(function ($, global, urbem) {
    'use strict';

    var codTipoNorma = urbem.giveMeBackMyField('codTipoNorma');

    window.varJsCodTipoNorma = codTipoNorma.val();
    codTipoNorma.on("change", function() {
        window.varJsCodTipoNorma = $(this).val();
    });
})(jQuery, window, UrbemSonata);
