(function () {
  'use strict';

  var anoInicial = UrbemSonata.giveMeBackMyField('anoInicial'),
    mesInicial = UrbemSonata.giveMeBackMyField('mesInicial'),
    anoFinal = UrbemSonata.giveMeBackMyField('anoFinal'),
    mesFinal = UrbemSonata.giveMeBackMyField('mesFinal'),
    configuracao = UrbemSonata.giveMeBackMyField('tipoCalculo'),
    inCodComplementar = UrbemSonata.giveMeBackMyField('inCodComplementar')
  ;

  anoInicial.on('change', function () {
    if ($(this).val() != '') {
      abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, buscando competências...</h4>');
      $.ajax({
        url: '/api-search-competencia-pagamento/preencher-competencia-folha-pagamento',
        method: "POST",
        data: {
          ano: $(this).val()
        },
        dataType: "json",
        success: function (data) {
          UrbemSonata.populateSelect(mesInicial, data, {value: 'id', label: 'label'}, mesInicial.data('mes'));
          fechaModal();
        }
      });
    }
  });

  anoFinal.on('change', function () {
    if ($(this).val() != '') {
      abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, buscando competências...</h4>');
      $.ajax({
        url: '/api-search-competencia-pagamento/preencher-competencia-folha-pagamento',
        method: "POST",
        data: {
          ano: $(this).val()
        },
        dataType: "json",
        success: function (data) {
          UrbemSonata.populateSelect(mesFinal, data, {value: 'id', label: 'label'}, mesFinal.data('mes'));
          fechaModal();
        }
      });
    }
  });

  mesFinal.on('change', function () {
    if (($(this).val() != '') && (configuracao.val() == '0')) {
      carregaComplementar(anoFinal.val(), mesFinal.val());
    }
  });

  function carregaComplementar(ano, mes) {
    if (ano != '' && mes != '') {

      abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, buscando folhas complementares...</h4>');
      $.ajax({
        url: '/recursos-humanos/folha-pagamento/relatorios/contra-cheque/consulta-folha-complementar',
        method: "POST",
        data: {
          ano: ano,
          mes: mes
        },
        dataType: "json",
        success: function (data) {
          UrbemSonata.populateSelect(inCodComplementar, data, {
            value: 'id',
            label: 'label'
          }, inCodComplementar.data('id'));
          fechaModal();
        }
      });
    }
  }

  configuracao.on('change', function () {
    if ($(this).val() != "") {
      if ($(this).val() == '0') {
        inCodComplementar.prop('disabled', false);
        if (anoFinal != '' && mesFinal.val() != '') {
          carregaComplementar(anoFinal.val(), mesFinal.val());
        }
      } else {
        inCodComplementar.prop('disabled', true);
      }
    }
  });

}());
