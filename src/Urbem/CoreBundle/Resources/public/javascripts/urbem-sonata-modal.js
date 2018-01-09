(function ($) {
  $.loadingUrbemModal = function (title, body) {
    var loadingModal = new UrbemModal(title, body);
    loadingModal.disableBackdrop();
    return loadingModal.open();
  }

  $.urbemModal = function (title, body) {
    return new UrbemModal(title, body);
  };
})(jQuery);

function UrbemModal(title, body) {

  var options = {
    dismissible: true,
    opacity: .5,
    starting_top: '1%'
  };

  var sizeOptions = {
    'small': 'modal-sm',
    'large': 'modal-lg'
  };

  var modalIdPrefix = 'main-container-';
  var documentIdPrefix = 'container-document-';
  var contentIdPrefix = 'modal-content-';
  var headerIdPrefix = 'modal-content-header-';
  var divBtnCloseIdPrefix = 'modal-close-';
  var btnCloseIdPrefix = 'modal-btn-close-';
  var headerTitleDivIdPrefix = 'modal-header-title-';
  var modalBodyIdPrefix = 'modal-body-';
  var modalFooterIdPrefix = 'modal-footer-';

  var mainContainer = null;
  var documentContainer = null;
  var contentContainer = null;
  var headerContainer = null;
  var divBtnClose = null;
  var titleDiv = null;
  var modalBody = null;
  var modalFooter = null;
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
  var defaultSize = '';

  this.UrbemModal = function (title, body) {
    if (undefined != title) {
      this.setTitle(title);
    }
    if (undefined != body) {
      this.setBody(body);
    }
  };

  this.enableBackdrop = function() {
    this.showCloseButton();
    options.backdrop = true;
    options.keyboard = true;

    return this;
  };

  this.disableBackdrop = function() {
    this.hideCloseButton();
    options.backdrop = 'static';
    options.keyboard = false;

    return this;
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

  /**
   * Set modal's footer (or action bar)
   * It accept html
   *
   * @param footer
   */
  this.setFooter = function (footer) {
    footerContent = footer;
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

    $(documentContainer).addClass(defaultSize);

    // Listeners
    $(divBtnClose).on('click', function (event) {
      event.preventDefault();
      var div = $(this).parent().parent().parent().parent().attr('id');
      $('#' + div).modal('hide');
    });

    var optionsMerged = _.merge(openOptions, options);

    $(mainContainer).modal(optionsMerged);

    // Esperar até que a animação termine de rodar para remover a layer excedente
    window.setTimeout(function () {
      $(".modal-backdrop").remove();
    }, 160);

    return this;
  };

  /**
   * Close modal
   *
   * @returns {UrbemModal}
   */
  this.close = function () {
    $(mainContainer).modal('hide');
    return this;
  };

  this.remove = function () {
      $('body').removeClass('modal-open');
      $(mainContainer).remove();
      return this;
  };

  var usModalContainer = $('<div/>', {
    id: 'us-modal-container'
  }).appendTo($('body'));

  // Creating html
  var createContainers = function () {
    internalId = uuid();
    mainContainer = $('<div/>', {
      'class': 'modal fade bs-example-modal-lg',
      'tabindex': '-1',
      'role': 'dialog',
      'id': modalIdPrefix + internalId
    }).appendTo(usModalContainer);

    documentContainer = $('<div/>', {
      'class': 'modal-dialog ',
      'role': 'document',
      'id': documentIdPrefix + internalId
    }).appendTo(mainContainer);

    contentContainer = $('<div/>', {
      'class': 'modal-content',
      'id': contentIdPrefix + internalId
    }).appendTo(documentContainer);

    headerContainer = $('<div/>', {
      'class': 'modal-header',
      'id': headerIdPrefix + internalId
    }).appendTo(contentContainer);


    /******** Botao fechar no header ******/
    if (isCloseButtonVisible()) {
      divBtnClose = $('<div/>', {
        'class': 'urbem-modal-close',
        'id': divBtnCloseIdPrefix + internalId
      }).appendTo(headerContainer);
    }

    var btnClose = $('<button/>', {
      'class': 'close',
      'type': 'button',
      'id': btnCloseIdPrefix + internalId
    }).attr('data-dismiss', 'modal').attr('aria-label', 'Close').appendTo(divBtnClose);

    var spanClose = $('<span/>').attr('aria-hidden', 'true').html('&times;').appendTo(btnClose);
    /******** Fim do botao fechar no header ******/

    titleDiv = $('<h4/>', {
      'class': 'modal-title urbem-modal-header-title',
      'id': headerTitleDivIdPrefix + internalId
    }).appendTo(headerContainer);
    $(titleDiv).html(titleContent);

    // Body
    modalBody = $('<div/>', {
      'class': 'modal-body urbem-modal-body',
      'id': modalBodyIdPrefix + internalId,
      'style': 'width: 100%'
    }).appendTo(contentContainer);
    $(modalBody).html(bodyContent);

    // Footer
    modalFooter = $('<div/>', {
      'class': 'modal-footer urbem-sonata-modal-action-bar',
      'style': 'background-color: #fefefe',
      'id': modalFooterIdPrefix + internalId
    }).appendTo(contentContainer);
    $(modalFooter).html(footerContent);
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
}
