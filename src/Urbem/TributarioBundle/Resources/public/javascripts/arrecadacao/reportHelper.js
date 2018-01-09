$(document).ready(function() {

    var contribuinte = $("#" + UrbemSonata.uniqId + "_contribuinte_autocomplete_input");

    contribuinte.on("change", function () {
        contribuinte.val('');
    });
});
