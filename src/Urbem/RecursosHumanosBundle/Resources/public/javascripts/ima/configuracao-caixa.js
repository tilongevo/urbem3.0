(function () {
  'use strict';

  function populateSelect(select, data, prop) {
    var selectedOption = select.find('option:selected');

    UrbemSonata.populateSelect(select, data, {
      value: "codContaCorrente",
      label: "numContaCorrente"
    }, selectedOption);
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
