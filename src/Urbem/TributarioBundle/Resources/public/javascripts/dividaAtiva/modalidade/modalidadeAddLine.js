var CONFIG_OPCOES_MODALIDADE = (function() {
    var private = {
        'CREDITOS': 'creditos',
        'DOCUMENTOS': 'documentos',
        'INCIDENCIA': 'incidencia',
        'ACRESCIMO': 'acrescimo',
        'DESCRICAO': 'descricao',
        'REGRA_UTILIZACAO': 'regraUtilizacao',
        'URL_CREDITO': '/tributario/divida-ativa/modalidade/credito/',
        'URL_DOCUMENTO': '/tributario/divida-ativa/modalidade/documento/',
        'URL_FUNDAMENTACAO_LEGAL': '/tributario/divida-ativa/autoridade/buscar-fundamentacao-legal/'
    };
    return {
        get: function(name) { return private[name]; },
        set: function(name, value) {private[name] = value;}
    };
})();

var valida = function (referencia, data, retorno) {
    if (referencia == CONFIG_OPCOES_MODALIDADE.get('INCIDENCIA')) {
        if (CONFIG_MODALIDADE.get('DADOS_AJAX')[referencia]) {
            var result = $.grep(CONFIG_MODALIDADE.get('DADOS_AJAX')[referencia], function (e) {
                if (e) {
                    var alocado = e.chave.split('.');
                    var enviado = data.data.chave.split('.');
                    alocado.splice(2, 3);
                    enviado.splice(2, 3);
                    return (alocado.length == enviado.length) && alocado.every(function(element, index) {
                            return element === enviado[index];
                        });
                }
            });
            if (result.length > 0) {
                retorno = false;
            }
        }
    }
    return retorno;
};

var tableCustomIncidencia = function (referencia, url) {
    if (referencia == CONFIG_OPCOES_MODALIDADE.get('INCIDENCIA')) {
        var incidencia = factoryObjeto('INPUT', referencia).val();
        var acrescimo = factoryObjeto('INPUT', CONFIG_OPCOES_MODALIDADE.get('ACRESCIMO').concat(' option:selected')).text();
        var regraUtilizacaoText = factoryObjeto('INPUT', CONFIG_OPCOES_MODALIDADE.get('REGRA_UTILIZACAO').concat(' option:selected')).text();
        var regraUtilizacao = factoryObjeto('INPUT', CONFIG_OPCOES_MODALIDADE.get('REGRA_UTILIZACAO')).val();

        if (!incidencia ||
            !regraUtilizacao ||
            !factoryObjeto('INPUT', CONFIG_OPCOES_MODALIDADE.get('ACRESCIMO')).val()
        ) {
            return false;
        }

        var retornoAcrescimo = acrescimo.split(' - ');

        if (incidencia == "ambos") {
            popula(1);
            popula(0);
        } else {
            popula(incidencia);
        }

        function popula(incidencia) {
            var objeto = {
                data: {
                    chave: retornoAcrescimo[0].concat('.', regraUtilizacao, '.', incidencia),
                    codigo: retornoAcrescimo[0],
                    descricao: retornoAcrescimo[1],
                    incidencia: (incidencia == '1' ? 'Pagamentos' : 'Inscrição em Dívida / Cobranças'),
                    regra: regraUtilizacaoText,
                    hidden: {codigo: retornoAcrescimo[0].concat('.', regraUtilizacao, '.', incidencia)}
                }
            };
            populaObjeto(objeto, referencia);
        }
    }
};

var tableCustomAjax = function (referencia, url) {
    if (
        referencia == CONFIG_OPCOES_MODALIDADE.get('CREDITOS') ||
        referencia == CONFIG_OPCOES_MODALIDADE.get('DOCUMENTOS')
    ) {

        if (!factoryObjeto('INPUT', referencia).val()) {
            return false;
        }

        return ajax = ajaxPopula(
            url + factoryObjeto('INPUT', referencia).val(),
            null,
            'GET',
            referencia
        );
    }
};

var validacao = function (referencia, data) {
    var retorno = true;
    valida(referencia, data, retorno);
    return retorno;
};

var initAppendTableCustom = function (referencia, url) {
    bloqueiaBotao();
    tableCustomIncidencia(referencia, url);
    tableCustomAjax(referencia, url);
    desbloqueiaBotao();
};

jQuery(function() {
    // INICIANDO APPEND PARA Creditos
    factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('CREDITOS') + ' .help-block.sonata-ba-field-help').css({'float': 'left', 'left': '35px', 'top': '3px'});
    initAppendTable(
        CONFIG_OPCOES_MODALIDADE.get('CREDITOS'),
        ['#', 'Código', 'Descrição'],
        CONFIG_OPCOES_MODALIDADE.get('URL_CREDITO')
    );
    populaEdit(CONFIG_OPCOES_MODALIDADE.get('CREDITOS'));

    // INICIANDO APPEND PARA Acréscimos Legais
    factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('INCIDENCIA')).css({'width': '50%'});
    factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('INCIDENCIA') + ' .sonata-ba-field.sonata-ba-field-standard-natural').css({'width': '50%'});
    factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('INCIDENCIA') + ' .help-block.sonata-ba-field-help').css({'float': 'left', 'left': '40px', 'top': '3px'});
    initAppendTable(
        CONFIG_OPCOES_MODALIDADE.get('INCIDENCIA'),
        ['#', 'Código', 'Descrição', 'Incidência', 'Regra de Utilização']
    );
    populaEdit(CONFIG_OPCOES_MODALIDADE.get('INCIDENCIA'));

    // INICIANDO APPEND PARA Acréscimos Documentos
    factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('DOCUMENTOS') + ' .help-block.sonata-ba-field-help').css({'float': 'left', 'left': '35px', 'top': '3px'});
    initAppendTable(
        CONFIG_OPCOES_MODALIDADE.get('DOCUMENTOS'),
        ['#', 'Código', 'Nome'],
        CONFIG_OPCOES_MODALIDADE.get('URL_DOCUMENTO')
    );
    populaEdit(CONFIG_OPCOES_MODALIDADE.get('DOCUMENTOS'));

    factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('DESCRICAO')).css({'width': '49%'});
    factoryObjeto('INPUT', 'fundamentacaoLegal').prop('disabled', true);
    factoryObjeto('INPUT', "tipo").on("change", function() {
        if (jQuery(this).val()) {
            factoryObjeto('INPUT', 'fundamentacaoLegal').prop('disabled', true);
            ajaxSelect(CONFIG_OPCOES_MODALIDADE.get('URL_FUNDAMENTACAO_LEGAL') + jQuery(this).val(), factoryObjeto('INPUT', 'fundamentacaoLegal'), null);
        }
    });

    validadeDadosListaNotEmptySubmit([CONFIG_OPCOES_MODALIDADE.get('CREDITOS'), CONFIG_OPCOES_MODALIDADE.get('DOCUMENTOS')]);
    jQuery(document).on('submit', 'form', function(e) {
        factoryObjeto('INPUT', 'fundamentacaoLegal').prop('disabled', false);
    });
});