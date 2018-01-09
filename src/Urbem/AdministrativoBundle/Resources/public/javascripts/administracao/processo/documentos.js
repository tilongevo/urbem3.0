(function ($, urbem) {
  'use strict';

  var modal = $.urbemModal()
    , fieldFkSwAssunto = urbem.giveMeBackMyField('fkSwAssunto');

  function loadDocumentoProcesso(assuntoObjectKey) {
    if (assuntoObjectKey !== undefined && assuntoObjectKey !== "") {
      $.ajax({
        url: '/administrativo/protocolo/processo/assunto/{id}/documentos'.replace('{id}', assuntoObjectKey),
        method: 'GET',
        dataType: 'html',
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando documentos necessários para esse assunto.')
            .open();
        },
        success: function (data) {
          $('.documentosProcesso > .box-body').html(data);
          modal.close();

          $('form').attr('enctype', 'multipart/form-data');
        }
      });
    }
  }

  fieldFkSwAssunto.on('change', function () {
    var codAssunto = $(this).val();

    loadDocumentoProcesso(codAssunto);
  });

})(jQuery, UrbemSonata);
