jQuery(function($) {
    $(document).ready(function() {

        let table = $('#file-table').DataTable( {
            "columnDefs": [
                {
                    "targets": [ 2 ],
                    "visible": false,
                },
                {
                    "targets": [ 4 ],
                    "visible": false,
                },
                {
                    "width": "5%", "targets": 0 },
                {
                    "render": function ( data, type, row ) {
                        return row[0] + ' ' + data;
                    },
                    "targets": 1
                },
                {
                    "visible": false,  "targets": [ 0 ] }
            ],
            "drawCallback": function( settings ) {
                $("#file-table thead").remove(); } ,
            "bInfo" : false,
            "ordering": false,
            "lengthChange": false,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Russian.json"
            },
            initComplete: function () {
                this.api().column(2).every( function () {
                    var column = this;
                    $("#file-table_filter").append("<br />")
                    var select = $('<select><option value="">Выберите категорию</option></select>')
                        .insertBefore( $("#file-table"))
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );
                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );

                } );
            }
        } );

        function format ( d ) {
            // `d` is the original data object for the row
            return '<div>' + d[4] + '</div>';
        }

        // Add event listener for opening and closing details
        $('#file-table tbody').on('click', 'a.description-control', function (e) {
            e.preventDefault()
            let tr = $(this).closest('tr');
            let row = table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
                $(this).html('Показать описание')
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
                $(this).html('Скрыть описание')
            }
        } );
    } );


});