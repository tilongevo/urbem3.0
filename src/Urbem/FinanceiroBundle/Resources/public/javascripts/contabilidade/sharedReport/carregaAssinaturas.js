$(document).ready(function() {

    var modalLoad = new UrbemModal();
    modalLoad.setTitle('Carregando...');
    var entidades = $('#' + UrbemSonata.uniqId + "_entidades");
    var incluirAssinatura = $('#' + UrbemSonata.uniqId + "_incluirAssinatura");
    var listaAssinaturas = $('#' + UrbemSonata.uniqId + "_listaAssinaturas");

    listaAssinaturas.prop('disabled', true);

    var carregaAssinaturas = function (codEntidades) {

        modalLoad.setBody("Aguarde, carregando lista de assinaturas");
        modalLoad.open();

        $.ajax({
            url: "/financeiro/contabilidade/get-lista-assinatura?entidades="+codEntidades,
            method: "GET",
            dataType: "json",

            success: function (data) {
                listaAssinaturas
                    .empty()
                    .prop('disabled', false)
                    .empty();

                for (var i=0; i< data.length; i++) {
                    $('<option/>').html(data[i].cod_entidade + ' - ' + data[i].nom_cgm +' - '+ data[i].cargo )
                        .val(data[i].cod_entidade+'|'+data[i].numcgm+'|'+data[i].timestamp)
                        .appendTo(listaAssinaturas);
                }

                listaAssinaturas.removeAttr('disabled');
                modalLoad.close();
            },
        });
    };

    entidades.on("change", function () {

        var entidadesValor = $(this).val();

        incluirAssinatura.select2('val', '');
        listaAssinaturas.select2('val', '');
        listaAssinaturas.prop('disabled', true);
        listaAssinaturas.empty();

        if (entidadesValor == null) {
            incluirAssinatura.prop('disabled', true);
        } else {
            incluirAssinatura.prop('disabled', false);
        }
    });

    incluirAssinatura.on("change", function () {

        var incluir = incluirAssinatura.val();

        if (incluir == 1) {

            carregaAssinaturas(entidades.val());

        } else {

            listaAssinaturas.select2('val', '');
            listaAssinaturas.prop('disabled', true);
        }
    });
});
