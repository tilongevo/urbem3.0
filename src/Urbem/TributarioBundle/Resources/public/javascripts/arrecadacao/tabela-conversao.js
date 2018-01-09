var condicaoParametro1 = $("#" + UrbemSonata.uniqId + "_condicaoParametro1"),
    condicaoParametro2 = $("#" + UrbemSonata.uniqId + "_condicaoParametro2"),
    condicaoParametro3 = $("#" + UrbemSonata.uniqId + "_condicaoParametro3"),
    condicaoParametro4 = $("#" + UrbemSonata.uniqId + "_condicaoParametro4"),
    valor = $("#" + UrbemSonata.uniqId + "_valor");

changeAttr(false);

var TabelaConversaoValores = function () {

    this.setCondicaoParametro1 = function(condicaoParametro1) {
        this.condicaoParametro1 = condicaoParametro1;
    };

    this.setCondicaoParametro2 = function(condicaoParametro2) {
        this.condicaoParametro2 = condicaoParametro2;
    };

    this.setCondicaoParametro3 = function(condicaoParametro3) {
        this.condicaoParametro3 = condicaoParametro3;
    };

    this.setCondicaoParametro4 = function(condicaoParametro4) {
        this.condicaoParametro4 = condicaoParametro4;
    };

    this.setValor = function(valor) {
        this.valor = valor;
    };

    this.setValue = function () {
        this.value = [
            this.condicaoParametro1,
            this.condicaoParametro2,
            this.condicaoParametro3,
            this.condicaoParametro4,
            this.valor
        ];

        return this.value.join("__");
    };

    this.getCondicaoParametro1 = function() {
        return this.condicaoParametro1;
    };

    this.getCondicaoParametro2 = function() {
        return this.condicaoParametro2;
    };

    this.getCondicaoParametro3 = function() {
        return this.condicaoParametro3;
    };

    this.getCondicaoParametro4 = function() {
        return this.condicaoParametro4;
    };

    this.getValor = function() {
        return this.valor;
    };

    this.adicionaLinha = function () {
        var linha =
            '<tr class="tr-rh">' +
            '<td style="display: none"><input name=\"valores[]\" type=\"hidden\" value=\"' + this.setValue() + '\" /></td>' +
            '<td>' + this.getCondicaoParametro1() + '</td>' +
            '<td>' + this.getCondicaoParametro2() + '</td>' +
            '<td>' + this.getCondicaoParametro3() + '</td>' +
            '<td>' + this.getCondicaoParametro4() + '</td>' +
            '<td>' + this.getValor() + '</td>' +
            '<td class=\"remove\"><i class="material-icons blue-text text-darken-4">delete</i></td>' +
            '</tr>';

        $('#tableValores').append(linha);
    };

    this.validaCampos = function () {
        if (valor.val() == '') {
            UrbemSonata.setFieldErrorMessage('valor', 'Selecione um valor antes de continuar!', valor.parent());
            return false;
        }
    };
};

$(".remove").on("click", function() {
    $(this).parent().remove();
});

$(document).on('click', '.remove', function () {
    $("button[name='btn_create_and_list']").show();
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
    condicaoParametro1.val('');
    condicaoParametro2.val('');
    condicaoParametro3.val('');
    condicaoParametro4.val('');
    valor.val('');
}

function changeAttr(required) {
    condicaoParametro1.attr('required', required);
    condicaoParametro2.attr('required', required);
    condicaoParametro3.attr('required', required);
    condicaoParametro4.attr('required', required);
    valor.attr('required', required);
}

$("#addValor").on("click", function() {
    var tabelaConversaoValores = new TabelaConversaoValores();

    tabelaConversaoValores.setCondicaoParametro1(condicaoParametro1.val());
    tabelaConversaoValores.setCondicaoParametro2(condicaoParametro2.val());
    tabelaConversaoValores.setCondicaoParametro3(condicaoParametro3.val());
    tabelaConversaoValores.setCondicaoParametro4(condicaoParametro4.val());
    tabelaConversaoValores.setValor(valor.val());

    removeErrorMessages();

    removeErrorField(condicaoParametro1, 'condicaoParametro1');
    removeErrorField(condicaoParametro2, 'condicaoParametro2');
    removeErrorField(condicaoParametro3, 'condicaoParametro3');
    removeErrorField(condicaoParametro4, 'condicaoParametro4');
    removeErrorField(valor, 'valor');

    tabelaConversaoValores.validaCampos();

    $('.empty').hide();

    tabelaConversaoValores.adicionaLinha();

    clearFields();
});