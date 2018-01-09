$(document).ready(function() {
    var btnSubmit = $(':input[type=submit]');
    btnSubmit.remove();

    var pagamentos = [];
    var despesas = [];

    //Adiciona a Unidade
    var areaSelectUnidade = $('<div class="form_row col s3 campo-sonata-select" id="sonata-ba-field-container-unidade"></div>');
    var unidade = $('<label class="control-label required" for="unidade">Unidade</label> <select id="unidade" required="required" name="unidade" tabindex="-1" title="Unidade" class="select2-parameters select2-multiple-options-custom" style="display: inline-block;">' +
        '<option value="">Selecione</option></select></div></div>');
    areaSelectUnidade.append(unidade);
    $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_orgao").after(areaSelectUnidade);

    //Adiciona Tipo Recurso
    var areaSelectTipoRecurso = $('<div class="form_row col s3 campo-sonata-select" id="sonata-ba-field-container-tipoRecurso"></div>');
    var tipoRecurso = $('<label class="control-label required" for="tipoRecurso">Tipo Recurso</label> <select id="tipoRecurso" required="required" name="tipoRecurso" tabindex="-1" title="Tipo Recurso" class="select2-parameters select2-multiple-options-custom" style="display: inline-block;">' +
        '<option value="">Selecione</option>' +
        '<option value="1">Recursos de Pagamento de Profissionais Magistério</option>' +
        '<option value="2">Recursos de Outras Despesas</option></select></div></div>');
    areaSelectTipoRecurso.append(tipoRecurso);
    $("#sonata-ba-field-container-unidade").after(areaSelectTipoRecurso);

    //Adiciona Recurso
    var areaSelectRecurso = $('<div class="form_row col s3 campo-sonata-select" id="sonata-ba-field-container-recurso"></div>');
    var recurso = $('<label class="control-label required" for="recurso">Recurso</label> <select id="recurso" name="recurso" required="required" tabindex="-1" title="Recurso" class="select2-parameters select2-multiple-options-custom" style="display: inline-block;">' +
        '<option value="">Selecione</option></select></div></div>');
    areaSelectRecurso.append(recurso);
    $("#sonata-ba-field-container-tipoRecurso").after(areaSelectRecurso);

    //Adiciona Ação
    var areaSelectAcao = $('<div class="form_row col s3 campo-sonata-select" id="sonata-ba-field-container-acao"></div>');
    var acao = $('<label class="control-label required" for="acao">Ação</label> <select id="acao" name="acao" required="required" tabindex="-1" title="Ação" class="select2-parameters select2-multiple-options-custom" style="display: inline-block;">' +
        '<option value="">Selecione</option></select></div></div>');
    areaSelectAcao.append(acao);
    $("#sonata-ba-field-container-recurso").after(areaSelectAcao);

    //Adiciona Tipo Educação Infantil
    var areaSelectTipoEducacaoInfantil = $('<div class="form_row col s3 campo-sonata-select" id="sonata-ba-field-container-tipoEducacaoInfantil"></div>');
    var tipoEducacaoInfantil = $('<label class="control-label required" for="tipoEducacaoInfantil">Tipo Educação Infantil</label> <select id="tipoEducacaoInfantil" required="required" name="tipoEducacaoInfantil" tabindex="-1" title="Tipo Educação Infantil" class="select2-parameters select2-multiple-options-custom" style="display: inline-block;">' +
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
    var tipoRecursoSelect = $("#tipoRecurso");
    var recursoSelect = $("#recurso");
    var acaoSelect = $("#acao");
    var tipoEducacaoInfantilSelect = $("#tipoEducacaoInfantil");

    var objects = [orgaoSelect, unidadeSelect, tipoRecursoSelect, recursoSelect, acaoSelect, tipoEducacaoInfantilSelect];
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
            tipoRecursoSelect.prop('disabled', false);
        } else {
            var orgaoObjects = [unidadeSelect, tipoRecursoSelect, recursoSelect, acaoSelect, tipoEducacaoInfantilSelect];
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
            tipoRecursoSelect.prop('disabled', false);
        } else {
            var unidadeObjects = [tipoRecursoSelect, recursoSelect, acaoSelect, tipoEducacaoInfantilSelect];
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
            var tipoRecurso = name.split("_")[0];
            var key = parseInt(name.split("_")[1]);
            var recursos = despesas;

            if (tipoRecurso === 'deletePagamento') {
                recursos = pagamentos;
            }

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
            data.push({name: "codTipo", value: recursos[key].cod_tipo});
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
                    loadPagamentosDespesas();
                }
            });
        });
    }

    // ObjectModal
    var modal = $.urbemModal();

    function renderTableListPagamentos(data, listClassToColumns) {
        var tableName = "tableListPagamentos";

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

                    var buttonDelete = $('<button type="button" name="deletePagamento_' + key + '" class="white-text blue darken-4 btn btn-success save delete"><i class="fa fa-trash" aria-hidden="true"></i></button>');

                    return buttonDelete.prop("outerHTML");
                }
            },
                { className: "white-space-unset vertical-align-unset", "targets": [ 0,1,2,3,4,5,6,7 ] }
            ]
        });
    }

    function renderTableListDespesas(data, listClassToColumns) {
        var tableName = "tableListDespesas";

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

                    var buttonDelete = $('<button type="button" name="deleteDespesa_' + key + '" class="white-text blue darken-4 btn btn-success save delete"><i class="fa fa-trash" aria-hidden="true"></i></button>');

                    return buttonDelete.prop("outerHTML");
                }
            },
                { className: "white-space-unset vertical-align-unset", "targets": [ 0,1,2,3,4,5,6,7 ] }
            ]
        });
    }

    function loadPagamentosDespesas() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        var data = [];
        data.push({name: "action", value: "LoadPagamentosDespesas"});
        $.post(UrlServiceProviderTCE, data)
            .success(function (data) {
                    if (true === data.response) {
                        pagamentos = data.pagamentos;
                        despesas = data.despesas;

                        var tablePagamentos = [];
                        var tableDespesas = [];

                        var contador = 1;
                        if (pagamentos) {
                            for (var i = 0; i < pagamentos.length; i++) {
                                tablePagamentos.push(
                                    [
                                        contador,
                                        pagamentos[i].cod_entidade,
                                        $("#" + UrbemSonata.uniqId + "_orgao option[value='" + pagamentos[i].num_orgao + "']").text(),
                                        pagamentos[i].num_unidade,
                                        pagamentos[i].cod_recurso + " - " + pagamentos[i].nom_recurso,
                                        pagamentos[i].cod_acao,
                                        pagamentos[i].cod_tipo_educacao === null ? '' : pagamentos[i].cod_tipo_educacao + " - " + $("#tipoEducacaoInfantil option[value='" + pagamentos[i].cod_tipo_educacao + "']").text(),
                                        [i]
                                    ]
                                );
                                contador++;
                            }
                        }

                        var contador = 1;
                        if (despesas) {
                            for (var i = 0; i < despesas.length; i++) {
                                tableDespesas.push(
                                    [
                                        contador,
                                        despesas[i].cod_entidade,
                                        $("#" + UrbemSonata.uniqId + "_orgao option[value='" + despesas[i].num_orgao + "']").text(),
                                        despesas[i].num_unidade,
                                        despesas[i].cod_recurso + " - " + despesas[i].nom_recurso,
                                        despesas[i].cod_acao,
                                        despesas[i].cod_tipo_educacao === null ? '' : despesas[i].cod_tipo_educacao + " - " + $("#tipoEducacaoInfantil option[value='" + despesas[i].cod_tipo_educacao + "']").text(),
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

                        renderTableListPagamentos(tablePagamentos, listClassToColumns);
                        renderTableListDespesas(tableDespesas, listClassToColumns);
                    }
                }
            );
    }

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", loadPagamentosDespesas);
}());