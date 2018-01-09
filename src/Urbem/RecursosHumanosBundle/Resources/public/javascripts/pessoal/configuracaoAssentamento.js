(function($){
    jQuery(function () {
        'use strict';
        
        window.varJsCodTipoNorma = jQuery("#" + UrbemSonata.uniqId + "_codTipoNorma").val();
        jQuery("#" + UrbemSonata.uniqId + "_codTipoNorma").on("change", function() {
            window.varJsCodTipoNorma = jQuery(this).val();
        });
        
        UrbemSonata.sonataFieldContainerHide("_assentamentoEvento");
        UrbemSonata.sonataFieldContainerHide("_assentamentoEventoProporcional");
        
        jQuery("#" + UrbemSonata.uniqId + "_eventoAutomatico").on('ifChecked', function () {
            UrbemSonata.sonataFieldContainerShow("_assentamentoEvento", true);
        });
        
        jQuery("#" + UrbemSonata.uniqId + "_informarEventosProporcionalizacao").on('ifChecked', function () {
            UrbemSonata.sonataFieldContainerShow("_assentamentoEventoProporcional", true);
        });
        
        jQuery("#" + UrbemSonata.uniqId + "_eventoAutomatico").on('ifUnchecked', function () {
            UrbemSonata.sonataFieldContainerHide("_assentamentoEvento");
        });
        
        jQuery("#" + UrbemSonata.uniqId + "_informarEventosProporcionalizacao").on('ifUnchecked', function () {
            UrbemSonata.sonataFieldContainerHide("_assentamentoEventoProporcional");
        });

        if (typeof(jQuery("#" + UrbemSonata.uniqId + "_eventoAutomatico").iCheck('update').checked) !== "undefined") {
            if (jQuery("#" + UrbemSonata.uniqId + "_eventoAutomatico").iCheck('update')[0].checked) {
                UrbemSonata.sonataFieldContainerShow("_assentamentoEvento");
            }
        }
        
        if (typeof(jQuery("#" + UrbemSonata.uniqId + "_informarEventosProporcionalizacao").iCheck('update').checked) !== "undefined") {
            if (jQuery("#" + UrbemSonata.uniqId + "_informarEventosProporcionalizacao").iCheck('update')[0].checked) {
                UrbemSonata.sonataFieldContainerShow("_assentamentoEventoProporcional");
            }
        }
        
        jQuery("#" + UrbemSonata.uniqId + "_codEsfera").on("change", function () {
            if (jQuery(this).val() != 3) {
                jQuery("#" + UrbemSonata.uniqId + "_fkPessoalAssentamentoOperador").val("1").trigger("change").attr("disabled", true);
            } else {
                jQuery("#" + UrbemSonata.uniqId + "_fkPessoalAssentamentoOperador").removeAttr("disabled");
            }
        });
        
        jQuery("#" + UrbemSonata.uniqId + "_codNorma_autocomplete_input").on("change", function() {
            jQuery.ajax({
              url: "/recursos-humanos/concurso/selecionar-norma/" + jQuery(this).val(),
              method: "GET",
              dataType: "json",
              success: function (data) {
                jQuery("#" + UrbemSonata.uniqId + "_dtPublicacao")
                    .val(data["dtPublicacao"]);
              }
            });
        });
        
        jQuery(document).ready(function() {
            jQuery("#" + UrbemSonata.uniqId + "_fkPessoalAssentamentoMotivo").trigger("change");
        });
        
        jQuery("#" + UrbemSonata.uniqId + "_fkPessoalAssentamentoMotivo").on("change", function() {
            switch (jQuery(this).val()) {
                case "5":
                case "6":
                    UrbemSonata.sonataFieldContainerShow("_quantDiasOnusEmpregador");
                    UrbemSonata.sonataFieldContainerHide("_quantDiasLicencaPremio");
                    jQuery("#" + UrbemSonata.uniqId + "_quantDiasLicencaPremio").val("");
                    break;
                case "9":
                    UrbemSonata.sonataFieldContainerShow("_quantDiasLicencaPremio");
                    UrbemSonata.sonataFieldContainerHide("_quantDiasOnusEmpregador");
                    jQuery("#" + UrbemSonata.uniqId + "_quantDiasOnusEmpregador").val("");
                    break;
                default:
                    UrbemSonata.sonataFieldContainerHide("_quantDiasOnusEmpregador");
                    UrbemSonata.sonataFieldContainerHide("_quantDiasLicencaPremio");
            }
        });
    })
}());
