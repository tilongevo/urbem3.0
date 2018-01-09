(function () {
  'use strict';

  var loadTable = function () {
    abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando dados dos itens</h4>');
    $.get('/recursos-humanos/folha-pagamento/folha-complementar/carrega-folha-complementar-fechada-anterior', {
      mode: 'table'
    })
      .success(function (data) {
        $('.fechadaAnterior .box-body').html(data);
        fechaModal();
      });
  };


  var loadTableFechada = function () {
    abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando dados dos itens</h4>');
    $.get('/recursos-humanos/folha-pagamento/folha-complementar/carrega-folha-complementar-fechada-anterior-folha-salario', {
      mode: 'table'
    })
      .success(function (data) {
        $('.folhasComplementares .box-body').html(data);
        fechaModal();
        loadTable();
      });
  };

  loadTableFechada();

}());
