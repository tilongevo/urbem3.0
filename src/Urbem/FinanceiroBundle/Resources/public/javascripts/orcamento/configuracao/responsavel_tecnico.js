$(document).ready(function() {
    'use strict';

    UrbemSonata.sonataFieldContainerHide("_classeConselho");
    $('#' + UrbemSonata.uniqId + '_classeConselho').attr('disabled', true);

    $("#" + UrbemSonata.uniqId + "_codProfissao").on('change', function() {
        UrbemSonata.sonataFieldContainerShow("_classeConselho");
    });
}());
