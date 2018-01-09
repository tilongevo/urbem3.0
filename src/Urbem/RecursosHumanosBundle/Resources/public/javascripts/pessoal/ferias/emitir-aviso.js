$(document).ready(function() {
    var tipo = $('#' + UrbemSonata.uniqId + "_tipo");
    var cgmMatricula = $('#' + UrbemSonata.uniqId + "_cgmMatricula_autocomplete_input");
    var lotacao = $('#' + UrbemSonata.uniqId + "_lotacao");
    var local = $('#' + UrbemSonata.uniqId + "_local");
    var regime = $('#' + UrbemSonata.uniqId + "_regime");
    var subDivisao = $('#' + UrbemSonata.uniqId + "_subDivisao");

    desabilitaCampoComExcecao([]);

    tipo.on("change", function () {

        switch (tipo.val()) {
            case "cgmMatricula":
                desabilitaCampoComExcecao([cgmMatricula]);
                break;
            case "lotacao":
                desabilitaCampoComExcecao([lotacao]);
                break;
            case "local":
                desabilitaCampoComExcecao([local]);
                break;
            case "subDivisao":
                desabilitaCampoComExcecao([regime, subDivisao]);
                break;
            default:
                desabilitaCampoComExcecao([]);
        }
    });

    function desabilitaCampoComExcecao(camposExcecoes) {

        var campos = [cgmMatricula, lotacao, local, regime, subDivisao ];

        campos.forEach(function(campo) {
            campo.select2('disable');
            campo.select2('data', '');

            camposExcecoes.forEach(function(campoExcecao) {
                if (campo === campoExcecao) {
                    campo.select2('enable');
                    campo.attr('require', false);
                    campo.attr('required', true);
                }
            });
        });
    }
});
