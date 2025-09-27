<div class="card">
    <div class="card-header">
        <a href="{{ route('judges.deleteAll') }}" class="btn btn-danger btn-sm">Очистить таблицу</a>
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
                    <th>Должность</th>
                    <th>Страна / Город</th>
                    <th>Категория</th>
                    <th style="" class="text-center">Дата регистрации</th>
                    <th style="width: 10%">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $judges as $judge)
                    <tr>
                        <td style="width: 1%">{{ $judge->id }}</td>
                        <td style="">
                            <a href="{{ route('judges.edit', $judge->id) }}">{{ $judge->FullName }}</a>
                        </td>
                        <td>{{  $judge->position }} </td>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">{{ $judge->country }}, {{ $judge->city }}</li>
                            </ul>
                        </td>
                        <td>{{  $judge->category }} </td>
                        <td class="text-center">
                            {{  $judge->createdAtForHumans() }}
                        </td>
                        <td class="text-center">
                            <a href="{{ route('judges.edit', $judge) }}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                            {{ Form::open(['url' => route('judges.destroy', $judge->id), 'style' => "display: inline-block", ]) }}
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
        {{ $judges->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>
