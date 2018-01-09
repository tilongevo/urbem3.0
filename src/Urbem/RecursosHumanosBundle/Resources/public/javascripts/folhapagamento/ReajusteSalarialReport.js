(function(){
    'use strict';

    UrbemSonata.sonataFieldContainerHide("_matricula");
    UrbemSonata.sonataFieldContainerHide("_matriculaCgm");
    UrbemSonata.sonataFieldContainerHide("_lotacao");
    UrbemSonata.sonataFieldContainerHide("_local");
    UrbemSonata.sonataFieldContainerHide("_atributoDinamicoServidor");
    UrbemSonata.sonataFieldContainerHide("_atributoDinamicoPensionista");
    UrbemSonata.sonataFieldContainerHide("_regime");
    UrbemSonata.sonataFieldContainerHide("_subdivisao");
    UrbemSonata.sonataFieldContainerHide("_funcao");
    UrbemSonata.sonataFieldContainerHide("_especialidade");
    UrbemSonata.sonataFieldContainerHide("_padrao");
    UrbemSonata.sonataFieldContainerHide("_evento");
    UrbemSonata.sonataFieldContainerHide("_tipoCalculo");
    UrbemSonata.sonataFieldContainerHide("_reajustePercentualValor");
    UrbemSonata.sonataFieldContainerHide("_valor");

    $("#" + UrbemSonata.uniqId + "_filtrar").on("change", function() {
        var opcao = $(this).val();

        if (opcao == 'contrato') {
            UrbemSonata.sonataFieldContainerShow("_matricula");
            UrbemSonata.sonataFieldContainerHide("_matriculaCgm");
            UrbemSonata.sonataFieldContainerHide("_lotacao");
            UrbemSonata.sonataFieldContainerHide("_local");
            UrbemSonata.sonataFieldContainerHide("_atributoDinamicoServidor");
            UrbemSonata.sonataFieldContainerHide("_atributoDinamicoPensionista");
            UrbemSonata.sonataFieldContainerHide("_regime");
            UrbemSonata.sonataFieldContainerHide("_subdivisao");
            UrbemSonata.sonataFieldContainerHide("_funcao");
            UrbemSonata.sonataFieldContainerHide("_especialidade");
        }
        if (opcao == 'cgm_contrato') {
            UrbemSonata.sonataFieldContainerShow("_matricula");
            UrbemSonata.sonataFieldContainerShow("_matriculaCgm");
            UrbemSonata.sonataFieldContainerHide("_lotacao");
            UrbemSonata.sonataFieldContainerHide("_local");
            UrbemSonata.sonataFieldContainerHide("_atributoDinamicoServidor");
            UrbemSonata.sonataFieldContainerHide("_atributoDinamicoPensionista");
            UrbemSonata.sonataFieldContainerHide("_regime");
            UrbemSonata.sonataFieldContainerHide("_subdivisao");
            UrbemSonata.sonataFieldContainerHide("_funcao");
            UrbemSonata.sonataFieldContainerHide("_especialidade");
        }
        if (opcao == 'lotacao') {
            UrbemSonata.sonataFieldContainerShow("_lotacao");
            UrbemSonata.sonataFieldContainerHide("_matriculaCgm");
            UrbemSonata.sonataFieldContainerHide("_matricula");
            UrbemSonata.sonataFieldContainerHide("_local");
            UrbemSonata.sonataFieldContainerHide("_atributoDinamicoServidor");
            UrbemSonata.sonataFieldContainerHide("_atributoDinamicoPensionista");
            UrbemSonata.sonataFieldContainerHide("_regime");
            UrbemSonata.sonataFieldContainerHide("_subdivisao");
            UrbemSonata.sonataFieldContainerHide("_funcao");
            UrbemSonata.sonataFieldContainerHide("_especialidade");
        }
        if (opcao == 'local') {
            UrbemSonata.sonataFieldContainerShow("_local");
            UrbemSonata.sonataFieldContainerHide("_matriculaCgm");
            UrbemSonata.sonataFieldContainerHide("_matricula");
            UrbemSonata.sonataFieldContainerHide("_lotacao");
            UrbemSonata.sonataFieldContainerHide("_atributoDinamicoServidor");
            UrbemSonata.sonataFieldContainerHide("_atributoDinamicoPensionista");
            UrbemSonata.sonataFieldContainerHide("_regime");
            UrbemSonata.sonataFieldContainerHide("_subdivisao");
            UrbemSonata.sonataFieldContainerHide("_funcao");
            UrbemSonata.sonataFieldContainerHide("_especialidade");
        }
        if (opcao == 'atributo_servidor') {
            UrbemSonata.sonataFieldContainerShow("_atributoDinamicoServidor");
            UrbemSonata.sonataFieldContainerHide("_matriculaCgm");
            UrbemSonata.sonataFieldContainerHide("_matricula");
            UrbemSonata.sonataFieldContainerHide("_lotacao");
            UrbemSonata.sonataFieldContainerHide("_local");
            UrbemSonata.sonataFieldContainerHide("_atributoDinamicoPensionista");
            UrbemSonata.sonataFieldContainerHide("_regime");
            UrbemSonata.sonataFieldContainerHide("_subdivisao");
            UrbemSonata.sonataFieldContainerHide("_funcao");
            UrbemSonata.sonataFieldContainerHide("_especialidade");
        }
        if (opcao == 'atributo_pensionista') {
            UrbemSonata.sonataFieldContainerShow("_atributoDinamicoPensionista");
            UrbemSonata.sonataFieldContainerHide("_matriculaCgm");
            UrbemSonata.sonataFieldContainerHide("_matricula");
            UrbemSonata.sonataFieldContainerHide("_lotacao");
            UrbemSonata.sonataFieldContainerHide("_local");
            UrbemSonata.sonataFieldContainerHide("_atributoDinamicoServidor");
            UrbemSonata.sonataFieldContainerHide("_regime");
            UrbemSonata.sonataFieldContainerHide("_subdivisao");
            UrbemSonata.sonataFieldContainerHide("_funcao");
            UrbemSonata.sonataFieldContainerHide("_especialidade");
        }
        if (opcao == 'reg_sub_fun_esp') {
            UrbemSonata.sonataFieldContainerShow("_regime");
            UrbemSonata.sonataFieldContainerShow("_subdivisao");
            UrbemSonata.sonataFieldContainerShow("_funcao");
            UrbemSonata.sonataFieldContainerShow("_especialidade");
            UrbemSonata.sonataFieldContainerHide("_lotacao");
            UrbemSonata.sonataFieldContainerHide("_local");
            UrbemSonata.sonataFieldContainerHide("_atributoDinamicoServidor");
            UrbemSonata.sonataFieldContainerHide("_atributoDinamicoPensionista");
        }
        if (opcao == 'geral') {
            UrbemSonata.sonataFieldContainerHide("_matricula");
            UrbemSonata.sonataFieldContainerHide("_matriculaCgm");
            UrbemSonata.sonataFieldContainerHide("_lotacao");
            UrbemSonata.sonataFieldContainerHide("_local");
            UrbemSonata.sonataFieldContainerHide("_atributoDinamicoServidor");
            UrbemSonata.sonataFieldContainerHide("_atributoDinamicoPensionista");
            UrbemSonata.sonataFieldContainerHide("_regime");
            UrbemSonata.sonataFieldContainerHide("_subdivisao");
            UrbemSonata.sonataFieldContainerHide("_funcao");
            UrbemSonata.sonataFieldContainerHide("_especialidade");
        }
    });

    $("#" + UrbemSonata.uniqId + "_valoresReajustar").on("change", function() {
        var opcaovalorreajustar = $(this).val();
        console.log(opcaovalorreajustar);

        if (opcaovalorreajustar == 'p') {
            UrbemSonata.sonataFieldContainerShow("_padrao");
            UrbemSonata.sonataFieldContainerHide("_evento");
            UrbemSonata.sonataFieldContainerHide("_tipoCalculo");
        }
        if (opcaovalorreajustar == 'e') {
            UrbemSonata.sonataFieldContainerShow("_evento");
            UrbemSonata.sonataFieldContainerShow("_tipoCalculo");
            UrbemSonata.sonataFieldContainerHide("_padrao");
        }

    });

    $("#" + UrbemSonata.uniqId + "_tiporeajuste").on("change", function() {
        var opcaovalor = $(this).val();
        console.log(opcaovalor);

        if (opcaovalor == 'p') {
            UrbemSonata.sonataFieldContainerShow("_reajustePercentualValor");
            UrbemSonata.sonataFieldContainerHide("_valor");
        }
        if (opcaovalor == 'v') {
            UrbemSonata.sonataFieldContainerShow("_valor");
            UrbemSonata.sonataFieldContainerHide("_reajustePercentualValor");
        }

    });

}());


