var descricao = $("#" + UrbemSonata.uniqId + "_descricao"),
    utilizarCotaUnica = $('input[name*="utilizarCotaUnica"]'),
    vencimentoValorIntegral = $("#" + UrbemSonata.uniqId + "_vencimentoValorIntegral"),
    limiteInicial = $("#" + UrbemSonata.uniqId + "_limiteInicial"),
    limiteFinal = $("#" + UrbemSonata.uniqId + "_limiteFinal");

changeAttr(false);

var CalendarioFiscal = function () {

    this.setUtilizarCotaUnica = function(utilizarCotaUnica) {
        this.utilizarCotaUnica = utilizarCotaUnica;
    };

    this.setDescricao = function(descricao) {
        this.descricao = descricao;
    };

    this.setVencimentoValorIntegral = function(vencimentoValorIntegral) {
        this.vencimentoValorIntegral = vencimentoValorIntegral;
    };

    this.setLimiteInicial = function(limiteInicial) {
        this.limiteInicial = limiteInicial;
    };

    this.setLimiteFinal = function(limiteFinal) {
        this.limiteFinal = limiteFinal;
    };

    this.setValue = function () {
        this.value = [
            this.utilizarCotaUnica,
            this.descricao,
            this.vencimentoValorIntegral,
            this.limiteInicial,
            this.limiteFinal
        ];

        return this.value.join("__");
    };

    this.getUtilizarCotaUnica = function() {
        return this.utilizarCotaUnica;
    };

    this.getDescricao = function() {
        return this.descricao;
    };

    this.getVencimentoValorIntegral = function() {
        return this.vencimentoValorIntegral;
    };

    this.getLimiteInicial = function() {
        return this.limiteInicial;
    };

    this.getLimiteFinal = function() {
        return this.limiteFinal;
    };

    this.adicionaLinha = function () {
        var linha =
            '<tr class="tr-rh">' +
            '<td style="display: none"><input name=\"grupoVencimentos[]\" type=\"hidden\" value=\"' + this.setValue() + '\" /></td>' +
            '<td>' + $('#tableGrupoVencimentos tr').length + '</td>' +
            '<td>' + this.getVencimentoValorIntegral() + '</td>' +
            '<td>' + this.getDescricao() + '</td>' +
            '<td>' + UrbemSonata.convertFloatToMoney(this.getLimiteInicial()) + '</td>' +
            '<td>' + UrbemSonata.convertFloatToMoney(this.getLimiteFinal()) + '</td>' +
            '<td>' + (this.getUtilizarCotaUnica() == 1 ? "Sim" : "Não")  + '</td>' +
            '<td class=\"remove\"><i class="material-icons blue-text text-darken-4">delete</i></td>' +
            '</tr>';

        $('#tableGrupoVencimentos').append(linha);
    };

    this.validaCampos = function () {
        if (descricao.val() == '') {
            UrbemSonata.setFieldErrorMessage('descricao', 'Selecione uma ordem antes de continuar!', descricao.parent());
            return false;
        }

        if (vencimentoValorIntegral.val() == '') {
            UrbemSonata.setFieldErrorMessage('vencimentoValorIntegral', 'Selecione uma data antes de continuar!', vencimentoValorIntegral.parent());
            return false;
        }

        if (limiteInicial.val() == '') {
            UrbemSonata.setFieldErrorMessage('limiteInicial', 'Selecione um limite inicial antes de continuar!', limiteInicial.parent());
            return false;
        }

        if (limiteFinal.val() == '') {
            UrbemSonata.setFieldErrorMessage('limiteFinal', 'Selecione um limite final antes de continuar!', limiteFinal.parent());
            return false;
        }
    };
};

$(".remove").on("click", function() {
    $(this).parent().remove();
});

$(document).on('click', '.remove', function () {
    $("button[name='btn_update_and_list']").show();
    $(this).parent().remove();
});

function removeErrorMessages()
{
    $('.sonata-ba-field-error-messages').remove();
}

function removeErrorField(field, name) {
    if (field.parent().hasClass('sonata-ba-field-error')) {
        $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_' + name).removeClass('has-error');
    }
}

function clearFields() {
    descricao.val('');
    vencimentoValorIntegral.val('');
    limiteInicial.val('');
    limiteFinal.val('');
}

function changeAttr(required) {
    descricao.attr('required', required);
    vencimentoValorIntegral.attr('required', required);
    limiteInicial.attr('required', required);
    limiteFinal.attr('required', required);
}

$("#addGrupoVencimento").on("click", function() {
    var calendarioFiscal = new CalendarioFiscal();

    calendarioFiscal.setDescricao(descricao.val());
    calendarioFiscal.setUtilizarCotaUnica(utilizarCotaUnica.val());
    calendarioFiscal.setVencimentoValorIntegral(vencimentoValorIntegral.val());
    calendarioFiscal.setLimiteInicial(UrbemSonata.convertMoneyToFloat(limiteInicial.val()));
    calendarioFiscal.setLimiteFinal(UrbemSonata.convertMoneyToFloat(limiteFinal.val()));

    removeErrorMessages();

    removeErrorField(descricao, 'descricao');
    removeErrorField(vencimentoValorIntegral, 'vencimentoValorIntegral');
    removeErrorField(limiteInicial, 'limiteInicial');
    removeErrorField(limiteFinal, 'limiteFinal');

    calendarioFiscal.validaCampos();

    $('.empty').hide();

    calendarioFiscal.adicionaLinha();

    clearFields();
});