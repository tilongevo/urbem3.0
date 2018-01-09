$(document).ready(function() {

    function start() {
        modal.close();
        modal.disableBackdrop().setTitle('Aguarde').setBody('Buscando Licitações').open();

        // src/Urbem/PrestacaoContasBundle/Resources/views/Tribunal/MG/Configuracao/ResponsavelLicitacao/main.html.twig
        var $listagem = $('#listagem');

        $listagem.DataTable().destroy();

        var url = UrlServiceProviderTCE + '&' + $(document.forms[0]).serialize();

        var $table = $listagem.DataTable({
            "pageLength": 5,
            "ordering": false,
            "searching": false,
            "paging": true,
            "processing": true,
            "serverSide": true,
            "lengthChange":false,
            // src/Urbem/PrestacaoContasBundle/Controller/TceAdminController.php
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoResponsavelLicitacao.php::buildServiceProvider
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoResponsavelLicitacao.php::actionLoad
            "ajax": {
                "url": url,
                "type": 'POST',
                "data": function (data) {
                    data.action = 'Load';

                    return data;
                }
            },
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Portuguese-Brasil.json"
            },
            // src/Urbem/PrestacaoContasBundle/Service/Tribunal/MG/Configuracao/ConfiguracaoResponsavelLicitacao.php::actionLoad
            "columns": [
                {"data": "licitacao"},
                {"data": "entidade"},
                {"data": "processo"},
                {"data": "modalidade"},
                {"data": null}
            ],
            "columnDefs": [
                {
                    "targets": -1,
                    "data": null,
                    "render": function (data, type, full, meta) {
                        return "<input type=\"hidden\" name=\"key\" value=\"" + data.key + "\">" + "<span class=\"white-text blue darken-4 btn btn-success save info-row\"><i class=\"material-icons\">info_outline</i></span>"
                    }
                }
            ],
            "drawCallback": function () {
                modal.close();
            }
        });

        $('body').on('click', '.info-row', function(e) {
            modal.close();

            var tr = $(this).closest('tr');
            var row = $table.row( tr );

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');

            } else {
                $('tr.shown').removeClass('shown').next('tr').html('').hide();

                modal.setTitle('Aguarde').setBody('Carregando formulário').open();

                data = [];
                data.push({name: 'key', value: row.data().key});
                data.push({name: 'action', value: 'LoadForm'});

                $.post(UrlServiceProviderTCE, data)
                    .success(function (data) {
                        if (false === data.response) {
                            alert(data.message);
                            return;
                        }

                        row.child(data.form).show();
                        tr.addClass('shown');

                        modal.close();

                        $('select').select2();
                    })
                    .error(function (data) {
                        alert('Por favor, contate o suporte técnico');
                        modal.close();
                    });
            }
        });
    }

    var modal = $.urbemModal();

    modal.disableBackdrop().setTitle('Aguarde').setBody('Carregando').open();

    UrbemSonata.waitForFunctionToBeAvailableAndExecute("UrlServiceProviderTCE", function() { modal.close(); });

    $('body').on('click', 'button[name="save_row"]', function (e) {
        modal.disableBackdrop().setTitle('Aguarde').setBody('Processando Informação').open();

        data = $(this).parents('tr').find('input, select').serializeArray();
        data.push({name: 'action', value: 'SaveResplic'});

        $.post(UrlServiceProviderTCE, data)
            .success(function (data) {
                alert(data.message);
                modal.close();
            })
            .error(function (data) {
                alert('Por favor, contate o suporte técnico');
                modal.close();
            });

        e.preventDefault();
        e.stopPropagation();

        return false;
    });

    // disable form submit
    $('button[name="filter"]').on('click', function (e) {
        modal.disableBackdrop().setTitle('Aguarde').setBody('Carregando').open();

        start();

        e.preventDefault();
        e.stopPropagation();

        return false;
    });

    $('button[name="btn_create_and_list"]').remove();

}());