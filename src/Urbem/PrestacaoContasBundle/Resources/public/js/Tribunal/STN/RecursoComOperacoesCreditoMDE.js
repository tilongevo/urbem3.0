$(document).ready(function() {
    var $modal = $.urbemModal();

    $modal.disableBackdrop().setTitle('Aguarde').setBody('Carregando').open();

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", function () {
        $modal.close();
    });

    function clearField($field) {
        $field.val("");
        $field.select2("data", "");
        $field.select2("data", null);
    }

    function disableField($field) {
        $field.select2('enable', false);
        $field.prop("disabled", true);
        clearField($field);
    }

    function enableField($field) {
        $field.select2('enable', true);
        $field.select2('enable', true);
        $field.prop("disabled", false);
    }

    var $entidade = UrbemSonata.giveMeBackMyField('prestacao_contas_stn_recurso_operacao_credito_mde_entidade');
    var $orgao = UrbemSonata.giveMeBackMyField('prestacao_contas_stn_recurso_operacao_credito_mde_orgao');
    var $unidade = UrbemSonata.giveMeBackMyField('prestacao_contas_stn_recurso_operacao_credito_mde_unidade');
    var $recursos = UrbemSonata.giveMeBackMyField('prestacao_contas_stn_recurso_operacao_credito_mde_recursos');

    clearField($entidade);
    disableField($orgao);
    disableField($unidade);
    disableField($recursos);

    $entidade.on('change', function() {
        disableField($orgao);
        disableField($unidade);
        disableField($recursos);
        $recursos.empty();


        if ('' === $(this).val()) {
            return;
        }

        enableField($orgao);
    });

    $orgao.on('change', function() {
        disableField($unidade);
        disableField($recursos);
        $recursos.empty();

        if ('' === $(this).val()) {
            return;
        }

        enableField($unidade);
    });

    $unidade.on('change', function() {
        disableField($recursos);
        $recursos.empty();

        if ('' === $(this).val()) {
            return;
        }

        $modal.disableBackdrop().setTitle('Aguarde').setBody('Carregando').open();

        data = [];
        data.push({name: 'action', value: 'LoadRecursos'});
        data.push({name: 'entidade', value: $entidade.val()});
        data.push({name: 'unidade', value: $unidade.val()});

        $.get(UrlServiceProviderTCE, data)
            .success(function (data) {
                $modal.close();

                if ('undefined' === typeof data['recursos']) {
                    return;
                }

                var opts = "";

                for (i in data.recursos) {
                    opts += "<option value='" + data['recursos'][i]['value'] + "'>" + data['recursos'][i]['text'] + "</option>";
                }

                $recursos.append(opts);

                if ("" !== opts) {
                    enableField($recursos);
                }
            })
            .error(function (data) {
                modal.close();
            });

        enableField($recursos);
    });
}());