<div class="card">
    <div class="card-header">
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
                    <th style="">Турнир</th>
                    <th style="" class="text-center">Дата создания</th>
                    <th style="width: 15%">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $tournaments as $tournament)
                    <tr>
                        <td style="width: 1%">{{ $tournament->id }}</td>
                        <td style="">
                            <a href="{{ route('tournaments.show', $tournament->id) }}">{{ $tournament->title }}</a>
                        </td>
                        <td>{{  $tournament->created_at }} </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center flex-wrap">
                                <a href="{{ route('tournament.export.pdf', $tournament->id) }}" class="btn btn-outline-info mb-2 mx-1" title="Скачать PDF">
                                    <i class="fas fa-file-pdf"></i>
                                </a>

                                <a href="{{ route('tournaments.edit', $tournament->id) }}" class="btn btn-primary mb-2 mx-1" title="Редактировать">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{ Form::open(['url' => route('tournaments.destroy', $tournament->id), 'style' => "display: inline-block", 'class' => 'mb-2 mx-1']) }}
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit" onclick="return confirm('Вы уверены?')" title="Удалить">
                                    <i class="fas fa-trash"></i>
                                </button>
                                {{ Form::close() }}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $tournaments->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>
