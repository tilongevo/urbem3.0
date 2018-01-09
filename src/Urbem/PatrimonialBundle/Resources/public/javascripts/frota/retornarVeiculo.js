(function(){
    'use strict';

    $("#" + UrbemSonata.uniqId + "_codUtilizacao").on("change", function() {
        var id = $(this).val();
        $.ajax({
            url: "/patrimonial/frota/veiculo/retornar-veiculo/consultar-utilizacao/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $('#' + UrbemSonata.uniqId + '_cgmMotorista').val(data['cgmMotorista']).trigger("change");
                var dtSaida = new Date(data['dtSaida']['date']);
                var dia = dtSaida.getDate();
                var mes = dtSaida.getMonth() + 1;
                var ano = dtSaida.getFullYear();
                if (mes < 10) {
                    mes = "0" + mes;
                }

                var hrSaida = new Date(data['hrSaida']['date']);
                var hor = hrSaida.getHours();
                var min = hrSaida.getMinutes();
                if (hor < 10) {
                    hor = "0" + hor;
                }
                if (min < 10) {
                    min = "0" + min;
                }
                $('#' + UrbemSonata.uniqId + '_dtSaida').val(dia + '/' + mes + '/' + ano);
                $('#' + UrbemSonata.uniqId + '_hrSaida').val(hor + ':' + min);
                $('#' + UrbemSonata.uniqId + '_kmInicial').val(data['kmSaida']);
                $('#' + UrbemSonata.uniqId + '_destino').val(data['destino']);
                $('#' + UrbemSonata.uniqId + '_kmRetorno').val(data['kmSaida']);
                $('#' + UrbemSonata.uniqId + '_kmRetorno').attr({"min" : data['kmSaida']});
            }
        });
    });
}());
