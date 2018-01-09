$(document).ready(function() {
    var codTipo =     $("#" + UrbemSonata.uniqId + "_codTipo").val();
    $("#" + UrbemSonata.uniqId + "_fkLdoTipoIndicadores").select2('val', codTipo);
    var selected = $('#select2-chosen-4').html();
    if (selected == 'Selecione') {
        $('#btnIncluir').removeAttr('href');
        $('#btnIncluir').attr('disabled', true);
        return;
    }
    $('#btnIncluir').attr('disabled', false);
});