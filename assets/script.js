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
                        const hash = $(location).attr('hash');
                        let selected = ""
                        if (hash === d){
                            selected = "selected"
                        }
                        select.append( '<option ' + selected + ' value="'+d+'">'+d+'</option>' )
                    } );

                } );
            }
        } );

        $(function() {

            let minimized_elements = $('.minimize');

            minimized_elements.each(function() {
                let tizer_length = 200;
                let t = '<div class="tizer">' + $(this).text().slice(0, tizer_length) + '<span>... </span><a href="#" class="more">Далее</a></div>';
                let h = '<div style="display:none;">' + $(this).html() + ' <a href="#" class="less">Свернуть</a></div>';
                
                if (t.length < tizer_length) return;

                $(this).html(t + h);

            });

            $('a.more', minimized_elements).click(function(event) {
                event.preventDefault();
                $(this).parent().hide();
                $(this).parent().next().show();
            });

            $('a.less', minimized_elements).click(function(event) {
                event.preventDefault();
                $(this).parent().hide().prev().show().prev().show();
            });

        });

    } );


});