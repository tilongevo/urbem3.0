(function ($, global) {
  'use strict';

  var helper = $.saidasDiversasHelper();

  $(document).on('change', 'input[id$="_fkAlmoxarifadoCatalogoItem_autocomplete_input"]', function (e) {
    var collectionNumber = helper.getFieldCollectionNumber(this);

    if ($(this).val() != ""
        && $(this).val() != null) {

      var uriEndPoint = '/patrimonial/frota/item/{codItem}/info'
        , fieldsInCollection = helper.getFieldsInCollection(collectionNumber);

      $.ajax({
        method: 'GET',
        url: uriEndPoint.replace('{codItem}', $(this).val()),
        dataType: 'json',
        success: function (data) {
          helper.setAsVisible(fieldsInCollection.km);
          helper.setAsVisible(fieldsInCollection.veiculo);
        }
      });
    }
  });
})(jQuery, window);
