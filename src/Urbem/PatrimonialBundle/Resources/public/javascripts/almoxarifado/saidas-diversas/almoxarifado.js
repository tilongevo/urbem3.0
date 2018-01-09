(function ($, global) {
  'use strict';

  var almoxarifadoField = UrbemSonata.giveMeBackMyField('almoxarifado');

  almoxarifadoField.on('change', function (e) {
    /**
     * Verifica e habilita os campos de itens nas collections caso o almoxarifado tenha sido preenchido.
     * Caso o usuario volte atras deixado o campo almoxarifado desabilitado, os campos de item e seus dependentes
     * serao desativados tambem.
     */
    if ($(this).val() != ""
        && $(this).val() != null) {
      
      global.varJsCodAlmoxarifado = $(this).val();
      global.codAlmoxarifado = global.varJsCodAlmoxarifado;

      var itemsFieldCollection = $(document).find('input[id$="_fkAlmoxarifadoCatalogoItem_autocomplete_input"]');

      $.each(itemsFieldCollection, function (index, elem) {
        $(document)
          .find('input[id$="_fkAlmoxarifadoCatalogoItem_autocomplete_input"]')
          .select2('enable')
          .val('')
          .trigger('change');
      });

    } else {
      $(document)
        .find('input[id$="_fkAlmoxarifadoCatalogoItem_autocomplete_input"]')
        .select2('disable')
        .val('')
        .trigger('change');
    }
  });

})(jQuery, window);
