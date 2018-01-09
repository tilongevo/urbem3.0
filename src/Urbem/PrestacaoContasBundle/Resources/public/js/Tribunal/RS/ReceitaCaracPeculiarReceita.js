$(document).ready(function() {
    /*informações importantes de carregamento inicial*/
    var exercicioContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_exercicio');
    var filtroSelect = $("#" + UrbemSonata.uniqId + '_filtro');

    /*botão mágico para consulta assíncrona*/
    var areaButton = $('<div class="form_row col s3 campo-sonata"></div>');
    var buttonSearch = $('<label class="control-label">&nbsp;</label><div class="sonata-ba-field "><button type="button" class="search-parametros-receita-peculiar white-text blue darken-4 btn btn-success save" name="btn_create_and_list"><i class="material-icons left">zoom_in</i>Buscar</button></div>');
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
    function renderTableList(data, tipoCaracteristicas, listClassToColumns) {
        var tableName = "tableListReceitasPeculiar";
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

                // Aplica Select2 no Identificador
                $(".select2-custom-item").select2();
            },
            columnDefs: [
                {
                    'targets': 3,
                    'searchable': false,
                    'orderable': false,
                    'render': function (data, type, full, meta) {
                        var exercicio = full[1];
                        var receita = full[2];
                        var tipoSelected = !parseInt(full[3]) ? 0 : full[3];
                        codReceita = receita.split("-")[0];

                        var $select = $("<select class='select2-parameters select2-custom-item  display-block width-250px' name='tipo_caracteristica["+exercicio.trim()+"~"+codReceita.trim()+"]'></select>", {
                            "id": full[0]+"start",
                            "name": "tipo_caracteristica["+exercicio.trim()+"~"+codReceita.trim()+"]",
                            "value": data
                        });

                        $.each(tipoCaracteristicas, function(key, tipo) {
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
    function buscaParametrosReceitaPeculiar() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();


        $.post(UrlServiceProviderTCE, $("form").serializeArray())
            .success(function (data) {
                    var dadosCaracteristica = data.dadosReceitaPeculiar;
                    var tipoCaracteristicas = data.caracteristica;

                    var data = [];
                    var contador = 1;
                    if (dadosCaracteristica) {
                        for (var i = 0; i < dadosCaracteristica.length; i++) {
                            data.push(
                                [
                                     contador,
                                     dadosCaracteristica[i].exercicio,
                                     dadosCaracteristica[i].cod_receita + " - " + dadosCaracteristica[i].descricao,
                                     dadosCaracteristica[i].cod_caracteristica,
                                ]
                            );
                            contador++;
                        }
                    }

                    $(".urbem-modal-body").html("Processando <strong>"+(contador - 1)+"</strong> items para exibição...");

                    var listClassToColumns = [
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-7",
                        "dt-cell-3"
                    ];

                    renderTableList(data, tipoCaracteristicas, listClassToColumns);
                }
            );
    }

    /*Escuta botão de busca*/
    $(".search-parametros-receita-peculiar").on("click", function() {
        buscaParametrosReceitaPeculiar();
    });
}());