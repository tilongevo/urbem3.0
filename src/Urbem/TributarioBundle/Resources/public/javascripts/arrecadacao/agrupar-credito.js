$(function () {
    "use strict";

    var desconto = 0,
        fieldCreditoGrupo = $("#" + UrbemSonata.uniqId + "_creditoGrupo_autocomplete_input"),
        fieldOrdem = $("#" + UrbemSonata.uniqId + "_ordem");

    $("button[name='btn_create_and_list']").hide();

    $('input[name*="desconto"]').on('ifChecked', function (e) {
        desconto = $(this).val();
    });

    fieldCreditoGrupo.attr('required', false);
    fieldOrdem.attr('required', false);

    $("#addCreditoGrupo").on("click", function() {
        var creditoGrupo = fieldCreditoGrupo.val(),
            info = creditoGrupo.split(" - "),
            descricao = info[1],
            codigo = info[0],
            ordem =  fieldOrdem.val();

        $('.sonata-ba-field-error-messages').remove();
        $('.sonata-ba-field-help').text('');

        if (fieldOrdem.parent().hasClass('sonata-ba-field-error')) {
            $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_ordem').removeClass('has-error');
        }

        if (fieldCreditoGrupo.parent().hasClass('sonata-ba-field-error')) {
            $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_creditoGrupo').removeClass('has-error');
        }

        if (creditoGrupo == '' || descricao == 'undefined') {
            UrbemSonata.setFieldErrorMessage('creditoGrupo', 'Selecione um crédito antes de continuar!', fieldCreditoGrupo.parent());
            return false;
        }

        if (fieldOrdem.val() == '') {
            UrbemSonata.setFieldErrorMessage('ordem', 'Selecione uma ordem antes de continuar!', fieldOrdem.parent());
            return false;
        }

        $("button[name='btn_create_and_list']").show();

        $('.empty-row-grupo-credito').hide();

        var linha =
            '<tr class="tr-rh row-grupo-credito">' +
            '<input name=\"creditos[]\" type=\"hidden\" value=\"' + descricao + '__' + codigo + '__' + ordem + '__' + desconto  + '\" />' +
            '<td>' + codigo + '</td>' +
            '<td>' + descricao + '</td>' +
            '<td>' + ordem + '</td>' +
            '<td>' + (desconto == 1 ? "Sim" : "Não")  + '</td>' +
            '<td class=\"remove\"><i class="material-icons blue-text text-darken-4">delete</i></td>' +
            '</tr>';

        $('#tableGrupoCreditos').append(linha);

        fieldOrdem.val('');
        $('#select2-chosen-1').html('');
        fieldCreditoGrupo.val('');
    });

    $(".remove").on("click", function() {
        $(this).parent().remove();
    });

    $(document).on('click', '.remove', function () {
        $("button[name='btn_update_and_list']").show();
        $(this).parent().remove();
    });
}());