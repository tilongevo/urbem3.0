(function ($, global) {
  'use strict';

  var almoxarifadoField = UrbemSonata.giveMeBackMyField('almoxarifado')
    , helper = jQuery.saidasDiversasHelper();

  $(document).on('sonata.add_element', function (e) {
    if (almoxarifadoField.val() != "") {
      $(document)
        .find('input[id$=_fkAlmoxarifadoCatalogoItem_autocomplete_input]')
        .select2('enable');
    } else {
      $(document)
        .find('input[id$=_fkAlmoxarifadoCatalogoItem_autocomplete_input]')
        .select2('disable');
    }
  });

  $(document).on('change', 'input[id$="_fkAlmoxarifadoCatalogoItem_autocomplete_input"]', function (e) {
    var collectionNumber = helper.getFieldCollectionNumber(this)
      , fieldsInCollection = helper.getFieldsInCollection(collectionNumber);

    global.formData[collectionNumber] = {};

    if ($(this).val() != ""
        && $(this).val() != null) {

      global.formData[collectionNumber].codItem = $(this).val();

      var catalogoItemEndPoint = $.catalogoItemEndPoint(global.formData[collectionNumber].codItem)
        , uriEndPoint = '/patrimonial/almoxarifado/requisicao-item/search/marcas'
        , modal = $.urbemModal();

      uriEndPoint += '/' + global.codAlmoxarifado;
      uriEndPoint += '/' +  global.formData[collectionNumber].codItem;

      catalogoItemEndPoint.success(function (catalogoItem) {
        var customFieldsInCollection = helper.getCustomInCollection(collectionNumber)
          , divElem = $('<div style="padding: 5px;"/>').text(catalogoItem.unidadeMedida);

        global.formData[collectionNumber].catalogoItem = catalogoItem;

        customFieldsInCollection
          .unidadeMedida
          .html(divElem);
      });

      $.ajax({
        method: 'GET',
        url: uriEndPoint,
        dataType: 'json',
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando marcas disponiveis.')
            .open();
        },
        success: function (data) {
          UrbemSonata.populateSelect(fieldsInCollection.marca, data, {
            value: "value",
            label: "label"
          });

          modal.close();
        },
        error: function (xhr, textStatus, error) {
          modal.close();

          modal
            .disableBackdrop()
            .setTitle(error)
            .setBody('Não foi possivel buscar marcas disponiveis.<br/>Contate o administrador do Sistema.')
            .open();

          global.setTimeout(function(){
            modal.close();
          }, 5000);
        }
      });
    } else {
      var firstOption = fieldsInCollection.marca.find('option:first-child');
      fieldsInCollection
        .marca
        .empty()
        .append(firstOption)
        .val('')
        .trigger('change');
    }
  });
})(jQuery, window);
