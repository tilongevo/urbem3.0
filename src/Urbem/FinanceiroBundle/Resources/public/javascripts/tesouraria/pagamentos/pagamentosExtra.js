var modalLoad = new UrbemModal();
modalLoad.setTitle('Carregando...');

var entidadeSelect = $('#' + UrbemSonata.uniqId + "_codEntidade");
var boletimSelect = $('#' + UrbemSonata.uniqId + "_codBoletim");
var reciboSelect = $('#' + UrbemSonata.uniqId + "_codRecibo");

$(function() {
  window.varJsCodEntidade = 0;

  boletimSelect.attr("disabled", "disabled");
  reciboSelect.attr("disabled", "disabled");

  entidadeSelect.change(function() {
    if (!$(this).val() > 0) return;

    window.varJsCodEntidade = $(this).val();
    buscaBoletimArrecadacaoExtra();
  });
});

function buscaBoletimArrecadacaoExtra() {
  var entidade = entidadeSelect.val();
  modalLoad.setBody("Aguarde, pesquisando boletins");
  modalLoad.open();

  $.ajax({
    url: "/financeiro/tesouraria/arrecadacao/extra-arrecadacoes/busca-boletim",
    method: "GET",
    data: {
      entidade: entidade
    },
    dataType: "json",
    success: function (data) {
      boletimSelect.find('option').remove().end();

      var len = data.length;
      for (var i=0; i<len; i++) {
        $('<option/>').html(data[i].cod_boletim + ' - ' + data[i].dt_boletim)
          .val(data[i].cod_boletim)
          .appendTo(boletimSelect);
      }
      boletimSelect.removeAttr('disabled');
      modalLoad.close();
    }
  });
}
