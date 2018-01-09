$(document).ready(function() {

    var filtrar = $('#' + UrbemSonata.uniqId + "_filtrar");
    var tipoFundamentacaoLegal = $('#' + UrbemSonata.uniqId + "_tipoFundamentacaoLegal");
    var credito = $('#' + UrbemSonata.uniqId + "_credito");
    var exercicio = $('#' + UrbemSonata.uniqId + "_exercicio");

    $('.creditoContainer').show();
    $('.grupoCreditoContainer').hide();

    filtrar.on("change", function () {
        var valor = $(this).val();

        if (valor == "credito") {

            exibeCredito();

        } else {
            exibeGrupoCredito();
        }
    });

    var exibeCredito = function() {

        $('.creditoContainer').show();
        $('.grupoCreditoContainer').hide();

    }

    var exibeGrupoCredito = function() {

        $('.grupoCreditoContainer').show();
        $('.creditoContainer').hide();
    }


    tipoFundamentacaoLegal.on("change", function () {

        window.varJsTipoFundamentacaoLegal = $(this).val();
    });

    exercicio.on("change", function () {

        window.varJsExercicio = $(this).val();
    });

    credito.on("change", function () {


    });

});