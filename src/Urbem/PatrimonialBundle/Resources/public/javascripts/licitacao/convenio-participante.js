(function ($, urbem) {
  'use strict';

  var fieldValorParticipacao = urbem.giveMeBackMyField('valorParticipacao')
    , fieldValorConvenio = urbem.giveMeBackMyField('valorConvenio')
    , fieldPercentualParticipacao = urbem.giveMeBackMyField('percentualParticipacao')
    , valorConvenio = fieldValorConvenio.val();

  fieldValorParticipacao.mask('#.##0,00', {
    reverse: true,
    onKeyPress: function (valorParticipacao, event, currentField, options) {
      valorParticipacao = urbem.convertMoneyToFloat(valorParticipacao);
      fieldPercentualParticipacao.val(urbem.convertFloatToMoney(valorParticipacao / valorConvenio * 100));
    }
  });
})(jQuery, UrbemSonata);
