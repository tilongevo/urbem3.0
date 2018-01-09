(function ($, global, urbem) {
  'use strict';

  var logradouroApi = global.logradouroApiUrl;

  global.varJsCodUf = 0;
  global.varJsCodMunicipio = 0;
  global.varJsCodUf1 = 0;
  global.varJsCodMunicipio1 = 0;
  global.varJsCodBairro = 0;
  global.varJsCodLogradouro = 0;


  var fieldSwLogradouro = urbem.giveMeBackMyField('swLogradouro')
    , fieldSwLogradouroCorresp = urbem.giveMeBackMyField('swLogradouroCorresp')
    , fieldSwBairro = urbem.giveMeBackMyField('swBairro')
    , fieldSwBairroCorresp = urbem.giveMeBackMyField('swBairroCorresp')
    , fieldSwCep = urbem.giveMeBackMyField('swCep')
    , fieldSwCepCorresp = urbem.giveMeBackMyField('swCepCorresp')
    , fieldSwUf = urbem.giveMeBackMyField('fkSwMunicipio__fkSwUf')
    , fieldSwMunicipio = urbem.giveMeBackMyField('fkSwMunicipio')
    , fieldSwUf1 = urbem.giveMeBackMyField('fkSwMunicipio1__fkSwUf')
    , fieldSwMunicipio1 = urbem.giveMeBackMyField('fkSwMunicipio1')
    , autocompleteSwLogradouro = $("#s2id_" + UrbemSonata.uniqId + "_swLogradouro_autocomplete_input")
    , autocompleteSwLogradouroCorresp = $("#s2id_" + UrbemSonata.uniqId + "_swLogradouroCorresp_autocomplete_input");

  function setVarJsCodUf(codUf) {
    if (codUf !== "" || codUf !== undefined) {
      global.varJsCodUf = codUf;
    }
  }

  function setVarJsCodLogradouro(codLogradouro) {
    if (codLogradouro !== "" || codLogradouro !== undefined) {
      global.varJsCodLogradouro = codLogradouro;
    }
  }

  function setVarJsCodMunicipio(codMunicipio) {
    if (codMunicipio !== "" || codMunicipio !== undefined) {
      global.varJsCodMunicipio = codMunicipio;
      autocompleteSwLogradouro.select2('enable');
      fieldSwBairro.select2('enable');
    }
  }

  function setVarJsCodUf1(codUf) {
    if (codUf !== "" || codUf !== undefined) {
      global.varJsCodUf1 = codUf;
    }
  }

  function setVarJsCodMunicipio1(codMunicipio) {
    if (codMunicipio !== "" || codMunicipio !== undefined) {
      global.varJsCodMunicipio1 = codMunicipio;
      autocompleteSwLogradouroCorresp.select2('enable');
    }
  }

  function setVarJsCodBairro(codBairro) {
    if (codBairro !== "" || codBairro !== undefined) {
        global.varJsCodBairro = codBairro;
    }
  }

  function populateBairrosCeps(codLogradouro) {
    if (codLogradouro !== undefined && codLogradouro !== '') {
      setVarJsCodLogradouro(codLogradouro);
      var modal = $.urbemModal();

      $.ajax({
        url: logradouroApi.replace('{id}', codLogradouro),
        method: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando dados adicionais do Logradouro.')
            .open();
        },
        error: function (xhr, textStatus, error) {
          modal.close();

          modal
            .disableBackdrop()
            .setTitle(error)
            .setBody('Contate o administrador do Sistema.')
            .open();

          global.setTimeout(function () {
            modal.close();
          }, 5000);
        },
        success: function (data) {

          urbem.populateSelect(fieldSwBairro, data.bairros, {
            label: 'nom_bairro',
            value: 'value'
          }, fieldSwBairro.val());

          urbem.populateSelect(fieldSwCep, data.ceps, {
            label: 'cep',
            value: 'value'
          }, fieldSwCep.val());

          fieldSwBairro.select2('enable');
          fieldSwCep.select2('enable');

          $('div.fkSwMunicipio_fkSwUf > div').text(data.uf);
          $('div.fkSwMunicipio > div').text(data.municipio);

          modal.close();
        }
      });
    }
  }

  fieldSwLogradouro.on('change', function (e) {
    populateBairrosCeps($(this).val());
  });

  function populateBairrosCepsCorresp(codLogradouroCorresp) {
    if (codLogradouroCorresp !== undefined && codLogradouroCorresp !== '') {
      var modal = $.urbemModal();

      $.ajax({
        url: logradouroApi.replace('{id}', codLogradouroCorresp),
        method: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando dados adicionais do Logradouro.')
            .open();
        },
        error: function (xhr, textStatus, error) {
          modal.close();

          modal
            .disableBackdrop()
            .setTitle(error)
            .setBody('Contate o administrador do Sistema.')
            .open();

          global.setTimeout(function () {
            modal.close();
          }, 5000);
        },
        success: function (data) {

          urbem.populateSelect(fieldSwBairroCorresp, data.bairros, {
            label: 'nom_bairro',
            value: 'value'
          }, fieldSwBairroCorresp.val());

          urbem.populateSelect(fieldSwCepCorresp, data.ceps, {
            label: 'cep',
            value: 'value'
          }, fieldSwCepCorresp.val());

          fieldSwBairroCorresp.select2('enable');
          fieldSwCepCorresp.select2('enable');

          $('div.fkSwMunicipio_fkSwUf1 > div').text(data.uf);
          $('div.fkSwMunicipio1 > div').text(data.municipio);

          modal.close();
        }
      });
    }
  }

  function setInitialVarJsValues() {
    if (fieldSwUf.val()) {
        setVarJsCodUf(fieldSwUf.val());
    }

    if (fieldSwMunicipio.val()) {
        setVarJsCodMunicipio(fieldSwMunicipio.val());
    }
  }

  fieldSwLogradouroCorresp.on('change', function (e) {
    populateBairrosCepsCorresp($(this).val());
  });

  $(document).ready(function () {
    populateBairrosCeps(fieldSwLogradouro.val());
    populateBairrosCepsCorresp(fieldSwLogradouroCorresp.val());

    fieldSwUf.on('change', function (e) {
      setVarJsCodUf($(this).val());
    });

    fieldSwMunicipio.on('change', function (e) {
      if (! $(this).val()) {
        autocompleteSwLogradouro.select2('disable');
        return;
      }
      setVarJsCodMunicipio($(this).val());
    });

    fieldSwUf1.on('change', function (e) {
      setVarJsCodUf1($(this).val());
    });

    fieldSwMunicipio1.on('change', function (e) {
      if (! $(this).val()) {
        autocompleteSwLogradouroCorresp.select2('disable');
        return;
      }
      setVarJsCodMunicipio1($(this).val());
    });

    fieldSwBairro.on('change', function (e) {
        setVarJsCodBairro($(this).val());
    });

    if (! fieldSwLogradouro.val()) {
        autocompleteSwLogradouro.select2('disable');
        autocompleteSwLogradouroCorresp.select2('disable');
    }

    setInitialVarJsValues();

  });

})(jQuery, window, UrbemSonata);
