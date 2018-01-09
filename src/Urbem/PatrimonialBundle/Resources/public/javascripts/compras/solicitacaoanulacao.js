(function(){
  'use strict';

  var formAction = $('form').prop('action'),
    giveMeMyField = function (fieldName) {

    };
  var fieldQuantidadeAnular = $('.quantidade-anulada');

  fieldQuantidadeAnular.on('change', function (e) {
    var fieldQuantidadeAnularValue = $(this).val().replaceAll('.', '').replace(',', '.'),
      fieldQuantidadeCalculoValue = $(this).parents("div .box-primary").find(".quantidade-calculo-qnt:first-child").val().replaceAll('.', '').replace(',', '.');

      var fieldTotalAnularValue = $(this).parents("div .box-primary").find(".total-anulado:first-child"),
        fieldTotalCalculoValue = $(this).parents("div .box-primary").find(".total-calculo-qnt:first-child").val(),
        totalItemAnulado = fieldTotalCalculoValue/fieldQuantidadeCalculoValue,
        totalItemAnuladoValue = float2moeda(fieldQuantidadeAnularValue*totalItemAnulado);
      fieldTotalAnularValue.val(totalItemAnuladoValue);
  });

  fieldQuantidadeAnular.on('click', function (e) {
    var fieldQuantidadeAnularValue = $(this).val().replaceAll('.', '').replace(',', '.');
    if(fieldQuantidadeAnularValue <= 0){
      $(this).val('');
    }
  });

  fieldQuantidadeAnular.on('focusout', function (e) {
    if($(this).val() == ''){
      $(this).val(0);
    }
  });


  jQuery('.sonata-ba-form form').on('submit', function (e) {
    var error = false;

    jQuery(document).find('.quantidade-anulada').each(function () {

      $(this).removeClass('sonata-ba-field-error').parent().removeClass('has-error');
      var fieldQuantidadeAnularValue = $(this).val().replaceAll('.', '').replace(',', '.'),
        fieldQuantidadeCalculoValue = $(this).parents("div .box-primary").find(".quantidade-calculo-qnt:first-child").val().replaceAll('.', '').replace(',', '.'),
        inputName = $(this).attr("name");

      if((fieldQuantidadeAnularValue*1) > (fieldQuantidadeCalculoValue*1)){
        var idCampo = inputName.split('[');
        idCampo = idCampo[1].split(']');
        UrbemSonata.setFieldErrorMessage(idCampo[0], 'A Quantidade a ser anulada deve ser menor ou igual a quantidade pendente!', $(this));
        error = true;
      }
    });

    if(true === error) {
      if(!jQuery('.sonata-ba-form').parent().find('.alert').length) {
        jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> A Quantidade a ser anulada deve ser menor ou igual a quantidade pendente! Verifique o formulário. </div>');
      }
      toTop();
      return false;
    }

    return true;
  });

  function toTop(){
    $('html, body').animate({
      scrollTop: 0
    }, 1000, 'easeInOutCirc');
  }

}());
