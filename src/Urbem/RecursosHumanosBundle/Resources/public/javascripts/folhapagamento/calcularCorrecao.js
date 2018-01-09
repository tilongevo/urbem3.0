jQuery(document).ready(function(){
    jQuery('#padrao_codNivelPadraoNivel').remove();
});
function calculaCorrecao(value){
    var padrao = jQuery('#padrao_codPadraoPadrao_valor');
    var valor   = padrao.val().replace('.','') ;
        valor   = valor.replace(',','.') ;
    var porcentId = value.id;
    var porcent = jQuery('#' + porcentId).val();
    var valorId = porcentId.replace('percentual','valor');
    jQuery('#' + valorId).val(0);
    if ( valor.length  != 0 ) {
        if ( porcent.length != 0) {
            if ( porcent  != 0){
                valor = Number(valor * (1+ porcent/100)).toFixed(2);
                valor = '' + valor; // transformando a variavel em string pra poder usar o replace
                if ( valor == 'NaN' ){
                // se a condição acima for verdadeira o percentual não pode ser calculado pq o valor é muito alto
                    valor = 0;
                }else {
                    valor = valor.replace('.',',') ;
                }
                jQuery('#' + valorId).val(valor);
            }
        }
    }
}