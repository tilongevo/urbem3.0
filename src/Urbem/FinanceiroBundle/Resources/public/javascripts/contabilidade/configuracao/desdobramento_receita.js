var modalLoad = new UrbemModal();
modalLoad.setTitle('Receita');

$(function () {
    "use strict";
    $("button[name='btn_create_and_list']").show();
    $("#" + UrbemSonata.uniqId + "_codReceitaPrincipal").prop('readonly', true);
}());