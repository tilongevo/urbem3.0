$(document).ready(function() {
    'use strict';
    $("#" + UrbemSonata.uniqId + "_boNatureza").attr('class', 'help-check-programa-ppa ');

    function getMacroObjetivo(inCodPPA, target) {
        $.ajax({
            url: "/financeiro/plano-plurianual/programa/get-macro-objetivo",
            method: "POST",
            data: {
              inCodPPA: inCodPPA
            },
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_inCodMacroObjetivo").prop('disabled', false);
                target
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                for (var i in data) {
                    target.append("<option value=" + i + ">" + data[i] + "</option>");
                    if (i == $("#" + UrbemSonata.uniqId + "_inCodMacroObjetivo").val()) {
                        target.val(i).trigger("change");
                    }
                }
            }
        });
    }

    function getProgramaSetorial(inCodMacroObjetivo, target) {

        $.ajax({
            url: "/financeiro/plano-plurianual/programa/get-programa-setorial",
            method: "POST",
            data: {
              inCodMacroObjetivo: inCodMacroObjetivo
            },
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_codSetorial").prop('disabled', false);
                target
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                var selected = "";
                for (var i in data) {
                    target.append("<option value=" + i + " " + selected + ">" + data[i] + "</option>");
                    if (i == $("#" + UrbemSonata.uniqId + "_codSetorial").val()) {
                        target.val(i).trigger("change");
                    }
                }
            }
        });
    }

    if (!$('#' + UrbemSonata.uniqId + '_inCodOrgao').val()) {
        $('#' + UrbemSonata.uniqId + '_inCodUnidade').empty();
        $('#' + UrbemSonata.uniqId + '_inCodUnidade').attr('disabled', true);
    }

    function getUnidadeByOrgao(codOrgao, exercicio, target)
    {
        $('#' + UrbemSonata.uniqId + '_inCodUnidade').attr('disabled', true);
      $.ajax({
          url: "/financeiro/plano-plurianual/programa/get-unidade-orgao",
          method: "POST",
          data: {
              codOrgao: codOrgao,
              exercicio: exercicio
          },
          dataType: "json",
          success: function (data) {
              $("#" + UrbemSonata.uniqId + "_inCodUnidade").prop('disabled', false);
              target
              .empty()
              .append("<option value=\"\">Selecione</option>");

              var selected = "";
              for (var i in data) {
                  target.append("<option value=" + i + " " + selected + ">" + i + ' - ' + data[i] + "</option>");
              }
              $('#' + UrbemSonata.uniqId + '_inCodUnidade').attr('disabled', false);
              $('#' + UrbemSonata.uniqId + '_inCodUnidade').select2('val', selected);
          }
      });
    }

    $("#" + UrbemSonata.uniqId + "_numPrograma").on("change", function () {
        $(".alert_error_" + UrbemSonata.uniqId).remove();
        $("#" + UrbemSonata.uniqId + "_numPrograma").parent().removeClass('sonata-ba-field-error');
        $.ajax({
            url: "/financeiro/plano-plurianual/programa/get-number-programa",
            method: "GET",
            data: {
                numPrograma: $(this).val()
            },
            dataType: "json",
            success: function (data)
            {
                if (!data) {
                    var message = null;

                    $("#" + UrbemSonata.uniqId + "_numPrograma").parent().addClass('sonata-ba-field-error');
                    message =
                            '<div class="help-block sonata-ba-field-error-messages alert_error_' + UrbemSonata.uniqId + '"> ' +
                                '<ul class="list-unstyled">' +
                                    '<li><i class="fa fa-exclamation-circle"></i> Número de programa não disponível.</li> ' +
                                '</ul> ' +
                            '</div>';
                    $("#" + UrbemSonata.uniqId + "_numPrograma").parent().append(message);
                    return;
                }
            }
        });
    });

    $( "form" ).submit(function( event ) {
        console.info($("#" + UrbemSonata.uniqId + "_numPrograma").parent().hasClass("sonata-ba-field-error"));
        if( $("#" + UrbemSonata.uniqId + "_numPrograma").parent().hasClass("sonata-ba-field-error") ) {
            $("#" + UrbemSonata.uniqId + "_numPrograma").focus();
            return false;
        }
    });

    $("#" + UrbemSonata.uniqId + "_inCodPPA").on("change", function () {
        desabilitarInCodMacroObjetivo();
        desabilitarCodSetorial();
        getMacroObjetivo($(this).val(), $("#" + UrbemSonata.uniqId + "_inCodMacroObjetivo"))
    });

    $("#" + UrbemSonata.uniqId + "_inCodMacroObjetivo").on("change", function () {
        desabilitarCodSetorial();
        getProgramaSetorial($(this).val(), $("#" + UrbemSonata.uniqId + "_codSetorial"))
    });

    $("#" + UrbemSonata.uniqId + "_inCodOrgao").on("change", function () {
        $("#" + UrbemSonata.uniqId + "_inCodUnidade").prop('disabled', true);
        $("#" + UrbemSonata.uniqId + "_inCodUnidade").empty().append("<option value=\"\">Selecione</option>");
        $("#s2id_" + UrbemSonata.uniqId + "_inCodUnidade .select2-chosen").text('');
        getUnidadeByOrgao($(this).val(), $("#" + UrbemSonata.uniqId + "_exercicio").val(), $("#" + UrbemSonata.uniqId + "_inCodUnidade"))
    });

    if ($("#" + UrbemSonata.uniqId + "_boNatureza_1").iCheck('update')[0].checked) {
        UrbemSonata.sonataFieldContainerShow("_stDataInicial");
        UrbemSonata.sonataFieldContainerShow("_stDataFinal");

    } else {
        UrbemSonata.sonataFieldContainerHide("_stDataInicial");
        UrbemSonata.sonataFieldContainerHide("_stDataFinal");
    }

    $("#" + UrbemSonata.uniqId + "_boNatureza_1").on('ifChecked', function () {
        UrbemSonata.sonataFieldContainerShow("_stDataInicial");
        UrbemSonata.sonataFieldContainerShow("_stDataFinal");
    });

    $("#" + UrbemSonata.uniqId + "_boNatureza_1").on('ifUnchecked', function () {
        UrbemSonata.sonataFieldContainerHide("_stDataInicial");
        UrbemSonata.sonataFieldContainerHide("_stDataFinal");
    });
    function desabilitarInCodMacroObjetivo() {
        $("#" + UrbemSonata.uniqId + "_inCodMacroObjetivo").prop('disabled', true);
        $("#" + UrbemSonata.uniqId + "_inCodMacroObjetivo").empty().append("<option value=\"\">Selecione</option>");
        $("#s2id_" + UrbemSonata.uniqId + "_inCodMacroObjetivo .select2-chosen").text('');
    }
    function desabilitarCodSetorial() {
        $("#" + UrbemSonata.uniqId + "_codSetorial").prop('disabled', true);
        $("#" + UrbemSonata.uniqId + "_codSetorial").empty().append("<option value=\"\">Selecione</option>");
        $("#s2id_" + UrbemSonata.uniqId + "_codSetorial .select2-chosen").text('');
    }

}());
