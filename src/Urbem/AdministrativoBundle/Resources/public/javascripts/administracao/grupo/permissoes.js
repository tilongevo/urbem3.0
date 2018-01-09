(function ($, global) {
  'use strict';

  var modal = $.urbemModal()
    , routeContainerElement = null
    , codGrupo = $('#form_grupo').val()
    , fieldFormRoutes = $('#form_routes');

  function beforeSendAjaxHandler(xhr) {
    modal
      .disableBackdrop()
      .setTitle('Aguarde...')
      .setBody('Buscando rotas.')
      .open();
  }

  function errorAjaxHandler(xhr, textStatus, error) {
    modal.close();

    modal
      .disableBackdrop()
      .setTitle(error)
      .setBody('Contate o administrador do Sistema.')
      .open();

    global.setTimeout(function () {
      modal.close();
    }, 5000);
  }

  function updateAllStatus(selectedElement) {
    selectedElement
      .parent().parent().parent().parent()
      .find('.action--expand-route').each(function () {
      var unselectedElement = $(this);

      if (selectedElement.attr('data-route') != unselectedElement.attr('data-route')) {
        unselectedElement
          .find('i.fa')
          .removeClass('fa-arrow-right');
      } else {
        selectedElement
          .find('i.fa')
          .addClass('fa-arrow-right');
      }
    });
  }

  function adicionaNaColecao(codRota) {
    var rotas = JSON.parse(fieldFormRoutes.val());
    codRota = parseInt(codRota);

    rotas.push(codRota);

    fieldFormRoutes.val(JSON.stringify(rotas));
  }

  function removeDaColecao(codRota) {
    var rotas = JSON.parse(fieldFormRoutes.val());
    codRota = parseInt(codRota);

    rotas.slice(rotas.indexOf(codRota));

    fieldFormRoutes.val(JSON.stringify(rotas));
  }

  function foiSelecionado(codRota) {
    var rotas = JSON.parse(fieldFormRoutes.val());

    for (var i = 0; i < rotas.length; i++) {
      if (rotas[i] == codRota) {
        return true;
      }
    };


    return false;
  }

  function loadRoutes(parentRouteId, renderAt) {
    $.ajax({
      url: '/administrativo/administracao/grupo/api/rotas/{id}/children'.replace('{id}', parentRouteId),
      method: 'GET',
      dataType: 'html',
      data: {
        cod_grupo: codGrupo
      },
      beforeSend: beforeSendAjaxHandler,
      error: errorAjaxHandler,
      success: function (data) {
        var html = $(data);

        renderAt.html(data);

        renderAt.find('input[type="checkbox"]').each(function () {
          var element = $(this)
            , codRota = $(this).val();

          if (foiSelecionado(codRota)) {
            element.prop('checked', true);
          }

          if (renderAt.closest('tr').prev().find('input[type="checkbox"][parent-route]').is(':checked')) {
            element.prop('checked', true);
          }
        });

        modal.close();
      }
    });
  }

  $(document).on('click', '.action--expand-route', function (event) {
    var selectedElement = $(this);

    routeContainerElement = $('#' + $(this).attr('data-render-result-in'));
    loadRoutes(selectedElement.attr('data-route'), routeContainerElement)

    event.stopPropagation();
  });

  $(document).on('show.bs.collapse', 'div[id^="accordion-local-"]', function (e) {
    loadRoutes($(this).attr('data-route'), $(this));
    e.stopPropagation();
  });

  $(document).on('change', 'input[type="checkbox"]', function () {
    var codRota = $(this).val()
      , containerSubRotas = $(document).find('div[data-route="'+ codRota +'"]');;

    if ($(this).is(':checked')) {
      adicionaNaColecao(codRota);

      if (containerSubRotas.html().length > 0) {
        containerSubRotas.find('input[type="checkbox"]:not(:checked)').click();
      }

    } else {
      removeDaColecao(codRota);
      removeDaColecao($(this).attr('parent-route'));

      if (containerSubRotas.html().length > 0) {
        containerSubRotas.find('input[type="checkbox"]:checked').click();
      }
    }
  });
})(jQuery, window);
