var codOrdem = $('#' + UrbemSonata.uniqId + '_codOrdem'),
    exercicio = $('#' + UrbemSonata.uniqId + '_exercicio'),
    codEntidade = $('#' + UrbemSonata.uniqId + '_codEntidade'),
    exercicioEmpenho = $('#' + UrbemSonata.uniqId + '_exercicioEmpenho'),
    codEmpenho = UrbemSonata.giveMeBackMyField('codEmpenho'),
    codNotaLiquidacao = $('#' + UrbemSonata.uniqId + '_fkEmpenhoNotaLiquidacao'),
    codNota = $('#' + UrbemSonata.uniqId + '_codNota'),
    codFornecedor = $('select#' + UrbemSonata.uniqId + '_codFornecedor'),
    observacao = $('#' + UrbemSonata.uniqId + '_observacao'),
    vlPagamento = $('#' + UrbemSonata.uniqId + '_vlPagamento'),
    total = $('#' + UrbemSonata.uniqId + '_total'),
    totalOrdemPagamento = $('#' + UrbemSonata.uniqId + '_totalOrdemPagamento'),
    numItens = $('#' + UrbemSonata.uniqId + '_numItens');

function limparEmpenho() {
    codEmpenho
        .empty()
        .select2('val', '')
    ;
}

function limparNotaLiquidacao() {
    codNotaLiquidacao
        .empty()
        .select2('val', '')
    ;
}

function limparFornecedor() {
    codFornecedor
        .empty()
        .select2('val', '')
    ;
}

function limparFormulario() {
    limparEmpenho();
    limparNotaLiquidacao();
    limparFornecedor();
    vlPagamento.val('');
    total.val('');
    observacao.val('');
}

window.varJsExercicio = exercicioEmpenho.val();
exercicioEmpenho.on('change', function () {
    window.varJsExercicio = $(this).val();
    limparFormulario();
});

codEmpenho.on('change', function () {
    carregarLiquidacao(exercicioEmpenho.val(), codEntidade.val(), $(this).val());
});

function carregarLiquidacao(exercicio, codEntidade, codEmpenho) {
    $.ajax({
        url: "/financeiro/empenho/ordem-pagamento/item",
        method: "POST",
        data: {exercicio: exercicio, codEntidade: codEntidade, codEmpenho: codEmpenho},
        dataType: "json",
        success: function (data) {
            limparNotaLiquidacao();
            codNotaLiquidacao
                .append('<option value="' + data.cod_nota + '" selected>' + data.cod_nota + ' - ' + data.dt_liquidacao + '</option>')
                .select2('val', data.cod_nota);
            codNota.val(data.cod_nota);

            if ((vlPagamento.val() == '') || (numItens.val() == 0)) {
                var valor = ((data.vl_itens - data.vl_itens_anulados) - (data.vl_ordem - data.vl_ordem_anulada));
                vlPagamento.val(UrbemSonata.convertFloatToMoney(valor));
                var soma = valor + parseFloat(totalOrdemPagamento.val());
                total.val(UrbemSonata.convertFloatToMoney(soma));
            }

            if ((codFornecedor.val() == null) || (numItens.val() == 0)) {
                codFornecedor
                    .empty()
                    .append('<option value="' + data.cgm_beneficiario + '">' + data.cgm_beneficiario + ' - ' + data.beneficiario + '</option>')
                    .select2("val", data.cgm_beneficiario);
            }

            observacao.val(data.descricao);
        }
    });
}

vlPagamento.on('change', function () {
    var soma = UrbemSonata.convertMoneyToFloat($(this).val()) + parseFloat(totalOrdemPagamento.val());
    total.val(UrbemSonata.convertFloatToMoney(soma));
});

if (codEmpenho.val() != '') {
    carregarLiquidacao(exercicioEmpenho.val(), codEntidade.val(), codEmpenho.val());
}

if (vlPagamento.val() != '') {
    var soma = UrbemSonata.convertMoneyToFloat(vlPagamento.val()) + parseFloat(totalOrdemPagamento.val());
    total.val(UrbemSonata.convertFloatToMoney(soma));
}

$('div .campo-sonata:eq(7)').css({"max-height" : "66px"} );