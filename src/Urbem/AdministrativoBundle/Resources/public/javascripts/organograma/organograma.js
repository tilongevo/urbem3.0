(function(){
    'use strict';

    if (! UrbemSonata.checkModule('organograma')) {
        return;
    }

    var tipoNorma = $("#" + UrbemSonata.uniqId + "_tipoNorma").val();
    if ((tipoNorma == "") || (tipoNorma == undefined)) {
      $("#" + UrbemSonata.uniqId + "_fkNormasNorma")
      .empty()
      .append("<option value=\"\">Selecione</option>");
    } else {
      var editNorma = $("#" + UrbemSonata.uniqId + "_editNorma").val();
      $.ajax({
          url: "/administrativo/organograma/organograma/consultar-norma/" + tipoNorma,
          method: "GET",
          dataType: "json",
          success: function (data) {
              $("#" + UrbemSonata.uniqId + "_fkNormasNorma")
                  .empty()
                  .append("<option value=\"\">Selecione</option>")
                  .select2("val", "");

              $.each(data, function (index, value) {
                  var selected = '';
                  if (editNorma == value) {
                      selected = 'selected';
                  }
                  $("#" + UrbemSonata.uniqId + "_fkNormasNorma")
                      .append("<option " + selected + " value=" + value + ">" +  index + "</option>");
              });
              $("#" + UrbemSonata.uniqId + "_fkNormasNorma").select2();
          }
      });
    }

    $("#" + UrbemSonata.uniqId + "_tipoNorma").on("change", function() {
        var id = $(this).val();
        if (!id) {
          id = -1;
        }
        $.ajax({
            url: "/administrativo/organograma/organograma/consultar-norma/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_fkNormasNorma")
                    .empty()
                    .append("<option value=\"\">Selecione</option>")
                    .select2("val", "");

                $.each(data, function (index, value) {
                    $("#" + UrbemSonata.uniqId + "_fkNormasNorma")
                        .append("<option value=" + value + ">" +  index + "</option>");
                });
            }
        });
    });

    var canAddNivel = $("#" + UrbemSonata.uniqId + "_canAddNivel").val();
    if (!canAddNivel) {
      $("#field_actions_" + UrbemSonata.uniqId + "_fkOrganogramaNiveis").hide();
      $("input[id*='_fkOrganogramaNiveis_']").each(function(){
          $(this).attr('readonly', 'readonly');
      });
    }

}());
