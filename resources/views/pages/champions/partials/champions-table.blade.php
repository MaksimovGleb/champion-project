<div class="card">
    <div class="card-header">
        <a href="{{ route('champions.deleteAll') }}" class="btn btn-danger btn-sm">Очистить таблицу</a>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>

    <div class="card-body p-0 table-responsive">
        <table class="table table-striped projects tasks-table sortable">
            <thead>
                <tr>
                    <th style="width: 1%">#</th>
                    <th style="">ФИО</th>
                    <th>Тренер</th>
                    <th>Разряд</th>
                    <th>Вес</th>
                    <th>Дата рождения (возраст)</th>
                    <th style="" class="text-center">Дата регистрации</th>
                    <th style="width: 10%">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $champions as $champion)
                    <tr>
                        <td style="width: 1%">{{ $champion->id }}</td>
                        <td style="">
                            <a href="{{ route('champions.edit', $champion->id) }}">{{ $champion->FullName }}</a>
                        </td>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">{{ $champion->coach }}</li>
                            </ul>
                        </td>
                        <td>{{  $champion->category }} </td>
                        <td>{{  $champion->weight }} </td>
                        <td>{{ $champion->birth_date ? \Carbon\Carbon::parse($champion->birth_date)->format('d.m.Y') : '' }} @if($champion->age) ({{ $champion->age }}) @endif</td>
                        <td class="text-center">
                            {{  $champion->createdAtForHumans() }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('champions.edit', $champion) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                            {{ Form::open(['url' => route('champions.destroy', $champion->id), 'style' => "display: inline-block", ]) }}
                            @csrf
                            @method('DELETE')
                                <button class="btn btn-danger" type="submit" onclick="return confirm('Вы уверены?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $champions->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>
