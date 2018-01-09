$(document).ready(function(){
    "use strict";

    var creditos = $('input:radio[name="filter[creditos][value]"]');
    var inscricaoEconomica = $("label[for='filter_fkArrecadacaoParcela__fkArrecadacaoLancamento__fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__fkArrecadacaoCadastroEconomicoCalculo__fkArrecadacaoCadastroEconomicoFaturamento__fkEconomicoCadastroEconomico_value']").parent();
    var filterInscricaoEconomica = $('#filter_fkArrecadacaoParcela__fkArrecadacaoLancamento__fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__fkArrecadacaoCadastroEconomicoCalculo__fkArrecadacaoCadastroEconomicoFaturamento__fkEconomicoCadastroEconomico_value');
    var contribuinte = $('#filter-' + UrbemSonata.uniqId + '-contribuinte');
    var localizacao = $('#filter-' + UrbemSonata.uniqId + '-codLocalizacao');
    var filterLocalizacao = $('select#filter_codLocalizacao_value');
    var lote = $("label[for='filter_fkArrecadacaoPagamentos__fkArrecadacaoPagamentoLotes__codLote_value']").parent();
    var filterLote = $('#filter_fkArrecadacaoPagamentos__fkArrecadacaoPagamentoLotes__codLote_value');
    var inscricaoMunicipal = $('#filter-' + UrbemSonata.uniqId + '-inscricaoMunicipal');
    var filterInscricaoMunicipal = $('#filter_inscricaoMunicipal_value');
    var cgm = $('#filter-' + UrbemSonata.uniqId + '-cgm');
    var filterCgm = $( "input[name*='filter[cgm][value]" );
    var parcelamento = $('#filter-' + UrbemSonata.uniqId + '-parcelamento');
    var filterParcelamento = $('#filter_parcelamento_value');
    var exercicio = $('#filter_exercicio_value');
    var filterExercicio = $('#filter-' + UrbemSonata.uniqId + '-exercicio');
    var filterBanco = $('.js-banco');
    var filterAgencia = $('.js-agencia');
    var inputDtPagamento = $('.js-dtPagamento');
    var filterTipoPagamento = $('.js-tipoPagamento');
    var valor = $('.js-valor');
    var parcelaValor = $('#' + UrbemSonata.uniqId + '_fkArrecadacaoParcela__valor');
    var filterValor = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_valor');
    var numeracao = $('input#' + UrbemSonata.uniqId + '_numeracao');
    var juro = $('#' + UrbemSonata.uniqId + '_juro');
    var multa = $('#' + UrbemSonata.uniqId + '_multa');
    var correcao = $('#' + UrbemSonata.uniqId + '_correcao');
    var valorCorrigido = $('#' + UrbemSonata.uniqId + '_valorCorrigido');
    var numParcelamento = $('.js-numParcelamento');
    var numParcela = $('.js-numParcela');

    $('input:radio[name="filter[creditos][value]"]').each(function(){
        $(this).addClass('my-radio');
    });

    $('input:radio[name="filter[creditos][value]"]:first').prop('required', true);

    var baixaDebitosManual = {

        hideFields: function() {
                contribuinte.addClass('hide');
                lote.addClass('hide');
                localizacao.addClass('hide');
                inscricaoMunicipal.addClass('hide');
                inscricaoEconomica.addClass('hide');
                cgm.addClass('hide');
                parcelamento.addClass('hide');
                if (!$('select.js-tipoPagamento').val()) {
                    filterValor.addClass('hide');
                }
        },
        clearFilterFields: function() {
            $(".js-contribuinte").select2('disable');
            $("input#filter_inscricaoMunicipal_value_autocomplete_input").select2('disable');
            $("input.js-cgm").select2('disable');
            $("input.js-lote").select2('disable');
            $("select.js-localizacao").select2('disable');
            $("select#filter_fkArrecadacaoParcela__fkArrecadacaoLancamento__fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__fkArrecadacaoCadastroEconomicoCalculo__fkArrecadacaoCadastroEconomicoFaturamento__fkEconomicoCadastroEconomico_value").select2('disable');
        },
        init: function() {
            var $this = this;
            exercicio.attr('required', true);

            if (!filterBanco.val()) {
                filterAgencia.attr('disabled', true);
            }

            $this.hideFields();

            if (!inputDtPagamento.val()) {
                filterTipoPagamento.attr('disabled', true);
            }

            if (filterBanco.val() && filterAgencia.val()) {
                carregaAgencias(filterBanco.val());
            }

            $(".my-radio").on("ifClicked", function(){
                var option = $(this);

                $this.clearFilterFields();

                $this.hideFields();

                if (option.val() == 'cgm') {
                    contribuinte.removeClass('hide');
                    $("input.js-contribuinte").select2('enable');
                    $("input.js-contribuinte").attr('required', true);
                    filterExercicio.removeClass('hide');
                }

                if (option.val() == 'ie') {
                    inscricaoEconomica.removeClass('hide');
                    $("select#filter_fkArrecadacaoParcela__fkArrecadacaoLancamento__fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__fkArrecadacaoCadastroEconomicoCalculo__fkArrecadacaoCadastroEconomicoFaturamento__fkEconomicoCadastroEconomico_value").select2('enable');
                    $("select#filter_fkArrecadacaoParcela__fkArrecadacaoLancamento__fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__fkArrecadacaoCadastroEconomicoCalculo__fkArrecadacaoCadastroEconomicoFaturamento__fkEconomicoCadastroEconomico_value").attr('required', true);
                    filterExercicio.removeClass('hide');
                }

                if (option.val() == 'ii') {
                    inscricaoMunicipal.removeClass('hide');
                    lote.removeClass('hide');
                    localizacao.removeClass('hide');
                    $("input#filter_inscricaoMunicipal_value_autocomplete_input").select2('enable');
                    $("input.js-lote").select2('enable');
                    $("select.js-localizacao").select2('enable');

                    $("input#filter_inscricaoMunicipal_value_autocomplete_input").attr('required', true);
                    filterExercicio.removeClass('hide');
                    exercicio.attr('required', true);
                }

                if (option.val() == 'da') {
                    cgm.removeClass('hide');
                    parcelamento.removeClass('hide');
                    parcelamento.attr('disabled', true);
                    exercicio.attr('required', false);
                    exercicio.val('');
                    filterExercicio.addClass('hide');
                    filterParcelamento.attr('disabled', true);
                    if (!cgm.val()) {
                        filterParcelamento.attr('disabled', true);
                    }
                    $("input.js-cgm").select2('enable');
                    $("input.js-cgm").attr('required', true);
                    filterParcelamento.attr('required', true);
                }

                window.varJsLocalizacao = $('.js-localizacao').val();
                window.varJsLote = $('.js-lote').val();

                $('body').on('change', '.js-localizacao', function (e) {
                    window.varJsLocalizacao = $(this).val();
                });

                $('body').on('change', '.js-lote', function (e) {
                    window.varJsLote = $(this).val();
                });
            });

            localizacao.on('change', function() {
                if (!filterLocalizacao.val()) {
                    limpar(filterLote, false, true);
                    filterLote.select2('val', '');
                    filterInscricaoMunicipal.select2('val', '');
                    return;
                }
            });

            filterCgm.on('change', function() {
                var cgm = $(this);
                carregaCobranca(cgm.val());
            });

            filterBanco.on('change', function() {
                var banco = $(this);
                if (!banco.val()) {
                    limpar(filterAgencia);
                    filterAgencia.attr('disabled', true);
                    return;
                }
                carregaAgencias(banco.val());
            });

            inputDtPagamento.on('blur', function() {
                if (inputDtPagamento.val()) {
                    filterTipoPagamento.attr('disabled', false);
                    calculaValores();
                    return;
                }
                completeWithZero();
                filterTipoPagamento.attr('disabled', true);
            });

            filterTipoPagamento.on('change', function() {
                var tipoPagamento = $(this);
                if (tipoPagamento.val()) {
                    filterValor.removeClass('hide');
                    calculaValores();
                    return;
                }
                filterValor.addClass('hide');
                completeWithZero();
            });

            $('.my-radio').each(function() {

                if ($(this).prop('checked')) {
                    var creditoChecked = $(this);

                    if (creditoChecked.val() == 'cgm') {
                        contribuinte.removeClass('hide');
                        $("input.js-contribuinte").select2('enable');
                    }

                    if (creditoChecked.val() == 'ie') {
                        inscricaoEconomica.removeClass('hide');
                        $("select#filter_fkArrecadacaoParcela__fkArrecadacaoLancamento__fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__fkArrecadacaoCadastroEconomicoCalculo__fkArrecadacaoCadastroEconomicoFaturamento__fkEconomicoCadastroEconomico_value").select2('enable');
                    }

                    if (creditoChecked.val() == 'ii') {
                        inscricaoMunicipal.removeClass('hide');
                        lote.removeClass('hide');
                        localizacao.removeClass('hide');
                        $("input#filter_inscricaoMunicipal_value_autocomplete_input").select2('enable');
                        $("input.js-lote").select2('enable');
                        $("select.js-localizacao").select2('enable');
                    }

                    if (creditoChecked.val() == 'da') {
                        cgm.removeClass('hide');
                        parcelamento.removeClass('hide');
                        parcelamento.attr('disabled', true);
                        exercicio.attr('required', false);
                        exercicio.val('');
                        filterParcelamento.attr('disabled', true);
                        if (!cgm.val()) {
                            filterParcelamento.attr('disabled', true);
                        }
                        $("input.js-cgm").select2('enable');
                        filterExercicio.addClass('hide');
                    }
                }
            });

        }
    }

    baixaDebitosManual.init();

    function limpar(campo, option, disabled) {
        campo.empty();
        if (option) {
            campo.append('<option value="">Selecione</option>');
        }
        if (disabled) {
            campo.attr('disabled', true);
        }
    }

    function carregaCobranca(cgm) {
        if (!cgm) {
            return;
        }
        filterParcelamento.attr('disabled', true);
        $.ajax({
            url: "/tributario/arrecadacao/baixa-debitos/baixa-manual/carrega-cobrancas",
            method: "POST",
            data: {numcgm: cgm},
            dataType: "json",
            success: function (data) {
                var selected = filterParcelamento.val();
                limpar(filterParcelamento, false);
                $.each(data, function (index, value) {
                    if (index == selected) {
                        filterParcelamento.append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        filterParcelamento.append("<option value=" + index + ">" + value + "</option>");
                    }
                });
                filterParcelamento.attr('disabled', false);
            }
        });
    }

    function carregaAgencias(banco) {
        if (!banco) {
            return;
        }
        var selected = filterAgencia.val();
        filterAgencia.attr('disabled', true);
        filterAgencia.empty();
        $.ajax({
            url: "/tributario/arrecadacao/baixa-debitos/baixa-manual/carrega-agencias",
            method: "POST",
            data: {codBanco: banco},
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, value) {
                    if (index == selected) {
                        filterAgencia.append("<option value='" + index + "' selected>" + value + "</option>");
                    } else {
                        filterAgencia.append("<option value='" + index + "'>" + value + "</option>");
                    }
                });
                filterAgencia.val(selected).change();
                filterAgencia.attr('disabled', false);
            }
        });
    }

    function completeWithZero() {
        juro.val('0.00');
        multa.val('0.00');
        correcao.val('0.00');
        valorCorrigido.val('0.00');
    }

    function calculaValores() {
        if (!filterTipoPagamento.val()) {
            completeWithZero();
            return;
        }
        $.ajax({
            url: "/tributario/arrecadacao/baixa-debitos/baixa-manual/calcula-valores",
            method: "GET",
            data: {numeracao: numeracao.val(), data: inputDtPagamento.val()},
            dataType: "json",
            success: function (response) {

                var juros = (response.juros).replace('.', ',');
                var multas = (response.multa).replace('.', ',');
                var correcoes = (response.correcao).replace('.', ',');
                var parcelamento = (response.num_parcelamento);
                var parcela = (response.num_parcela);

                juro.val(juros);
                multa.val(multas);
                correcao.val(correcoes);
                numParcelamento.val(parcelamento);
                numParcela.val(parcela);

                var sum = (UrbemSonata.convertMoneyToFloat(parcelaValor.val()) + UrbemSonata.convertMoneyToFloat(juros) + UrbemSonata.convertMoneyToFloat(multas) + UrbemSonata.convertMoneyToFloat(correcoes));

                valorCorrigido.val(UrbemSonata.convertFloatToMoney(sum));
            }
        });
    }

}());
