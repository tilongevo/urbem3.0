$(function() {
    $("#" + UrbemSonata.uniqId + "_codProfissao").on("change", function() {
        getConselhoClasse();
    });

    if ( $("#" + UrbemSonata.uniqId + "_codProfissao").val() != '' && $("#" + UrbemSonata.uniqId + "_codProfissao").val() != undefined)
    {
        getConselhoClasse();
    }

    function getConselhoClasse()
    {
        $.ajax({
            url: "/tributario/cadastro-economico/responsavel-tecnico/get-conselho-classe",
            method: "GET",
            data: {
                codProfissao: $("#" + UrbemSonata.uniqId + "_codProfissao").val(),
            },
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_conselhoClasse").val(data);
            }
        });
    }
});