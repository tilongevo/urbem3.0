(function () {
  'use strict';

    var regexpClassificacaoEdit = /list/,
        locationHref = document.location.href;

    var urlSubmit = '/patrimonial/patrimonio/inventario/exportar-coletora-txt';

    if(regexpClassificacaoEdit.test(locationHref)) {

        $("form").attr('target', '_blank');
        $("form").attr('action', urlSubmit);

        var typeArchive = $('#filter_typeArchive_value'),
            local = $('#filter_local_value'),
            mensagem = '',
            field,
            container,
            submit = false;

        jQuery("form").on('submit', function (event) {
            mensagem = '';

            if (local.val() == '' || local.val() == null) {
                mensagem = "Selecione pelo menos um local para fazer o filtro";
                field = local;
                container = local.parent();
                limpaMessageErrors();
            }

            if (typeArchive.val() == '' || typeArchive.val() == null) {
                mensagem = "Selecione um tipo de arquivo para fazer o filtro";
                field = typeArchive;
                container = typeArchive.parent();
                limpaMessageErrors();
            }

            if(mensagem != '') {
                limpaMessageErrors();
                UrbemSonata.setFieldErrorMessage(
                    field,
                    mensagem,
                    container
                );

                jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' + mensagem + ' </div>');
            } else {
                limpaMessageErrors();
                submit = true;
            }

            return submit;

        });
    }

    function limpaMessageErrors()
    {
        $(".sonata-ba-field-error-messages").remove();
    }
}());
