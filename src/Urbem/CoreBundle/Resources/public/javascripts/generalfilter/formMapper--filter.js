(function ($, urbem) {
  'use strict';

  var tipo = urbem.giveMeBackMyField('tipo'),
    codContrato = urbem.giveMeBackMyField('codContrato'),
    matricula = urbem.giveMeBackMyField('matricula'),
    lotacao = urbem.giveMeBackMyField('lotacao'),
    local = urbem.giveMeBackMyField('local'),
    funcao = urbem.giveMeBackMyField('funcao'),
    camposARetirar = urbem.giveMeBackMyField('camposARetirar'),
    regime = urbem.giveMeBackMyField('regime'),
    subdivisao = urbem.giveMeBackMyField('subdivisao'),
    cargo = urbem.giveMeBackMyField('cargo'),
    evento = urbem.giveMeBackMyField('evento'),
    especialidade = urbem.giveMeBackMyField('especialidade'),
    padrao = urbem.giveMeBackMyField('padrao'),
    codContratoStorage,
    camposArray = [
        'codContrato',
        'lotacao',
        'local',
        'funcao',
        'regime',
        'subdivisao',
        'cargo',
        'especialidade',
        'padrao',
        'matricula',
        'evento'
    ];

  function desabilitaAll(camposArray){
    $.each(camposArray, function( index, value ) {
      var campo = urbem.giveMeBackMyField(value);
      if((value == 'codContrato') && (typeof(campo) !== 'undefined')) {
        codContrato.select2('disable');
      }

        if((value == 'matricula') && (typeof(campo) !== 'undefined')) {
            matricula.select2('disable');
        }

      if(typeof (campo) !== 'undefined') {
        campo.prop('disabled', true);
      }
    });
  }

  function habilitaCampo(camposArray, campoAHabilitar){
    $.each(camposArray, function( index, value ) {
      var campo = urbem.giveMeBackMyField(value);
        if((value == 'codContrato') && (typeof(campo) !== 'undefined') && (value != campoAHabilitar)) {
            codContrato.select2('disable');
        } else if('codContrato' == campoAHabilitar) {
            codContrato.select2('enable');
        }

        if((value == 'matricula') && (typeof(campo) !== 'undefined') && (value != campoAHabilitar)) {
            matricula.select2('disable');
        } else if('matricula' == campoAHabilitar) {
            matricula.select2('enable');
        }

      if((typeof (campo) !== 'undefined') && (value != campoAHabilitar)) {
        campo.prop('disabled', true);
      } else if(value == campoAHabilitar){
        campo.prop('disabled', false);
      }

      if(campoAHabilitar == 'reg_sub_car_esp_grupo') {
        cargo.prop('disabled', false);
        subdivisao.prop('disabled', false);
        regime.prop('disabled', false);
        especialidade.prop('disabled', false);
      }
    });
  }

  tipo.on('change', function () {
    switch ($(this).val()) {
    case 'matricula':
        habilitaCampo(camposArray, $(this).val());
    case 'cgm_contrato':
        habilitaCampo(camposArray, 'codContrato');
    break;
    case 'lotacao':
        habilitaCampo(camposArray, $(this).val());
    break;
    case 'local':
        habilitaCampo(camposArray, $(this).val());
    break;
    case 'funcao':
        habilitaCampo(camposArray, $(this).val());
    break;
    case 'evento':
        habilitaCampo(camposArray, $(this).val());
    break;
    case 'reg_sub_car_esp_grupo':
        habilitaCampo(camposArray, $(this).val());
    break;
    case 'padrao':
        habilitaCampo(camposArray, $(this).val());
    break;
    default:
    desabilitaAll(camposArray);
break;
    }
  });

  if (codContrato) {
      codContrato.on('change', function () {
          localStorage.setItem('codContratoStorage', JSON.stringify($(this).select2('data')));
      });

      codContrato.select2('data', JSON.parse(localStorage.getItem('codContratoStorage')));
  }

  localStorage.removeItem('codContratoStorage');
  tipo.trigger('change');

})(jQuery, UrbemSonata);
