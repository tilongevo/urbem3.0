var dataVencimentoParcelamento = $("#" + UrbemSonata.uniqId + "_dataVencimentoParcelamento"),
    descontoParcelamento = $("#" + UrbemSonata.uniqId + "_descontoParcelamento"),
    dataVencimentoDesconto = $("#" + UrbemSonata.uniqId + "_dataVencimentoDesconto"),
    formaDescontoParcelamento = $("#" + UrbemSonata.uniqId + "_formaDescontoParcelamento"),
    quantidadeParcelas = $("#" + UrbemSonata.uniqId + "_quantidadeParcelas");

changeAttr(false);

$("button[name='btn_update_and_list']").hide();

var VencimentoParcela = function () {

    this.setDataVencimentoParcelamento = function(dataVencimentoParcelamento) {
        this.dataVencimentoParcelamento = dataVencimentoParcelamento;
    };

    this.setDescontoParcelamento = function(descontoParcelamento) {
        this.descontoParcelamento = descontoParcelamento;
    };

    this.setDataVencimentoDesconto = function(dataVencimentoDesconto) {
        this.dataVencimentoDesconto = dataVencimentoDesconto;
    };

    this.setFormaDescontoParcelamento = function(formaDescontoParcelamento) {
        this.formaDescontoParcelamento = formaDescontoParcelamento;
    };

    this.setQuantidadeParcelas = function(quantidadeParcelas) {
        this.quantidadeParcelas = quantidadeParcelas;
    };

    this.setValue = function () {
        this.value = [
            this.dataVencimentoParcelamento,
            this.descontoParcelamento,
            this.dataVencimentoDesconto,
            this.formaDescontoParcelamento,
            this.quantidadeParcelas
        ];

        return this.value.join("__");
    };

    this.getDataVencimentoParcelamento = function() {
        return this.dataVencimentoParcelamento;
    };

    this.getDescontoParcelamento = function() {
        return this.descontoParcelamento;
    };

    this.getDataVencimentoDesconto = function() {
        return this.dataVencimentoDesconto;
    };

    this.getFormaDescontoParcelamento = function() {
        return this.formaDescontoParcelamento;
    };

    this.getQuantidadeParcelas = function() {
        return this.quantidadeParcelas;
    };

    this.adicionaLinha = function (dados) {
        var linha =
            '<tr class="tr-rh">' +
            '<td style="display: none"><input name=\"parcelas[]\" type=\"hidden\" value=\"' + this.setValue() + '\" /></td>' +
            '<td>' + dados.dataVencimentoParcelamento + '</td>' +
            '<td>' + dados.descontoParcelamento + '</td>' +
            '<td>' + dados.dataVencimentoDesconto + '</td>' +
            '<td>' + (dados.formaDescontoParcelamento == 'perparc' ? "Percentual" : "Valor Absoluto") + '</td>' +
            '<td class=\"remove\"><i class="material-icons blue-text text-darken-4">delete</i></td>' +
            '</tr>';

        $('#tableParcelas').append(linha);
    };

    this.validaCampos = function () {
        if (dataVencimentoParcelamento.val() == '') {
            UrbemSonata.setFieldErrorMessage('dataVencimentoParcelamento', 'Selecione um vencimento antes de continuar!', dataVencimentoParcelamento.parent());
            return false;
        }

        if (descontoParcelamento.val() == '') {
            UrbemSonata.setFieldErrorMessage('descontoParcelamento', 'Selecione um desconto antes de continuar!', descontoParcelamento.parent());
            return false;
        }

        if (dataVencimentoDesconto.val() == '') {
            UrbemSonata.setFieldErrorMessage('dataVencimentoDesconto', 'Selecione um vencimento desconto antes de continuar!', dataVencimentoDesconto.parent());
            return false;
        }

        if (quantidadeParcelas.val() == '') {
            UrbemSonata.setFieldErrorMessage('quantidadeParcelas', 'Selecione a quantidade de parcelas antes de continuar!', quantidadeParcelas.parent());
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
    dataVencimentoParcelamento.val('');
    descontoParcelamento.val('');
    dataVencimentoDesconto.val('');
    quantidadeParcelas.val('');
}

function changeAttr(required) {
    dataVencimentoParcelamento.attr('required', required);
    descontoParcelamento.attr('required', required);
    dataVencimentoDesconto.attr('required', required);
    quantidadeParcelas.attr('required', required);
}

function carregaParcelas(vencimentoDesconto) {
    var modal = new UrbemModal();
    var dados;

    modal.setTitle('Carregando...');
    abreModal('Carregando','Aguarde, processando dados');

    $.ajax({
        url: "/tributario/arrecadacao/calendario-fiscal/get-parcelas-desconto",
        method: "GET",
        data: {
            dataVencimentoParcelamento: dataVencimentoParcelamento.val(),
            dataVencimentoDesconto: dataVencimentoDesconto.val(),
            quantidadeParcelas: quantidadeParcelas.val()
        },
        dataType: "json",
        success: function (data) {
            fechaModal();
            for (var i in data) {
                dados = {
                    dataVencimentoParcelamento: data[i].dataVencimentoParcelamento,
                    descontoParcelamento: vencimentoDesconto.getDescontoParcelamento(),
                    dataVencimentoDesconto: data[i].dataVencimentoDesconto,
                    formaDescontoParcelamento: vencimentoDesconto.getFormaDescontoParcelamento()
                };
                vencimentoDesconto.adicionaLinha(dados);
            }
        }
    });
}

$("#addParcela").on("click", function() {
    var vencimentoDesconto = new VencimentoParcela(), dados;

    vencimentoDesconto.setDataVencimentoParcelamento(dataVencimentoParcelamento.val());
    vencimentoDesconto.setDescontoParcelamento(descontoParcelamento.val());
    vencimentoDesconto.setDataVencimentoDesconto(dataVencimentoDesconto.val());
    vencimentoDesconto.setFormaDescontoParcelamento(formaDescontoParcelamento.val());
    vencimentoDesconto.setQuantidadeParcelas(quantidadeParcelas.val());

    removeErrorMessages();

    removeErrorField(dataVencimentoParcelamento, 'dataVencimentoParcelamento');
    removeErrorField(descontoParcelamento, 'descontoParcelamento');
    removeErrorField(dataVencimentoDesconto, 'dataVencimentoDesconto');
    removeErrorField(quantidadeParcelas, 'quantidadeParcelas');

    vencimentoDesconto.validaCampos();

    $("button[name='btn_update_and_list']").show();

    $('.empty').hide();

    if (quantidadeParcelas.val() == 1) {
        dados = {
            dataVencimentoParcelamento: dataVencimentoParcelamento.val(),
            descontoParcelamento: descontoParcelamento.val(),
            dataVencimentoDesconto: dataVencimentoDesconto.val(),
            formaDescontoParcelamento: formaDescontoParcelamento.val()
        };

        vencimentoDesconto.adicionaLinha(dados);
    } else {
        carregaParcelas(vencimentoDesconto);
    }

    clearFields();
});