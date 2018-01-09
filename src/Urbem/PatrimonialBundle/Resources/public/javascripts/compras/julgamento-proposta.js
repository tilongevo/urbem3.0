(function(){
    'use strict';

    var radio =  $("input[name='" + UrbemSonata.uniqId + "[incluir_assinaturas]']");
    var assinaturas = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_assinatura');
    assinaturas.hide();
    radio.on('ifChecked', function () {
        assinaturas.hide();
        if('1' == $(this).val()) {
            assinaturas.show();
        }
    });

}());