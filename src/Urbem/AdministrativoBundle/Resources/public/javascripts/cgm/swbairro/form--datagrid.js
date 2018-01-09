(function ($, urbem) {
  'use strict';

  var fkSwMunicipioField = $('#filter_fkSwMunicipio_value')
    , fkSwMunicipioFkSwUfField = $('#filter_fkSwMunicipio__fkSwUf_value')
    , rotaUri = '/administrativo/cgm/manutencao-bairro/consultar-municipio/{id}'
    , modal = $.urbemModal();

  fkSwMunicipioFkSwUfField.on('change', function () {
    var codUf = $(this).val();

    if (codUf !== '' && codUf !== undefined) {
      $.ajax({
        url: rotaUri.replace('{id}', codUf),
        method: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando municipios.')
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
          urbem.populateSelect(fkSwMunicipioField, data, {
            label: 'label',
            value: 'value'
          });

          fkSwMunicipioField.select2('enable');

          modal.close();

        }
      });
    } else {
      fkSwMunicipioField.empty();
      fkSwMunicipioField.select2('disable');
    }
  });

})(jQuery, UrbemSonata);
