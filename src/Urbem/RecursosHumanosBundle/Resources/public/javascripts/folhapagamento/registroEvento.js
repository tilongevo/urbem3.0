(function () {
  'use strict';

  var fkFolhapagamentoEventoField = UrbemSonata.giveMeBackMyField('fkFolhapagamentoEvento'),
    fkFolhapagamentoEventoFieldId = fkFolhapagamentoEventoField.prop('id'),
    fkFolhapagamentoEventoFieldContainer = fkFolhapagamentoEventoField.parent(),
    codCargoField = UrbemSonata.giveMeBackMyField('codCargo'),
    codSubDivisaoField = UrbemSonata.giveMeBackMyField('codSubDivisao'),
    codEspecialidadeField = UrbemSonata.giveMeBackMyField('codEspecialidade'),
    valorField = UrbemSonata.giveMeBackMyField('valor'),
    parcelaField = UrbemSonata.giveMeBackMyField('parcela'),
    qtdeParcelaField = UrbemSonata.giveMeBackMyField('qtdeParcela'),
    mesCarenciaField = UrbemSonata.giveMeBackMyField('mesCarencia'),
    previsaoField = UrbemSonata.giveMeBackMyField('previsao'),
    quantidadeField = UrbemSonata.giveMeBackMyField('quantidade'),
    tipoField = UrbemSonata.giveMeBackMyField('tipo'),
    codContratoField = UrbemSonata.giveMeBackMyField('codContrato'),
    submit = false
  ;

  if(fkFolhapagamentoEventoField.val() != '') {
    fkFolhapagamentoEventoField.prop('readonly', 'readonly');
    carregaTextoComplementar();
  }

  function carregaTextoComplementar() {
    abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, carregando texto Complementar</h4>');
    $.ajax({
      url: "/recursos-humanos/folha-pagamento/evento/carrega-texto-complementar",
      method: "POST",
      dataType: "json",
      data: {
        codEvento: fkFolhapagamentoEventoField.val()
      },
      success: function (data) {
        $("#" + UrbemSonata.uniqId + "_textoComplementar").val(data.observacao);

        if (data.apresentaParcela == 'true') {
          valorField.prop('readonly', false);
          parcelaField.prop('readonly', false);
          qtdeParcelaField.prop('readonly', false);
          mesCarenciaField.prop('readonly', false);
          previsaoField.prop('readonly', false);
          quantidadeField.prop('readonly', true);
        } else {
          valorField.prop('readonly', true);
          parcelaField.prop('readonly', true);
          qtdeParcelaField.prop('readonly', true);
          mesCarenciaField.prop('readonly', true);
          previsaoField.prop('readonly', true);
          quantidadeField.prop('readonly', false);
        }

        if ((tipoField.val() == 'V') || (tipoField.val() == 'P')) {
          valorField.prop('readonly', false);
          quantidadeField.prop('readonly', false);
        }
        fechaModal();
      }
    });
  }

  function valida() {
    var mensagem;
    $.ajax({
      url: "/recursos-humanos/pessoal/adidos-cedidos/consultar-adido-cedido",
      method: "POST",
      dataType: "json",
      data: {
        codContrato: codContratoField.val()
      },
      success: function (data) {
        mensagem = data.mensagem;

        jQuery('.sonata-ba-field-error-messages').remove();
        jQuery('.sonata-ba-form').parent().find('.alert.alert-danger.alert-dismissable').remove();

        if (mensagem != '') {
          event.preventDefault();

          $(".sonata-ba-field-error-messages").remove();
          UrbemSonata.setFieldErrorMessage(
            fkFolhapagamentoEventoFieldId,
            mensagem,
            fkFolhapagamentoEventoFieldContainer
          );
          jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' + mensagem + ' </div>');
          jQuery('button[name="btn_create_and_list"]').addClass('disabled ');
        } else {
          jQuery('button[name="btn_create_and_list"]').removeClass('disabled');
          submit = true;
        }
      }
    });
  }

  jQuery('button[name="btn_create_and_list"]').on("click", function (event) {
    return submit;
  });

  $("#" + UrbemSonata.uniqId + "_fkFolhapagamentoEvento").on("change", function () {
    carregaTextoComplementar();
    valida();
  });

}());
