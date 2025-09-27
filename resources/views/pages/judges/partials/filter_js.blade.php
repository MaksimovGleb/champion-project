<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"
        integrity="sha512-6Jym48dWwVjfmvB0Hu3/4jn4TODd6uvkxdi9GNbBHwZ4nGcRxJUCaTkL3pVY6XUQABqFo3T58EMXFQztbjvAFQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function () {
        $('[data-redirect]').dblclick(function () {
            document.location = $(this).data('redirect');
        });
        $('.select2').select2({
            tags: false,
        });

        $('.select2.taggable').select2({
            tags: true,
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
    });
</script>
