(function ($, global) {
  'use strict';

  var helper = $.saidasDiversasHelper();

  $(document).on('change', 'select[id$="_marca"]', function (e) {
    var collectionNumber = helper.getFieldCollectionNumber(this)
      , fieldsInCollection = helper.getFieldsInCollection(collectionNumber);

    global.formData[collectionNumber].codMarca = $(this).val();

    if (global.formData[collectionNumber].codMarca != null
        && global.formData[collectionNumber].codMarca != "") {

      var uriEndPoint = '/patrimonial/almoxarifado/requisicao-item/search/centros-custo'
        , modal = $.urbemModal();

      uriEndPoint += '/' + global.codAlmoxarifado;
      uriEndPoint += '/' + global.formData[collectionNumber].codItem;
      uriEndPoint += '/' + global.formData[collectionNumber].codMarca;

      $.ajax({
        method: 'GET',
        url: uriEndPoint,
        dataType: 'json',
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando centros de custos disponiveis.')
            .open();
        },
        success: function (data) {
          UrbemSonata.populateSelect(fieldsInCollection.centro, data, {
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
            .setBody('Não foi possivel buscar centros de custos disponiveis.<br/>Contate o administrador do Sistema.')
            .open();

          global.setTimeout(function(){
            modal.close();
          }, 5000);
        }
      });
    } else {
      var firstOption = fieldsInCollection.centro.find('option:first-child');
      fieldsInCollection.centro
        .empty()
        .append(firstOption)
        .val('')
        .trigger('change');
    }
  });
})(jQuery, window);
