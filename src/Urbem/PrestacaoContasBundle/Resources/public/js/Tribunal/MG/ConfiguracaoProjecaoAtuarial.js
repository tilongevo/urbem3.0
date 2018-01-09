$(document).ready(function() {
    function money() {
        $(document).on('click', '.money', function () {
            $(this).mask('#.##0,00', {reverse: true});
            if ($(this).val() == '') {
                $(this).val('0,00');
            }
            if ($(this).val().indexOf(',') < 0) {
                $(this).val($(this).val() + ',00');
            }
        });
    }

    var entidade = $("select#" + UrbemSonata.uniqId + "_entidade");

    $(':input[type=submit]').prop('disabled', true);

    entidade.change(function() {
        if ($(this).val()) {
            $(':input[type=submit]').prop('disabled', false);
            buscaParametros();
        } else {
            $(':input[type=submit]').prop('disabled', true);
        }
    });

     //ObjectModal
    var modal = $.urbemModal();

    //* Table principal com item a ser manipulados*/
    function renderTableList(data, listClassToColumns) {
        var tableName = "tableListRPPS";

        var table = $("#"+tableName).DataTable();

        table.destroy();
        var table = $("#"+tableName).DataTable( {
            data:           data,
            deferRender:    true,
            scrollY:        400,
            pageLength:     50,
            ordering:       false,
            scrollCollapse: true,
            scroller:       false,
            searching:      false,
            paging:         false,
            autoWidth:      false,
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Portuguese-Brasil.json"
            },
            drawCallback: function () { // this gets rid of duplicate headers
                $('.dataTables_scrollBody thead tr').css({ display: 'none' });

                UrbemSonata.DataTablesSetDimensionToHeaderAndBodyCell(tableName, listClassToColumns);
                money();
            },
            initComplete: function( settings, json ) {
                modal.close();
                $('.dataTables_scrollBody thead tr').css({ display: 'none' });
            },
            columnDefs: [{
                'targets': 1,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var exercicio = full[0];
                    var vlPatronal = UrbemSonata.convertFloatToMoney(full[1]);

                    var $input = $("<div class='input-group'><span class='input-group-addon'>R$</span><input type='text' class='money campo-sonata form-control' value='"+vlPatronal+"' name='projecoes["+exercicio+"][vlPatronal]'></div>");

                    return $input.prop("outerHTML");
                }
            },{
                'targets': 2,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var exercicio = full[0];
                    var vlReceita = UrbemSonata.convertFloatToMoney(full[2]);

                    var $input = $("<div class='input-group'><span class='input-group-addon'>R$</span><input type='text' class='money campo-sonata form-control' value='"+vlReceita+"' name='projecoes["+exercicio+"][vlReceita]'></div>");

                    return $input.prop("outerHTML");
                }
            },{
                'targets': 3,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var exercicio = full[0];
                    var vlDespesa = UrbemSonata.convertFloatToMoney(full[3]);

                    var $input = $("<div class='input-group'><span class='input-group-addon'>R$</span><input type='text' class='money campo-sonata form-control' value='"+vlDespesa+"' name='projecoes["+exercicio+"][vlDespesa]'></div>");

                    return $input.prop("outerHTML");
                }
            },{
                'targets': 4,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var exercicio = full[0];
                    var vlRpps = UrbemSonata.convertFloatToMoney(full[4]);

                    var $input = $("<div class='input-group'><span class='input-group-addon'>R$</span><input type='text' class='money campo-sonata form-control' value='"+vlRpps+"' name='projecoes["+exercicio+"][vlRpps]'></div>");

                    return $input.prop("outerHTML");
                }
            },
            { className: "white-space-unset vertical-align-unset", "targets": [ 0,1,2,3,4 ] }
            ]
        });
    }

    function buscaParametros() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        $.post(UrlServiceProviderTCE, $("form").serializeArray())
            .success(function (data) {
                    if (data.response == true) {
                        var projecoes = data.projecoes;

                        var data = [];

                        if (projecoes) {
                            for (var i in projecoes) {
                                data.push(
                                    [
                                        i,
                                        projecoes[i].vlPatronal,
                                        projecoes[i].vlReceita,
                                        projecoes[i].vlDespesa,
                                        projecoes[i].vlRpps
                                    ]
                                );
                            }
                        }

                        var listClassToColumns = [
                            "dt-cell-2",
                            "dt-cell-2",
                            "dt-cell-2",
                            "dt-cell-2",
                            "dt-cell-2"
                        ];

                        renderTableList(data, listClassToColumns);
                    }
                }
            );
    }
}());