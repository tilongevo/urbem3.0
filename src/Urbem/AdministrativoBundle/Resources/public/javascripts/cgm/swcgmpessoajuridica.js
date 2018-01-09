$(document).ready(function() {
    'use strict';

    $("#" + UrbemSonata.uniqId + "_numcgm__cep").mask('99999-999');
    $("#" + UrbemSonata.uniqId + "_numcgm__cepCorresp").mask('99999-999');
    $("#" + UrbemSonata.uniqId + "_cnpj").mask('99.999.999/9999-99');
    $("#" + UrbemSonata.uniqId + "_numcgm__foneComercial").mask('(99) 9999-9999');

    var SPMaskBehavior = function (val) {
      return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
      onKeyPress: function(val, e, field, options) {
          field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };

    $("#" + UrbemSonata.uniqId + "_numcgm__foneCelular").mask(SPMaskBehavior, spOptions);

    $("#" + UrbemSonata.uniqId + "_numcgm__cep").StringUrbem().clearString(/^[-]$/);
    $("#" + UrbemSonata.uniqId + "_numcgm__cepCorresp").StringUrbem().clearString(/^[-]$/);
    $("#" + UrbemSonata.uniqId + "_cnpj").StringUrbem().clearString(/^(..\/-)$/);
    $("#" + UrbemSonata.uniqId + "_cnpj").StringUrbem().clearString(/^(.)$/);
    $("#" + UrbemSonata.uniqId + "_numcgm__foneComercial").StringUrbem().clearString();
    $("#" + UrbemSonata.uniqId + "_numcgm__foneCelular").StringUrbem().clearString();
}());
