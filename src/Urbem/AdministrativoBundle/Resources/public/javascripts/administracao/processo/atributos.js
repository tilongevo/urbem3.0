(function ($, urbem) {
  'use strict';

  var modal = $.urbemModal()
    , fieldFkSwAssunto = urbem.giveMeBackMyField('fkSwAssunto')
    , containerAtributoDinamico = $('.atributosProcesso > .box-body');

  function loadAtributosDinamicosDoProcesso(assuntoObjectKey) {
    if (assuntoObjectKey !== undefined && assuntoObjectKey !== "") {
      $.ajax({
        url: '/administrativo/protocolo/processo/assunto/{id}/atributo-dinamico'.replace('{id}', assuntoObjectKey),
        method: 'GET',
        dataType: 'html',
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando atributos desse assunto.')
            .open();
        },
        success: function (data) {
          containerAtributoDinamico.html(data);
          modal.close();

          containerAtributoDinamico.find('.select2-parameters').select2();
        }
      });
    }
  }

  loadAtributosDinamicosDoProcesso(fieldFkSwAssunto.val());

  fieldFkSwAssunto.on('change', function () {
    var codAssunto = $(this).val();

    loadAtributosDinamicosDoProcesso(codAssunto);
  });

})(jQuery, UrbemSonata);
