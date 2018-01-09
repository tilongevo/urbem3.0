(function () {
  'use strict';

  $(document).ready(function(){
      $("#" + UrbemSonata.uniqId + "_qtdItem").prop( "readonly", true );
      $("#" + UrbemSonata.uniqId + "_vlReferencia").prop( "readonly", true );
  });

  /**
   * Calcula valor total a partir do valor unitário
   *
   * @author Helike Long (helikelong@gmail.com)
   * @date   2016-09-28
   *
   */
  $("#" + UrbemSonata.uniqId + "_vlUnit").on("keyup", function () {
    var vlUnit = $(this).val().replace(/\./g,'').replace(/\,/g,'.');
    var qtdItem = $("#" + UrbemSonata.uniqId + "_qtdItem").val().replace(/\./g,'').replace(/\,/g,'.');

    $("#" + UrbemSonata.uniqId + "_vlCotacao").val(( parseFloat(vlUnit * qtdItem).toFixed(2) ).toString().replace(/\,/g,' ').replace(/\./g,',').replace(/\ /g,'.'));
  });

  /**
   * Calcula valor unitário a partir do valor total
   *
   * @author Helike Long (helikelong@gmail.com)
   * @date   2016-09-28
   *
   */
  $("#" + UrbemSonata.uniqId + "_vlCotacao").on("keyup", function () {
    var vlCotacao = $(this).val().replace(/\./g,'').replace(/\,/g,'.');
    var qtdItem = $("#" + UrbemSonata.uniqId + "_qtdItem").val().replace(/\./g,'').replace(/\,/g,'.');
    
    if(!vlCotacao)
      return;

    $("#" + UrbemSonata.uniqId + "_vlUnit").val(( parseFloat(vlCotacao / qtdItem).toFixed(2) ).toString().replace(/\,/g,' ').replace(/\./g,',').replace(/\ /g,'.'));
  });

  /**
   * Coleta as informações do item selecionado
   *
   * @author Helike Long (helikelong@gmail.com)
   * @date   2016-09-28
   *
   */
  $("#" + UrbemSonata.uniqId + "_fkComprasCotacaoItem").on("change", function () {
    var id = $(this).val();
    if(id.indexOf(" - ") != -1) {
        id.split(" - ");
        id = id[0];
    }
    var codCotacao = $("#" + UrbemSonata.uniqId + "_codCotacao").val();
    var exercicio = $("#" + UrbemSonata.uniqId + "_exercicioCotacao").val();

    if(id == 0) {
      //
      return ;
    }

    $.ajax({            
        url: "/patrimonial/compras/cotacao-fornecedor-item/get-item-info/?codItem=" + id + "&codCotacao=" + codCotacao + "&exercicio=" + exercicio,
        method: "GET",
        dataType: "json",
        success: function (data) {
            $("#" + UrbemSonata.uniqId + "_qtdItem").val(data.quantidade.replace(/\,/g,' ').replace(/\./g,',').replace(/\ /g,'.'));
            $("#" + UrbemSonata.uniqId + "_vlReferencia").val(( parseFloat(data.vlRef).toFixed(2) ).toString().replace(/\,/g,' ').replace(/\./g,',').replace(/\ /g,'.'));
            $("#" + UrbemSonata.uniqId + "_vlCotacao").trigger("keyup");
        }
    });
  });
  $("#" + UrbemSonata.uniqId + "_fkComprasCotacaoItem").trigger("change");
    jQuery('.sonata-ba-form form').on('submit', function () {
        var error = false;
        var mensagem = '';
        jQuery('.sonata-ba-field-error-messages').remove();
        jQuery('.sonata-ba-form').parent().find('.alert.alert-warning.alert-dismissable').remove();

        var vlUnit =  $("#" + UrbemSonata.uniqId + "_vlUnit");
        var vlReferencia =  $("#" + UrbemSonata.uniqId + "_vlReferencia");

        // Validação: vlUnit não pode ser menor que o vlReferencia
        if(vlUnit.val() != "") {
            var valVlUnit = parseFloat( vlUnit.val().replace(/\./g, '').replace(/\,/g, '.') ).toFixed(2);
            var vlReferencia = parseFloat( vlReferencia.val().replace(/\./g, '').replace(/\,/g, '.') ).toFixed(2);
            mensagem = 'O valor unitário deve ser maior que o valor de referência do Item.';
            vlUnit.parent().removeClass('sonata-ba-field-error');
            if((vlReferencia - valVlUnit) > 0) {
                error = true;
                vlUnit.parent().addClass('sonata-ba-field-error');
                vlUnit.parent().append('<div class="help-block sonata-ba-field-error-messages" style="position: relative;"> <ul class="list-unstyled"> <li><i class="fa fa-exclamation-circle"></i> Valor menor que o valor de Referência.</li> </ul> </div>');
            }
        }

        if(error) {
            jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-warning alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' + mensagem + ' </div>');
            return false;
        }
    });

}());
