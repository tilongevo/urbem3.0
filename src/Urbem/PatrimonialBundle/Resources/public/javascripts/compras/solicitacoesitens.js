(function ($, urbem, admin) {
  'use strict';

  var modal = $.urbemModal()
    , btnSalvar = $("[name='btn_create_and_list']");

  var fieldCodEntidade = urbem.giveMeBackMyField("codEntidade")
    , fieldCodSolicitacao = urbem.giveMeBackMyField("codSolicitacao")
    , fieldCodSolicitacaoPai = urbem.giveMeBackMyField("codSolicitacaoHidden")
    , fieldExercicio = urbem.giveMeBackMyField("exercicio")
    , fieldRegistroPrecoHidden = urbem.giveMeBackMyField("registroPrecoHidden");

  function checkErrors() {
    var hasError = $('.has-error').length > 0;

    if (hasError) {
      blockSaveButton();
    } else {
      unlockSaveButton();
    }
  }

  function blockSaveButton() {
    $('button[name="btn_update_and_list"]').attr('disabled', true);
  }

  function unlockSaveButton() {
    $('button[name="btn_update_and_list"]').attr('disabled', false);
  }

  /**
   * @param field
   */
  function setFieldError(field, message) {
    unsetFieldError(field);

    var fieldContainer = field.parents('.form_row.campo-sonata');

    var errorElement =
      $('<div class="help-block sonata-ba-field-error-messages"/>').append(
        $('<span class="close-help-block"/>').append(
          $('<i class="fa fa-times-circle"/>', {'aria-hidden': true})
        )
      ).append(
        $('<ul class="list-unstyled"/>').append(
          $('<li/>').append(
            $('<i class="fa fa-exclamation-circle"/>'),
            message
          )
        )
      );

    fieldContainer
      .addClass('has-error')
      .find('div.sonata-ba-field')
      .append(errorElement);
  }

  /**
   * @param field
   */
  function unsetFieldError(field) {
    var fieldContainer = field.parents('.has-error');

    if (fieldContainer.length > 0) {
      fieldContainer.removeClass('has-error');
      fieldContainer.find('.sonata-ba-field-error-messages').remove();
    }
  }

  /**
   * Busca e carrega as solicitaçoes efetuadas pela entidade selecionada e no exercicio informado.
   *
   * @param codEntidade
   */
  function carregaSolicitacoes(codEntidade) {
    if (codEntidade != "") {
      var exercicio = fieldExercicio.val()
        , codSolicitacaoPai = fieldCodSolicitacaoPai.val();

      $.ajax({
        url: "/patrimonial/compras/solicitacao/monta-recupera-relacionamento-solicitacao-itens",
        data: {
          'exercicio': exercicio,
          'codEntidade': codEntidade,
          'codSolicitacaoPai': codSolicitacaoPai
        },
        method: "GET",
        dataType: "json",
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Pesquisando as solicitações.')
            .open();
        },
        success: function (data) {
          fieldCodSolicitacao.select2('enable');
          urbem.populateSelect(fieldCodSolicitacao, data, {value: 'value', label: 'label'});

          modal.close();
        }
      });
    } else {
      fieldCodSolicitacao.select2('disable');
    }
  }

  /**
   * @param solicitacao
   */
  function carregaItensDaSolicitacao(solicitacao) {
    if (solicitacao != '') {
      $.ajax({
        url: '/patrimonial/compras/solicitacao/monta-recupera-item-solicitacao',
        data: {
          'solicitacao': solicitacao
        },
        method: "GET",
        dataType: "html",
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Pesquisando os itens.')
            .open();
        },
        success: function (data) {
          var content = $(data);

          if (content.length > 0) {
            $('.solicitacao-items .box-body').html(content);
            content.find('select.select2-parameters').select2().show();
          } else {
            blockSaveButton()
          }

          moneyMask();
          checkErrors();

          modal.close();
        }
      });
    }
  }

  /**
   * @param codDespesa
   * @param fieldIdentifier
   */
  function carregaSaldoDotacao(codDespesa, fieldIdentifier) {
    var fieldSaldoDotacao = $("input[name=saldoDotacao_" + fieldIdentifier + "]")
      , fieldVlTotal = $("input[name=vlTotal_" + fieldIdentifier + "]");

    if (codDespesa != '') {
      var solicitacao = fieldCodSolicitacao.val();

      $.ajax({
        url: '/patrimonial/compras/solicitacao/recupera-saldo-dotacao',
        data: {
          solicitacao: solicitacao,
          codDespesa: codDespesa
        },
        method: "GET",
        dataType: "json",
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Pesquisando Saldo Dotação.')
            .open();
        },
        success: function (data) {
          var reservaDeSaldo = data.saldo_anterior
            , valorTotalItem = parseFloat(fieldVlTotal.val().replaceAll('.', '').replaceAll(',', '.'));

          fieldSaldoDotacao.val(float2moeda(reservaDeSaldo));

          if (reservaDeSaldo > valorTotalItem) {
            unsetFieldError(fieldSaldoDotacao);
          } else {
            setFieldError(fieldSaldoDotacao, "&nbsp;Valor Total do Item é Superior ao Saldo da Dotação!");
          }

          checkErrors();

          modal.close();
        }
      });
    } else {
      fieldSaldoDotacao.val(0);
      if (fieldRegistroPrecoHidden.val() == 1) {
        unsetFieldError(fieldSaldoDotacao);
      }
    }
  }

  /**
   * @param codDespesa
   * @param fieldIdentifier
   */
  function carregaCodEstrutural(codDespesa, fieldIdentifier) {
    var fieldCodEstrutural = $("select[name=codEstrutural_" + fieldIdentifier + "]");

    if (codDespesa != '') {
      var solicitacao = fieldCodSolicitacao.val();

      $.ajax({
        url: '/patrimonial/compras/solicitacao/recupera-cod-estrutural',
        data: {
          exercicio:  $('select[name="_exercicio"]').val(),
          codDotacao: codDespesa
        },
        dataType: "json",
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Pesquisando as desdobramentos.')
            .open();
        },
        success: function (data) {
          fieldCodEstrutural.select2('enable');

          $.each(data, function( index, value ) {
            data[index] = {
              value: value.cod_conta + '-' + value.exercicio,
              label: value.cod_estrutural + ' - ' + value.descricao
            };
          });

          urbem.populateSelect(fieldCodEstrutural, data, {value: 'value', label: 'label'});

          modal.close();

          carregaSaldoDotacao(codDespesa, fieldIdentifier);
        }
      });
    } else {
      fieldCodEstrutural.val(0);
      carregaSaldoDotacao(codDespesa, fieldIdentifier);
    }
  }

  fieldExercicio.on("change", function () {
    fieldCodEntidade.val('').change();
    $('.solicitacao-items .box-body').html('');
  });

  fieldCodEntidade.on("change", function () {
    carregaSolicitacoes($(this).val());
  });

  fieldCodSolicitacao.on("change", function () {
    carregaItensDaSolicitacao($(this).val());
  });

  $(document).ready(function () {
    blockSaveButton();
  });

  $(document).on('change', "select[name^='codDespesa_']", function (e) {
    var fieldName = $(this).attr('name')
      , splitName = fieldName.split('_');

    carregaCodEstrutural($(this).val(), splitName[1]);
  });

})(jQuery, UrbemSonata, Admin);
