$(function () {
    "use strict";

    if (! UrbemSonata.checkModule('logradouro')) {
      return;
    }

    var unique_id = $('meta[name="uniqid"]').attr("content");

    $("#" + unique_id + "_codUf").on("change", function() {
        if ($(this).val() == '') {
            $("#" + unique_id + "_codMunicipio")
                .empty()
                .append("<option value=\"\">Selecione</option>");
            return false;
        }
        $.ajax({
            url: "/administrativo/logradouro/listar-municipio-uf/" + $(this).val(),
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#" + unique_id + "_codMunicipio")
                    .empty()
                    .append("<option value=\"\">Selecione</option>")
                    .prop('disabled', false);

                for (var i in data) {
                    $("#" + unique_id + "_codMunicipio")
                        .append("<option value=" + data[i] + ">" + i + "</option>");
                }

                $("#" + unique_id + "_codMunicipio")
                    .val("");
            }
        });
    });

  $("#" + unique_id + "_codMunicipio").on("change", function() {
    if ($(this).val() == '') {
      $("#" + unique_id + "_codBairro")
        .empty()
        .append();
      return false;
    }
    $.ajax({
      url: "/administrativo/logradouro/listar-bairros/" + $(this).val(),
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#" + unique_id + "_codBairro").select2('val', '');
        $("#" + unique_id + "_codBairro")
          .empty()
          .prop('disabled', false);

        for (var i in data) {
          $("#" + unique_id + "_codBairro")
            .append("<option value=" + data[i] + ">" + i + "</option>");
        }

        $("#" + unique_id + "_codBairro")
          .val("");
      }
    });
  });

}());
