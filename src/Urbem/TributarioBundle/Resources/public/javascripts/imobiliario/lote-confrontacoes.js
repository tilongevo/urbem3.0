$(function () {
    "use strict";

    var uf = UrbemSonata.giveMeBackMyField('fkSwUf'),
        municipio = UrbemSonata.giveMeBackMyField('fkSwMunicipio'),
        trecho = $("#" + UrbemSonata.uniqId + "_fkImobiliarioTrecho_autocomplete_input"),
        lote = UrbemSonata.giveMeBackMyField('fkImobiliarioLote'),
        descricao = UrbemSonata.giveMeBackMyField('descricao'),
        pontoCardeal = UrbemSonata.giveMeBackMyField('fkImobiliarioPontoCardeal'),
        extensao = UrbemSonata.giveMeBackMyField('extensao'),
        trechoContainer = $('.fieldset-trecho'),
        loteContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkImobiliarioLote'),
        descricaoContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_descricao'),
        tipo = 'trecho',
        testada = 0,
        submitStatus = true;

    loteContainer.hide();
    descricaoContainer.hide();

    uf.attr('required', false);
    municipio.attr('required', false);
    trecho.attr('required', false);
    lote.attr('required', false);
    extensao.attr('required', false);
    descricao.attr('required', false);

    $('input[name*="principal"]').on('ifChecked', function (e) {
        e.stopPropagation();
        testada = $(this).val();
    });

    $('input[name*="confrontacaoTipo"]').on('ifChecked', function (e) {
        e.stopPropagation();
        tipo = $(this).val();
        if ($(this).val() == 'trecho') {
            trechoContainer.show();
            loteContainer.hide();
            descricaoContainer.hide();
        } else if ($(this).val() == 'lote') {
            trechoContainer.hide();
            loteContainer.show();
            descricaoContainer.hide();
        } else {
            trechoContainer.hide();
            loteContainer.hide();
            descricaoContainer.show();
        }
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

    pontoCardeal.on('click', function () {
        $('.sonata-ba-field-error-messages').remove();
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

    $('form').submit(function() {
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

    function activeTab(identificador) {
        $('a[href^="#tab_' + UrbemSonata.uniqId + '"]').parent().removeClass('active');

        $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').attr('aria-expanded', true);
        $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').find('.has-errors').removeClass('hide');
        $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').parent().addClass('active');

        $('.tab-pane').removeClass('active in');
        $('#tab_' + UrbemSonata.uniqId + '_' + identificador).addClass('active in');
    }
}());