var tipoOrcamentaria = $('#' + UrbemSonata.uniqId + '_tipoRetencao_0'),
    tipoExtraOrcamentaria = $('#' + UrbemSonata.uniqId + '_tipoRetencao_1'),
    planoAnaliticaContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkContabilidadePlanoAnalitica'),
    planoAnalitica = $('select#' + UrbemSonata.uniqId + '_fkContabilidadePlanoAnalitica'),
    receitaContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkOrcamentoReceita'),
    receita = $('select#' + UrbemSonata.uniqId + '_fkOrcamentoReceita'),
    codEntidade = $('#' + UrbemSonata.uniqId + '_codEntidade'),
    exercicio = $('#' + UrbemSonata.uniqId + '_exercicio'),
    vlRetencao = $('#' + UrbemSonata.uniqId + '_vlRetencao'),
    totalRetencoes = $('#' + UrbemSonata.uniqId + '_totalRetencoes'),
    totalRetencoesOrdemPagamento = $('#' + UrbemSonata.uniqId + '_totalRetencoesOrdemPagamento'),
    total = $('#' + UrbemSonata.uniqId + '_total');

function tipoRetencao(tipo) {
    if (tipo == 1) {
        receita.attr('required', true);
        planoAnalitica.attr('required', false);
        planoAnalitica.select2('val', '');
        planoAnalitica.trigger('change');
        receitaContainer.show();
        planoAnaliticaContainer.hide()
    } else {
        receita.attr('required', false);
        planoAnalitica.attr('required', true);
        receita.select2('val', '');
        receita.trigger('change');
        receitaContainer.hide();
        planoAnaliticaContainer.show()
    }
}

tipoOrcamentaria.on('ifChecked', function () {
    tipoRetencao(1);
});
if (tipoOrcamentaria.attr('checked') == 'checked') {
    tipoRetencao(1);
}

tipoExtraOrcamentaria.on('ifChecked', function () {
    tipoRetencao(2);
});
if (tipoExtraOrcamentaria.attr('checked')) {
    tipoRetencao(2);
}

var limparReceitas = function() {
    receita
        .empty()
        .append('<option value="">Selecione</option>')
        .select2('val', '');
};

function carregarReceitas(exercicio, codEntidade) {
    $.ajax({
        url: "/financeiro/empenho/ordem-pagamento/receita",
        method: "POST",
        data: {exercicio: exercicio, codEntidade: codEntidade},
        dataType: "json",
        success: function (data) {
            var selected = receita.val();
            limparReceitas();
            $.each(data, function (index, value) {
                if (value == selected) {
                    receita.append('<option value="' + value + '" selected>' + index + '</option>');
                } else {
                    receita.append('<option value="' + value + '">' + index + '</option>');
                }
            });
            receita.select2('val', selected);
        }
    });
}

carregarReceitas(exercicio.val(), codEntidade.val());

vlRetencao.on('change', function () {
    var soma = UrbemSonata.convertMoneyToFloat($(this).val()) + parseFloat(totalRetencoesOrdemPagamento.val());
    totalRetencoes.val(UrbemSonata.convertFloatToMoney(soma));
});

if (vlRetencao.val() != '') {
    var soma = UrbemSonata.convertMoneyToFloat(vlRetencao.val()) + parseFloat(totalRetencoesOrdemPagamento.val());
    totalRetencoes.val(UrbemSonata.convertFloatToMoney(soma));
}