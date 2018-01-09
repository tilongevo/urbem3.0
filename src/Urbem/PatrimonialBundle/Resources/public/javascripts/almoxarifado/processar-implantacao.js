(function(){
    'use strict';
    $("#" + UrbemSonata.uniqId + "_quantidade").mask("99999");

    $("#" + UrbemSonata.uniqId + "_valorMercado").mask('#.##0,00', {reverse: true});

    var codItem =  UrbemSonata.giveMeBackMyField('codItem')
        , fieldCodUnidade = $("#codUnidade")
        , fieldCodTipo = $("#codTipo")
        , modal = jQuery.urbemModal()
        , urlEndPoint = '/patrimonial/almoxarifado/processar-implantacao/get-item?id=';

    codItem.on('change', function (e) {
        var valCodItem = jQuery(this).val();
        fieldCodUnidade.empty();
        fieldCodTipo.empty();
        var isPerecivel = $('#' + UrbemSonata.uniqId + '_codItem option:selected').text().indexOf('Perecível') > 0;
        jQuery.ajax({
            method: 'GET',
            url: urlEndPoint+valCodItem,
            dataType: 'json',
            beforeSend: function (xhr) {
                modal
                    .disableBackdrop()
                    .setTitle('Aguarde...')
                    .setBody('Buscando.')
                    .open();
            },
            success: function (data) {
                fieldCodUnidade.html(data.item.codUnidade);
                fieldCodTipo.html(data.item.codTipo);
                modal.close();
            }
        });
        // $('.box-header:eq(1)').show();
        // if(isPerecivel) {
        //     $('.box-header:eq(1)').show();
        // } else {
        //     $('.box-header:eq(1)').hide();
        // }
    });
    // item.trigger('change');
}());