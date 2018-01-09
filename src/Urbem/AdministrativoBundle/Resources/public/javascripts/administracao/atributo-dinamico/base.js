/*global jQuery, window*/
(function ($) {
  'use strict';

  $.attrDinamicoAjaxReqHelper = function () {
    return new AtributoDinamicoAjaxRequestsHelper();
  };

})(jQuery);

function AtributoDinamicoAjaxRequestsHelper() {

  var modal = $.urbemModal();

  /**
   * @param xhr
   * @param textStatus
   * @param error
   */
  var errorAjaxRequest =  function (xhr, textStatus, error) {
    modal.close();

    modal
      .disableBackdrop()
      .setTitle(error)
      .setBody('Contate o administrador do Sistema.')
      .open();

    window.setTimeout(function () {
      modal.close();
    }, 5000);
  };

  /**
   * @param codGestao
   * @param successCallback
   */
  this.moduloRequest = function (codGestao, successCallback) {
    $.ajax({
      url: '/administrativo/administracao/atributo/consultar-modulo/{id}'.replace('{id}', codGestao),
      method: 'GET',
      dataType: 'json',
      beforeSend: function (xhr) {
        modal
          .disableBackdrop()
          .setTitle('Aguarde...')
          .setBody('Buscando modulos.')
          .open();
      },
      error: errorAjaxRequest,
      success: successCallback
    });
  };

  /**
   * @param codModulo
   * @param successCallback
   */
  this.cadastroRequest = function (codModulo, successCallback) {
    $.ajax({
      url: '/administrativo/administracao/atributo/consultar-cadastro/{id}'.replace('{id}', codModulo),
      method: 'GET',
      dataType: 'json',
      beforeSend: function (xhr) {
        modal
          .disableBackdrop()
          .setTitle('Aguarde...')
          .setBody('Buscando cadastros.')
          .open();
      },
      error: errorAjaxRequest,
      success: successCallback
    });
  };

  /**
   * @return UrbemModal
   */
  this.getModal = function () {
    return modal;
  }
}
