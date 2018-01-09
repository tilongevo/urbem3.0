(function(){
    'use strict';

    if (! UrbemSonata.checkModule('rais')) {
        return;
    }
    
    var unique_id = $('meta[name="uniqid"]').attr('content'),
        ceiVinculado = $('#' + unique_id + '_ceiVinculado');

    if (ceiVinculado.is(':checked')) {
        UrbemSonata.sonataFieldContainerShow('_prefixo');
        UrbemSonata.sonataFieldContainerShow('_numeroCei');
    } else {
        UrbemSonata.sonataFieldContainerHide('_prefixo');
        UrbemSonata.sonataFieldContainerHide('_numeroCei');
    }

    ceiVinculado.on('ifChecked', function() {
        UrbemSonata.sonataFieldContainerShow('_prefixo');
        UrbemSonata.sonataFieldContainerShow('_numeroCei');
    });

    ceiVinculado.on('ifUnchecked', function() {
        UrbemSonata.sonataFieldContainerHide('_prefixo');
        UrbemSonata.sonataFieldContainerHide('_numeroCei');
    });
}());