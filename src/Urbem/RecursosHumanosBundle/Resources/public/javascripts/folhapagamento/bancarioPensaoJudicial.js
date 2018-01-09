$(document).ready(function(){
	config.banco.on("change", function() {
	    factoryActionBanco(jQuery(this).val());
	});

	if (config.banco.val() == '') {
	    clear(config.agencia);
	} else {
	    factoryActionBanco(config.banco.val());
	}
	
	$("form").submit(function(){
		config.agenciasStr.val(JSON.stringify(config.agencia.val()));
		config.agencia.select2('enable', false);
	});
});

var config = {
    urlBanco: "/recursos-humanos/folha-pagamento/bancario-pensao-judicial/relatorio/agencias-por-banco",
    banco : jQuery("#" + UrbemSonata.uniqId + "_banco"),
    agencia : jQuery("#" + UrbemSonata.uniqId + "_agencia"),
    agenciasStr: jQuery("#" + UrbemSonata.uniqId + "_agenciasStr")
};

// para buscar as agencias
function factoryActionBanco(banco) {
    if (banco == "") {
        return;
    }
    clear(config.agencia);
    habilitarDesabilitar(config.agencia, true);
    ajax(config.urlBanco, {bancos: banco}, config.agencia);
}

var sucesso = function (data, tag) {
    habilitarDesabilitar(tag, false);
    var tagName = tag.prop("tagName");
    if (tagName == "SELECT") {
        $.each(data.dados, function (index, value) {
            var aux = tag.val();
            if (index == aux) {
                tag
                    .append("<option value='" + index +"'>" + value + "</option>");
            } else {
                tag
                    .append("<option value='" + index + "'>" + value + "</option>");
            }
        });
        tag.select2();
    }
};
var clear = function(select) {
	select.html("");
};
var ajax = function (url, dados, tag) {
    jQuery.ajax({
        url: url,
        method: "POST",
        data: dados,
        dataType: "json",
        success: function (data) {
            sucesso(data, tag);
        }
    });
};

var habilitarDesabilitar = function habilitarDesabilitarSelect(target, optionBoolean) {
    target.prop('disabled', optionBoolean);
};
