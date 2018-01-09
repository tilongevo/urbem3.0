(function(){
    'use strict';

    $("#" + UrbemSonata.uniqId + "_cgmMotorista").on("change", function() {
        var id = $(this).val();
        if (!id) {
          return;
        }

        if(id.indexOf(" - ") != -1) {
            id.split(" - ");
            id = id[0];
        }
        abreModal('Carregando','Aguarde, carregando dados do motorista');

        $.ajax({
            url: "/patrimonial/frota/motorista/consultar-dados-cgm-motorista/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $('#' + UrbemSonata.uniqId + '_numCnh').val(data['numCnh']);
                $('#' + UrbemSonata.uniqId + '_dtValidadeCnh').val(data['dtValidadeCnh']);
                $('#' + UrbemSonata.uniqId + '_categoriaCnh').val(data['categoriaCnh']);
                $('select').select2();
                $("#" + UrbemSonata.uniqId + "_categoriaCnh").trigger('change');
            }
        });
        fechaModal();
    });

    $("#" + UrbemSonata.uniqId + "_categoriaCnh").on("change", function() {
        var id = $(this).val();
        if (!id) {
          return;
        }

        abreModal('Carregando','Aguarde, carregando veículos para categoria');

        $.ajax({
            url: "/patrimonial/frota/motorista/get-veiculos-cnh-categoria/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                var old = $("#" + UrbemSonata.uniqId + "_codVeiculo").val();

                $("#" + UrbemSonata.uniqId + "_codVeiculo")
                    .empty();
                $('select').select2();

                $.each(data, function (index, value) {
                    $("#" + UrbemSonata.uniqId + "_codVeiculo")
                        .append("<option value=" + index + " " + ( (old && old.indexOf(index) != -1) ? 'selected="selected"' : '' ) + ">" + value + "</option>");
                });
                $('select').select2();
                fechaModal();
            }
        });
    });
}());
