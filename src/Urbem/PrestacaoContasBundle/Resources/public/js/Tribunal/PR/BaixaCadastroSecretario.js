$(document).ready(function() {
    var modal = $.urbemModal();

    modal.disableBackdrop().setTitle('Aguarde').setBody('Buscando Informações').open();

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", function() {
        modal.close().remove();
    });

    // remove create button and default fields
    $('button[name="btn_create_and_list"]').remove();

    // disable form submit
    document.forms[0].onsubmit = function (e) {
        return false;
    };

    $('button[name="filter"]').click(function() {
        data = $(document.forms[0]).serializeArray();
        data.push({name: 'action', value: 'LoadCadastroSecretario'});

        modal.disableBackdrop().setTitle('Aguarde').setBody('Carregando').open();

        var url = UrlServiceProviderTCE + '&' + $(document.forms[0]).serialize();

        // src/Urbem/PrestacaoContasBundle/Resources/views/Tribunal/PR/Configuracao/BaixaCadastroSecretario/main.html.twig
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
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/PR/Configuracao/ConfiguracaoBaixaSecretario.php::buildServiceProvider
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/PR/Configuracao/ConfiguracaoBaixaSecretario.php::actionLoadCadastroSecretario
            "ajax": {
                "url": url,
                "type": 'POST',
                "data": function (data) {
                    data.action = 'LoadCadastroSecretario';

                    return data;
                }
            },
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Portuguese-Brasil.json"
            },
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/PR/Configuracao/ConfiguracaoBaixaSecretario.php::actionLoadCadastroSecretario
            "columns": [
                {"data": "numCadastro"},
                {"data": "orgao"},
                {"data": "secretario"},
                {"data": "dataInicio"},
                {"data": "dataBaixa"},
                {"data": null}
            ],
            "columnDefs": [
                {
                    "targets": -1,
                    "data": null,
                    "render": function (data, type, full, meta) {
                        return "<input type=\"hidden\" name=\"key\" value=\"" + data.key + "\">" +
                            "<span class=\"white-text blue darken-4 btn btn-success edit-row\"><i class=\"material-icons\">edit</i></span>";
                    }
                }
            ],
            "drawCallback": function () {
                modal.close().remove();
            }
        });
    });

    $('body').on('click', '.edit-row', function() {
        modal.disableBackdrop().setTitle('Aguarde').setBody('Carregando').open();

        data = [];
        data.push({name: 'action', value: 'LoadForm'});
        data.push({name: 'key', value: $(this).parent().find('input[name="key"]').val()});

        $.get(UrlServiceProviderTCE, data)
            .success(function (data) {
                modal.close().remove();
                modal.disableBackdrop().showCloseButton().setTitle('Dados para Baixa do Secretário').setBody($(data.form)).open({'size': 'large'});
            })
            .error(function (data) {
                modal.close().remove();
            });
    });

    $('body').on('click', 'button[name="save_update"]', function(e) {
        data = $("#form").serializeArray();
        data.push({name: 'action', value: 'LoadForm'});

        modal.close().remove();
        modal.disableBackdrop().setTitle('Aguarde').setBody('Validando').open();

        $.post(UrlServiceProviderTCE, data)
            .success(function (data) {
                modal.close().remove();

                if (null !== data.message) {
                    alert(data.message);
                }

                if (true === data.success) {
                    return;
                }

                modal.disableBackdrop().showCloseButton().setTitle('Dados para Baixa do Secretário').setBody($(data.form)).open({'size': 'large'});
            })
            .error(function (data) {
                modal.close().remove();
            });
    });

}());