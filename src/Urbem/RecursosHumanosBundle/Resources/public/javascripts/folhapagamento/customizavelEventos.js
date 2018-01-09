$(function () {
  "use strict";

  var eventos = UrbemSonata.giveMeBackMyField('eventos'),
    eventosContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_eventos'),
    anoFinal = UrbemSonata.giveMeBackMyField('ano'),
    mesFinal = UrbemSonata.giveMeBackMyField('mes'),
    inCodComplementar = UrbemSonata.giveMeBackMyField('inCodComplementar'),
    configuracao = UrbemSonata.giveMeBackMyField('tipoCalculo')
  ;

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

  $('form').submit(function () {
    var count = eventos.select2('data').length;
    if (count > 6) {
      mensagemErro(eventosContainer, 'Só é permitido no máximo 6 eventos');
      return false;
    }
    return true;
  });

  function mensagemErro(campo, memsagem) {
    var message = '<div class="help-block sonata-ba-field-error-messages">' +
      '<ul class="list-unstyled">' +
      '<li><i class="fa fa-exclamation-circle"></i> ' + memsagem + '</li>' +
      '</ul></div>';
    campo.after(message);
  }
}());
