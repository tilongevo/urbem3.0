$(function () {
    "use strict";

    var valor = $('#definir_valor_valor');

    valor.mask('000.000,00', {reverse: true});

    $("button[name='definir']").hide();

    $("#adiciona").on("click", function() {
        $("button[name='definir']").show();

        var vigencia = $("#definir_valor_dtVigencia").val();
        if(valor.val() == '' || vigencia == '') {
            return false;
        }
        var linha =
            '<tr>' +
            '<input name=\"valores[]\" type=\"hidden\" value=\"' + UrbemSonata.convertMoneyToFloat(valor.val()) + '__' + vigencia + '\" />' +
            '<td>' + vigencia + '</td>' +
            '<td>' + valor.val() + '</td>' +
            '<td class=\"remove\"><i class="material-icons blue-text text-darken-4">delete</i></td>' +
            '</tr>';

        $('#tableValores').append(linha);

        $("#definir_valor_valor").val('');
        $("#definir_valor_dtVigencia").val('');
    });

    $(".remove").on("click", function() {
        $(this).parent().remove();
    });

    $(document).on('click', '.remove', function () {
        $("button[name='btn_update_and_list']").show();
        $(this).parent().remove();
    });
}());