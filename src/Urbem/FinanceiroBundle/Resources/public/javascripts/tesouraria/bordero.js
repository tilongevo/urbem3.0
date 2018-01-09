/*global $*/
(function () {
    'use strict';
    var entidadeNonMappedField = UrbemSonata.giveMeBackMyField('entidadeNonMapped'),
        fkTesourariaBoletimField = UrbemSonata.giveMeBackMyField('fkTesourariaBoletim'),
        exercicioField = UrbemSonata.giveMeBackMyField('exercicio'),
        fkContabilidadePlanoBanco = UrbemSonata.giveMeBackMyField('fkContabilidadePlanoBanco'),
        codOrdemPagamento = UrbemSonata.giveMeBackMyField('codOrdemPagamento'),
        banco = UrbemSonata.giveMeBackMyField('banco'),
        agencia = UrbemSonata.giveMeBackMyField('agencia');


    function configHtml(sumIndex, item) {
        return {
            buildTable: buildTable(),
            buildInputHidden: buildInputHidden()
        };
        function buildTable() {
            var html = "<tr>" +
                "<td>" + sumIndex + "</td>" +
                "<td>" + item.entidade + "</td>" +
                "<td>" + item.op + "</td>" +
                "<td>" + item.notaEmpenho + "</td>" +
                "<td>" + item.credor + "</td>" +
                "<td>" + item.vlTotalLiquidacao + "</td>" +
                "<td><a href='javascript://Remover' class='item-" + item.codOrdemPag + "'><i class='fa fa-trash fa-lg' aria-hidden='true'></i></a></td>" +
                "</tr>";

            return html
        }

        function buildInputHidden() {
            var htmlForm =
                    "<div class='hiddenRegistros'>" +
                    "<input type='hidden' name='registros[" + sumIndex + "][entidade]' value='" + item.entidade + "' >" +
                    "<input type='hidden' name='registros[" + sumIndex + "][codNota]' value='" + item.codNota + "' >" +
                    "<input type='hidden' name='registros[" + sumIndex + "][vlPago]' value='" + item.vlPago + "' >" +
                    "<input type='hidden' name='registros[" + sumIndex + "][codOrdemPag]' value='" + item.codOrdemPag + "' >" +
                    "<input type='hidden' name='registros[" + sumIndex + "][banco]' value='" + item.banco + "' >" +
                    "<input type='hidden' name='registros[" + sumIndex + "][agencia]' value='" + item.agencia + "' >" +
                    "<input type='hidden' name='registros[" + sumIndex + "][contaCorrente]' value='" + item.contaCorrente + "' >" +
                    "<input type='hidden' name='registros[" + sumIndex + "][codTipo]' value='" + item.codTipo + "' >" +
                    "<input type='hidden' name='registros[" + sumIndex + "][observacao]' value='" + item.observacao + "' >" +
                    "</div>"
                ;
            return htmlForm;
        }
    }

    function objectTable() {
        var table = 'table.registrosBordero';
        return {
            aHref: aHref(),
            body: body(),
            hiddenRegistros: hiddenRegistros()
        };

        function aHref() {
            return jQuery(table + ' tbody a');
        }

        function body() {
            return jQuery(table + ' tbody')
        }

        function hiddenRegistros() {
            return jQuery(table + ' .hiddenRegistros')
        }
    }

    var populateSelect = function (select, data, prop) {
        habilitarDesabilitar(select, false);
        var firstOption = select.find('option:first-child');

        select.empty().append(firstOption);

        $.each(data, function (index, item) {
            var option = $('<option>', {value: item[prop.value], text: item[prop.text]});
            select.append(option);
        });

        select.select2();
    };

    var clear = function (select) {
        select.empty().append("<option value=\"\">Selecione</option>").select2("val", "").val('').trigger("change");
    };

    var habilitarDesabilitar = function habilitarDesabilitarSelect(target, optionBoolean) {
        target.prop('disabled', optionBoolean);
    };

    var functionAjax = function (url, dados, tag, method) {
        var params = {
            url: url,
            dataType: "json",
            method: method,
            success: function (data) {
                sucessoAjax(data.dados, tag);
            }
        };

        if (method == "POST") {
            params.data = dados;
        }

        jQuery.ajax(params);
    };

    var sucessoAjax = function (data, tag) {
        habilitarDesabilitar(tag, false);
        var tagName = tag.prop("tagName");
        if (tagName == "SELECT") {
            $.each(data, function (index, value) {
                var aux = tag.val();
                if (index == aux) {
                    tag
                        .append("<option value=" + index + " selected>" + value + "</option>");
                } else {
                    tag
                        .append("<option value=" + index + ">" + value + "</option>");
                }
            });
            tag.select2();
        }
    };

    var populateOrdemPagamento = function (codEntidade, exercicio, codPlano) {
        if (!codEntidade || !codPlano || !exercicio) {
            return false;
        }

        functionAjax(
            '/financeiro/tesouraria/pagamentos/bordero/busca-ordem-pagamento/',
            {codEntidade: codEntidade, codPlano: codPlano, exercicio: exercicio},
            codOrdemPagamento,
            'POST'
        );
    };

    var populateAgencia = function (codBanco) {
        if (!codBanco) {
            return false;
        }

        functionAjax(
            '/financeiro/tesouraria/pagamentos/bordero/busca-agencias/',
            {codBanco: codBanco},
            agencia,
            'POST'
        );
    };

    var registros = [];
    var registro = {};
    var adapterAjax = function (url, dados, tag, method) {

        var params = {
            url: url,
            dataType: "json",
            method: method,
            data: dados,
            success: function (data) {
                registro = data.dados;
                if (registro) {
                    jQuery('.incluir-registro').show();
                    populaInputsValores(registro);
                }
            }
        };

        jQuery.ajax(params);
    };

    var populaInputsValores = function (data) {
        UrbemSonata.giveMeBackMyField('valor').val(data.valor);
        UrbemSonata.giveMeBackMyField('valorPago').val(data.vlPago);
        UrbemSonata.giveMeBackMyField('valorLiquido').val(data.vlTotalLiquidacao);
        UrbemSonata.giveMeBackMyField('credor').val(data.credor);
    };

    var clearInputsValores = function () {
        UrbemSonata.giveMeBackMyField('valor').val("");
        UrbemSonata.giveMeBackMyField('valorPago').val("");
        UrbemSonata.giveMeBackMyField('valorLiquido').val("");
        UrbemSonata.giveMeBackMyField('credor').val("");
        UrbemSonata.giveMeBackMyField('banco').trigger("change");
        clear(UrbemSonata.giveMeBackMyField('agencia'));
        UrbemSonata.giveMeBackMyField('contaCorrente').val("");
        UrbemSonata.giveMeBackMyField('observacao').val("");
    };

    jQuery('.incluir-registro').on('click', function () {
        var result = $.grep(registros, function (e) {
            if (e) {
                return e.codOrdemPag == registro.codOrdemPag;
            }
        });
        if (result.length == 0) {
            if (validaCamposParaAddRegistro()) {
                registro.observacao = UrbemSonata.giveMeBackMyField('observacao').val();
                registro.banco = UrbemSonata.giveMeBackMyField('banco').val();
                registro.agencia = UrbemSonata.giveMeBackMyField('agencia').val();
                registro.contaCorrente = UrbemSonata.giveMeBackMyField('contaCorrente').val();
                registro.codTipo = UrbemSonata.giveMeBackMyField('codTipo').val();
                registros.push(registro);
                updateListaRegistros();
                clearInputsValores();
                jQuery('.incluir-registro').hide();
            }
        }
    });

    var removerItem = function () {
        (objectTable()).aHref.on('click', function (e) {
            var item = jQuery(this).attr('class').replace('item-', '');
            $.grep(registros, function (e, i) {
                if (e) {
                    if (e.codOrdemPag == item) {
                        delete registros[i];
                        updateListaRegistros();
                    }
                }
            });
        });
    };

    var validaCamposParaAddRegistro = function () {

        var campos = [
            UrbemSonata.giveMeBackMyField('valor'),
            UrbemSonata.giveMeBackMyField('valorPago'),
            UrbemSonata.giveMeBackMyField('valorLiquido'),
            UrbemSonata.giveMeBackMyField('credor'),
            UrbemSonata.giveMeBackMyField('banco'),
            UrbemSonata.giveMeBackMyField('agencia'),
            UrbemSonata.giveMeBackMyField('contaCorrente'),
            UrbemSonata.giveMeBackMyField('observacao')
        ];
        var retorno = true;
        campos.forEach(function (campo, index, arr) {
            if (campo.val().length == 0) {
                retorno = false;
            }
        });
        return retorno;

    };

    var updateListaRegistros = function () {
        (objectTable()).body.html("");
        (objectTable()).hiddenRegistros.remove();
        registros.forEach(function (item, index, arr) {
            var sumIndex = (parseInt(index) + 1);
            var html = configHtml(sumIndex, item);
            (objectTable()).body.append(html.buildTable);
            (objectTable()).body.after(html.buildInputHidden);
        });
        removerItem();
    };

    var populateFkContabilidadePlanoBanco = function (codEntidade) {
        if (!codEntidade) {
            return false;
        }
        functionAjax(
            '/financeiro/tesouraria/pagamentos/bordero/' + codEntidade + '/busca-conta/',
            null,
            fkContabilidadePlanoBanco,
            'GET'
        );
    };

    var buscaValores = function (codOrdemPagamento, exercicio, codEntidade, codPlano) {
        if (!codOrdemPagamento || !exercicio || !codEntidade || !codPlano) {
            return false;
        }
        adapterAjax(
            '/financeiro/tesouraria/pagamentos/bordero/busca-valores-ordem-pagamento/',
            {codOrdemPagamento: codOrdemPagamento, exercicio: exercicio, codEntidade: codEntidade, codPlano: codPlano},
            codOrdemPagamento,
            'POST'
        );
    };

    var populateBoletimField = function (codEntidade) {
        $.get('/financeiro/api/search/boletim', {
            cod_entidade: codEntidade
        }).success(function (data) {
            populateSelect(fkTesourariaBoletimField, data, {
                value: 'value',
                text: 'label'
            });
        });
    };

    entidadeNonMappedField.on('change', function (e) {
        habilitarDesabilitar(fkContabilidadePlanoBanco, true);
        habilitarDesabilitar(fkTesourariaBoletimField, true);
        clear(fkContabilidadePlanoBanco);
        clear(fkTesourariaBoletimField);
        populateFkContabilidadePlanoBanco(entidadeNonMappedField.val());
        populateBoletimField(entidadeNonMappedField.val());
    });

    banco.on('change', function (e) {
        habilitarDesabilitar(agencia, true);
        clear(agencia);
        populateAgencia(banco.val());
    });

    fkContabilidadePlanoBanco.on('change', function (e) {
        ordemPagamento();
    });

    codOrdemPagamento.on('change', function (e) {
        buscaValoresOrdemPagamento();
    });

    var ordemPagamento = function () {
        habilitarDesabilitar(codOrdemPagamento, true);
        clear(codOrdemPagamento);
        populateOrdemPagamento(entidadeNonMappedField.val(), exercicioField.val(), fkContabilidadePlanoBanco.val());
    };

    var buscaValoresOrdemPagamento = function () {
        buscaValores(codOrdemPagamento.val(), exercicioField.val(), entidadeNonMappedField.val(), fkContabilidadePlanoBanco.val());
    };

    jQuery('.btn-success.save').on('click', function (e) {
        clear(codOrdemPagamento);
        if (registros.length <= 0) {
            e.preventDefault();
            e.stopPropagation();
        }
    });

}());


