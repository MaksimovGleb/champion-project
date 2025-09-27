@foreach($tournament->grid as $ageKey => $category)
    <h2>{{ $ageKey }}</h2>

    @foreach($category as $weightsKey => $weightCategory)
        @php
            $usedParticipantIds = collect($weightCategory['Раунд 1'])
                ->flatMap(fn($match) => [$match['p1'], $match['p2']])
                ->unique()
                ->filter();

            $usedParticipants = collect($tournament->participants)
                ->filter(fn($p) => $usedParticipantIds->contains((string)$p['id']))
                ->sortBy(fn($p) => mb_strtolower($p['surname'])); // Сортировка по фамилии
        @endphp

        <div class="card mb-4">
            <div class="card-header">
                <h3 class="card-title">{{ $weightsKey }}</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body p-3 table-responsive">
                <tournament-edit-table
                    :tournament-id="{{ $tournament->id }}"
                    :groups='@json($weightCategory)'
                    :participants-arr='@json($usedParticipants->values())'
                    :age-category="'{{ $ageKey }}'"
                    :weight-class="'{{ $weightsKey }}'"
                ></tournament-edit-table>
            </div>
        </div>
    @endforeach
@endforeach

<a href="{{ route('tournaments.show', $tournament) }}" class="btn btn-primary mt-3">Сохранить и перейти к просмотру</a>
