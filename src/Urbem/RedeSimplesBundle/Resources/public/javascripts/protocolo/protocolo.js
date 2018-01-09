$(document).ready(function() {
    'use strict';

    $(".protocolo-numeric").prop("type", "number");
    $(".protocolo-decimal").maskMoney({thousands:'.', decimal:',', allowZero:true});
    // $(".datepicker").datepicker();
});