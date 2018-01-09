$(document).ready(function() {
    var btnSubmit = $(':input[type=submit]');
    btnSubmit.remove();

    var areaButton = $('<div class="form_row col s3 campo-sonata"></div>');
    var buttonOk = $('<label class="control-label">&nbsp;</label><div class="sonata-ba-field "><button type="button" class="white-text blue darken-4 btn btn-success save" name="btn_create_and_list"><i class="material-icons left">input</i>Ok</button></div>');
    areaButton.append(buttonOk);

    var containerFields = $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_search_autocomplete_empenho");
    containerFields.after(areaButton);

    var empenhos;
    var exercicioAtual;

    $(".protocolo-numeric").keypress(function() {
        if (parseInt($(this).val()) < 0) {
            $(this).val(0);
        }
    });

    // Remove Option Selecione from Input Default
    $.each($("select#" + UrbemSonata.uniqId + "_entidade option"), function() {
        if ($(this).val() === '') {
            $(this).remove();
        }
    });

    //Set Parameters para o envio do AJAX
    var parameters = {};
    var entidade = $("select#" + UrbemSonata.uniqId + "_entidade");
    parameters['entidade'] = entidade.val();
    entidade.on('change', function () {
        parameters['entidade'] = $(this).val();
    });

    $("#" + UrbemSonata.uniqId + "_exercicio").addClass("protocolo-numeric").attr("maxlength", 4);
    $("#" + UrbemSonata.uniqId + "_exercicioLicitacao").addClass("protocolo-numeric").attr("maxlength", 4);
    $("#" + UrbemSonata.uniqId + "_codLicitacao").addClass("protocolo-numeric").attr("maxlength", 5);
    $("#" + UrbemSonata.uniqId + "_search_autocomplete_empenho").addClass("select2-parameters autocomplete-input");

    function runEvents() {
        $(".edit").on('click', function () {
            var key = getKey($(this).attr('name'));
            var entidade = exercicioAtual + "~" + empenhos[key].codEntidade;
            var empenho = empenhos[key].codEmpenho + "/" +  exercicioAtual + " - " + empenhos[key].nomCgm;

            $("#" + UrbemSonata.uniqId + "_exercicio").val(empenhos[key].exercicio);
            $("#" + UrbemSonata.uniqId + "_entidade").val(entidade).change();
            $("#" + UrbemSonata.uniqId + "_exercicioLicitacao").val(empenhos[key].exercicioLicitacao);
            $("#" + UrbemSonata.uniqId + "_codLicitacao").val(empenhos[key].codLicitacao);
            $("#" + UrbemSonata.uniqId + "_codModalidade").val(empenhos[key].codModalidade).change();
            $("#" + UrbemSonata.uniqId + "_search_autocomplete_empenho").select2("data", {"id": empenhos[key].codEmpenho, "label": empenho}).trigger('change');
        });

        $(".delete").on('click', function () {
            var key = getKey($(this).attr('name'));
            modal.disableBackdrop()
                .setTitle("Aguarde")
                .setBody("Removendo Dado...")
                .open();

            var data = [];
            data.push({name: "action", value:"Delete"});
            data.push({name: "exercicio", value: empenhos[key].exercicio});
            data.push({name: "codEntidade", value: empenhos[key].codEntidade});
            data.push({name: "exercicioLicitacao", value: empenhos[key].exercicioLicitacao});
            data.push({name: "codLicitacao", value: empenhos[key].codLicitacao});
            data.push({name: "codModalidade", value: empenhos[key].codModalidade});
            data.push({name: "codEmpenho", value: empenhos[key].codEmpenho});
            $.post(
                UrlServiceProviderTCE, data
            ).success(function (data) {
                modal.close().remove();
                if (false === data.response) {
                    modal.disableBackdrop()
                        .showCloseButton()
                        .setTitle("Erro")
                        .setBody(data.message)
                        .open();
                } else {
                    loadEmpenhos();
                }
            });
        });
    }

    $(".save").on('click', function (e) {

        modal.disableBackdrop()
            .setTitle("Aguarde")
            .setBody("Salvando Dados...")
            .open();

        data = $("form").serializeArray();
        data.push({name: "action", value:"Save"});

        $.post(
            UrlServiceProviderTCE, data
        ).success(function (data) {
            modal.close().remove();
            if (false === data.response) {
                modal.disableBackdrop()
                    .showCloseButton()
                    .setTitle("Error")
                    .setBody(data.message)
                    .open();
            } else {
                $("form").submit();
            }
        });
    });

    function getKey(name) {

        var key = name.split("_")[1];

        return parseInt(key);
    }

    //ObjectModal
    var modal = $.urbemModal();

    //* Table principal com item a ser manipulados*/
    function renderTableList(data, listClassToColumns) {
        var tableName = "tableListEmpenhos";

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
                runEvents();
            },
            initComplete: function( settings, json ) {
                modal.close();
                $('.dataTables_scrollBody thead tr').css({ display: 'none' });

                UrbemSonata.LoadAutoCompleteInput('.autocomplete-input', 'search_autocomplete_empenho', UrlServiceProviderTCE, 1, parameters);
                $(".autocomplete-input").select2('data', null).trigger('change');
            },
            columnDefs: [{
                'targets': 7,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var key = full[7];

                    var buttonDelete = $('<button type="button" name="delete_' + key + '" class="white-text blue darken-4 btn btn-success save delete"><i class="fa fa-trash" aria-hidden="true"></i></button>');
                    var buttonEdit = $('<button type="button" name="edit_' + key + '" class="white-text blue darken-4 btn btn-success save edit"><i class="fa fa-pencil" aria-hidden="true"></i></button>');

                    buttonEdit.append(buttonDelete);
                    return buttonEdit.prop("outerHTML");
                }
            },
                { className: "white-space-unset vertical-align-unset", "targets": [ 0,1,2,3,4,5,6,7 ] }
            ]
        });
    }

    function loadEmpenhos() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        data = [];
        data.push({name: "action", value: "LoadEmpenhos"});
        $.post(UrlServiceProviderTCE, data)
            .success(function (data) {
                    if (true === data.response) {
                        empenhos = data.content;
                        exercicioAtual = data.exercicioAtual;

                        $("#" + UrbemSonata.uniqId + "_exercicio").val(exercicioAtual);
                        var data = [];

                        var contador = 1;
                        if (empenhos) {
                            for (var i = 0; i < empenhos.length; i++) {
                                data.push(
                                    [
                                        contador,
                                        empenhos[i].exercicio,
                                        empenhos[i].codEntidade,
                                        empenhos[i].codEmpenho + " - " + empenhos[i].nomCgm,
                                        empenhos[i].exercicioLicitacao,
                                        empenhos[i].codLicitacao,
                                        empenhos[i].codModalidade + " - " + empenhos[i].descricao,
                                        [i],
                                        empenhos[i].codEmpenho,
                                        empenhos[i].codModalidade,
                                        empenhos[i].nomCgm
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
                            "dt-cell-1",
                            "dt-cell-1",
                            "dt-cell-2",
                            "dt-cell-1"
                        ];

                        renderTableList(data, listClassToColumns);
                    }
                }
            );
    }

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", loadEmpenhos);
}());