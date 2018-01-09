(function () {
    'use strict';

    var fkSwCgmField = UrbemSonata.giveMeBackMyField('fkSwCgm'),
        fkSwCgmFieldId = fkSwCgmField.prop('id'),
        fkSwCgmFieldContainer = fkSwCgmField.parent();

    jQuery('button[name="btn_create_and_list"]').on('click', function (event) {
        var mensagem = '';
        jQuery('.sonata-ba-field-error-messages').remove();
        jQuery('.sonata-ba-form').parent().find('.alert.alert-danger.alert-dismissable').remove();

        if (fkSwCgmField.val() == '') {
            event.preventDefault();
            mensagem = 'O Campo Seguradora não pode ficar vazio';

            $(".sonata-ba-field-error-messages").remove();
            UrbemSonata.setFieldErrorMessage(
                fkSwCgmFieldId,
                mensagem,
                fkSwCgmFieldContainer
            );

            jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' + mensagem + ' </div>');
            return false;
        }
    });
}());
