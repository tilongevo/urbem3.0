(function ($, global, urbem) {
    'use strict';

    var matriculaServidor = urbem.giveMeBackMyField('codContratoCedente', true)
    ;

    matriculaServidor.on("change", function() {
        localStorage.setItem('matriculaServidorId', $(this).select2('data').id);
        localStorage.setItem('matriculaServidorLabel', $(this).select2('data').label);
    });

    matriculaServidor.select2('data', {
        id: localStorage.getItem('matriculaServidorId'),
        label: localStorage.getItem('matriculaServidorLabel')
    });

    localStorage.removeItem('matriculaServidorId');
    localStorage.removeItem('matriculaServidorLabel');

})(jQuery, window, UrbemSonata);
