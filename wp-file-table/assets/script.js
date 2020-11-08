jQuery(function($) {
    // $.noConflict(true);
    $(document).ready(function() {
        $('#file-table').DataTable( {
            "columnDefs": [
                {
                    "targets": [ 2 ],
                    "visible": false,
                },
                { "width": "5%", "targets": 0 },
                {
                    // The `data` parameter refers to the data for the cell (defined by the
                    // `data` option, which defaults to the column being worked with, in
                    // this case `data: 0`.
                    "render": function ( data, type, row ) {
                        return row[0] + ' ' + data;
                    },
                    "targets": 1
                },
                { "visible": false,  "targets": [ 0 ] }
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
    } );
});