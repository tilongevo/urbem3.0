$(function () {
    "use strict";

    var codConstrucao = UrbemSonata.giveMeBackMyField('codConstrucao'),
        localizacao = $("#" + UrbemSonata.uniqId + "_fkImobiliarioLocalizacao_autocomplete_input"),
        lote = $("#" + UrbemSonata.uniqId + "_fkImobiliarioLote_autocomplete_input"),
        imovel = $("#" + UrbemSonata.uniqId + "_fkImobiliarioImovel_autocomplete_input"),
        area = UrbemSonata.giveMeBackMyField("area"),
        submitStatus = true;

    if (codConstrucao.val() == '') {
        carregaAtributos();
    }

    function carregaAtributos() {
        var params = {
            entidade: "CoreBundle:Imobiliario\\ConstrucaoOutros",
            fkEntidadeAtributoValor: "getFkImobiliarioAtributoConstrucaoOutrosValores",
            codModulo: "12",
            codCadastro: "9",
            codEntidade: {}
        };

        if (codConstrucao.val() != undefined && codConstrucao.val() != '') {
            params.codEntidade = {
                codConstrucao: codConstrucao.val()
            }
        }

        AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(params);
    }

    window.varJsCodLocalizacao = localizacao.val();
    localizacao.on("change", function() {
        if ($(this).val() != '') {
            lote.select2('enable');
            imovel.select2('enable');
        } else {
            lote.select2('val', '');
            lote.select2('disable');
            imovel.select2('val', '');
            imovel.select2('disable');
        }
        window.varJsCodLocalizacao = $(this).val();
    });

    window.varJsCodLote = lote.val();
    lote.on("change", function() {
        window.varJsCodLote = $(this).val();
    });

    if (localizacao.val() == '') {
        lote.select2('disable');
        imovel.select2('disable');
    }

    imovel.on('change', function () {
        unidadeAutonoma($(this).val());
    });

    function unidadeAutonoma(inscricaoMunicipal) {
        submitStatus = false;
        $.ajax({
            url: "/tributario/cadastro-imobiliario/edificacao/imovel/unidade-autonoma",
            method: "POST",
            data: {inscricaoMunicipal: inscricaoMunicipal},
            dataType: "json",
            success: function (data) {
                if (data) {
                    submitStatus = true;
                } else {
                    var message = '<div class="help-block sonata-ba-field-error-messages">' +
                        '<ul class="list-unstyled">' +
                        '<li><i class="fa fa-exclamation-circle"></i>  Deve haver no mínimo uma edificação como unidade autônoma no imóvel informado!</li>' +
                        '</ul></div>';
                    imovel.after(message);
                }
            }
        });
    }

    $('form').submit(function() {
        return submitStatus;
    });
}());