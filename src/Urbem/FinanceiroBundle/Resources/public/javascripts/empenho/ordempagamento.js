var config = {
    entidade : jQuery("select#" + UrbemSonata.uniqId + "_fkOrcamentoEntidade"),
    codEntidade : jQuery("#" + UrbemSonata.uniqId + "_codEntidade"),
    exercicio : jQuery("#" + UrbemSonata.uniqId + "_exercicio"),
    dtEmissao : jQuery("#" + UrbemSonata.uniqId + "_dtEmissao"),
    descricao : jQuery("#" + UrbemSonata.uniqId + "_observacao"),
    fornecedor : jQuery("#" + UrbemSonata.uniqId + "_codFornecedor"),
    credor : jQuery("#" + UrbemSonata.uniqId + "_credor"),
    total : jQuery("#" + UrbemSonata.uniqId + "_total"),
    incluirAssinaturas : jQuery("#" + UrbemSonata.uniqId + "_incluirAssinaturas"),
    first : true,
    empenho : {},
    receita : {},
    item : {},
    alterados : [],
    ocultaColuna : 0
};

function carregarTotal() {
    var valores = $(document).find('input[id*=_vlPagamento]');
    var total = 0;
    $.each(valores, function () {
        total = total + UrbemSonata.convertMoneyToFloat($(this).val());
    });
    config.total.val(UrbemSonata.convertFloatToMoney(total));
}

$('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_retencoes').hide();

$(document).on('sonata.add_element', function() {
    config.entidade.attr('disabled', true);
    carregarItens();
});

function ocultaColuna(x) {
    $('#field_container_' + UrbemSonata.uniqId + '_codOrdemPagamentoRetencao tr td:nth-child(' + x + ')').hide();
    $('#field_container_' + UrbemSonata.uniqId + '_codOrdemPagamentoRetencao tr th:nth-child(' + x + ')').hide();
    desabilitaRetencoes();
    removeObrigatorios(x);
}

function desabilitaRetencoes() {
    if (!$("#" + UrbemSonata.uniqId + "_retencoes_0").is(':checked')) {
        $('#' + UrbemSonata.uniqId + '_retencoes_0').attr('disabled', true);
    }
    if (!$("#" + UrbemSonata.uniqId + "_retencoes_1").is(':checked')) {
        $('#' + UrbemSonata.uniqId + '_retencoes_1').attr('disabled', true);
    }
    if (!$("#" + UrbemSonata.uniqId + "_retencoes_2").is(':checked')) {
        $('#' + UrbemSonata.uniqId + '_retencoes_2').attr('disabled', true);
    }
}

function removeObrigatorios(x) {
    if (x == 2) {
        var selectsReceita = $(document).find('select[id*=_fkReceita]');
        $.each(selectsReceita, function () {
            $(this).attr('required', false);
        });
    } else if (x == 3) {
        var selectsPlanos = $(document).find('select[id*=_fkPlanoAnalitica]');
        $.each(selectsPlanos, function () {
            $(this).attr('required', false);
        });
    }
}

var clearReceitas = function() {
    var selectsReceita = $(document).find('select[id*=_fkReceita]');
    $.each(selectsReceita, function () {
       $(this).empty().append("<option value=\"\">Selecione</option>").select2("val", "");
    });
};

UrbemSonata.sonataPanelHide('_fkEmpenhoPagamentoLiquidacoes');
config.entidade.on("change", function() {
    config.codEntidade.val($(this).val());
    carregarDataOrdem(config.exercicio.val(), $(this).val());
    if ($(this).val() != '') {
        UrbemSonata.sonataPanelShow('_fkEmpenhoPagamentoLiquidacoes');
        carregarEmpenho(config.exercicio.val(), $(this).val());
    }
});

