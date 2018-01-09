$(document).ready(function() {
    $("#btnIncluir").attr('disabled', true);
    $('#filter_fkLdoTipoIndicadores_value').on("change", function () {
        var selectedText = $("#filter_fkLdoTipoIndicadores_value option:selected").text();
        if (selectedText != 'Selecione') {
            $("#btnIncluir").attr('disabled', false);
            return ;
        }
        $("#btnIncluir").attr('disabled', true);
    });
});