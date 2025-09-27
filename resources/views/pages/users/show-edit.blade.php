@extends('layouts.admin-lte')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css"
          integrity="sha256-5veQuRbWaECuYxwap/IOE/DAwNxgm4ikX7nrgsqYp88=" crossorigin="anonymous">
@endpush

@section('sidebar')
    @include('pages.partials.sidebar')
@endsection

@section('menu')
    @include('pages.partials.content-header')
@endsection

@section('content')


        <?php $active = (old('tabNumber') ?? Session::get('tabNumber') ?? 'personal-tab') ?>

            <div class="card">
                <div class="card-header d-flex p-0">
                    <h3 class="card-title p-3">Личная информация</h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        <li class="nav-item ml-auto mr-auto">
                            <a class="nav-link @if($active == "personal-tab") active @endif" data-toggle="pill"
                               href="#personal-tab">
                                Профиль
                            </a>
                        </li>
                        @can('changePassword', $user)
                            <li class="nav-item ml-auto mr-auto">
                                <a class="nav-link @if($active == "pass-tab") active @endif" data-toggle="pill"
                                    href="#pass-tab">
                                    Изменить пароль
                                </a>
                            </li>
                        @endcan
                        <div class="card-tools">
                            <div class="form-group row">
                                <div class="col-12">

                                </div>
                            </div>
                        </div>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane @if($active == "personal-tab") active show @endif" id="personal-tab">
                            @include('pages.users.partials.personal-info')
                        </div>
                        @can('changePassword', $user)
                            <div class="tab-pane @if($active == "pass-tab") active show @endif" id="pass-tab">
                                @include('pages.users.partials.pass-change')
                            </div>
                        @endcan
                    </div>
                </div>
            </div>


    @can('update', $user)
            <?php $readOnly = false ?>
    @else
            <?php $readOnly = true ?>
    @endcan

@endsection

@section('footer')
    @include('pages.partials.footer')
@endsection

