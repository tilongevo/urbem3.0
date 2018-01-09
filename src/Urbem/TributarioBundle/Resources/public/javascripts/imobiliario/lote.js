$(function () {
    "use strict";

    if (UrbemSonata.giveMeBackMyField('codCadastro') == undefined) {
        return false;
    }

    var uf = UrbemSonata.giveMeBackMyField('fkSwUf'),
        municipio = UrbemSonata.giveMeBackMyField('fkSwMunicipio'),
        trecho = $("#" + UrbemSonata.uniqId + "_fkImobiliarioTrecho_autocomplete_input"),
        submitStatus = true,
        tipoLote = UrbemSonata.giveMeBackMyField('codCadastro').val(),
        codLote = UrbemSonata.giveMeBackMyField('codLote'),
        pontoCardeal = UrbemSonata.giveMeBackMyField('fkImobiliarioPontoCardeal'),
        tipo = 'trecho',
        testada = 0,
        testadaContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_principal'),
        trechoContainer = $('.fieldset-trecho'),
        loteContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkImobiliarioLote'),
        descricaoContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_descricao'),
        lote = UrbemSonata.giveMeBackMyField('fkImobiliarioLote'),
        descricao = UrbemSonata.giveMeBackMyField('descricao'),
        extensao = UrbemSonata.giveMeBackMyField('extensao'),
        area = UrbemSonata.giveMeBackMyField('area'),
        profundidadeMedia = UrbemSonata.giveMeBackMyField('profundidadeMedia');

    if (codLote.val() != '') {
        $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_seguirCadastroImovel').hide();
        $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkImobiliarioConfrontacoes').hide();
    } else {
        carregaAtributos(tipoLote);
    }

    $('input[name*="tipoLote"]').on('ifChecked', function (e) {
        tipoLote = $(this).val();
        carregaAtributos($(this).val());
    });

    function clearSelect(campo, placeholder) {
        campo.empty();
        if (placeholder) {
            campo.append('<option value="">Selecione</option>');
        }
        campo.select2('val', '');
    }

    window.varJsCodUf = uf.val();
    if (uf.val() != '') {
        carregaMunicipio(uf.val());
    }
    uf.on("change", function() {
        carregaMunicipio($(this).val());
        window.varJsCodUf = $(this).val();
    });

    window.varJsCodMunicipio = municipio.val();
    municipio.on("change", function() {
        window.varJsCodMunicipio = $(this).val();
    });

    function carregaMunicipio(codUf) {
        var selected = municipio.val();
        clearSelect(municipio, false);
        municipio.attr('disabled', true);
        $.ajax({
            url: "/tributario/logradouro/municipio",
            method: "POST",
            data: {codUf: codUf},
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, value) {
                    if (selected == index) {
                        municipio.append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        municipio.append("<option value=" + index + ">" + value + "</option>");
                    }
                });
                window.varJsCodMunicipio = selected;
                municipio.select2('val', selected);
                municipio.attr('disabled', false);
            }
        });
    }

    function carregaAtributos(codCadastro) {
        var data = {
            urbano: {
                entidade: "CoreBundle:Imobiliario\\LoteUrbano",
                getFkEntidadeAtributoValor: "getFkImobiliarioAtributoLoteUrbanoValores"
            },
            rural: {
                entidade: "CoreBundle:Imobiliario\\LoteRural",
                getFkEntidadeAtributoValor: "getFkImobiliarioAtributoLoteRuralValores"
            }
        };

        var params = {
            entidade: (codCadastro == 2) ? data.urbano.entidade : data.rural.entidade,
            fkEntidadeAtributoValor:(codCadastro == 2) ? data.urbano.getFkEntidadeAtributoValor : data.rural.getFkEntidadeAtributoValor,
            codModulo: "12",
            codCadastro: codCadastro
        };

        if(codLote.val() != 0 || codLote.val() != '') {
            params.codEntidade = {
                codLote: codLote.val()
            };
        }

        AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(params);
    }

    $('input[name*="principal"]').on('ifChecked', function (e) {
        testada = $(this).val();
    });

    loteContainer.hide();
    descricaoContainer.hide();
    uf.attr('required', false);
    municipio.attr('required', false);
    trecho.attr('required', false);
    lote.attr('required', false);
    extensao.attr('required', false);
    descricao.attr('required', false);

    $('input[name*="confrontacaoTipo"]').on('ifChecked', function (e) {
        e.stopPropagation();
        tipo = $(this).val();
        if ($(this).val() == 'trecho') {
            testadaContainer.show();
            trechoContainer.show();
            loteContainer.hide();
            descricaoContainer.hide();
        } else if ($(this).val() == 'lote') {
            testadaContainer.hide();
            trechoContainer.hide();
            loteContainer.show();
            descricaoContainer.hide();
        } else {
            testadaContainer.hide();
            trechoContainer.hide();
            loteContainer.hide();
            descricaoContainer.show();
        }
    });

    $("#manuais").on("click", function() {
        $('.sonata-ba-field-error-messages').remove();

        var col = '<tr class="tr-rh row-confrontacoes">';
        if (tipo == 'trecho') {
            if (trecho.val() == '' || extensao.val() == '') {
                return false;
            }

            var classPrincipal = '';
            if (testada == 1) {
                submitStatus = true;
                classPrincipal = ' confrontacoes-principal'
            }
            col += '<td class="td-rh confrontacoes' + classPrincipal + '">' +
                '<input type="hidden" value="' + trecho.val() + '" name="confrontacoes[trecho][trecho][]">' +
                '<input type="hidden" value="' + pontoCardeal.val() + '" name="confrontacoes[trecho][ponto_cardeal][]">' +
                '<input type="hidden" value="' + UrbemSonata.convertMoneyToFloat(extensao.val()) + '" name="confrontacoes[trecho][extensao][]">' +
                '<input type="hidden" value="' + testada + '" name="confrontacoes[trecho][principal][]">' +
                $('select#' + UrbemSonata.uniqId + '_fkImobiliarioPontoCardeal option:selected').text() +
                '</td>';
            col += '<td class="td-rh tipo">Trecho</td>';
            col += '<td class="td-rh descricao">' + trecho.select2('data').label + '</td>';
        } else if (tipo == 'lote') {
            if (lote.val() == '' || extensao.val() == '') {
                return false;
            }
            col += '<td class="td-rh confrontacoes">' +
                '<input type="hidden" value="' + lote.val() + '" name="confrontacoes[lote][lote][]">' +
                '<input type="hidden" value="' + pontoCardeal.val() + '" name="confrontacoes[lote][ponto_cardeal][]">' +
                '<input type="hidden" value="' + UrbemSonata.convertMoneyToFloat(extensao.val()) + '" name="confrontacoes[lote][extensao][]">' +
                '<input type="hidden" value="0" name="confrontacoes[lote][principal][]">' +
                $('select#' + UrbemSonata.uniqId + '_fkImobiliarioPontoCardeal option:selected').text() +
                '</td>';
            col += '<td class="td-rh tipo">Lote</td>';
            col += '<td class="td-rh descricao">' + $('select#' + UrbemSonata.uniqId + '_fkImobiliarioLote option:selected').text() + '</td>';
        } else {
            if (descricao.val() == '' || extensao.val() == '') {
                return false;
            }
            col += '<td class="td-rh confrontacoes">' +
                '<input type="hidden" value="' + descricao.val() + '" name="confrontacoes[diversa][diversa][]">' +
                '<input type="hidden" value="' + pontoCardeal.val() + '" name="confrontacoes[diversa][ponto_cardeal][]">' +
                '<input type="hidden" value="' + UrbemSonata.convertMoneyToFloat(extensao.val()) + '" name="confrontacoes[diversa][extensao][]">' +
                '<input type="hidden" value="0" name="confrontacoes[diversa][principal][]">' +
                $('select#' + UrbemSonata.uniqId + '_fkImobiliarioPontoCardeal option:selected').text() +
                '</td>';
            col += '<td class="td-rh tipo">Outros</td>';
            col += '<td class="td-rh descricao">' + descricao.val() + '</td>';
        }
        col += '<td class="td-rh extensao">' + extensao.val() + '</td>';
        col += '<td class="td-rh testada">' + ((testada == 1 && tipo == 'trecho') ? "Sim" : "Não") + '</td>';
        col += '<td class="td-rh remove"><i class="material-icons blue-text text-darken-4">delete</i></td>';
        col += '</tr>';

        $('#tableConfrontacoesManuais').append(col);

        pontoCardeal.select2('val', 0);
        lote.select2('val', '');
        trecho.select2('val', '');

        $('input[name*="confrontacaoTipo"][value="trecho"]').iCheck('check');
        $('input[name*="confrontacaoTipo"][value="lote"]').iCheck('uncheck');
        $('input[name*="confrontacaoTipo"][value="outros"]').iCheck('uncheck');
        $('input[name*="confrontacaoTipo"][value="outros"]').trigger('chenge');

        $('input[name*="principal"][value="0"]').iCheck('check');
        $('input[name*="principal"][value="1"]').iCheck('uncheck');
        extensao.val('');
        descricao.val('');

        $('.empty-row-confrontacoes').hide();
    });

    $(document).on('click', '.remove', function () {
        $(this).parent().remove();
        if ($(".confrontacoes-principal").length <= 0) {
            submitStatus = false;
        }
        if ($(".row-confrontacoes").length <= 0) {
            submitStatus = false;
            $('.empty-row-confrontacoes').show();
        }
    });

    area.on('change', function () {
        $(this).parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
    });

    profundidadeMedia.on('change', function () {
        $(this).parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
    });

    $('form').submit(function() {
        if (parseInt(area.val()) <= 0) {
            UrbemSonata.setFieldErrorMessage('area', 'O valor deve ser maior que zero!', area.parent());
            activeTab(1);
            return false;
        }
        if (parseInt(profundidadeMedia.val()) <= 0) {
            UrbemSonata.setFieldErrorMessage('profundidadeMedia', 'O valor deve ser maior que zero!', profundidadeMedia.parent());
            activeTab(1);
            return false;
        }
        if ($(".row-confrontacoes").length <= 0 || $(".confrontacoes-principal").length <= 0) {
            var message = '<div class="help-block sonata-ba-field-error-messages">' +
                '<ul class="list-unstyled">' +
                '<li><i class="fa fa-exclamation-circle"></i>  Deve haver ao menos uma confrontação de trecho definida como testada!</li>' +
                '</ul></div>';
            pontoCardeal.after(message);
            activeTab(2);
            return false;
        }
        return submitStatus;
    });

    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkImobiliarioPontoCardeal').on('mouseover', function () {
        $('.sonata-ba-field-error-messages').remove();
    });
    extensao.on('mouseover', function () {
        $('.sonata-ba-field-error-messages').remove();
    });

    UrbemSonata.giveMeBackMyField('fkImobiliarioLocalizacao').on('change', function () {
        if ($(this).val() != '' && UrbemSonata.giveMeBackMyField('numLote').val() != '') {
            verificaLoteLocalizacaoValor($(this).val(), UrbemSonata.giveMeBackMyField('numLote').val());
        }
    });

    UrbemSonata.giveMeBackMyField('numLote').on('change', function () {
        if ($(this).val() != '' && UrbemSonata.giveMeBackMyField('fkImobiliarioLocalizacao').val() != '') {
            verificaLoteLocalizacaoValor(UrbemSonata.giveMeBackMyField('fkImobiliarioLocalizacao').val(), $(this).val());
        }
    });

    function verificaLoteLocalizacaoValor(codLocalizacao, valor) {
        var numLote = UrbemSonata.giveMeBackMyField('numLote');
        submitStatus = false;
        $('.sonata-ba-field-error-messages').remove();
        $.ajax({
            url: "/tributario/cadastro-imobiliario/lote/consultar-lote-localizacao-valor",
            method: "POST",
            data: {codLocalizacao: codLocalizacao, valor: valor},
            dataType: "json",
            success: function (data) {
                if (data) {
                    numLote.val('');
                    var message = '<div class="help-block sonata-ba-field-error-messages">' +
                        '<ul class="list-unstyled">' +
                        '<li><i class="fa fa-exclamation-circle"></i>  Número do lote já cadastrado nesta localização!</li>' +
                        '</ul></div>';
                    numLote.after(message);
                } else {
                    submitStatus = true;
                }
            }
        });
    }

    function activeTab(identificador) {
        $('a[href^="#tab_' + UrbemSonata.uniqId + '"]').parent().removeClass('active');

        $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').attr('aria-expanded', true);
        $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').find('.has-errors').removeClass('hide');
        $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').parent().addClass('active');

        $('.tab-pane').removeClass('active in');
        $('#tab_' + UrbemSonata.uniqId + '_' + identificador).addClass('active in');
    }
}());
