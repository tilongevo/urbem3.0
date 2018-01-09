$(document).ready(function() {
    'use strict';

    var orgao = $("select#" + UrbemSonata.uniqId + "_unidadeExecutoraCodOrgao"),
        unidade = $("select#" + UrbemSonata.uniqId + "_unidadeExecutoraCodUnidade"),
        ppa = $("select#" + UrbemSonata.uniqId + "_ppa"),
        programa = $("select#" + UrbemSonata.uniqId + "_fkPpaPrograma"),
        tipo = $('input[name="' + UrbemSonata.uniqId + '[tipoTipoAcao]"]'),
        subTipo = $("select#" + UrbemSonata.uniqId + "_dadosTipoAcao"),
        numAcao = $("#" + UrbemSonata.uniqId + "_numAcao"),
        exercicio = $("#" + UrbemSonata.uniqId + "_exercicio"),
        filterPpa = $("select#filter_fkPpaPrograma__fkPpaProgramaSetorial__fkPpaMacroObjetivo__fkPpaPpa_value"),
        filterPrograma = $("select#filter_fkPpaPrograma_value"),
        filterTipoOrcamentaria = $("#filter_tipoAcao_value_0"),
        filterTipoNaoOrcamentaria = $("#filter_tipoAcao_value_1"),
        filterSubTipo = $("select#filter_fkPpaAcaoDados__fkPpaTipoAcao_value");

    unidade.attr('disabled', true);
    orgao.on("change", function() {
        if ($(this).val() == '') {
            limparUnidades();
            unidade.select2('val', '');
            unidade.attr('disabled', true);
        } else {
            carregarUnidades($(this).val());
        }
    });

    function limparUnidades() {
        unidade
            .empty()
            .append('<option value="">Selecione</option>');
    }

    if (orgao.val() == '') {
        limparUnidades();
        unidade.select2('val', '');
        unidade.attr('disabled', true);
    } else {
        carregarUnidades(orgao.val());
    }

    function carregarUnidades(codOrgao) {
        unidade.attr('disabled', true);
        $.ajax({
            url: "/financeiro/plano-plurianual/acao/consultar-unidades",
            method: "POST",
            data: {codOrgao: codOrgao},
            dataType: "json",
            success: function (data) {
                var selected = unidade.val();
                limparUnidades();
                $.each(data, function (index, value) {
                    if (index == selected) {
                        unidade.append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        unidade.append("<option value=" + index + ">" + value + "</option>");
                    }
                });
                unidade.select2("val", selected);
                unidade.attr('disabled', false);
            }
        });
    }

    function limpar(campo, option) {
        campo.empty();
        if (option) {
            campo.append('<option value="">Selecione</option>');
        }
    }

    filterPrograma.attr('disabled', true);
    programa.attr('disabled', true);
    ppa.on("change", function() {
        if ($(this).val() == '') {
            limpar(programa, true);
            programa.select2('val', '');
            programa.attr('disabled', true);
        } else {
            carregarProgramas($(this).val());
        }
    });

    filterPpa.on("change", function() {
        if ($(this).val() == '') {
            limpar(filterPrograma, false);
            filterPrograma.select2('val', '');
            filterPrograma.attr('disabled', true);
        } else {
            carregarfilterProgramas($(this).val());
        }
    });

    if (filterPpa.val() == '') {
        limpar(filterPrograma, false);
    } else {
        carregarfilterProgramas(filterPpa.val());
    }

    if (ppa.val() == '') {
        limpar(programa, true);
        programa.select2('val', '');
        programa.attr('disabled', true);
    } else {
        carregarProgramas(ppa.val());
    }

    function carregarProgramas(codPpa) {
        programa.attr('disabled', true);
        $.ajax({
            url: "/financeiro/plano-plurianual/acao/consultar-programas",
            method: "POST",
            data: {codPpa: codPpa},
            dataType: "json",
            success: function (data) {
                var selected = programa.val();
                limpar(programa, true);
                $.each(data, function (index, value) {
                    if (index == selected) {
                        programa.append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        programa.append("<option value=" + index + ">" + value + "</option>");
                    }
                });
                programa.select2("val", selected);
                programa.attr('disabled', false);
            }
        });
    }

    function carregarfilterProgramas(codPpa) {
        filterPrograma.attr('disabled', true);
        $.ajax({
            url: "/financeiro/plano-plurianual/acao/consultar-programas",
            method: "POST",
            data: {codPpa: codPpa},
            dataType: "json",
            success: function (data) {
                var selected = filterPrograma.val();
                limpar(filterPrograma, false);
                $.each(data, function (index, value) {
                    if (index == selected) {
                        filterPrograma.append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        filterPrograma.append("<option value=" + index + ">" + value + "</option>");
                    }
                });
                filterPrograma.select2("val", selected);
                filterPrograma.attr('disabled', false);
            }
        });
    }

    function limparSubTipos(campo, placeholder) {
        campo.empty();
        if (placeholder) {
            campo.append('<option value="">Selecione</option>');
        }
    }

    if ((tipo.val() != '') && (tipo.val() != undefined)) {
        carregarSubTipos(tipo.val(), subTipo, true);
    }
    tipo.on('ifChecked', function() {
        carregarSubTipos($(this).val(), subTipo, true);
    });

    function carregarSubTipos(codTipo, campo, placeholder) {
        campo.attr('disabled', true);
        $.ajax({
            url: "/financeiro/plano-plurianual/acao/consultar-subtipos",
            method: "POST",
            data: {codTipo: codTipo},
            dataType: "json",
            success: function (data) {
                var selected = campo.val();
                limparSubTipos(campo, placeholder);
                $.each(data, function (index, value) {
                    if (selected == index) {
                        campo.append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        campo.append("<option value=" + index + ">" + value + "</option>");
                    }
                });
                campo.select2("val", selected);
                campo.attr('disabled', false);
            }
        });
    }

    if ((programa.val() == '') && (subTipo.val() == '')) {
        UrbemSonata.sonataPanelHide('_periodoDataInicio', false);
    } else {
        showHidePeriodoAcao(programa.val(), subTipo.val());
    }

    programa.on("change", function() {
        if (subTipo.val() != '') {
            showHidePeriodoAcao($(this).val(), subTipo.val());
        }
    });

    subTipo.on("change", function() {
        if (programa.val() != '') {
            showHidePeriodoAcao(programa.val(), $(this).val());
        } else {
            UrbemSonata.sonataPanelHide('_periodoDataInicio', false);
        }
    });

    function showHidePeriodoAcao(codPrograma, codTipo) {
        $.ajax({
            url: "/financeiro/plano-plurianual/acao/consultar-natureza-temporal",
            method: "POST",
            data: {codPrograma: codPrograma, codTipo: codTipo},
            dataType: "json",
            success: function (data) {
                if (data.continuo) {
                    UrbemSonata.sonataPanelShow('_periodoDataInicio', true);
                } else {
                    UrbemSonata.sonataPanelHide('_periodoDataInicio', false);
                }
            }
        });
    }

    if (filterTipoOrcamentaria.attr('checked') != undefined) {
        carregarSubTipos(filterTipoOrcamentaria.val(), filterSubTipo, false);
    } else if (filterTipoNaoOrcamentaria.attr('checked') != undefined) {
        carregarSubTipos(filterTipoNaoOrcamentaria.val(), filterSubTipo, false);
    } else {
        filterSubTipo.attr('disabled', true);
    }

    filterTipoOrcamentaria.on('ifChecked', function() {
        carregarSubTipos($(this).val(), filterSubTipo, false);
    });

    filterTipoNaoOrcamentaria.on('ifChecked', function() {
        carregarSubTipos($(this).val(), filterSubTipo, false);
    });

    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }

    function verificaNumAcao(subTipo, exercicio, numAcao, campo) {
        $.ajax({
            url: "/financeiro/plano-plurianual/acao/consultar-num-acao",
            method: "POST",
            data: {codTipo: subTipo, exercicio: exercicio, numAcao: numAcao},
            dataType: "json",
            success: function (data) {
                $('.sonata-ba-field-error-messages').remove();
                var message = '<div class="help-block sonata-ba-field-error-messages"><ul class="list-unstyled">';
                if (!data.digito) {
                    message += '<li><i class="fa fa-exclamation-circle"></i> O Código ' + pad(numAcao, 4) + ' não pertence ao subtipo da ação selecionado!</li>';
                }

                if (data.existe) {
                    message += '<li><i class="fa fa-exclamation-circle"></i> O Código ' + pad(numAcao, 4) + ' já está cadastrado no sistema!</li>';
                }
                message += '</ul></div>';
                campo.after(message);
            }
        });
    }

    numAcao.on('change', function(){
        if (subTipo.val() != '') {
            verificaNumAcao(subTipo.val(), exercicio.val(), $(this).val(), numAcao)
        }
    });

    subTipo.on('change', function(){
        if (numAcao.val() != '') {
            verificaNumAcao($(this).val(), exercicio.val(), numAcao.val(), numAcao)
        }
    });

    $.each($('.fontes-recurso'), function(){
        $(this).hide();
    });
    $.each($('.btn_fontes_recurso'), function(){
        $(this).html('add');
    });

    $(".btn_fontes_recurso").on("click", function() {
        var codRecurso = $(this).attr('data-codRecurso');

        if ( $(this).html() == 'add' ) {
            $('#fontesRecurso_' + codRecurso).show();
            $(this).html('remove');
        } else {
            $('#fontesRecurso_' + codRecurso).hide();
            $(this).html('add');
        }
        return false;
    });

    $(document).on('click', '.btn_fontes_recurso', function() {
        var codRecurso = $(this).attr('data-codRecurso');

        if ($(this).html() == 'add') {
            $('#fontesRecurso_' + codRecurso).show();
            $(this).html('remove');
        } else {
            $('#fontesRecurso_' + codRecurso).hide();
            $(this).html('add');
        }
        return false;
    });

    $(document).on('click', '.remove', function () {
        var ano;
        for (ano = 1; ano <= 4; ano++) {
            var totalAno = parseFloat($('#total-ano-' + ano).val()) - UrbemSonata.convertMoneyToFloat($('#acaoRecurso' + $(this).attr('recurso') + '-valor' + ano).val());
            $('#total-ano-' + ano).val(totalAno);
            $('#valor-ano-' + ano).html('R$' + UrbemSonata.convertFloatToMoney(totalAno));
        }
        var total = parseFloat($('#total-ano-1').val()) + parseFloat($('#total-ano-2').val()) + parseFloat($('#total-ano-3').val()) + parseFloat($('#total-ano-4').val());
        $('#total').val(total);
        $('#valor-total').html('R$' + UrbemSonata.convertFloatToMoney(total));

        if (total == 0) {
            $('.acao-recurso').hide();
        }

        $('#fontesRecurso_' + $(this).attr('recurso')).remove();
        $(this).parent().remove();
    });

    $(".money").on("change", function() {
        if ($(this).val() == '') {
            $(this).val('0,00');
        }
        if ($(this).val().indexOf(',') < 0) {
            $(this).val($(this).val() + ',00');
        }
    });

    if (UrbemSonata.giveMeBackMyField('codRecurso')) {
        UrbemSonata.giveMeBackMyField('codRecurso').on('click', function () {
            $(this).parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
            $('.sonata-ba-field-error-messages').remove();
            return false;
        });
    }

    $('input.recurso-valores').on('click', function () {
        $(this).parent().parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
        return false;
    });

    $("#manuais").on("click", function() {
        var recurso = UrbemSonata.giveMeBackMyField('codRecurso'),
            vlAno1 = UrbemSonata.convertMoneyToFloat(UrbemSonata.giveMeBackMyField('valor1').val()),
            vlAno2 = UrbemSonata.convertMoneyToFloat(UrbemSonata.giveMeBackMyField('valor2').val()),
            vlAno3 = UrbemSonata.convertMoneyToFloat(UrbemSonata.giveMeBackMyField('valor3').val()),
            vlAno4 = UrbemSonata.convertMoneyToFloat(UrbemSonata.giveMeBackMyField('valor4').val());

        if ($('#acaoRecurso_' + recurso.val()).val() != undefined) {
            UrbemSonata.setFieldErrorMessage('codRecurso', 'Recurso já incluído para esta ação!', recurso.parent());
            return false;
        }

        if (recurso.val() != '') {
            if ((vlAno1) || (vlAno2) || (vlAno3) || (vlAno4)) {
                var totalAno1 = parseFloat($('#total-ano-1').val()) + vlAno1,
                    totalAno2 = parseFloat($('#total-ano-2').val()) + vlAno2,
                    totalAno3 = parseFloat($('#total-ano-3').val()) + vlAno3,
                    totalAno4 = parseFloat($('#total-ano-4').val()) + vlAno4,
                    total = totalAno1 + totalAno2 + totalAno3 + totalAno4;

                $('#valor-ano-1').html('R$' + UrbemSonata.convertFloatToMoney(totalAno1));
                $('#total-ano-1').val(totalAno1);
                $('#valor-ano-2').html('R$' + UrbemSonata.convertFloatToMoney(totalAno2));
                $('#total-ano-2').val(totalAno2);
                $('#valor-ano-3').html('R$' + UrbemSonata.convertFloatToMoney(totalAno3));
                $('#total-ano-3').val(totalAno3);
                $('#valor-ano-4').html('R$' + UrbemSonata.convertFloatToMoney(totalAno4));
                $('#total-ano-4').val(totalAno4);
                $('#valor-total').html('R$' + UrbemSonata.convertFloatToMoney(total));
                $('#total').val(total);

                var linha =
                    '<tr class="tr-rh">' +
                    '<td class="td-rh">' +
                    '<i data-codRecurso="' + recurso.val() + '" class="material-icons btn_fontes_recurso blue-text text-darken-4" style="cursor: pointer">remove</i>' +
                    '<input type="hidden" value="" id="acaoRecurso_' + recurso.val() + '" name="acaoRecurso[' + recurso.val() + ']" />' +
                    '</td>' +
                    '<td class="td-rh">' + $('select#' + UrbemSonata.uniqId + '_codRecurso option:selected').text() + '</td>' +
                    '<td class="td-rh">' +
                    '<div class="sonata-ba-field sonata-ba-field-standard-natural">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon">R$</span><input type="text" id="acaoRecurso' + recurso.val() + '-valor1" name="acaoRecurso[' + recurso.val() + '][valor1]" class="acao-recurso-valor money campo-sonata form-control" value="' + UrbemSonata.giveMeBackMyField('valor1').val() + '" recurso="' + recurso.val() + '" ano="1">' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td class="td-rh">' +
                    '<div class="sonata-ba-field sonata-ba-field-standard-natural">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon">R$</span><input type="text" id="acaoRecurso' + recurso.val() + '-valor2" name="acaoRecurso[' + recurso.val() + '][valor2]" class="acao-recurso-valor money campo-sonata form-control" value="' + UrbemSonata.giveMeBackMyField('valor2').val() + '" recurso="' + recurso.val() + '" ano="2">' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td class="td-rh">' +
                    '<div class="sonata-ba-field sonata-ba-field-standard-natural">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon">R$</span><input type="text" id="acaoRecurso' + recurso.val() + '-valor3" name="acaoRecurso[' + recurso.val() + '][valor3]" class="acao-recurso-valor money campo-sonata form-control" value="' + UrbemSonata.giveMeBackMyField('valor3').val() + '" recurso="' + recurso.val() + '" ano="3">' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td class="td-rh">' +
                    '<div class="sonata-ba-field sonata-ba-field-standard-natural">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon">R$</span><input type="text" id="acaoRecurso' + recurso.val() + '-valor4" name="acaoRecurso[' + recurso.val() + '][valor4]" class="acao-recurso-valor money campo-sonata form-control" value="' + UrbemSonata.giveMeBackMyField('valor4').val() + '" recurso="' + recurso.val() + '" ano="4">' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td class="td-rh"><span id="vlTotal_' + recurso.val() + '">R$' + UrbemSonata.convertFloatToMoney(vlAno1 + vlAno2 + vlAno3 + vlAno4) + '</span></td>' +
                    '<td recurso="' + recurso.val() + '" class="td-rh remove"><i class="material-icons blue-text text-darken-4" style="cursor: pointer">delete</i></td>' +
                    '</tr>' +
                    '<tr class="tr-rh fontes-recurso" id="fontesRecurso_' + recurso.val() + '">' +
                    '<td></td>' +
                    '<td colspan="7">' +
                    '<h4 class="col s10 box-title left-align show">Metas Físicas</h4>' +
                    '<div class="divider grey lighten-1  title-divider"></div>' +
                    '<table>' +
                    '<tr class="tr-rh">' +
                    '<th class="th-rh"></th>' +
                    '<th class="th-rh">Quantidade</th>' +
                    '<th class="th-rh">Valor Total</th>' +
                    '</tr>' +
                    '<tr class="tr-rh">' +
                    '<td class="td-rh">1º Ano do PPA</td>' +
                    '<td class="td-rh">' +
                    '<div class="sonata-ba-field sonata-ba-field-standard-natural">' +
                    '<div class="input-group">' +
                    '<input type="text" id="acaoRecurso' + recurso.val() + '-quantidade1" name="acaoRecurso[' + recurso.val() + '][quantidade1]" class="acao-recurso-quantidade money campo-sonata form-control" value="0,00"  recurso="' + recurso.val() + '" ano="1">' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td class="td-rh"><span id="acaoRecurso' + recurso.val() + '-ano1">R$' + UrbemSonata.convertFloatToMoney(vlAno1) + '</span></td>' +
                    '</tr>' +
                    '<tr class="tr-rh">' +
                    '<td class="td-rh">2º Ano do PPA</td>' +
                    '<td class="td-rh">' +
                    '<div class="sonata-ba-field sonata-ba-field-standard-natural">' +
                    '<div class="input-group">' +
                    '<input type="text" id="acaoRecurso' + recurso.val() + '-quantidade2" name="acaoRecurso[' + recurso.val() + '][quantidade2]" class="acao-recurso-quantidade money campo-sonata form-control" value="0,00"  recurso="' + recurso.val() + '" ano="2">' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td class="td-rh"><span id="acaoRecurso' + recurso.val() + '-ano2">R$' + UrbemSonata.convertFloatToMoney(vlAno2) + '</span></td>' +
                    '</tr>' +
                    '<tr class="tr-rh">' +
                    '<td class="td-rh">3º Ano do PPA</td>' +
                    '<td class="td-rh">' +
                    '<div class="sonata-ba-field sonata-ba-field-standard-natural">' +
                    '<div class="input-group">' +
                    '<input type="text" id="acaoRecurso' + recurso.val() + '-quantidade3" name="acaoRecurso[' + recurso.val() + '][quantidade3]" class="acao-recurso-quantidade money campo-sonata form-control" value="0,00"  recurso="' + recurso.val() + '" ano="3">' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td class="td-rh"><span id="acaoRecurso' + recurso.val() + '-ano3">R$' + UrbemSonata.convertFloatToMoney(vlAno3) + '</span></td>' +
                    '</tr>' +
                    '<tr class="tr-rh">' +
                    '<td class="td-rh">4º Ano do PPA</td>' +
                    '<td class="td-rh">' +
                    '<div class="sonata-ba-field sonata-ba-field-standard-natural">' +
                    '<div class="input-group">' +
                    '<input type="text" id="acaoRecurso' + recurso.val() + '-quantidade4" name="acaoRecurso[' + recurso.val() + '][quantidade4]" class="acao-recurso-quantidade money campo-sonata form-control" value="0,00"  recurso="' + recurso.val() + '" ano="4">' +
                    '</div>' +
                    '</div>' +
                    '</td>' +
                    '<td class="td-rh"><span id="acaoRecurso' + recurso.val() + '-ano4">R$' + UrbemSonata.convertFloatToMoney(vlAno4) + '</span></td>' +
                    '</tr>' +
                    '<tr class="tr-rh">' +
                    '<td class="td-rh">Total</td>' +
                    '<td class="td-rh"><span id="qntTotal_' + recurso.val() + '">0,00</span></td>' +
                    '<td class="td-rh"><span id="vlTotalMf_' + recurso.val() + '">R$' + UrbemSonata.convertFloatToMoney(vlAno1 + vlAno2 + vlAno3 + vlAno4) + '</span></td>' +
                    '</tr>' +
                    '</table>' +
                    '</td>' +
                    '</tr>';

                $('.acao-recurso').show();

                $.each($('.fontes-recurso'), function () {
                    $(this).hide();
                });
                $.each($('.btn_fontes_recurso'), function () {
                    $(this).html('add');
                });

                $('.fontes-recurso-totais').before(linha);

                recurso.select2('val', '');
                UrbemSonata.giveMeBackMyField('valor1').val('0,00');
                UrbemSonata.giveMeBackMyField('valor2').val('0,00');
                UrbemSonata.giveMeBackMyField('valor3').val('0,00');
                UrbemSonata.giveMeBackMyField('valor4').val('0,00');

                $.each($('.money'), function () {
                    var val = $(this).val();
                    if (val != '') {
                        if (val.indexOf(',') == -1) {
                            val = val + ',00';
                        }

                        if (val.indexOf(',') != -1) {
                            val = val.padRight(val.indexOf(',') + 3);
                        }

                        $(this).val(val);
                    }
                    $(this).mask('#.##0,00', {reverse: true});
                    $(this).on("change", function () {
                        if ($(this).val() == '') {
                            $(this).val('0,00');
                        }
                        if ($(this).val().indexOf(',') < 0) {
                            $(this).val($(this).val() + ',00');
                        }
                    });
                });
            } else {
                UrbemSonata.setFieldErrorMessage('codRecurso', 'O total do recurso não pode ser 0!', UrbemSonata.giveMeBackMyField('valor1').parent().parent());
                return false;
            }
        }else {
            UrbemSonata.setFieldErrorMessage('codRecurso', 'Campo Recurso obrigatório!', recurso.parent());
            return false;
        }
    });

    $(document).on('change', '.acao-recurso-valor', function () {
        var ano = $(this).attr('ano'),
            codRecurso = $(this).attr('recurso'),
            totalAno = 0;
        $('#acaoRecurso' + codRecurso + '-ano' + ano).html('R$' + $(this).val());
        $.each($('.acao-recurso-valor'), function() {
            if ($(this).attr('ano') == ano) {
                totalAno += UrbemSonata.convertMoneyToFloat($(this).val());
            }
        });

        $('#total-ano-' + ano).val(totalAno);
        $('#valor-ano-' + ano).html('R$' + UrbemSonata.convertFloatToMoney(totalAno));
        var totalRecurso = UrbemSonata.convertMoneyToFloat($('#acaoRecurso' + $(this).attr('recurso') + '-valor1').val());
        totalRecurso += UrbemSonata.convertMoneyToFloat($('#acaoRecurso' + $(this).attr('recurso') + '-valor2').val());
        totalRecurso += UrbemSonata.convertMoneyToFloat($('#acaoRecurso' + $(this).attr('recurso') + '-valor3').val());
        totalRecurso += UrbemSonata.convertMoneyToFloat($('#acaoRecurso' + $(this).attr('recurso') + '-valor4').val());
        $('#vlTotal_' + codRecurso).html('R$' + UrbemSonata.convertFloatToMoney(totalRecurso));
        $('#vlTotalMf_' + codRecurso).html('R$' + UrbemSonata.convertFloatToMoney(totalRecurso));
        var total = parseFloat($('#total-ano-1').val()) + parseFloat($('#total-ano-2').val()) + parseFloat($('#total-ano-3').val()) + parseFloat($('#total-ano-4').val());
        $('#total').val(total);
        $('#valor-total').html('R$' + UrbemSonata.convertFloatToMoney(total));
    });

    $(document).on('change', '.acao-recurso-quantidade', function () {
        var totalQuantidade = UrbemSonata.convertMoneyToFloat($('#acaoRecurso' + $(this).attr('recurso') + '-quantidade1').val());
        totalQuantidade += UrbemSonata.convertMoneyToFloat($('#acaoRecurso' + $(this).attr('recurso') + '-quantidade2').val());
        totalQuantidade += UrbemSonata.convertMoneyToFloat($('#acaoRecurso' + $(this).attr('recurso') + '-quantidade3').val());
        totalQuantidade += UrbemSonata.convertMoneyToFloat($('#acaoRecurso' + $(this).attr('recurso') + '-quantidade4').val());
        $('#qntTotal_' + $(this).attr('recurso')).html(UrbemSonata.convertFloatToMoney(totalQuantidade));
    });

    $( "form" ).submit(function() {
        if ($('.fontes-recurso').length == 0) {
            UrbemSonata.setFieldErrorMessage('codRecurso', 'Fonte de recurso obrigatória!', UrbemSonata.giveMeBackMyField('codRecurso').parent());
            return false;
        }
        return true;
    });

    function getMessage(context, inputId, textMessage)
    {
        var message = null;
        $(".alert_error").remove();
        context.addClass('sonata-ba-field-error');
        message =
            '<div class="help-block sonata-ba-field-error-messages alert_error alert_error_' + inputId + '"> ' +
            '<ul class="list-unstyled"><li><i class="fa fa-exclamation-circle"></i> ' + textMessage + ' </li></ul> ' +
            '</div>';
        context.append(message);
        return;
    }
}());