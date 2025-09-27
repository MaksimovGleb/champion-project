<?php

namespace App\Services\Tournament;

use App\Models\Champion;
use App\Models\Judge;
use App\Models\Tournament;
use App\Services\Champion\ChampionService;
use Illuminate\Support\Collection;

class TournamentService
{
    public function createTournament(): Tournament
    {
        [$grid, $participants] = $this->generateGridAndParticipants(app(ChampionService::class));

        $judges = Judge::all()->map(fn($judge) => [
            'id'         => $judge->id,
            'position'   => $judge->position,
            'name'       => $judge->name,
            'surname'    => $judge->surname,
            'patronymic' => $judge->patronymic,
            'country'    => $judge->country,
            'city'       => $judge->city,
            'category'   => $judge->category,
        ])->values();

        return Tournament::create([
            'title'        => 'Турнир от ' . now()->format('d.m.Y H:i'),
            'participants' => $participants,
            'grid'         => $grid,
            'judges'       => $judges,
        ]);
    }

    private function getParticipantsForCategory($category, $weightMin, $weightMax)
    {
        return Champion::whereBetween('weight', [$weightMin, $weightMax])
            ->whereRaw('TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN ? AND ?', $category['age'])
            ->get();
    }

    private function generateFakeParticipantsForGroup(Collection $groupParticipants, Collection $allParticipants): array
    {
        $groupParticipants = $groupParticipants->map(function ($participant) {
            return [
                'id'    => $participant['id'] ?? $participant->id,
                'coach' => $participant['coach'] ?? $participant->coach ?? null,
            ];
        });

        // Проверяем количество участников в группе
        $currentCount = $groupParticipants->count();

        $nextPow = 1;
        while ($nextPow < $currentCount) {
            $nextPow *= 2;
        }
        $missing = $nextPow - $currentCount;

        for ($i = 0; $i < $missing; $i++) {
            // Генерация уникального ID для фейкового участника
            $fakeId = 'fake_' . ($allParticipants->count() + 1); // Нумерация фейков

            // Создаем фейкового участника как ассоциативный массив
            $fake = [
                'id'         => $fakeId,
                'surname'    => 'Пустышка',
                'name'       => '—',
                'coach'      => '—',
                'category'   => '—',
                'birth_date' => null,
                'weight'     => null,
            ];

            // Добавляем фейкового участника в общий список участников
            $allParticipants->push($fake); // Используем push для добавления фейкового участника

            // Добавляем фейкового участника в группу
            $groupParticipants->push([
                'id'    => $fakeId,   // ID фейкового участника
                'coach' => null,      // Дополнительные данные
            ]);
        }

        return [$groupParticipants, $allParticipants];
    }

    /**
     * Пересчитывает победителя матча по правилам:
     * - если один из бойцов фейковый (fake_), побеждает другой;
     *  - если один из бойцов отсутствует (null), побеждает другой (если $autoWinOnMissing = true);
     * - иначе исход ещё неизвестен.
     */
    public function recalculateWinner(array &$match, bool $autoWinOnMissing = true): void
    {
        $a = $match['p1'] ?? null;
        $b = $match['p2'] ?? null;

        $winner = null;

        // при наличии фейка побеждает реальный
        if ($a && str_starts_with($a, 'fake_')) {
            $winner = $b;
        } elseif ($b && str_starts_with($b, 'fake_')) {
            $winner = $a;
        }

        // при отсутствии одного из бойцов
        if ($autoWinOnMissing && !$winner) {
            if (!$a && $b) {
                $winner = $b;
            } elseif (!$b && $a) {
                $winner = $a;
            }
        }

        $match['winner'] = $winner;
    }

    /**
     * Генерация всех раундов, начиная с первого (с перемешиванием и фейками)
     */
    private function generateRounds(Collection $groupParticipants): array
    {
        $rounds = [];

        // Первый раунд
        $participants = $groupParticipants->shuffle()->values();
        $matches = [];

        while ($participants->count() >= 2) {
            $a = $participants->shift();
            $idx = $participants->search(fn($b) => $b['coach'] !== $a['coach']);
            $b = $idx === false ? $participants->shift() : $participants->pull($idx);

            $match = [
                'p1' => $a['id'],
                'p2' => $b['id'],
                'winner' => null
            ];
            $this->recalculateWinner($match);
            $matches[] = $match;
        }

        if ($participants->count() === 1) {
            $solo = $participants->shift();
            $match = [
                'p1'     => $solo['id'],
                'p2'     => null,
                'winner' => null,
            ];

            $this->recalculateWinner($match);
            $matches[] = $match;
        }

        $rounds['Раунд 1'] = $matches;

        // Добавляем остальные раунды
        $nextRounds = $this->generateNextRoundsFromFirst($matches);

        return array_merge($rounds, $nextRounds);
    }

    /**
     * Перегенерация раундов после Раунда 1 (например, после замены участника)
     */
    public function generateNextRoundsFromFirst(array $round1): array
    {
        $rounds = [];
        $prevMatches = $round1;
        $roundNum = 2;

        while (count($prevMatches) > 1) {
            $nextMatches = [];

            for ($i = 0; $i < count($prevMatches); $i += 2) {
                $match = [
                    'p1' => $prevMatches[$i]['winner'] ?? null,
                    'p2' => $prevMatches[$i+1]['winner'] ?? null,
                    'winner' => null
                ];
                $this->recalculateWinner($match, false);
                $nextMatches[] = $match;
            }

            $rounds["Раунд {$roundNum}"] = $nextMatches;
            $prevMatches = $nextMatches;
            $roundNum++;
        }

        return $rounds;
    }

    public function generateGridAndParticipants(ChampionService $championService): array
    {
        $grid = [];
        $allParticipants = collect();

        foreach ($championService->ageCategories() as $category) {
            $grid[$category['title']] = [];

            foreach ($category['weights'] as $weightsKey => $weightMax) {
                $weightMin = $weightsKey === 0 ? 0 : $category['weights'][$weightsKey - 1] + 0.1;

                $champions = $this->getParticipantsForCategory($category, $weightMin, $weightMax);
                if ($champions->isEmpty()) {
                    continue;
                }

                // Сохраняем участников
                $participants = $champions->mapWithKeys(fn($champ) => [
                    $champ->id => [
                        'id'         => $champ->id,
                        'surname'    => $champ->surname,
                        'name'       => $champ->name,
                        'coach'      => $champ->coach,
                        'category'   => $champ->category,
                        'birth_date' => $champ->birth_date,
                        'weight'     => $champ->weight,
                    ],
                ]);
                $allParticipants = $allParticipants->merge($participants);

                // Перемешиваем участников
                $group = $champions->shuffle()->values();

                // Добавляем фейков
                [$group, $allParticipants] = $this->generateFakeParticipantsForGroup($group, $allParticipants);

                // Генерируем раунды
                $rounds = $this->generateRounds($group);

                // Добавляем в весовую категорию
                $grid[$category['title']]["Весовая категория до {$weightMax} кг"] = $rounds;
            }
        }

        return [$grid, $allParticipants];
    }
}
