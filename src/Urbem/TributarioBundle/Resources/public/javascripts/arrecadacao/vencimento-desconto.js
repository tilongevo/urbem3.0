var dataVencimento = $("#" + UrbemSonata.uniqId + "_dataVencimento"),
    desconto = $("#" + UrbemSonata.uniqId + "_desconto"),
    formaDesconto = $("#" + UrbemSonata.uniqId + "_formaDesconto");

changeAttr(false);

var VencimentoDesconto = function () {

    this.setDataVencimento = function(dataVencimento) {
        this.dataVencimento = dataVencimento;
    };

    this.setDesconto = function(desconto) {
        this.desconto = desconto;
    };

    this.setFormaDesconto = function(formaDesconto) {
        this.formaDesconto = formaDesconto;
    };

    this.setValue = function () {
        this.value = [
            this.dataVencimento,
            this.desconto,
            this.formaDesconto
        ];

        return this.value.join("__");
    };

    this.getDataVencimento = function() {
        return this.dataVencimento;
    };

    this.getDesconto = function() {
        return this.desconto;
    };

    this.getFormaDesconto = function() {
        return this.formaDesconto;
    };

    this.adicionaLinha = function () {
        var linha =
            '<tr class="tr-rh">' +
            '<td style="display: none"><input name=\"descontos[]\" type=\"hidden\" value=\"' + this.setValue() + '\" /></td>' +
            '<td>' + this.getDataVencimento() + '</td>' +
            '<td>' + this.getDesconto() + '</td>' +
            '<td>' + (this.getFormaDesconto() == 'per' ? "Percentual" : "Valor Absoluto")  + '</td>' +
            '<td class=\"remove\"><i class="material-icons blue-text text-darken-4">delete</i></td>' +
            '</tr>';

        $('#tableDescontos').append(linha);
    };

    this.validaCampos = function () {
        if (dataVencimento.val() == '') {
            UrbemSonata.setFieldErrorMessage('dataVencimento', 'Selecione uma data antes de continuar!', descricao.parent());
            return false;
        }

        if (desconto.val() == '') {
            UrbemSonata.setFieldErrorMessage('desconto', 'Selecione um desconto antes de continuar!', vencimentoValorIntegral.parent());
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
    dataVencimento.val('');
    desconto.val('');
}

function changeAttr(required) {
    dataVencimento.attr('required', required);
    desconto.attr('required', required);
}

$("#addDesconto").on("click", function() {
    var vencimentoDesconto = new VencimentoDesconto();

    vencimentoDesconto.setDataVencimento(dataVencimento.val());
    vencimentoDesconto.setDesconto(desconto.val());
    vencimentoDesconto.setFormaDesconto(formaDesconto.val())

    removeErrorMessages();

    removeErrorField(dataVencimento, 'dataVencimento');
    removeErrorField(desconto, 'desconto');

    vencimentoDesconto.validaCampos();

    $('.empty').hide();

    vencimentoDesconto.adicionaLinha();

    clearFields();
});