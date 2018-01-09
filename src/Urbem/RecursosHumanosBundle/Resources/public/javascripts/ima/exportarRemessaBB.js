$(function () {
  "use strict";

  var  ano = UrbemSonata.giveMeBackMyField('ano'),
       mes = UrbemSonata.giveMeBackMyField('mes');

  var loadTable = function (ano,mes) {
    abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando dados dos itens</h4>');
    $.get('/recursos-humanos/ima/exportar-remessa-bb/carrega-contas-convenio', {
      mode: 'table',
      mes: mes,
      ano: ano
    })
      .success(function (data) {
        $('.grupoContas .box-body').html(data);
        fechaModal();
      });
  };

  mes.on("change", function () {
    loadTable(ano.val(), $(this).val());
  });

  loadTable(ano.val(), mes.val());
}());
