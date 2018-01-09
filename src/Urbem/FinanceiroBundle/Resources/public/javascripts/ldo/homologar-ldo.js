$(document).ready(function() {
    'use strict';

    var habilitarDesabilitar = function habilitarDesabilitarSelect(target, optionBoolean) {
        target.prop('disabled', optionBoolean);
    };

    var clear = function(select) {
        select.empty().append("<option value=\"\">Selecione</option>").select2("val", "").val('').trigger("change");
    };

    function getExercicioLdo(codPpa, target) {
        if (codPpa != '') {
            $.ajax({
                url: "/financeiro/ldo/homologar-ldo/get-exercicio-ldo-homologado",
                method: "POST",
                data: {
                  codPpa: codPpa
                },
                dataType: "json",
                success: function (data) {
                    habilitarDesabilitar(target, false);
                    for (var i in data) {
                        target.append("<option value=" + i + ">" + data[i] + "</option>");
                    }
                    target.select2("val", "");
                }
            });
        }
    }

    function getVeiculoPublicacaoPorTipo(codTipoVeiculosPublicidade, target) {
        if (codTipoVeiculosPublicidade != '') {
            $.ajax({
                url: "/financeiro/ldo/homologar-ldo/get-veiculo-publicacao-tipo",
                method: "POST",
                data: {
                  codTipoVeiculosPublicidade: codTipoVeiculosPublicidade
                },
                dataType: "json",
                success: function (data) {
                    target.attr('required', true);
                    habilitarDesabilitar(target, false);
                    for (var i in data) {
                        target.append("<option value=" + i + ">" + data[i] + "</option>");
                    }
                    target.select2("val", "");
                }
            });
        }
    }

    $("#" + UrbemSonata.uniqId + "_codPpa").on("change", function () {
        habilitarDesabilitar($("#" + UrbemSonata.uniqId + "_ano"), true);
        clear($("#" + UrbemSonata.uniqId + "_ano"));
        getExercicioLdo($(this).val(), $("#" + UrbemSonata.uniqId + "_ano"));
    });

    $("#" + UrbemSonata.uniqId + "_codTipoVeiculosPublicidade").on("change", function () {
        habilitarDesabilitar($("#" + UrbemSonata.uniqId + "_fkLicitacaoVeiculosPublicidade"), true);
        clear($("#" + UrbemSonata.uniqId + "_fkLicitacaoVeiculosPublicidade"));
        getVeiculoPublicacaoPorTipo($(this).val(), $("#" + UrbemSonata.uniqId + "_fkLicitacaoVeiculosPublicidade"));
    });

    UrbemSonata.sonataPanelHide("_dtEncaminhamento");
    $("#" + UrbemSonata.uniqId + "_ano").on("change", function () {
        if ($(this).val() != '') {
            UrbemSonata.sonataPanelShow("_dtEncaminhamento");
        } else {
          UrbemSonata.sonataPanelHide("_dtEncaminhamento");
        }
    });
}());
