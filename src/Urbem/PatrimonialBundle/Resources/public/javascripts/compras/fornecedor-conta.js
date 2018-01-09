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
    numContaField = UrbemSonata.giveMeBackMyField("numConta"),
    populateAgenciaField = function (fieldBanco) {
      var codBanco = fieldBanco.val();

      UrbemSearch
        .findAgenciasByBanco(codBanco)
        .success(function (data) {
          populateSelect(codAgenciaField, data, {value: 'codAgencia', text: 'nomAgencia'});

          if (data.length > 0) {
            codAgenciaField.prop('disabled', false);
          }
        });
    },
    populateNumContaField = function (fieldBanco, fieldAgencia) {
      var codAgencia = fieldAgencia.val(),
        codBanco = fieldBanco.val();

      UrbemSonata.UrbemSearch
        .findContasCorrenteByAgencia(codBanco, codAgencia)
        .success(function (data) {
          populateSelect(numContaField, data, {value: 'numContaCorrente', text: 'numContaCorrente'});

          if (data.length > 0) {
            numContaField.prop('disabled', false);
          }
        });
    };

  // Se o field de Banco estiver vazio
  if (!codBancoField.val().trim()) {
    codAgenciaField.prop('disabled', true);
    numContaField.prop('disabled', true);
  } else {
    populateAgenciaField(codBancoField);
    populateNumContaField(codBancoField, codAgenciaField);
  }

  codBancoField.on('change', function (elem) {
    elem.stopPropagation();

    populateAgenciaField($(this));
  });

  codAgenciaField.on('change', function (elem) {
    elem.stopPropagation();

    populateNumContaField(codBancoField, $(this));
  });
}());
