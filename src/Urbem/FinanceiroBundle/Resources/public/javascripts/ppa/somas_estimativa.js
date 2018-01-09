var CONFIG_SOMA = (function() {
    var private = {
        'CLASS_ROW': ".table-estimativa .row-estimativa",
        'CLASS_ROW_NUMERO': ".row-",
        'ID_INPUT': '#valor_',
        'VALOR_TOTAL': jQuery('#valorTotal'),
        'ID_VALOR_SOMA': '#td-resultado-soma-',
        'GRUPO_1': {'g1' : [1, 2, 3, 4]},
        'GRUPO_2': {'g2' : [5, 6, 7]},
        'GRUPO_3': {'g3' : [8, 9]},
        'GRUPO_4': {'g4' : [10, 11]},
        'GRUPO_5': {'g5' : [12, 13, 14, 15, 16, 17, 18]},
        'GRUPO_6': {'g6' : [20, 21, 22, 23, 24]},
        'INIT_FORMAT_VALORES': [5, 6, 7, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 20, 21, 22, 23, 24, 25]
    };
    return {
        get: function(name) { return private[name]; }
    };
})();


//Busca o input por um determinado id
function buildIdSelectEstimativaPorNumero(numero) {
    return jQuery(CONFIG_SOMA.get('CLASS_ROW') + CONFIG_SOMA.get('CLASS_ROW_NUMERO') + numero).find(CONFIG_SOMA.get('ID_INPUT') + numero);
}

//Busca a tag p por um determinado id
function buildIdPValorSoma(numero) {
    return jQuery(CONFIG_SOMA.get('CLASS_ROW') + CONFIG_SOMA.get('CLASS_ROW_NUMERO') + numero).find(CONFIG_SOMA.get('ID_VALOR_SOMA') + numero);
}

//Add classe para um determinado grupo de input
//Retorna o nome do grupo
function addClassGroupInput(grupo) {
    for (var prop in CONFIG_SOMA.get(grupo)) {
        for (var i = 0; i < CONFIG_SOMA.get(grupo)[prop].length; i++) {
           buildIdSelectEstimativaPorNumero(CONFIG_SOMA.get(grupo)[prop][i]).addClass(prop);
        }
        return prop;
    }
}

//atribui um zero para um determinado tag p
function clearPvalorSoma(numero) {
    buildIdPValorSoma(numero).text(0);
}

//adiciona em uma determinada tag p um valor
function addValuePValorSoma(numeroPValor, valorInput) {
    if (valorInput) {
        var res = valorInput.replaceAll(".", "");
        res = res.replaceAll(",",".");
        for (var i = 0; i < numeroPValor.length; i++) {
            var valorColunas = buildIdPValorSoma(numeroPValor[i]).text().replaceAll(".", "").replaceAll(",",".");
            var total = parseFloat(valorColunas) + parseFloat(res);
            total = parseFloat(Math.round(total * 100) / 100).toFixed(2);
            buildIdPValorSoma(numeroPValor[i]).text(float2moeda(total));
        }
    }
}

//função para reaproveitamento, que vai somar os valores de um determinado grupo "GRUPO 5" na posição 1 da tabela
function wrapAddValuePValorSoma() {
    for (var i = 0; i < CONFIG_SOMA.get('GRUPO_5').g5.length; i++) {
        addValuePValorSoma([1], buildIdSelectEstimativaPorNumero(CONFIG_SOMA.get('GRUPO_5').g5[i]).val());
    }
}

//Linha 26 - o Total de Receitas será a equação linha1 + linha 19 - linha 25.
function updateTotalReceitas() {
    var valorP1 = buildIdPValorSoma(1).text().replaceAll(".", "").replaceAll(",",".");
    var valorP19 = buildIdPValorSoma(19).text().replaceAll(".", "").replaceAll(",",".");
    var total = parseFloat(valorP1) + parseFloat(valorP19);
    if (buildIdSelectEstimativaPorNumero(25).val()) {
        total = total - parseFloat(buildIdSelectEstimativaPorNumero(25).val().replaceAll(".", "").replaceAll(",","."));
    }
    CONFIG_SOMA.get('VALOR_TOTAL').text(float2moeda(total));
}

//Inicia se valores já foram cadastrados
function initCodReceita(arrayValInput, PValorSoma) {
    var total = 0;
    for (var i = 0; i < arrayValInput.length; i++) {
        total += parseFloat(buildIdSelectEstimativaPorNumero(arrayValInput[i]).val().replaceAll(".", "").replaceAll(",","."));
    }
    buildIdPValorSoma(PValorSoma).text(float2moeda(total));
}


