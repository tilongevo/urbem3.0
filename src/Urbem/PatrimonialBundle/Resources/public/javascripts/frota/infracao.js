$(function () {
  "use strict";

  if (! UrbemSonata.checkModule('infracao')) {
    return;
  }

  $("#" + UrbemSonata.uniqId + "_fkFrotaMotivoInfracao").on("change", function () {
    var id = $(this).val();

    if(id == 0) {
      document.getElementsByTagName('form')[0].reset();
      return ;
    }

    $.ajax({
      url: "/patrimonial/frota/infracao/get-infracao-info/" + id,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#" + UrbemSonata.uniqId + "_baseLegal").val(data.baseLegal);
        $("#" + UrbemSonata.uniqId + "_gravidade").val(data.gravidade);
        $("#" + UrbemSonata.uniqId + "_pontos").val(data.pontos);
      }
    });
  });

  $("#" + UrbemSonata.uniqId + "_fkFrotaMotivoInfracao").trigger("change");
});
