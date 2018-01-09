$(document).ready(function() {
    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_cmbBimestre').hide();
    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_cmbQuadrimestre').hide();
    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_cmbSemestre').hide();

    // Exibe o Select que esteja selecionado por default no load inicial
    var tipoRelatorioSelected = $("#" + UrbemSonata.uniqId + "_tipoRelatorio option:selected").val();
    var cmbShow = $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_cmb" + tipoRelatorioSelected);
    cmbShow.attr("show", true);
    cmbShow.show();

    //Mostrar/Ocultar os Selects de Exibição
    $("#" + UrbemSonata.uniqId + "_tipoRelatorio").on("change", function() {
        if ($('*[show=true]')) {
            $('*[show=true]').removeAttr("show").hide();
        }
        var value = $(this).val();
        var combo = $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_cmb" + value);

        combo.attr("show", true);
        combo.show();

    });

    //Validar Entidade - A Entidade Câmara não pode se juntar a outras entidades
    $("#" + UrbemSonata.uniqId + "_entidade").on("change", function() {
        var options = [];

        $("#" + UrbemSonata.uniqId + "_entidade option:selected").each(function(i){
            options[i] = $(this).text().toLowerCase();
        });
        if (options.length > 1) {
            for (i = 0; i < options.length; i++) {
                if (options[i].indexOf("câmara") != -1 || options[i].indexOf("camara") != -1) {
                    $('form :submit').prop("disabled", true);
                } else {
                    $('form :submit').prop("disabled", false);
                }
            }
        }
        else {
            $('form :submit').prop("disabled", false);
        }
    });
}());