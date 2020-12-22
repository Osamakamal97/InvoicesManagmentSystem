$(function(e) {
    //file export datatable
    var table = $('#example').DataTable({
        lengthChange: false,
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ ',
            url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Arabic.json'
        }
    });
    table.buttons().container()
        .appendTo('#example_wrapper .col-md-6:eq(0)');

    $('#example1').DataTable({
        language: {
            searchPlaceholder: 'ابحث...',
            sSearch: '',
            lengthMenu: '_MENU_',
            url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Arabic.json'
        }
    });
    $('#example2').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'ابحث...',
            sSearch: '',
            lengthMenu: '_MENU_',
            url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Arabic.json'
        }
    });
    var table = $('#example-delete').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
            url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Arabic.json'
        }
    });
    $('#example-delete tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });

    $('#button').click(function() {
        table.row('.selected').remove().draw(false);
    });

    //Details display datatable
    $('#example-1').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_',
            url: '//cdn.datatables.net/plug-ins/1.10.22/i18n/Arabic.json'
        },
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal({
                    header: function(row) {
                        var data = row.data();
                        return 'Details for ' + data[0] + ' ' + data[1];
                    }
                }),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                    tableClass: 'table border mb-0'
                })
            }
        }
    });
});