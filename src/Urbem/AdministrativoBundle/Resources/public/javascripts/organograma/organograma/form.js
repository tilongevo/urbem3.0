(function ($, urbem, global) {
  'use strict';

  var modal = $.urbemModal()
    , valueCodTipoNorma = null;

  var fieldFkNormasTipoNorma = urbem.giveMeBackMyField('fkNormasNorma__fkNormasTipoNorma')
    , fieldFkNormasNorma = urbem.giveMeBackMyField('fkNormasNorma');

  var uriNormas = '/administrativo/organograma/organograma/consultar-norma/{id}';

  fieldFkNormasNorma.select2('disable');

  fieldFkNormasTipoNorma.on('change', function () {
    valueCodTipoNorma = $(this).val();

    if (valueCodTipoNorma !== "" && valueCodTipoNorma !== undefined) {
      $.ajax(uriNormas.replace('{id}', valueCodTipoNorma), {
        method: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando normas.')
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

          urbem.populateSelect(fieldFkNormasNorma, data, {label: 'label', value: 'value'});

          fieldFkNormasNorma.select2('enable');

          modal.close();
        }
      })
    }
  });
})(jQuery, UrbemSonata, window);
