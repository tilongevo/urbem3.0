(function ($, urbem) {
  'use strict';

  var sonataId = urbem.uniqId
    , modal = $.urbemModal();

  $(document).on('show.bs.collapse', 'div[id^="accordion-local-"]', function (e) {
    var element = $(this)
      , elementId = $(this).prop('id')
      , indexes = elementId.split('-');

    if (element.html().length === 0) {
      $.ajax({
        url: '/patrimonial/patrimonio/inventario/api/local/' + indexes[2]+ '/'+ indexes[3]+ '/'+ indexes[4],
        data: {
          mode: 'table'
        },
        dataType: 'html',
        method: 'GET',
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando locais.')
            .open();
        },
        success: function (data) {
          // Muda icone de + para -
          $('a[data-target="#' + elementId + '"]').find('i.fa')
            .removeClass('fa-plus-square')
            .addClass('fa-minus-square');

          // Renderiza HTML recebido da requisiçao no container.
          element.append($(data));

          // Fecha o modal apos o html requisitado for renderizado
          modal.close();
        },
        error: function (xhr, textStatus, error) {
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
      });
    } else {
      // Muda icone de + para -
      $('a[data-target="#' + elementId + '"]').find('i.fa')
        .removeClass('fa-plus-square')
        .addClass('fa-minus-square');
    }
  });

})(jQuery, UrbemSonata);
