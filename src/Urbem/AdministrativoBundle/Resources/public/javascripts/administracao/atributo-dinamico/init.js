/*global jQuery*/
(function ($, urbem) {
  'use strict';

  function getFieldContainerByFieldId(fieldId) {
    var prefix = 'sonata-ba-field-container-';

    return $('#'.concat(prefix, fieldId));
  }

  $('.init-hidden').each(function () {
    var element = $(this);

    getFieldContainerByFieldId(element.attr('id')).hide();
  });

  $('.init-hidden--with').hide();

  urbem.giveMeBackMyField('valorPadraoNumero')
    .attr({
      'type': 'number',
      'min': 0
    });

})(jQuery, UrbemSonata);
