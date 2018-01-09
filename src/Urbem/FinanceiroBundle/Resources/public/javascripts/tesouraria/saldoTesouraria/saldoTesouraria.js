var config = {
    entidade : jQuery("#" + UrbemSonata.uniqId + "_fkOrcamentoEntidade"),
    conta : jQuery("#" + UrbemSonata.uniqId + "_codPlano"),
    vlSaldo : jQuery("#" + UrbemSonata.uniqId + "_vlSaldo"),
    exercicio : jQuery("#" + UrbemSonata.uniqId + "_exercicio"),
    valores : []
};
var clearContas = function() {
    config.conta.empty().append("<option value=\"\">Selecione</option>").select2("val", "");
};
config.entidade.on("change", function() {
    entidadeCod = $(this).val();
    carregarContas(entidadeCod);
});

if (config.entidade.val() == '') {
    clearContas();
    config.vlSaldo.val('');
} else {
    carregarContas(config.entidade.val());
}

config.conta.attr('required', true);
function carregarContas(entidade) {
    clearContas();
    config.valores = [];
    config.vlSaldo.val("");
    if (entidade) {
        $.ajax({
            url: "/financeiro/tesouraria/configuracao/implantar-saldo-inicial/contas-por-entidade/",
            method: "POST",
            data: {entidade: entidade, 'exercicio': config.exercicio.val()},
            dataType: "json",
            success: function (data) {
                sucesso(data);
            }
        });
    } else {
        config.conta.attr('disabled', true);
    }
}

config.conta.attr('disabled', true);
var sucesso = function (data) {
    config.conta.attr('disabled', true);
    $.each(data.contas, function (index, value) {
        var codPrograma = config.conta.val();
        if (index == codPrograma) {
            config.conta
                .append("<option value=" + index + " selected>" + index  + ' - ' + value + "</option>");
        } else {
            config.conta
                .append("<option value=" + index + ">" + index + ' - ' + value + "</option>");
        }
    });
    $.each(data.contasVl, function (index, value) {
        config.valores[index] = value;
    });
    config.conta.select2();
    config.conta.attr('disabled', false);
};

config.conta.on("change", function() {
    if ($(this).val() != '') {
        var valor = $(this).val();
        var valores = config.valores;
        for(var k in valores){
            if(valor == k){
                if (valores[k]) {
                    config.vlSaldo.val(formatter.format(valores[k]));
                }
            }
        }
    } else {
        config.vlSaldo.val('');
    }
});

var formatter = new Intl.NumberFormat('pt-BR', {minimumFractionDigits: 2});

config.vlSaldo.maskMoney(
    {
        allowNegative: true,
        decimal: ',',
        thousands: '.'
    }
);

$( "form" ).submit(function() {
    config.vlSaldo.val(config.vlSaldo.maskMoney('unmasked')[0]);
});