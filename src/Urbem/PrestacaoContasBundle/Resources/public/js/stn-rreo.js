$(function () {
    var groupBimestre =  $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_cmbBimestre');
    var groupMes =  $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_cmbMes');

    $("#" + UrbemSonata.uniqId + "_tipoRelatorio").on("change", function() {
        if ($(this).val() == 'opt_bimestre') {
            groupBimestre.show();
            groupMes.hide();
            return;
        }

        groupMes.show();
        groupBimestre.hide();
    });

    $('#' + UrbemSonata.uniqId + '_assinaturas').removeAttr('required');
}());