(function () {
    'use strict';

    var completarTanque = UrbemSonata.giveMeBackMyField('completarTanque');
    var frotaItem = UrbemSonata.giveMeBackMyField('fkFrotaItem');
    var frotaVeiculo = UrbemSonata.giveMeBackMyField('fkFrotaVeiculo');
    var valor = UrbemSonata.giveMeBackMyField('valor');
    var valorUnitario = UrbemSonata.giveMeBackMyField('valorUnitario');
    var quantidade = UrbemSonata.giveMeBackMyField('quantidade');
    var placa = UrbemSonata.giveMeBackMyField('placa');
    var prefixo = UrbemSonata.giveMeBackMyField('prefixo');

    var item = 0;

    frotaItem.prop("disabled", "disabled");
    showCompletarTanque(completarTanque, valor, valorUnitario, quantidade);

    if(frotaItem.val()) {
        item = frotaItem.val();
    }

    if(frotaVeiculo.val() != "" && frotaVeiculo.val() != undefined) {
        getVeiculoCombustiveis(frotaVeiculo, frotaItem, item);
        preencheDadosVeiculo(frotaVeiculo, placa, prefixo)
    }

    frotaVeiculo.on("change", function () {
        getVeiculoCombustiveis(frotaVeiculo, frotaItem, item);
        preencheDadosVeiculo(frotaVeiculo, placa, prefixo)
    });

    completarTanque.on("ifChecked", function(){
        showCompletarTanque($(this), valor, valorUnitario, quantidade);
    });

    quantidade.on('focusout', function () {
        valor.val(calcularValorTotal($(this), valorUnitario));
    });

    valorUnitario.on('focusout', function(){
        valor.val(calcularValorTotal(quantidade, $(this)));
    });

    valor.on('focusout', function () {
        valorUnitario.val(calcularValorUnitario(quantidade, $(this)))
    });
}());

function calcularValorTotal(quantidade, valorUnitario){
    var floatQuantidade = UrbemSonata.convertMoneyToFloat(quantidade.val());
    var floatValUnitario = UrbemSonata.convertMoneyToFloat(valorUnitario.val());
    var result = floatQuantidade * floatValUnitario;

    return UrbemSonata.convertFloatToMoney(result);
}

function calcularValorUnitario(quantidade, valorTotal){
    var floatQuantidade = UrbemSonata.convertMoneyToFloat(quantidade.val());
    var floatValTotal = UrbemSonata.convertMoneyToFloat(valorTotal.val());
    var result = floatValTotal / floatQuantidade;

    return UrbemSonata.convertFloatToMoney(result);
}

function showCompletarTanque(completarTanque, valor, valorUnitario, quantidade) {
    var optCompletarTanque = completarTanque.find('input[type="radio"]:checked').val();

    if(optCompletarTanque == 'S'){
        valor.prop('readonly', true);
        valor.val(0.00);
        valorUnitario.prop('readonly', true);
        valorUnitario.val(0.00);
        quantidade.prop('readonly', true);
        quantidade.val(0);
    }else{
        valor.prop('readonly', false);
        valorUnitario.prop('readonly', false);
        quantidade.prop('readonly', false);
    }
}

function getVeiculoCombustiveis(frotaVeiculo, frotaItem, item) {
    var codVeiculo = frotaVeiculo.val();

    if (codVeiculo == 0) {
        frotaItem.prop("disabled", "disabled");
        frotaItem.empty();

        return;
    }

    abreModal('Carregando','Aguarde, carregando os combustíveis para esse veículo');

    $.ajax({
        url: "/patrimonial/frota/veiculo/consultar-veiculo-combustiveis/" + codVeiculo,
        method: "GET",
        dataType: "json",
        success: function (data) {
            frotaItem.prop("disabled", false);
            frotaItem.empty();

            frotaItem.append("<option value='0'>Selecione...</option>");

            $.each(data, function (index, value) {
                frotaItem.append("<option value='" + index + "'>" + value + "</option>");
            });

            frotaItem.val(item);
            $('select').select2();
            fechaModal();
        }
    });
}

function preencheDadosVeiculo(frotaVeiculo, placa, prefixo) {
    var codVeiculo = frotaVeiculo.val();
    placa.val('');
    prefixo.val('');

    $.ajax({
        url: "/patrimonial/frota/veiculo/consultar-dados-veiculo/" + codVeiculo,
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            placa.val(data.placa);
            prefixo.val(data.prefixo);
        }
    })
}
