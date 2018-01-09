(function ($, urbem) {
  'use strict';

  var tipo = urbem.giveMeBackMyField('tipo', true),
    codContrato = urbem.giveMeBackMyField('codContrato', true),
    lotacao = urbem.giveMeBackMyField('lotacao', true),
    local = urbem.giveMeBackMyField('local', true),
    codContratoValue = $('#filter_codContrato_value_autocomplete_input', true),
    localValue = $('#filter_local_value_autocomplete_input', true),
    lotacaoValue = $('#filter_lotacao_value_autocomplete_input', true);

  codContrato.select2('disable');
  lotacao.prop('disabled', true);
  local.prop('disabled', true);

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
        localValue.select2('val', '');
        local.select2('data', null);
        removeElements('lotacao');
        removeElements('local');
        break;
      case 'lotacao':
        lotacao.prop('disabled', false);
        codContrato.select2('disable');
        codContrato.select2('data', '');
        codContratoValue.select2('val', '');
        local.select2('disable');
        local.select2('data', null);
        localValue.select2('val', '');
        removeElements('local');
        removeElements('codContrato');
        break;
      case 'local':
        local.prop('disabled', false);
        lotacao.select2('disable');
        lotacao.select2('data', null);
        codContrato.select2('disable');
        codContratoValue.select2('val', '');
        codContrato.select2('data', '');
        removeElements('codContrato');
        removeElements('lotacao');
        break;
      default:
        codContrato.select2('disable');
        codContrato.select2('data', '');
        codContratoValue.select2('val', '');
        lotacao.prop('disabled', true);
        lotacao.select2('data', null);
        lotacaoValue.select2('val', '');
        local.select2('disable');
        local.select2('data', null);
        localValue.select2('val', '');
        removeElements('codContrato');
        removeElements('lotacao');
        removeElements('local');
        break;
    }
  });

  tipo.trigger('change');

})(jQuery, UrbemSonata);
