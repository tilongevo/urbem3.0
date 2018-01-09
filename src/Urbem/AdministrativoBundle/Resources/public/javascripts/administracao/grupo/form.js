(function ($) {
  'use strict';

  var formRoutesField = $('input#form_routes');

  $(document).on('click', 'input[type="checkbox"]', function () {
    var permissions = $.parseJSON(formRoutesField.val())
      , codRota = Number.parseInt($(this).val());

    if ($(this).prop("checked")) {
      permissions.push(codRota);
    } else {
      var indexToDelete = permissions.indexOf(codRota);
      permissions.splice(indexToDelete, 1);
    }

    formRoutesField.val(JSON.stringify(permissions));
  });

})(jQuery);
