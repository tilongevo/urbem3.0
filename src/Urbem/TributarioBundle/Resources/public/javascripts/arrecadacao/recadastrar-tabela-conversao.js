var exercicioOrigem = $("#form_exercicioOrigem"),
    tabela = $("#form_tabela");

tabela.attr('disabled', true);

exercicioOrigem.on("change", function() {
    $("#spinner").show();

    $.ajax({
        url: "/api-search-tabela-conversao/get-tabela-conversao",
        method: "GET",
        data: {
            exercicioOrigem: exercicioOrigem.val()
        },
        dataType: "json",
        success: function (data) {
            $("#spinner").hide();

            tabela.attr('disabled', false);
            tabela
                .empty()
                .append("<option value=\"9999\">Todos</option>");

            $.each(data, function (index, value) {
                tabela.append("<option value=" + index + ">" + value + "</option>");
            });
        }
    });
});