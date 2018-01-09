$(function () {
    "use strict";

    var dataBase   = $('#data_base');
    var codCalculo = $('#cod_calculo');
    var valorPagar = $('#valor_pagar');
    var juros      = $('#juros');
    var multa      = $("#multa");
    var correcao   = $('#correcao');
    var totalPagar = $('#total_pagar');

    $("#calcular").on("click", function() {

        $.ajax({
            url: "/tributario/arrecadacao/consulta-escrituracao/calcula-valores",
            method: "GET",
            data: {codCalculo: codCalculo.val(), dataBase: dataBase.val()},
            dataType: "json",
            beforeSend: function () {
                loading(true);
            },
            success: function (response) {

                var valorParcela = response.parcela_valor - response.parcela_valor_desconto;
                valorPagar.text(valorParcela);
                juros.text(response.parcela_juros_pagar);
                multa.text(response.parcela_multa_pagar);
                correcao.text(response.parcela_correcao_pagar);
                totalPagar.text(response.valor_total);
                loading(false);
            }
        });

    });

    function loading(display)
    {
        $('.class-spinner').remove();
        var block = null;
        if (display) {
            block = "style='display:block;'";
        }

        var spinner = "<div id='spinner' class='spinner-load-hide spinner-load ' " + block + ">" +
            "<i class='fa fa-spinner fa-spin fa-3x fa-fw'></i>" +
            "<span class='sr-only'>Loading...</span>" +
            "</div>";

        var div = document.createElement('div');
        div.className = 'class-spinner';
        div.style.marginTop = '50px';
        div.style.float = 'left';

        div.innerHTML = spinner;
        var formActions = document.querySelector(".sonata-ba-form-actions");
        document.forms[0].insertBefore(div, formActions);
    }

}());
