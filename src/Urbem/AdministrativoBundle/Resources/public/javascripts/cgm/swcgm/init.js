(function ($, urbem, global) {
  'use strict';

  global.logradouroApiUrl = typeof global.logradouroApiUrl !== 'undefined' ? global.logradouroApiUrl : '/administrativo/logradouro/api/{id}' ;

  var fieldSwBairro = urbem.giveMeBackMyField('swBairro')
    , fieldSwBairroCorresp = urbem.giveMeBackMyField('swBairroCorresp')
    , fieldSwCep = urbem.giveMeBackMyField('swCep')
    , fieldSwCepCorresp = urbem.giveMeBackMyField('swCepCorresp');

  $(document).ready(function (e) {
    fieldSwBairro.select2('disable');
    fieldSwBairroCorresp.select2('disable');
    fieldSwCep.select2('disable');
    fieldSwCepCorresp.select2('disable');
  });

})(jQuery, UrbemSonata, window);
