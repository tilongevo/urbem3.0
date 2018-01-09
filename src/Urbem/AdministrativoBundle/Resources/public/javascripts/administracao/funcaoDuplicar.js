(function(){
  'use strict';

  $('.btn-submit').on('click', function () {
    $('form[name="duplicar_funcao"]').submit();
  });

  $('select').select2();
}());
