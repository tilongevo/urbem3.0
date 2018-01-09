$(function () {
    "use strict";

    $('input[name*="atributo_reserva_rigida"]').on('ifChecked', function (e) {
        e.stopPropagation();

        var change = $(this).val() == 'true' ? true : false ;

        if (change) {
            $('input[name*="atributo_reserva_autorizacao"][value="false"]').iCheck('check');
            $('input[name*="atributo_reserva_autorizacao"][value="true"]').iCheck('uncheck');
        }

        if (!change) {
            $('input[name*="atributo_reserva_autorizacao"][value="false"]').iCheck('uncheck');
            $('input[name*="atributo_reserva_autorizacao"][value="true"]').iCheck('check');
        }

    });

    $('input[name*="atributo_reserva_autorizacao"]').on('ifChecked', function (e) {
        e.stopPropagation();

        var change = $(this).val() == 'true' ? true : false ;

        if (change) {
            $('input[name*="atributo_reserva_rigida"][value="false"]').iCheck('check');
            $('input[name*="atributo_reserva_rigida"][value="true"]').iCheck('uncheck');
        }

        if (!change) {
            $('input[name*="atributo_reserva_rigida"][value="false"]').iCheck('uncheck');
            $('input[name*="atributo_reserva_rigida"][value="true"]').iCheck('check');
        }

    });
});
