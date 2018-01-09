$(document).ready(function(){

    $('.maxlength_9').attr('maxlength','9');
    $('.maxlength_3').attr('maxlength','3');
    $('.maxlength_4').attr('maxlength','4');
    $('.maxlength_10').attr('maxlength','10');

    $('.localizacao_mask').mask('00.00.00');

    $('.js-tipo-relatorio').on('select2-selecting', function(e) {
        if (e.choice.id == 'sintetico') {
            $('.js-atributos').prop('disabled', true);
            return;
        }

        $('.js-atributos').prop('disabled', false);
    });

});
