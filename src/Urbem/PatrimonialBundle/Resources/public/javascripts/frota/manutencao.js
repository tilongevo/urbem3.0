(function(){
    'use strict';
    var veiculo = $("#" + UrbemSonata.uniqId + "_fkFrotaVeiculo");
    var autorizacao = $("#" + UrbemSonata.uniqId + "_codAutorizacao");
    var km = $("#" + UrbemSonata.uniqId + "_km");

    if (! UrbemSonata.checkModule('manutencao')) {
        return;
    }
    
    UrbemSonata.sonataFieldContainerHide('_codAutorizacao');
    $('#' + UrbemSonata.uniqId + '_tipoManutencao input').on('ifChecked', function () {
        if($(this).val() == 1) {
            UrbemSonata.sonataFieldContainerShow('_codAutorizacao');
            veiculo.prop( "readonly", true );
            $('select').select2();
        } else {
            UrbemSonata.sonataFieldContainerHide('_codAutorizacao');
            veiculo.prop( "readonly", false );
            $('select').select2();
        }
    });
    var tipoManutencao = $('#' + UrbemSonata.uniqId + '_tipoManutencao input[checked="checked"]').val();
    $('#' + UrbemSonata.uniqId + '_tipoManutencao input[value="'+tipoManutencao+'"]').trigger('ifChecked');

    autorizacao.on("change", function () {
        if($(this).val() == "") {
            return;
        }

        abreModal('Carregando','Aguarde, carregando dados da autorização');
        var autorizacao = $(this).children("option").filter(":selected").text();
        autorizacao = autorizacao.split("/");
        $.ajax({
            url: "/patrimonial/frota/manutencao/get-autorizacao-info?codAutorizacao=" + autorizacao[0] + "&exercicioAutorizacao=" + autorizacao[1],
            method: "GET",
            dataType: "json",
            success: function (data) {
                veiculo.val(data.codVeiculo);
                $('select').select2();
                fechaModal();
                veiculo.trigger('change');
            }
        });
    });
    autorizacao.trigger('change');

    veiculo.on('change', function(){
        if(veiculo.val() == '') {
            return;
        }

        abreModal('Carregando','Aguarde, carregando quilometragem');
        $.ajax({
            url: "/patrimonial/frota/veiculo/get-km/" + veiculo.val(),
            method: "GET",
            dataType: "json",
            success: function (data) {
                km.val(data.km);
                fechaModal();
            }
        });
    });
    


}());
