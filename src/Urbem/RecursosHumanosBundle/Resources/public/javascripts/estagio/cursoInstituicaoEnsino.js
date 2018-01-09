$(function () {
  "use strict";

  var unique_id = $('meta[name="uniqid"]').attr("content");

  var field = UrbemSonata.giveMeBackMyField('fkSwCgmPessoaJuridica'),
      fieldGrau = UrbemSonata.giveMeBackMyField('grauCurso'),
      fieldCurso = UrbemSonata.giveMeBackMyField('curso');

  $(fieldGrau).on('change', function() {
    var selectedOptionGrau = $(this).find('option:selected'),
      selectTarget = fieldCurso;

    if(fieldGrau.val() != "") {
      abreModal('Carregando','Aguarde, buscando informações...');
      $.ajax({
        url: '/recursos-humanos/estagio/estagiario-estagio/preencher-curso-by-grau',
        method: 'POST',
        data: {
          codGrau: selectedOptionGrau.val(),
        },
        dataType: 'json',
        success: function (data) {
          if (data != null) {
            fieldCurso.find('option').remove();
            fieldCurso.select2('readonly', false);
            selectTarget.parent().find('div').find('span').first().html('Selecione');
            UrbemSonata.populateSelect(selectTarget, data, {
              value: 'cod_curso',
              label: 'nom_curso'
            }, selectTarget.val());
            fechaModal();
          }
        }
      });
    } else {
      fieldCurso.select2('val','');
      fieldCurso.select2('readonly',true);
    }
  });
});
