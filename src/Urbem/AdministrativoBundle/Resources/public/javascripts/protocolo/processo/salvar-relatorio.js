(function ($, urbem, global) {
  'use strict';

  var fieldFormTypeAssinaturas = urbem.giveMeBackMyField('formType_assinaturas')
    , fieldFormTypeEntidade = urbem.giveMeBackMyField('formType_entidade')
    , fieldFormTypeModulo = urbem.giveMeBackMyField('formType_modulo');

  var urlApi = '/administrativo/administracao/assinatura/api/search/{entidade}/{modulo}'
    , modal = $.urbemModal();

  $(document).ready(function (e) {
    fieldFormTypeAssinaturas.select2('disable');
  });

  function loadAssinaturasDoProcesso(entidadeObjectKey, moduloObjectKey) {
    if (entidadeObjectKey !== undefined && entidadeObjectKey !== "") {
      var url = urlApi
        .replace('{entidade}', entidadeObjectKey)
        .replace('{modulo}', moduloObjectKey);

      $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando assinaturas.')
            .open();
        },
        error: function (xhr, textStatus, error) {
          modal.close();

          modal
            .disableBackdrop()
            .setTitle(error)
            .setBody('Contate o administrador do Sistema.')
            .open();

          global.setTimeout(function () {
            modal.close();
          }, 5000);
        },
        success: function (data) {

          urbem.populateSelect(fieldFormTypeAssinaturas, data.items, {
            label: 'label',
            value: 'value'
          });

          fieldFormTypeAssinaturas.select2('enable');

          modal.close();
        }
      });
    } else {
      fieldFormTypeAssinaturas
        .val('')
        .trigger('change')
        .select2('disable');
    }
  }

  fieldFormTypeEntidade.on('change', function (e) {
    loadAssinaturasDoProcesso($(this).val(), fieldFormTypeModulo.val());
  });

})(jQuery, UrbemSonata, window);
