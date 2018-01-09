$(document).ready(function() {
    /*botão mágico para consulta assíncrona*/
    var areaButton = $('<div class="form_row col s3 campo-sonata"></div>');
    var buttonSearch = $('<label class="control-label">&nbsp;</label><div class="sonata-ba-field "><button type="button" class="white-text blue darken-4 btn btn-success save" name="btnSearch" id="btnSearch"><i class="material-icons left">zoom_in</i>Buscar</button></div>');
    areaButton.append(buttonSearch);

    var containerFields = $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_codGrupo");
    containerFields.after(areaButton);

    $(':input[type=submit]').prop('disabled', true);

    /*Escuta botão de busca*/
    $("#btnSearch").on("click", function() {
        buscaParametros();
        $(':input[type=submit]').prop('disabled', false);
    });

    /*Limpa o Textarea e Desabilita a observacao e o submit obrigando uma nova search*/
    $(document).on("change", "#" + UrbemSonata.uniqId + "_entidade", function() {
        $(':input[type=submit]').prop('disabled', true);
    });

    $(document).on("change", "#" + UrbemSonata.uniqId + "_codGrupo", function() {
        $(':input[type=submit]').prop('disabled', true);
    });

    //ObjectModal
    var modal = $.urbemModal();

    //* Table principal com item a ser manipulados*/
    function renderTableList(data, planoContasEstrutura, listClassToColumns) {
        var tableName = "tableListVincular";

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
                'targets': 4,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var planoContaEstruturaSelected = full[4];
                    var codConta = full[6];

                    var $select = $("<select class='select2-custom-item display-block width-250px' name='codConta["+codConta+"]'></select>", {
                        "id": full[0]+"start",
                        "name": "codConta["+codConta+"]",
                        "value": data
                    });

                    var $selecione = $("<option></option>", {
                        "text": "Selecione",
                        "value": ''
                    });
                    $select.append($selecione);

                    $.each(planoContasEstrutura, function(key, estrutura) {
                        var $option = $("<option></option>", {
                            "text": estrutura.codigoEstrutural + " - " + estrutura.titulo,
                            "value": estrutura.codigoEstrutural
                        });

                        if(planoContaEstruturaSelected === estrutura.codigoEstrutural){
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

        $.post(UrlServiceProviderTCE, $("form").serializeArray())
            .success(function (data) {

                    var planoConta = data.content;
                    var planoContasEstrutura = data.planoContasEstrutura;


                    var data = [];

                    var contador = 1;
                    if (planoConta) {
                        for (var i = 0; i < planoConta.length; i++) {
                            data.push(
                                [
                                    contador,
                                    planoConta[i].cod_plano,
                                    planoConta[i].cod_estrutural,
                                    planoConta[i].nom_conta,
                                    planoConta[i].cod_estrutural_estrutura,
                                    planoConta[i].vinculado,
                                    planoConta[i].cod_conta
                                ]
                            );
                            contador++;
                        }
                    }

                    var listClassToColumns = [
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-2",
                        "dt-cell-3",
                        "dt-cell-4",
                        "dt-cell-1"
                    ];

                    renderTableList(data, planoContasEstrutura, listClassToColumns);
                }
            );
    }
}());