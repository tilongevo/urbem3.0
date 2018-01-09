(function(){
    'use strict';
    var config = {
        'normas': jQuery("#padrao_codPadraoPadrao_codNorma"),
        'tipoNormas': jQuery("#padrao_codPadraoPadrao_tipoNorma"),
        'url': '/recursos-humanos/folha-pagamento/padrao/normas-por-tipo/',
        'href': window.location.href
    };

    // para verificar se esta na pagina "novo"
    var bloqueia = function verificaBloqueio() {
        if(config.href.substr(config.href.lastIndexOf('/') + 1) == "novo")
            return true;
    };

    if(bloqueia())
        config.normas.prop('disabled', true);

    config.tipoNormas.on("change", function() {
        var id = $(this).val();
        if(!id)
            return false;

        $.ajax({
            url: config.url + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                if(data.status){
                    config.normas.empty().select2("val", "");
                    config.normas.append("<option value='0'>-- Selecione --</option>");
                    $.each(data.normas, function (index, value) {
                        config.normas.append("<option value=" + value.codNorma + ">" + value.nomNorma + "</option>");
                    });
                    config.normas.prop('disabled', false);
                }else{
                    alert("Sem normas para esse tipo norma!");
                    config.normas.prop('disabled', true);
                }
            }
        });
    });
}());
jQuery('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
    language: 'pt-BR'
});
