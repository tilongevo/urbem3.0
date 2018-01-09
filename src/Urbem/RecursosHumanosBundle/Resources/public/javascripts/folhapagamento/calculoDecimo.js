(function ($, urbem) {
  'use strict';

  var tipo = urbem.giveMeBackMyField('tipo', true),
    codContrato = urbem.giveMeBackMyField('codContrato', true),
    lotacao = urbem.giveMeBackMyField('lotacao', true),
    codContratoValue = $('#filter_codContrato_value_autocomplete_input', true),
    codContratoT = $("#s2id_filter_codContrato_value_autocomplete_input"),
    lotacaoT = $("#s2id_filter_lotacao_value"),
    lotacaoValue = $('#filter_lotacao_value_autocomplete_input', true);

  codContrato.select2('disable');
  lotacao.prop('disabled', true);

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
        lotacao.select2('data', '');
        lotacaoValue.select2('val', '');
        removeElements('lotacao');
        break;
      case 'lotacao':
        lotacao.prop('disabled', false);
        codContrato.select2('disable');
        codContratoValue.select2('val', '');
        codContrato.select2('data', '');
        removeElements('codContrato');
        break;
      default:
        codContrato.select2('disable');
        lotacao.prop('disabled', true);
        lotacaoValue.select2('val', '');
        lotacao.select2('data', '');
        codContratoValue.select2('val', '');
        codContrato.select2('data', '');
        removeElements('lotacao');
        removeElements('codContrato');
        break;
    }
  });

  tipo.trigger('change');

})(jQuery, UrbemSonata);
