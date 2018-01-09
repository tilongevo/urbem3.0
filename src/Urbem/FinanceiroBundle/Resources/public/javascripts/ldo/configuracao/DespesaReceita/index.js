$(document).ready(function() {
    $("#form_ppa").on("change", function() {
        var id = $(this).val();
        $.ajax({
            url: "/financeiro/ppa/ppa/retorna-exercicios-ldo/" + id,
            method: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function (data) {
                $("#form_ano")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                $.each(data, function (index, value) {
                    $("#form_ano")
                        .append("<option value=" + index + ">" + value + "</option>");
                });
            }
        });
    });
});