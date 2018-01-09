$(document).ready(function() {

    //ObjectModal
    var modal = $.urbemModal();

    //* Table principal com item a ser manipulados*/
    function renderTableList(data, tipoDocCredor, listClassToColumns) {
        var tableName = "tableListTipoDocumentoCredor";

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
            },
            initComplete: function( settings, json ) {
                modal.close();
                $('.dataTables_scrollBody thead tr').css({ display: 'none' });
            },
            columnDefs: [{
                'targets': 2,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var tipoDocCredorSelected = full[2];
                    var codDocumento = full[1];
                    codDocumento = codDocumento.split("-")[0];

                    var $select = $("<select class='select2-custom-item display-block width-250px' name='tipoDocCredor["+codDocumento.trim()+"]'></select>", {
                        "id": full[0]+"start",
                        "name": "tipoDocCredor["+codDocumento.trim()+"]",
                        "value": data
                    });

                    var $selecione = $("<option></option>", {
                        "text": 'Selecione',
                        "value": ''
                    });
                    $select.append($selecione);

                    $.each(tipoDocCredor, function(key, tipo) {
                        var $option = $("<option></option>", {
                            "text": tipo.descricao,
                            "value": tipo.codigo
                        });

                        if (tipoDocCredorSelected === tipo.codigo) {
                            $option.attr("selected", "selected")
                        }

                        $select.append($option);
                    });

                    return $select.prop("outerHTML");
                }
            },
                { className: "white-space-unset vertical-align-unset", "targets": [ 0,1,2 ] }
            ]
        });
    }

    function buscaParametros() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        $.post(UrlServiceProviderTCE)
            .success(function (data) {
                    var tipoDocumento = data.tipoDocumento;
                    var tipoDocCredor = data.tipoDocCredor;

                    var data = [];

                    var contador = 1;
                    if (tipoDocumento) {
                        for (var i = 0; i < tipoDocumento.length; i++) {
                            data.push(
                                [
                                    contador,
                                    tipoDocumento[i].codDocumento + " - " + tipoDocumento[i].nomDocumento,
                                    tipoDocumento[i].codigo
                                ]
                            );
                            contador++;
                        }
                    }

                    var listClassToColumns = [
                        "dt-cell-1",
                        "dt-cell-3",
                        "dt-cell-3"
                    ];

                    renderTableList(data, tipoDocCredor, listClassToColumns);
                }
            );
    }

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", buscaParametros);
}());