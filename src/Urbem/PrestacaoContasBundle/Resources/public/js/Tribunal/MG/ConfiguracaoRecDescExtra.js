$(document).ready(function() {
    var modal = $.urbemModal();

    modal.disableBackdrop().setTitle('Aguarde').setBody('Carregando').open();

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", function () {
        modal.close();
    });

    // remove create button and defaut fields
    $('button[name="btn_create_and_list"]').remove();
    $('.sonata-ba-collapsed-fields > em').remove();

    // disable form submit
    document.forms[0].onsubmit = function (e) {
        return false;
    };

    var $inCategoriaField = UrbemSonata.giveMeBackMyField('configuracao_rec_desc_extra_inCategoria');
    var $inTipoLancamentoField = UrbemSonata.giveMeBackMyField('configuracao_rec_desc_extra_inTipoLancamento');
    var $inSubTipoField = UrbemSonata.giveMeBackMyField('configuracao_rec_desc_extra_inSubTipo');
    var $inCodConta = UrbemSonata.giveMeBackMyField('configuracao_rec_desc_extra_inCodConta');
    var $buttonSave = $('button[name="save"]');

    function disableField($field) {
        $field.select2('enable', false);
        $field.val("").prop("disabled", true);
        $field.select2("data", "");
        $field.select2("data", null);
    }

    function enableField($field) {
        $field.select2('enable', true);
        $field.val("").prop("disabled", false);
    }

    disableField($inTipoLancamentoField);
    disableField($inSubTipoField);
    disableField($inCodConta);

    $inCategoriaField.on('change', function() {
        disableField($inTipoLancamentoField);
        disableField($inSubTipoField);
        disableField($inCodConta);

        $inSubTipoField.empty();
        $inCodConta.empty();

        if ('' === $(this).val()) {
            return;
        }

        enableField($inTipoLancamentoField);
    });

    $inTipoLancamentoField.on('change', function() {
        disableField($inSubTipoField);
        disableField($inCodConta);

        $inSubTipoField.empty();
        $inCodConta.empty();

        modal.disableBackdrop().setTitle('Aguarde').setBody('Carregando').open();

        data = [];
        data.push({name: 'action', value: 'LoadSubTipo'});
        data.push({name: 'inTipoLancamento', value: $(this).val()});

        $.post(UrlServiceProviderTCE, data)
            .success(function (data) {
                modal.close();

                if ('undefined' === typeof data['subTipos']) {
                    return;
                }

                var opts = "";

                for (i in data.subTipos) {
                    opts += "<option value='" + data['subTipos'][i]['value'] + "'>" + data['subTipos'][i]['text'] + "</option>";
                }

                $inSubTipoField.append(opts);

                if ("" !== opts) {
                    enableField($inSubTipoField);

                } else {
                    enableField($inCodConta);
                }
            })
            .error(function (data) {
                modal.close();
            });
    });

    $inSubTipoField.on('change', function () {
        disableField($inCodConta);

        if ('' === $(this).val()) {
            return;
        }

        modal.disableBackdrop().setTitle('Aguarde').setBody('Carregando').open();

        // src/Urbem/PrestacaoContasBundle/Resources/views/Tribunal/MG/Configuracao/RecDescExtra/main.html.twig
        var $listagem = $('#listagem');

        $listagem.DataTable().destroy();

        $listagem.DataTable({
            "pageLength": 15,
            "ordering": false,
            "searching": false,
            "paging": true,
            "processing": true,
            "serverSide": true,
            "lengthChange":false,
            // src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoRecDescExtra.php::buildServiceProvider
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoRecDescExtra.php::actionLoadBalanceteExtmmaa
            "ajax": {
                "url": UrlServiceProviderTCE,
                "type": 'GET',
                "data": function (data) {
                    data.action = 'LoadBalanceteExtmmaa';
                    data.inCategoria = $inCategoriaField.val();
                    data.inTipoLancamento = $inTipoLancamentoField.val();
                    data.inSubTipo = $inSubTipoField.val();

                    return data;
                }
            },
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Portuguese-Brasil.json"
            },
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoRecDescExtra.php::actionLoadBalanceteExtmmaa
            "columns": [
                {"data": "codigo"},
                {"data": "codigoEstrutural"},
                {"data": "descricao"},
                {"data": null}
            ],
            "columnDefs": [
                {
                    "targets": -1,
                    "data": null,
                    "render": function (data, type, full, meta) {
                        return "<input type=\"hidden\" name=\"key\" value=\"" + data.key + "\">" + "<span class=\"white-text btn btn-warning remove-row\"><i class=\"material-icons\">close</i></span>"
                    }
                }
            ],
            "drawCallback": function () {
                enableField($inCodConta);
                modal.close();
            }
        });
    });

    $buttonSave.on('click', function () {
        modal.setTitle('Aguarde').setBody('Salvando').open();

        data = $(document.forms[0]).serializeArray();
        data.push({name: 'action', value: 'SaveBalanceteExtmmaa'});

        $.post(UrlServiceProviderTCE, data)
            .success(function (data) {
                alert(data.message);
                modal.close();
            })
            .error(function (data) {
                alert('Por favor, contate o suporte técnico');
                modal.close();
            });
    });

    $('body').on('click', '.remove-row', function(e) {
        modal.setTitle('Aguarde').setBody('Removendo').open();

        var row = $(this).parents('tr');

        // including input:hidden[name='key'] set on columnDefs
        data = row.find('input, select').serializeArray();
        data.push({name: 'action', value: 'DeleteBalanceteExtmmaa'});

        $.post(UrlServiceProviderTCE, data)
            .success(function (data) {
                row.remove();
                alert(data.message);
                modal.close();
            })
            .error(function (data) {
                alert('Por favor, contate o suporte técnico');
                modal.close();
            });
    });

}());