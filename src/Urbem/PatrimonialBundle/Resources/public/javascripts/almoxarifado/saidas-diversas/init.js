(function ($, global) {
  'use strict';

  global.formData = {};

  var fieldHelper = $.saidasDiversasHelper();

  $(document).on('sonata.add_element', function (e) {
    $('[data-show="when-has-dynamic-field"]').hide();
    $('[data-show="when-has-perecivel-field"]').hide();

    fieldHelper.setAsInvisible($('input[id$="_km"]'));
    fieldHelper.setAsInvisible($('input[id$="_veiculo_autocomplete_input"]'));
  });
})(jQuery, window);
