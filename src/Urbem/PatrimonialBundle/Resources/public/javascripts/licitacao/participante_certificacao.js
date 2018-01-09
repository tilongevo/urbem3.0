$(function () {
  "use strict";

  $("#" + UrbemSonata.uniqId + "_codEntidade").on('change', function () {
    window.varJsCodEntidade = $(this).val();
  });
  $("#" + UrbemSonata.uniqId + "_codEntidade").trigger('change');

  $("#" + UrbemSonata.uniqId + "_modalidade").on('change', function () {
    window.varJsCodModalidade = $(this).val();
  });
  $("#" + UrbemSonata.uniqId + "_modalidade").trigger('change');
});
