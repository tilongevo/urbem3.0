$(function () {
    "use strict";

    var templateParcelaHeader =
        '<h5 class=\"col s10 box-title left-align show\"></h5>' +
        '<div class=\"box-body  no-padding\">' +
        '<table class=\"table show-table\">' +
        '<tbody>';

    var templateParcelaFooter = '</tbody>' +
        '</table>' +
        '</div>';

    var templateParcela1 = '<tr class=\"sonata-ba-view-container\">' +
        '<th>Última Numeração</th>' +
        '<td class=\"numeracao\"></td><select><option>Vencimentos</option><option>{{ parcela[\'numeracao\'] }}</option></select>' +
        '</td></tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Parcela</th>' +
        '<td class=\"parcela\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Vencimento</th>' +
        '<td class=\"vencimento\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Situação</th>' +
        '<td class=\"situacao\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container hide\">' +
        '<th>Data de Pagamento</th>' +
        '<td class=\"dataPagamento\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container hide\">' +
        '<th>Lote</th>' +
        '<td class=\"codLote\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container hide\">' +
        '<th>Data Processamento</th>' +
        '<td class=\"dataProcessamento\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container hide\">' +
        '<th>Banco</th>' +
        '<td class=\"banco\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container hide\">' +
        '<th>Agência</th>' +
        '<td class=\"agencia\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container hide\">' +
        '<th>Observação</th>' +
        '<td class=\"observacao\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container hide\">' +
        '<th>Usuário</th>' +
        '<td class=\"cgm\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Valor da Parcela</th>' +
        '<td class=\"valor\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Descontos</th>' +
        '<td class=\"desconto\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Juros</th>' +
        '<td class=\"juros\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Multa</th>' +
        '<td class=\"multa\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Correção</th>' +
        '<td class=\"correcao\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container hide\">' +
        '<th>Diferença de Pagamento</th>' +
        '<td class=\"diferenca\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Total Pago</th>' +
        '<td class=\"totalPago\" colspan=\"2\"></td>' +
        '</tr>';

    var templateParcelas = '<tr class="sonata-ba-view-container">' +
        '<th>Última Numeração</th>' +
        '<td class=\"numeracao\"></td>' +
        '<td class=\"s12\">' +
        '<select><option>Vencimentos</option><option class="numeracao"></option></select>' +
        '</td></tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Parcela</th>' +
        '<td class=\"parcela\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Vencimento</th>' +
        '<td class=\"vencimento\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Situação</th>' +
        '<td class=\"situacao\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Valor da Parcela</th>' +
        '<td class=\"valorParcela\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Descontos</th>' +
        '<td class=\"desconto\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Juros</th>' +
        '<td class=\"juros\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Multa</th>' +
        '<td class=\"multa\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Correção</th>' +
        '<td class=\"correcao\" colspan=\"2\"></td>' +
        '</tr>' +
        '<tr class=\"sonata-ba-view-container\">' +
        '<th>Total a Pagar</th>' +
        '<td class=\"totalPagar\" colspan=\"2\"></td>' +
        '</tr>';

    var templateDetalhamentoHeader =
        '<h5 class=\"col s10 box-title left-align show\">titulo</h5>' +
        '<div class=\"box-body  no-padding\">' +
        '<table class=\"bordered highlight\">' +
        '<tbody>';

    var detalhamentoPorCreditoHeader = '<tr class=\"tr-rh\">' +
        '<th class=\"th-rh\">&nbsp;</th>' +
        '<th class=\"th-rh\">Crédito</th>' +
        '<th class=\"th-rh\">Valor</th>' +
        '<th class=\"th-rh\">Descontos</th>' +
        '<th class=\"th-rh\">Juros</th>' +
        '<th class=\"th-rh\">Multa</th>' +
        '<th class=\"th-rh\">Correção</th>' +
        '<th class=\"th-rh\">Valor Diferença</th>' +
        '<th class=\"th-rh\">Valor Total</th>' +
        '</tr>';

    var detalhamentoPorCreditoTemplate = '<tr class=\"tr-rh\">' +
        '<td class=\"tr-rh center\">index</td>' +
        '<td class=\"tr-rh\">credito_codigo_composto - credito_nome</td>' +
        '<td class=\"tr-rh\">valor_credito</td>' +
        '<td class=\"tr-rh\">credito_descontos</td>' +
        '<td class=\"tr-rh\">credito_juros_pagar</td>' +
        '<td class=\"tr-rh\">credito_multa_pagar</td>' +
        '<td class=\"tr-rh\">credito_correcao_pago</td>' +
        '<td class=\"tr-rh\">diferenca</td>' +
        '<td class=\"tr-rh\">valor_total</td>' +
        '</tr>';

    var detalhamentoColunaTotal = '<tr class=\"tr-rh\">' +
        '<td class=\"tr-rh\" colspan=\"7\">&nbsp;</td>' +
        '<td class=\"tr-rh right\">Total:</td>' +
        '<td class=\"tr-rh\">total</td>' +
        '</tr>';

    function init() {
        $('.js-toggle').on('click', function(){
            var parcela = $(this);
            var detalhesDiv = parcela.parent().next().find('.toggleDiv');

            detalhesDiv.toggle();

            detalhesDiv.next('div.toggleDiv2').toggle();

            var icon = parcela.find('i');
            var detalhe = parcela.find('a').attr('data-detalhe');

            if (icon.hasClass('fa-caret-square-o-down')) {
                icon.removeClass('fa-caret-square-o-down');
                icon.addClass('fa-caret-square-o-up');

                if (detalhe.length) {
                    findDetalheParcela(detalhe,detalhesDiv);
                }

                return;
            }

            icon.removeClass('fa-caret-square-o-up');
            icon.addClass('fa-caret-square-o-down');
        });

        $('.js-toggle').trigger('click');
    }

    function findDetalheParcela(params, detalhesDiv) {
        detalhesDiv.empty();

        params = params.split(',');

        var codLancamento = params[0];
        var numeracao = params[1];
        var codParcela = params[2];
        var ocorrenciaPagamento = params[3];

        var descricaoGrupoCredito = 'iptu';
        if (location.pathname.split('/').indexOf('iss') >= 0) {
             descricaoGrupoCredito = 'iss';
        }

        $.ajax({
            url: '/portal-cidadao/arrecadacao/consulta/'+ descricaoGrupoCredito +'/detalhe-parcela',
            method: "GET",
            data: {codLancamento: codLancamento, numeracao: numeracao, codParcela: codParcela, ocorrenciaPagamento: ocorrenciaPagamento},
            dataType: "json",
            beforeSend: function() {
                $('html, body').animate({
                    scrollTop: detalhesDiv.offset().top
                }, 2000);

                detalhesDiv.parent().find('div.loading').removeClass('hide');

            },
            complete: function() {
                detalhesDiv.parent().find('div.loading').addClass('hide');

                findDetalhamentoPorCredito(codLancamento, numeracao, codParcela, detalhesDiv);
            },
            success: function (data) {
                var detalhe = data.data[0];

                detalhesDiv.prepend(templateParcelaHeader + templateParcela1 + templateParcelaFooter);
                detalhesDiv.find('.box-title').html(getDetalhamentoParcelaTitle(detalhe.info_parcela));
                detalhesDiv.find('.numeracao').html(detalhe.numeracao);
                detalhesDiv.find('.parcela').html(detalhe.info_parcela);
                detalhesDiv.find('.vencimento').html(detalhe.vencimento_original);
                detalhesDiv.find('.situacao').html(detalhe.situacao);

                if (detalhe.pagamento_data) {
                    detalhesDiv.find('.dataPagamento').parent().removeClass('hide');
                    detalhesDiv.find('.codLote').parent().removeClass('hide');
                    detalhesDiv.find('.dataProcessamento').parent().removeClass('hide');

                    if (data.pagamento_tipo != 'Baixa Manual') {
                        detalhesDiv.find('.banco').parent().removeClass('hide');
                        detalhesDiv.find('.agencia').parent().removeClass('hide');
                        detalhesDiv.find('.cgm').parent().removeClass('hide');

                        detalhesDiv.find('.banco').html(detalhe.pagamento_cod_banco + ' - ' + detalhe.pagamento_nom_banco);
                        detalhesDiv.find('.agencia').html(detalhe.pagamento_num_agencia + ' - ' + detalhe.pagamento_nom_agencia);
                        detalhesDiv.find('.cgm').html(detalhe.pagamento_numcgm + ' - ' + detalhe.pagamento_nomcgm);
                    }
                }

                detalhesDiv.find('.dataPagamento').html(detalhe.pagamento_data);
                detalhesDiv.find('.codLote').html(detalhe.pagamento_cod_lote);
                detalhesDiv.find('.dataProcessamento').html(detalhe.pagamento_data_baixa);

                if (detalhe.observacao) {
                    detalhesDiv.find('.observacao').html(detalhe.observacao).parent().removeClass('hide');
                }

                detalhesDiv.find('.valor').html(moneySymbol() + detalhe.parcela_valor);
                detalhesDiv.find('.desconto').html(moneySymbol() + detalhe.parcela_valor_desconto);

                var valorHtml = getZero();
                if (detalhe.parcela_juros) {
                    valorHtml = moneySymbol() + detalhe.parcela_juros;
                }
                detalhesDiv.find('.juros').html(valorHtml);

                valorHtml = getZero();
                if (detalhe.parcela_multa) {
                    valorHtml = moneySymbol() + detalhe.parcela_multa;
                }
                detalhesDiv.find('.multa').html(valorHtml);

                valorHtml = getZero();
                if (detalhe.parcela_correcao_pagar) {
                    valorHtml = moneySymbol() + detalhe.parcela_correcao_pagar;
                }
                detalhesDiv.find('.correcao').html(valorHtml);

                valorHtml = getZero();
                if (detalhe.tmp_pagamento_diferenca) {
                    valorHtml = moneySymbol() + detalhe.tmp_pagamento_diferenca;
                }
                detalhesDiv.find('.diferenca').html(valorHtml);

                if (detalhe.tp_pagamento==true) {
                    detalhesDiv.find('.diferenca').parent().removeClass('hide');
                }

                valorHtml = getZero();
                if (detalhe.valor_total) {
                    valorHtml = moneySymbol() + detalhe.valor_total;
                }
                detalhesDiv.find('.totalPago').html(valorHtml);

                if (!detalhe.pagamento_data) {
                    detalhesDiv.find('.totalPago').siblings('th').html('Total a Pagar');
                }
            }
        });
    }

    function moneySymbol() {
        return 'R$ ';
    }

    function getZero() {
        return moneySymbol() + '0.00';
    }

    function getDetalhamentoParcelaTitle(numParcela) {
        return '<strong>Detalhamento de Valores da parcela ' + numParcela + '</strong>';
    }

    function getDetalheParcelaTitle() {
        return '<strong>Detalhamento por Crédito</strong>';
    }

    function getDetalhamentoCreditoTitle() {
        return '<strong>Detalhamento por Crédio</strong>';
    }

    function findDetalhamentoPorCredito(codLancamento, numeracao, codParcela, detalhesDiv) {
        var codLancamento = codLancamento;
        var numeracao = numeracao;
        var codParcela = codParcela;

        var descricaoGrupoCredito = 'iptu';
        if (location.pathname.split('/').indexOf('iss') >= 0) {
             descricaoGrupoCredito = 'iss';
        }

        $.ajax({
            url: '/portal-cidadao/arrecadacao/consulta/'+ descricaoGrupoCredito +'/detalhamento-por-credito',
            method: "GET",
            data: {codLancamento: codLancamento, numeracao: numeracao, codParcela: codParcela},
            dataType: "json",
            beforeSend: function() {
                $('html, body').animate({
                    scrollTop: detalhesDiv.offset().top
                }, 2000);

                detalhesDiv.parent().find('div.loading2').removeClass('hide');
            },
            complete: function() {
                detalhesDiv.parent().find('div.loading2').addClass('hide');
            },
            success: function (data) {
                var obj = data.data;
                var template = detalhamentoPorCreditoTemplate;
                var temp = '';
                var detalhamento, rowTotal;
                var total = 0;
                var recalcDiferenca = false;

                $.each(obj, function(ObjKey, ObjValue) {

                    detalhamento = detalhamentoPorCreditoTemplate;
                    detalhamento = detalhamento.replace('index', ObjKey+1);

                    $.each(ObjValue, function(key, value) {

                        if (key == 'valor_total') {
                            total += parseFloat(Number(value));
                        }

                        if (key == 'pagamento_data' && value) {
                            if (parseInt(ObjValue.pagamento_diferenca) > 0) {
                                return;
                            }

                            ObjValue.diferenca = (Number(ObjValue.valor_total) - Number(ObjValue.valor_credito));
                        }

                        if (key == 'valor_total') {
                            value = Number(value);
                        }

                        detalhamento = detalhamento.replace(key, value);
                    });

                    temp += detalhamento;

                    rowTotal = detalhamentoColunaTotal.replace('total', total.toFixed(2));
                });

                detalhesDiv.append(templateDetalhamentoHeader.replace('titulo', getDetalhamentoCreditoTitle()) + detalhamentoPorCreditoHeader + temp + rowTotal + templateParcelaFooter);
            }
        });
    }

    init();

}());
