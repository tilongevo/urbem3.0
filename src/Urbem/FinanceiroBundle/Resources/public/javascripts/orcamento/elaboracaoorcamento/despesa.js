$(document).ready(function() {
    'use strict';

    var $unidade = $("#" + UrbemSonata.uniqId + "_fkOrcamentoUnidade");
    var $funcao = $("#" + UrbemSonata.uniqId + "_fkOrcamentoFuncao");
    var $subfuncao = $("#" + UrbemSonata.uniqId + "_fkOrcamentoSubfuncao");
    var $programa = $("#" + UrbemSonata.uniqId + "_fkOrcamentoPrograma");
    var $pao = $("#" + UrbemSonata.uniqId + "_fkOrcamentoPao");
    
    $unidade.prop("readonly", true);
    $funcao.prop("readonly", true);
    $subfuncao.prop("readonly", true);
    $programa.prop("readonly", true);
    $pao.prop("readonly", true);
    
    var $valDotacao = $("#" + UrbemSonata.uniqId + "_vlOriginal");
    
    if ($valDotacao.val() == undefined ) {
        return false;
    }

    var totalValor = 0;
    var totalPercentual = UrbemSonata.convertMoneyToFloat($('#totalPercentual').val());

    $(".tb_percent").mask("###,00", {reverse: true});
    $(".tb_val").mask("#.##0,00", {reverse: true});

    $("#totalPercentual").attr('readonly', true);
    $("#totalValor").attr('readonly', true);
    $(".tb_val").attr('readonly', true);

    var path = window.location.pathname.substring(1);
    var isEdit = path.includes("/edit");
    if (!isEdit) {
        $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_fkOrcamentoReceitaCreditoTributario").hide();
        $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_fkOrcamentoReceitaCreditoTributario").disabled = true;
        $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_fkOrcamentoReceitaCreditoTributario").required = false;
    }

    $("#" + UrbemSonata.uniqId + "_vlOriginal").on("blur", function()
    {
        $(".alert_error").remove();
    });

    $(".tb_percent").on("blur", function()
    {
        $(".alert_error").remove();

        var inputId = jQuery(this).attr('id');

        var n = $("#" + inputId).val();
        var n_ = UrbemSonata.convertMoneyToFloat(n);

        var v = $("#" + UrbemSonata.uniqId + "_vlOriginal").val();
        var v_ = UrbemSonata.convertMoneyToFloat(v);
        if (v_ == undefined) {
            getMessage( $valDotacao.parent().parent(), "_valor", textMessageValor);
        } else if (v_ != undefined && Number(v_) == 0) {
            getMessage( $valDotacao.parent().parent(), "_valor", textMessageValor);
        } else {
            var vFloat = v_; //valor
            var nFloat = n_; //porcentagem

            var result = vFloat / 100 * nFloat;
            var vl = result.toFixed(2);

            var inputIdValor = inputId.replace("Percentual", "");
            $("#" + inputIdValor).val( UrbemSonata.convertFloatToMoney(vl) );

            if( Number(n_) > 100) {
                $("#" + inputId).val('100,00');
                $("#" + inputIdValor).val(v);
            }

            if (n.indexOf(',') < 0) {
                $("#" + inputId).val(UrbemSonata.convertMoneyToFloat(n) + ',00');
            }

            if (n.length == 0) {
                $("#" + inputIdValor).val('0,00');
            }

            if( $("#totalPercentual").val() != undefined) {
                totalPercentual = 0;
                for (var i = 1; i <= 6; i++) {
                    var vlPercentual = UrbemSonata.convertMoneyToFloat($("#vlPercentual_" + i).val());
                    totalPercentual = totalPercentual + vlPercentual;
                }
                if( totalPercentual  > 100) {
                    $(".alert_error__total").remove();
                    getMessage( $('.totalMsgValidate'), "_total", textMessageExceed);
                    $("#totalPercentual").focus();
                } else if( Number($("#totalPercentual").val()) <= 100) {
                    $(".alert_error__total").remove();
                }
            }

            $("#totalPercentual").val(UrbemSonata.convertFloatToMoney(totalPercentual));

            if( $("#totalValor").val() != undefined) {
                totalValor = 0;
                for (var i = 1; i <= 6; i++) {
                    totalValor += UrbemSonata.convertMoneyToFloat($('#vl_' + i).val());
                }
            }
            $("#totalValor").val(UrbemSonata.convertFloatToMoney(totalValor));
        }
    });
    
    $valDotacao.on("blur", function(){
    	var total = 0;
    	for (var i = 1; i <= $(".tb_percent").length; i++) {
    		if (typeof $("#vlPercentual_" + i).attr('data-no-edit') == "undefined") {
    			var vlPercentual = UrbemSonata.convertMoneyToFloat($("#vlPercentual_" + i).val());
                var valDotacao = UrbemSonata.convertMoneyToFloat($(this).val());
                
                var result = (valDotacao / 100) * parseFloat(vlPercentual);
                total += result;
                var vl = UrbemSonata.convertFloatToMoney(result);
                
                $("#vl_" + i).val(vl);
    		} else {
    			total += UrbemSonata.convertMoneyToFloat($("#vl_" + i).val());
    		}
        }
    	$("#totalValor").val(UrbemSonata.convertFloatToMoney(total));
    });

    var textMessageValor = "Primeiro, insira um valor.";
    var textMessageExceed = "Meta não pode ser excedida além dos 100%.";
    var textMessageLess = "Meta não pode ser menor que 100%.";
    var textMessageValError = "O valor total das previsões é diferente da dotação orçamentaria."

    function getMessage(context, inputId, textMessage)
    {
        var message = null;
        $(".alert_error").remove();
        context.addClass('sonata-ba-field-error');
        message =
            '<div class="help-block sonata-ba-field-error-messages alert_error alert_error_' + inputId + '"> ' +
                '<ul class="list-unstyled"><li><i class="fa fa-exclamation-circle"></i> ' + textMessage + ' </li></ul> ' +
            '</div>';
        context.append(message);
        return;
    }

    $('form').on('submit', function()
    {
        $(".alert_error").remove();
        for (var i = 1; i <= 6; i++) {
            if ( $("#vl_" + i).val() == "") {
                $("#vl_" + i).val(0);
            }
        }
        if (UrbemSonata.convertMoneyToFloat($('#totalValor').val()) != UrbemSonata.convertMoneyToFloat($valDotacao.val())) {
        	getMessage($('.totalMsgValidate'), "_total", textMessageValError);
            return false;
        }
        if (Number(totalPercentual) < 100) {
            getMessage($('.totalMsgValidate'), "_total", textMessageLess);
            return false;
        } else if (Number(totalPercentual) > 100) {
            getMessage($('.totalMsgValidate'), "_total", textMessageExceed);
            return false;
        } else {
            return true;
        }
    });

    $('div .campo-sonata:eq(1)').css({"max-height" : "66px"} );
    $('.col.s8.initial.left-align').css({"position" : "fixed"} );

    jQuery("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_codConta").removeClass('s3').addClass('s9');
    jQuery("#" + UrbemSonata.uniqId + "_creditoTributario").closest('label').attr({'style': 'margin-top: 21px !important;'});

    $('#' + UrbemSonata.uniqId + '_codConta_autocomplete_input').on("change", function() {
        localStorage.setItem('codContaId', $(this).select2('data').id);
        localStorage.setItem('codContaLabel', $(this).select2('data').label);
    });

    if (($("input[name='" + UrbemSonata.uniqId + "[codConta]']").val()) && (localStorage.getItem('codContaLabel'))) {
        $('#' + UrbemSonata.uniqId + '_codConta_autocomplete_input').select2('data', {
            id: localStorage.getItem('codContaId'),
            label: localStorage.getItem('codContaLabel')
        });
    }

    localStorage.removeItem('codContaId');
    localStorage.removeItem('codContaLabel');
});
