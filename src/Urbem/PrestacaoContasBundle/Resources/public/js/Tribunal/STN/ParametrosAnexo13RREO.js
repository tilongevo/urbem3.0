$(document).ready(function() {

    var btnSubmit = $(':input[type=submit]');
    btnSubmit.remove();

    // ObjectModal
    var modal = $.urbemModal();

    var valores;

    var areaButton = $('<div class="form_row col s3 campo-sonata"></div>');
    var buttonIncluir = $('<label class="control-label ">&nbsp;</label><div class="sonata-ba-field "><button type="submit" class="white-text blue darken-4 btn btn-success save" name="btn_create_and_list"><i class="material-icons left">input</i>Incluir</button></div>');
    areaButton.append(buttonIncluir);
    $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_vlSaldoFinanceiro").after(areaButton);

    var entidadeSelect = $("#" + UrbemSonata.uniqId + "_entidade");
    entidadeSelect.on('change', function () {
        if ($(this).val()) {
            loadValores($(this).val());
        }
    });

    function renderTableListValores(data, listClassToColumns) {
        var tableName = "tableListValores";

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
                $(".delete").on('click', function () {
                    var key = $(this).attr('data-id-delete');
                    console.log(key);
                    modal.disableBackdrop()
                        .setTitle("Aguarde")
                        .setBody("Removendo Dado...")
                        .open();

                    var parameters = [];
                    parameters.push({name: "action", value:"Delete"});
                    parameters.push({name: "codEntidade", value: valores[key].codEntidade});
                    parameters.push({name: "exercicio", value: valores[key].exercicio});
                    parameters.push({name: "ano", value: valores[key].ano});
                    $.post(
                        UrlServiceProviderTCE, parameters
                    ).success(function (data) {
                        modal.close().remove();
                        if (false === data.response) {
                            modal.disableBackdrop()
                                .showCloseButton()
                                .setTitle("Erro")
                                .setBody(data.message)
                                .open();
                        } else {
                            loadValores(entidadeSelect.val());
                        }
                    });
                });
            },
            initComplete: function( settings, json ) {
                modal.close();
                $('.dataTables_scrollBody thead tr').css({ display: 'none' });

            },
            columnDefs: [{
                'targets': 5,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var key = full[5];

                    var buttonDelete = $('<button type="button" name="delete_' + key + '" data-id-delete="' + key + '" class="white-text blue darken-4 btn btn-success save delete"><i class="fa fa-trash" aria-hidden="true"></i></button>');

                    return buttonDelete.prop("outerHTML");
                }
            },
                { className: "white-space-unset vertical-align-unset", "targets": [ 0,1,2,3,4,5 ] }
            ]
        });
    }

    function loadValores(entidade) {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        var data = [];
        data.push({name: "entidade", value: entidade});
        data.push({name: "action", value: "LoadValores"});
        $.post(UrlServiceProviderTCE, data)
            .success(function (data) {
                    if (true === data.response) {
                        valores = data.valores;

                        var tableValores = [];

                        var contador = 1;
                        if (valores) {
                            for (var i = 0; i < valores.length; i++) {
                                tableValores.push(
                                    [
                                        contador,
                                        valores[i].ano,
                                        UrbemSonata.convertFloatToMoney(valores[i].vlReceitaPrevidenciaria),
                                        UrbemSonata.convertFloatToMoney(valores[i].vlDespesaPrevidenciaria),
                                        UrbemSonata.convertFloatToMoney(valores[i].vlSaldoFinanceiro),
                                        [i],
                                        valores[i].codEntidade,
                                        valores[i].exercicio,
                                        valores[i].ano
                                    ]
                                );
                                contador++;
                            }
                        }

                        var listClassToColumns = [
                            "dt-cell-1",
                            "dt-cell-1",
                            "dt-cell-3",
                            "dt-cell-3",
                            "dt-cell-3",
                            "dt-cell-1"
                        ];

                        renderTableListValores(tableValores, listClassToColumns);
                    }
                }
            );
    }
}());