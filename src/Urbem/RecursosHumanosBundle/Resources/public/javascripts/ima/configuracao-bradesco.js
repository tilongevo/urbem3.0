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
    codBancoField = UrbemSonata.giveMeBackMyField("codBanco"),
    codAgenciaField = UrbemSonata.giveMeBackMyField("codAgencia"),
    numContaField = UrbemSonata.giveMeBackMyField("codContaCorrente"),
    populateNumContaField = function (fieldBanco, fieldAgencia) {
      var codAgencia = fieldAgencia.val(),
        codBanco = fieldBanco.val();

      UrbemSonata.UrbemSearch
        .findContasCorrenteByAgencia(codBanco, codAgencia)
        .success(function (data) {
          populateSelect(numContaField, data, {value: 'codContaCorrente', text: 'numContaCorrente'});

          if (data.length > 0) {
            numContaField.prop('disabled', false);
          }
        });
    };


  codAgenciaField.on('change', function (elem) {
    elem.stopPropagation();

    populateNumContaField(codBancoField, $(this));
  });
}());
