(function ($, global) {
  'use strict';

  var helper = jQuery.saidasDiversasHelper();

  $(document).on('change', 'input[id$="_fkAlmoxarifadoCatalogoItem_autocomplete_input"]', function (e) {
    var collectionNumber = helper.getFieldCollectionNumber(this);

    if (global.formData[collectionNumber].codItem != ""
        && global.formData[collectionNumber].codItem != null) {

      var fieldsInCollection = helper.getFieldsInCollection(collectionNumber)
        , atributoDinamicoEndPoint = $.atributoDinamicoEndPoint(
            global.formData[collectionNumber].codItem,
            global.formData[collectionNumber].codItem + '_' + collectionNumber
          );

      atributoDinamicoEndPoint
        .requestData()
        .success(function (data) {

          var atributoDinamicoFieldId = fieldsInCollection.atributosDinamicos.prop('id')
            , atributoDinamicoDivId = '#sonata-ba-field-container-' + atributoDinamicoFieldId
            , atributoDinamicoFieldContainer = $(atributoDinamicoDivId).parent();

          var backUp = $('#sonata-ba-field-container-' + atributoDinamicoFieldId);

          atributoDinamicoFieldContainer.html("");

          if (data.length > 0) {
            $.each(data, function (index) {
              atributoDinamicoFieldContainer.append(data[index]);
            });
          }

          atributoDinamicoFieldContainer.append(backUp);
          helper.setAsInvisible(fieldsInCollection.atributosDinamicos);
        });
    }
  });
})(jQuery, window);
