(function(){
  'use strict';

  var cgmMotoristaField = UrbemSonata.giveMeBackMyField('cgmMotorista'),
    cgmMotoristaFieldId = cgmMotoristaField.prop('id'),
    cgmMotoristaFieldContainer = cgmMotoristaField.parent();

  jQuery('button[name="btn_create_and_list"]').on('click', function (event) {
    var mensagem = '';
    jQuery('.sonata-ba-field-error-messages').remove();
    jQuery('.sonata-ba-form').parent().find('.alert.alert-danger.alert-dismissable').remove();

    if (cgmMotoristaField.val() == '') {
      event.preventDefault();
      mensagem = 'O Campo Motorista deve ser selecionado!';

      $(".sonata-ba-field-error-messages").remove();
      UrbemSonata.setFieldErrorMessage(
        cgmMotoristaFieldId,
        mensagem,
        cgmMotoristaFieldContainer
      );

      jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' + mensagem + ' </div>');
      return false;
    }
  });


  $("#" + UrbemSonata.uniqId + "_codVeiculo").on("change", function() {
    var id = $(this).val();
    $.ajax({
      url: "/patrimonial/frota/veiculo/retirar-veiculo/consultar-veiculo/" + id,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $('#' + UrbemSonata.uniqId + '_kmSaida').val(data['kmInicial']);
        $('#' + UrbemSonata.uniqId + '_kmSaida').attr({"min" : data['kmInicial']});
      }
    });
  });
}());
