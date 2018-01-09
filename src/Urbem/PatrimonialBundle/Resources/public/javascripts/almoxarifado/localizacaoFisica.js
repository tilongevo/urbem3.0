(function(){
    'use strict';

    var urlQuery = "/financeiro/empenho/autorizacao/get-unidade-medida";
    var collectionAdminPrefix = "fkAlmoxarifadoLocalizacaoFisicaItens";
    var collectionCount = 0;


    var fieldItemOnChangeAction = function () {
        var modalLoading = jQuery.urbemModal();
        var collectionCount = $(this)[0]
            .id
            .replace('_codItem_autocomplete_input', '')
            .replace(UrbemSonata.uniqId + '_' + collectionAdminPrefix + '_', '');
        var prefixFieldName = collectionAdminPrefix + '_' + collectionCount + '_';
        var unidadeMedida = UrbemSonata.giveMeBackMyField(prefixFieldName + 'unidadeMedida');

        var codItemValue = $(this).val();
        if (!codItemValue) {
            unidadeMedida.val('Indefinido....');
            return;
        }

            jQuery.ajax({
                method: 'POST',
                dataType: 'json',
                url: urlQuery,
                data: { codItem: codItemValue },
                beforeSend: function (xhr) {
                    modalLoading
                        .disableBackdrop()
                        .setTitle('Aguarde...')
                        .setBody('Carregando unidade de medida.')
                        .open();
                },
                success: function (data) {
                    unidadeMedida.val(data);
                    modalLoading.close();
                },
                fail: function() {
                    modalLoading
                        .setTitle('Erro...')
                        .setBody('Ocorreu um problema, tente novamente. Caso o problema persista contate o suporte.')
                }
            });

    };

    $(document).on('sonata.add_element', function (e) {
        for (var i = 0; i <= collectionCount; i++) {
            var prefixFieldName = collectionAdminPrefix + '_' + i + '_';
            var codItem = UrbemSonata.giveMeBackMyField(prefixFieldName + 'codItem');

            codItem.on('change', fieldItemOnChangeAction);
            codItem.trigger('change');
        }
        collectionCount++;
    });

    var codItem = jQuery('input[id*=codItem]');
    collectionCount = codItem.length;
    codItem.on('change', fieldItemOnChangeAction);
    codItem.trigger('change');
}());
