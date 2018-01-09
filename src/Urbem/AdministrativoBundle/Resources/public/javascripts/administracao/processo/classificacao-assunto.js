(function ($, urbem) {
  'use strict';

  var modal = $.urbemModal();

  var fieldSwClassificacao = urbem.giveMeBackMyField('swClassificacao')
    , fieldFkSwAssunto = urbem.giveMeBackMyField('fkSwAssunto');

  $(document).ready(function (e) {
    fieldFkSwAssunto.select2('disable');
  });

  function loadFieldFkSwAssuntoData(codClassificacao) {
    if (codClassificacao !== undefined && codClassificacao !== "") {
      $.ajax({
        url: '/administrativo/protocolo/processo/assunto-classificacao',
        method: 'GET',
        data: {
          codClassificacao: codClassificacao
        },
        dataType: 'json',
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando assuntos dessa Classificação.')
            .open();
        },
        success: function (data) {
          urbem.populateSelect(fieldFkSwAssunto, data, {
            label: 'label',
            value: 'value'
          }, fieldFkSwAssunto.val());

          modal.close();
          fieldFkSwAssunto.select2('enable');
        }
      });
    } else {
      fieldFkSwAssunto
        .val('')
        .trigger('change')
        .select2('disable');
    }
  }

  loadFieldFkSwAssuntoData(fieldSwClassificacao.val());

  fieldSwClassificacao.on('change', function (e) {
    var codClassificacao = $(this).val();
    loadFieldFkSwAssuntoData(codClassificacao);
  });

})(jQuery, UrbemSonata);
