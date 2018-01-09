$(function() {
    $.sonataField('#valor').mask("#.##0,00", {reverse: true});
    var boletimUrl = '/financeiro/tesouraria/outras-operacoes/api/get-boletim-by-entidade';
    var contaUrl = '/financeiro/tesouraria/outras-operacoes/api/get-contas-by-entidade';
    var saldoUrl = '/financeiro/tesouraria/outras-operacoes/api/get-saldo-by-conta';
    $.sonataField('#entidade').on('change', function (event) {
        var entidade = $(this);
        $.ajax({
            url: boletimUrl,
            data: {
                'entidade': entidade.val()
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            jqAjaxErrorHandler('Erro ao consultar boletins.', textStatus, errorThrown);
        }).done(function (data, textStatus, jqXHR) {
            var boletimSelect = $.sonataField("#boletim");
            boletimSelect.find('option').remove().end();
            boletimSelect.removeAttr('disabled');

            var len = data.length;
            for (var i=0; i<len; i++) {
                $('<option/>').html(data[i].cod_boletim + ' - ' + data[i].dt_boletim)
                    .val(data[i].cod_boletim)
                    .appendTo(boletimSelect);
            }
        });
    }).trigger('change');

    $.sonataField('#contaResgate').on('click', function(event) {
        var entidade = $.sonataField('#entidade');
        $.ajax({
            url: contaUrl,
            cache: true,
            data: {
                'entidade': entidade.val()
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            jqAjaxErrorHandler('Erro ao consultar contas de saida.', textStatus, errorThrown);
        }).done(function (data) {
            var modalContaResgate = new UrbemModal();
            modalContaResgate.setTitle('Contas de Resgate');

            var bodyContent = !(data.length)
                ? 'Não foram encontradas contas de resgate.'
                : getContasAsTable(data, 'resgate');

            modalContaResgate.setBody(bodyContent);
            modalContaResgate.open();

            $('.choose-conta-resgate').on('click', function(event) {
                var link = $(this);
                $.sonataField('#contaResgateId').val(link.data('value'));
                $.sonataField('#contaResgate').val(
                    link.data('value') + ' - ' + link.data('name')
                );
                modalContaResgate.close();
            });
        });
    });

    $.sonataField("#contaSaida").on('click', function (event) {
        var entidade = $.sonataField('#entidade');
        $.ajax({
            url: contaUrl,
            cache: true,
            data: {
                'entidade': entidade.val(),
                'tipo': 'saida'
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            jqAjaxErrorHandler('Erro ao consultar contra saida', textStatus, errorThrown);
        }).done(function(data) {
            jqLog('Sucesso ao carregar contas de saida');
            var modalContaSaida = new UrbemModal();
            modalContaSaida.setTitle('Conta saida');

            var bodyContent = !(data.length)
                ? 'Não foram encontradas conta saida.'
                : getContasAsTable(data, 'saida');

            modalContaSaida.setBody(bodyContent);
            modalContaSaida.open();

            $('.choose-conta-saida').on('click', function (event) {
                var link = $(this);
                $.sonataField('#contaSaidaId').val(link.data('value'));
                $.sonataField('#contaSaida').val(
                    link.data('value') + ' - ' + link.data('name')
                );
                modalContaSaida.close();
                var loadingModel = loading();
                loadingModel.open();

                var saldo = $.get(saldoUrl, {conta: link.data('value')}, function (data) {
                    $.sonataField('saldoSaida').val(data.saldo);
                    loadingModel.close();
                });

                loadingModel.close();
            });
        });
    });

    function getContasAsTable(data, type) {
        var table = $('<table/>', {'class': 'table'});
        if (data.length) {
            var thead = $('<thead/>').appendTo(table);
            var trHead = $('<tr/>').appendTo(thead);

            $('<th/>').html('Código Classificação').appendTo(trHead);
            $('<th/>').html('Código Reduzido').appendTo(trHead);
            $('<th/>').html('Descrição').appendTo(trHead);
            $('<th/>').html('&nbsp;').appendTo(trHead);

            var tbody = $('<tbody/>').appendTo(table);

            for (var i = 0; i < data.length; i++) {
                var tr = $('<tr/>').appendTo(tbody);

                $('<td/>').html(data[i].cod_estrutural).appendTo(tr);
                $('<td/>').html(data[i].cod_plano).appendTo(tr);
                $('<td/>').html(data[i].nom_conta).appendTo(tr);

                var fieldAction = $('<td/>').appendTo(tr);

                var action = $('<a/>', {
                    'href': 'javascript:;',
                    'class': 'choose-conta-' + type,
                    'data-value': data[i].cod_plano,
                    'data-name': data[i].nom_conta
                }).appendTo(fieldAction);

                $('<span/>', {'class': 'glyphicon glyphicon-ok'}).appendTo(action);
            }
        }

        return table;
    }

    $('form[role="form"]').on('submit', function (event) {
        var saldoElement = $.sonataField('saldoSaida');
        var valor = parseFloat($.sonataField('valor').val());
        if (parseFloat(saldoElement.val()) < valor ) {
            event.preventDefault();
            event.stopPropagation();
            var alertModal = new UrbemModal();
            alertModal.setTitle('Saldo Insuficiente');
            alertModal.setBody('Atenção, o saldo da sua conta é ' + saldoElement.val() + '.<br /> Caso queira prosseguir, sua conta ficará negativa.');
            var actionSpan = $('<span/>', {});
            $('<button/>', {type: 'button', class: 'btn btn-danger pull-left btn-transaction-cancel'})
                .html('Cancelar').appendTo(actionSpan);
            $('<button/>', {type: 'button', class: 'btn btn-primary btn-transaction-continue'})
                .html('Continuar').appendTo(actionSpan);
            alertModal.setFooter(actionSpan);
            alertModal.open();

            $('.btn-transaction-cancel').on('click', function() {
                alertModal.close();
            });
            $('.btn-transaction-continue').on('click', function() {
                saldoElement.val(parseFloat(valor + 0.1));
                $('form[role="form"]').submit();
                alertModal.close();
                return true;
            });

            return false;
        }
    });

    function jqAjaxErrorHandler(msg, textStatus, errorThrown) {
        console.log('[Outras-Operacoes] ' + msg);
        console.log(textStatus);
        console.log(errorThrown);
    }

    function jqLog(msg) {
        console.log('[RESGATES] ' + msg);
    }

    function loading() {
        jqLog('Sucesso ao carregar loading model');
        var loadingModal = new UrbemModal();
        loadingModal.setBody('Carregando...');
        return loadingModal;
    }

});