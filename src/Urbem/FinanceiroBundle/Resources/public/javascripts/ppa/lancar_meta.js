$(document).ready(function() {

    $.each($('.metas'), function(index, value){
        $(this).hide();
    })

    $(".btn_meta").on("click", function() {
        codAcao = $(this).attr('data-codAcao');

        if($(this).html() == 'add'){
            $('#meta_' + codAcao).show();
            $(this).html('remove');
        }
        else{
            $('#meta_' + codAcao).hide();
            $(this).html('add');  
        }
    });

    jQuery('#buscaPorRecurso').on("change", function() {
        if (parseInt(jQuery(this).val()) > 0) {
            jQuery('.tr-todos').hide();
            jQuery('.tr-' + jQuery(this).val()).show();
        } else {
            jQuery('.tr-todos').show();
        }
    });

    jQuery( window ).load(function() {
        jQuery('.carrega-tabela').show();
        jQuery('.aguarde').hide();
    });
});
