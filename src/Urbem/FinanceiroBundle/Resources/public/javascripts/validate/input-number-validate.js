$(document).ready(function() {
    'use strict';

    $(".validateNumber").on("change", function()
    {
        var inputId = jQuery(this).attr('id'),
            number = Number(jQuery(this).attr('max')),
            valTyped =   Number(jQuery(this).val());

        if (!isNaN(valTyped) && valTyped > number && valTyped > 0) {
            getMessage(jQuery(this), inputId, number);
        } else if (!isNaN(valTyped) && valTyped <= number && valTyped > 0 || valTyped.toString().length == 0) {
            $(".alert_error_" + inputId).remove();
        } else if (!isNaN(valTyped) && valTyped <= 0) {
            getMessage(jQuery(this), inputId, '-1');
        }
    });

    function getMessage(context, inputId, number)
    {
        var message = null;
        $(".alert_error_" + inputId).remove();
        context.parent().addClass('sonata-ba-field-error');
        message =
            '<div class="help-block sonata-ba-field-error-messages alert_error_' + inputId + '"> ' +
                '<ul class="list-unstyled">' +
                    '<li>';
        if (number != '-1') { // faltando translate messages.PT-BR
            message +=  '<i class="fa fa-exclamation-circle"></i> O valor deve ser igual ou menor que ' + number +'.';
        } else {
            message +=  '<i class="fa fa-exclamation-circle"></i> O valor não pode ser zero ou negativo.';
        }
        message +=  '</li> ' +
                '</ul> ' +
            '</div>';
        context.parent().append(message);
        return;
    }
}());
