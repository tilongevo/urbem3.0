(function ($, urbem) {
    'use strict';

    var tipo = urbem.giveMeBackMyField('tipo', true);
    var cgmMatricula = urbem.giveMeBackMyField('codContrato', true);
    var evento = urbem.giveMeBackMyField('evento', true);
    var ano = urbem.giveMeBackMyField('competenciaAno', true);
    var mes = urbem.giveMeBackMyField('competenciaMes', true);

    desabilitaCampoComExcecao([]);

    tipo.attr('required', true);
    ano.attr('required', true);

    if(tipo.val() == "cgmMatricula") {
        desabilitaCampoComExcecao([cgmMatricula]);
    } else if (tipo.val() == "evento") {
        desabilitaCampoComExcecao([evento]);
    } else {
        desabilitaCampoComExcecao([]);
    }

    tipo.on("change", function () {

        switch (tipo.val()) {
            case "cgmMatricula":
                desabilitaCampoComExcecao([cgmMatricula]);
                break;
            case "evento":
                desabilitaCampoComExcecao([evento]);
                break;
            default:
                desabilitaCampoComExcecao([]);
        }
    });

    ano.on("change", function () {
       $('form').submit();
    });

    function desabilitaCampoComExcecao(camposExcecoes) {

        var campos = [cgmMatricula, evento ];

        campos.forEach(function(campo) {
            campo.select2('disable');
            campo.prop('disabled', true);

            camposExcecoes.forEach(function(campoExcecao) {
                if (campo === campoExcecao) {
                    campo.select2('enable');
                    campo.prop('disabled', false);
                    campo.attr('required', true);
                } else {
                    campo.select2('data', '');
                }
            });
        });
    }
})(jQuery, UrbemSonata);