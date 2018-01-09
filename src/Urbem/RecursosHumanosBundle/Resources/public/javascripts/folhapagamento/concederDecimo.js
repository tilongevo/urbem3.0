(function ($, urbem) {
  'use strict';

  var tipo = urbem.giveMeBackMyField('tipo', true),
    codContrato = urbem.giveMeBackMyField('codContrato', true),
    lotacao = urbem.giveMeBackMyField('lotacao', true),
    local = urbem.giveMeBackMyField('local', true),
    codContratoValue = $('#filter_codContrato_value_autocomplete_input', true),
    localValue = $('#filter_local_value_autocomplete_input', true),
    lotacaoValue = $('#filter_lotacao_value_autocomplete_input', true),
    regime = urbem.giveMeBackMyField('regime', true),
    subdivisao = urbem.giveMeBackMyField('subdivisao', true),
    cargo = urbem.giveMeBackMyField('cargo', true),
    especialidade = urbem.giveMeBackMyField('especialidade', true)
  ;

  codContrato.select2('disable');
  lotacao.prop('disabled', true);
  local.prop('disabled', true);
  regime.prop('disabled', true);
  subdivisao.prop('disabled', true);
  cargo.prop('disabled', true);
  especialidade.prop('disabled', true);

  function removeElements(campo) {
    $('#filter_'+campo+'_value_hidden_inputs_wrap').find('input').each(function (index, val){
      val.remove();
    });
  }

  tipo.on('change', function () {
    switch ($(this).val()) {
      case 'cgm_contrato':
        codContrato.select2('enable');
        lotacao.prop('disabled', true);
        lotacao.select2('data', null);
        lotacaoValue.select2('val', '');
        local.select2('disable');
        local.select2('data', null);
        localValue.select2('val', '');
        regime.select2('disable');
        regime.select2('data', null);
        cargo.select2('disable');
        cargo.select2('data', null);
        especialidade.select2('disable');
        especialidade.select2('data', null);
        subdivisao.select2('disable');
        subdivisao.select2('data', null);
        removeElements('lotacao');
        removeElements('local');
        removeElements('regime');
        removeElements('subdivisao');
        removeElements('cargo');
        removeElements('especialidade');
        break;
      case 'lotacao':
        lotacao.prop('disabled', false);
        codContrato.select2('disable');
        codContrato.select2('data', null);
        codContratoValue.select2('val', '');
        local.select2('disable');
        local.select2('data', null);
        localValue.select2('val', '');
        regime.select2('disable');
        regime.select2('data', null);
        cargo.select2('disable');
        cargo.select2('data', null);
        especialidade.select2('disable');
        especialidade.select2('data', null);
        subdivisao.select2('disable');
        subdivisao.select2('data', null);
        removeElements('local');
        removeElements('codContrato');
        removeElements('regime');
        removeElements('subdivisao');
        removeElements('cargo');
        removeElements('especialidade');
        break;
      case 'local':
        local.prop('disabled', false);
        lotacao.prop('disabled', true);
        lotacao.select2('data', null);
        lotacaoValue.select2('val', '');
        codContrato.select2('disable');
        codContrato.select2('data', null);
        codContratoValue.select2('val', '');
        local.select2('disable');
        local.select2('data', null);
        localValue.select2('val', '');
        regime.select2('disable');
        regime.select2('data', null);
        cargo.select2('disable');
        cargo.select2('data', null);
        especialidade.select2('disable');
        especialidade.select2('data', null);
        subdivisao.select2('disable');
        subdivisao.select2('data', null);
        removeElements('codContrato');
        removeElements('lotacao');
        removeElements('regime');
        removeElements('subdivisao');
        removeElements('cargo');
        removeElements('especialidade');
        break;
      case 'reg_sub_car_esp_grupo':
        regime.prop('disabled', false);
        subdivisao.prop('disabled', false);
        cargo.prop('disabled', false);
        especialidade.prop('disabled', false);
        local.prop('disabled', true);
        local.select2('data', null);
        localValue.select2('val', '');
        lotacao.prop('disabled', true);
        lotacao.select2('data', null);
        lotacaoValue.select2('val', '');
        codContrato.select2('disable');
        codContrato.select2('data', null);
        codContratoValue.select2('val', '');
        removeElements('local');
        removeElements('codContrato');
        removeElements('lotacao');
        break;
      default:
        codContrato.select2('disable');
        codContrato.select2('data', null);
        codContratoValue.select2('val', '');
        lotacao.prop('disabled', true);
        lotacao.select2('data', null);
        lotacaoValue.select2('val', '');
        local.select2('disable');
        local.select2('data', null);
        localValue.select2('val', '');
        regime.select2('disable');
        regime.select2('data', null);
        cargo.select2('disable');
        cargo.select2('data', null);
        especialidade.select2('disable');
        especialidade.select2('data', null);
        subdivisao.select2('disable');
        subdivisao.select2('data', null);
        removeElements('codContrato');
        removeElements('lotacao');
        removeElements('local');
        removeElements('regime');
        removeElements('subdivisao');
        removeElements('cargo');
        removeElements('especialidade');
        break;


    }
  });

  tipo.trigger('change');

})(jQuery, UrbemSonata);