@push('custom-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"
            integrity="sha512-6Jym48dWwVjfmvB0Hu3/4jn4TODd6uvkxdi9GNbBHwZ4nGcRxJUCaTkL3pVY6XUQABqFo3T58EMXFQztbjvAFQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{--    <script src="https://cdn.tiny.cloud/1/wrd21kidqtxlp87pw6ylnr5mnhuzxlexyflwo4syioxc2amt/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>--}}

    <script type="text/javascript">
        $(document).ready(function () {
            $('[data-redirect]').dblclick(function () {
                document.location = $(this).data('redirect');
            });
            $('.select2').select2();

            $('.select2.taggable').select2({
                tags: true
            });
        });

        $.fn.dataTable.moment('DD.MM.YYYY HH:mm:ss');
        $('.sortable').DataTable({
            "paging": false, // переключение страниц
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "order": [[0, 'desc']],
            "info": false,//количество записей
            "autoWidth": false,
            "responsive": true,
            "language": {
                "emptyTable": "таблица пуста"
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            // tinymce.init({
            //     selector: '.tinymce',
            //     theme: 'silver',
            //     branding: false,
            //     plugins: "paste",
            //     paste_as_text: true,
            // });

            FilePond.registerPlugin(FilePondPluginFileValidateSize);

            const input = document.querySelector('input[id="attachments"]');
            const pond = FilePond.create(input);

            var filesFromOldRequest = '';
            var files = [];

            if (filesFromOldRequest.length)
                files = filesFromOldRequest;

            FilePond.setOptions({
                chunkUploads: true,
                chunkSize: {{ config('filepond.chunk_size') }},
                maxFileSize: {{ config('media-library.max_file_size') }},
                labelMaxFileSizeExceeded: 'Максимальный размер файла - {{ config('media-library.max_file_size')/1024/1024 }} MB',
                labelIdle: 'Перетащите файлы или <span class="filepond--label-action"> откройте</span> их',
                labelFileProcessingComplete: 'Файл прикреплён',
                labelFileProcessing: 'Загрузка',
                labelTapToUndo: '',
                labelTapToCancel: '',
                files: files,
                server: {
                    url: '/filepond/api',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                },
                onprocessFile: () => console.log('file'),
                onprocessFiles: () => console.log('files'),
            });

            document.addEventListener('FilePond:processfiles', e => {
                $('.filepond-btn').attr('disabled', false);
            });

            document.addEventListener('FilePond:addfilestart', e => {
                $('.filepond-btn').attr('disabled', true);
            });

            $("#inputPhone").inputmask("+9-999-999-99-99");

            if({!! json_encode($readOnly) !!})
                $("#inputRegion").prop('disabled', 'disabled');
            else
                $("#inputRegion").removeAttr('disabled');
        });
    </script>

    <script>
        $(document).ready(function () {
            var oldErrors = {!! json_encode($errors->toArray()) !!};

            if (oldErrors["password"]) {
                toastr.error(oldErrors["password"][0],
                    {
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: true,
                        closeButton: true,
                        showMethod: 'slideDown',
                        hideMethod: 'slideUp',
                        showDuration: "400",
                        timer: 5000
                    }
                );
            }

            if (oldErrors["password_confirmation"]) {
                toastr.error(oldErrors["password_confirmation"][0],
                    {
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: true,
                        closeButton: true,
                        showMethod: 'slideDown',
                        hideMethod: 'slideUp',
                        showDuration: "400",
                        timer: 5000
                    }
                );
            }
        });
    </script>

    <script>
        function clear(profileNumber = 0) {
            var form = document.getElementById(`user_settings${profileNumber}`);
            if (form)
                form.innerHTML = "";
        }

        function buildLabelTag(caption, classAttribute = null) {
            var label = document.createElement("LABEL");
            if (classAttribute)
                label.setAttribute("class", classAttribute);
            label.innerText = caption;
            return label;
        }

        function buildInputTag(name, className = "", placeholder = "", value = "", type = "text", id = "") {
            var input = document.createElement("input");
            input.type = type;
            input.name = name;
            input.className = className;
            input.placeholder = placeholder;
            input.id = id;

            if (type === 'date') {// Инициализация Flatpickr
                flatpickr(input, {
                    enableTime: false,
                    dateFormat: 'Y-m-d',
                    allowInput: true,
                    locale: 'ru',
                });

                input.addEventListener('input', function () {// Добавляем обработчик события для преобразования формата при вводе
                    var parsedDate = moment(this.value, ['YYYY-MM-DD', 'DD.MM.YYYY', 'DD-MM-YYYY'], true);
                    if (parsedDate.isValid()) {
                        this.value = parsedDate.format('YYYY-MM-DD');
                    }
                });
            }
            input.value = value;
            if ({!! json_encode($readOnly) !!})
                input.setAttribute("readonly", 'readonly');

            return input;
        }

        function buildError(text) {
            var error = document.createElement("div");
            error.setAttribute("class", "alert alert-danger");
            error.innerText = text;
            return error;
        }

        function buildInputWithLabel(name, caption, placeholder = "", value = "", errors = [], id = "", type = "") {
            var formGroup = document.createElement("div");
            formGroup.setAttribute("class", "form-group row");

            // create label
            var label = buildLabelTag(caption, "col-md-3 col-form-label")
            formGroup.append(label);

            // create wrapping div for input
            var div = document.createElement("div");
            div.setAttribute("class", "col-md-9");

            // create input into wrapped div
            var input = buildInputTag(name, "form-control", placeholder, value, type ?? "text", id);
            div.append(input);

            if (errors.length) {
                var errorText = errors[0];
                var br = document.createElement("br");
                div.append(br);
                var error = buildError(errorText);
                div.append(error);
            }
            formGroup.append(div);
            return formGroup;
        }

        function buildHiddenInput(name, value, id = "") {
            var input = document.createElement("input");
            input.setAttribute("type", "hidden");
            input.setAttribute("value", value);
            input.setAttribute("name", name);
            if (id)
                input.setAttribute("id", id);
            return input;
        }

    </script>
    <script src="{{ mix('/client/js/auth.js') }}"></script>
@endpush
