(function ($, urbem, global) {
  'use strict';

  var renderMinusIcon = function (targetId) {
      $('a[data-target="#' + targetId + '"]')
        .find('i.fa')
        .removeClass('fa-minus-square')
        .addClass('fa-plus-square');
      };

  $(document).on('hidden.bs.collapse', 'div[id^="accordion-historico-bem-"]', function (e) {
    var elementId = $(this).prop('id');

    renderMinusIcon(elementId);
  });

  $(document).on('hidden.bs.collapse', 'div[id^="accordion-local-"]', function (e) {
    var elementId = $(this).prop('id');

    if (!$('#' + elementId).is(':visible')) {
      renderMinusIcon(elementId);
    }
  });

})(jQuery, UrbemSonata, window);
