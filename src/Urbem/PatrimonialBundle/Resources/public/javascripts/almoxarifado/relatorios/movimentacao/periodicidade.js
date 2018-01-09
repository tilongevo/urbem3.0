(function ($, urbem) {
  'use strict';

  var fieldDia = urbem.giveMeBackMyField('dia')
    , fieldMes = urbem.giveMeBackMyField('mes')
    , fieldAno = urbem.giveMeBackMyField('ano')
    , fieldNumeroNotaFiscal = urbem.giveMeBackMyField('numeroNotaFiscal')
    , containerIntervalo = urbem.giveMeBackMyField('intervalo')
    , fieldPeriodicidade = urbem.giveMeBackMyField('periodicidade');

  var periodicidade = fieldPeriodicidade.val();

  callPeriodicidadeFiledsCondition(periodicidade);

  $(document).ready(function () {
    fieldPeriodicidade.on('change', function () {
      periodicidade = $(this).val();

      if (periodicidade != undefined && periodicidade != '') {
        callPeriodicidadeFiledsCondition(periodicidade);
      }
    });

    fieldDia
      .prop('type', 'number')
      .prop('min', 1)
      .prop('max', 31)
    ;

    fieldNumeroNotaFiscal.prop('type', 'number');
  });

  function callPeriodicidadeFiledsCondition(periodicidade) {
    switch (periodicidade) {
      case 'intervalo':
        showFieldsForIntervalo();
        break;
      case 'dia':
        showFieldsForDia();
        break;
      case 'mes':
        showFieldsForMes();
        break;
      case 'ano':
        showFieldsForAno();
        break;
    }
  }

  function sonataFieldIntervaloContainerShow() {
    containerIntervalo
      .find('label')
      .addClass('required');

    containerIntervalo
      .find('input')
      .prop('required', true);

    containerIntervalo
      .parent()
      .parent()
      .show();
  }

  function sonataFieldIntervaloContainerHide() {
    containerIntervalo
      .find('label')
      .removeClass('required');

    containerIntervalo
      .find('input')
      .prop('required', false);

    containerIntervalo
      .parent()
      .parent()
      .hide();
  }

  function showFieldsForIntervalo() {
    urbem.sonataFieldContainerHide('_dia');
    urbem.sonataFieldContainerHide('_mes');
    urbem.sonataFieldContainerHide('_ano');

    sonataFieldIntervaloContainerShow();
  }

  function showFieldsForDia() {
    sonataFieldIntervaloContainerHide();
    urbem.sonataFieldContainerHide('_mes');
    urbem.sonataFieldContainerHide('_ano');

    urbem.sonataFieldContainerShow('_dia');
  }

  function showFieldsForMes() {
    sonataFieldIntervaloContainerHide();
    urbem.sonataFieldContainerHide('_dia');

    urbem.sonataFieldContainerShow('_ano');
    urbem.sonataFieldContainerShow('_mes');
  }

  function showFieldsForAno() {
    sonataFieldIntervaloContainerHide();
    urbem.sonataFieldContainerHide('_dia');
    urbem.sonataFieldContainerHide('_mes');

    urbem.sonataFieldContainerShow('_ano');
  }

})(jQuery, UrbemSonata);
