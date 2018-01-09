$(function() {
    // "use strict";

    // Afastamento selecionado
    // exibe:
    // Repetir Mensalmente
    // Movimentação com Retorno
    // Sim
    // *SEFIP Retorno
    // Não
    // Informações sobre o recolhimento do FGTS - Collection

    var tipoMovimentacao = "input[name='" + UrbemSonata.uniqId + "[tipo]']";
    var movimentacaoRetorno = "input[name='" + UrbemSonata.uniqId + "[movimentacaoRetorno]']";

    /**
     * @TODO Resetar dados do form quando mudar opção AFASTAMENTO => SIM/NÃO
     * @param value
     */

    function showHideSefipRetorno(value)
    {
        if (value == 2) { // Não
            UrbemSonata.sonataFieldContainerHide("_fkPessoalMovSefipRetorno");
            UrbemSonata.sonataFieldContainerHide("_repetirMensal");
            UrbemSonata.sonataFieldContainerHide("_movimentacaoRetorno");
            UrbemSonata.sonataFieldContainerHide("_sefipRetorno");
            $(".group-data-sefip-saidas").hide();
            return;
        }

        // Sim
        UrbemSonata.sonataFieldContainerShow("_fkPessoalMovSefipRetorno");
        UrbemSonata.sonataFieldContainerShow("_repetirMensal");
        UrbemSonata.sonataFieldContainerShow("_movimentacaoRetorno");
        UrbemSonata.sonataFieldContainerHide("_sefipRetorno");

        if($(movimentacaoRetorno + ':checked').val() == 2){
            UrbemSonata.sonataFieldContainerHide("_fkPessoalMovSefipRetorno");
        }

        $(".group-data-sefip-saidas").show();
    }

    function showHideMovimentacaoRetorno(value)
    {
        if (value == 1) { // Sim
            $(".group-data-sefip-saidas").hide();
            UrbemSonata.sonataFieldContainerShow("_fkPessoalMovSefipRetorno");
            UrbemSonata.sonataFieldContainerShow("_sefipRetorno");

            return;
        }

        // Nao
        $('.group-data-sefip-saidas').show();
        UrbemSonata.sonataFieldContainerHide("_fkPessoalMovSefipRetorno");
        UrbemSonata.sonataFieldContainerHide("_sefipRetorno");
    }

    $(tipoMovimentacao).on('ifChecked', function() {
        showHideSefipRetorno($(this).val());
    });

    $(movimentacaoRetorno).on('ifChecked', function() {
        showHideMovimentacaoRetorno($(this).val());
    });

    showHideSefipRetorno($(tipoMovimentacao+':checked').val());
    showHideMovimentacaoRetorno($(movimentacaoRetorno+':checked').val());

    if ( ! ( typeof currentRequestId === 'undefined' || !currentRequestId > 0 ) ) {
        // pagina de edicao
        var tipo = $( tipoMovimentacao + ':checked' ).val();
        if ( tipo == 2 ) {
            $(".group-data-sefip-saidas").hide();
        }
    }
});
