$(document).ready(function() {
    var valores = [];

    var btnSubmit = $(':input[type=submit]');
    btnSubmit.remove();

    var areaButton = $('<div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-procurar">');
    var buttonProcurar = $('<label class="control-label ">&nbsp;</label><div class="sonata-ba-field "><button type="button" class="white-text blue darken-4 btn btn-success save search" name="btn_create_and_list">Procurar</button></div>');
    areaButton.append(buttonProcurar);
    $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_dataImplantacao").after(areaButton);

    var areaSubmit = $('<div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-incluir">');
    var submit = $('<label class="control-label ">&nbsp;</label><div class="sonata-ba-field "><button type="submit" class="white-text blue darken-4 btn btn-success save" name="btn_create_and_list"><i class="material-icons left">input</i>Incluir</button></div>');
    areaSubmit.append(submit);
    $("#sonata-ba-field-container-valor").after(areaSubmit);

    //Adiciona Entidade
    var areaSelectEntidade = $('<div class="form_row col s3 campo-sonata-select" id="sonata-ba-field-container-entidade"></div>');
    var entidade = $('<label class="control-label required" for="entidade">Entidade</label> <select id="entidade" required="required" disabled="disabled" name="entidade" tabindex="-1" title="Entidade" class="select2-parameters select2-multiple-options-custom" style="display: inline-block;">' +
        '<option value="">Selecione</option></select>');
        areaSelectEntidade.append(entidade);
    $("form > div:eq(0)").after(areaSelectEntidade);

    //Adiciona Periodo
    var areaSelectPeriodo = $('<div class="form_row col s3 campo-sonata-select" id="sonata-ba-field-container-periodo"></div>');
    var periodo = $('<label class="control-label required" for="periodo">Periodo</label> <select id="periodo" required="required" disabled="disabled" name="periodo" tabindex="-1" title="Periodo" class="select2-parameters select2-multiple-options-custom" style="display: inline-block;">' +
        '<option value="">Selecione</option></select>');
        areaSelectPeriodo.append(periodo);
    $("#sonata-ba-field-container-entidade").after(areaSelectPeriodo);

    var dataImplantacao = $("#" + UrbemSonata.uniqId + "_dataImplantacao");
    var entidadeSelect = $("#entidade");
    var periodoSelect = $("#periodo");

    $(".search").on('click', function () {
        var parameters = [];

        if (dataImplantacao.val().length === 10) {
            parameters.push({name: 'dataImplantacao', value: dataImplantacao.val()});
            UrbemSonata.loadSelectOnAjax(entidadeSelect, 'LoadEntidade', parameters, enableSelectFromAjax);
            UrbemSonata.loadSelectOnAjax(periodoSelect, 'LoadPeriodo', parameters, enableSelectFromAjax);
            entidadeSelect.prop('disabled', false);
        } else {
            disable();
            clear();
        }
    });

    $(".incluir").on('click', function () {
        $("form").submit();
    });

    $(".money").blur(function() {
        if (parseInt($(this).val()) < 0 || $(this).val() === '') {
            $(this).val(UrbemSonata.convertFloatToMoney(0.00));
        }
    });

    $(".money").keyup(function () {
        var inputValor = $("#valor");
        var total = 0;
        var receita = 0;
        var deducao = 0;

        if (parseInt($(this).val()) < 0) {
            $(this).val(0);
        }
        $(".receita").each(function () {
            receita += UrbemSonata.convertMoneyToFloat($(this).val());
        });
        $(".deducao").each(function () {
            deducao += UrbemSonata.convertMoneyToFloat($(this).val());
        });
        total = receita - deducao;
        inputValor.val(UrbemSonata.convertFloatToMoney(total));
    });

    entidadeSelect.on('change', function () {
        var parameters = [];

        if (dataImplantacao.val().length === 10) {
            if ($(this).val()) {
                parameters.push({name: 'entidade', value: $(this).val()});
                parameters.push({name: 'dataImplantacao', value: dataImplantacao.val()});
                loadValores(parameters);
                periodoSelect.prop('disabled', false);
                UrbemSonata.loadSelectOnAjax(periodoSelect, 'LoadPeriodo', parameters, enableSelectFromAjax);
            } else {
                periodoSelect.val('').change();
                periodoSelect.prop('disabled', true);
            }
        }
    });

    periodoSelect.on('change', function () {
        if ($(this).val()) {
            $("#createValores").attr("data-toggle", "tab");
            $("#liInputList").removeClass("disabled");
            $("#liInputList").removeAttr("title");
            $('.nav-tabs a[href="#inputList"]').tab('show');
        } else {
            $("#createValores").attr("data-toggle", "");
            $("#liInputList").addClass("disabled");
            $("#liInputList").attr("title", "Selecione o Período");
            $('.nav-tabs a[href="#tableList"]').tab("show");
        }
    });

    function disable()
    {
        entidadeSelect.prop('disabled', true);
        periodoSelect.prop('disabled', true);
    }

    function clear()
    {
        entidadeSelect.val('').change();
        periodoSelect.val('').change();
    }

    function enableSelectFromAjax(){}

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
            data.push({name: "exercicio", value: valores[key].exercicio});
            data.push({name: "codEntidade", value: valores[key].codEntidade});
            data.push({name: "mes", value: valores[key].mes});
            data.push({name: "ano", value: valores[key].ano});
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
                    var parameters = [];
                    parameters.push({name: 'entidade', value: entidadeSelect.val()});
                    parameters.push({name: 'dataImplantacao', value: dataImplantacao.val()});
                    loadValores(parameters);
                }
            });
        });
    }

    // ObjectModal
    var modal = $.urbemModal();

    function renderTableListValores(data, listClassToColumns) {
        var tableName = "tableListValores";

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
                'targets': 3,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var key = full[3];

                    var buttonDelete = $('<button type="button" name="delete_' + key + '" class="white-text blue darken-4 btn btn-success save delete"><i class="fa fa-trash" aria-hidden="true"></i></button>');

                    return buttonDelete.prop("outerHTML");
                }
            },
                { className: "white-space-unset vertical-align-unset", "targets": [ 0,1,2,3 ] }
            ]
        });
    }

    function loadValores(parameters) {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        parameters.push({name: "action", value: "LoadValores"});
        $.post(UrlServiceProviderTCE, parameters)
            .success(function (data) {
                    if (true === data.response) {
                        valores = data.valores;

                        var data = [];

                        var contador = 1;
                        if (valores) {
                            for (var i = 0; i < valores.length; i++) {
                                data.push(
                                    [
                                        contador,
                                        valores[i].periodo,
                                        valores[i].valor,
                                        [i],
                                        valores[i].exercicio,
                                        valores[i].codEntidade,
                                        valores[i].mes,
                                        valores[i].ano
                                    ]
                                );
                                contador++;
                            }
                        }

                        var listClassToColumns = [
                            "dt-cell-1",
                            "dt-cell-5",
                            "dt-cell-5",
                            "dt-cell-1"
                        ];

                        renderTableListValores(data, listClassToColumns);
                    }
                }
            );
    }

}());