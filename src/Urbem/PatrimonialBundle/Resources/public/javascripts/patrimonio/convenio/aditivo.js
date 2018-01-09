(function ($, urbem) {
  'use strict';

  var sonataId = urbem.uniqId
    , modal = $.urbemModal();

    jQuery(document).on('sonata.add_element', function () {
        $(".select2-v4-parameters").siblings('select').remove();
        $(".select2-v4-parameters").parent().parent().attr('style', 'height: 66px !important');
    });

})(jQuery, UrbemSonata);
