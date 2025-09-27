<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Tournament;
use App\Services\Tournament\TournamentService;
use Auth;
use Illuminate\Http\Request;

class TournamentsController extends Controller
{
    public function exportPdf(Tournament $tournament)
    {
        if (Auth::user()->isAdmin(true)) {

            $pdf = Pdf::loadView('pdf.tournament', compact('tournament'))
                ->setPaper('a4', 'landscape');

            return $pdf->download("Турнир-{$tournament->id}.pdf");
        }

        return to_route('champions.index')->with('error', 'нет права!');
    }

    public function index()
    {
        if (Auth::user()->isAdmin(true)) {
            $title = 'Все отсортированные таблицы соревнований';

            $tournaments = Tournament::all();

            $tournamentsCount = count($tournaments);
            $tournaments = $tournaments->sortByDesc('id')->paginate(20)->appends(request()->query());

            $data=[
                'title' => $title,
                'tournaments' => $tournaments,
                'tournamentsCount' => $tournamentsCount,
            ];
            return view('pages.tournaments.admin.index', $data);
        }

        return to_route('champions.index')->with('error', 'нет права!');
    }

    public function store(TournamentService $tournamentService)
    {
        if (Auth::user()->isAdmin(true)) {

            $tournament = $tournamentService->createTournament();

            return to_route('tournaments.edit', ['tournament' => $tournament->id]);

        }

        return to_route('champions.index')->with('error', 'нет права!');
    }

    public function show(Tournament $tournament)
    {
        if (Auth::user()->isAdmin(true)) {
            $tournament = Tournament::with([ ])->find($tournament->id);

            return view('pages.tournaments.admin.show', [
                'tournament' => $tournament,
                'title' => $tournament->title,
                'checked' => true,
            ]);
        }

        return to_route('champions.index')->with('error', 'нет права!');
    }

    public function edit(Tournament $tournament)
    {
        if (Auth::user()->isAdmin(true)) {
            return view('pages.tournaments.admin.edit', [
                'tournament' => $tournament,
                'title' => 'Проверка и редактирование ' . $tournament->title,
            ]);
        }

        return to_route('champions.index')->with('error', 'нет права!');
    }

    public function change(Request $request, Tournament $tournament, TournamentService $tournamentService)
    {
        if (!Auth::user()->isAdmin(true)) {
            return response()->json(['message' => 'Нет прав'], 403);
        }

        $data = $request->validate([
            'ageCategory' => 'required|string',
            'weightClass' => 'required|string',
            'matchIndex'  => 'required|integer',
            'side'        => 'required|in:p1,p2',
            'newId'       => 'required',
        ]);

        // 3) Извлекаем текущую сетку и первый раунд
        $grid = $tournament->grid;
        $weightCategoryData = $grid[$data['ageCategory']][$data['weightClass']];
        $round1 = $weightCategoryData['Раунд 1'];

        // 4) Меняем местами
        $oldId = $round1[$data['matchIndex']][$data['side']];
        foreach ($round1 as $i => $match) {
            foreach (['p1', 'p2'] as $key) {
                if ($match[$key] == $data['newId']) {
                    // оба обмена в одном месте
                    $round1[$i][$key] = $oldId;
                    $round1[$data['matchIndex']][$data['side']] = $data['newId'];
                    // пересчёт победителей в двух матчах
                    $tournamentService->recalculateWinner($round1[$i]);
                    $tournamentService->recalculateWinner($round1[$data['matchIndex']]);
                    break 2;
                }
            }
        }

        // 5) Перестройка всех следующих раундов
        $nextRounds = $tournamentService->generateNextRoundsFromFirst($round1);

        // 6) Собираем финальную категорию и сохраняем
        $weightCategoryData = array_merge(['Раунд 1' => $round1], $nextRounds);
        $grid[$data['ageCategory']][$data['weightClass']] = $weightCategoryData;

        $tournament->grid = $grid;
        $tournament->save();

        // 7) Возвращаем обновлённый Раунд 1
        return response()->json([
            'message' => 'Обмен завершён',
            'weightCategory' => $round1,
        ]);
    }

    public function update(Request $request, Tournament $tournament)
    {
        if (Auth::user()->isAdmin(true)) {

            // Валидируем: ожидаем, что придёт массив под ключом grid
            $data = $request->validate([
                'ageCategory' => 'required|string',
                'weightClass' => 'required|string',
                'grid' => 'required|array',
            ]);

            $grid = $tournament->grid;
            $grid[$data['ageCategory']][$data['weightClass']] = $data['grid'];
            $tournament->grid = $grid;
            $tournament->save();

            return response()->json([
                'message' => 'Grid успешно сохранён',
                'grid'    => $tournament->grid,
            ], 200);
        }
        return response()->json(['message' => 'Нет прав'], 403);
    }

    public function destroy(Tournament $tournament)
    {
        if (Auth::user()->isAdmin(true)) {
            try {
                $tournament->delete();
                return to_route('tournaments.index')
                    ->with('success', 'Участник удалён!');
            }
            catch (\Exception $exception)
            {
                return to_route('champions.index')
                    ->with('errors', 'Участник не может быть удалён');
            }
        }
        return redirect()->back()->with('error', 'нет права!');
    }
}
