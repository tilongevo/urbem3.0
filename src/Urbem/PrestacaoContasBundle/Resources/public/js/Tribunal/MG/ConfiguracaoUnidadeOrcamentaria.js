$(document).ready(function() {

    function start() {
        modal.close();

        var endpoints = {
            "unidade_orcamentaria_atual": {"name": UrlServiceProviderTCE, "action": 'saveUnidadeOrcamentariaAtual'},
            "unidade_orcamentaria_conversao": {"name": UrlServiceProviderTCE, "action": 'saveUnidadeOrcamentariaConversao'}
        };

        $('#unidade_orcamentaria_atual').DataTable({
            "pageLength": 5,
            "ordering": false,
            "searching": false,
            "paging": true,
            "processing": true,
            "serverSide": true,
            "lengthChange":false,
            // src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoUnidadeOrcamentaria.php::buildServiceProvider
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoUnidadeOrcamentaria.php::actionLoadUnidadeOrcamentariaAtual
            "ajax": {
                "url": UrlServiceProviderTCE,
                "data": function (data) {
                    data.action = "LoadUnidadeOrcamentariaAtual"
                }
            },
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Portuguese-Brasil.json"
            },
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoUnidadeOrcamentaria.php::actionLoadUnidadeOrcamentariaAtual
            "columns": [
                {"data": "fkOrcamentoOrgao"},
                {"data": "fkOrcamentoUnidade"},
                {"data": "identificador"},
                {"data": "fkSwCgm"},
                {"data": null}
            ],
            "columnDefs": [
                {
                    "targets": -1,
                    "data": null,
                    "render": function (data, type, full, meta) {
                        return "<input type=\"hidden\" name=\"key\" value=\"" + data.key + "\">" + "<span class=\"white-text blue darken-4 btn btn-success save save-row\" data-endpoint=\"unidade_orcamentaria_atual\"><i class=\"material-icons left\">input</i>Salvar</span>"
                    }
                }
            ],
            "drawCallback": function () {
                $('select.select2-unidade-orcamentarial-atual').select2();
            }
        });

        $('#unidade_orcamentaria_conversao').DataTable({
            "pageLength": 5,
            "ordering": false,
            "searching": false,
            "paging": true,
            "processing": true,
            "serverSide": true,
            "lengthChange":false,
            // src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoUnidadeOrcamentaria.php::buildServiceProvider
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoUnidadeOrcamentaria.php::actionLoadUnidadeOrcamentariaConversao
            "ajax": {
                "url": UrlServiceProviderTCE,
                "data": function (data) {
                    data.action = "LoadUnidadeOrcamentariaConversao"
                }
            },
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Portuguese-Brasil.json"
            },
            // src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoUnidadeOrcamentaria.php::buildServiceProvider
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoUnidadeOrcamentaria.php::actionLoadUnidadeOrcamentariaConversao
            "columns": [
                {"data": "exercicio"},
                {"data": "num_orgao"},
                {"data": "num_unidade"},
                {"data": "identificador"},
                {"data": "fkSwCgm"},
                {"data": "fkOrcamentoOrgaoAtual"},
                {"data": "fkOrcamentoUnidadeAtual"},
                {"data": null}
            ],
            "columnDefs": [
                {
                    "targets": -1,
                    "data": null,
                    "render": function (data, type, full, meta) {
                        return "<input type=\"hidden\" name=\"key\" value=\"" + data.key + "\">" + "<span class=\"white-text blue darken-4 btn btn-success save save-row\" data-endpoint=\"unidade_orcamentaria_conversao\"><i class=\"material-icons left\">input</i>Salvar</span>"
                    }
                }
            ],
            "drawCallback": function () {
                $('select.select2-unidade-orcamentarial-conversao').select2();
            }
        });

        $('body').on('click', '.save-row', function(e) {
            modal.setTitle('Aguarde').setBody('Salvando dados').open();

            // set on columnDefs (data-endpoint)
            endpointName = $(this).data('endpoint');

            _endpoint = endpoints[endpointName];

            // including input:hidden[name='key'] set on columnDefs
            data = $(this).parents('tr').find('input, select').serializeArray();

            // src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoUnidadeOrcamentaria.php::buildServiceProvider
            data.push({name: 'action', value: _endpoint.action});

            // src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoUnidadeOrcamentaria.php::buildServiceProvider
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoUnidadeOrcamentaria.php::actionSaveUnidadeOrcamentariaAtual
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoUnidadeOrcamentaria.php::actionSaveUnidadeOrcamentariaConversao
            $.post(_endpoint.name, data)
                .success(function (data) {
                    alert(data.message);
                    modal.close();
                })
                .error(function (data) {
                    alert('Por favor, contate o suporte técnico');
                    modal.close();
                });
        });
    }

    var modal = $.urbemModal();

    modal.disableBackdrop().setTitle('Aguarde').setBody('Buscando Informações').open();

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", start);

    // remove create button and default fields
    $('button[name="btn_create_and_list"]').remove();
    $('.sonata-ba-collapsed-fields > em').remove();

    // disable form submit
    document.forms[0].onsubmit = function (e) {
        return false;
    };
}());