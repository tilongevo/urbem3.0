$(document).ready(function() {
    'use strict';

    var QueryString = function () {
        // This function is anonymous, is executed immediately and
        // the return value is assigned to QueryString!
        var query_string = {};
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            // If first entry with this name
            if (typeof query_string[pair[0]] === "undefined") {
                query_string[pair[0]] = decodeURIComponent(pair[1]);
                // If second entry with this name
            } else if (typeof query_string[pair[0]] === "string") {
                var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
                query_string[pair[0]] = arr;
                // If third or later entry with this name
            } else {
                query_string[pair[0]].push(decodeURIComponent(pair[1]));
            }
        }
        return query_string;
    }();

    var clear = function(select) {
        select.empty().append("<option value=\"\">Selecione</option>").select2("val", "").val('').trigger("change");
    };

    var habilitarDesabilitar = function habilitarDesabilitarSelect(target, optionBoolean) {
        target.prop('disabled', optionBoolean);
    };

    function getMacroObjetivo(codPpa, target) {
        clear(target);
        $.ajax({
            url: "/financeiro/plano-plurianual/programa-setorial/get-macro-objetivo",
            method: "POST",
            data: {
              codPpa: codPpa
            },
            dataType: "json",
            success: function (data) {
                habilitarDesabilitar(target, false);
                var selected = "";
                for (var i in data) {
                    if (QueryString['filter%5BcodMacro%5D%5Bvalue%5D']) {
                        target
                            .append("<option value=" + i + "  " + selected + ">" + data[i] + "</option>");
                        if (i == QueryString['filter%5BcodMacro%5D%5Bvalue%5D']) {
                            target.val(i).trigger("change");
                        }
                    } else {
                        target
                            .append("<option value=" + i + " " + selected + ">" + data[i] + "</option>");
                        if (i == $("#" + UrbemSonata.uniqId + "_inCodMacro").val()) {
                            target.val(i).trigger("change");
                        }
                    }
                }
            }
        });
    }

    if ($("#filter_codPpa_value").val() == '') {
        clear($("#filter_codMacro_value"));
        habilitarDesabilitar($("#filter_codMacro_value"), true);
    } else {
        getMacroObjetivo($("#filter_codPpa_value").val(), $("#filter_codMacro_value"))
    }

    $("#" + UrbemSonata.uniqId + "_codPpa").on("change", function () {
        clear($("#" + UrbemSonata.uniqId + "_fkPpaMacroObjetivo"));
        habilitarDesabilitar($("#" + UrbemSonata.uniqId + "_fkPpaMacroObjetivo"), true);
        getMacroObjetivo($(this).val(), $("#" + UrbemSonata.uniqId + "_fkPpaMacroObjetivo"))
    });

    $("#filter_codPpa_value").on("change", function () {
        clear($("#filter_codMacro_value"));
        habilitarDesabilitar($("#filter_codMacro_value"), true);
        getMacroObjetivo($(this).val(), $("#filter_codMacro_value"))
    });

    if ($("#" + UrbemSonata.uniqId + "_codPpa").val() != "") {
        getMacroObjetivo($("#" + UrbemSonata.uniqId + "_codPpa").val(), $("#" + UrbemSonata.uniqId + "_fkPpaMacroObjetivo"));
    }
    $("#" + UrbemSonata.uniqId + "_codPpa").prop('required',true);
    $("#" + UrbemSonata.uniqId + "_fkPpaMacroObjetivo").prop('required',true);

}());
