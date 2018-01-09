/*global jQuery, UrbemSonata*/
(function ($, urbem) {
  'use strict';

  var codTipo = null
    , displayedFiled = null
    , fkAdministracaoTipoAtributoFiled = urbem.giveMeBackMyField('fkAdministracaoTipoAtributo')
    , tipoAtributo = {
        numerico: 1,
        texto: 2,
        lista: 3,
        listaMultipla: 4,
        data: 5,
        numerico2: 6, // Decimal, ex.: 2,50, 2.50
        textoLongo: 7
      };

  /**
   * Recupera o container absoluto do field usando seu atributo `id`.
   **/
  function getFieldContainerByFieldId(fieldId) {
    var prefix = 'sonata-ba-field-container-';

    return $('#'.concat(prefix, fieldId));
  }

  /**
   * Esconde todos os fields que tem a classe `.init-hidden`,
   * exceto o que for enviado o atributo `id` do field.
   */
  function hideFieldsExcept(fieldId) {
    var elementId = null;

    $('.init-hidden').each(function () {
      elementId = $(this).attr('id');

      if (elementId !== fieldId || fieldId === undefined) {
        $(this).val('');
        getFieldContainerByFieldId(elementId).hide();
      }
    });
  }

  function showAndHideFieldsBasedChoosenTipo(codTipo) {
    /**
     * Define o campo que esta sendo exibido.
     */
    switch (codTipo) {
      case tipoAtributo.numerico:
        displayedFiled = urbem.giveMeBackMyField('valorPadraoNumero');
        break;
      case tipoAtributo.texto:
        displayedFiled = urbem.giveMeBackMyField('valorPadraoTexto');
        break;
      case tipoAtributo.data:
        displayedFiled = urbem.giveMeBackMyField('valorPadraoData');
        break;
      case tipoAtributo.numerico2:
        displayedFiled = urbem.giveMeBackMyField('valorPadraoDecimal');
        break;
      case tipoAtributo.textoLongo:
        displayedFiled = urbem.giveMeBackMyField('valorPadraoTextoLongo');
        break;
    }

    /**
     * Os tipos de atributo `lista` e `lista multipla` são collections do Sonata.
     * Por isso a ação de esconder deles estão focadas no `$formMapper->with()`.
     */
    if (codTipo !== tipoAtributo.lista && codTipo !== tipoAtributo.listaMultipla) {
      getFieldContainerByFieldId(displayedFiled.attr('id')).show();
      hideFieldsExcept(displayedFiled.attr('id'));
      $('.init-hidden--with').hide();
    } else {
      $('.init-hidden--with').show();
      hideFieldsExcept();
    }
  }

  codTipo = Number(fkAdministracaoTipoAtributoFiled.val());

  if (codTipo !== 0
      && codTipo !== undefined
      && codTipo !== "") {
    showAndHideFieldsBasedChoosenTipo(codTipo);
  }

  fkAdministracaoTipoAtributoFiled.on('change', function () {
    codTipo = Number($(this).val());
    showAndHideFieldsBasedChoosenTipo(codTipo);
  });

})(jQuery, UrbemSonata);
