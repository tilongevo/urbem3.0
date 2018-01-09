(function ($, urbem) {
    'use strict';

    var ano = urbem.giveMeBackMyField('ano'),
        mes = urbem.giveMeBackMyField('mes'),
        tipo = urbem.giveMeBackMyField('tipo'),
        ordenacao = urbem.giveMeBackMyField('ordenacao'),
        gerarRelatorio = urbem.giveMeBackMyField('gerarRelatorio');

    var matricula = $('#' + UrbemSonata.uniqId + "_matricula_autocomplete_input");
    var lotacao = $('#' + UrbemSonata.uniqId + "_lotacao");
    var local = $('#' + UrbemSonata.uniqId + "_local");
    var padrao = $('#' + UrbemSonata.uniqId + "_padrao");
    var geral = $('#' + UrbemSonata.uniqId + "_geral");
    var funcao = $('#' + UrbemSonata.uniqId + "_funcao");

    var selectTipo = '';
    desabilitaCampoComExcecao([]);

    tipo.on("change", function () {

        getValueAndDisabledFields();
    });

    function getValueAndDisabledFields() {
        switch (tipo.val()) {

            case "matricula":
                desabilitaCampoComExcecao([matricula]);
                selectTipo = matricula.select2('val');
                break;
            case "lotacao":
                desabilitaCampoComExcecao([lotacao]);
                selectTipo = lotacao.select2('val');
                break;
            case "local":
                desabilitaCampoComExcecao([local]);
                selectTipo = local.select2('val');
                break;
            case "funcao":
                desabilitaCampoComExcecao([funcao]);
                selectTipo = funcao.select2('val');
                break;
            case "geral":
                desabilitaCampoComExcecao([]);
                matricula.select2('data', '');
                lotacao.select2('data', '');
                local.select2('data', '');
                funcao.select2('data', '');
                selectTipo = "geral";
                break;
            default:
                desabilitaCampoComExcecao([]);
                matricula.select2('data', '');
                lotacao.select2('data', '');
                local.select2('data', '');
                funcao.select2('data', '');
        }
    }

    function desabilitaCampoComExcecao(camposExcecoes) {

        var campos = [matricula, lotacao, local, funcao];

        campos.forEach(function(campo) {
            campo.select2('disable');
            campo.prop('disabled', true);

            camposExcecoes.forEach(function(campoExcecao) {
                if (campo === campoExcecao) {
                    campo.select2('enable');
                    campo.attr('disabled', false);
                    campo.attr('required', true);
                } else {
                    campo.select2('data', '');
                }
            });
        });
    }

    mes = urbem.giveMeBackMyField('mes');

    ano.on('change', function() {
        if ($(this).val() != '') {
            abreModal('Carregando','Aguarde, buscando compentencias...');
            $.ajax({
                url: '/api-search-competencia-pagamento/preencher-competencia-folha-pagamento',
                method: "POST",
                data: {
                    ano: $(this).val()
                },
                dataType: "json",
                success: function (data) {
                    urbem.populateSelect(mes, data, {value: 'id', label: 'label'}, mes.data('mes'));
                    fechaModal();
                }
            });
        }
    });

    ano.on('change', function() {
        if ($(this).val() != '') {
            abreModal('Carregando','Aguarde, selecionando lotações...');
            $.ajax({
                url: '/api-search-competencia-pagamento/preencher-competencia-folha-pagamento',
                method: "POST",
                data: {
                    ano: $(this).val()
                },
                dataType: "json",
                success: function (data) {
                    urbem.populateSelect(mes, data, {value: 'id', label: 'label'}, mes.data('mes'));
                    fechaModal();
                }
            });
        }
    });

    $('#sonata-ba-field-container-'+UrbemSonata.uniqId+'_gerarRelatorio').hide();


    $('#gerarRelatorio').on('click', function () {
        var error = false;
        var mensagem = '';
        jQuery('.sonata-ba-field-error-messages').remove();
        jQuery('.sonata-ba-form').parent().find('.alert.alert-danger.alert-dismissable').remove();

        if ((tipo.val() == "")) {
            UrbemSonata.setFieldErrorMessage('','Campo obrigatório!', tipo.parent());
            return
        }

        if ((ano.val() == "")) {
            UrbemSonata.setFieldErrorMessage('','Campo obrigatório!', ano.parent());
            return
        }

        if ((mes.val() == "")) {
            UrbemSonata.setFieldErrorMessage('','Campo obrigatório!', mes.parent());
            return
        }

        var campoDeBusca = urbem.giveMeBackMyField(tipo.val());

        if (tipo.val() != 'geral') {
            if (campoDeBusca.select2('val') == ''  ) {
                UrbemSonata.setFieldErrorMessage('','Campo obrigatório!', campoDeBusca.parent());
                return
            }
        }

        getValueAndDisabledFields(); //Pega os valores do formulário

        abreModal('Carregando','Aguarde ...');
        var data = {
            'tipo' : tipo.val(),
            'tipoValor' : selectTipo,
            'mes' : mes.val(),
            'ano' : ano.val(),
            'ordenacao' : ordenacao.val()
        };

        $.ajax({
            url: '/recursos-humanos/folha-pagamento/relatorios/termo-rescisao/gerar_relatorio',
            method: "GET",
            data: data,
            dataType: "json",
            success: function (data) {
                var url = '/recursos-humanos/folha-pagamento/relatorios/termo-rescisao/view-download-arquivo/';
                window.location = url + data.filename + '?total=' + data.contratos;
                fechaModal();
            },
            error: function (data) {
                fechaModal();
            }
        });
    });

})(jQuery, UrbemSonata);
