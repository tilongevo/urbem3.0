(function () {
  'use strict';

  function populateSelect(select, data, prop) {
    var firstOption = select.find('option:first-child'),
      selectedOption = select.find('option:selected');

    select.empty().append(firstOption);

    $.each(data, function (index, item) {
      var attrs = {
        value: item[prop.value],
        text: item[prop.text]
      };

      if (selectedOption.val() == item[prop.value]) {
        attrs.selected = true;
      }

      select.append($('<option>', attrs));
    });

    select.select2();
  }

  var UrbemSearch = UrbemSonata.UrbemSearch,
    regexpClassificacaoCreate = /create\?id\=[0-9]+/,
    locationHref = document.location.href,
    fieldCodCatalogo = UrbemSonata.giveMeBackMyField('codCatalogo'),
    fieldCodClassificacao = UrbemSonata.giveMeBackMyField('fkAlmoxarifadoCatalogoClassificacao'),
    populateFieldCodClassificacao = function (codCatalogo) {
      UrbemSearch
        .findClassificacaoByCatalogo(codCatalogo)
        .success(function (data) {
          data.forEach(function (item, index) {
            data[index].customView = item.codEstrutural + " - " + item.descricao.toUpperCase();
          });

          populateSelect(fieldCodClassificacao, data, {
            value: 'fkAlmoxarifadoCatalogoClassificacao',
            text: 'customView'
          });

          fieldCodClassificacao.prop('disabled', false);
        });
    };

  if (regexpClassificacaoCreate.test(locationHref)) {
    fieldCodClassificacao.prop('disabled', true);
  }

  if (fieldCodCatalogo.val() != "") {
    populateFieldCodClassificacao(fieldCodCatalogo.val());
  }

  fieldCodCatalogo.on('change', function () {
    populateFieldCodClassificacao($(this).val());
  });
}());
