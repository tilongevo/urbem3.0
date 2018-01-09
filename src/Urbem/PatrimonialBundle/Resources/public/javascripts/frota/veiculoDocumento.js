(function(){
  'use strict';

  if (! UrbemSonata.checkModule('veiculo-documento')) {
      return;
  }

  var unique_id = $('meta[name="uniqid"]').attr('content'),
    situacao = $('#' + unique_id + '_situacao');
  
  if (situacao.is(':checked')) {
      UrbemSonata.sonataFieldContainerShow('_exercicioEmpenho');
      UrbemSonata.sonataFieldContainerShow('_codEntidade');
      UrbemSonata.sonataFieldContainerShow('_codEmpenho');
  } else {
      UrbemSonata.sonataFieldContainerHide('_exercicioEmpenho');
      UrbemSonata.sonataFieldContainerHide('_codEntidade');
      UrbemSonata.sonataFieldContainerHide('_codEmpenho');
  }

  situacao.on('ifChecked', function() {
      UrbemSonata.sonataFieldContainerShow('_exercicioEmpenho');
      UrbemSonata.sonataFieldContainerShow('_codEntidade');
      UrbemSonata.sonataFieldContainerShow('_codEmpenho');
  });

  situacao.on('ifUnchecked', function() {
      UrbemSonata.sonataFieldContainerHide('_exercicioEmpenho');
      UrbemSonata.sonataFieldContainerHide('_codEntidade');
      UrbemSonata.sonataFieldContainerHide('_codEmpenho');
  });

}());
