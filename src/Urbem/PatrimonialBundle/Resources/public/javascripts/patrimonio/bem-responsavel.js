(function(){
    'use strict';

    $("#" + UrbemSonata.uniqId + "_MFResponsavelAnterior_autocomplete_input").on("change", function() {

        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando a data de Inicio</h4>');
        var id = $(this).val();
        $.ajax({
            url: "/patrimonial/patrimonio/bem/carrega-dt-inicio-responsavel/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_dtInicioAnterior").val(data);
                fechaModal();
            }
        });
    });
}());
