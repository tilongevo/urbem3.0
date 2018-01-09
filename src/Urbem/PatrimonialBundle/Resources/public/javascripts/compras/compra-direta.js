(function () {
  'use strict';

  var UrbemSearch = UrbemSonata.UrbemSearch,
    formAction = $('form').prop("action"),
    regexpCompraDireta = /(\/patrimonial\/compras\/compra-direta\/)/g,
    regexpHomologacaoCompraDireta = /(\/patrimonial\/compras\/homologacao-compra-direta\/)/g,
    regexpPublicacao = /(\/patrimonial\/compras\/compra-direta\/publicacoes)/g,
    regexpAnulacao = /(\/patrimonial\/compras\/compra-direta\/anulacao)/g,
    fieldfkOrcamentoEntidade = $('#' + UrbemSonata.uniqId + '_fkOrcamentoEntidade'),
    fieldCodObjeto = UrbemSonata.giveMeBackMyField("fkComprasObjeto");

  if (regexpCompraDireta.test(formAction)) {
    var fieldCodMapa = UrbemSonata.giveMeBackMyField("fkComprasMapa"),

      loadTable = function (codMapa) {
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando dados dos itens</h4>');
        $.get('/patrimonial/api/search/catalogo-items', {
          cod_mapa: fieldCodMapa.val(),
          mode: 'table'
        })
          .success(function (data) {
            $('.comprasdireta-items .box-body').html(data);
            fechaModal();
          });
      };

    fieldfkOrcamentoEntidade.on('change', function (e) {
      if ($(this).val() != '') {
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando data da solicitação</h4>');
        $.get('/patrimonial/compras/compra-direta/search/recupera-ultima-data-contabil/', {
          cod_entidade: $(this).val()
        })
          .success(function (data) {
            if (data) {

              $('#' + UrbemSonata.uniqId + '_dtCompraDireta').val(data.date);
              if (data.liberaData == false) {
                $("#" + UrbemSonata.uniqId + "_dtCompraDireta").prop('readonly', true);
              } else {
                $("#" + UrbemSonata.uniqId + "_dtCompraDireta").prop('readonly', false);
              }
              fechaModal();
            } else {
              $('#' + UrbemSonata.uniqId + '_dtCompraDireta').val("");
              fechaModal();
            }
          });
      } else {
        $('#' + UrbemSonata.uniqId + '_dtCompraDireta').val("");
      }
    });

    fieldCodMapa.on('change', function (e) {
      e.stopPropagation();

      var codMapa = $(this).val();
      loadTable(codMapa);

      $.get('/patrimonial/api/search/objeto', {
        cod_mapa: codMapa
      })
        .success(function (data) {
          if (data) {
            fieldCodObjeto.select2('val', data);
            fieldCodObjeto.select2('readonly', true);
          }
        });
    });

    if (fieldCodMapa.val()) {
      loadTable(fieldCodMapa.val());
      fieldCodMapa.select2('readonly', true);
    }
  }

  if (regexpPublicacao.test(formAction)) {
    var fieldCodCompraDireta = $('#' + UrbemSonata.uniqId + '_codCompraDireta');

    fieldCodCompraDireta.prop('readonly', true);
  }

  if (regexpAnulacao.test(formAction)) {
    $('.readonly').prop('readonly', true);

    $('.hidden-field').each(function () {
      var fieldId = $(this).prop('id'),
        containerPrefix = 'sonata-ba-field-container-';

      $('#' + containerPrefix + fieldId).css({'display': 'none'});
    });
  }

  if (regexpHomologacaoCompraDireta.test(formAction)) {

    var fieldCodEntidade = $('#' + UrbemSonata.uniqId + '_hcodEntidade'),
      fieldCodModalidade = $('#' + UrbemSonata.uniqId + '_hcodModalidade'),
      fieldExercicio = $('#' + UrbemSonata.uniqId + '_hexercicio'),
      fieldCodCompraDireta = $('#' + UrbemSonata.uniqId + '_hcodCompraDireta'),
      loadTable = function (exercicio, codEntidade, codModalidade, codCompraDireta) {
        $.get('/patrimonial/api/search/homologacao-compra-direta', {
          cod_entidade: fieldCodEntidade.val(),
          cod_modalidade: fieldCodModalidade.val(),
          exercicio: fieldExercicio.val(),
          cod_compra_direta: fieldCodCompraDireta.val(),
          mode: 'table'
        })
          .success(function (data) {
            $('.comprasdireta-items .box-body').html(data);
          });
      };

    if (fieldExercicio.val(), fieldCodEntidade.val(), fieldCodModalidade.val(), fieldCodCompraDireta.val()) {
      loadTable(fieldExercicio.val(), fieldCodEntidade.val(), fieldCodModalidade.val(), fieldCodCompraDireta.val());
    }
  }

}());
