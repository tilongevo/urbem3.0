$(function() {
    getNivelSuperior();
    $("#" + UrbemSonata.uniqId + "_codVigencia").on("change", function() {
        getNivelSuperior();
    });
    function getNivelSuperior()
    {
        $.ajax({
            url: "/tributario/cadastro-economico/hierarquia-servico/nivel/get-nivel-superior",
            method: "GET",
            data: {
                codVigencia: $("#" + UrbemSonata.uniqId + "_codVigencia").val(),
            },
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_nivelSuperior").val(data);
            }
        });
    }
});