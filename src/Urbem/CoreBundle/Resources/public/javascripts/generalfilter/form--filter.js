(function ($, urbem) {
    'use strict';

  var tipo = urbem.giveMeBackMyField('tipo', true),
    codContrato = urbem.giveMeBackMyField('codContrato', true),
    matricula = urbem.giveMeBackMyField('matricula', true),
    lotacao = urbem.giveMeBackMyField('lotacao', true),
    local = urbem.giveMeBackMyField('local', true),
    funcao = urbem.giveMeBackMyField('funcao', true),
    regime = urbem.giveMeBackMyField('regime', true),
    subdivisao = urbem.giveMeBackMyField('subdivisao', true),
    cargo = urbem.giveMeBackMyField('cargo', true),
    especialidade = urbem.giveMeBackMyField('especialidade', true),
    padrao = urbem.giveMeBackMyField('padrao', true),
    codContratoRescisao = urbem.giveMeBackMyField('codContratoRescisao', true),
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
      'codContratoRescisao'
    ];

  function desabilitaAll(camposArray){
    $.each(camposArray, function( index, value ) {
      var campo = urbem.giveMeBackMyField(value, true);

      if((value == 'codContrato') && (typeof(campo) !== 'undefined')) {
        codContrato.select2('disable');
      }

      if((value == 'matricula') && (typeof(campo) !== 'undefined')) {
        matricula.select2('disable');
      }

      if((value == 'codContratoRescisao') && (typeof(campo) !== 'undefined')) {
        codContratoRescisao.select2('disable');
      }

      if(typeof (campo) !== 'undefined') {
        campo.prop('disabled', true);
      }
    });
  }

  function habilitaCampo(camposArray, campoAHabilitar){
    $.each(camposArray, function( index, value ) {
      var campo = urbem.giveMeBackMyField(value, true);

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

      if((value == 'codContratoRescisao') && (typeof(campo) !== 'undefined') && (value != campoAHabilitar)) {
        codContratoRescisao.select2('disable');
      } else if('codContratoRescisao' == campoAHabilitar) {
        codContratoRescisao.select2('enable');
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
      case 'reg_sub_car_esp_grupo':
        habilitaCampo(camposArray, $(this).val());
        break;
      case 'codContratoRescisao':
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

  if (matricula) {
    matricula.on('change', function () {
      localStorage.setItem('matriculaStorage', JSON.stringify($(this).select2('data')));
    });

    matricula.select2('data', JSON.parse(localStorage.getItem('matriculaStorage')));
  }

  localStorage.removeItem('codContratoStorage');
  localStorage.removeItem('matriculaStorage');
  tipo.trigger('change');

})(jQuery, UrbemSonata);
