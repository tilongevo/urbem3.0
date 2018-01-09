(function(){
    'use strict';
    var agenda = $("#" + UrbemSonata.uniqId + "_agenda");
    var empenho = $("#" + UrbemSonata.uniqId + "_codEmpenho");
    var modalContent =
      '<h5 class="text-center">' +
      '    <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i>' +
      '</h5>' +
      '<h4 class="grey-text text-center">Aguarde, pesquisando grupos</h4>';

    empenho.mask('#');
    agenda.on("change", function() {
        var val = $(this).val();

        if (!val) {
          return;
        }

        abreModal(modalContent);
        $.ajax({
          url: "/patrimonial/patrimonio/manutencao/paga/" + val,
          method: "GET",
          dataType: "json",
          success: function (data) {
            console.log(data);
            $.each(data, function (key, value) {
              $("#" + UrbemSonata.uniqId + "_" + key).val(value);
            });
            fechaModal();
          }
        });
    });
}());
