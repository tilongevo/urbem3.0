var config = {
    codEntidade : jQuery("select#" + UrbemSonata.uniqId + "_fkOrcamentoEntidade"),
    exercicio : jQuery("#" + UrbemSonata.uniqId + "_exercicio"),
    tipoRecibo : jQuery("#" + UrbemSonata.uniqId + "_tipoRecibo"),
    dtEmissao : jQuery("#" + UrbemSonata.uniqId + "_dtEmissao"),
    codContaBanco : jQuery("#" + UrbemSonata.uniqId + "_codContaBanco"),
    incluirAssinaturas : jQuery('input[name="' + UrbemSonata.uniqId + '[incluirAssinaturas]"]'),
    assinaturas : jQuery("#" + UrbemSonata.uniqId + "_assinaturas")
};

var clearContas = function() {
    config.codContaBanco.empty().append("<option value=\"\">Selecione</option>").select2("val", "");
};

var clearAssinaturas = function() {
    config.assinaturas.empty().append("<option value=\"\">Selecione</option>").select2("val", "");
};

if (config.codEntidade.val() == '') {
    clearContas();
    clearAssinaturas();
} else {
    carregarDataEmissao(config.exercicio.val(), $(this).val(), config.tipoRecibo.val());
    carregarCodContaBanco(config.exercicio.val(), $(this).val());
    carregarAssinaturas(config.exercicio.val(), $(this).val());
}

config.codEntidade.on("change", function() {
    carregarDataEmissao(config.exercicio.val(), $(this).val(), config.tipoRecibo.val());
    carregarCodContaBanco(config.exercicio.val(), $(this).val());
    carregarAssinaturas(config.exercicio.val(), $(this).val());
});

function carregarDataEmissao(exercicio, codEntidade, tipoRecibo) {
    $.ajax({
        url: "/financeiro/tesouraria/recibo-receita-extra/data-emissao",
        method: "POST",
        data: {exercicio: exercicio, codEntidade: codEntidade, tipoRecibo: tipoRecibo},
        dataType: "json",
        success: function (data) {
            if (data.data != null) {
                config.dtEmissao.val(data.data);
            } else {
                config.dtEmissao.val('');
            }
        }
    });
}

function carregarCodContaBanco(exercicio, codEntidade) {
    clearContas();
    $.ajax({
        url: "/financeiro/tesouraria/recibo-receita-extra/conta-banco",
        method: "POST",
        data: {exercicio: exercicio, codEntidade: codEntidade},
        dataType: "json",
        success: function (data) {
            $.each(data, function (index, value) {
                config.codContaBanco.append("<option value=" + value + ">" + index + "</option>");
            });
        }
    });
    config.codContaBanco.select2();
}

function carregarAssinaturas(exercicio, codEntidade) {
    clearAssinaturas();
    $.ajax({
        url: "/financeiro/tesouraria/recibo-receita-extra/assinatura",
        method: "POST",
        data: {exercicio: exercicio, codEntidade: codEntidade},
        dataType: "json",
        success: function (data) {
            $.each(data, function (index, value) {
                config.assinaturas.append("<option value=" + value + ">" + index + "</option>");
            });
        }
    });
    config.assinaturas.select2();
}

UrbemSonata.sonataPanelHide('_assinaturas', false);
config.incluirAssinaturas.on('ifChecked', function () {
    if ($(this).val() == 1) {
        UrbemSonata.sonataPanelShow('_assinaturas', true);
        config.assinaturas.attr('required', true);
    } else {
        UrbemSonata.sonataPanelHide('_assinaturas', false);
        config.assinaturas.attr('required', false);

    }
});