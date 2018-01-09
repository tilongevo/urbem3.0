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
        data.push({name: 'action', value: 'LoadDDC'});

        modal.disableBackdrop().setTitle('Aguarde').setBody('Carregando').open();

        var url = UrlServiceProviderTCE + '&' + $(document.forms[0]).serialize();

        // src/Urbem/PrestacaoContasBundle/Resources/views/Tribunal/MG/Configuracao/DDC/main.html.twig
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
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoDDC.php::buildServiceProvider
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoDDC.php::actionLoadDDC
            "ajax": {
                "url": url,
                "type": 'POST',
                "data": function (data) {
                    data.action = 'LoadDDC';

                    return data;
                }
            },
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Portuguese-Brasil.json"
            },
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoDDC.php::actionLoadDDC
            "columns": [
                {"data": "exercicio"},
                {"data": "mes"},
                {"data": "entidade"},
                {"data": "lei"},
                {"data": "contrato"},
                {"data": "data"},
                {"data": null}
            ],
            "columnDefs": [
                {
                    "targets": -1,
                    "data": null,
                    "render": function (data, type, full, meta) {
                        return "<input type=\"hidden\" name=\"key\" value=\"" + data.key + "\">" +
                            "<span class=\"white-text blue darken-4 btn btn-success edit-row\"><i class=\"material-icons\">edit</i></span>" +
                            "<span class=\"white-text btn btn-warning remove-row\"><i class=\"material-icons\">close</i></span>";
                    }
                }
            ],
            "drawCallback": function () {
                modal.close().remove();
            }
        });
    });

    $('a.new').click(function() {
        modal.disableBackdrop().setTitle('Aguarde').setBody('Carregando').open();

        data = [];
        data.push({name: 'action', value: 'LoadForm'});

        $.get(UrlServiceProviderTCE, data)
            .success(function (data) {
                modal.close().remove();
                modal.disableBackdrop().showCloseButton().setTitle('Dados para Configuração do DDC').setBody($(data.form)).open({'size': 'large'});
            })
            .error(function (data) {
                modal.close().remove();
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
                modal.disableBackdrop().showCloseButton().setTitle('Dados para Configuração do DDC').setBody($(data.form)).open({'size': 'large'});
            })
            .error(function (data) {
                modal.close().remove();
            });
    });

    $('body').on('click', '.remove-row', function() {
        modal.disableBackdrop().setTitle('Aguarde').setBody('Carregando').open();

        data = [];
        data.push({name: 'action', value: 'RemoveConfiguracaoDDC'});
        data.push({name: 'key', value: $(this).parent().find('input[name="key"]').val()});

        $.get(UrlServiceProviderTCE, data)
            .success(function (data) {
                alert(data.message);
                modal.close().remove();
            })
            .error(function (data) {
                modal.close().remove();
            });
    });

    $('body').on('click', 'button[name="save_update"]', function(e) {
        modal.close().remove();
        modal.disableBackdrop().setTitle('Aguarde').setBody('Validando').open();

        data = $("#form").serializeArray();
        data.push({name: 'action', value: 'LoadForm'});

        $.post(UrlServiceProviderTCE, data)
            .success(function (data) {
                modal.close().remove();

                if (null !== data.message) {
                    alert(data.message);
                    return;
                }

                modal.disableBackdrop().showCloseButton().setTitle('Dados para Configuração do DDC').setBody($(data.form)).open({'size': 'large'});
            })
            .error(function (data) {
                modal.close().remove();
            });
    });
}());