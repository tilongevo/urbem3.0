$(document).ready(function() {
    /*botão mágico para consulta assíncrona*/
    var areaButton = $('<div class="form_row col s3 campo-sonata"></div>');
    var buttonSearch = $('<label class="control-label">&nbsp;</label><div class="sonata-ba-field "><button type="button" class="white-text blue darken-4 btn btn-success save" name="btnSearch" id="btnSearch"><i class="material-icons left">zoom_in</i>Buscar</button></div>');
    areaButton.append(buttonSearch);

    /*Adiciona o Botão, após o Input Descricao*/
    var containerFields = $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_descricao");
    containerFields.after(areaButton);

    var cmbClassificacaoDedutora = $("select#" + UrbemSonata.uniqId + "_cmbClassificacaoDedutora");
    var classificacaoDedutora = $("#" + UrbemSonata.uniqId + "_classificacaoDedutora");

    /* Adiciona a máscara de classificação escolhida no Select
    *
    * OBS: No código antigo ela está sendo tratada, mas está chumbada o valor,
    * mesmo assim foi colocada caso haja a necessidade de usar ela
    *
    */
    cmbClassificacaoDedutora.change(function() {
        var text = $("select#" + UrbemSonata.uniqId + "_cmbClassificacaoDedutora option:selected").text();
        setClassificacaoRedutora(classificacaoDedutora, text);
    });

    /*Escuta botão de busca*/
    $("#btnSearch").on("click", function() {
        buscaParametros();
    });

     //ObjectModal
    var modal = $.urbemModal();

    //* Table principal com item a ser manipulados*/
    function renderTableList(data, valoresIdentificadores, listClassToColumns) {
        var tableName = "tableListReceitas";

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

                    var caracteristicaSelected = full[2];
                    var receita = full[1];
                    receita = receita.split("-")[0];

                    var $select = $("<select class='select2-custom-item display-block width-250px' name='valores_identificadores["+receita.trim()+"]'></select>", {
                        "id": full[0]+"start",
                        "name": "valores_identificadores["+receita.trim()+"]",
                        "value": data
                    });

                    $.each(valoresIdentificadores, function(key, identificador) {
                        var $option = $("<option></option>", {
                            "text": identificador.descricao,
                            "value": identificador.codIdentificador
                        });

                        if(caracteristicaSelected === identificador.codIdentificador){
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

        $.post(UrlServiceProviderTCE, $("form").serializeArray())
            .success(function (data) {

                var valoresIdentificadores = data.valoresIdentificadores;

                var dadosReceita = data.receita;

                var data = [];

                var contador = 1;
                if (dadosReceita) {
                    for (var i = 0; i < dadosReceita.length; i++) {
                        data.push(
                            [
                                contador,
                                dadosReceita[i].cod_receita + " - " + dadosReceita[i].descricao,
                                dadosReceita[i].cod_identificador
                            ]
                        );
                        contador++;
                    }
                }

                var listClassToColumns = [
                    "dt-cell-1",
                    "dt-cell-8",
                    "dt-cell-3"
                ];

                $(".urbem-modal-body").html("Processando <strong>"+dadosReceita.length+"</strong> items para exibição...");
                renderTableList(data, valoresIdentificadores, listClassToColumns);
            }
        );
    }

    function setClassificacaoRedutora(input, value)
    {
        var valueArray = value.split(" - ");
        input.val(valueArray[0]);
    }
}());