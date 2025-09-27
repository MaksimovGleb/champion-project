<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{{ $tournament->title }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 1rem;
        }

        h1 {
            font-size: 120%;
            margin: 0.5rem 0;
        }

        h2, h3 {
            font-size: 100%;
            margin: 0.5rem 0;
        }

        table {
            border-collapse: collapse;
            font-size: 9px;
            width: 100%;
            margin-bottom: 1.5rem;
            table-layout: fixed;
            text-align: center; /* центрируем общий текст */
        }

        table th, table td {
            padding: 2px;
            text-align: center; /* центрируем содержимое */
        }

        table.judges-table th,
        table.judges-table td,
        table.weighing-table th,
        table.weighing-table td,
        table.summary-table th,
        table.summary-table td {
            border: 1px solid #333;
        }

        /* Стили для турнирных сеток */
        table.bracket-table {
            width: 100% !important;
            /* позволяем немного выходить за пределы, если нужно */
            max-width: calc(100% + 40px) !important;
            margin: 0 auto 1.5rem;
            font-size: 14px;
            table-layout: fixed;
            text-align: center;
        }

        table.bracket-table th {
            padding: 8px 12px;
            text-align: center;
            font-weight: bold;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
        }

        table.bracket-table td {
            padding: 8px 12px;
            vertical-align: middle;
            text-align: center;
        }

        .match {
            border: 1px solid #333;
            border-radius: 4px;
            padding: 6px 8px;
            margin: 4px 0;
            word-wrap: break-word;
            text-align: center;
        }

        .winner {
            background-color: #2ecc71;
            color: white;
            font-weight: bold;
        }

        .loser {
            background-color: #f9f9f9;
        }

        .coach {
            font-size: 10px;
            color: #555;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <h1>{{ $tournament->title }}</h1>

    <h3>Судьи</h3>
    <table class="judges-table">
        <thead>
        <tr>
            <th>ФИО</th>
            <th>Должность</th>
            <th>Страна</th>
            <th>Город</th>
            <th>Категория</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tournament->judges as $judge)
            <tr>
                <td>{{ $judge['surname'] }} {{ $judge['name'] }} {{ $judge['patronymic'] ?? '' }}</td>
                <td>{{ $judge['position'] }}</td>
                <td>{{ $judge['country'] }}</td>
                <td>{{ $judge['city'] }}</td>
                <td>{{ $judge['category'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @php
        // 1) Участники: все и только реальные
        $allParticipants = collect($tournament->participants)->keyBy('id');
        $realParticipants = $allParticipants->reject(fn($_, $id) => str_starts_with((string)$id, 'fake_'));

        // Собираем отчёт: взвешивание, итоги и сетки
        $report = [];
        foreach ($tournament->grid as $ageKey => $category) {
            foreach ($category as $weightsKey => $weightCategory) {
                // Раунды
                $rounds = collect($weightCategory)
                    ->keys()
                    ->filter(fn($k) => str_starts_with($k, 'Раунд '))
                    ->sortBy(fn($k) => (int) str_replace('Раунд ', '', $k))
                    ->values();
                $roundCount = $rounds->count();

                // Взвешивание
                $weigh = collect($weightCategory)
                    ->filter(fn($_, $k) => str_starts_with($k, 'Раунд '))
                    ->flatMap(fn($matches) => $matches)
                    ->flatMap(fn($m) => [$m['p1'] ?? null, $m['p2'] ?? null])
                    ->filter(fn($id) => $realParticipants->has($id))
                    ->unique()
                    ->map(fn($id) => $realParticipants->get($id))
                    ->values();

                // Места
                $placeList = collect();
                // Финал
                $final = $weightCategory[$rounds->last()][0] ?? null;
                if ($final) {
                    [$w, $l] = [$final['winner'], ($final['p1'] === $final['winner'] ? $final['p2'] : $final['p1'])];
                    if ($realParticipants->has($w)) $placeList->push(['id'=>$w,'place'=>1]);
                    if ($realParticipants->has($l)) $placeList->push(['id'=>$l,'place'=>2]);
                }
                // Вылетевшие
                $el = [];
                foreach ($rounds as $i => $r) {
                    foreach ($weightCategory[$r] as $m) {
                        foreach (['p1','p2'] as $side) {
                            $id = $m[$side] ?? null;
                            if (!$id || !isset($m['winner']) || $m['winner'] === $id) continue;
                            if ($realParticipants->has($id)) {
                                $el[$id] = $i;
                            }
                        }
                    }
                }
                foreach ($el as $id => $ri) {
                    $pl = $roundCount - $ri + 1; // логично: финалисты → 2, полуфинал → 3, четверть → 4 и т.д.
                    $placeList->push(['id' => $id, 'place' => $pl]);
                }
                $places = $placeList
                    ->unique(fn($x) => $x['id'])
                    ->map(fn($e) => array_merge($realParticipants->get($e['id']), ['place'=>$e['place']]))
                    ->sortBy('place')
                    ->values();

                // Ограничиваем раунды последними тремя
                $filteredRounds = $rounds->slice(-3)->values();
                $filteredMatches = collect($weightCategory)
                    ->only($filteredRounds)
                    ->toArray();

                $report[$ageKey][$weightsKey] = [
                    'weigh'   => $weigh,
                    'places'  => $places,
                    'rounds'  => $filteredRounds,
                    'matches' => $filteredMatches,
                ];
            }
        }
    @endphp

    {{-- 3) Выводим сначала все протоколы взвешивания --}}
    <h1>Протокол взвешивания</h1>
    @foreach($report as $ageKey => $byWeight)
        <h2>{{ $ageKey }}</h2>
        @foreach($byWeight as $weightsKey => $data)
            <h3>{{ $weightsKey }}</h3>

            @if($data['weigh']->isEmpty())
                <p>Нет участников.</p>
            @else
                <table class="weighing-table">
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>ФИО</th>
                        <th>Тренер</th>
                        <th>Разряд</th>
                        <th>Дата рождения</th>
                        <th>Вес (кг)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['weigh'] as $i => $item)
                        <tr>
                            <td>{{ $i+1 }}</td>
                            <td>{{ $item['surname'].' '.$item['name'] }}</td>
                            <td>{{ $item['coach'] }}</td>
                            <td>{{ $item['category'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($item['birth_date'])->format('d.m.Y') }}</td>
                            <td>{{ number_format($item['weight'],2) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    @endforeach

    {{-- 4) А теперь — все краткие итоги --}}
    <h1>Краткий итог</h1>
    @foreach($report as $ageKey => $byWeight)
        <h2>{{ $ageKey }}</h2>
        @foreach($byWeight as $weightsKey => $data)
            <h3>{{ $weightsKey }}</h3>

            @if($data['places']->isEmpty())
                <p>Нет итогов.</p>
            @else
                <table class="summary-table">
                    <thead>
                    <tr>
                        <th>Место</th>
                        <th>Ф.И.О.</th>
                        <th>Дата рождения</th>
                        <th>Разряд</th>
                        <th>Тренер</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['places'] as $item)
                        <tr>
                            <td>{{ $item['place'] }}</td>
                            <td>{{ $item['surname'].' '.$item['name'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($item['birth_date'])->format('d.m.Y') }}</td>
                            <td>{{ $item['category'] }}</td>
                            <td>{{ $item['coach'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    @endforeach

    {{-- 5) Таблица сетки --}}
    <h1>Турнирные сетки</h1>
    @foreach($report as $ageKey => $byWeight)
        @foreach($byWeight as $weightsKey => $data)
            <div class="page-break"></div>
            <h2>{{ $ageKey }} - {{ $weightsKey }}</h2>
            @php
                $rounds = $data['rounds'];
                $matches = $data['matches'];

                $totalRows = count($matches[$rounds->first()])*2;
            @endphp

            <table class="bracket-table">
                <thead>
                <tr>
                    @foreach($rounds as $round)
                        <th style="width: {{ 100 / $rounds->count() }}%">{{ $round }}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                    @for ($row = 0; $row < $totalRows; $row++)
                        <tr>
                            @foreach($rounds as $roundIndex => $round)
                                @php
                                    $step = pow(2, $roundIndex);
                                    $matchIndex = intdiv($row, $step * 2);
                                    $isTop = ($row % ($step * 2)) === 0;
                                @endphp

                                @if(!$isTop)
                                    <td></td>
                                @else
                                    @php
                                        $match = $matches[$round][$matchIndex] ?? null;

                                        $p1= $allParticipants[$match['p1']] ?? null;
                                        $p2= $allParticipants[$match['p2']] ?? null;

                                        $isP1Winner= $match['p1']===($match['winner']??null) && $match['p1'];
                                        $isP2Winner= $match['p2']===($match['winner']??null) && $match['p2'];
                                    @endphp
                                    <td rowspan="{{ $step*2 }}">
                                        <div class="match">
                                            <div class="{{ $isP1Winner?'winner':'loser' }}">
                                                {{ $p1?"{$p1['surname']} {$p1['name']}": '—' }}
                                                <div class="coach">{{ $p1['coach']??'—' }}</div>
                                            </div>
                                            <div class="{{ $isP2Winner?'winner':'loser' }}">
                                                {{ $p2?"{$p2['surname']} {$p2['name']}": '—' }}
                                                <div class="coach">{{ $p2['coach'] ?? '—' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endfor
                </tbody>
            </table>

        @endforeach
    @endforeach

</body>
</html>
