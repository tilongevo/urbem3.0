$(document).ready(function() {
    /*informações importantes de carregamento inicial*/
    var exercicioContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_exercicio');
    var filtroSelect = $("#" + UrbemSonata.uniqId + '_filtro');
    exercicioContainer.hide();

    /*botão mágico para consulta assíncrona*/
    var areaButton = $('<div class="form_row col s3 campo-sonata"></div>');
    var buttonSearch = $('<label class="control-label">&nbsp;</label><div class="sonata-ba-field "><button type="button" class="search-parametros-uniorcam white-text blue darken-4 btn btn-success save" name="btn_create_and_list"><i class="material-icons left">zoom_in</i>Buscar</button></div>');
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
    function renderTableList(data, tipoIdentificadores, listClassToColumns) {
        var tableName = "tableListUniorcam";
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

                // Todos os auto-completes cusotmizados
                UrbemSonata.LoadAutoCompleteInput('.autocomplete-input', 'search_autocomplete_cgm', UrlServiceProviderTCE, 3);

                // Aplica Select2 no Identificador
                $(".select2-custom-item").select2();
            },
            columnDefs: [
                {
                    'targets': 5,
                    'searchable': false,
                    'orderable': false,
                    'render': function (data, type, full, meta) {
                        var exercicio = full[1];
                        var numOrgao = full[2];
                        var numUnidade = full[3];
                        var numCgm = full[5];

                        numOrgao = numOrgao.split("-")[0];
                        numUnidade = numUnidade.split("-")[0];
                        cgmData = numCgm.split("-");

                        var numCgm = nomCgm = '';
                        if (cgmData.length > 0) {
                            numCgm = cgmData[0];
                            nomCgm = cgmData[1];
                        }

                        var $input = $("<input type='text' required='true' data-value='"+numCgm+"' data-label='"+nomCgm+"' data-allow-clear='true' class='select2-parameters autocomplete-input  display-block width-250px' name='cgm["+exercicio.trim()+"~"+numOrgao.trim()+"~"+numUnidade.trim()+"]' id='cgm_"+exercicio.trim()+"_"+numOrgao.trim()+"_"+numUnidade.trim()+"' value='"+numCgm+"'>", {
                            "id": full[0]+"_cgm_start",
                            "name": "cgm["+exercicio.trim()+"~"+numOrgao.trim()+"~"+numUnidade.trim()+"]",
                            "value": data
                        });

                        return $input.prop("outerHTML");
                    }
                },
                {
                    'targets': 4,
                    'searchable': false,
                    'orderable': false,
                    'render': function (data, type, full, meta) {
                        var exercicio = full[1];
                        var numOrgao = full[2];
                        var numUnidade = full[3];
                        var tipoSelected = full[4];
                        numOrgao = numOrgao.split("-")[0];
                        numUnidade = numUnidade.split("-")[0];

                        var $select = $("<select class='select2-parameters select2-custom-item  display-block width-250px' name='tipo_identificador["+exercicio.trim()+"~"+numOrgao.trim()+"~"+numUnidade.trim()+"]'></select>", {
                            "id": full[0]+"start",
                            "name": "tipo_identificador["+exercicio.trim()+"~"+numOrgao.trim()+"~"+numUnidade.trim()+"]",
                            "value": data
                        });

                        $.each(tipoIdentificadores, function(key, tipo) {
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
                { className: "white-space-unset vertical-align-unset", "targets": [ 0,1,2,3,4,5 ] }
            ]
        });
    }

    // Function busca
    function buscaParametrosUniorcam() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();


        $.post(UrlServiceProviderTCE, $("form").serializeArray())
            .success(function (data) {
                    var tipoIdentificadores = data.identificadores;
                    var dadosUniorcam = data.dadosUniorcam;

                    var data = [];
                    var contador = 1;
                    if (dadosUniorcam) {
                        for (var i = 0; i < dadosUniorcam.length; i++) {
                            data.push(
                                [
                                    contador,
                                    dadosUniorcam[i].exercicio,
                                    dadosUniorcam[i].numOrgao + " - " + dadosUniorcam[i].nomOrgao,
                                    dadosUniorcam[i].numUnidade + " - " + dadosUniorcam[i].nomUnidade,
                                    dadosUniorcam[i].identificador,
                                    dadosUniorcam[i].numcgm + " - " + dadosUniorcam[i].nomCgm,
                                ]
                            );
                            contador++;
                        }
                    }

                    var listClassToColumns = [
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-2",
                        "dt-cell-2",
                        "dt-cell-3",
                        "dt-cell-3"
                    ];

                    $(".urbem-modal-body").html("Processando <strong>"+(contador - 1)+"</strong> items para exibição...");
                    renderTableList(data, tipoIdentificadores, listClassToColumns);
                }
            );
    }

    /*Escuta botão de busca*/
    $(".search-parametros-uniorcam").on("click", function() {
        buscaParametrosUniorcam();
    });
}());