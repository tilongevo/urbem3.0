$(document).ready(function() {
    'use strict';

    var entidade = UrbemSonata.giveMeBackMyField('codEntidade'),
        exercicio = UrbemSonata.giveMeBackMyField('exercicio'),
        dtAutorizacao = UrbemSonata.giveMeBackMyField('dtAutorizacao'),
        dotacaoOrcamentaria = UrbemSonata.giveMeBackMyField('codDespesa'),
        desdobramento = UrbemSonata.giveMeBackMyField('codClassificacao'),
        saldoDotacao = UrbemSonata.giveMeBackMyField('saldoDotacao'),
        orgao = UrbemSonata.giveMeBackMyField('numOrgao'),
        unidade = UrbemSonata.giveMeBackMyField('numUnidade'),
        fornecedor = $("input[name='" + UrbemSonata.uniqId + "[fkSwCgm]']"),
        categoriaEmpenho = UrbemSonata.giveMeBackMyField('codCategoria'),
        contaContrapartida = UrbemSonata.giveMeBackMyField('contaContrapartida'),
        dotacaoOrcamentariaOld = '',
        total = UrbemSonata.giveMeBackMyField('total'),
        totalReserva = UrbemSonata.giveMeBackMyField('totalReserva');

    if (dtAutorizacao.val() == undefined) {
        return false;
    }

    dtAutorizacao.on('change', function () {
        if (!$(this).attr('min')) {
            return false;
        }
        $('.sonata-ba-field-error-messages').remove();
        validarDtAutorizacao($(this));
    });

    function validarDtAutorizacao(fieldDtAutorizacao) {
        var dtAtual = new Date(),
            res1 = fieldDtAutorizacao.val().split("/"),
            date1 = new Date(res1[2], (parseInt(res1[1]) -1), res1[0],0,0,0),
            res2 = fieldDtAutorizacao.attr('min').split("-"),
            date2 = new Date(res2[0], (parseInt(res2[1]) -1), res2[2],0,0,0),
            minDate = date2.getDate() + '/' + res2[1] + '/' + date2.getFullYear();
        if (date1 < date2) {
            UrbemSonata.setFieldErrorMessage('dtAutorizacao', 'Data da Autorização deve ser maior ou igual a \'' + minDate + '\'!', fieldDtAutorizacao.parent().parent());
            fieldDtAutorizacao.parent().parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
            fieldDtAutorizacao.val(minDate);
            return false;
        } else if (date1 > dtAtual) {
            UrbemSonata.setFieldErrorMessage('dtAutorizacao', 'Data da Autorização deve ser menor ou igual a data atual!', fieldDtAutorizacao.parent().parent());
            fieldDtAutorizacao.parent().parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
            fieldDtAutorizacao.val(minDate);
            return false;
        }
        return true;
    }

    UrbemSonata.sonataFieldContainerHide("_contaContrapartida");

    dotacaoOrcamentaria.attr('disabled', true);
    desdobramento.attr('disabled', true);
    orgao.attr('disabled', true);
    unidade.attr('disabled', true);

    if (entidade.val() !== '') {
        entidade.attr('disabled', true);
        dotacaoOrcamentaria.attr('disabled', false);
        if (desdobramento.val() !== '') {
            desdobramento.attr('disabled', false);
        }
        orgao.attr('disabled', false);
        unidade.attr('disabled', false);

        if (dotacaoOrcamentaria.val() !== '') {
            dotacaoOrcamentariaOld = dotacaoOrcamentaria.val();
            dotacaoOrcamentaria.attr('required', true);
            $('#' + UrbemSonata.uniqId + '_numOrgao > option').each(function() {
                if (this.selected === false) {
                    this.remove();
                }
            });

            $('#' + UrbemSonata.uniqId + '_numUnidade > option').each(function() {
                if (this.selected === false) {
                    this.remove();
                }
            });
        }
    }

    entidade.on('change', function () {
        getDtAutorizacao($(this).val(), exercicio.val(), dtAutorizacao);
    });

    function getDtAutorizacao(codEntidade, exercicio) {
        if (codEntidade == '') {
            dtAutorizacao.val('');
            clearSelect(dotacaoOrcamentaria);
            clearSelect(desdobramento);
            clearSelect(orgao);
            clearSelect(unidade);
            saldoDotacao.val('');
            return false;
        }
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando data da autorização...</h4>');
        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-dt-autorizacao",
            method: "POST",
            data: {
                codEntidade: codEntidade,
                exercicio: exercicio
            },
            dataType: "json",
            success: function (data) {
                dtAutorizacao.prop('disabled', false);
                if (typeof(data) == "string") {
                    var res = data.split("/");
                    dtAutorizacao.attr('min', res[2] + '-' + res[1] + '-' + res[0]);
                    dtAutorizacao.val(data);
                } else {
                    dtAutorizacao.val('');
                }
                fechaModal();
                getDotacao(codEntidade, exercicio);
            }
        });
    }

    function getDotacao(codEntidade, exercicio) {
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando dotações orçamentárias...</h4>');
        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-dotacao",
            method: "POST",
            data: {
                codEntidade: codEntidade,
                exercicio: exercicio
            },
            dataType: "json",
            success: function (data) {
                dotacaoOrcamentaria
                    .attr('disabled', false)
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                for (var i in data) {
                    dotacaoOrcamentaria.append("<option value=" + i + ">" + data[i] + "</option>");
                }

                dotacaoOrcamentaria.select2('val', '');
                fechaModal();
                getOrgaoOrcamentario(codEntidade, exercicio, false, false);
            }
        });
    }

    function getOrgaoOrcamentario(codEntidade, exercicio, numOrgao, numUnidade) {
        if (numOrgao === false) abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando órgãos...</h4>');
        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-orgao-orcamentario",
            method: "POST",
            data: {
                codEntidade: codEntidade,
                exercicio: exercicio
            },
            dataType: "json",
            success: function (data) {
                orgao
                    .attr('disabled', false)
                    .empty();

                if (numOrgao === false) {
                    orgao.append("<option value=\"\">Selecione</option>")
                }

                for (var i in data) {
                    if (numOrgao === false) {
                        orgao.append("<option value=" + i + ">" + data[i] + "</option>");
                    } else if (numOrgao == i) {
                        orgao.append("<option value=" + i + " selected>" + data[i] + "</option>");
                    }
                }

                if (numOrgao === false) {
                    orgao.select2('val', '');
                    unidade.attr('disabled', true).empty().append("<option value=\"\">Selecione</option>").select2('val', '');
                    fechaModal();
                } else {
                    orgao.select2('val', numOrgao);
                    getUnidadeOrcamentaria(numOrgao, codEntidade, numUnidade);
                }
            }
        });
    }

    orgao.on('change', function () {
        getUnidadeOrcamentaria($(this).val(), entidade.val(), false);
    });

    function getUnidadeOrcamentaria(numOrgao, codEntidade, numUnidade) {
        if (numOrgao == '') {
            clearSelect(unidade);
            return false;
        }
        if (numUnidade === false) abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando unidades...</h4>');
        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-unidade-orcamentaria",
            method: "POST",
            data: {
                numOrgao: numOrgao,
                codEntidade: codEntidade
            },
            dataType: "json",
            success: function (data) {
                unidade
                    .attr('disabled', false)
                    .empty();

                if (numUnidade == false) {
                    unidade.append("<option value=\"\">Selecione</option>")
                }

                for (var i in data) {
                    if (numUnidade == false) {
                        unidade.append("<option value=" + i + ">" + data[i] + "</option>");
                    } else if (numUnidade == i) {
                        unidade.append("<option value=" + i + " selected>" + data[i] + "</option>");
                    }
                }

                if (numUnidade === false) {
                    unidade.select2('val', '');
                } else {
                    unidade.select2('val', numUnidade);
                }
                if (numUnidade === false) fechaModal()
            }
        });
    }

    dotacaoOrcamentaria.on('change', function () {
        saldoDotacao.parent().parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
        getSaldoDotacao($(this).val(), entidade.val(), dtAutorizacao.val(), exercicio.val());
    });

    function getSaldoDotacao(codDespesa, codEntidade, dtAutorizacao, exercicio) {
        if (codDespesa == '') {
            saldoDotacao.val('');
            clearSelect(desdobramento);
            getOrgaoOrcamentario(codEntidade, exercicio, false, false);
            return false;
        }
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando saldo da dotação...</h4>');
        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-saldo-dotacao",
            method: "POST",
            data: {
                stExercicio: exercicio,
                inCodDespesa: codDespesa,
                stDataEmpenho: dtAutorizacao,
                inEntidade: codEntidade
            },
            dataType: "json",
            success: function (data) {
                saldoDotacao.val(UrbemSonata.convertFloatToMoney(data));
                fechaModal();
                getDesdobramento(codDespesa, codEntidade, exercicio);
            }
        });
    }

    function getDesdobramento(codDespesa, codEntidade, exercicio) {
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando desdobramentos...</h4>');
        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-desdobramento",
            method: "POST",
            data: {
                codDespesa: codDespesa,
                exercicio: exercicio
            },
            dataType: "json",
            success: function (data) {
                clearSelect(desdobramento);
                desdobramento.attr('disabled', false);
                desdobramento.attr('required', true);

                for (var i in data) {
                    desdobramento.append("<option value=" + i + ">" + data[i] + "</option>");
                }

                desdobramento.select2('val', '');
                fechaModal();
                getOrgaoOrcamentarioDespesa(codDespesa, codEntidade, exercicio)
            }
        });
    }

    function getOrgaoOrcamentarioDespesa(codDespesa, codEntidade, exercicio) {
        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-orgao-orcamentario-despesa",
            method: "POST",
            data: {
                codEntidade: codEntidade,
                exercicio: exercicio,
                codDespesa: codDespesa
            },
            dataType: "json",
            success: function (data) {
                getOrgaoOrcamentario(codEntidade, exercicio, data.num_orgao, data.num_unidade);
            }
        });
    }

    if (categoriaEmpenho.val() != 1) {
        UrbemSonata.sonataFieldContainerShow("_contaContrapartida", true);
    }

    categoriaEmpenho.on("change", function () {
        if (($(this).val() != 1) && (fornecedor.val() != '')) {
            getContrapartida(fornecedor.val(), exercicio.val());
        } else {
            clearSelect(contaContrapartida);
            UrbemSonata.sonataFieldContainerHide("_contaContrapartida");
        }
    });

    $('#' + UrbemSonata.uniqId + '_fkSwCgm_autocomplete_input').on('change', function () {
       categoriaEmpenho.select2('val', 1);
       clearSelect(contaContrapartida);
       UrbemSonata.sonataFieldContainerHide("_contaContrapartida");
    });

    function getContrapartida(numcgm, exercicio)
    {
        $.ajax({
            url: "/financeiro/empenho/autorizacao/get-contrapartida",
            method: "POST",
            data: {
                exercicio: exercicio,
                numcgm: numcgm
            },
            dataType: "json",
            success: function (data) {
                contaContrapartida
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                if (data.length === 0) {
                    UrbemSonata.setFieldErrorMessage('categoriaEmpenho', 'O responsável por adiantamento informado não está cadastrado ou está inativo.', categoriaEmpenho.parent());
                    categoriaEmpenho.select2('val', 1);
                } else {
                    UrbemSonata.sonataFieldContainerShow("_contaContrapartida", true);
                    contaContrapartida.attr('disabled', false);
                    contaContrapartida.attr('required', true);

                    for (var i in data) {
                        contaContrapartida.append("<option value=" + i + ">" + data[i] + "</option>");
                    }

                    contaContrapartida.select2('val', '');
                }
            }
        });
    }

    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_codCategoria').on('mouseover', function () {
        categoriaEmpenho.parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
    });

    function clearSelect(field) {
        field.attr('disabled', true).empty().append("<option value=\"\">Selecione</option>").select2('val', '');
    }

    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_saldoDotacao').on('mouseover', function () {
        saldoDotacao.parent().parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
    });

    $('form').on('submit', function () {
        if (!validarDtAutorizacao(dtAutorizacao)) {
            return false;
        }
        if (dotacaoOrcamentariaOld !== '') {
            if ((dotacaoOrcamentariaOld !== dotacaoOrcamentaria.val()) && (UrbemSonata.convertMoneyToFloat(saldoDotacao.val()) < total.val())) {
                UrbemSonata.setFieldErrorMessage('saldoDotacao', 'O Saldo da Dotação é menor que o Valor Total da Autorização! (R$' + UrbemSonata.convertFloatToMoney(total.val()) + ')', saldoDotacao.parent().parent());
                return false;
            }
        }
        entidade.attr('disabled', false);
    });
}());