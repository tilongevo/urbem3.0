var UrbemSonata = UrbemSonata || {};

$(document).ready(function () {
    var unique_id = $('meta[name="uniqid"]').attr('content');

    if ($("#" + unique_id + "_codOrganograma option").size() <= 1) {
        $("#" + unique_id + "_codOrganograma").parent().append("<div style='color: #a94442'>Não foi encontrado nenhum organograma com data de implantação superior ao organograma ativo</div>");
    }
});