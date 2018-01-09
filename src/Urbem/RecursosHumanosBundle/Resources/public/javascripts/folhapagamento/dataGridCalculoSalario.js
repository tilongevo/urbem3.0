(function () {
  'use strict';

  var tipoField = $('#filter_tipo_value'),
    tipoFieldContainer = tipoField.parent(),
    fieldCodContrato = $('#s2id_filter_codContrato_value_autocomplete_input'),
    fieldLotacao = $('#filter_lotacao_value'),
    fieldLocal = $('#filter_local_value'),
    fieldEvento = $('#s2id_filter_evento_value_autocomplete_input'),
    submit = false,
    container,
    field,
    mensagem = ''
  ;

  $(document).ready(function () {
    if(tipoField.val() == 'cgm') {
      fieldCodContrato.select2("enable");
      fieldLotacao.select2("disable");
      fieldLocal.select2("disable");
      fieldEvento.select2("disable");
    } else if(tipoField.val() == 'lotacao') {
      fieldCodContrato.select2("disable");
      fieldLotacao.select2("enable");
      fieldLocal.select2("disable");
      fieldEvento.select2("disable");
    } else if(tipoField.val() == 'local') {
      fieldCodContrato.select2("disable");
      fieldLocal.select2("enable");
      fieldLotacao.select2("disable");
      fieldEvento.select2("disable");
    } else if(tipoField.val() == 'evento') {
      fieldCodContrato.select2("disable");
      fieldLocal.select2("disable");
      fieldLotacao.select2("disable");
      fieldEvento.select2("enable");
    } else {
      fieldCodContrato.select2("disable");
      fieldLocal.select2("disable");
      fieldLotacao.select2("disable");
      fieldEvento.select2("disable");
    }
  });

  tipoField.on("change", function (event) {
    if($(this).val() == 'cgm') {
      fieldCodContrato.select2("enable");
      fieldLotacao.select2("disable");
      fieldLocal.select2("disable");
      fieldEvento.select2("disable");
      limpaMessageErrors();
    } else if($(this).val() == 'lotacao') {
      fieldCodContrato.select2("disable");
      fieldLotacao.select2("enable");
      fieldLocal.select2("disable");
      fieldEvento.select2("disable");
      limpaMessageErrors();
    } else if($(this).val() == 'local') {
      fieldCodContrato.select2("disable");
      fieldLocal.select2("enable");
      fieldLotacao.select2("disable");
      fieldEvento.select2("disable");
      limpaMessageErrors();
    } else if($(this).val() == 'evento') {
      fieldCodContrato.select2("disable");
      fieldLocal.select2("disable");
      fieldLotacao.select2("disable");
      fieldEvento.select2("enable");
      limpaMessageErrors();
    } else {
      fieldCodContrato.select2("disable");
      fieldLocal.select2("disable");
      fieldLotacao.select2("disable");
      fieldEvento.select2("disable");
      limpaMessageErrors();
    }
  });

  jQuery("form").on('submit', function (event) {
    if (tipoField.val() == '') {
       mensagem = "Selecione um tipo para fazer o filtro";
      field = tipoField;
      container = tipoField.parent();
      limpaMessageErrors();
    } else if ((fieldLocal.val() == null) && (tipoField.val() == 'local')) {
       mensagem = "Selecione ao menos um local para realizar a busca";
       field = fieldLocal;
       container = fieldLocal.parent();
      limpaMessageErrors();
    } else if (fieldCodContrato.select2('data').length == 0 && tipoField.val() == 'cgm') {
      mensagem = "Selecione ao menos um CGM/Matricula para realizar a busca";
      field = fieldCodContrato;
      container = fieldCodContrato.parent();
      limpaMessageErrors();
    } else if (fieldLotacao.val() == null && tipoField.val() == 'lotacao') {
      mensagem = "Selecione ao menos uma lotação para realizar a busca";
      field = fieldLotacao;
      container = fieldLotacao.parent();
      limpaMessageErrors();
    } else if (fieldEvento.select2('data').length == 0 && tipoField.val() == 'evento') {
      mensagem = "Selecione ao menos um evento para realizar a busca";
      field = fieldEvento;
      container = fieldEvento;
      limpaMessageErrors();
    }

    if (tipoField.val() == 'geral') {
      mensagem = '';
    }

    if(mensagem != '') {
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

  function limpaMessageErrors()
  {
    $(".sonata-ba-field-error-messages").remove();
  }
}());
