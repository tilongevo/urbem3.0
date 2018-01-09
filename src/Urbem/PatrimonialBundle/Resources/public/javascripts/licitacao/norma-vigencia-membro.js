(function(){
    'use strict';

    var fieldNormaOnChangeAction = function () {
        var urlEndPoint = '/patrimonial/licitacao/comissao-licitacao/norma-vigencia?id=';
        var modal = jQuery.urbemModal();
        var dataComissao = UrbemSonata.giveMeBackMyField('dataComissaoMembro');
        var vigencia = UrbemSonata.giveMeBackMyField('vigenciaMembro');
        var codValue = $(this).val();

        if (!codValue) {
            return;
        }

        if (codValue != '' && dataComissao) {
            jQuery.ajax({
                method: 'GET',
                url: urlEndPoint + codValue,
                dataType: 'json',
                beforeSend: function (xhr) {
                    modal
                        .disableBackdrop()
                        .setTitle('Aguarde...')
                        .setBody('Carregando data de Designação da Comissão e Vigência.')
                        .open();
                },
                success: function (data) {

                    var datePublicacao = 'Não informado'
                        , dateTermino = 'Não informado';
                    if (data.item.datePublicacao != null) {
                        datePublicacao = data.item.datePublicacao;
                    }

                    if (data.item.dateTermino != null) {
                        dateTermino = data.item.dateTermino;
                    }
                    dataComissao.val(datePublicacao);
                    vigencia.val(dateTermino);
                    modal.close();
                }
            });
        }
    };

    var norma = jQuery('input[id*=normaMembro]');
    norma.on('change', fieldNormaOnChangeAction);
    norma.trigger('change');

}());