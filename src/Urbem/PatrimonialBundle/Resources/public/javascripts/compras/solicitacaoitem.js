(function(){
  'use strict';

  var formAction = $('form').prop('action'),
    giveMeMyField = function (fieldName) {

    };

    var fieldvalorUnitario = UrbemSonata.giveMeBackMyField('valorUnitario'),
      fieldQuantidade = UrbemSonata.giveMeBackMyField('quantidade'),
      fieldVlTotal = UrbemSonata.giveMeBackMyField('vlTotal'),
      fieldvlTotalHidden = UrbemSonata.giveMeBackMyField('vlTotalHidden'),
      fieldDotacao = UrbemSonata.giveMeBackMyField('codDespesa'),
      fieldSaldoDotacao = UrbemSonata.giveMeBackMyField('saldoDotacao'),
      fieldCodEstrutural = UrbemSonata.giveMeBackMyField('codEstrutural'),
      fieldExercicio = UrbemSonata.giveMeBackMyField('exercicio'),
      fieldItem = UrbemSonata.giveMeBackMyField('fkAlmoxarifadoCatalogoItem'),
      fieldCentroCusto = UrbemSonata.giveMeBackMyField('fkAlmoxarifadoCentroCusto'),
      fieldSaldoDotacaoValue = 0,
      fieldVlTotalValue = '',
      fieldVlTotalHiddenValue = '',
      fieldVlTotalString = '';


  fieldCentroCusto.on('change', function (e) {
    var fieldfieldCentroCustoValue = $(this).val();
    var fieldItemValue = fieldItem.val();
    if(fieldfieldCentroCustoValue > 0 && fieldItemValue > 0) carregaSaldoCentroCusto(fieldfieldCentroCustoValue, fieldItemValue);
  });

  function carregaSaldoCentroCusto(codCentro, codItem)
  {
    abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, carregando saldo centro de custo</h4>');
    $.ajax({
      url: "/patrimonial/almoxarifado/catalogo/carrega-saldo_centro_custo?codCentro=" + codCentro + "&codItem=" + codItem,
      method: "GET",
      dataType: "json",
      success: function (data) {
        var fieldSaldoCentro = UrbemSonata.giveMeBackMyField('saldoCentroCusto');
        if (data[0].nom_unidade != '' && data != null) {
          var saldoValue = moeda(data[0].saldo_estoque, 2, ',', '.');
          fieldSaldoCentro.val(saldoValue);
        } else {
          fieldSaldoCentro.val(0);
        }
        fechaModal();
      }
    });
  }

  fieldItem.on('change', function (e) {
    var fieldItemValue = $(this).val();
    var fieldfieldCentroCustoValue = fieldCentroCusto.val();

    if(fieldItemValue != "") {
      abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, carregando unidade de medida do item</h4>');
      $.ajax({
        url: "/patrimonial/almoxarifado/catalogo/carrega-almoxarifado-catalogo-unidade?item=" + fieldItemValue,
        method: "GET",
        dataType: "json",
        success: function (data) {

          var fieldUnidadeMedida = UrbemSonata.giveMeBackMyField('unidadeMedida');

          if (data[0].nom_unidade != '' && data != null) {
            fieldUnidadeMedida.val(data[0].nom_unidade);
          } else {
            fieldUnidadeMedida.val('Não informada');
          }
          fechaModal();

          if (fieldfieldCentroCustoValue > 0 && fieldItemValue > 0) carregaSaldoCentroCusto(fieldfieldCentroCustoValue, fieldItemValue);
        }
      });
    }
  });

  fieldDotacao.on('change', function (e) {

    var fieldDotacaoValue = $(this).val(),
      fieldExercicioValue = fieldExercicio.val();
    carregaSaldoDotacao(fieldExercicioValue, fieldDotacaoValue);
  });

  function carregaSaldoDotacao(fieldExercicioValue, fieldDotacaoValue)
  {
    if (fieldExercicioValue == '' || fieldDotacaoValue == '') {

      fieldSaldoDotacao.val(0);
    }else{

      abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando saldo da dotação</h4>');
      $.ajax({
        url: "/patrimonial/compras/solicitacao/recupera-saldo-solicitacao?exercicio=" + fieldExercicioValue + "&codDotacao=" + fieldDotacaoValue,
        method: "GET",
        dataType: "json",
        success: function (data) {

          if(data[0].saldo_dotacao != '' && data != null){
            fieldSaldoDotacaoValue = moeda(data[0].saldo_dotacao, 2, ',', '.');
            fieldSaldoDotacao.val(fieldSaldoDotacaoValue);
          }else{
            fieldSaldoDotacao.val(0);
          }
          fechaModal();
          carregaCodEstrutural(fieldDotacaoValue, fieldExercicioValue);
        },
        fail: function() {
          fechaModal();
          abreModal('<h5 class="text-center"></h5> <h4 class="grey-text text-center">Erro ao carregar conteúdo</h4> <p class="grey-text text-center">Houve um erro na aplicação, por favor contate o suporte técnico</p>');
        }
      });
    }
  }


  function carregaCodEstrutural(fieldDotacaoValue, fieldExercicioValue) {
    abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando desdobramento</h4>');
    $.ajax({
      url: "/patrimonial/compras/solicitacao/recupera-cod-estrutural?exercicio=" + fieldExercicioValue + "&codDotacao=" + fieldDotacaoValue,
      method: "GET",
      dataType: "json",
      success: function (data) {
        var options = "";
        fieldCodEstrutural.parent().find('div').find('span').first().html('Selecione');
        if (data != null) {
          fieldCodEstrutural.find('option').remove();
          $.each(data, function (key, value) {
            options += '<option value="' + value.cod_estrutural + '">' +  value.cod_estrutural + ' - ' + value.descricao + '</option>';
            fieldCodEstrutural.html(options);
          });
        } else {
          fieldCodEstrutural.parent().find('div').find('span').first().html('Selecione');
          fieldCodEstrutural.html(options);
        }
        fechaModal();
      }
    });
  }


  fieldvalorUnitario.on('focusout', function (e) {
      var fieldvalorUnitarioValue = $(this).val(),
        fieldQuantidadeValue = fieldQuantidade.val();

      setValorTotal(fieldvalorUnitarioValue, fieldQuantidadeValue);
  });

  fieldQuantidade.on('focusout', function (e) {
      var fieldvalorUnitarioValue = fieldvalorUnitario.val(),
        fieldQuantidadeValue = $(this).val();

      setValorTotal(fieldvalorUnitarioValue, fieldQuantidadeValue);
  });

  // Set valor total e envia para tratamento [método::retornaValorTotal]
  function setValorTotal(fieldvalorUnitarioValue, fieldQuantidadeValue) {

      fieldvalorUnitarioValue = replaceAll(fieldvalorUnitarioValue, '.', '').replace(',', '.');
      fieldQuantidadeValue = replaceAll(fieldQuantidadeValue, '.', '').replace(',', '.');

      fieldVlTotalValue = retornaValorTotal(fieldvalorUnitarioValue, fieldQuantidadeValue);
      fieldVlTotalString = String(fieldVlTotalValue);

      fieldVlTotalHiddenValue = replaceAll(fieldVlTotalString, '.', '').replace(',', '.');

      fieldVlTotal.val(fieldVlTotalValue);
      fieldvlTotalHidden.val(fieldVlTotalHiddenValue);
  }

  // Trata Valores [multiplica total por qnt]
  function retornaValorTotal(fieldvalorUnitarioValue, fieldQuantidadeValue) {

    fieldvalorUnitarioValue >= 0 && fieldQuantidadeValue >= 0 ? fieldVlTotalValue = (fieldvalorUnitarioValue * fieldQuantidadeValue) : fieldVlTotalValue = '';

    if(fieldVlTotalValue != '')
      fieldVlTotalValue = moeda(fieldVlTotalValue, 2, ',', '.');
    return fieldVlTotalValue;
  }

  // Converte em formato moeda
  function moeda(valor, casas, separdor_decimal, separador_milhar){

    var valor_total = parseInt(valor * (Math.pow(10,casas)));
    var inteiros =  parseInt(parseInt(valor * (Math.pow(10,casas))) / parseFloat(Math.pow(10,casas)));
    var centavos = parseInt(parseInt(valor * (Math.pow(10,casas))) % parseFloat(Math.pow(10,casas)));

    if(centavos%10 == 0 && centavos+"".length<2 ){
      centavos = centavos+"0";
    }else if(centavos<10){
      centavos = "0"+centavos;
    }

    var milhares = parseInt(inteiros/1000);
    inteiros = inteiros % 1000;

    var retorno = "";

    if(milhares>0){
      retorno = milhares+""+separador_milhar+""+retorno
      if(inteiros == 0){
        inteiros = "000";
      } else if(inteiros < 10){
        inteiros = "00"+inteiros;
      } else if(inteiros < 100){
        inteiros = "0"+inteiros;
      }
    }
    retorno += inteiros+""+separdor_decimal+""+centavos;

    return retorno;
  }

  // Replace All
  function replaceAll(string, token, newtoken) {
    while (string.indexOf(token) != -1) {
      string = string.replace(token, newtoken);
    }
    return string;
  }


  function reload() {
    var fieldvalorUnitarioValue = fieldvalorUnitario.val(),
      fieldQuantidadeValue = fieldQuantidade.val();
    setValorTotal(fieldvalorUnitarioValue, fieldQuantidadeValue);
  }

  reload();

}());
