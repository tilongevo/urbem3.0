$(document).ready(function() {
    'use strict';

    $("#" + UrbemSonata.uniqId + "_numcgm__cep").mask('99999-999');
    $("#" + UrbemSonata.uniqId + "_numcgm__cepCorresp").mask('99999-999');
    $("#" + UrbemSonata.uniqId + "_servidor_pis_pasep").mask('999.99999.99-9');
    $("#" + UrbemSonata.uniqId + "_cpf").mask('999.999.999-99');
    $("#" + UrbemSonata.uniqId + "_num_cnh").mask('99999999999');
    $("#" + UrbemSonata.uniqId + "_numcgm__foneResidencial").mask('(99) 9999-9999');
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

    $("#" + UrbemSonata.uniqId + "_numcgm__foneResidencial").StringUrbem().clearString();
    $("#" + UrbemSonata.uniqId + "_numcgm__foneComercial").StringUrbem().clearString();
    $("#" + UrbemSonata.uniqId + "_numcgm__foneCelular").StringUrbem().clearString();

    $("#" + UrbemSonata.uniqId + "_numcgm__foneResidencial").StringUrbem().clearString(/^[()\s-]$/);
    $("#" + UrbemSonata.uniqId + "_numcgm__foneComercial").StringUrbem().clearString(/^[()\s-]$/);
    $("#" + UrbemSonata.uniqId + "_numcgm__foneCelular").StringUrbem().clearString(/^[()\s-]$/);

    $("#" + UrbemSonata.uniqId + "_cpf").StringUrbem().clearString(/^(..-)$/);
    $("#" + UrbemSonata.uniqId + "_cpf").StringUrbem().clearString(/^[.]$/);

    $("#" + UrbemSonata.uniqId + "_servidor_pis_pasep").StringUrbem().clearString(/^(..-)$/);
    $("#" + UrbemSonata.uniqId + "_servidor_pis_pasep").StringUrbem().clearString(/^[.]$/);

    $("#" + UrbemSonata.uniqId + "_numcgm__cep").StringUrbem().clearString(/^[-]$/);
    $("#" + UrbemSonata.uniqId + "_numcgm__cepCorresp").StringUrbem().clearString(/^[-]$/);
}());
