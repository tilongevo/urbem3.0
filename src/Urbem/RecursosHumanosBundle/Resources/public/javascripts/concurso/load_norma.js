$(function () {
  "use strict";

  if (! UrbemSonata.checkModule('concurso')) {
    return;
  }

  var codNormaInput = '#' + UrbemSonata.uniqId + '_fkNormasNorma1';

  $("#" + UrbemSonata.uniqId + "_codTipoNorma").change(function(){

    if ($(this).val() == '') {
      $(codNormaInput)
        .empty()
        .append("<option value=\"\">Selecione</option>")
        .select2("val", "");
      return false;
    }

    $.ajax({
      url: "/recursos-humanos/concurso/filtra-norma-por-tipo/" + $(this).val(),
      method: "GET",
      dataType: "json",
      success: function (data) {
        $(codNormaInput)
          .empty()
          .append("<option value=\"\">Selecione</option>")

        for (var i in data) {
          $(codNormaInput)
            .append("<option value=" + i + ">" + data[i] + "</option>");
        }

        $(codNormaInput)
          .select2("val", "")
          .prop('disabled', false);
      },
      error: function () {
        alert("Houve um erro na aplicação, por favor contate o suporte técnico.");
      }
    });

  });


  function pesquisaDataPublicacao(norma) {
    if (!norma > 0) {
      return;
    }

    $.ajax({
      url: "/recursos-humanos/concurso/selecionar-norma/" + norma,
      method: "GET",
      dataType: "json",

      success: function (data) {


        if(data["link"] != ''){
          $('#link-edital').html("<div id='link-edital'><b>EDITAL</b>: <a href='/bundles/core/download/administrativo/norma/" + data["link"] + "' target='_blank'>" + data["link"] + '</a></div>');
        }else{
          $('#link-edital').html("&nbsp;");
        }

        $("#" + UrbemSonata.uniqId + "_dataPublicacao")
            .val(data["dtPublicacao"]);
      }
    });
  }

  $("#" + UrbemSonata.uniqId + "_fkNormasNorma").on("change", function() {
    if($(this).val() == ''){
      $("#" + UrbemSonata.uniqId + "_dataPublicacao").val('');
    }
    pesquisaDataPublicacao($(this).val());
  });

  var codNorma = $("#" + UrbemSonata.uniqId + "_fkNormasNorma").val();

  if (codNorma > 0) {
    pesquisaDataPublicacao(codNorma);
    $("#" + UrbemSonata.uniqId + "_dtAplicacao").focus(function () {
      $(".help-block").hide();
    });
  }

  $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_fkNormasNorma").parent().parent().prepend("<div id='link-edital'>&nbsp;</div>");

});
