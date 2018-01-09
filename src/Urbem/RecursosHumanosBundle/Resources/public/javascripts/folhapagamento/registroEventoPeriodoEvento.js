$(function () {
  "use strict";

  window.varJsCodPeriodoMovimentacao = jQuery("#" + UrbemSonata.uniqId + "_codPeriodoMovimentacao").val();

  var modeloEventos = $('.row-modelo-eventos'),
    quotaTotal = 0,
    quotaPromitente = 0,
    fkFolhapagamentoEventoField = UrbemSonata.giveMeBackMyField('evento'),
    fkFolhapagamentoEventoFieldId = fkFolhapagamentoEventoField.prop('id'),
    fkFolhapagamentoEventoFieldContainer = fkFolhapagamentoEventoField.parent(),
    codCargoField = UrbemSonata.giveMeBackMyField('codCargo'),
    codSubDivisaoField = UrbemSonata.giveMeBackMyField('codSubDivisao'),
    codEspecialidadeField = UrbemSonata.giveMeBackMyField('codEspecialidade'),
    valorField = UrbemSonata.giveMeBackMyField('valor'),
    parcelaField = UrbemSonata.giveMeBackMyField('parcela'),
    qtdeParcelaField = UrbemSonata.giveMeBackMyField('qtdeParcela'),
    quantidadeField = UrbemSonata.giveMeBackMyField('quantidade'),
    propField = UrbemSonata.giveMeBackMyField('proporcional'),
    codContratoField = UrbemSonata.giveMeBackMyField('codContrato'),
    textoComplementarField = UrbemSonata.giveMeBackMyField('textoComplementar'),
    qtdeParcelaTotal = 0,
    quantidadeTotal = 0,
    valorTotal = 0,
    tipo = UrbemSonata.giveMeBackMyField('tipo'),
    submit = false;

  $("#manuais").on("click", function () {
    if ($('#evento-' + fkFolhapagamentoEventoField.val()).length >= 1) {
      mensagemErro(fkFolhapagamentoEventoFieldContainer, 'Evento já informado!');
      return false;
    }

    novaLinha();
  });

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
          quantidadeField.prop('readonly', true);
        } else {
          valorField.prop('readonly', true);
          parcelaField.prop('readonly', true);
          qtdeParcelaField.prop('readonly', true);
          quantidadeField.prop('readonly', false);
        }

        fechaModal();
      }
    });
  }

  $("#" + UrbemSonata.uniqId + "_evento").on("change", function () {
    carregaTextoComplementar();
  });


  function novaLinha() {
    $('.sonata-ba-field-error-messages').remove();
    var codigo = '';
    var nome = fkFolhapagamentoEventoField.select2('data').text;
    var propNome = '';

    if (nome.trim() == 'Selecione') {
      mensagemErro(fkFolhapagamentoEventoFieldContainer, 'Deve ser informado ao menos um evento!');
      return false;
    }

    if (nome != undefined) {
      nome = nome.split(' - ');
      codigo = nome[0];
      nome = nome[1];
    }

    if (propField.val() == 0) {
      propNome = 'Não';
    } else {
      propNome = 'Sim';
    }

    var campo = UrbemSonata.giveMeBackMyField(tipo.val());

    if((tipo.val() != 'geral') && (tipo.val() != 'cgm_contrato')) {
      campo = campo;
    } else if(tipo.val() == 'cgm_contrato') {
      campo = UrbemSonata.giveMeBackMyField('codContrato');
    }

    if((campo.val() == '') || (campo.val() == null)) {
      mensagemErro(campo, 'Deve ser informado ao menos um registro!');
      return false;
    }

    var row = modeloEventos.clone();
    row.removeClass('row-modelo-eventos');
    row.addClass('row-eventos');
    row.attr('id', 'evento-' + fkFolhapagamentoEventoField.val());
    row.find('.valor').html(valorField.val());
    row.find('.codigo').append(codigo);
    row.find('.parcela').html(parcelaField.val());
    row.find('.qtdeParcela').html(qtdeParcelaField.val());
    row.find('.quantidade').html(quantidadeField.val());
    row.find('.evento').html(nome);
    row.find('.prop').html(propNome);
    row.find('.imput-eventos').attr('value', fkFolhapagamentoEventoField.val());
    row.show();

    valorTotal += parseInt(valorField.val());
    qtdeParcelaTotal += parseInt(qtdeParcelaField.val());
    quantidadeTotal += parseInt(quantidadeField.val());

    $(".row-modelo-eventos-somatorio").find('.valor-soma').html(valorTotal);
    $(".row-modelo-eventos-somatorio").find('.quantidade-soma').html(quantidadeTotal);
    $(".row-modelo-eventos-somatorio").find('.quantidadeParcelas-soma').html(qtdeParcelaTotal);

    $('.empty-row-eventos').hide();
    $('#tableEventos').append(row);
    fkFolhapagamentoEventoField.select2('val', '');
    quantidadeField.val('0');
    textoComplementarField.val('');
  }



  $('form').submit(function () {
    if ($(".row-eventos").length <= 0) {
      mensagemErro(fkFolhapagamentoEventoFieldContainer, 'Deve ser informado ao menos um evento!');
      return false;
    }
    return true;
  });

  $(document).on('click', '.remove', function () {
    if ($(this).parent().hasClass('row-eventos')) {
      quotaTotal -= parseInt($(this).parent().find('.imput-evento-quota').attr('value'));
    } else {
      quotaPromitente -= parseInt($(this).parent().find('.imput-promitente-quota').attr('value'));
    }
    $(this).parent().remove();
    if ($(".row-eventos").length <= 0) {
      $('.empty-row-eventos').show();
    }
  });

  function mensagemErro(campo, memsagem) {
    var message = '<div class="help-block sonata-ba-field-error-messages">' +
      '<ul class="list-unstyled">' +
      '<li><i class="fa fa-exclamation-circle"></i> ' + memsagem + '</li>' +
      '</ul></div>';
    campo.after(message);
  }

}());
