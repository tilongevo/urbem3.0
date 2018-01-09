var CONFIG_AUTORIDADE = (function() {
    var private = {
        'INPUT': '#' + UrbemSonata.uniqId + '_',
        'URL_FUNCAO_CARGO': '/tributario/divida-ativa/autoridade/buscar-funcao-cargo/',
        'URL_FUNDAMENTACAO_LEGAL': '/tributario/divida-ativa/autoridade/buscar-fundamentacao-legal/',
        'DIV_WRAP_FORM': '#sonata-ba-field-container-' + UrbemSonata.uniqId + '_',
        'PROCURADOR': 'procurador',
        'AUTORIDADE': 'autoridade'
    };
    return {
        get: function(name) { return private[name]; }
    };
})();

var sucesso = function (data, tag, selected) {
    var tagName = tag.prop("tagName");
    if (tagName == "SELECT") {
        tag.empty().append("<option value=\"\">Selecione</option>").select2("val", "").val('').trigger("change");
        $.each(data, function (index, value) {
            if (index == selected) {
                tag
                    .append("<option value=" + index + " selected>" + value + "</option>");
            } else {
                tag
                    .append("<option value=" + index + ">" + value + "</option>");
            }
        });
        tag.prop('disabled', false);
        tag.select2();
    }

    if (tagName == "INPUT") {
        var type = tag.prop("type");
        if (type == "text") {
            tag.val(data);
        }
    }
};

var ajax = function (url, tag, selected) {
    jQuery.ajax({
        url: url,
        method: "GET",
        dataType: "json",
        success: function (data) {
            sucesso(data.data, tag, selected);
        }
    });
};

var factoryObjeto = function (id, value) {
    var retorno = jQuery(CONFIG_AUTORIDADE.get(id));
    if (value) {
        retorno = jQuery(CONFIG_AUTORIDADE.get(id) + value);
    }
    return retorno;
};

var desabilitarHabilitarProcurador = function (tipoAutoridade) {
    switch(tipoAutoridade) {
        case CONFIG_AUTORIDADE.get('PROCURADOR'):
            factoryObjeto('INPUT', 'oab').prop('disabled', false);
            factoryObjeto('INPUT', 'codUf').prop('disabled', false);
            break;
        case CONFIG_AUTORIDADE.get('AUTORIDADE'):
            factoryObjeto('INPUT', 'oab').prop('disabled', true);
            factoryObjeto('INPUT', 'codUf').prop('disabled', true);
            break;
    }
};

jQuery(function() {
    factoryObjeto('INPUT', 'tipoAssinatura').prop('required', true);
    if (factoryObjeto('DIV_WRAP_FORM', 'tipoAssinatura').find('a').length == 1) {
        factoryObjeto('INPUT', 'tipoAssinatura').removeAttr('required');
    }

    factoryObjeto('DIV_WRAP_FORM', 'oab').css({'clear': 'left'});
    factoryObjeto('DIV_WRAP_FORM', 'fundamentacaoLegal').css({'width' : '50%', 'clear': 'left'});
    factoryObjeto('INPUT', 'fundamentacaoLegal').prop('disabled', true);
    factoryObjeto('INPUT', "matriculas_autocomplete_input").on("change", function() {
        if (jQuery(this).val()) {
            ajax(CONFIG_AUTORIDADE.get('URL_FUNCAO_CARGO') + jQuery(this).val(), factoryObjeto('INPUT', 'funcaoCargo'), null);
        } else {
            factoryObjeto('INPUT', 'funcaoCargo').val("");
        }
    });

    factoryObjeto('INPUT', "tipo").on("change", function() {
        if (jQuery(this).val()) {
            factoryObjeto('INPUT', 'fundamentacaoLegal').prop('disabled', true);
            ajax(CONFIG_AUTORIDADE.get('URL_FUNDAMENTACAO_LEGAL') + jQuery(this).val(), factoryObjeto('INPUT', 'fundamentacaoLegal'), null);
        }
    });

    if (factoryObjeto('INPUT', 'fundamentacaoLegalEdit').val()) {
        ajax(
            CONFIG_AUTORIDADE.get('URL_FUNDAMENTACAO_LEGAL') + factoryObjeto('INPUT', "tipo").val(),
            factoryObjeto('INPUT', 'fundamentacaoLegal'),
            factoryObjeto('INPUT', 'fundamentacaoLegalEdit').val()
        );
    }

    desabilitarHabilitarProcurador(factoryObjeto('INPUT', "tipoAutoridade").val());
    factoryObjeto('INPUT', "tipoAutoridade").on("change", function() {
        desabilitarHabilitarProcurador(jQuery(this).val());
        factoryObjeto('INPUT', 'codUf').select2("val", "0").val('').trigger("change");
    });

    jQuery(document).on('submit', 'form', function() {
        factoryObjeto('INPUT', 'fundamentacaoLegal').prop('disabled', false);
    });
});