validacao = function (referencia, data) {
    var retorno = true;
    valida(referencia, data, retorno);
    return retorno;
};

var populaReducaoCreditoAcrescimo = function (dados, valor, chave) {
    var select = factoryObjeto('INPUT', CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO'));
    select.empty().append("<option value=\"\">Selecione</option>").select2("val", "").val('').trigger("change");
    if (dados) {
        dados.forEach(function (element, index, array) {
            select.append("<option value=" + element[chave] + ">" + element[valor] + "</option>");
        });
        select.select2();
    }
};

var tableCustomCreditoAcrescimo = function (referencia, url) {
    if (referencia == CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO')) {
        var tipoReducao = factoryObjeto('INPUT', 'tipoReducao').val();
        var valor = factoryObjeto('INPUT', 'valor').val();
        var reducoesIncidencia = factoryObjeto('INPUT', CONFIG_OPCOES_MODALIDADE.get('REDUCOES_INCIDENCIA')).val();
        var creditoAcrescimo = factoryObjeto('INPUT', CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO').concat(' option:selected')).text();
        var creditoAcrescimoVal = factoryObjeto('INPUT', CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO')).val();

        if (!valor ||
            !tipoReducao ||
            !reducoesIncidencia ||
            !creditoAcrescimoVal ) {
            return false;
        }

        var objeto = {
            data: {
                chave: creditoAcrescimoVal,
                codigo: creditoAcrescimoVal,
                descricao: creditoAcrescimo,
                tipo: reducoesIncidencia,
                tipoReducao: tipoReducao.replace('valor_',''),
                valor: valor,
                hidden: {codigo: creditoAcrescimoVal}
            }
        };
        populaObjeto(objeto, referencia);
    }
};

var tableCustomReducoesRegraUtilizacao = function (referencia, url) {
    if (referencia == CONFIG_OPCOES_MODALIDADE.get('REDUCOES_REGRA_UTILIZACAO')) {
        var reducoesRegraUtilizacao = factoryObjeto('INPUT', referencia.concat(' option:selected')).text();
        var chave = factoryObjeto('INPUT', referencia).val();
        var dadosReducoes = CONFIG_MODALIDADE.get('DADOS_AJAX')[CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO')];
        if (!dadosReducoes || dadosReducoes.length <= 0) {
            return false;
        }
        var valor = 0;
        var tipo = '';
        var incidencia = '';
        var codigoHidden = '';
        var concatChave = '';
        dadosReducoes.forEach(function (element, index, array) {
            var valorAtual = parseFloat(element.valor.replaceAll(".", "").replaceAll(",","."));
            if (valorAtual > valor) {
                valor = valorAtual;
                tipo = element.tipoReducao;
            }
            incidencia += element.codigo.concat(' - ') + element.descricao.concat('<br />');
            concatChave = element.chave;
            if (element.tipo == 'credito') {
                concatChave = element.chave.split(".");
                concatChave = concatChave[0];
            }
            if (codigoHidden != '') {
                codigoHidden +=  '-' + concatChave;
            } else {
                codigoHidden = concatChave;
            }
        });

        var objeto = {
            data: {
                chave: chave,
                tipo: tipo,
                valor: float2moeda(valor),
                regra: reducoesRegraUtilizacao,
                incidencia: incidencia,
                hidden: {codigo: codigoHidden.concat('+').concat(chave).concat('.').concat(float2moeda(valor).replaceAll(".", "")).concat('.').concat(tipo)}
            }
        };
        populaObjeto(objeto, referencia);

        CONFIG_MODALIDADE.get('DADOS_AJAX')[CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO')].splice(0);
        updateLista(CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO'));
        factoryObjeto('INPUT', 'tipoReducao').select2("val", "").val('').trigger("change");
        factoryObjeto('INPUT', 'valor').val('');
        factoryObjeto('INPUT', CONFIG_OPCOES_MODALIDADE.get('REDUCOES_INCIDENCIA')).select2("val", "").val('').trigger("change");
    }
};

initAppendTableCustom = function (referencia, url) {
    bloqueiaBotao();
    tableCustomIncidencia(referencia, url);
    tableCustomCreditoAcrescimo(referencia, url);
    tableCustomReducoesRegraUtilizacao(referencia, url);
    tableCustomAjax(referencia, url);
    factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO')).hide();
    factoryObjeto('INPUT', CONFIG_OPCOES_MODALIDADE.get('REDUCOES_INCIDENCIA')).select2("val", "").val('').trigger("change");
    desbloqueiaBotao();
};

jQuery(function() {
    CONFIG_OPCOES_MODALIDADE.set('CREDITO_ACRESCIMO', 'creditoAcrescimo');
    CONFIG_OPCOES_MODALIDADE.set('REDUCOES_INCIDENCIA', 'reducoesIncidencia');
    CONFIG_OPCOES_MODALIDADE.set('REDUCOES_REGRA_UTILIZACAO', 'reducoesRegraUtilizacao');
    CONFIG_OPCOES_MODALIDADE.set('acrescimo', 'Acréscimo');
    CONFIG_OPCOES_MODALIDADE.set('credito', 'Crédito');

    factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO')).hide();
    factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO')).css({'width': '50%'});
    factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO') + ' .sonata-ba-field.sonata-ba-field-standard-natural').css({'width': '50%'});
    factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO') + ' .help-block.sonata-ba-field-help').css({'float': 'left', 'left': '40px', 'top': '3px'});

    factoryObjeto('INPUT', CONFIG_OPCOES_MODALIDADE.get('REDUCOES_INCIDENCIA')).on("change", function() {
        if (jQuery(this).val()) {
            factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO')).show();
            factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO') + ' label').text("");
            factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO') + ' label').text(CONFIG_OPCOES_MODALIDADE.get(jQuery(this).val()));
            var referencia = {
                'referencia' : null,
                'valor': null
            };
            if (jQuery(this).val() === 'acrescimo') {
                referencia.referencia = CONFIG_OPCOES_MODALIDADE.get('INCIDENCIA');
                referencia.chave = 'codigo';
                referencia.valor = 'descricao';
            } else if(jQuery(this).val() === 'credito') {
                referencia.referencia = CONFIG_OPCOES_MODALIDADE.get('CREDITOS');
                referencia.chave = 'codigo';
                referencia.valor = 'valor';
            }
            populaReducaoCreditoAcrescimo(CONFIG_MODALIDADE.get('DADOS_AJAX')[referencia.referencia], referencia.valor, referencia.chave);
        }
    });

    initAppendTable(
        CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO'),
        ['#', 'Código', 'Descrição', 'Tipo', 'Tipo de Redução', 'Valor']
    );

    factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('REDUCOES_REGRA_UTILIZACAO')).css({'width': '50%'});
    factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('REDUCOES_REGRA_UTILIZACAO') + ' .sonata-ba-field.sonata-ba-field-standard-natural').css({'width': '50%'});
    factoryObjeto('WRAP_FORM', CONFIG_OPCOES_MODALIDADE.get('REDUCOES_REGRA_UTILIZACAO') + ' .help-block.sonata-ba-field-help').css({'float': 'left', 'left': '40px', 'top': '3px'});

    initAppendTable(
        CONFIG_OPCOES_MODALIDADE.get('REDUCOES_REGRA_UTILIZACAO'),
        ['#', 'Tipo', 'Valor', 'Regra', 'Incidência']
    );

    populaEdit(CONFIG_OPCOES_MODALIDADE.get('REDUCOES_REGRA_UTILIZACAO'));

    validadeDadosListaNotEmptySubmit([CONFIG_OPCOES_MODALIDADE.get('REDUCOES_REGRA_UTILIZACAO')]);
    jQuery(document).on('submit', 'form', function(e) {
        factoryObjeto('INPUT', CONFIG_OPCOES_MODALIDADE.get('CREDITO_ACRESCIMO')).empty().append("<option value=\"\">Selecione</option>").select2("val", "").val('').trigger("change");
    });
});