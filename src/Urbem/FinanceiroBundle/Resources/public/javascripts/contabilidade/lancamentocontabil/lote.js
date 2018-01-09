$(document).ready(function() {
    'use strict';

    var formAction = $('form').prop("action"),
        regexLote = /(\/financeiro\/contabilidade\/lancamento-contabil\/create)/g;

    function carregaCodLote(codEntidade, exercicio, tipo) {
        $.ajax({
            url: "/financeiro/contabilidade/lancamento-contabil/consultar-cod-lote",
            method: "POST",
            data: {codEntidade: codEntidade, exercicio: exercicio, tipo: tipo},
            dataType: "json",
            success: function (data) {
                UrbemSonata.giveMeBackMyField('codLote').val(data)
            }
        });
    }

    if (regexLote.test(formAction)) {
        if (UrbemSonata.giveMeBackMyField('fkOrcamentoEntidade').val() != '') {
            carregaCodLote(
                UrbemSonata.giveMeBackMyField('fkOrcamentoEntidade').val(),
                UrbemSonata.giveMeBackMyField('exercicio').val(),
                UrbemSonata.giveMeBackMyField('tipo').val()
            );
        }
        UrbemSonata.giveMeBackMyField('fkOrcamentoEntidade').on('change', function () {
            carregaCodLote(
                $(this).val(),
                UrbemSonata.giveMeBackMyField('exercicio').val(),
                UrbemSonata.giveMeBackMyField('tipo').val()
            );
        });
    }

    $('.lote-assinaturas').hide();
    $('#lote_incluirAssinaturas_1').on( "click", function (){
        $('.lote-assinaturas').show();
    });
    $('#lote_incluirAssinaturas_0').on( "click", function (){
        $('.lote-assinaturas').hide();
    });
}());