$(document).ready(function() {

    //ObjectModal
    var modal = $.urbemModal();

    //* Table principal com item a ser manipulados*/
    function renderTableList(data, tipoVeiculoTce, subtipoVeiculoTce, listClassToColumns) {
        var tableName = "tableListTipoVeiculo";

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
                eventFillSelectSubtipoVeiculoTce(subtipoVeiculoTce);
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

                    var tipoVeiculoTceSelected = full[2];
                    var tipoVeiculo = full[1];
                    tipoVeiculo = tipoVeiculo.split("-")[0];

                    var $selectTipoVeiculoTce = $("<select class='select2-custom-item display-block width-250px tipo-veiculo-tce' id='tipo_"+tipoVeiculo.trim()+"' name='tipoVeiculoTce["+tipoVeiculo.trim()+"]'></select>", {
                        "id": full[0]+"start",
                        "name": "tipoVeiculoTce["+tipoVeiculo.trim()+"]",
                        "value": data
                    });

                    $.each(tipoVeiculoTce, function(key, tipo) {
                        var $option = $("<option></option>", {
                            "text": tipo.nomTipoTce,
                            "value": tipo.codTipoTce
                        });

                        if (tipoVeiculoTceSelected === tipo.codTipoTce) {
                            $option.attr("selected", "selected")
                        }

                        $selectTipoVeiculoTce.append($option);
                    });

                    return $selectTipoVeiculoTce.prop("outerHTML");
                }
            },
            {
                'targets': 3,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var subtipoVeiculoTceSelected = parseInt(full[3]);
                    var tipoVeiculoTceSelected = full[2];
                    var tipoVeiculo = full[1];
                    tipoVeiculo = tipoVeiculo.split("-")[0];

                    var $selectSubtipoVeiculoTce = $("<select class='select2-custom-item display-block width-250px' id='subtipo_"+tipoVeiculo.trim()+"' name='subtipoVeiculoTce["+tipoVeiculo.trim()+"]'></select>", {
                        "id": full[0]+"start",
                        "name": "subtipoVeiculoTce["+tipoVeiculo.trim()+"]",
                        "value": data
                    });

                    var subtipoArray = subtipoVeiculoTce[tipoVeiculoTceSelected];

                    $.each(subtipoArray, function(key, subtipo) {
                        var $option = $("<option></option>", {
                            "text": subtipo,
                            "value": key
                        });

                        if (subtipoVeiculoTceSelected === parseInt(key)) {
                            $option.attr("selected", "selected")
                        }

                        $selectSubtipoVeiculoTce.append($option);
                    });

                    return $selectSubtipoVeiculoTce.prop("outerHTML");
                }
            },
                { className: "white-space-unset vertical-align-unset", "targets": [ 0,1,2,3 ] }
            ]
        });
    }

    function eventFillSelectSubtipoVeiculoTce(subtipoVeiculoTce)
    {
        $(".tipo-veiculo-tce").on("change", function () {
            var tipoVeiculoValue = $(this).val();
            var tipoVeiculo = $(this).attr("id");
            var subtipoSelect = $('#sub'+tipoVeiculo);
            subtipoSelect.html('');

            $.each(subtipoVeiculoTce[tipoVeiculoValue], function(key, value) {
                $(subtipoSelect)
                    .append($("<option></option>")
                        .attr("value",key)
                        .text(value));
            });
        });
    }

    function buscaParametros() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        $.post(UrlServiceProviderTCE)
            .success(function (data) {
                    var tipoVeiculo = data.tipoVeiculo;
                    var tipoVeiculoTce = data.tipoVeiculoTce;
                    var subtipoVeiculoTce = data.subtipoVeiculoTce;

                    var data = [];

                    var contador = 1;
                    if (tipoVeiculo) {
                        for (var i = 0; i < tipoVeiculo.length; i++) {
                            data.push(
                                [
                                    contador,
                                    tipoVeiculo[i].codTipo + " - " + tipoVeiculo[i].nomTipo,
                                    tipoVeiculo[i].codTipoTce,
                                    tipoVeiculo[i].codSubtipoTce
                                ]
                            );
                            contador++;
                        }
                    }

                    var listClassToColumns = [
                        "dt-cell-1",
                        "dt-cell-4",
                        "dt-cell-4",
                        "dt-cell-4"
                    ];

                    renderTableList(data, tipoVeiculoTce, subtipoVeiculoTce, listClassToColumns);
                }
            );
    }

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", buscaParametros);
}());