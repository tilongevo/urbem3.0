(function () {
  'use strict';

  var tipoField = $('#filter_tipo_value'),
    tipoFieldContainer = tipoField.parent(),
    fieldCodContrato = $('#s2id_filter_codContrato_value_autocomplete_input'),
    fieldEvento = UrbemSonata.giveMeBackMyField('evento', true),
    fieldTipoCalculo = $('#filter_tipoCalculo_value'),
    submit = false,
    container,
    field,
    mensagem = '';

  function limpaMessageErrors() {
    $(".sonata-ba-field-error-messages").remove();
  }

  $(document).ready(function () {
    if (tipoField.val() == 'cgm') {
      fieldCodContrato.select2("enable");
      fieldEvento.prop("disabled",true);
    } else if (tipoField.val() == 'evento') {
      fieldCodContrato.select2("disable");
      fieldEvento.select2("enable");
    } else {
      fieldCodContrato.select2("disable");
      fieldEvento.prop("disabled",true);
    }
  });

  tipoField.on("change", function (event) {
    if ($(this).val() == 'cgm') {
      fieldCodContrato.select2("enable");
      fieldEvento.select2("disable");
      limpaMessageErrors();
    } else if ($(this).val() == 'evento') {
      fieldCodContrato.select2("disable");
      fieldEvento.select2("enable");
      limpaMessageErrors();
    } else {
      fieldCodContrato.select2("disable");
      fieldEvento.prop("disabled",true);
      limpaMessageErrors();
    }
  });

  fieldTipoCalculo.on("change" ,function (event) {
    mensagem = '';
    limpaMessageErrors();
  });

  jQuery("form").on('submit', function (event) {
    if (tipoField.val() == 'cgm') {
      if (fieldCodContrato.select2('data').length == 0) {
        mensagem = "Selecione ao menos um CGM/Matricula para realizar a busca";
        field = fieldCodContrato;
        container = fieldCodContrato.parent();
        limpaMessageErrors();
      }
    } else if (tipoField.val() == 'evento') {
      if (fieldEvento.select2('data').length == 0) {
        mensagem = "Selecione ao menos um evento para realizar a busca";
        field = fieldEvento;
        container = fieldEvento;
        limpaMessageErrors();
      }
    }

    if (mensagem != '') {
      limpaMessageErrors();
      UrbemSonata.setFieldErrorMessage(
        field,
        mensagem,
        container
      );

      jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' + mensagem + ' </div>');
    } else {
      submit = true;
    }

    return submit;
  });
}());
