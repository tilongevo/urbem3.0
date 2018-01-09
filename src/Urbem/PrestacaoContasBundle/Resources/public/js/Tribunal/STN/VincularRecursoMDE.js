$(document).ready(function() {
    var btnSubmit = $(':input[type=submit]');
    btnSubmit.remove();

    var recursos = [];

    //Adiciona a Unidade
    var areaSelectUnidade = $('<div class="form_row col s3 campo-sonata-select" id="sonata-ba-field-container-unidade"></div>');
    var unidade = $('<label class="control-label required" for="unidade">Unidade</label> <select id="unidade" required="required" name="unidade" tabindex="-1" title="Unidade" class="select2-parameters select2-multiple-options-custom" style="display: inline-block;">' +
        '<option value="">Selecione</option></select></div></div>');
    areaSelectUnidade.append(unidade);
    $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_orgao").after(areaSelectUnidade);

    //Adiciona Recurso
    var areaSelectRecurso = $('<div class="form_row col s3 campo-sonata-select" id="sonata-ba-field-container-recurso"></div>');
    var recurso = $('<label class="control-label required" for="recurso">Recurso</label> <select id="recurso" name="recurso" required="required" tabindex="-1" title="Recurso" class="select2-parameters select2-multiple-options-custom" style="display: inline-block;">' +
        '<option value="">Selecione</option></select></div></div>');
    areaSelectRecurso.append(recurso);
    $("#sonata-ba-field-container-unidade").after(areaSelectRecurso);

    //Adiciona Ação
    var areaSelectAcao = $('<div class="form_row col s3 campo-sonata-select" id="sonata-ba-field-container-acao"></div>');
    var acao = $('<label class="control-label required" for="acao">Ação</label> <select id="acao" name="acao" required="required" tabindex="-1" title="Ação" class="select2-parameters select2-multiple-options-custom" style="display: inline-block;">' +
        '<option value="">Selecione</option></select></div></div>');
    areaSelectAcao.append(acao);
    $("#sonata-ba-field-container-recurso").after(areaSelectAcao);

    //Adiciona Tipo Educação Infantil
    var areaSelectTipoEducacaoInfantil = $('<div class="form_row col s3 campo-sonata-select" id="sonata-ba-field-container-tipoEducacaoInfantil"></div>');
    var tipoEducacaoInfantil = $('<label class="control-label required" id="lblTipoEducacaoInfantil" for="tipoEducacaoInfantil">Tipo Educação Infantil</label> <select id="tipoEducacaoInfantil" required="required" name="tipoEducacaoInfantil" tabindex="-1" title="Tipo Educação Infantil" class="select2-parameters select2-multiple-options-custom" style="display: inline-block;">' +
        '<option value="">Selecione</option>' +
        '<option value="1">Creche</option>' +
        '<option value="2">Pré-Escola</option></select></div></div>');
    areaSelectTipoEducacaoInfantil.append(tipoEducacaoInfantil);
    $("#sonata-ba-field-container-acao").after(areaSelectTipoEducacaoInfantil);

    var areaButton = $('<div class="form_row col s3 campo-sonata"></div>');
    var buttonOk = $('<label class="control-label ">&nbsp;</label><div class="sonata-ba-field "><button type="submit" class="white-text blue darken-4 btn btn-success save" name="btn_create_and_list"><i class="material-icons left">input</i>Incluir</button></div>');
    areaButton.append(buttonOk);

    $("#sonata-ba-field-container-tipoEducacaoInfantil").after(areaButton);

    // Fields
    var entidadeSelect = $("#" + UrbemSonata.uniqId + "_entidade");
    var orgaoSelect = $("#" + UrbemSonata.uniqId + "_orgao");
    var unidadeSelect = $("#unidade");
    var recursoSelect = $("#recurso");
    var acaoSelect = $("#acao");
    var tipoEducacaoInfantilSelect = $("#tipoEducacaoInfantil");

    var objects = [orgaoSelect, unidadeSelect, recursoSelect, acaoSelect, tipoEducacaoInfantilSelect];
    disabledSelect(objects);

    function disabledSelect(objects) {
        for(var key = 0; key < objects.length; key++) {
            // Disabled selects
            objects[key].prop('disabled', true);
            objects[key].val('').change();
        }
    }

    function enableSelect($select, content) {
        $select.prop('disabled', false);
    }

    entidadeSelect.on('change', function () {
        if ($(this).val()) {
            orgaoSelect.prop('disabled', false);
        } else {
            disabledSelect(objects);
        }
    });

    orgaoSelect.on('change', function () {
        var parameters = [];
        parameters.push({name: 'orgao', value: $(this).val()});

        if ($(this).val()) {
            UrbemSonata.loadSelectOnAjax(unidadeSelect, 'LoadUnidade', parameters, enableSelect);
        } else {
            var orgaoObjects = [unidadeSelect, recursoSelect, acaoSelect, tipoEducacaoInfantilSelect];
            disabledSelect(orgaoObjects);
        }
    });

    unidadeSelect.on('change', function () {
        var parameters = [];
        parameters.push({name: 'entidade', value: entidadeSelect.val()});
        parameters.push({name: 'orgao', value: orgaoSelect.val()});
        parameters.push({name: 'unidade', value: $(this).val()});

        if ($(this).val()) {
            UrbemSonata.loadSelectOnAjax(recursoSelect, 'LoadRecurso', parameters, enableSelect);
            recursoSelect.prop('disabled', false);
        } else {
            var unidadeObjects = [recursoSelect, acaoSelect, tipoEducacaoInfantilSelect];
            disabledSelect(unidadeObjects);
        }
    });

    recursoSelect.on('change', function () {
        var parameters = [];
        parameters.push({name: 'entidade', value: entidadeSelect.val()});
        parameters.push({name: 'orgao', value: orgaoSelect.val()});
        parameters.push({name: 'unidade', value: unidadeSelect.val()});
        parameters.push({name: 'recurso', value: recursoSelect.val()});

        if ($(this).val()) {
            UrbemSonata.loadSelectOnAjax(acaoSelect, 'LoadAcao', parameters, enableSelect);
            acaoSelect.prop('disabled', false);
        } else {
            var recursoObjects = [acaoSelect, tipoEducacaoInfantilSelect];
            disabledSelect(recursoObjects);
        }
    });

    acaoSelect.on('change', function () {
        if ($(this).val()) {
            tipoEducacaoInfantilSelect.prop('disabled', false);
        } else {
            var acaoObjects = [tipoEducacaoInfantilSelect];
            disabledSelect(acaoObjects);
        }
    });

    function runEvents() {
        $(".delete").on('click', function () {
            var name = $(this).attr('name');
            var key = parseInt(name.split("_")[1]);

            modal.disableBackdrop()
                .setTitle("Aguarde")
                .setBody("Removendo Dado...")
                .open();

            var data = [];
            data.push({name: "action", value:"Delete"});
            data.push({name: "exercicio", value: recursos[key].exercicio});
            data.push({name: "codEntidade", value: recursos[key].cod_entidade});
            data.push({name: "numOrgao", value: recursos[key].num_orgao});
            data.push({name: "numUnidade", value: recursos[key].num_unidade});
            data.push({name: "codRecurso", value: recursos[key].cod_recurso});
            data.push({name: "codTipoEducacao", value: recursos[key].cod_tipo_educacao});
            data.push({name: "codAcao", value: recursos[key].cod_acao});
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
                    loadRecursos();
                }
            });
        });
    }

    // ObjectModal
    var modal = $.urbemModal();

    // Function Test
    function carregaAcaoTeste() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações importantes...')
            .open();

        $.post(UrlServiceProviderTCE, $("form").serializeArray())
            .success(function (data) {

                console.log(data);

                modal.close();
            }
        );
    }

    function renderTableListRecursos(data, listClassToColumns) {
        var tableName = "tableListRecursos";

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
                runEvents();
            },
            initComplete: function( settings, json ) {
                modal.close();
                $('.dataTables_scrollBody thead tr').css({ display: 'none' });

            },
            columnDefs: [{
                'targets': 7,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var key = full[7];

                    var buttonDelete = $('<button type="button" name="delete_' + key + '" class="white-text blue darken-4 btn btn-success save delete"><i class="fa fa-trash" aria-hidden="true"></i></button>');

                    return buttonDelete.prop("outerHTML");
                }
            },
                { className: "white-space-unset vertical-align-unset", "targets": [ 0,1,2,3,4,5,6,7 ] }
            ]
        });
    }

    function loadRecursos() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        var data = [];
        data.push({name: "action", value: "LoadRecursos"});
        $.post(UrlServiceProviderTCE, data)
            .success(function (data) {
                    if (true === data.response) {
                        recursos = data.content;

                        var tableRecursos = [];

                        var contador = 1;
                        if (recursos) {
                            for (var i = 0; i < recursos.length; i++) {
                                tableRecursos.push(
                                    [
                                        contador,
                                        recursos[i].cod_entidade,
                                        $("#" + UrbemSonata.uniqId + "_orgao option[value='" + recursos[i].num_orgao + "']").text(),
                                        recursos[i].num_unidade,
                                        recursos[i].cod_recurso + " - " + recursos[i].nom_recurso,
                                        recursos[i].cod_acao,
                                        recursos[i].cod_tipo_educacao === null ? '' : recursos[i].cod_tipo_educacao + " - " + $("#tipoEducacaoInfantil option[value='" + recursos[i].cod_tipo_educacao + "']").text(),
                                        [i]
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
                            "dt-cell-1",
                            "dt-cell-1",
                            "dt-cell-1"
                        ];

                        renderTableListRecursos(tableRecursos, listClassToColumns);
                    }
                }
            );
    }

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", loadRecursos);
}());