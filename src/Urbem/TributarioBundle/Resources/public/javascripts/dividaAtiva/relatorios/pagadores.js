$(function () {
    "use strict";

    var filtroPor = UrbemSonata.giveMeBackMyField('filtroPor'),
        exercicio = UrbemSonata.giveMeBackMyField('exercicio'),
        numeroRegistros = UrbemSonata.giveMeBackMyField('numeroRegistros'),
        submitStatus = true,
        tipo = $('#tipo').val();

    $("#manuais").on("click", function() {

        $('.sonata-ba-field-error-messages').remove();

        if(filtroPor.val() == '') {
            var message = '<div class="help-block sonata-ba-field-error-messages">' +
                '<ul class="list-unstyled">' +
                '<li><i class="fa fa-exclamation-circle"></i>  Por favor, selecione um item na lista.</li>' +
                '</ul></div>';
            filtroPor.after(message);
            return false;
        }

        if(exercicio.val() == '' && tipo == 'Crédito') {
            var message = '<div class="help-block sonata-ba-field-error-messages">' +
                '<ul class="list-unstyled">' +
                '<li><i class="fa fa-exclamation-circle"></i>  Por favor, preencha este campo.</li>' +
                '</ul></div>';
            exercicio.after(message);
            return false;
        }
        var col = '<tr class="tr-rh row-creditos">';
        col += '<input type="hidden" value="' + tipo + '" name="creditos[tipo]">';

        col += '<input type="hidden" value="' + filtroPor.val() + '" name="creditos[codigo][]">';
        col += '<input type="hidden" value="' + $('select#' + UrbemSonata.uniqId + '_filtroPor option:selected').text() + '" name="creditos[descricao][]">';
        col += '<input type="hidden" value="' + exercicio.val() + '" name="creditos[exercicio][]">';

        col += '<td class="td-rh codigo">' + filtroPor.val() + '</td>';
        if(tipo == 'Crédito') {
            col += '<td class="td-rh exercicio">' + exercicio.val() + '</td>';
        }
        col += '<td class="td-rh descricao">' + $('select#' + UrbemSonata.uniqId + '_filtroPor option:selected').text() + '</td>';
        col += '<td class="td-rh remove"><i class="material-icons blue-text text-darken-4">delete</i></td>';
        col += '</tr>';

        $('#tableCreditosManuais').append(col);

        filtroPor.select2('val', '');
        exercicio.val('');
        submitStatus = true;
    });

    $(document).on('click', '.remove', function () {
        $(this).parent().remove();
        if ($(".row-creditos").length <= 0) {
            submitStatus = false;
        }
    });

    $('form').submit(function() {
        if ($(".row-creditos").length <= 0) {
            $('#tableCreditosManuais').after(
                '<div style="align: center" class="help-block sonata-ba-field-error-messages">' +
                '<ul class="list-unstyled">' +
                '<li><i class="fa fa-exclamation-circle"></i>  Deve ser incluso pelo menos um '+ tipo+'.</li>' +
                '</ul></div>'
            );
            return false;
        }
        $('#tableCreditosManuais').append('<input type="hidden" value="' + numeroRegistros.val() + '" name="creditos[limite]">');
        return submitStatus;
    });
});