$(document).ready(function() {

    //Se edit, array dos input`s para atualizar o a tag p
    initCodReceita([9], 8);
    initCodReceita([5, 6, 7, 9, 10, 11], 2);
    initCodReceita([5, 6, 7, 9], 3);
    initCodReceita([20, 21, 22, 23, 24], 19);
    initCodReceita([5, 6, 7], 4);
    initCodReceita([5, 6, 7, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18 ], 1);

    // Linhas 5,6 e 7 imputadas - os valores serão somados e atribuídos às linhas 4, 3 , 2 e 1.
    var grupo2 = addClassGroupInput('GRUPO_2');
    jQuery('.' + grupo2).on("input", function() {
        var valoresParaLimparEsomar = [1, 2, 3, 4];
        //limpa os valores
        valoresParaLimparEsomar.forEach(clearPvalorSoma);
        $.each(jQuery('.' + grupo2), function(index, value){
            var parcial = ($(this).val() ? $(this).val() : 0);
            //soma os valores
            addValuePValorSoma(valoresParaLimparEsomar, parcial);
        });

        //atualiza os valores dos inputs que não fazem parte do GRUPO_2
        valoresParaLimparEsomar.splice(-1,1);
        addValuePValorSoma(valoresParaLimparEsomar, buildIdSelectEstimativaPorNumero(9).val());

        var arrayValor = [10, 11];
        valoresParaLimparEsomar.splice(-1,1);
        for (var i = 0; i < arrayValor.length; i++) {
            addValuePValorSoma(valoresParaLimparEsomar, buildIdSelectEstimativaPorNumero(arrayValor[i]).val());
        }
        wrapAddValuePValorSoma();
        //atualiza o total da receita
        updateTotalReceitas();
    });

    // Linha 9 imputada - o valor será somado aos valores das linhas 3, 2, 1 e 8.
    buildIdSelectEstimativaPorNumero(9).on("input", function() {
        var valoresParaLimparEsomar = [1, 2, 3, 8];
        valoresParaLimparEsomar.forEach(clearPvalorSoma);
        $.each(buildIdSelectEstimativaPorNumero(9), function(index, value){
            var parcial = ($(this).val() ? $(this).val() : 0);
            addValuePValorSoma(valoresParaLimparEsomar, parcial);
        });

       var arrayValor = [5, 6, 7];
        valoresParaLimparEsomar.splice(-1,1);
        for (var i = 0; i < arrayValor.length; i++) {
            addValuePValorSoma(valoresParaLimparEsomar, buildIdSelectEstimativaPorNumero(arrayValor[i]).val());
        }
        var arrayValor2 = [10, 11];
        valoresParaLimparEsomar.splice(-1,1);
        for (var j = 0; j < arrayValor2.length; j++) {
            addValuePValorSoma(valoresParaLimparEsomar, buildIdSelectEstimativaPorNumero(arrayValor2[j]).val());
        }
        wrapAddValuePValorSoma();
        updateTotalReceitas();
    });

    // Linhas 10 e 11 imputadas - os valores serão somados as linhas 1 e 2.
    var grupo4 = addClassGroupInput('GRUPO_4');
    jQuery('.' + grupo4).on("input", function() {
        var valoresParaLimparEsomar = [1, 2];
        valoresParaLimparEsomar.forEach(clearPvalorSoma);
        $.each(jQuery('.' + grupo4), function(index, value){
            var parcial = ($(this).val() ? $(this).val() : 0);
            addValuePValorSoma(valoresParaLimparEsomar, parcial);
        });

        var arrayValor = [5, 6, 7, 9];
        for (var i = 0; i < arrayValor.length; i++) {
            addValuePValorSoma(valoresParaLimparEsomar, buildIdSelectEstimativaPorNumero(arrayValor[i]).val());
        }
        wrapAddValuePValorSoma();
        updateTotalReceitas();
    });

    // Linhas 12, 13, 14, 15, 16, 17 e 18  imputadas - os valores serão somados a linha 1.
    var grupo5 = addClassGroupInput('GRUPO_5');
    jQuery('.' + grupo5).on("input", function() {
        clearPvalorSoma(1);
        $.each(jQuery('.' + grupo5), function(index, value){
            var parcial = ($(this).val() ? $(this).val() : 0);
            addValuePValorSoma([1], parcial);
        });

        var arrayValor = [5, 6, 7, 9, 10, 11];
        for (var i = 0; i < arrayValor.length; i++) {
            addValuePValorSoma([1], buildIdSelectEstimativaPorNumero(arrayValor[i]).val());
        }
        updateTotalReceitas();
    });

    // Linhas 20, 21, 22, 23, e 24 imputadas - os valores serão somados e exibidos na linha 19.
    var grupo6 = addClassGroupInput('GRUPO_6');
    jQuery('.' + grupo6).on("input", function() {
        clearPvalorSoma(19);
        $.each(jQuery('.' + grupo6), function(index, value){
            var parcial = ($(this).val() ? $(this).val() : 0);
            addValuePValorSoma([19], parcial);
        });
        updateTotalReceitas();
    });

    // Linha 25 - o valor imputado nesta linha deverá sempre ser negativo e será subtraído no total das Receitas na linha 26.
    buildIdSelectEstimativaPorNumero(25).on("input", function() {
        updateTotalReceitas();
    });
});