var gerarVerificador = function () {
    $.ajax({
        url: "/financeiro/tesouraria/terminal/gerar-verificador/",
        method: "POST",
        data: null,
        dataType: "json",
        success: function (data) {
            sucesso(data);
        }
    });
};
var sucesso = function (data) {
    jQuery("#" + UrbemSonata.uniqId + "_codVerificador").val(data.codigo);
};
var verificardor = jQuery("#" + UrbemSonata.uniqId + "_codVerificador").val();
if (verificardor == "") {
    gerarVerificador();
}

$("#filter_fkTesourariaUsuarioTerminais__fkSwCgm_value_autocomplete_input").on("change", function() {
    localStorage.setItem('swcgmpfId', $(this).select2('data').id);
    localStorage.setItem('swcgmpfLabel', $(this).select2('data').label);
});

if ($("input[name='filter[fkTesourariaUsuarioTerminais__fkSwCgm][value]']").val()) {
    $("#filter_fkTesourariaUsuarioTerminais__fkSwCgm_value_autocomplete_input").select2('data', {
        id: localStorage.getItem('swcgmpfId'),
        label: localStorage.getItem('swcgmpfLabel')
    });
}

localStorage.removeItem('swcgmpfId');
localStorage.removeItem('swcgmpfLabel');