(function ($, urbem) {
  'use strict';

  var fieldTipoRelatorio = urbem.giveMeBackMyField('tipoRelatorio')
    , tipoRelatorio = fieldTipoRelatorio.find('input[type="radio"]:checked').val();

  function callTipoRelatorioFiledsCondition(tipoRelatorio) {
    switch (tipoRelatorio) {
      case 'analitico':
        showFieldsForTipoRelatorioAnalitico();
        break;
      case 'sintetico':
        showFieldsForTipoRelatorioSintetico();
        break;
    }
  }

  function showFieldsForTipoRelatorioAnalitico() {
    urbem.sonataFieldContainerHide('_quebraPor');
    urbem.sonataFieldContainerHide('_situacao');
  }

  function showFieldsForTipoRelatorioSintetico() {
    urbem.sonataFieldContainerShow('_quebraPor');
    urbem.sonataFieldContainerShow('_situacao');
  }

  callTipoRelatorioFiledsCondition(tipoRelatorio);

  $(document).ready(function () {
    fieldTipoRelatorio.on('ifChecked', function () {
      tipoRelatorio = $(this).find('input[type="radio"]:checked').val();

      callTipoRelatorioFiledsCondition(tipoRelatorio);
    });
  });

})(jQuery, UrbemSonata);
