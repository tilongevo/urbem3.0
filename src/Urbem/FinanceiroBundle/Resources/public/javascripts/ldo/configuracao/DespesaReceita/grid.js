$(document).ready(function() {

    var initAno = jQuery('tr.receitas th').eq(3).attr('class').replace('th-rh','');
    for (ano = initAno; ano <= (parseInt(initAno) + 2); ano++) {
        var anoString = String(ano);
        fazSomaTotal('receita', anoString.trim());
        fazSomaTotal('despesa', anoString.trim());
        somaReservaContigencia(anoString.trim());
        initReservaContigenciaRpps(anoString.trim());
    }

    $(".valorParcial").on("input", function() {

        //Soma de reserva de contingencia
        var grupo = $(this).attr('data-grupo');
        var ano = $(this).attr('data-ano');
        var rpps = $(this).attr('data-rpps');
        var rppsNome = 'reserva';
        if($(this).attr('data-rpps') == '1'){
            rppsNome = 'rpps';
        }

        $('#' + rppsNome + grupo + '_' + ano).val(0);
        $.each($('.valorParcial[data-ano="' + ano + '"][data-rpps="' + rpps + '"][data-grupo="' + grupo + '"]'), function(index, value){
            var rppsNome = 'reserva';
            if($(this).attr('data-rpps') == '1'){
                rppsNome = 'rpps';
            }
            var parcial = ($(this).val() ? $(this).val() : 0);

            if (parcial) {
                if (rppsNome + grupo != 'reservaProjetada') {
                    parcial = parcial.replaceAll(".", "").replaceAll(",",".");
                    if($(this).attr('data-operacao') == 'd'){
                        parcial = parcial * (-1);
                    }
                    parcial = parseFloat($('#' + rppsNome + grupo + '_' + ano).val().replaceAll(".", "").replaceAll(",",".")) + parseFloat(parcial);
                    parcial =  parseFloat(Math.round(parcial * 100) / 100).toFixed(2);

                    $('#' + rppsNome + grupo + '_' + ano).val(float2moeda(parcial));
                }
            }
        });

        //Somatorias
        fazSomatoria(1, [2, 4, 5, 8, 9, 10, 11, 12, 13, 14, 16, 17], ano, grupo);
        fazSomatoria(3, [4, 5], ano, grupo);
        fazSomatoria(6, [8, 9, 10], ano, grupo);
        fazSomatoria(7, [8, 9], ano, grupo);
        fazSomatoria(15, [16, 17], ano, grupo);
        fazSomatoria(18, [19, 20, 21, 22, 23], ano, grupo);
        fazSomatoria(26, [28, 29, 31, 32, 34, 35], ano, grupo);
        fazSomatoria(27, [28, 29], ano, grupo);
        fazSomatoria(30, [31, 32], ano, grupo);
        fazSomatoria(33, [34, 35], ano, grupo);
        fazSomatoria(36, [38, 39, 41, 42, 43], ano, grupo);
        fazSomatoria(37, [38, 39], ano, grupo);
        fazSomatoria(40, [41, 42], ano, grupo);

        fazSomaTotal('receita', ano);
        fazSomaTotal('despesa', ano);

        somaReservaContigencia(ano);

    });
});

function fazSomatoria (pai, filhos, ano, grupo)
{
    var tipo = 'receita';
    if(pai > 25){
        tipo = 'despesa';
    }
    $('#' + tipo + grupo + '_' + pai + '_' + ano).val(0);
    for(i = 0; i < filhos.length; i++){
        parcial = $('#' + tipo + grupo + '_' + filhos[i] + '_' + ano).val();
        if (parcial) {
            parcial = parseFloat($('#' + tipo + grupo + '_' + pai + '_' + ano).val().replaceAll(".", "").replaceAll(",",".")) + parseFloat(parcial.replaceAll(".", "").replaceAll(",","."));
            parcial =  parseFloat(Math.round(parcial * 100) / 100).toFixed(2);
            $('#' + tipo + grupo + '_' + pai + '_' + ano).val(float2moeda(parcial));
        }
    }
}

