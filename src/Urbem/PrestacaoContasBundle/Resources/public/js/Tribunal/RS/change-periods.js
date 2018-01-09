$(document).ready(function() {
    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_cmb_bimestre').hide();
    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_cmb_trimestre').hide();
    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_cmb_quadrimestre').hide();

    // Exibe o Select que esteja selecionado por default no load inicial
    var tipoRelatorioSelected = $("#" + UrbemSonata.uniqId + "_tipo_relatorio option:selected").val();
    var cmbShow = $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_cmb_" + tipoRelatorioSelected);
    cmbShow.attr("show", true);
    cmbShow.show();

    //Mostrar/Ocultar os Selects de Exibição
    $("#" + UrbemSonata.uniqId + "_tipo_relatorio").on("change", function() {
        if ($('*[show=true]')) {
            $('*[show=true]').removeAttr("show").hide();
        }
        var value = $(this).val();
        var combo = $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_cmb_" + value);

        combo.attr("show", true);
        combo.show();

    });
}());