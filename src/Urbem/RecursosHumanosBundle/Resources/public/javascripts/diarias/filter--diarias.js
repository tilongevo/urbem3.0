(function ($, global, urbem) {
    'use strict';

    var matricula = urbem.giveMeBackMyField('codContrato', true);

    matricula.on("change", function() {
        localStorage.setItem('matriculaId', $(this).select2('data').id);
        localStorage.setItem('matriculaLabel', $(this).select2('data').label);
    });

    matricula.select2('data', {
        id: localStorage.getItem('matriculaId'),
        label: localStorage.getItem('matriculaLabel')
    });

    localStorage.removeItem('matriculaId');
    localStorage.removeItem('matriculaLabel');

    matricula.prop("required", true);

})(jQuery, window, UrbemSonata);
