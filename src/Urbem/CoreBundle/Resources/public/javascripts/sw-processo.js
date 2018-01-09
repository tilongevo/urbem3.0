(function (urbem, $) {
  'use strict';
  var regexpClassificacaoEdit = /edit/,
    locationHref = document.location.href;

  var fieldCodAssunto = urbem.giveMeBackMyField('codAssunto')
    , fieldCodProcesso = urbem.giveMeBackMyField('codProcesso')
    , fieldCodClassificacao = urbem.giveMeBackMyField("codClassificacao");

  fieldCodAssunto.prop("readonly", true);
  fieldCodProcesso.prop("readonly", true);

  if (urbem.checkModule('compra-direta') && regexpClassificacaoEdit.test(locationHref)) {
    fieldCodAssunto.prop("readonly", false);
    fieldCodProcesso.prop("readonly", false);
  }

  if (urbem.checkModule('lote') && regexpClassificacaoEdit.test(locationHref) && fieldCodProcesso != "") {
      fieldCodAssunto.prop("readonly", false);
      fieldCodProcesso.prop("readonly", false);
  }

  if (urbem.checkModule('baixa-manual') && regexpClassificacaoEdit.test(locationHref) && fieldCodProcesso != "") {
      fieldCodAssunto.prop("readonly", false);
      fieldCodProcesso.prop("readonly", false);
  }

  function carregaAssunto(codClassificacao) {
    if (codClassificacao != "") {
      abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando assuntos</h4>');
      $.ajax({
        url: "/api-search-processo/find-assuntos-by-classificacao/?codClassificacao=" + codClassificacao,
        method: "GET",
        dataType: "json",
        success: function (data) {
          fieldCodAssunto.prop("readonly", false);
          fieldCodAssunto.prop("required", true);

          urbem.populateSelect(fieldCodAssunto, data, {
            value: 'codAssunto',
            label: 'nomAssunto'
          });

          fechaModal();
        }
      });
    } else {
      fieldCodAssunto.prop("readonly", true);
      fieldCodProcesso.prop("readonly", true);
    }
  }

  function carregaProcesso(codAssunto, codClassificacao) {
    if (codAssunto != "") {
      abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando processos</h4>');
      $.ajax({
        url: "/api-search-processo-classificacao/find-processo-by-assuntos-and-classificacao/?codAssunto=" + codAssunto + "&codClassificacao=" + codClassificacao,
        method: "GET",
        dataType: "json",
        success: function (data) {
          fieldCodProcesso.prop("readonly", false);
          fieldCodProcesso.prop("required", true);

          urbem.populateSelect(fieldCodProcesso, data, {
            value: 'codProcesso',
            label: 'nomProcesso'
          });

          fechaModal();
        }
      });
    } else {
      fieldCodProcesso.prop("readonly", true);
    }
  }


  fieldCodClassificacao.on("change", function (e) {
    var codClassificacao = $(this).val();

    clearSelectOptions(fieldCodAssunto);
    clearSelectOptions(fieldCodProcesso);
    carregaAssunto(codClassificacao);
  });


  fieldCodAssunto.on("change", function (e) {

    var codAssunto = $(this).val()
      , codClassificacao = fieldCodClassificacao.val();

    clearSelectOptions(fieldCodProcesso);
    carregaProcesso(codAssunto, codClassificacao);
  });

  function clearSelectOptions(field) {
      var option = $('<option>', {value: '', text: 'Selecione'});
      field.empty();
      field.append(option);
      field.select2('val', '');
      field.attr("readonly", true);
  }

}(UrbemSonata, jQuery));
