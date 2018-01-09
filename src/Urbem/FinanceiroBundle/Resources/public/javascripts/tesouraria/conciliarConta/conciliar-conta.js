$(function () {
    "use strict";

    var dtMovimentacao = $('#manuais_dtMovimentacao'),
        vlMovimentacao = $('#manuais_vlMovimentacao'),
        tipoMovimentacaoEntradas = $('#manuais_tipoMovimentacao_0'),
        tipoMovimentacaoSaidas = $('#manuais_tipoMovimentacao_1'),
        descricao = $('#manuais_descricao'),
        saldoTesouraria = UrbemSonata.giveMeBackMyField('saldoTesouraria'),
        saldoConciliado = UrbemSonata.giveMeBackMyField('saldoConciliado'),
        filterCodPlanoDe = $('#filter_codPlanoDe_value'),
        filterCodPlanoAte = $('#filter_codPlanoAte_value'),
        filterMes = $('select#filter_mes_value'),
        filterDtExtrato = $('#filter_dtExtrato_value');

    if ( saldoTesouraria != undefined ) saldoTesouraria.val(UrbemSonata.convertFloatToMoney(saldoTesouraria.attr('data-custom')));
    if ( saldoConciliado != undefined ) saldoConciliado.val(UrbemSonata.convertFloatToMoney(saldoConciliado.attr('data-custom')));

    filterDtExtrato.on('change', function(){
        var dtExtrato = $(this).val();
        if (parseInt(dtExtrato.substr(3, 2)) != filterMes.val()) {
            filterDtExtrato.val('');
            $('.sonata-ba-field-error-messages').remove();
            $('#dp_filter_dtExtrato_value').after(
                '<div class="help-block sonata-ba-field-error-messages">' +
                '<ul class="list-unstyled">' +
                '<li><i class="fa fa-exclamation-circle"></i> A data do extrato deve ser no mês informado!</li>' +
                '</ul>' +
                '</div>'
            );
        }
    });

    filterDtExtrato.on('click', function(){
        $('.sonata-ba-field-error-messages').remove();
    });

    filterCodPlanoDe.on('change', function () {
        filterCodPlanoAte.val($(this).val());
    });

    $(document).on('click', '.conciliar', function () {
        if ($(this).is(":checked")) {
            var soma = parseFloat(saldoConciliado.attr('data-custom')) - parseFloat($(this).attr('data-custom'));
            saldoConciliado.attr('data-custom', soma);
            saldoConciliado.val(UrbemSonata.convertFloatToMoney(soma));
        } else {
            var subtracao = parseFloat(saldoConciliado.attr('data-custom')) + parseFloat($(this).attr('data-custom'));
            saldoConciliado.attr('data-custom', subtracao);
            saldoConciliado.val(UrbemSonata.convertFloatToMoney(subtracao));
        }
    });

    $('.conciliar').on('ifChecked', function () {
        var soma = parseFloat(saldoConciliado.attr('data-custom')) - parseFloat($(this).attr('data-custom'));
        saldoConciliado.attr('data-custom', soma);
        saldoConciliado.val(UrbemSonata.convertFloatToMoney(soma));
    });

    $('.conciliar').on('ifUnchecked', function () {
        var subtracao = parseFloat(saldoConciliado.attr('data-custom')) + parseFloat($(this).attr('data-custom'));
        saldoConciliado.attr('data-custom', subtracao);
        saldoConciliado.val(UrbemSonata.convertFloatToMoney(subtracao));
    });

    tipoMovimentacaoEntradas.attr('checked', 'checked');

    $("#manuais").on("click", function() {
        var tipoMovimentacao = 'C';
        var valor = 0.00;
        var sinal = '';
        if (tipoMovimentacaoSaidas.is(":checked")) {
            tipoMovimentacao = 'D';
            valor = UrbemSonata.convertMoneyToFloat(vlMovimentacao.val()) * -1;
            sinal = '-';
        } else {
            valor = UrbemSonata.convertMoneyToFloat(vlMovimentacao.val());
        }

        if (dtMovimentacao.val() != '' && (vlMovimentacao.val() != '' && vlMovimentacao.val() != '0,00') && descricao.val() != '') {
            var linha =
                '<tr>' +
                '<td style=\"display: none\"><input name=\"manuais_lancamentos[]\" type=\"hidden\" value=\"' + dtMovimentacao.val() + '~' + tipoMovimentacao + '~' + valor + '~' + descricao.val() + '~0' + '\" /></td>' +
                '<td>' + dtMovimentacao.val() + '</td>' +
                '<td>' + descricao.val() + '</td>' +
                '<td>' + sinal + 'R$' + vlMovimentacao.val() + '</td>' +
                '<td></td>' +
                '<td><input class=\"conciliar\" data-custom=\"' + valor + '\" type=\"checkbox\" name=\"manuais_lancamentosConciliado[]\" value=\"' + dtMovimentacao.val() + '~' + tipoMovimentacao + '~' + valor + '~' + descricao.val() + '~0' + '\" /></td>' +
                '<td class=\"remove\"><i class="material-icons blue-text text-darken-4">delete</i></td>' +
                '</tr>';

            $('.listagem-vazia').hide();
            $('#tableLancamentoManuais').append(linha);

            var subtracao = parseFloat(saldoConciliado.attr('data-custom')) + valor;
            saldoConciliado.attr('data-custom', subtracao);
            saldoConciliado.val(UrbemSonata.convertFloatToMoney(subtracao));

            vlMovimentacao.val('0,00');
            descricao.val('');
        }
    });

    $(document).on('click', '.remove', function () {
        $(this).parent().remove();
    });

    $(".remove").click(function() {
        $(this).parent().remove();
    });

    $(function() {
        $( "#accordion" ).accordion({ active: false, collapsible: true, heightStyle: "content" });
    });
}());