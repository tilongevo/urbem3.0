(function () {
  'use strict';

  var regexpClassificacaoEdit = /edit/,
      locationHref = document.location.href;

  var isEdit = regexpClassificacaoEdit.test(locationHref);

  // Proibe a edição do código de classificação
  if (isEdit) {
      $("#" + UrbemSonata.uniqId + "_codCatalogo").prop("readonly", true);
      $("#" + UrbemSonata.uniqId + "_codNivel").prop("readonly", true);
  }

  if (!UrbemSonata.checkModule('catalogo-classificacao')) {
    return;
  }

  UrbemSonata.sonataFieldContainerHide('_codAtributo');

  var fieldCodCatalogo = UrbemSonata.giveMeBackMyField('codCatalogo');

  $("#" + UrbemSonata.uniqId + "_codNivel").prop("disabled", true);

  if (fieldCodCatalogo.val() != "") {
    getNiveisCatalogo(fieldCodCatalogo.val());
  }

  $("#" + UrbemSonata.uniqId + "_codCatalogo").on("change", function () {
    var codCatalogo = $("#" + UrbemSonata.uniqId + "_codCatalogo").val();
    UrbemSonata.sonataFieldContainerHide('_codAtributo');
    getNiveisCatalogo(codCatalogo);
  });

  $("#" + UrbemSonata.uniqId + "_codNivel").on("change", function () {
    var codNivel = $(this).val();
    var codNivelT = $("#" + UrbemSonata.uniqId + "_codNivel option:selected").text();
    codNivelT = codNivelT.split(" - ");
    codNivelT = codNivelT[0];
    var codCatalogo = $("#" + UrbemSonata.uniqId + "_codCatalogo").val();

    CatalogoClassificaoComponent.getNivelCategorias(codCatalogo, codNivel, codNivelT);

    UrbemSonata.sonataFieldContainerHide('_codAtributo');
    if(codNivel == $("#" + UrbemSonata.uniqId + "_codNivel option:last-child").val()) {
      UrbemSonata.sonataFieldContainerShow('_codAtributo');
    }
  });
}());

function getNiveisCatalogo(codCatalogo) {
  if (codCatalogo == 0) {
    $("#" + UrbemSonata.uniqId + "_codNivel")
      .empty();
    return;
  }
  abreModal('Carregando','Aguarde, carregando níveis do catálogo');

  $.ajax({
    url: "/patrimonial/almoxarifado/catalogo-classificacao/get-niveis-catalogo/" + codCatalogo,
    method: "GET",
    dataType: "json",
    success: function (data) {
      $("#" + UrbemSonata.uniqId + "_codNivel").prop("disabled", false);
      $("#" + UrbemSonata.uniqId + "_codNivel")
        .empty();

      $("#" + UrbemSonata.uniqId + "_codNivel")
        .append("<option value='0'>Selecione...</option>");
      $.each(data, function (index, value) {
        $("#" + UrbemSonata.uniqId + "_codNivel")
          .append("<option value='" + index + "'>" + value + "</option>");
      });
      $("#" + UrbemSonata.uniqId + "_codNivel").val(CatalogoClassificaoComponent.nivel);

      fechaModal();
      if(CatalogoClassificaoComponent.nivel) {
        $("#" + UrbemSonata.uniqId + "_codNivel").trigger('change');
      }
    }
  });
}
