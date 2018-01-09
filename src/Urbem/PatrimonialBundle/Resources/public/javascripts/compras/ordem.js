$(function () {
    "use strict";

    $(document).ready(function(){
        document.getElementsByTagName('form')[0].reset();

        $("#" + UrbemSonata.uniqId + "_item").prop( "readonly", true );
        $("#" + UrbemSonata.uniqId + "_qtdEmpenho").prop( "readonly", true );
        $("#" + UrbemSonata.uniqId + "_qtdOrdem").prop( "readonly", true );
        $("#" + UrbemSonata.uniqId + "_qtdDisponivel").prop( "readonly", true );
        $("#" + UrbemSonata.uniqId + "_valorUnit").prop( "readonly", true );
        $("#" + UrbemSonata.uniqId + "_vlTotal").prop( "readonly", true );

        $( ".money" ).each(function( index ) {
          $( this ).val(( ( parseFloat($(this).val()).toFixed(2) ).toString().replace(/\,/g,'') ).replace(/\./g,','));
        });
        $( ".quantity" ).each(function( index ) {
          $( this ).val(( ( parseFloat($(this).val()).toFixed(4) ).toString().replace(/\,/g,'') ).replace(/\./g,','));
        });

        $('.money').maskMoney('mask');
        $('.quantity').maskMoney('mask');
    });

    UrbemSonata.giveMeBackMyField('codEmpenho').on("change", function () {
        var id = $(this).val();
        if(id.indexOf("/") != -1) {
            id = id.split("/");
            id = id[0];
        }

        if(id == 0) {
            document.getElementsByTagName('form')[0].reset();
            return ;
        }

        $.ajax({
            url: "/patrimonial/compras/ordem/get-empenho-info/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                window.varJsCodEntidade = data.codEntidade;
                // Dados Ordem
                $("#" + UrbemSonata.uniqId + "_entidade").val(data.entidade);
                $("#" + UrbemSonata.uniqId + "_codEntidade").val(data.codEntidade);
                $("#" + UrbemSonata.uniqId + "_fornecedor").val(data.fornecedor);
                $("#" + UrbemSonata.uniqId + "_exercicioEmpenho").val(data.exercicioEmpenho);
                // Item
                $("#" + UrbemSonata.uniqId + "_item").val(data.item.nomItem);
                $("#" + UrbemSonata.uniqId + "_numItem").val(data.item.numItem);
                $("#" + UrbemSonata.uniqId + "_codPreEmpenho").val(data.item.codPreEmpenho);
                $("#" + UrbemSonata.uniqId + "_exercicioPreEmpenho").val(data.item.exercicioPreEmpenho);
                $("#" + UrbemSonata.uniqId + "_qtdEmpenho").val(data.item.quantidade.replace(/\,/g,' ').replace(/\./g,',').replace(/\ /g,'.'));
                $("#" + UrbemSonata.uniqId + "_qtdOrdem").val(data.item.ocQtdAtendido.replace(/\,/g,' ').replace(/\./g,',').replace(/\ /g,'.'));
                $("#" + UrbemSonata.uniqId + "_qtdDisponivel").val(data.item.ocSaldo.replace(/\,/g,' ').replace(/\./g,',').replace(/\ /g,'.'));
                $("#" + UrbemSonata.uniqId + "_valorUnit").val(data.item.vlUnit.replace(/\,/g,' ').replace(/\./g,',').replace(/\ /g,'.'));
                $("#" + UrbemSonata.uniqId + "_qtdOrdemAtual").val(data.item.ocSaldo.replace(/\,/g,' ').replace(/\./g,',').replace(/\ /g,'.'));
              $("#" + UrbemSonata.uniqId + "_vlTotal").val(( parseFloat(parseFloat($("#" + UrbemSonata.uniqId + "_valorUnit").val()) * parseFloat($("#" + UrbemSonata.uniqId + "_qtdOrdemAtual").val())).toFixed(2) ).toString().replace(/\,/g,' ').replace(/\./g,',').replace(/\ /g,'.'));
            }
        });
    });

    $("#" + UrbemSonata.uniqId + "_qtdOrdemAtual").on("keyup", function () {
        var valueChange = parseFloat( parseFloat($(this).val().replace(/\./g,'').replace(/\,/g,'.')) * parseFloat($("#" + UrbemSonata.uniqId + "_valorUnit").val().replace(/\./g,'').replace(/\,/g,'.')) ).toFixed(2).toString().replace(/\,/g,' ').replace(/\./g,',').replace(/\ /g,'.');
        if (isNaN(valueChange)) {
            valueChange = 0;
        }
        $("#" + UrbemSonata.uniqId + "_vlTotal").val(valueChange);
    });

    var unique_id = $('meta[name="uniqid"]').attr('content'),
        incluirAssinatura = $('#' + unique_id + '_incluirAssinatura');

    if (incluirAssinatura.is(':checked')) {
        UrbemSonata.sonataFieldContainerShow('_codAssinaturas');
    } else {
        UrbemSonata.sonataFieldContainerHide('_codAssinaturas');
    }

    incluirAssinatura.on('ifChecked', function() {
        UrbemSonata.sonataFieldContainerShow('_codAssinaturas');
    });

    incluirAssinatura.on('ifUnchecked', function() {
        UrbemSonata.sonataFieldContainerHide('_codAssinaturas');
    });

}());
