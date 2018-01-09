$(document).ready(function () {
    'use strict';

    var modalLoad = new UrbemModal()
        , urlEndPoint = '/recursos-humanos/pessoal/aposentadoria/consultar-reajuste?id='
        , fieldEnquadramento =  $("#" + UrbemSonata.uniqId + "_fkPessoalClassificacaoEnquadramento")
        , fieldReajuste = UrbemSonata.giveMeBackMyField('reajuste')
        , dtRequirimento = UrbemSonata.giveMeBackMyField('dtRequirimento')
        , dtConcessao = UrbemSonata.giveMeBackMyField('dtConcessao')
        , dtPublicacao = UrbemSonata.giveMeBackMyField('dtPublicacao')
        , dtEncerramento = UrbemSonata.giveMeBackMyField('dtEncerramento')
        , codEnquadramentoEdit = UrbemSonata.giveMeBackMyField('codEnquadramento')
        , motivoEncerramento = UrbemSonata.giveMeBackMyField('motivoEncerramento');
    modalLoad.setTitle('Carregando...');

    var classsificacaoEnquadSelect = $("#" + UrbemSonata.uniqId + "_fkPessoalClassificacaoEnquadramento");
    var selectTarget = $("#" + UrbemSonata.uniqId + "_fkPessoalClassificacaoEnquadramento");
    var codClassificacao = $("#" + UrbemSonata.uniqId + "_codClassificacao");

    var codEnquadramento = selectTarget.val();

    $('form').submit(function() {
        $('.sonata-ba-field-error-messages').remove();

        var error = false;
        var dtRequirimentoTime = toDate(dtRequirimento.val());
        var dtConcessaoTime = toDate(dtConcessao.val());
        var dtPublicacaoTime = toDate(dtPublicacao.val());

        if (!motivoEncerramento.attr("disabled")) {
            if ( (motivoEncerramento.val() != '' && dtEncerramento.val() == '') || (dtEncerramento.val() != '' && motivoEncerramento.val() == '')) {
                error = true;
                motivoEncerramento.parent().parent().append('<div class="help-block sonata-ba-field-error-messages" style="position: relative;"> <ul class="list-unstyled"> <li><i class="fa fa-exclamation-circle"></i> Campo motivo do encerramento e data de encerramento devem estar preenchidos ou vazios.</li> </ul> </div>');
            }

            if (dtEncerramento.val() != '') {
                var dtEncerramentoTime = toDate(dtEncerramento.val());
                if (dtEncerramentoTime < dtPublicacaoTime || dtEncerramentoTime < dtConcessaoTime || dtEncerramentoTime < dtRequirimentoTime) {
                    error = true;
                    dtEncerramento.parent().parent().append('<div class="help-block sonata-ba-field-error-messages" style="position: relative;"> <ul class="list-unstyled"> <li><i class="fa fa-exclamation-circle"></i> Campo data do encerramento não pode ser anterior as datas de Concessão, Requerimento e Publicação.</li> </ul> </div>');
                }
            }
        }
        if (dtRequirimentoTime > dtConcessaoTime) {
            error = true;
            dtConcessao.parent().parent().append('<div class="help-block sonata-ba-field-error-messages" style="position: relative;"> <ul class="list-unstyled"> <li><i class="fa fa-exclamation-circle"></i> A data deve ser maior que a data de requerimento da aposentadoria.</li> </ul> </div>');
        }

        if (dtConcessaoTime > dtPublicacaoTime) {
            error = true;
            dtPublicacao.parent().parent().append('<div class="help-block sonata-ba-field-error-messages" style="position: relative;"> <ul class="list-unstyled"> <li><i class="fa fa-exclamation-circle"></i> A data deve ser maior que a data de Concessão do Benefício.</li> </ul> </div>');
        }
        if (error) {
            return false;
        }

    });

    function toDate(dateStr) {
        var parts = dateStr.split("/");
        return new Date(parts[2], parts[1] - 1, parts[0]).getTime();
    }

    function carregaEnquadramento(codClassificacao) {
        if (!codClassificacao) {
            return;
        }
        $.ajax({
            url: '/recursos-humanos/pessoal/aposentadoria/consultar-enquadramento?codEnquadramento=' + codClassificacao,
            method: 'GET',
            data: {
                classificacao: $("#" + UrbemSonata.uniqId + "_codClassificacao").val()
            },
            dataType: 'json',
            success: function (data) {
                classsificacaoEnquadSelect.removeAttr("disabled");
                classsificacaoEnquadSelect.empty();
                classsificacaoEnquadSelect.append('<option value="" selected="selected">Selecione</option>');
                classsificacaoEnquadSelect.select2("val", '');
                fieldReajuste.val('');
                $.each(data, function (index, item) {
                    classsificacaoEnquadSelect.append(
                        '<option value=' + item['cod_enquadramento'] + '>' + item['descricao'] + ' - ' + item['reajuste'] + '</option>');
                });
                if(codEnquadramentoEdit.val() != '') {
                  classsificacaoEnquadSelect.select2("val", codEnquadramentoEdit.val());
                  fieldEnquadramento.trigger('change');
                }
                modalLoad.close();
            }
        });
    }

    if (codClassificacao.val() != '') {
        carregaEnquadramento(codClassificacao.val());
    }

    $("#" + UrbemSonata.uniqId + "_codClassificacao").on('change', function () {

        if ($(this).val() == 0) {
            classsificacaoEnquadSelect.prop("disabled", true);
            return false;
        }
        modalLoad.setBody("Aguarde, pesquisando Enquadramentos");
        modalLoad.open();

        carregaEnquadramento($(this).val());

    });

    function fieldEnquadramentoOnChangeAction(e) {
        var modal = jQuery.urbemModal();
        var codValue = $(e).val();
        if (!codValue) {
            return;
        }
        if ((codValue != '') && (classsificacaoEnquadSelect.val() != '')) {
            jQuery.ajax({
                method: 'GET',
                url: urlEndPoint + codValue,
                dataType: 'json',
                beforeSend: function (xhr) {
                    modal
                        .disableBackdrop()
                        .setTitle('Aguarde...')
                        .setBody('Carregando reajuste.')
                        .open();
                },
                success: function (data) {
                    var valueReajuste = 'Não informado';
                    if (data.item.reajuste != null) {
                        valueReajuste = data.item.reajuste;
                    }
                    fieldReajuste.val(valueReajuste);
                    modal.close();
                }
            });
        } else {
            fieldReajuste.val("");
        }
    };

    fieldEnquadramento.on('change', function (e) {
        fieldEnquadramentoOnChangeAction($(this));
    });

}());
