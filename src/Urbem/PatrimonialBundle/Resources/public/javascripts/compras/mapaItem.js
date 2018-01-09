(function ($, urbem) {
  'use strict';

  var modal = $.urbemModal();

  var fieldQuantidade = urbem.giveMeBackMyField('quantidade')
    , fieldValorUnitario = urbem.giveMeBackMyField('valorUnitario')
    , fieldValorTotal = urbem.giveMeBackMyField('vlTotal')
    , fieldCodDespesa = urbem.giveMeBackMyField('codDespesa')
    , fieldCodEstrutural = urbem.giveMeBackMyField('codEstrutural')
    , fieldCodSolicitacao = urbem.giveMeBackMyField('codSolicitacao')
    , fieldSaldoDotacao = urbem.giveMeBackMyField('saldoDotacao');

  function formatQuantidade(quantidade) {
    quantidade = quantidade.replaceAll('.', '').replace(',', '.');

    return parseFloat(quantidade);
  }

  function formatMoney(valor) {
    valor = valor.replaceAll('.', '').replace(',', '.');

    return parseFloat(valor);
  }

  /**
   * @param quantidade
   * @param valorUnitario
   */
  function updateFieldValorTotal(quantidade, valorUnitario) {
    quantidade = formatQuantidade(quantidade);
    valorUnitario = formatMoney(valorUnitario);

    quantidade = isNaN(quantidade) ? 0 : quantidade;
    valorUnitario = isNaN(valorUnitario) ? 0 : valorUnitario;

    fieldValorTotal.val(float2moeda(quantidade * valorUnitario));
  }

  /**
   * @param quantidade
   * @param valorTotal
   */
  function updateFieldValorUnitario(quantidade, valorTotal) {
    quantidade = formatQuantidade(quantidade);
    valorTotal = formatMoney(valorTotal);

    quantidade = isNaN(quantidade) ? 0 : quantidade;
    valorTotal = isNaN(valorTotal) ? 0 : valorTotal;

    fieldValorUnitario.val(float2moeda(valorTotal / quantidade));
  }

  /**
   * @param codDespesa
   * @param fieldIdentifier
   */
  function carregaSaldoDotacao(codDespesa) {
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
            .setBody('Pesquisando Saldo da Dotação.')
            .open();
        },
        success: function (data) {
          var reservaDeSaldo = data.saldo_anterior;

          fieldSaldoDotacao.val(float2moeda(reservaDeSaldo));

          modal.close();
        }
      });
    } else {
      fieldSaldoDotacao.val(0);
    }
  }

  /**
   * @param codDespesa
   */
  function carregaCodEstrutural(codDespesa) {
    if (codDespesa != '') {
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
            .setBody('Pesquisando Desdobramentos.')
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

          carregaSaldoDotacao(codDespesa);
        }
      });
    } else {
      fieldCodEstrutural.val(0);
      carregaSaldoDotacao(codDespesa);
    }
  }

  $(document).ready(function () {

    if (fieldQuantidade !== undefined) {
      fieldQuantidade.on('input', function () {
        updateFieldValorTotal($(this).val(), fieldValorUnitario.val());
      });
    }

    fieldValorUnitario.on('input', function () {
      var quantidade = 0;

      if (fieldQuantidade !== undefined) {
        quantidade = fieldQuantidade.val();
      } else {
        quantidade = $('td#quantidade').text();
      }

      updateFieldValorTotal($.trim(quantidade), $(this).val());
    });

    fieldValorTotal.on('input', function () {
      var quantidade = 0;

      if (fieldQuantidade !== undefined) {
        quantidade = fieldQuantidade.val();
      } else {
        quantidade = $('td#quantidade').text();
      }

      updateFieldValorUnitario($.trim(quantidade), $(this).val());
    });

    if (fieldCodDespesa !== undefined) {
      carregaSaldoDotacao(fieldCodDespesa.val());

      fieldCodDespesa.on('change', function () {
        carregaCodEstrutural($(this).val());
      });
    }
  });

})(jQuery, UrbemSonata);

String.prototype.replaceAll = function(str1, str2, ignore) {
  return this.replace(new RegExp(str1.replace(/([\/\,\!\\\^\$\{\}\[\]\(\)\.\*\+\?\|\<\>\-\&])/g,"\\$&"),(ignore?"gi":"g")),(typeof(str2)=="string")?str2.replace(/\$/g,"$$$$"):str2);
};
