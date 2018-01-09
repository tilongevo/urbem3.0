(function ($, global) {
  'use strict';

  var helper = $.saidasDiversasHelper();

  $(document).on('change', 'select[id$="_centro"]', function (e) {
    var collectionNumber = helper.getFieldCollectionNumber(this);

    global.formData[collectionNumber].codCentro = $(this).val();

    if (global.formData[collectionNumber].codCentro != null
        && global.formData[collectionNumber].codCentro != "") {

      var uriEndPoint = '/patrimonial/almoxarifado/requisicao-item/search/saldo-estoque'
        , modal = $.urbemModal()
        , customFieldsInCollection = helper.getCustomInCollection(collectionNumber);

      uriEndPoint += '/' + global.codAlmoxarifado;
      uriEndPoint += '/' + global.formData[collectionNumber].codItem;
      uriEndPoint += '/' + global.formData[collectionNumber].codMarca;
      uriEndPoint += '/' + global.formData[collectionNumber].codCentro;

      $.ajax({
        method: 'GET',
        url: uriEndPoint,
        dataType: 'json',
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando saldo em estoque.')
            .open();
        },
        success: function (data) {
          var divElem = $('<div style="padding: 5px;"/>').text(data.saldo_estoque.replace('.', ','));

          customFieldsInCollection
            .saldoEstoque
            .html(divElem);

          modal.close();
        },
        error: function (xhr, textStatus, error) {
          var divElem = $('<div style="padding-left: 5px;"/>').text(xhr.responseText);

          customFieldsInCollection
            .saldoEstoque
            .html(divElem);

          modal.close();
        }
      });
    }
  });

})(jQuery, window);
