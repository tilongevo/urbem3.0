var CONFIG = (function() {
    var private = {
        'SINTETICO': 'S',
        'NUMEROS': [1, 2, 3, 4],
        'INPUT_PORCENTAGEM':  jQuery('.input-porcentagem'),
        'ID': "#estimativa_ppa_porcentagemAno",
        'ANO': '.ano',
        'VALOR_PARCIAL': jQuery('.valorParcial'),
        'ESTI_PORCENTAGEM': $("#estimativa_ppa_porcentagem")
    };
    return {
        get: function(name) { return private[name]; }
    };
})();

function buildIdSelect(numero) {
    return $(CONFIG.get('ID') + numero);
}
function buildClassAno(numero) {
    return $(CONFIG.get('ANO') + numero);
}
function clearPorcentagem(numero) {
    buildIdSelect(numero).val('');
}
function preencherAno(numero) {
    buildIdSelect(numero).on("input", function() {
        $.each(buildClassAno(numero), function(index, value){
            $(this).val(buildIdSelect(numero).val());
        })
    });
}
$(document).ready(function() {
    CONFIG.get('ESTI_PORCENTAGEM').on("change", function() {
        if($(this).val() ==  CONFIG.get('SINTETICO')){
            CONFIG.get('INPUT_PORCENTAGEM').show();
        } else {
            CONFIG.get('NUMEROS').forEach(clearPorcentagem);
            CONFIG.get('INPUT_PORCENTAGEM').hide();
        }
    });
    CONFIG.get('NUMEROS').forEach(preencherAno);
});