function fazSomaTotal(tipo, ano) {
    switch (tipo)
    {
        case "receita":
            somaTotalReceita(ano);
            break;
        case "despesa":
            somaTotalDespesa(ano);
            break;
    }
}
function somaTotalReceita(ano) {
    var arrayRowSoma = [1, 18, 24, 25];
    var soma = 0;
    arrayRowSoma.forEach(function (chave) {
        var row = jQuery('#receitaProjetada_' + chave +'_' + ano).val();
        if (row) {
            row = row.replaceAll(".", "").replaceAll(",",".");
            if (chave == 25) {
                soma = parseFloat(soma) - parseFloat(row);
            } else {
                soma = parseFloat(soma) + parseFloat(row);
            }
            soma =  parseFloat(Math.round(soma * 100) / 100).toFixed(2);
        }
    });

    jQuery('#receitaProjetada_26_' + ano).val(float2moeda(soma));
}

function somaTotalDespesa(ano) {
    var arrayRowSoma = [28, 29, 31, 32, 34, 35, 38, 39, 41, 42, 43];
    var soma = 0;
    arrayRowSoma.forEach(function (chave) {
        var row = jQuery('#despesaProjetada_' + chave +'_' + ano).val();

        if (row) {
            row = row.replaceAll(".", "").replaceAll(",",".");
            soma = parseFloat(soma) + parseFloat(row);
            soma = parseFloat(Math.round(soma * 100) / 100).toFixed(2);
        }
    });
    jQuery('#despesaProjetada_44_' + ano).val(float2moeda(soma));
}

function somaReservaContigencia(ano) {
    var totalReceitaProjetada = jQuery('#receitaProjetada_26_' + ano).val().replaceAll(".", "").replaceAll(",",".");

    var soma = somaReceitasDespesasRpps(ano ,[5, 9, 17, 24] ,'receitaProjetada');
    var reservaContigencia = (totalReceitaProjetada - soma);
    var somaDespesaRpps = somaReceitasDespesasRpps(ano ,[29 ,32 ,35 ,39] ,'despesaProjetada');

    var totalDesepesaProjetada = jQuery('#despesaProjetada_44_' + ano).val().replaceAll(".", "").replaceAll(",",".");
    totalDesepesaProjetada = (totalDesepesaProjetada - somaDespesaRpps);
    somaDespesaRpps = (somaDespesaRpps * 2);
    totalDesepesaProjetada = (totalDesepesaProjetada + somaDespesaRpps);
    reservaContigencia = (reservaContigencia - totalDesepesaProjetada);

    jQuery('#reservaProjetada_' + ano).val(float2moeda(reservaContigencia));
}

function initReservaContigenciaRpps(ano) {
    var somaReceitaRpps = somaReceitasDespesasRpps(ano ,[5, 9, 17, 24] ,'receitaProjetada');
    var somaDespesaRpps = somaReceitasDespesasRpps(ano ,[29 ,32 ,35 ,39] ,'despesaProjetada');

    var totalReservaContigenciaRpps = (somaReceitaRpps - somaDespesaRpps);
    jQuery('#rppsProjetada_' + ano).val(float2moeda(totalReservaContigenciaRpps));
}

function somaReceitasDespesasRpps(ano, arrayRowSoma, id) {
    var soma = 0;
    arrayRowSoma.forEach(function (chave) {
        var row = jQuery('#' + id + '_' + + chave +'_' + ano).val();
        if (row) {
            row = row.replaceAll(".", "").replaceAll(",",".");
            soma = parseFloat(soma) + parseFloat(row);
            soma = parseFloat(Math.round(soma * 100) / 100).toFixed(2);
        }
    });
    return soma;
}