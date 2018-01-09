(function ($) {
  'use strict';

  var codBem = UrbemSonata.giveMeBackMyField("codBem");
  var exercicio = UrbemSonata.giveMeBackMyField("exercicio");
  var idInventario = UrbemSonata.giveMeBackMyField("idInventario");

  codBem.on("change", function (e) {

    var codBem = $(this).val()
      , modal = $.urbemModal();

    if (codBem !== undefined && codBem !== "") {
      $.ajax({
        url: "/patrimonial/patrimonio/inventario-historico-bem/get-item-inventario-historico-bem",
        data: {
          codBem: codBem, exercicio: exercicio.val(), idInventario: idInventario.val()
        },
        method: "GET",
        dataType: "json",
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando informações adicionais.')
            .open();
        },
        success: function (data) {
          $("#" + UrbemSonata.uniqId + "_codOrgaoDe").val(data.codOrgao);
          $("#" + UrbemSonata.uniqId + "_codLocalDe").val(data.codLocal);

          modal.close();
        }
      });

    } else {
      e.stopPropagation();
    }
  });


})(jQuery);
