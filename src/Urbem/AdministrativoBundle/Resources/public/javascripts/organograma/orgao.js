(function ($, urbem, global) {
  'use strict';

  var fieldCodOrgaoSuperior = urbem.giveMeBackMyField('codOrgaoSuperior')
    , fieldCodOrganograma = urbem.giveMeBackMyField('codOrganograma')
    , fieldFkNormasNorma = urbem.giveMeBackMyField('fkNormasNorma')
    , fieldTipoNorma = urbem.giveMeBackMyField('tipoNorma')
    , fieldCodNivel = urbem.giveMeBackMyField('codNivel')
    , codOrganograma = fieldCodOrganograma.val()
    , codTipoNorma = fieldTipoNorma.val()
    , modal = $.urbemModal()
    , nivelOrgao = $(".js-nivelOrgao")
    , nivelSecretarias = $(".js-nivelSecretarias")
    , nivelUnidades = $(".js-nivelUnidades")
    , nivelMode = $(".js-nivelMode");

  fieldFkNormasNorma.next('select').attr('required', 'required');
  fieldCodOrganograma.select2('disable');

  var parentDiv = nivelMode.parent().parent();

  hiddenNiveis();

  if (codOrganograma === '' || codOrganograma === undefined) {
    fieldCodNivel.empty()
      .append("<option value=\"\">Selecione</option>")
      .select2("val", "");
  } else if (fieldCodOrganograma.attr('disabled') !== 'disabled') {
    manterNivel(codOrganograma);
  }

  nivelMode.on("change", function () {
    if ($(this).val() == 2) {
      ativarManual();
      return;
    }

    hiddenNiveis();

  });

  fieldCodOrgaoSuperior.on("change", function () {
    var codOrgaoSuperior = $(this).val();
    getCodNiveis(codOrgaoSuperior, fieldCodOrganograma.select2('data'));

  });

  function getCodNiveis(codOrgaoSuperior, codOrganograma) {

    $.ajax({
      url: "/administrativo/organograma/orgao/consultar-valor-nivel",
      method: "POST",
      data: {codOrgao: codOrgaoSuperior, organograma: codOrganograma.id},
      dataType: "json",
      beforeSend: function (xhr) {
        modal
          .disableBackdrop()
          .setTitle('Aguarde...')
          .setBody('Buscando valores niveis.')
          .open();
      },
      success: function (data) {

        $.each(data, function (index, value) {
          $("input[name='codNivel" + (parseInt(index) + parseInt(1)) + "']").val(value);
        });

        modal.close();
      }

    });
  }

  fieldCodOrganograma.on("change", function () {
    var id = $(this).val();
    if (id === '') {
      id = 0;
    }
    manterNivel(id);
  });

  var nivel = fieldCodNivel.val();
  if ((nivel === '') || (nivel === undefined)) {
    fieldCodOrgaoSuperior.empty()
      .append("<option value=\"\">Selecione</option>")
      .attr("disabled", true)
      .attr("required", false)
      .select2("val", "");
  } else if (fieldCodOrganograma.attr('disabled') !== 'disabled') {
    manterOrgao(codOrganograma, nivel);
    modal.close();
  }

  fieldCodNivel.on("change", function () {
    var codOrganograma = fieldCodOrganograma.val()
      , codNivel = $(this).val();

    $("#" + UrbemSonata.uniqId + "_editNivel").val(codNivel);
    if (codNivel === '') {
      codNivel = 0;
    }

    manterOrgao(codOrganograma, codNivel);
    disableParentNivel(codNivel);
  });

  function disableParentNivel(codNivel) {
    $.each($(".js-nivelVisibility"), function () {
      var element = $(this);
      var name = element.attr("name");

      if (name.replace("codNivel", "") != codNivel) {
        element.prop("disabled", true);
        return;
      }

      element.prop("disabled", false);

    });
  }

  function ativarManual() {
    $(".js-nivelVisibility").parent().parent("div").removeClass("hidden");
  }

  function hiddenNiveis() {
    $(".js-nivelVisibility").parent().parent("div").addClass("hidden");
    nivelMode.select2().val("1");

  }

  function manterNivel(organograma) {
    var inputManual = "";
    $.ajax({
      url: "/administrativo/organograma/orgao/consultar-nivel",
      method: "POST",
      data: {organograma: organograma},
      dataType: "json",
      beforeSend: function (xhr) {
        $(".inputManual").empty();
        $(".inputManual").remove();
        modal
          .disableBackdrop()
          .setTitle('Aguarde...')
          .setBody('Buscando niveis.')
          .open();
      },
      success: function (data) {
        fieldCodNivel.empty()
          .append("<option value=\"\">Selecione</option>")
          .select2("val", "");

        $.each(data, function (index, value) {
          fieldCodNivel.append("<option value=" + index + ">" + value[0] + "</option>");

          inputManual += createInputManual(index, value[0], value[1]);
        });

        modal.close();

        $(inputManual).insertAfter(parentDiv);

        if (nivelMode.val() == 2) {
          ativarManual();
        }
      }
    });
  }

  function createInputManual(index, fieldName, mask) {
    var html = '<div class="form_row col s3 campo-sonata-input-text hidden inputManual">' +
      '<label class=" control-label"> Código ' + fieldName + '</label>' +
      '<div class="sonata-ba-field sonata-ba-field-standard-natural ">' +
      '<input type="text" name="codNivel' + index + '" class="js-nivelVisibility numeric campo-sonata form-control " maxlength="' + mask.length + '" disabled>' +
      '</div></div>';

    return html;
  }

  function manterOrgao(organograma, nivel) {
    emptyInputs();
    if ((nivel != 1) && (nivel != undefined) && (nivel != 0)) {
      $.ajax({
        url: "/administrativo/organograma/orgao/consultar-superior",
        method: "POST",
        data: {codOrganograma: organograma, codNivel: nivel},
        dataType: "json",
        beforeSend: function (xhr) {
          modal.close();
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando orgãos superiores.')
            .open();
        },
        success: function (data) {
          fieldCodOrgaoSuperior.attr("disabled", false);
          fieldCodOrgaoSuperior.attr("required", true);
          fieldCodOrgaoSuperior.empty()
            .append("<option value=\"\">Selecione</option>")
            .select2("val", "");

          $.each(data, function (index, value) {
            fieldCodOrgaoSuperior
              .append("<option value=" + index + ">" + value + "</option>");
          });

          modal.close();
        }
      });
    } else {
      fieldCodOrgaoSuperior.empty()
        .append("<option value=\"\">Selecione</option>")
        .attr("disabled", true)
        .attr("required", false)
        .select2("val", "");
    }
  }

  function emptyInputs() {
    $.each( $("input.js-nivelVisibility") , function() {
      $(this).val("");
    });
  }

  function manterNormas(tipoNorma) {
      $.ajax('/administrativo/organograma/organograma/consultar-norma/{id}'.replace('{id}', tipoNorma), {
        method: 'GET',
        dataType: 'json',
        beforeSend: function (xhr) {
          modal
            .disableBackdrop()
            .setTitle('Aguarde...')
            .setBody('Buscando normas.')
            .open();
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
        },
        success: function (data) {
          urbem.populateSelect(fieldFkNormasNorma, data, {label: 'label', value: 'value'}, fieldFkNormasNorma.val());

          fieldFkNormasNorma.select2('enable');

          modal.close();
        }
      });
  }

  if (codTipoNorma !== "" && codTipoNorma !== undefined) {
    manterNormas(codTipoNorma);
  } else {
    fieldFkNormasNorma.empty()
      .append("<option value=\"\">Selecione</option>")
      .attr("required", true)
      .attr("disabled", true)
      .select2("val", "");
  }

  fieldTipoNorma.on('change', function () {
    codTipoNorma = $(this).val();

    if (codTipoNorma !== "" && codTipoNorma !== undefined) {
      manterNormas(codTipoNorma);
    }
  });

  if (fieldCodOrganograma.attr('disabled') === 'disabled') {
    $("#sonata-ba-field-container-" + urbem.uniqId + "_inativacao").hide();
    $("#" + urbem.uniqId + "_inativacao").attr('required', false);

    $("#" + urbem.uniqId + "_desativar_0").on('ifChecked', function (event) {
      $("#sonata-ba-field-container-" + urbem.uniqId + "_inativacao").show();
      $("#" + urbem.uniqId + "_inativacao").attr('required', true);
    });

    $("#" + urbem.uniqId + "_desativar_1").on('ifChecked', function (event) {
      $("#sonata-ba-field-container-" + urbem.uniqId + "_inativacao").hide();
      $("#" + urbem.uniqId + "_inativacao").attr('required', false);
    });
  }

})(jQuery, UrbemSonata, window);
