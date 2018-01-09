(function(){
    'use strict';

  var fkPatrimonioBemField = UrbemSonata.giveMeBackMyField('fkPatrimonioBem');
  var dtInicioField = UrbemSonata.giveMeBackMyField('dtInicio');
  var responsavelField = UrbemSonata.giveMeBackMyField('responsavel');

  fkPatrimonioBemField.on('change', function() {
        var id = $(this).val();
        if (!id) {
          return;
        }

        if(id.indexOf(" - ") != -1) {
          id.split(" - ");
          id = id.substring(0, id.indexOf(" - "));
        }
        abreModal('Carregando','Aguarde, carregando dados do Bem');

        $.ajax({
            url: "/patrimonial/patrimonio/bem/carrega-bem-proprio?id=" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                dtInicioField.val(data['dtInicio']);
                responsavelField.val(data['responsavel']);
            }
        });
        fechaModal();
    });

  fkPatrimonioBemField.trigger("change");
}());
