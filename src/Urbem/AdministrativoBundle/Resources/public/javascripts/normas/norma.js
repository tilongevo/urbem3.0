$(document).ready(function () {

  $('#' + UrbemSonata.uniqId + "_codTipoNorma").on('change', function (event) {
    window.setTimeout(function () {
      $('input[type="number"]').on('keyup blur change', function (event) {
        var field = $(this);
        if (parseInt(field.val()) < 0) {
          field.val('');
        }
      });
    }, 1500);
  });

  $(".textarea-custom").width("75%").height("125");
});

(function ($, urbem, attrDinamicoComponent) {
  'use strict';

  var attrDinamicosParams = {
        tabela: "CoreBundle:Normas\\Norma",
        fkTabela: "getFkNormasAtributoNormaValores",
        tabelaPai: 'CoreBundle:Normas\\TipoNorma',
        codTabelaPai: {
          codTipoNorma: null
        },
        fkTabelaPaiCollection: "getFkNormasAtributoTipoNormas",
        fkTabelaPai: "getFkNormasAtributoTipoNorma"
      }
    , codTipoNorma = null
    , fkNormasTipoNormaField = urbem.giveMeBackMyField('fkNormasTipoNorma');

  urbem.giveMeBackMyField('exercicio').attr('type', 'number');
  urbem.giveMeBackMyField('numNorma').attr('type', 'number');

  fkNormasTipoNormaField.on("change", function () {
    codTipoNorma = $(this).val();

    if (codTipoNorma !== '' && codTipoNorma !== undefined) {
      attrDinamicosParams.codTabelaPai.codTipoNorma = codTipoNorma;
      attrDinamicoComponent.getAtributoDinamicoFields(attrDinamicosParams);
    } else {
      $("#atributos-dinamicos").html('<span>Não existem atributos para o item selecionado.</span>');
    }
  });

})(jQuery, UrbemSonata, AtributoDinamicoComponent);
