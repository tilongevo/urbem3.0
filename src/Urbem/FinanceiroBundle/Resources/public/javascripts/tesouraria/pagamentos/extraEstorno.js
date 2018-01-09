$(function() {
    window.varJsCodEntidade = 0;

    var modalLoad = new UrbemModal();
    modalLoad.setTitle('Carregando...');

    $.sonataField("#boletim").attr("disabled", "disabled");
    $.sonataField("#codRecibo").attr("disabled", "disabled");
    $.sonataField("#codRecibo").attr("disabled", "disabled");

    $(".dados-estorno").hide();
    $('button[type="submit"]').hide();
    $('#' + UrbemSonata.uniqId + '_boletim').attr("disabled", "disabled");


    function buscaBoletimArrecadacaoExtra()
    {
        var entidade = $.sonataField("#entidade").val();
        modalLoad.setBody("Aguarde, pesquisando boletins");
        modalLoad.open();

        $.ajax({
            url: "/financeiro/tesouraria/arrecadacao/extra-arrecadacoes/busca-boletim",
            method: "GET",
            data: {
                entidade: entidade
            },
            dataType: "json",
            success: function (data) {
                $(".sonata-ba-field-error-messages").remove();
                if (data.length == 0) {
                    var message = 'Não há boletins para essa entidade.'
                    getMessage( $.sonataField("#entidade") , message );
                    modalLoad.close();
                    return;
                }
                $.sonataField("#boletim").find('option').remove().end();

                var len = data.length;
                for (var i=0; i<len; i++)
                {
                    if(i == 0) {
                        $('<option/>').html('Selecione')
                            .appendTo($.sonataField("#boletim"));
                    }
                    $('<option/>').html(data[i].cod_boletim + ' - ' + data[i].dt_boletim)
                        .val(data[i].cod_boletim)
                        .appendTo($.sonataField("#boletim"));
                }
                $.sonataField("#boletim").removeAttr('disabled');
                modalLoad.close();
            }
        });
    }

    function selectResultChange(id, param_cod, param_nom)
    {
        var select = $.sonataField("#"+id);
        select.find('option').remove().end();
        $('<option />').html(param_cod + ' - ' + param_nom).val(param_cod).appendTo(select);
        select.val(param_cod).change();
    }

    function getMessage(context, message)
    {
        $(".sonata-ba-field-error-messages").remove();
        context.parent().addClass('sonata-ba-field-error');
        message =
            '<div class="help-block sonata-ba-field-error-messages alert_error_' + context + '"> ' +
            '<ul class="list-unstyled">' +
            '<li><i class="fa fa-exclamation-circle"></i> ' + message + '</li> ' +
            '</ul> ' +
            '</div>';
        context.parent().append(message);
        return;
    }

    $.sonataField("#entidade").on("change", function()
    {
        if (!$(this).val() > 0) return;
        window.varJsCodEntidade = $(this).val();
        buscaBoletimArrecadacaoExtra();
    });

    $.sonataField("#boletim").on("change", function()
    {
        if ($(this).val() > 0) {
            $.sonataField("#codRecibo").removeAttr('disabled');
            return;
        }
        $.sonataField("#codRecibo").attr("disabled", "disabled");
        $(".dados-estorno").hide();
    });

    $("#" + UrbemSonata.uniqId + "_codRecibo").on("blur", function()
    {
        if( $("#" + UrbemSonata.uniqId + "_codRecibo").val() != '' ) {
            modalLoad.setBody("Verificando se este recibo é válido... Aguarde.");
            modalLoad.open($.sonataField("#boletim").val());
            console.log( $.sonataField("#entidade").val(), $.sonataField("#codRecibo").val(), $.sonataField("#boletim").val() );
            $.ajax({
                url: "/financeiro/tesouraria/arrecadacao/extra-arrecadacoes/busca-recibo",
                method: "GET",
                data: {
                    entidade: $.sonataField("#entidade").val(),
                    recibo: $.sonataField("#codRecibo").val(),
                    boletim: $.sonataField("#boletim").val()
                },
                dataType: "json",
                success: function (data) {
                    if (data.length != 0)
                    {
                        var optionSelected = $.sonataField("#boletim option:selected").text();
                        optionSelected = optionSelected.split("-");
                        dateBoletim_exp = optionSelected[1].split("/");
                        var dtboletim = dateBoletim_exp[2] + '-' + dateBoletim_exp[1] + '-' + dateBoletim_exp[0].trim();

                        $.ajax({
                            url: "/financeiro/tesouraria/extra-estorno/get-pagamento",
                            method: "GET",
                            data: {
                                recibo: $("#" + UrbemSonata.uniqId + "_codRecibo").val(),
                                codboletim: $.sonataField("#boletim").val(),
                                dtboletim: dtboletim.trim()
                            },
                            dataType: "json",
                            success: function (data) {
                                if (data.length != 0) {
                                    selectResultChange('credor', data[0].cod_credor, data[0].nom_credor);
                                    selectResultChange('recurso', data[0].cod_recurso, data[0].nom_recurso);
                                    selectResultChange('planoDebito', data[0].cod_plano_debito, data[0].nom_conta_debito);
                                    selectResultChange('planoCredito', data[0].cod_plano_credito, data[0].nom_conta_credito);
                                    $("#" + UrbemSonata.uniqId + "_valor").val(data[0].valor);
                                    $("#" + UrbemSonata.uniqId + "_observacao").val(data[0].observacao);
                                    $(".dados-estorno").show();
                                    $('button[type="submit"]').show();
                                    $(".sonata-ba-field-error-messages").remove();
                                    modalLoad.close();
                                    return
                                } else {
                                    $(".dados-estorno").hide();
                                    modalLoad.close();
                                    $('button[type="submit"]').hide();
                                    var message = 'Não foi possível recuperar informações para este boletim.';
                                    getMessage($("#" + UrbemSonata.uniqId + "_codRecibo"), message);
                                    return
                                }
                            }
                        });
                    } else
                    {
                        $(".dados-estorno").hide();
                        modalLoad.close();
                        $('button[type="submit"]').hide();
                        var message = 'Recibo inválido ou não está pago.';
                        getMessage($("#" + UrbemSonata.uniqId + "_codRecibo"), message);
                        return
                    }
                }
            });
        }
    });

    $("#" + UrbemSonata.uniqId + "_valorEstorno").on("change", function()
    {
        var valor = $("#" + UrbemSonata.uniqId + "_valor").val();
        var valorEstornado = $("#" + UrbemSonata.uniqId + "_valorEstorno").val();
        valorEstornado = Number( valorEstornado.replace('.', '').replace(',', '').replace('.', '') );
        valor =  Number( valor.replace('.', '').replace(',', '') );
        if( valorEstornado > valor) {
            var message = 'Não pode ser maior que o Valor pago.';
            var valorEstornoInput = $("#" + UrbemSonata.uniqId + "_valorEstorno");
            getMessage( valorEstornoInput.parent(), message );
        } else {
            $(".sonata-ba-field-error-messages").remove();
        }
    });
});
