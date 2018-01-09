(function () {
  'use strict';

  var itemField = UrbemSonata.giveMeBackMyField('item')
    , marcaField = UrbemSonata.giveMeBackMyField('marca')
    , centroCustoField = UrbemSonata.giveMeBackMyField('centro_custo')
    , requisicaoField = UrbemSonata.giveMeBackMyField('requisicao')
    , quantidadeField = UrbemSonata.giveMeBackMyField('quantidade')
    , saldoField = UrbemSonata.giveMeBackMyField('saldo');

  itemField.on("change", function () {
    var codItem = jQuery(this).val()
      , codRequisicao = requisicaoField.val().split('~')
      , modal = jQuery.urbemModal()
      , urlEndPoint = '/patrimonial/almoxarifado/requisicao-item/search/marcas';

    urlEndPoint += '/' + codRequisicao[2];
    urlEndPoint += '/' + codItem;

    jQuery.ajax({
      method: 'GET',
      url: urlEndPoint,
      dataType: 'json',
      beforeSend: function (xhr) {
        modal
          .disableBackdrop()
          .setTitle('Aguarde...')
          .setBody('Buscando marcas disponiveis.')
          .open();
      },
      success: function (data) {
        UrbemSonata.populateSelect(marcaField, data, {
          value: "value",
          label: "label"
        });

        marcaField.attr('disabled', false);
        modal.close();
      }
    });

  });

  marcaField.on("change", function () {
    var codItem = itemField.val()
      , codMarca = jQuery(this).val()
      , codRequisicao = requisicaoField.val().split('~')
      , urlEndPoint = '/patrimonial/almoxarifado/requisicao-item/search/centros-custo';

    urlEndPoint += '/' + codRequisicao[2];
    urlEndPoint += '/' + codItem;
    urlEndPoint += '/' + codMarca;

    if ("" != codMarca) {
      var modal = jQuery.urbemModal();

      jQuery.ajax({
        method: 'GET',
        url: urlEndPoint,
        dataType: 'json',
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando Centros de Custo disponiveis.')
            .open();
        },
        success: function (data) {
          UrbemSonata.populateSelect(centroCustoField, data, {
            value: "value",
            label: "label"
          });

          centroCustoField.attr('disabled', false);
          modal.close();
        }
      });
    }
  });

  centroCustoField.on("change", function () {
    var codItem = itemField.val()
      , codMarca = marcaField.val()
      , codCentro = jQuery(this).val()
      , codRequisicao = requisicaoField.val().split('~');

    if ("" != codCentro) {
      var modal = jQuery.urbemModal()
        , urlEndPoint = '/patrimonial/almoxarifado/requisicao-item/search/saldo-estoque'
        , saldoFieldContainer = saldoField.parent();

      urlEndPoint += '/' + codRequisicao[2];
      urlEndPoint += '/' + codItem;
      urlEndPoint += '/' + codMarca;
      urlEndPoint += '/' + codCentro;

      jQuery.ajax({
        method: 'GET',
        url: urlEndPoint,
        dataType: 'json',
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando saldo em estoque.')
            .open();
        },
        success: function (data) {
          saldoField.val(data.saldo_estoque.replace('.', ','));
          quantidadeField.val('0,0000');

          modal.close();
        },
        error: function (xhr, textStatus, error) {
          var divScreenErrorMessage = "";

          if (!saldoFieldContainer.hasClass('sonata-ba-field-error')) {
            divScreenErrorMessage += '<div class="alert alert-danger alert-dismissable">';
            divScreenErrorMessage += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>&nbsp;';
            divScreenErrorMessage += xhr.responseText;
            divScreenErrorMessage += '</div>';

            jQuery('.sonata-ba-form').parent().prepend(divScreenErrorMessage);
          }

          modal.close();
        }
      });
    }
  });

  jQuery('button[name="btn_update_and_list"]').on('click', function (event) {
    var hasHomologacaoAutomaticaField = UrbemSonata.giveMeBackMyField('has_homologacao_automatica');

    if (true == hasHomologacaoAutomaticaField.val()) {
      event.preventDefault();

      var confirmationModal = jQuery.urbemConfirmationModal()
        , makeHomologacaoAutomaticaField = UrbemSonata.giveMeBackMyField('make_homologacao_automatica')

      confirmationModal
        .setTitle('Homologar Requisição')
        .setBody('As requisições estão configuradas para fazer homologação automatica, deseja homologar essa requisição?')
        .setProceedButtonLabel('Homologar')
        .setCancelButtonLabel('Cancelar')
        .open()
      ;

      confirmationModal
        .proceedAction(function () {
          makeHomologacaoAutomaticaField.val(1);

          jQuery('.sonata-ba-form form').submit();
        })
        .cancelAction(function () {
          makeHomologacaoAutomaticaField.val(0);

          jQuery('.sonata-ba-form form').submit();
        });
    }
  });
})();
