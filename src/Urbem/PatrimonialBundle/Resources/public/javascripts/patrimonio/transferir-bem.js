(function(){
  'use strict';
  var local_origem = $("#" + UrbemSonata.uniqId + "_local_origem");
  var modalContent =
    '<h5 class="text-center">' +
    '    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i>' +
    '</h5>' +
    '<h4 class="grey-text text-center">Aguarde, pesquisando bens</h4>';
  var target = $('.sonata-ba-collapsed-fields').last();

  local_origem.on('change', function() {
    var val = $(this).val();

    if (!val) {
      return;
    }


    abreModal(modalContent);
    $.ajax({
      url: "/patrimonial/patrimonio/bem/bens-por-local/" + val,
      method: "GET",
      dataType: "json",
      success: function (data) {
        console.log(data);
        target.empty();
        $.each(data, function (key, value) {
          var id = UrbemSonata.uniqId + '_codBem_' + key;
          var name = 'codBem[' + key + ']';
          var cb = target.append('<div class="form_row col s12 campo-sonata">' +
            '<label class="control-label" for="' + id + '">' + value['bem'] + '</label>' +
            '<input id="' + id + '" name="' + name + '" value="' + value['codBem'] + '" type="checkbox" >' +
            '</div>');
          cb.iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue'
          });
        });
        fechaModal();
      }
    });
  });
  local_origem.trigger('change');
}());
