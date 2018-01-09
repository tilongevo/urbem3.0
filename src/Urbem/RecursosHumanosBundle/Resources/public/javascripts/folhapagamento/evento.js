(function ($, global) {
    'use strict';

    function hideBaseFields()
    {
        UrbemSonata.sonataFieldContainerShow("_apresentarContracheque");
        UrbemSonata.sonataFieldContainerHide("_tipo");
        UrbemSonata.sonataFieldContainerHide("_fixado");
        UrbemSonata.sonataFieldContainerHide("_valorQuantidade");
        UrbemSonata.sonataFieldContainerHide("_unidadeQuantitativa");
    }

    function showBaseFields()
    {
        UrbemSonata.sonataFieldContainerHide("_apresentarContracheque");
        UrbemSonata.sonataFieldContainerShow("_tipo");
        UrbemSonata.sonataFieldContainerShow("_fixado");
        UrbemSonata.sonataFieldContainerShow("_valorQuantidade");
        UrbemSonata.sonataFieldContainerShow("_unidadeQuantitativa");
    }

    if ( $("form").find($("#" + UrbemSonata.uniqId + "_codigo")).length > 0 ) {
        UrbemSonata.sonataFieldContainerHide("_apresentarContracheque");
        UrbemSonata.sonataFieldContainerHide("_limiteCalculo");
        UrbemSonata.sonataFieldContainerHide("_apresentaParcela");

        /* Natureza = Informativo */
        $("#" + UrbemSonata.uniqId + "_natureza_2").on('ifChecked', function () {
            UrbemSonata.sonataFieldContainerShow("_apresentarContracheque");
        });

        $("#" + UrbemSonata.uniqId + "_natureza_2").on('ifUnchecked', function () {
            UrbemSonata.sonataFieldContainerHide("_apresentarContracheque");
        });

        if ($("#" + UrbemSonata.uniqId + "_natureza_2").iCheck('update')[0].checked) {
            UrbemSonata.sonataFieldContainerShow("_apresentarContracheque");
        } else {
            UrbemSonata.sonataFieldContainerHide("_apresentarContracheque");
        }

        /* Natureza = Base */
        $("#" + UrbemSonata.uniqId + "_natureza_3").on('ifChecked', function () {
            hideBaseFields();
        });

        $("#" + UrbemSonata.uniqId + "_natureza_3").on('ifUnchecked', function () {
            showBaseFields();
        });

        if ($("#" + UrbemSonata.uniqId + "_natureza_3").iCheck('update')[0].checked) {
            hideBaseFields();
        } else {
            showBaseFields();
        }

        $("#" + UrbemSonata.uniqId + "_tipo_1").on('ifChecked', function () {
            UrbemSonata.sonataFieldContainerShow("_limiteCalculo");
        });

        $("#" + UrbemSonata.uniqId + "_tipo_1").on('ifUnchecked', function () {
            UrbemSonata.sonataFieldContainerHide("_limiteCalculo");
        });

        if ($("#" + UrbemSonata.uniqId + "_tipo_1").iCheck('update')[0].checked) {
            UrbemSonata.sonataFieldContainerShow("_limiteCalculo");
        } else {
            UrbemSonata.sonataFieldContainerHide("_limiteCalculo");
        }

        $("#" + UrbemSonata.uniqId + "_limiteCalculo_1").on('ifChecked', function () {
            UrbemSonata.sonataFieldContainerShow("_apresentaParcela");
        });

        $("#" + UrbemSonata.uniqId + "_limiteCalculo_1").on('ifUnchecked', function () {
            UrbemSonata.sonataFieldContainerHide("_apresentaParcela");
        });

        if ($("#" + UrbemSonata.uniqId + "_limiteCalculo_1").iCheck('update')[0].checked) {
            UrbemSonata.sonataFieldContainerShow("_apresentaParcela");
        } else {
            UrbemSonata.sonataFieldContainerHide("_apresentaParcela");
        }

        $("#" + UrbemSonata.uniqId + "_codigo").mask("99999");

        $("#" + UrbemSonata.uniqId + "_codigo").on("blur", function () {
            $(this).val($(this).val().padStart(5, "0"));
        });
    }

    $("#filter_codigo_value").on("blur", function () {
        $(this).val($(this).val().padStart(5, "0"));
    });

    function consultarDescricaoSequenciaCalculo(source) {
        if (source.val() != '') {
            abreModal('Carregando','Aguarde, carregando descrição da sequencia de calculo');
            $.ajax({
                url: "/recursos-humanos/folha-pagamento/evento/consultar-descricao-sequencia-calculo",
                method: "POST",
                dataType: "json",
                data: {
                    codSequencia: source.val()
                },
                success: function (data) {
                    $("#" + UrbemSonata.uniqId + "_stSequenciaDescricao").html(data.descricao);
                    $("#" + UrbemSonata.uniqId + "_stSequenciaComplemento").html(data.complemento);
                    fechaModal();
                }
            });
        }
    }

    $("#" + UrbemSonata.uniqId + "_codSequencia").on("change", function () {
        consultarDescricaoSequenciaCalculo($(this));
    });

    $("#" + UrbemSonata.uniqId + "_codSequencia").trigger("change");
})(jQuery, window);
