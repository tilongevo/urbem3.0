
(function ($) {
  $.urbemConfirmationModal = function (title, body) {
    return new UrbemConfirmationModal();
  };
})(jQuery);

function UrbemConfirmationModal(title, body) {

  var options = {
    backdrop: 'static',
    dismissible: true,
    keyboard: false,
    opacity: .5,
    starting_top: '1%'
  };

  var sizeOptions = {
    'small': 'modal-sm',
    'large': 'modal-lg'
  };

  var confirmationOptions = {
    proceedLabel: 'Ok',
    cancelLabel: 'Cancelar'
  };

  var modalIdPrefix = 'main-container-'
    , documentIdPrefix = 'container-document-'
    , contentIdPrefix = 'modal-content-'
    , headerIdPrefix = 'modal-content-header-'
    , divBtnCloseIdPrefix = 'modal-close-'
    , btnCloseIdPrefix = 'modal-btn-close-'
    , headerTitleDivIdPrefix = 'modal-header-title-'
    , modalBodyIdPrefix = 'modal-body-'
    , modalFooterIdPrefix = 'modal-footer-'
    , modalProceedIdPrefix = 'modal-confirmation-proceed-'
    , modalCancelIdPrefix = 'modal-confirmation-cancel-';

  var mainContainer = null
    , documentContainer = null
    , contentContainer = null
    , headerContainer = null
    , divBtnClose = null
    , titleDiv = null
    , modalBody = null
    , modalFooter = null
    , groupContainerProceedButton = null
    , groupContainerCancelButton = null
    , groupContainerButton = null
    , proceedButton = null
    , cancelButton = null;

  /**
   * Visibility of the close button
   * @type {boolean}
   */
  var closeButtonVisibility = true;

  var internalId = 0;

  // Content variables
  var titleContent = '';
  var bodyContent = '';
  var footerContent = '';
  var defaultSize = 'modal-lg';

  this.UrbemModal = function (title, body) {
    if (undefined != title) {
      this.setTitle(title);
    }
    if (undefined != body) {
      this.setBody(body);
    }
  };

  /**
   * Show close button on modal
   *
   * @returns {UrbemModal}
   */
  this.showCloseButton = function () {
    closeButtonVisibility = true;
    return this;
  };

  /**
   * Hide close button from modal
   *
   * @returns {UrbemModal}
   */
  this.hideCloseButton = function () {
    closeButtonVisibility = false;
    return this;
  };

  /**
   * (internal function)
   * Verify if the close button is hidden
   *
   * @returns {boolean}
   */
  var isCloseButtonVisible = function () {
    return closeButtonVisibility;
  };

  /**
   * Set modal's title
   * It accept html
   *
   * @param title string
   * @returns {UrbemModal}
   */
  this.setTitle = function (title) {
    titleContent = title;
    return this;
  };

  /**
   * Set modal's body
   * It accept html
   *
   * @param body string
   * @returns {UrbemModal}
   */
  this.setBody = function (body) {
    bodyContent = body;
    return this;
  };

  /**
   * Alias para this.setBody();
   *
   * @param content
   */
  this.setContent = function (content) {
    this.setBody(content);
    return this;
  };

  this.setProceedButtonLabel = function (label) {
    confirmationOptions.proceedLabel = label;
    return this;
  };

  this.setCancelButtonLabel = function (label) {
    confirmationOptions.cancelLabel = label;
    return this;
  };

  this.proceedAction = function(callback) {
    proceedButton.click(callback);
    return this;
  };

  this.cancelAction = function(callback) {
    cancelButton.click(callback);
    return this;
  };

  /**
   * Open the modal
   *
   * @param openOptions
   * @returns {UrbemModal}
   */
  this.open = function (openOptions) {
    createContainers();

    if (_.has(openOptions, 'size')) {
      if (openOptions.size in sizeOptions) {
        defaultSize = sizeOptions[openOptions.size];
      }
    }

    jQuery(documentContainer).addClass(defaultSize);

    // Listeners
    jQuery(divBtnClose).on('click', function (event) {
      event.preventDefault();
      var div = jQuery(this).parent().parent().parent().parent().attr('id');
      jQuery('#' + div).modal('hide');
    });

    var optionsMerged = _.merge(openOptions, options);

    jQuery(mainContainer).modal(optionsMerged);

    // Esperar até que a animação termine de rodar para remover a layer excedente
    window.setTimeout(function () {
      jQuery(".modal-backdrop").remove();
    }, 160);

    return this;
  };

  /**
   * Close modal
   *
   * @returns {UrbemModal}
   */
  this.close = function () {
    jQuery(mainContainer).modal('hide');
    return this;
  };

  this.remove = function() {
      jQuery(mainContainer).remove();
      return this;
  };

  var usModalContainer = jQuery('<div/>', {
    id: 'us-modal-container'
  }).appendTo(jQuery('body'));

  // Creating html
  var createContainers = function () {
    internalId = uuid();
    mainContainer = jQuery('<div/>', {
      'class': 'modal fade bs-example-modal-lg',
      'tabindex': '-1',
      'role': 'dialog',
      'id': modalIdPrefix + internalId
    }).appendTo(usModalContainer);

    documentContainer = jQuery('<div/>', {
      'class': 'modal-dialog ',
      'role': 'document',
      'id': documentIdPrefix + internalId
    }).appendTo(mainContainer);

    contentContainer = jQuery('<div/>', {
      'class': 'modal-content',
      'id': contentIdPrefix + internalId
    }).appendTo(documentContainer);

    headerContainer = jQuery('<div/>', {
      'class': 'modal-header',
      'id': headerIdPrefix + internalId
    }).appendTo(contentContainer);

    titleDiv = jQuery('<h4/>', {
      'class': 'modal-title urbem-modal-header-title',
      'id': headerTitleDivIdPrefix + internalId
    }).appendTo(headerContainer);
    jQuery(titleDiv).html(titleContent);

    // Body
    modalBody = jQuery('<div/>', {
      'class': 'modal-body urbem-modal-body',
      'id': modalBodyIdPrefix + internalId,
      'style': 'width: 100%'
    }).appendTo(contentContainer);
    jQuery(modalBody).html(bodyContent);

    // Div group buttons
    groupContainerButton = jQuery('<div/>', {
      'class': '',
      'role': 'group'
    });

    /******** Botao proceder ******/
    groupContainerProceedButton = jQuery('<div/>', {
      'class': 'btn-group left',
      'role': 'group'
    }).appendTo(groupContainerButton);

    proceedButton = jQuery('<button/>', {
      'class': 'btn btn-primary',
      'type': 'button',
      'id': modalProceedIdPrefix + 'confirmation-proceed-' + internalId
    })
      .text(confirmationOptions.proceedLabel)
      .appendTo(groupContainerProceedButton);

    /******** Botao cancelar ******/
    groupContainerCancelButton = jQuery('<div/>', {
      'class': 'btn-group',
      'role': 'group'
    }).appendTo(groupContainerButton);

    cancelButton = jQuery('<button/>', {
      'class': 'btn btn-danger',
      'type': 'button',
      'id': modalCancelIdPrefix + 'confirmation-proceed-' + internalId
    }).text(confirmationOptions.cancelLabel).appendTo(groupContainerCancelButton);

    // Footer
    modalFooter = jQuery('<div/>', {
      'class': 'modal-footer urbem-sonata-modal-action-bar',
      'style': 'background-color: #fefefe',
      'id': modalFooterIdPrefix + internalId
    }).appendTo(contentContainer);
    jQuery(modalFooter).html(footerContent);

    groupContainerButton.appendTo(modalFooter);
    jQuery(modalFooter).html(groupContainerButton);
  };

  this.getUuid = function () {
    return internalId;
  };

  this.getModalId = function () {
    return modalIdPrefix + internalId;
  };

  var uuid = function () {
    function s4() {
      return Math.floor((1 + Math.random()) * 0x10000)
        .toString(16)
        .substring(1);
    }

    return s4() + s4() + '-' + s4() + s4();
  };

  return this.UrbemModal(title, body);
};
