$(function() {
    window.varJsCodEntidade = 0;

    $("button[name='btn_create_and_list']").closest("form").on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });

    // Inicia desativado até a escolha do boletim
    $("button[name='btn_create_and_list']").hide();
    $(".dados-arrecadacao").hide();

    var entidadeSelect = $.sonataField("#entidade");
    var boletimSelect = $.sonataField("#boletim");
    var reciboField = $.sonataField("#codRecibo");

    var contaEntrada = $.sonataField("#contaPlanoCredito_autocomplete_input");
    var contaSaida = $.sonataField("#contaPlanoDebito_autocomplete_input");
    var historico = $.sonataField("#codHistorico_autocomplete_input");
    var valor = $.sonataField("#valor");
    var observacao = $.sonataField("#observacao");

    var btnPesquisaRecibo = $("button[name='pesquisa_boletim']");
    valor.mask("#.##0,00", {reverse: true});

    boletimSelect.attr("disabled", "disabled");
    reciboField.attr("disabled", "disabled");
    btnPesquisaRecibo.attr("disabled", "disabled");

    $('#' + UrbemSonata.uniqId + '_boletim').attr("disabled", "disabled");
    reciboField.attr("disabled", "disabled");

    var modalLoad = new UrbemModal();
    modalLoad.setTitle('Carregando...');

    function setErroBoletim(message) {
    
        if (message != '') {
            $("#alert").load("/bundles/core/javascripts/templates/alert_danger.html", null, function() {
                $(this).find("span").html(message);
            });
        } else {
            $("#alert").empty();
        }
    }

    function buscaBoletimArrecadacaoExtra() {
        var entidade = $.sonataField("#entidade").val();
        setErroBoletim("");
        modalLoad.setBody("Aguarde, pesquisando boletins");
        modalLoad.open();

        boletimSelect
            .empty()
            .append("<option value=\"\">Selecione</option>");

        $.ajax({
            url: "/financeiro/tesouraria/arrecadacao/extra-arrecadacoes/busca-boletim",
            method: "GET",
            data: {
                entidade: entidade
            },
            dataType: "json",
            success: function (data) {

                boletimSelect.select2('val', '');
                boletimSelect
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                if (data.length == 0) {

                    setErroBoletim("Não há boletins abertos para esta entidade!");

                    boletimSelect.removeAttr('disabled');
                    modalLoad.close();
                    return;
                }

                var len = data.length;
                for (var i=0; i<len; i++) {
                    $('<option/>').html(data[i].cod_boletim + ' - ' + data[i].dt_boletim)
                        .val(data[i].cod_boletim)
                        .appendTo(boletimSelect);
                }
                boletimSelect.removeAttr('disabled');
                modalLoad.close();
            }
        });
    }

    function buscaReciboArrecadacaoExtra() {
        var entidade = $.sonataField("#entidade").val();
        var recibo = $.sonataField("#codRecibo").val();
        var boletim = $.sonataField("#boletim").val();

        if (!parseInt(recibo) > 0) {
            return;
        }

        if (entidade == "" || recibo == "") {
            return setErroBoletim("Informe um boletim.");
        }
        setErroBoletim("");
        modalLoad.setBody("Aguarde, validando se recibo é válido");
        modalLoad.open();

        $.ajax({
            url: "/financeiro/tesouraria/arrecadacao/extra-arrecadacoes/busca-recibo",
            method: "GET",
            data: {
                entidade: entidade,
                recibo: recibo,
                boletim: boletim
            },
            dataType: "json",
            success: function (data) {
                if (data.length == 0 || data.error) {
                    setErroBoletim("Código de recibo inválido ("+recibo+") ou o recibo já foi arrecadado.");
                    if (data.error)
                        setErroBoletim(data.error);

                    modalLoad.close();
                    $(".dados-arrecadacao").hide();
                    $("button[name='btn_create_and_list']").hide();
                    return;
                }

                modalLoad.close();
                $(".dados-arrecadacao").show();
                $("button[name='btn_create_and_list']").show();
            }
        });
    }

    btnPesquisaRecibo.click(function() {
        buscaReciboArrecadacaoExtra();
    });

    entidadeSelect.change(function() {

        clearFields();
        hideFields();

        if (!$(this).val() > 0) return;

        window.varJsCodEntidade = $(this).val();
        buscaBoletimArrecadacaoExtra();
    });

    boletimSelect.change(function() {

        clearFields();

        if ($(this).val() > 0) {
            reciboField.removeAttr('disabled');
            btnPesquisaRecibo.removeAttr('disabled');
            $(".dados-arrecadacao").show();
            $("button[name='btn_create_and_list']").show();
            return;
        }

        hideFields();
    });

    reciboField.focusout(function() {
        buscaReciboArrecadacaoExtra();
    });

    function hideFields() {
        reciboField.attr("disabled", "disabled");
        btnPesquisaRecibo.attr("disabled", "disabled");
        $(".dados-arrecadacao").hide();
        $("button[name='btn_create_and_list']").hide();
    }

    function clearFields() {
        contaEntrada.select2('val', '');
        contaSaida.select2('val', '');
        historico.select2('val', '');
        valor.val('');
        observacao.val('');
    }
});