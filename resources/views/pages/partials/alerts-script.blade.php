<script>
    $(document).ready(function() {
        {{-- ->with('success', 'Сообщение успешно добавлено!'); --}}

        @if (Session::has('success'))
        toastr.success("{{ Session::get('success') }}", "Успешно!",
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
        @endif

        @if (Session::has('error'))
        toastr.error("{{ Session::get('error') }}", "Ошибка!",
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
        @endif

        @if (Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}", "Внимание!",
            {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        );
        @endif

        @if (Session::has('info'))
        toastr.info("{{ Session::get('info') }}", "Внимание!",
            {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        );
        @endif
    });
</script>

