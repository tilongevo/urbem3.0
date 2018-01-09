(function () {
  'use strict';

  var config = {
      urlAlmoxarifado: "/patrimonial/almoxarifado/almoxarifado/dados-almoxarifado/",
      almoxarifado: UrbemSonata.giveMeBackMyField("fkSwCgm"),
      endereco: UrbemSonata.giveMeBackMyField("endereco"),
      telefone: UrbemSonata.giveMeBackMyField("telefone")
    },
    ajax = function (url) {
      jQuery.ajax({
        url: url,
        method: "GET",
        dataType: "json",
        success: function (data) {
          config.endereco.val(data.endereco);
          config.telefone.val(data.telefone);
        }
      });
    };

  function factoryActionAlmoxarifado(numcgm) {
    if (numcgm == "") {
      return;
    }

    config.endereco.val("");
    config.telefone.val("");

    ajax(config.urlAlmoxarifado + numcgm);
  }

  config.almoxarifado.on("change", function (e) {
    factoryActionAlmoxarifado(jQuery(this).val());
  });

  if (config.almoxarifado.val() == undefined) {
    config.endereco.val("");
    config.telefone.val("");
  } else {
    factoryActionAlmoxarifado(config.almoxarifado.val());
  }
}());
