(function () {
  'use strict';

  var getFieldContainer = function ($field) {
      var containerPrefix = '#sonata-ba-field-container-',
        fieldId = $field.attr('id');

      return jQuery(containerPrefix + fieldId);
    },
    numericOnly = function (event) {
      var regex = new RegExp("^[0-9\b]+$")
        , key = String.fromCharCode(!event.charCode ? event.which : event.charCode);

      if (!regex.test(key)) {
        event.preventDefault();
        return false;
      }
    },
    hideCatalogoItemCustomFields = function () {
      var fieldsAtributosDinamicos = jQuery('[data-show="when-atributo-dinamico"]')
        , fieldsBemPatrimonial = jQuery('[data-show="when-patrimonio"]')
        , fieldsPereciveis = jQuery('[data-show="when-perecivel"]');

      jQuery.each(fieldsAtributosDinamicos, function (index) {
        getFieldContainer(jQuery(fieldsAtributosDinamicos[index])).hide();
      });

      jQuery.each(fieldsBemPatrimonial, function (index) {
        getFieldContainer(jQuery(fieldsBemPatrimonial[index])).hide();
      });

      jQuery.each(fieldsPereciveis, function (index) {
        getFieldContainer(jQuery(fieldsPereciveis[index])).hide();
      });
    },
    showAllCatalogoItemPerecivelFields = function () {
      var fieldsPereciveis = jQuery('[data-show="when-perecivel"]');

      jQuery.each(fieldsPereciveis, function (index) {
        getFieldContainer(jQuery(fieldsPereciveis[index])).show();
      });
    },
    showAllCatalogoItemPatrimonioFields = function () {
      var fieldsBemPatrimonial = jQuery('[data-show="when-patrimonio"]');

      jQuery.each(fieldsBemPatrimonial, function (index) {
        getFieldContainer(jQuery(fieldsBemPatrimonial[index])).show();
      });
    };

  $(document).on('keypress', '.only-number', numericOnly);

  var urlCatalogoItemInfo = "/patrimonial/almoxarifado/catalogo-item/{id}/info"
    , collectionAdminPrefix = "fkAlmoxarifadoLancamentoMateriais_"
    , catalogDynamicItems = []
    , collectionCount = 0;


    $(document).on('click', '.load-more', function () {
        if (collectionCount > 0) {
            catalogDynamicItems = [];
            for (var inc = 0; inc < collectionCount; inc++) {
                var prefixFieldNameBefore = collectionAdminPrefix + (collectionCount === undefined ? 0 : inc)
                    , nameFieldItem = prefixFieldNameBefore + "_item"
                    , nameFieldMarca = prefixFieldNameBefore + "_marca"
                    , nameFieldCodigoBarras = prefixFieldNameBefore + "_codigoBarras"
                    , nameFieldCentro = prefixFieldNameBefore + "_centro"
                    , nameFieldQuantidade = prefixFieldNameBefore + "_quantidade"
                    , nameFieldValorMercado = prefixFieldNameBefore + "_valorMercado"
                    , catalogoItemBefore = UrbemSonata.giveMeBackMyField(nameFieldItem)
                    , catalogoMarcaBefore = UrbemSonata.giveMeBackMyField(nameFieldMarca)
                    , catalogoCodigoBarrasBefore = UrbemSonata.giveMeBackMyField(nameFieldCodigoBarras)
                    , catalogoCentroBefore = UrbemSonata.giveMeBackMyField(nameFieldCentro)
                    , catalogoQuantidadeBefore = UrbemSonata.giveMeBackMyField(nameFieldQuantidade)
                    , catalogoValorMercadoBefore = UrbemSonata.giveMeBackMyField(nameFieldValorMercado)
                    , catalogDynamicItemsObject = []
                    , fields = [];

                var item = {};
                item.id = (catalogoItemBefore.select2('data') != null ? catalogoItemBefore.select2('data').id : '');
                item.label = (catalogoItemBefore.select2('data') != null ? catalogoItemBefore.select2('data').label: '');
                item.name = nameFieldItem;
                item.type = 1;
                catalogDynamicItemsObject.push(item);

                item = {};
                item.id = (catalogoMarcaBefore.select2('data') != null ? catalogoMarcaBefore.select2('data').id : '');
                item.label = (catalogoMarcaBefore.select2('data') != null ? catalogoMarcaBefore.select2('data').label : '');
                item.name = nameFieldMarca;
                item.type = 1;
                catalogDynamicItemsObject.push(item);

                item = {};
                item.content = catalogoCodigoBarrasBefore.val();
                item.name = nameFieldCodigoBarras;
                item.type = 2;
                catalogDynamicItemsObject.push(item);

                item = {};
                item.content = catalogoCodigoBarrasBefore.val();
                item.name = nameFieldCodigoBarras;
                item.type = 2;
                catalogDynamicItemsObject.push(item);

                item = {};
                item.id = (catalogoCentroBefore.select2('data') != null ? catalogoCentroBefore.select2('data').id : '');
                item.label = (catalogoCentroBefore.select2('data') != null ? catalogoCentroBefore.select2('data').label : '');
                item.name = nameFieldCentro;
                item.type = 1;
                catalogDynamicItemsObject.push(item);

                item = {};
                item.content = catalogoQuantidadeBefore.val();
                item.name = nameFieldQuantidade;
                item.type = 2;
                catalogDynamicItemsObject.push(item);

                item = {};
                item.content = catalogoValorMercadoBefore.val();
                item.name = nameFieldValorMercado;
                item.type = 2;
                catalogDynamicItemsObject.push(item);

                catalogDynamicItems.push(catalogDynamicItemsObject);
            }

        }
    });

  // Esconde campos e elementos ao clicar para adicionar mais no sonata_type_collection
  $(document).on('sonata.add_element', function (e) {

      UrbemSonata.backDynamicItems(catalogDynamicItems);

    hideCatalogoItemCustomFields();
    var prefixFieldName = collectionAdminPrefix + (collectionCount === undefined ? 0 : collectionCount)
      , catalogoItemField = UrbemSonata.giveMeBackMyField(prefixFieldName + "_item")
      , codModuloField = UrbemSonata.giveMeBackMyField(prefixFieldName + '_codModulo')
      , codCadastroField = UrbemSonata.giveMeBackMyField(prefixFieldName + '_codCadastro')
      , atributosDinamicosField = UrbemSonata.giveMeBackMyField(prefixFieldName + "_atributosDinamicos");


    if (undefined !== catalogoItemField) {

      // console.log(catalogoItemField.attr('id'));
      jQuery(document).on('change', '#' + catalogoItemField.attr('id'), function (e) {
        var catalogoItemObjectId = jQuery(this).val()
          , idPieces = jQuery(this).attr('id').split('_')
          , prefixFieldAtibutoDinamicoId = idPieces[1] + '_' + idPieces[2] + '_atributos-dinamicos'
          , finalUrlCatalogoItemInfo = urlCatalogoItemInfo.replace("{id}", catalogoItemObjectId);

        getFieldContainer(jQuery(atributosDinamicosField))
          .after('<div id="' + prefixFieldAtibutoDinamicoId + '" class="col s12"></div>');

        var modalLoading = jQuery.urbemModal();

        jQuery.ajax({
          method: 'GET',
          url: finalUrlCatalogoItemInfo,
          beforeSend: function (xhr) {
            modalLoading
              .disableBackdrop()
              .setTitle('Aguarde...')
              .setBody('Verificando campos de itens pereciveis e itens de patrimonio.')
              .open();
          },
          success: function (data) {
            if (data.tipo !== undefined) {
              switch (data.tipo) {
                case "perecivel":
                  showAllCatalogoItemPerecivelFields();
                  break;
                case "patrimonio":
                  showAllCatalogoItemPatrimonioFields();
                  break;
              }
            }

            modalLoading.close();

            jQuery.ajax({
              method: 'POST',
              url: '/administrativo/administracao/atributo/consultar-campos/',
              dataType: 'json',
              data: {
                tabela: 'CoreBundle:Almoxarifado\\LancamentoMaterial',
                fkTabela: 'getFkAlmoxarifadoAtributoEstoqueMaterialValores',
                // codTabela: catalogoItemObjectId,
                tabelaPai: 'CoreBundle:Almoxarifado\\CatalogoItem',
                codTabelaPai: {
                  'codItem': catalogoItemObjectId
                },
                fkTabelaPaiCollection: 'getFkAlmoxarifadoAtributoCatalogoItens',
                fkTabelaPai: 'getFkAlmoxarifadoAtributoCatalogoItem',
                prefix: catalogoItemObjectId + '_' + idPieces[2]
              },
              beforeSend: function (xhr) {
                modalLoading
                  .disableBackdrop()
                  .setTitle('Aguarde...')
                  .setBody('Verificando campos dinamicos.')
                  .open();
              },
              success: function (data) {
                jQuery.each(data, function (index, value) {
                  if (value) {
                    $('#' + prefixFieldAtibutoDinamicoId).append(value);
                  }
                });

                modalLoading.close();
              }
            });
          }
        });
      });
    }

    collectionCount++;
  });

}());