function carregarDataOrdem(exercicio, codEntidade) {
    $.ajax({
        url: "/financeiro/empenho/ordem-pagamento/data-ordem",
        method: "POST",
        data: {exercicio: exercicio, codEntidade: codEntidade},
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

function carregarEmpenho(exercicio, codEntidade) {
    $.ajax({
        url: "/financeiro/empenho/ordem-pagamento/empenho",
        method: "POST",
        data: {exercicio: exercicio, codEntidade: codEntidade},
        dataType: "json",
        success: function (data) {
            config.empenho = data;
            var selects = $(document).find('select[id*=_codEmpenho]');
            if (selects.length > 0) {
                carregarItens();
            }
        }
    });
}

function carregarReceita(exercicio, codEntidade) {
    $.ajax({
        url: "/financeiro/empenho/ordem-pagamento/receita",
        method: "POST",
        data: {exercicio: exercicio, codEntidade: codEntidade},
        dataType: "json",
        success: function (data) {
            config.receita = data;
            var selectsReceita = $(document).find('select[id*=_fkReceita]');
            if (selectsReceita.length > 0) {
                carregarReceitas();
            }
        }
    });
}

function carregarReceitas() {
    var selectsReceita = $(document).find('select[id*=_fkReceita]');
    $.each(selectsReceita, function () {
        var selectId = $(this).attr('id');
        var selectedItem = $(this).val();
        $('#' + selectId).empty().append("<option value=\"\">Selecione</option>").select2("val", "");
        $.each(config.receita, function (index, value) {
            if (selectedItem == value) {
                $('#' + selectId).append('<option value="' + value + '" selected>' + index + '</option>');
            } else {
                $('#' + selectId).append('<option value="' + value + '">' + index + '</option>');
            }
        });
        $('#' + selectId).val(selectedItem).select2("val", selectedItem);
    });
}

function carregarItem(exercicio, codEntidade, codEmpenho) {
    $.ajax({
        url: "/financeiro/empenho/ordem-pagamento/item",
        method: "POST",
        data: {exercicio: exercicio, codEntidade: codEntidade, codEmpenho: codEmpenho},
        dataType: "json",
        success: function (data) {
            var valor = ((data.vl_itens - data.vl_itens_anulados) - (data.vl_ordem - data.vl_ordem_anulada));
            var selects = $(document).find('select[id*=_codEmpenho]');
            $.each(selects, function () {
                var imputId = $(this).attr('id');
                var linha = imputId.match(/_(\d)/)[1];
                if ($(this).val() == data.cod_empenho) {
                    var valorAtual = $('#' + UrbemSonata.uniqId + '_fkEmpenhoPagamentoLiquidacoes_' + linha + '_vlPagamento').val();
                    if (valorAtual == '') {
                        $('#' + UrbemSonata.uniqId + '_fkEmpenhoPagamentoLiquidacoes_' + linha + '_vlPagamento')
                            .val(UrbemSonata.convertFloatToMoney(valor)).trigger('change');
                    } else {
                        $('#' + UrbemSonata.uniqId + '_fkEmpenhoPagamentoLiquidacoes_' + linha + '_vlPagamento')
                            .trigger('change');
                    }
                    $('#' + UrbemSonata.uniqId + '_fkEmpenhoPagamentoLiquidacoes_' + linha + '_fkEmpenhoNotaLiquidacao')
                        .empty()
                        .append('<option value="">Selecione</option>')
                        .append('<option value="' + data.cod_nota + '">' + data.cod_nota + ' - ' + data.dt_liquidacao + '</option>')
                        .select2("val", data.cod_nota);

                }
            });
            config.fornecedor.empty().append('<option value="' + data.cgm_beneficiario + '">' + data.cgm_beneficiario + ' - ' + data.beneficiario + '</option>').select2("val", data.cgm_beneficiario);
            config.credor.val(data.cgm_beneficiario);
            config.descricao.val(data.descricao);
            config.item = data;

            carregarReceita(config.exercicio.val(), config.codEntidade.val());
            if (config.ocultaColuna != 0) {
                ocultaColuna(config.ocultaColuna);
            }
            $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_retencoes').show();
        }
    });
}

UrbemSonata.sonataPanelHide('_codOrdemPagamentoAssinatura');
$("#" + UrbemSonata.uniqId + "_incluirAssinaturas_0").on('ifChecked', function(event){
    UrbemSonata.sonataPanelShow('_codOrdemPagamentoAssinatura');
});

$("#" + UrbemSonata.uniqId + "_incluirAssinaturas_1").on('ifChecked', function(event){
    UrbemSonata.sonataPanelHide('_codOrdemPagamentoAssinatura');
});

if ($("#" + UrbemSonata.uniqId + "_incluirAssinaturas_0").is(':checked')) {
    UrbemSonata.sonataPanelShow('_codOrdemPagamentoAssinatura');
}

if ($("#" + UrbemSonata.uniqId + "_retencoes_0").is(':checked')) {
    UrbemSonata.sonataPanelHide('_codOrdemPagamentoRetencao');
}

if ($("#" + UrbemSonata.uniqId + "_retencoes_1").is(':checked')) {
    ocultaColuna(3);
}

if ($("#" + UrbemSonata.uniqId + "_retencoes_2").is(':checked')) {
    ocultaColuna(2);
}

$("#" + UrbemSonata.uniqId + "_retencoes_0").on('ifChecked', function(event){
    UrbemSonata.sonataPanelHide('_codOrdemPagamentoRetencao');
    var selects = $(document).find('select[id*=_codEmpenho]');
    if (selects.length < Object.keys(config.empenho).length) {
        $('#field_actions_' + UrbemSonata.uniqId + '_fkEmpenhoPagamentoLiquidacoes').show();
    }
});

$("#" + UrbemSonata.uniqId + "_retencoes_1").on('ifChecked', function(event){
    UrbemSonata.sonataPanelShow('_codOrdemPagamentoRetencao');
    $('#field_actions_' + UrbemSonata.uniqId + '_fkEmpenhoPagamentoLiquidacoes').hide();
    config.ocultaColuna = 3;
});

$("#" + UrbemSonata.uniqId + "_retencoes_2").on('ifChecked', function(event){
    UrbemSonata.sonataPanelShow('_codOrdemPagamentoRetencao');
    $('#field_actions_' + UrbemSonata.uniqId + '_fkEmpenhoPagamentoLiquidacoes').hide();
    config.ocultaColuna = 2;
});

if (config.codEntidade.val() != '') {
    UrbemSonata.sonataPanelShow('_fkEmpenhoPagamentoLiquidacoes');
    config.entidade.val(config.codEntidade.val()).select2("val", config.codEntidade.val());
    config.entidade.attr('disabled', true);

    carregarEmpenho(config.exercicio.val(), config.codEntidade.val());
    carregarReceita(config.exercicio.val(), config.codEntidade.val());
}

function carregarItens() {
    var selects = $(document).find('select[id*=_codEmpenho]');
    $.each(selects, function () {
        var selectId = $(this).attr('id');
        var empenho = '';
        if ($(this).val() != '') {
            empenho = $(this).val();
        }
        var linha = selectId.match(/_(\d)/)[1];

        $('#' + UrbemSonata.uniqId + '_fkEmpenhoPagamentoLiquidacoes_' + linha + '_fkEmpenhoNotaLiquidacao')
            .empty()
            .append("<option value=\"\">Selecione</option>")
            .select2("val", "");

        $('#' + UrbemSonata.uniqId + '_fkEmpenhoPagamentoLiquidacoes_' + linha + '_vlPagamento')
            .on("change", function () {
                carregarTotal();
            });

        $("#" + selectId).empty().append("<option value=\"\">Selecione</option>").select2("val", "");
        $.each(config.empenho, function (index, value) {
            if (empenho == value) {
                $("#" + selectId).append("<option value=" + value + " selected>" + index + "</option>");
            } else {
                $("#" + selectId).append("<option value=" + value + ">" + index + "</option>");
            }
        });
        $("#" + selectId).select2("val", empenho);
        if (empenho != '') {
            carregarItem(config.exercicio.val(), config.entidade.val(), empenho);
        }
        $("#" + selectId).on("change", function () {
            carregarItem(config.exercicio.val(), config.entidade.val(), $(this).val());
        });
    });
    if (selects.length >= Object.keys(config.empenho).length) {
        $('#field_actions_' + UrbemSonata.uniqId + '_fkEmpenhoPagamentoLiquidacoes').hide();
    }
    if (selects.length > 1) {
        desabilitaRetencoes();
    }
}

function setCurrentExercicio() {
    var exercicio = $('select[name=_exercicio]').val();
    var inputExercicioEmpenho = $('input#filter_fkEmpenhoPagamentoLiquidacoes__fkEmpenhoNotaLiquidacao__exercicioEmpenho_value');
    var inputExercicioOP = $('input#filter_exercicio_value');

    inputExercicioEmpenho.val(exercicio);
    inputExercicioOP.val(exercicio);
}

$( document ).ready(function() {
    setCurrentExercicio();
});
