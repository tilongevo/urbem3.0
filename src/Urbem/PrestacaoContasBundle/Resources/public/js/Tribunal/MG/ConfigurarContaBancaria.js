$(document).ready(function() {
    $(".protocolo-numeric").keypress(function() {
        if (parseInt($(this).val()) < 0) {
            $(this).val(0);
        }
    });

    /*botão mágico para consulta assíncrona*/
    var areaButton = $('<div class="form_row col s3 campo-sonata"></div>');
    var buttonSearch = $('<label class="control-label">&nbsp;</label><div class="sonata-ba-field "><button type="button" class="white-text blue darken-4 btn btn-success save" name="btnSearch" id="btnSearch"><i class="material-icons left">zoom_in</i>Buscar</button></div>');
    areaButton.append(buttonSearch);

    var containerFields = $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_codOrdenacao");
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

    $(document).on("change", "#" + UrbemSonata.uniqId + "_codOrdenacao", function() {
        $(':input[type=submit]').prop('disabled', true);
    });

    //ObjectModal
    var modal = $.urbemModal();

    //* Table principal com item a ser manipulados*/
    function renderTableList(data, aplicacao, listClassToColumns) {
        var tableName = "tableContaContabil";

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
                UrbemSonata.acceptOnlyNumeric($(".protocolo-numeric"));
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

                    var codTipoAplicacaoSelected = full[4];
                    var codConta = full[7];

                    var $select = $("<select class='select2-custom-item display-block width-250px' name='codTipoAplicacao["+codConta+"]'></select>", {
                        "id": full[0]+"start",
                        "name": "codTipoAplicacao["+codConta+"]",
                        "value": data
                    });

                    var $selecione = $("<option></option>", {
                        "text": "Selecione",
                        "value": ''
                    });
                    $select.append($selecione);

                    $.each(aplicacao, function(key, aplicacao) {
                        var $option = $("<option></option>", {
                            "text": aplicacao.descricao,
                            "value": aplicacao.codTipoAplicacao
                        });

                        if(codTipoAplicacaoSelected === aplicacao.codTipoAplicacao){
                            $option.attr("selected", "selected")
                        }

                        $select.append($option);
                    });

                    return $select.prop("outerHTML");
                }
            },
                {
                'targets': 6,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var codConta = full[7];
                    var CodCtbAnterior = full[6];

                    var $input = $("<input type='text' class='campo-sonata form-control protocolo-numeric' value='"+CodCtbAnterior+"' name='codCtbAnterior["+codConta+"]'>");

                    return $input.prop("outerHTML");
                }
            },
                { className: "white-space-unset vertical-align-unset", "targets": [ 0,1,2,3,4,5,6 ] }
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

                    var contas = data.content;
                    var aplicacao = data.aplicacao;


                    var data = [];

                    var contador = 1;
                    if (contas) {
                        for (var i = 0; i < contas.length; i++) {
                            var codCtbAnterior = contas[i].cod_ctb_anterior;
                            if (codCtbAnterior == null) {
                                codCtbAnterior = '';
                            }
                            data.push(
                                [
                                    contador,
                                    contas[i].cod_estrutural,
                                    contas[i].cod_plano,
                                    contas[i].nom_conta,
                                    contas[i].cod_tipo_aplicacao,
                                    "Banco: " + contas[i].num_banco + " Agência: " + contas[i].num_agencia + " C/C: " + contas[i].num_conta_corrente,
                                    codCtbAnterior,
                                    contas[i].cod_conta,
                                ]
                            );
                            contador++;
                        }
                    }

                    var listClassToColumns = [
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-2",
                        "dt-cell-2",
                        "dt-cell-3",
                        "dt-cell-1"
                    ];

                    $(".urbem-modal-body").html("Processando <strong>"+contas.length+"</strong> items para exibição...");
                    renderTableList(data, aplicacao, listClassToColumns);
                }
            );
    }
}());