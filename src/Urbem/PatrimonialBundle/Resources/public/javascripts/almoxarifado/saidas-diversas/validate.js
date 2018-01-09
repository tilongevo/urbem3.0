(function ($, global, sonata) {
  'use strict';

  $(document).on('click', 'button[name="btn_create_and_list"]', function (e) {
    e.stopPropagation();

    $.each(global.pereciveis, function (index) {
      var perecivel = global.pereciveis[index]
        , input = $('input[id$=quantidade_perecivel_' + perecivel.lote + ']');

      var saldoLote = Math.abs(perecivel.saldoLote)
        , quantidade = Math.abs(input.val().replace('.', '').replace(',', '.'));

      var errMsg;

      if (quantidade > saldoLote) {
        errMsg = 'Quantidade %quantidade% deve ser menor ou igual ao Saldo em Estoque %saldo% no lote %lote%.';
        errMsg = errMsg
          .replace('%quantidade%', input.val())
          .replace('%saldo%', perecivel.saldoLote.replace('.', ','))
          .replace('%lote%', perecivel.lote)
        ;
      }

      if (quantidade == 0 || input.val() == "") {
        errMsg = 'Quantidade deve ser maior que zero no lote %lote%.';
        errMsg = errMsg.replace('%lote%', perecivel.lote)
      }

      if (errMsg != undefined) {
        $('.sonata-ba-field-error-messages').remove();
        $('.sonata-ba-form').parent().find('.alert.alert-danger.alert-dismissable').remove();

        sonata.setFieldErrorMessage(
          input.prop('id'),
          errMsg,
          input.parent()
        );

        return false;
      }
    });
  });

})(jQuery, window, UrbemSonata);
