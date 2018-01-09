$(document).ready(function() {

    // Add Tooltip on Inputs
    $.each(toolTipConfigurarArquivoREGLIC, function(index, value) {
        if  ($("#" + UrbemSonata.uniqId + "_" + index).length) {
            var input = $("#" + UrbemSonata.uniqId + "_" + index);
            input.attr("data-toggle", "tooltip")
                .attr("data-html", "true")
                .attr("title", value);
        }
    });

    /*botão mágico para consulta assíncrona*/
    var areaButton = $('<div class="form_row col s3 campo-sonata"></div>');
    var buttonSearch = $('<label class="control-label">&nbsp;</label><div class="sonata-ba-field "><button type="button" class="white-text blue darken-4 btn btn-success save" name="btnSearch" id="btnSearch"><i class="material-icons left">zoom_in</i>Buscar</button></div>');
    areaButton.append(buttonSearch);

    var containerFields = $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_entidade");
    containerFields.after(areaButton);

    $(':input[type=submit]').prop('disabled', true);

    /*Escuta botão de busca*/
    $("#btnSearch").on("click", function() {
        buscaParametros();
        $(':input[type=submit]').prop('disabled', false);
    });
    //ObjectModal
    var modal = $.urbemModal();

    //* Table principal com item a ser manipulados*/
    function renderTableList(data, tipoDecreto, listClassToColumns) {
        var tableName = "tableListDecreto";

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
                'targets': 5,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var codTipoDecretoSelected = full[5];
                    var codNorma = full[6];

                    var $select = $("<select class='select2-custom-item display-block width-250px' name='codTipoDecreto["+codNorma+"]'></select>", {
                        "id": full[0]+"start",
                        "name": "codTipoDecreto["+codNorma+"]",
                        "value": data
                    });

                    var $selecione = $("<option></option>", {
                        "text": "Selecione",
                        "value": ""
                    });
                    $select.append($selecione);

                    $.each(tipoDecreto, function(key, tipo) {
                        var $option = $("<option></option>", {
                            "text": tipo.descricao,
                            "value": tipo.codTipoDecreto
                        });

                        if(codTipoDecretoSelected === tipo.codTipoDecreto){
                            $option.attr("selected", "selected")
                        }

                        $select.append($option);
                    });

                    return $select.prop("outerHTML");
                }
            },
            { className: "white-space-unset vertical-align-unset", "targets": [ 0,1,2,3,4,5 ] }
            ]
        });
    }

    function buscaParametros() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        $.post(UrlServiceProviderTCE,  $("form").serializeArray())
            .success(function (data) {

                    var decreto = data.decreto;
                    var tipoDecreto = data.tipoDecreto;
                    var reglic = data.reglic;

                    if (reglic.length !== 0) {
                        $.each(reglic, function(index, value) {
                            if  ($("#" + UrbemSonata.uniqId + "_" + index).length) {
                                var input = $("#" + UrbemSonata.uniqId + "_" + index);
                                if (input.is('select')) {
                                    input.val(value).trigger("change");
                                } else {
                                    input.val(value);
                                }
                            }
                        });
                    } else {
                        $.each(toolTipConfigurarArquivoREGLIC, function(index, value) {
                            if  ($("#" + UrbemSonata.uniqId + "_" + index).length) {
                                var input = $("#" + UrbemSonata.uniqId + "_" + index);
                                if (input.is('select')) {
                                    input.val(' ').trigger("change");
                                } else {
                                    input.val('');
                                }
                            }
                        });
                    }

                    var data = [];

                    var contador = 1;
                    if (decreto) {
                        for (var i = 0; i < decreto.length; i++) {
                            data.push(
                                [
                                    contador,
                                    decreto[i].numNorma,
                                    decreto[i].nomNorma,
                                    decreto[i].dtAssinatura,
                                    decreto[i].dtPublicacao,
                                    decreto[i].codTipoDecreto,
                                    decreto[i].codNorma
                                ]
                            );
                            contador++;
                        }
                    }

                    var listClassToColumns = [
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-6",
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-2"
                    ];

                    renderTableList(data, tipoDecreto, listClassToColumns);
                }
            );
    }
}());