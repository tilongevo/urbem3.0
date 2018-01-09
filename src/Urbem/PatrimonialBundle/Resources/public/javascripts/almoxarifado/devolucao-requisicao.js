(function ($) {
  'use strict';

  var checkboxIdentifier = "input[id$='devolverItem'][type='checkbox']"
    , getPrefixNamedFields = function (field) {
      var regex = /[a-zA-Z0-9]+/g,
        fieldName = field.attr('name');

      var parts = fieldName.match(regex);

      var rebuildedPrefixName = UrbemSonata.uniqId;
      rebuildedPrefixName += '_fkAlmoxarifadoRequisicaoItens';
      rebuildedPrefixName += '_'+ parts[2];

      return rebuildedPrefixName;
    }
    , removeRequiredRule = function (field) {
      field.prop('required', false);
      $("label[for='" + field.prop('id') + "']").removeClass('required');
    }
    , addRequiredRule = function (field) {
      field.prop('required', true);
      $("label[for='" + field.prop('id') + "']").addClass('required');
    };

  $('.init-readonly').prop('readonly', true);

  $(document).on("ifChecked", checkboxIdentifier, function(event) {
    var fieldsIdentifier = "[id^='" + getPrefixNamedFields($(this)) + "'].check-empty"
      , fields = $(fieldsIdentifier);

    $.each(fields, function (index, element) {
      addRequiredRule($(element));
    });
  });

  $(document).on("ifUnchecked", checkboxIdentifier, function(event) {
    var fieldsIdentifier = "[id^='" + getPrefixNamedFields($(this)) + "'].check-empty"
      , fields = $(fieldsIdentifier);

    $.each(fields, function (index, element) {
      removeRequiredRule($(element));
    });
  });
}(jQuery));
