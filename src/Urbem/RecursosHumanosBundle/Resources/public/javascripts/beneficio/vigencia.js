var UrbemSonata = UrbemSonata || {};

(function(){
  'use strict';

  $(document).on('sonata.add_element', function() {

    var camposValorInicial = $(document).find('input[id*=_vlInicial]');
    var camposValorFinal   = $(document).find('input[id*=_vlFinal]');

    $.each(camposValorInicial, function () {
      if($(this).val() == '') {
        $(this).val('0,00')
      }
      $(this).maskMoney({thousands:'.', decimal:',', allowZero:true});
    });

    $.each(camposValorFinal, function () {
      if($(this).val() == '') {
        $(this).val('0,00')
      }
      $(this).maskMoney({thousands:'.', decimal:',', allowZero:true});
    });

  });


}());
