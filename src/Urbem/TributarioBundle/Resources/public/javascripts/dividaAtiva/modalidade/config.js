var CONFIG_MODALIDADE = (function() {
    var private = {
        'INPUT': '#' + UrbemSonata.uniqId + '_',
        'WRAP_FORM': '#sonata-ba-field-container-' +  UrbemSonata.uniqId + '_',
        'DADOS_AJAX': {},
        'ID_TABELA': '#tabela-',
        'ID_HIDDEN': '#hidden-',
        'ID_WRAP': '#wrap-',
        'INCLUIR_REGISTRO': '.incluir-registro '
    };
    return {
        get: function(name) { return private[name]; },
        set: function(name, value) {$.extend(private[name], value);}
    };
})();

var factoryObjeto = function (id, value) {
    var retorno = jQuery(CONFIG_MODALIDADE.get(id));
    if (value) {
        retorno = jQuery(CONFIG_MODALIDADE.get(id) + value);
    }
    return retorno;
};

var buildInitHtml = function (idTable, headerTable) {
    return {
        wrap: wrapTableDiv(idTable, headerTable)
    };
    function table(idTable, headerTable) {
        var html = '<table class="col s12 highlight bordered" id="tabela-' + idTable + '" style="margin-bottom: 45px;">';

        html += '<thead class="thead-rh"><tr class="sonata-ba-list-field-header">';
        for (x in headerTable) {
            html += '<th class="th-rh">' + headerTable[x] + '</th>';
        }
        html += '<th class="th-rh"></th></tr></thead>';

        html += '<tbody>';
        html += '</tbody>';
        html += '</table>';
        return html;
    }
    function div(idTable) {
        return '<div id="hidden-' + idTable + '"></div>';
    }
    function wrapTableDiv(idTable, headerTable)
    {
        var wrap = '<div id="wrap-' + idTable + '">';
        wrap += table(idTable, headerTable);
        wrap += div(idTable);
        wrap += '</div>';
        return wrap;
    }
};

var initTableAndDiv = function (referencia, headerTable) {
    var html = buildInitHtml(referencia, headerTable);
    factoryObjeto('WRAP_FORM', referencia).after(html.wrap);
};

var bloqueiaBotao = function () {
    factoryObjeto('INCLUIR_REGISTRO').addClass('disabled');
};

var desbloqueiaBotao = function () {
    factoryObjeto('INCLUIR_REGISTRO').removeClass('disabled');
};

function configHtml(sumIndex, item, arrayName) {
    return {
        buildTable: buildTable(sumIndex, item),
        buildInputHidden: buildInputHidden(sumIndex, item, arrayName)
    };
    function buildTable(sumIndex, item) {
        var html = "<tr><td>" + sumIndex + "</td>";
            $.each(item, function(index, value) {
                if (index != 'hidden') {
                    if (index != 'chave') {
                        html += "<td>" + value + "</td>";
                    }
                }
            });
            html += "<td><a href='javascript://Remover' class='item-" + item.chave + "'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a></td></tr>";
        return html
    }
    function buildInputHidden(sumIndex, item, arrayName) {
        var html = "";
        $.each(item, function(index, value) {
            if (index == 'hidden') {
                $.each(value, function(index, value) {
                    html += "<div><input type='hidden' name='"+ arrayName +"[" + index + "][" + sumIndex + "]' value='" + value + "' ></div>";
                });
            }
        });
        return html;
    }
}

var removeItemContent = function (obj, referencia) {
    var item = obj.attr('class').replace('item-', '');
    $.grep(CONFIG_MODALIDADE.get('DADOS_AJAX')[referencia], function (e, i) {
        if (e) {
            if (e.chave == item) {
                CONFIG_MODALIDADE.get('DADOS_AJAX')[referencia].splice(i, 1);
                updateLista(referencia);
            }
        }
    });
};

var removerItem = function (referencia) {
    factoryObjeto('ID_TABELA', referencia + ' a').on('click', function (e) {
        removeItemContent(jQuery(this), referencia);
    });
};

var updateLista = function (referencia) {
    factoryObjeto('ID_TABELA', referencia + ' tbody').html("");
    factoryObjeto('ID_HIDDEN', referencia).html("");
    CONFIG_MODALIDADE.get('DADOS_AJAX')[referencia].forEach(function (item, index, arr) {
        var sumIndex = (parseInt(index) + 1);
        var html = configHtml(sumIndex, item, referencia);
        factoryObjeto('ID_TABELA', referencia + ' tbody').append(html.buildTable);
        factoryObjeto('ID_HIDDEN', referencia).append(html.buildInputHidden);
    });
    removerItem(referencia);
};

var populaObjeto = function (data, referencia) {
    if (!validacao(referencia, data)) {
        return false;
    }
    if (CONFIG_MODALIDADE.get('DADOS_AJAX')[referencia]) {
        var result = $.grep(CONFIG_MODALIDADE.get('DADOS_AJAX')[referencia], function (e) {
            if (e) {
                if (e.chave == data.data.chave) {
                    return true;
                }
            }
        });
        if (result.length == 0) {
            CONFIG_MODALIDADE.get('DADOS_AJAX')[referencia].push(data.data);
        }
    } else {
        var objectAux = {};
        objectAux[referencia] = [data.data];
        CONFIG_MODALIDADE.set('DADOS_AJAX', objectAux);
    }
    updateLista(referencia);
};

var populaObjetos = function (dataString, referencia) {
    var obj = JSON.parse(dataString);
    $.grep(obj, function (e) {
        if (e) {
            populaObjeto(e, referencia);
        }
    });
};

var populaEdit = function (referencia) {
    if (factoryObjeto('INPUT', referencia + 'Edit').length > 0) {
        populaObjetos(factoryObjeto('INPUT', referencia + 'Edit').val(), referencia);
    }
};

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

var ajaxSelect = function (url, tag, selected) {
    jQuery.ajax({
        url: url,
        method: "GET",
        dataType: "json",
        success: function (data) {
            sucesso(data.data, tag, selected);
        }
    });
};

var ajaxPopula = function (url, dados, method, referencia) {
    var params = {
        url: url,
        dataType: "json",
        method: method,
        success: function (data) {
            populaObjeto(data, referencia);
        }
    };
    if (method == "POST") {
        params.data = dados;
    }
    return jQuery.ajax(params);
};

var initAppendTable = function (referencia, headerTable, url) {
    initTableAndDiv(referencia, headerTable);
    jQuery(CONFIG_MODALIDADE.get('WRAP_FORM') + referencia + ' .incluir-registro').on('click', function () {
        initAppendTableCustom(referencia, url);
    });
};

var validadeDadosListaNotEmptySubmit = function (arrayReference) {
    if (arrayReference.length > 0) {
        jQuery(document).on('submit', 'form', function(e) {
            arrayReference.forEach(function (element, index, array) {
                if (!CONFIG_MODALIDADE.get('DADOS_AJAX')[element] || CONFIG_MODALIDADE.get('DADOS_AJAX')[element].length == 0) {
                    e.preventDefault();
                }
            });
        });
    }
};