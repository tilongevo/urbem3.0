$(document).ready(function() {
    'use strict';

    var clear = function(select) {
        select.empty().append("<option value=\"\">Selecione</option>").select2("val", "").val('').trigger("change");
    };

    var habilitarDesabilitar = function (target, optionBoolean) {
        target.prop('disabled', optionBoolean);
    };

    var clearDadosEmpenho = function () {

        var ids = [
            '_codDespesa',
            '_codClassificacao',
            '_saldoDotacao',
            '_numOrgao',
            '_numUnidade',
            '_cgmBeneficiario',
            '_codCategoria',
            '_dtEmpenho',
            '_dtValidadeFinal',
            '_descricao',
            '_codHistorico'
        ];

        ids.forEach(function(element, index, array){
            $("#" + UrbemSonata.uniqId + element).val("");
        });
    };

    function getEmpenhoOriginal() {
        var
        codEntidade = $("#" + UrbemSonata.uniqId + "_codEntidade").val(),
        exercicio = $("#" + UrbemSonata.uniqId + "_exercicio").val(),
        codEmpenhoInicial = $("#" + UrbemSonata.uniqId + "_codEmpenhoInicial").val(),
        codEmpenhoFinal = $("#" + UrbemSonata.uniqId + "_codEmpenhoFinal").val(),
        periodoInicial = $("#" + UrbemSonata.uniqId + "_periodoInicial").val(),
        periodoFinal = $("#" + UrbemSonata.uniqId + "_periodoFinal").val();
        
        if ( codEntidade === "") {
            return;
        }
        
        if ( isNaN( parseInt( codEmpenhoInicial ) ) ) {
            return;
        }
        
        if ( isNaN( parseInt( codEmpenhoFinal ) ) ) {
            return;
        }
        
        if ( periodoInicial === "" ) {
            return;
        }
        
        if ( periodoFinal === "" ) {
            return;
        }

        habilitarDesabilitar($("#" + UrbemSonata.uniqId + "_codEmpenho"), true);
        clear($("#" + UrbemSonata.uniqId + "_codEmpenho"));
        clearDadosEmpenho();
        $.ajax({
            url: "/financeiro/empenho/emitir-empenho-complementar/get-empenho-original",
            method: "POST",
            data: {
                codEntidade: codEntidade,
                exercicio: exercicio,
                codEmpenhoInicial: codEmpenhoInicial,
                codEmpenhoFinal: codEmpenhoFinal,
                periodoInicial: periodoInicial,
                periodoFinal: periodoFinal
            },
            dataType: "json",
            success: function ( data ) {
                habilitarDesabilitar($("#" + UrbemSonata.uniqId + "_codEmpenho"), false);
                for (var i in data) {
                    $("#" + UrbemSonata.uniqId + "_codEmpenho").append("<option value=" + i + ">" + data[i] + "</option>");
                }
            }
        });
    }
    
    function getInformacaoEmpenhoOriginal() {
        var
        codEmpenho = $("#" + UrbemSonata.uniqId + "_codEmpenho").val(),
        codEntidade = $("#" + UrbemSonata.uniqId + "_codEntidade").val(),
        exercicio = $("#" + UrbemSonata.uniqId + "_exercicio").val();
        
        if ( codEmpenho === "" ) {
            return;
        }
        
        if ( codEntidade === "" ) {
            return;
        }
        clearDadosEmpenho();
        $.ajax({
            url: "/financeiro/empenho/emitir-empenho-complementar/get-informacao-empenho-original",
            method: "POST",
            data: {
                codEmpenho: codEmpenho,
                codEntidade: codEntidade,
                exercicio: exercicio,
            },
            dataType: "json",
            success: function ( data ) {
                for ( var field in data ) {
                    var fieldNameId = "#" + UrbemSonata.uniqId + "_" + field;
                    if ( $(fieldNameId).is("SELECT") ) {
                        $(fieldNameId).val(data[field]).trigger("change");
                    } else {
                        $(fieldNameId).val(data[field]);
                    }
                }
            }
        });
    }
    
    $(".filtro-empenho-complementar").on("blur change", function () {
        getEmpenhoOriginal();
    });
    
    $("#" + UrbemSonata.uniqId + "_codEmpenho").on("change", function() {
        getInformacaoEmpenhoOriginal();
    });
}());
