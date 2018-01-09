var config = {
    entidade : jQuery("select[name='form[entidade]']"),
    conta : jQuery("select[name='form[codPlano]']"),
    exercicio : jQuery("input[name='form[exercicio]']"),
    botao : jQuery("button[name='form[submit]']")
};

var clear = function(select) {
    select.empty().append("<option value=\"\">Selecione</option>").select2("val", "").val('').trigger("change");
};
var habilitarDesabilitar = function (target, optionBoolean) {
    target.prop('disabled', optionBoolean);
};

config.botao.hide();
config.entidade.on('change', function(){
    habilitarDesabilitarBotao($(this), config.conta);
});
config.conta.on('change', function(){
    habilitarDesabilitarBotao($(this), config.entidade);
});

function habilitarDesabilitarBotao(target, selectVerificar) {
    if (target.val() && selectVerificar.val()) {
        config.botao.show();
    } else {
        config.botao.hide();
    }
}

config.entidade.on("change", function() {
    entidadeCod = $(this).val();
    clear(config.conta);
    habilitarDesabilitar(config.conta, true);
    carregarContas(entidadeCod);
});

if (config.entidade.val() == '') {
    clear(config.conta);
} else {
    carregarContas(config.entidade.val());
}
function carregarContas(entidade) {
    config.valores = [];
    $.ajax({
        url: "/financeiro/tesouraria/saldos/consultar-saldo/contas-por-entidade",
        method: "POST",
        data: {entidade: entidade, 'exercicio': config.exercicio.val()},
        dataType: "json",
        success: function (data) {
            sucesso(data);
        }
    });
};
var sucesso = function (data) {
    var codPrograma = config.conta.val();
    habilitarDesabilitar(config.conta, false);
    $.each(data.contas, function (index, value) {
        if (index == codPrograma) {
            config.conta
                .append("<option value=" + index + " selected>" + value + "</option>");
        } else {
            config.conta
                .append("<option value=" + index + ">" + value + "</option>");
        }
    });
    config.conta.select2();
};
