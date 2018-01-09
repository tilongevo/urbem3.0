(function ($, urbem) {
  'use strict';

  var tipo = urbem.giveMeBackMyField('tipo', true),
    codContrato = urbem.giveMeBackMyField('codContrato', true),
    lotacao = urbem.giveMeBackMyField('lotacao', true),
    local = urbem.giveMeBackMyField('local', true),
    codContratoValue = $('#filter_codContrato_value_autocomplete_input', true),
    localValue = $('#filter_local_value_autocomplete_input', true),
    lotacaoValue = $('#filter_lotacao_value_autocomplete_input', true),
    cargo = urbem.giveMeBackMyField('cargo', true),
    funcao = urbem.giveMeBackMyField('funcao', true),
    especialidade = urbem.giveMeBackMyField('especialidade', true),
    padrao = urbem.giveMeBackMyField('padrao', true),
    camposArray = [
      'codContrato',
      'lotacao',
      'local',
      'cargo',
      'padrao',
      'especialidade'
    ];

  var modalLoad = new UrbemModal();
  modalLoad.setTitle('Carregando...');

  function desabilitaAll(camposArray) {
    $.each(camposArray, function (index, value) {
      var campo = urbem.giveMeBackMyField(value, true);

      if ((value == 'codContrato') && (typeof(campo) !== 'undefined')) {
        codContrato.select2('disable');
      }

      if ((value == 'cargo') && (typeof(campo) !== 'undefined')) {
        cargo.select2('disable');
      }

      if (typeof (campo) !== 'undefined') {
        campo.prop('disabled', true);
      }
    });
  }

  function habilitaCampo(camposArray, campoAHabilitar) {
    $.each(camposArray, function (index, value) {
      var campo = urbem.giveMeBackMyField(value, true);
      if ((value == 'codContrato') && (typeof(campo) !== 'undefined') && (value != campoAHabilitar)) {
        codContrato.select2('disable');
        limpaCampo(campo);
      } else if ('codContrato' == campoAHabilitar) {
        codContrato.select2('enable');
      }

      if ((value == 'cargo') && (typeof(campo) !== 'undefined') && (value != campoAHabilitar)) {
        campo.select2('disable');
        limpaCampo(campo);
      } else if ('cargo' == campoAHabilitar) {
        cargo.select2('enable');
        cargo.prop('disabled', true);
      }

      if ((typeof (campo) !== 'undefined') && (value != campoAHabilitar)) {
        campo.prop('disabled', true);
        limpaCampo(campo);
      } else if (value == campoAHabilitar) {
        campo.prop('disabled', false);
      }
    });
  }

  tipo.on('change', function () {
    switch ($(this).val()) {
      case 'cgm_contrato':
        habilitaCampo(camposArray, 'codContrato');
        $('#filter_codContrato_value_autocomplete_input').attr('required', true);
        break;
      case 'lotacao':
        habilitaCampo(camposArray, $(this).val());
        break;
      case 'local':
        habilitaCampo(camposArray, $(this).val());
        break;
      case 'funcao':
        habilitaCampo(camposArray, 'cargo');
        $('#filter-' + urbem.uniqId + '-cargo').find('label').text('Função');
        $('#filter_cargo_value_autocomplete_input').attr('required', true);
        break;
      case 'cargo':
        habilitaCampo(camposArray, $(this).val());
        $('#filter-' + urbem.uniqId + '-cargo').find('label').text('Cargo');
        $('#filter_cargo_value_autocomplete_input').attr('required', true);
        break;
      case 'padrao':
        habilitaCampo(camposArray, $(this).val());
        break;
      default:
        desabilitaAll(camposArray);
        limpaCampo(codContrato);
        limpaCampo(lotacao);
        limpaCampo(local);
        limpaCampo(cargo);
        limpaCampo(padrao);
        limpaCampo(especialidade);
        break;
    }
  });

  function removeElements(campo) {
    $('#filter_' + campo + '_value_hidden_inputs_wrap').find('input').each(function (index, val) {
      val.remove();
    });
  }

  function limpaCampo(campo) {
    if (campo.selector == '#filter_cargo_value_autocomplete_input') {
      $('#filter_cargo_value_autocomplete_input').select2('val', '');
    } else {
     campo.prop('disabled', true);
     campo.select2('data', null);
    }
  }

  function carregarEspecialidades(codCargo) {
    modalLoad.setBody("Aguarde, pesquisando especialidades");
    modalLoad.open();
    especialidade.prop('disabled', false);
    $.ajax({
      url: "/recursos-humanos/api/search/especialidade-by-cargo",
      method: "GET",
      data: {codCargo: codCargo},
      dataType: "json",
      success: function (data) {
        urbem.populateSelect(especialidade, data, {
          value: "value",
          label: "label"
        });
        if (localStorage.getItem('especialidadeStorage')) {
            especialidade.select2('data', JSON.parse(localStorage.getItem('especialidadeStorage')));
            localStorage.removeItem('especialidadeStorage');
        }
        modalLoad.close();
      }
    });
  }

  if (cargo) {
    cargo.on('change', function () {
      localStorage.setItem('cargoStorage', JSON.stringify($(this).select2('data')));
    });

    cargo.select2('data', JSON.parse(localStorage.getItem('cargoStorage')));
  }

  if (especialidade) {
    especialidade.on('change', function () {
      localStorage.setItem('especialidadeStorage', JSON.stringify($(this).select2('data')));
    });

    especialidade.select2('data', JSON.parse(localStorage.getItem('especialidadeStorage')));
  }

  if (tipo.val() == ''){
    $('#filter_cargo_value_autocomplete_input').select2('data', '');
  }
  localStorage.removeItem('cargoStorage');
  cargo.on('change', function () {
    if($(this).val() != '') {
      carregarEspecialidades($(this).val());
    }
  })
  tipo.trigger('change');
  if ((tipo.val() == 'cargo') || (tipo.val() == 'funcao')) {
    cargo.trigger('change');
  }

    if (codContrato) {
        codContrato.on('change', function () {
            localStorage.setItem('contratoStorage', JSON.stringify($(this).select2('data')));
        });

        codContrato.select2('data', JSON.parse(localStorage.getItem('contratoStorage')));
    }
    localStorage.removeItem('contratoStorage');

    if (especialidade) {
        especialidade.on('change', function () {
            localStorage.setItem('especialidadeStorage', JSON.stringify($(this).select2('data')));
        });

        especialidade.select2('data', JSON.parse(localStorage.getItem('especialidadeStorage')));
    }

})(jQuery, UrbemSonata);
