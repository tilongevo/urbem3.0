$(document).ready(function() {
    'use strict';
    
    function getNormaTipoNorma(source, target) {
        $.ajax({
            url: "/recursos-humanos/folha-pagamento/padrao/get-normas-tipo-norma",
            method: "POST",
            data: {
                codTipoNorma: source.val()
            },
            dataType: "json",
            success: function (data) {
                target.empty().append("<option value=\"\">Selecione</option>");

                for (var i in data) {
                    target.append("<option value=" + i + ">" + data[i] + "</option>");
                }
                
                target.val('').trigger("change");
            }
        });
    }
    
    function calcularValorCorrecao() {
      var widget = '#field_widget_' + UrbemSonata.uniqId + '_fkFolhapagamentoNivelPadraoNiveis > table > tbody > tr';
      
      $(widget).each(function (index) {
          var valorPadrao = UrbemSonata.convertMoneyToFloat($('#' + UrbemSonata.uniqId + '_valor').val()),
          percentual = UrbemSonata.convertMoneyToFloat($('#' + UrbemSonata.uniqId + '_fkFolhapagamentoNivelPadraoNiveis_' + index + '_percentual').val()),
          valor = '#' + UrbemSonata.uniqId + '_fkFolhapagamentoNivelPadraoNiveis_' + index + '_valor',
          resultado;
          
          resultado = valorPadrao + (valorPadrao * (percentual / 100));
          
          $(valor).val(UrbemSonata.convertFloatToMoney(resultado));
      });
    }

    $("#" + UrbemSonata.uniqId + "_codTipoNorma").on("change", function () {
        getNormaTipoNorma($(this), $("#" + UrbemSonata.uniqId + "_codNorma"));
    });
    
    $(document).on('blur', '.percentual', function() {
        calcularValorCorrecao();
    });
    
    $("#" + UrbemSonata.uniqId + "_valor").on("change", function () {
        calcularValorCorrecao();
    });    
});
