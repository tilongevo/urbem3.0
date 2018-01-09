$(document).ready(function() {
    /*informações importantes de carregamento inicial*/
    var tipoCredorSelect = $("select.tipo-credores-all");
    var exercicioContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_exercicio');
    var filtroSelect = $("#" + UrbemSonata.uniqId + '_filtro');
    exercicioContainer.hide();
    tipoCredorSelect.prop("disabled", true);

    /*botão mágico para consulta assíncrona*/
    var areaButton = $('<div class="form_row col s3 campo-sonata"></div>');
    var buttonSearch = $('<label class="control-label">&nbsp;</label><div class="sonata-ba-field "><button type="button" class="search-parametros-credor white-text blue darken-4 btn btn-success save" name="btn_create_and_list"><i class="material-icons left">zoom_in</i>Buscar</button></div>');
    areaButton.append(buttonSearch);

    var containerFields = $(".sonata-ba-collapsed-fields");
    containerFields.append(areaButton);

    /*Ação para esconder ou não o exercício*/
    filtroSelect.on("change", function() {
        if ($(this).val() == "exercicio") {
            return exercicioContainer.show();
        }

        return exercicioContainer.hide();
    });

    // ObjectModal
    var modal = $.urbemModal();

    /* Table principal com item a ser manipulados*/
    function renderTableList(data, tipoCredores, listClassToColumns) {
        var tableName = "tableListCredores";
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
                'targets': 3,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {
                    var exercicio = full[1];
                    var tipoSelected = full[3];
                    var numcgm = full[2];
                    numcgm = numcgm.split("-")[0];

                    var $select = $("<select class='select2-custom-item display-block width-250px' name='tipo_credor["+exercicio+"~"+numcgm+"]'></select>", {
                        "id": full[0]+"start",
                        "name": "tipo_credor["+exercicio.trim() + "˜" + numcgm.trim()+"]",
                        "value": data
                    });

                    $.each(tipoCredores, function(key, tipo) {
                        var $option = $("<option></option>", {
                            "text": tipo.label,
                            "value": tipo.id
                        });

                        if(tipoSelected === tipo.id){
                            $option.attr("selected", "selected")
                        }

                        $select.append($option);
                    });

                    return $select.prop("outerHTML");
                }
            },
                { className: "white-space-unset vertical-align-unset", "targets": [ 0,1,2,3 ] }
            ]
        });
    }

    // Function busca
    function buscaParametrosCredor() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        $.post(UrlServiceProviderTCE, $("form").serializeArray())
            .success(function (data) {
                    setSelectTipoCredor(data.tipoCredores);

                    var tipoCredores = data.tipoCredores;
                    var dadosCredorConversao = data.dadosCredorConversao;
                    var credoresExercicioAtual = data.credoresExercicioAtual;

                    var data = [];

                    /* primeira consulta*/
                    var contador = 1;
                    if (credoresExercicioAtual) {
                        for (var i = 0; i < credoresExercicioAtual.length; i++) {
                            data.push(
                                [
                                    contador,
                                    credoresExercicioAtual[i].exercicio,
                                    credoresExercicioAtual[i].numcgm + " - " + credoresExercicioAtual[i].nomCgm,
                                    credoresExercicioAtual[i].tipo
                                ]
                            );
                            contador++;
                        }
                    }

                    /* segunda consulta*/
                    if (dadosCredorConversao) {
                        for (var i = 0; i < dadosCredorConversao.length; i++) {
                            data.push(
                                [
                                    contador,
                                    dadosCredorConversao[i].exercicio,
                                    dadosCredorConversao[i].numcgm + " - " + dadosCredorConversao[i].nomCgm,
                                    dadosCredorConversao[i].tipo
                                ]
                            );
                            contador++;
                        }
                    }

                    var listClassToColumns = [
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-7",
                        "dt-cell-3"
                    ];

                    $(".content-data-credores").hide();
                    $(".urbem-modal-body").html("Processando <strong>"+(contador - 1)+"</strong> items para exibição...");
                    renderTableList(data, tipoCredores, listClassToColumns);
                }
            );
    }

    /* Monta combo com os tipos */
    function setSelectTipoCredor(tipoCredores) {
        tipoCredorSelect
            .prop("disabled", true)
            .empty()
            .select2("val", "")
            .append('<option>Selecione</option>');

        $.each(tipoCredores, function(index, tipo) {
            tipoCredorSelect.append('<option value="'+tipo.id+'">'+tipo.label+'</option>');
        });

        tipoCredores.length > 0 ? tipoCredorSelect.prop("disabled", false).trigger("change") : null;
    }

    /*Popula objeto com selacao automática*/
    tipoCredorSelect.on("change", function() {
        if (!parseInt($(this).val()) > 0) {
            return;
        }

        $(".select2-custom-item").val($(this).val());
    });

    /*Escuta botão de busca*/
    $(".search-parametros-credor").on("click", function() {
        buscaParametrosCredor();
    });
}());