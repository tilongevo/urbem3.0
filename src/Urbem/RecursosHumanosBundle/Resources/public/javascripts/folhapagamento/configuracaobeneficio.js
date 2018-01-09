$(function () {
    "use strict";

    var backupAutocompleteList = {},
        backupTextoComplementarList = {}
    ;

    function getTextoComplementar(source, target) {
        if (source.val() != '') {
            abreModal('Carregando','Aguarde, carregando texto complementar');
            $.ajax({
                url: "/recursos-humanos/folha-pagamento/configuracao-beneficio/get-texto-complementar",
                method: "POST",
                dataType: "json",
                data: {
                    codEvento: source.val()
                },
                success: function (data) {
                    target.val(data);
                    fechaModal();
                }
            });
        }
    }

    $("#" + UrbemSonata.uniqId + "_codEventoValeTransporte").on("change", function() {
        getTextoComplementar($(this), $("#" + UrbemSonata.uniqId + "_textoComplementarValeTransporte"));
    });

    $('select:regex(id, (_\\d+_fkFolhapagamentoEvento))').each(function (index, value) {
        $(this).on("change", function () {
            var textoComplementar = "#" + UrbemSonata.uniqId + "_fkFolhapagamentoBeneficioEventos_" + index + "_textoComplementar";
            getTextoComplementar($(this), $(textoComplementar));
        });
    });

    $(document).on('click', '.load-more', function () {
        $('input.select2-parameters:regex(id, (_\\d+_\\w+_autocomplete_input))').each(function (index, value) {
            if ($(this).select2('data') !== null) {
              backupAutocompleteList[$(this).attr('id')] = {
                "id": $(this).select2('data').id,
                "label": $(this).select2('data').label
              };
            }
        });

        $('input:regex(id, (_\\d+_textoComplementar))').each(function (index, value) {
            backupTextoComplementarList[$(this).attr('id')] = {
                "value": $(this).val()
            };
        });
    });

    $(document).on('sonata.add_element', function() {
        for (var i in backupAutocompleteList) {
          $("#" + i).select2('data', {
              id: backupAutocompleteList[i].id,
              label: backupAutocompleteList[i].label
          });

          var inputHidden = $("#" + i).next().attr("id");

          $("#" + inputHidden + " input:hidden").val(backupAutocompleteList[i].id);
          $("#" + i).next().first().trigger("change");
        }

        for (var i in backupTextoComplementarList) {
          $("#" + i).val(backupTextoComplementarList[i].value);
        }

        $('select:regex(id, (_\\d+_fkFolhapagamentoEvento))').each(function (index, value) {
            $(this).on("change", function () {
                var textoComplementar = "#" + UrbemSonata.uniqId + "_fkFolhapagamentoBeneficioEventos_" + index + "_textoComplementar";
                getTextoComplementar($(this), $(textoComplementar));
            });
        });
    });
}());
