$(document).ready(function() {
    $(".protocolo-numeric").blur(function() {
        if (parseInt($(this).val()) < 0) {
            $(this).val(0);
        }
    });
    UrbemSonata.acceptOnlyNumeric($(".protocolo-numeric"));

    // Fields
    var percentualAnual = $("#" + UrbemSonata.uniqId + "_flPercentualAnual");
    var planejamentoAnual = $("select#" + UrbemSonata.uniqId + "_stPlanejamentoAnual");
    var info = "No planejamento anual, o município contemplou percentual de até 25% das aquisições de bens e serviços licitáveis, visando tratamento diferenciado para as microempresas e empresas de pequeno porte?";

    addInfo(info);
    changeInput(planejamentoAnual.val());

    // ObjectModal
    var modal = $.urbemModal();

    planejamentoAnual.change(function() {
        changeInput($(this).val());
    });

    function carregaValoresIniciais() {
        modal.disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações...')
            .open();

        $.post(UrlServiceProviderTCE, $("form").serializeArray())
            .success(function (data) {
                    if (data.response == true) {
                        percentualAnual.val(data.flPercentualAnual);
                        if (data.stPlanejamentoAnual) {
                            planejamentoAnual.val(data.stPlanejamentoAnual).trigger("change");
                        }
                        changeInput(data.stPlanejamentoAnual);
                    }
                    modal.close();
                }
            );
    }

    // Onload
    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", carregaValoresIniciais);

    // value = 1 -> Sim / value = 2 -> Não /Conforme Tabela no BD
    function changeInput(value)
    {
        if (value == '2' || !value) {
            percentualAnual.prop('disabled', true);
            percentualAnual.val(0);
            percentualAnual.prop('required',false);
        } else {
            percentualAnual.prop('disabled', false);
            percentualAnual.prop('required',true);
        }
    }

    function addInfo(info)
    {
        var div = $("<div>", {"class": "box-header col s12"});
        var h = $("<h4>", {"class": "col s12 box-title left-align show"}).append(info);

        div.append(h);
        $(".box-header").after(div);
    }
}());