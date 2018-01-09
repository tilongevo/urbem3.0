$(function () {
    "use strict";

    var atributos = UrbemSonata.giveMeBackMyField('atributos');
    var  tipoRelatorio = UrbemSonata.giveMeBackMyField('tipoRelatorio');

    tipoRelatorio.on('change', function () {
        atributos.select2('val', '');
        if (tipoRelatorio.val() == 'sintetico') {
            atributos.attr('disabled', true);
        } else if (tipoRelatorio.val() == 'analitico') {
            atributos.attr('disabled', false);
        }
    });
}());