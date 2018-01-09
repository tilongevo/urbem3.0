$(document).ready(function() {
    function money() {
        $(document).on('click', '.money', function () {
            $(this).mask('#.##0,00', {reverse: true});
            if ($(this).val() == '') {
                $(this).val('0,00');
            }
            if ($(this).val().indexOf(',') < 0) {
                $(this).val($(this).val() + ',00');
            }
        });
    }

    var areaSelect = $('<div class="form_row col s3 campo-sonata-select"></div>');
    var select = $('<label class="control-label required" for="unidade">Unidade</label> <select id="unidade" name="unidade" disabled="" tabindex="-1" title="Unidade" class="select2-parameters select2-multiple-options-custom" style="display: inline-block;">' +
        '<option value="">Selecione</option></select></div></div>');
    areaSelect.append(select);

    var containerFields = $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_orgao");
    containerFields.after(areaSelect);

    var entidade = $("select#" + UrbemSonata.uniqId + "_entidade");
    var orgao = $("select#" + UrbemSonata.uniqId + "_orgao");
    var unidade = $("#unidade");

    unidade.prop("disabled", true);
    orgao.prop("disabled", true);
    $(':input[type=submit]').prop('disabled', true);

    entidade.change(function() {
        if ($(this).val()) {
            $(':input[type=submit]').prop('disabled', true);
            orgao.val('').change();
            orgao.prop("disabled", false);

            unidade.prop("disabled", true);
            unidade.val('').change();
        } else {
            orgao.prop("disabled", true);
            orgao.val('').change();

            unidade.prop("disabled", true);
            unidade.val('').change();
        }
    });

    orgao.change(function() {
        if ($(this).val()) {
            loadUnidade($(this).val(), unidade);
        } else {
            unidade.prop("disabled", true);
            unidade.val('').change();
        }
    });

    unidade.change(function() {
        if ($(this).val()) {
            buscaParametros(entidade.val(), orgao.val(), $(this).val());
            $(':input[type=submit]').prop('disabled', false);
        } else {
            $(':input[type=submit]').prop('disabled', true);
        }
    });

    /* Carrega as Unidades*/
    function loadUnidade(orgao, $select) {
        modal.disableBackdrop().setTitle('Aguarde').setBody('Carregando').open();

        data = [];
        data.push({name: 'action', value: 'LoadUnidade'});
        data.push({name: 'orgao', value: orgao});

        $.get(UrlServiceProviderTCE, data)
            .success(function (data) {
                if (data.response == true) {
                    var unidades = data.content;
                    $select.empty();
                    $select.append("<option value=''>Selecione</option>");
                    $select.val('').change();

                    $.each(unidades,function(key, value)
                    {
                        $select.append('<option value=' + key + '>' + value + '</option>');
                    });

                    $select.prop("disabled", false);
                }
                modal.close().remove();
            })
            .error(function (data) {
                modal.close().remove();
        });
    }
     //ObjectModal
    var modal = $.urbemModal();

    //* Table principal com item a ser manipulados*/
    function renderTableList(data, listClassToColumns) {
        var tableName = "tableList";

        var table = $("#"+tableName).DataTable();

        table.destroy();
        var table = $("#"+tableName).DataTable( {
            data:           data,
            deferRender:    true,
            scrollY:        400,
            scrollX:        true,
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
                money();

                $('.update-total').keyup(function() {
                        var periodos = 12;
                        var codGrupo = $(this).attr('id').split("_")[1];
                        if (!$(this).val()) {
                            $(this).val(0)
                        }
                        var total = 0;
                        for (i = 1; i <= periodos; i++) {
                            total += UrbemSonata.convertMoneyToFloat($('#codGrupo_' + codGrupo + '_' + i).val());
                        }
                        total = UrbemSonata.convertFloatToMoney(total);
                        $('#total_' + codGrupo).val(total);
                    }
                );
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

                    var value = UrbemSonata.convertFloatToMoney(full[2]);
                    var codGrupo = full[15];
                    var periodo = 1;

                    var $input = $("<input type='text' class='campo-sonata form-control money update-total' value='"+value+"' id='codGrupo_"+codGrupo+"_"+periodo+"' name='codGrupo["+codGrupo+"]["+periodo+"]'>");

                    return $input.prop("outerHTML");
                }
            },
            {
                'targets': 3,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var value = UrbemSonata.convertFloatToMoney(full[3]);
                    var codGrupo = full[15];
                    var periodo = 2;

                    var $input = $("<input type='text' class='campo-sonata form-control money update-total' value='"+value+"' id='codGrupo_"+codGrupo+"_"+periodo+"' name='codGrupo["+codGrupo+"]["+periodo+"]'>");

                    return $input.prop("outerHTML");
                }
            },
            {
                'targets': 4,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var value = UrbemSonata.convertFloatToMoney(full[4]);
                    var codGrupo = full[15];
                    var periodo = 3;

                    var $input = $("<input type='text' class='campo-sonata form-control money update-total' value='"+value+"' id='codGrupo_"+codGrupo+"_"+periodo+"' name='codGrupo["+codGrupo+"]["+periodo+"]'>");

                    return $input.prop("outerHTML");
                }
            },
            {
                'targets': 5,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var value = UrbemSonata.convertFloatToMoney(full[5]);
                    var codGrupo = full[15];
                    var periodo = 4;

                    var $input = $("<input type='text' class='campo-sonata form-control money update-total' value='"+value+"' id='codGrupo_"+codGrupo+"_"+periodo+"' name='codGrupo["+codGrupo+"]["+periodo+"]'>");

                    return $input.prop("outerHTML");
                }
            },
            {
                'targets': 6,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var value = UrbemSonata.convertFloatToMoney(full[6]);
                    var codGrupo = full[15];
                    var periodo = 5;

                    var $input = $("<input type='text' class='campo-sonata form-control money update-total' value='"+value+"' id='codGrupo_"+codGrupo+"_"+periodo+"' name='codGrupo["+codGrupo+"]["+periodo+"]'>");

                    return $input.prop("outerHTML");
                }
            },
            {
                'targets': 7,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var value = UrbemSonata.convertFloatToMoney(full[7]);
                    var codGrupo = full[15];
                    var periodo = 6;

                    var $input = $("<input type='text' class='campo-sonata form-control money update-total' value='"+value+"' id='codGrupo_"+codGrupo+"_"+periodo+"' name='codGrupo["+codGrupo+"]["+periodo+"]'>");

                    return $input.prop("outerHTML");
                }
            },
            {
                'targets': 8,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var value = UrbemSonata.convertFloatToMoney(full[8]);
                    var codGrupo = full[15];
                    var periodo = 7;

                    var $input = $("<input type='text' class='campo-sonata form-control money update-total' value='"+value+"' id='codGrupo_"+codGrupo+"_"+periodo+"' name='codGrupo["+codGrupo+"]["+periodo+"]'>");

                    return $input.prop("outerHTML");
                }
            },
            {
                'targets': 9,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var value = UrbemSonata.convertFloatToMoney(full[9]);
                    var codGrupo = full[15];
                    var periodo = 8;

                    var $input = $("<input type='text' class='campo-sonata form-control money update-total' value='"+value+"' id='codGrupo_"+codGrupo+"_"+periodo+"' name='codGrupo["+codGrupo+"]["+periodo+"]'>");

                    return $input.prop("outerHTML");
                }
            },
            {
                'targets': 10,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var value = UrbemSonata.convertFloatToMoney(full[10]);
                    var codGrupo = full[15];
                    var periodo = 9;

                    var $input = $("<input type='text' class='campo-sonata form-control money update-total' value='"+value+"' id='codGrupo_"+codGrupo+"_"+periodo+"' name='codGrupo["+codGrupo+"]["+periodo+"]'>");

                    return $input.prop("outerHTML");
                }
            },
            {
                'targets': 11,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var value = UrbemSonata.convertFloatToMoney(full[11]);
                    var codGrupo = full[15];
                    var periodo = 10;

                    var $input = $("<input type='text' class='campo-sonata form-control money update-total' value='"+value+"' id='codGrupo_"+codGrupo+"_"+periodo+"' name='codGrupo["+codGrupo+"]["+periodo+"]'>");

                    return $input.prop("outerHTML");
                }
            },
            {
                'targets': 12,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var value = UrbemSonata.convertFloatToMoney(full[12]);
                    var codGrupo = full[15];
                    var periodo = 11;

                    var $input = $("<input type='text' class='campo-sonata form-control money update-total' value='"+value+"' id='codGrupo_"+codGrupo+"_"+periodo+"' name='codGrupo["+codGrupo+"]["+periodo+"]'>");

                    return $input.prop("outerHTML");
                }
            },
            {
                'targets': 13,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var value = UrbemSonata.convertFloatToMoney(full[13]);
                    var codGrupo = full[15];
                    var periodo = 12;

                    var $input = $("<input type='text' class='campo-sonata form-control money update-total' value='"+value+"' id='codGrupo_"+codGrupo+"_"+periodo+"' name='codGrupo["+codGrupo+"]["+periodo+"]'>");

                    return $input.prop("outerHTML");
                }
            },
            {
                'targets': 14,
                'searchable': false,
                'orderable': false,
                'render': function (data, type, full, meta) {

                    var value = UrbemSonata.convertFloatToMoney(full[14]);
                    var codGrupo = full[15];

                    var $input = $("<input type='text' class='campo-sonata form-control money' readonly='readonly' id='total_"+codGrupo+"' value='"+value+"' name='total["+codGrupo+"]'>");

                    return $input.prop("outerHTML");
                }
            },
                { className: "white-space-unset vertical-align-unset", "targets": [ 0,1,2,3,4,5,6,7,8,9,10,11,12 ] }
            ]
        });
    }

    function buscaParametros(entidade, orgao, unidade) {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        data = [];
        data.push({name: 'action', value: 'LoadCronogramaMensalDesembolso'});
        data.push({name: 'entidade', value: entidade});
        data.push({name: 'orgao', value: orgao});
        data.push({name: 'unidade', value: unidade});

        $.post(UrlServiceProviderTCE,data)
            .success(function (data) {
                if (data.response == true) {
                    var cronogramas = data.content;
                    var gruposDespesa = data.gruposDespesa;
                    $('.saldo-inicial').text('R$ ' + data.saldoInicial);

                    var data = [];

                    var contador = 1;
                    for (var i in cronogramas) {
                        data.push(
                            [
                                contador,
                                cronogramas[i].descricao,
                                parseFloat(cronogramas[i].janeiro),
                                parseFloat(cronogramas[i].fevereiro),
                                parseFloat(cronogramas[i].marco),
                                parseFloat(cronogramas[i].abril),
                                parseFloat(cronogramas[i].maio),
                                parseFloat(cronogramas[i].junho),
                                parseFloat(cronogramas[i].julho),
                                parseFloat(cronogramas[i].agosto),
                                parseFloat(cronogramas[i].setembro),
                                parseFloat(cronogramas[i].outubro),
                                parseFloat(cronogramas[i].novembro),
                                parseFloat(cronogramas[i].dezembro),
                                parseFloat(cronogramas[i].janeiro) + parseFloat(cronogramas[i].fevereiro) + parseFloat(cronogramas[i].marco) + parseFloat(cronogramas[i].abril) +
                                parseFloat(cronogramas[i].maio) + parseFloat(cronogramas[i].junho) + parseFloat(cronogramas[i].julho) + parseFloat(cronogramas[i].agosto) +
                                parseFloat(cronogramas[i].setembro) + parseFloat(cronogramas[i].outubro) + parseFloat(cronogramas[i].novembro) + parseFloat(cronogramas[i].dezembro),
                                i
                            ]
                        );
                        contador++;
                    }

                    var listClassToColumns = [
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-1",
                        "dt-cell-1"
                    ];

                  renderTableList(data, gruposDespesa, listClassToColumns);
                }
            }
        );
    }
}());