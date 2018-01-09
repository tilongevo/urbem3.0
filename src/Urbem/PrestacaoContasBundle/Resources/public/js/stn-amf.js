$(document).ready(function() {
    var ppaSelect = $("#" + UrbemSonata.uniqId + "_inCodPPATxt");
    var exercicioSelect = $("#" + UrbemSonata.uniqId + "_stExercicio");

    function getIntervalPPA()
    {
        var periodoInicial = 0;
        var periodoFinal = 0;

        var interval = $("#" + UrbemSonata.uniqId + "_inCodPPATxt option:selected").text();
        if (interval != "") {
            var periodo = interval.split(" à ");
            periodoInicial = periodo[0];
            periodoFinal = periodo[1];

            exercicioSelect.empty();
            var selected = "";
            for(var ini = periodoInicial; ini <= periodoFinal; ini++) {
                selected = ini == periodoInicial ? " selected='selected'" : "";

                exercicioSelect.append("<option value='"+ini+"'"+selected+">"+ini+"</option>");
            }

            exercicioSelect.trigger("change");
        }
    }

    // OnLoad
    getIntervalPPA();

    ppaSelect.on("change", function() {
        getIntervalPPA();
    });
});