(function ($, global) {
  'use strict';

  var helper = $.saidasDiversasHelper();

  $(document).on('change', 'select[id$="_centro"]', function (e) {
    var collectionNumber = helper.getFieldCollectionNumber(this)
      , fieldCentroCusto = this
      , fieldsInCollection = helper.getFieldsInCollection(collectionNumber);

    global.formData[collectionNumber].codCentro = $(this).val();

    if (global.formData[collectionNumber].codCentro != ""
        && global.formData[collectionNumber].codCentro != null) {

      var perecivelEndPoint = $.perecivelEndPoint(
        global.codAlmoxarifado,
        global.formData[collectionNumber].codItem,
        global.formData[collectionNumber].codMarca,
        global.formData[collectionNumber].codCentro
      );

      perecivelEndPoint.requestData()
        .success(function (dataJson) {

          global.formData[collectionNumber].pereciveis = dataJson;

          perecivelEndPoint.requestDataAsHtml()
            .success(function (dataTable) {
              var fieldsetContainer = helper.getFieldsetInCollection(fieldCentroCusto)
                , dataTableElem = $(dataTable)
                , fkName = 'fkAlmoxarifadoLancamentoMateriais'
                , fieldAdminName = 'quantidadePerecivel'
                , fieldAbsContainer = fieldsetContainer.find('div.sonata-ba-field-' + [UrbemSonata.uniqId, fkName].join('_') + '-' + fieldAdminName)
                , fieldContainer = fieldAbsContainer.find('div#sonata-ba-field-container-' + [UrbemSonata.uniqId, fkName, collectionNumber, fieldAdminName].join('_'));

              $.each(dataJson, function (index) {

                var fieldQuantidadeBuilder = $.fieldBuilderHelper()
                  , fieldId = [fkName, collectionNumber, fieldAdminName, dataJson[index].lote].join('_')
                  , fieldName = [fkName, collectionNumber, fieldAdminName, dataJson[index].lote].join('][');

                fieldName = '[' + fieldName + ']';

                fieldQuantidadeBuilder
                  .addClassToField('quantity')
                  .setFieldId(fieldId)
                  .setFieldName(fieldName)
                  .build();

                var thElem = $('<th/>', { class: 'th-rh right-align', text: 'Quantidade' })
                  , tdElem = $('<td/>', { class: 'td-rh right-align' })
                  , trElem = dataTableElem.find('tr#perecivel_' + index);

                fieldAbsContainer.find('.form_row.col.s3.campo-sonata').removeClass('s3').addClass('s12');

                dataTableElem
                  .find('thead > tr')
                  .append(thElem);

                tdElem.append(fieldQuantidadeBuilder.getField());
                trElem.append(tdElem);

                fieldContainer.find('div.sonata-ba-field').html(dataTableElem);
              });

              if (dataJson.length > 0) {
                helper.setAsInvisible(fieldsInCollection.quantidade);
              }
            });
      });
    }
  });
})(jQuery, window);
