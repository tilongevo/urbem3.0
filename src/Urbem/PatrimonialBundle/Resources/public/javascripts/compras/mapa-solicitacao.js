(function ($, urbem, w) {
  'use strict';

  var modal = $.urbemModal();

  var fieldCodMapa = urbem.giveMeBackMyField("codMapa")
    , fieldCodEntidade = urbem.giveMeBackMyField("codEntidade")
    , fieldRegistroPrecos = urbem.giveMeBackMyField("registroPreco")
    , fieldExercicioSolicitacao = urbem.giveMeBackMyField("exercicioSolicitacao")
    , fieldFkComprasSolicitacaoHomologada = urbem.giveMeBackMyField("fkComprasSolicitacaoHomologada");

  function carregaSolicitacoes(codEntidade) {
    if (codEntidade != '') {
      $.ajax({
        url: "/patrimonial/compras/mapa-solicitacao/get-solicitacoes-mapa-compra",
        data: {
          codEntidade: codEntidade,
          exercicio: fieldExercicioSolicitacao.val(),
          preco: fieldRegistroPrecos.find('input[type="radio"]:checked').val()
        },
        method: "GET",
        dataType: "json",
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Pesquisando Solicitações.')
            .open();
        },
        success: function (data) {
          urbem.populateSelect(fieldFkComprasSolicitacaoHomologada, data, {value: 'value', label: 'label'});

          modal.close();
        }
      });
    } else {
      urbem.populateSelect(fieldFkComprasSolicitacaoHomologada, [], {value: 'value', label: 'label'});
    }
  }

  function carregarItensSolicitacao(codSolicitacao) {
    var tableBody = $("table#box-itens").find('tbody');

    if (codSolicitacao != '') {
      $.ajax({
        url: "/patrimonial/compras/mapa-solicitacao/get-item-solicitacao-mapa-compra",
        data: {
          codSolicitacao: codSolicitacao,
          codEntidade: fieldCodEntidade.val(),
          exercicio: fieldExercicioSolicitacao.val(),
          codMapa: fieldCodMapa.val()
        },
        method: "GET",
        dataType: "json",
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando itens dessa solicitação.')
            .open();
        },
        success: function (data) {
          tableBody.empty();

          $.each(data, function (index, item) {
            var tr = $('<tr/>');

            tr.append($('<td/>').text(index + 1))
              .append($('<td/>').text(item.cod_solicitacao))
              .append($('<td/>').text(item.cod_item + ' - ' + item.nom_item))
              .append($('<td class="text-right"/>').text(item.quantidade_solicitada).mask('#.##0,0000', { reverse: true }))
              .append($('<td class="text-right"/>').text(item.quantidade_mapa).mask('#.##0,0000', { reverse: true }))
              .append($('<td class="text-right"/>').text('R$ ' + float2moeda(item.valor_unitario)))
              .append($('<td style="text-align: right !important;"/>').text('R$ ' + float2moeda(item.valor_total_mapa)))
            ;

            tableBody.html(tr);
          });

          modal.close();
        }
      });
    } else {
      tableBody.html(
        $('<tr/>').html(
          $('<td colspan="7"/>').text('Nenhuma solicitação selecionada')
        )
      );
    }
  }

  $(document).ready(function () {
    fieldFkComprasSolicitacaoHomologada.select2(fieldCodEntidade.val() != '' ? 'enable' : 'disable' );

    if (fieldCodEntidade.val() != '') {
      carregaSolicitacoes(fieldCodEntidade.val());
    }
  });

  fieldCodEntidade.on('change', function () {
    carregaSolicitacoes($(this).val());
  });

  fieldFkComprasSolicitacaoHomologada.on('change', function () {
    var field = $(this);

    if (field.find('option').length > 1) {
      field.select2('enable');

      carregarItensSolicitacao($(this).val());

    } else {
      field.select2('disable');

      var modalSolicitacoes = $.urbemModal()
        .setTitle('Sem solicitações')
        .setBody('Não há Solicitaçao de Compras para esta entidade.')
        .open();

      w.setTimeout(function () {
        modalSolicitacoes.close();
      }, 10000);
    }
  });

  fieldRegistroPrecos.on('ifChecked', function () {
    carregaSolicitacoes(fieldCodEntidade.val());
  });

})(jQuery, UrbemSonata, window);
