$(document).ready(function() {
    'use strict';

    UrbemSonata.sonataPanelHide("_numUnidade");
    $("#" + UrbemSonata.uniqId + "_numcgm").on("change", function () {
        if ($(this).val() != '') {
            UrbemSonata.sonataPanelShow("_numUnidade");
        } else {
          UrbemSonata.sonataPanelHide("_numUnidade");
        }
    });
}());
