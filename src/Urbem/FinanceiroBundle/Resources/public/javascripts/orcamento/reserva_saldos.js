$(document).ready(function() {
    'use strict';

    var codEntidade = $("select#" + UrbemSonata.uniqId + "_codEntidade"),
        codDespesa = $("select#" + UrbemSonata.uniqId + "_fkOrcamentoDespesa"),
        dataEmpenho = $("#" + UrbemSonata.uniqId + "_dtValidadeInicial"),
        exercicio = $("#" + UrbemSonata.uniqId + "_exercicio"),
        saldoDotacao = $("#" + UrbemSonata.uniqId + "_saldoDotacao");

    function limparDespesas() {
        codDespesa
            .empty()
            .append('<option value="">Selecione</option>')
            .select2("val", "");
    }

    if ((!codEntidade.attr('disabled')) && (!codEntidade.val())) {
        limparDespesas();
    } else {
        carregarDespesas(codEntidade.val(), exercicio.val());
    }

    codEntidade.on('change', function() {
        carregarDespesas($(this).val(), exercicio.val());
    });

    codDespesa.on('change', function () {
        carregarSaldoDotacao(exercicio.val(), $(this).val(), dataEmpenho.val(), codEntidade.val());
    });

    function carregarDespesas(codEntidade, exercicio) {
        $.ajax({
            url: "/financeiro/orcamento/reserva-saldos/consultar-despesas",
            method: "POST",
            data: {codEntidade: codEntidade, exercicio: exercicio},
            dataType: "json",
            success: function (data) {
                var selectedDespesa = codDespesa.val();
                limparDespesas();
                $.each(data, function (index, value) {
                    if (index == selectedDespesa) {
                        codDespesa
                            .append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        codDespesa
                            .append("<option value=" + index  + ">" + value + "</option>");
                    }
                });
                codDespesa.select2('val', selectedDespesa);
            }
        });
    }

    function carregarSaldoDotacao(exercicio, codDespesa, dataEmpenho, codEntidade) {
        $.ajax({
            url: "/financeiro/orcamento/reserva-saldos/consultar-saldo",
            method: "POST",
            data: {
                exercicio: exercicio,
                codDespesa: codDespesa,
                dataEmpenho: dataEmpenho,
                codEntidade: codEntidade,
                tipo: "R"
            },
            dataType: "json",
            success: function (data) {
                var saldo = 0;
                if (data) {
                    saldo = data;
                }
                saldoDotacao.val(UrbemSonata.convertFloatToMoney(saldo));
            }
        });
    }
}());