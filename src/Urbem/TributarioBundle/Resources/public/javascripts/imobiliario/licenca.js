$(function () {
    "use strict";

    var codTipo = UrbemSonata.giveMeBackMyField('codTipo'),
        profissao = UrbemSonata.giveMeBackMyField('fkCseProfissao'),
        uf = UrbemSonata.giveMeBackMyField('fkSwUf'),
        localizacao = UrbemSonata.giveMeBackMyField('fkImobiliarioLocalizacao'),
        lote = UrbemSonata.giveMeBackMyField('fkImobiliarioLote'),
        loteamento = UrbemSonata.giveMeBackMyField('fkImobiliarioLoteamento'),
        tipoParcelamento = UrbemSonata.giveMeBackMyField('fkImobiliarioTipoParcelamento'),
        parcelamentoSolo = UrbemSonata.giveMeBackMyField('fkImobiliarioParcelamentoSolo'),
        novaUnidade = 0,
        novaUnidadeConstrucao = UrbemSonata.giveMeBackMyField('novaUnidade_0'),
        novaUnidadeEdificacao = UrbemSonata.giveMeBackMyField('novaUnidade_1'),
        descricao = UrbemSonata.giveMeBackMyField('descricao'),
        tipoEdificacao = UrbemSonata.giveMeBackMyField('fkImobiliarioTipoEdificacao'),
        codConstrucao = UrbemSonata.giveMeBackMyField('codConstrucao'),
        imovel = UrbemSonata.giveMeBackMyField('fkImobiliarioImovel'),
        atributosDinamicos = $('#atributos-dinamicos'),
        construcao = UrbemSonata.giveMeBackMyField('fkImobiliarioConstrucao'),
        codLicenca = UrbemSonata.giveMeBackMyField('codLicenca'),
        exercicio = UrbemSonata.giveMeBackMyField('exercicio');

    if (profissao == undefined) {
        return false;
    }

    $('.atributoDinamicoWith').hide();

    if (codTipo.val() == 7) {
        if (localizacao.val() == '') {
            lote.attr('disabled', true);
            loteamento.attr('disabled', true);
        }
        localizacao.on('change', function () {
            if ($(this).val() != '') {
                clearSelect(lote, true);
                carregarLotes($(this).val());
            }
        });
        lote.on('change', function () {
            if ($(this).val() != '') {
                clearSelect(loteamento, true);
                carregarLoteamentos($(this).val());
            } else {
                clearSelect(lote, true);
                clearSelect(loteamento, true);
            }
        })
    } else if (codTipo.val() == 8 || codTipo.val() == 9) {
        lote.attr('disabled', true);
        parcelamentoSolo.attr('disabled', true);
        localizacao.on('change', function () {
            if ($(this).val() != '') {
                clearSelect(lote, true);
                carregarLotes($(this).val());
            }
        });
        lote.on('change', function () {
            if ($(this).val() != '') {
                clearSelect(parcelamentoSolo, true);
                carregarDesmembramentos($(this).val(), tipoParcelamento.val());
            } else {
                clearSelect(lote, true);
                clearSelect(parcelamentoSolo, true);
            }
        })
    } else if (codTipo.val() == 1) {
        if (localizacao.val() == '') {
            lote.attr('disabled', true);
            imovel.attr('disabled', true);
        }
        localizacao.on('change', function () {
            if ($(this).val() != '') {
                clearSelect(lote, true);
                carregarLotes($(this).val());
            }
        });
        lote.on('change', function () {
            if ($(this).val() != '') {
                clearSelect(imovel, true);
                carregarImoveis($(this).val(), novaUnidade);
            } else {
                clearSelect(lote, true);
                clearSelect(imovel, true);
            }
        });

        if (novaUnidadeConstrucao.attr('checked') == 'checked') {
            tipoEdificacao.parent().parent().hide();
            tipoEdificacao.attr('required', false);
            descricao.parent().parent().show();
            descricao.attr('required', true);
            carregaAtributosConstrucao()
        } else {
            tipoEdificacao.parent().parent().show();
            tipoEdificacao.attr('required', true);
            descricao.parent().parent().hide();
            descricao.attr('required', false);
            carregaAtributosEdificacao(tipoEdificacao.val(), codConstrucao.val());
        }

        novaUnidadeConstrucao.on('ifChecked', function () {
            tipoEdificacao.parent().parent().hide();
            tipoEdificacao.attr('required', false);
            descricao.parent().parent().show();
            descricao.attr('required', true);
            carregaAtributosConstrucao();
        });

        novaUnidadeEdificacao.on('ifChecked', function () {
            tipoEdificacao.select2('val', '');
            tipoEdificacao.parent().parent().show();
            tipoEdificacao.attr('required', true);
            atributosDinamicos.empty().append('<span>Não existem atributos para o item selecionado.</span>');
            descricao.parent().parent().hide();
            descricao.attr('required', false);
            novaUnidade = 1;
            if (lote.val() != '') {
                clearSelect(imovel, true);
                carregarImoveis(lote.val(), novaUnidade);
            }
        });

        tipoEdificacao.on('change', function () {
            carregaAtributosEdificacao($(this).val(), codConstrucao.val());
        });
    } else {
        if (localizacao.val() == '') {
            lote.attr('disabled', true);
            imovel.attr('disabled', true);
            construcao.attr('disabled', true);
        }
        localizacao.on('change', function () {
            if ($(this).val() != '') {
                clearSelect(lote, true);
                carregarLotes($(this).val());
            }
        });
        lote.on('change', function () {
            if ($(this).val() != '') {
                clearSelect(imovel, true);
                clearSelect(construcao, true);
                carregarImoveis($(this).val(), 1);
            } else {
                clearSelect(lote, true);
                clearSelect(imovel, true);
                clearSelect(construcao, true);
            }
        });
        imovel.on('change', function () {
            if ($(this).val() != '') {
                clearSelect(construcao, true);
                carregarConstrucoes($(this).val());
            }
        });
    }

    $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_atributosDinamicosLicenca").hide();
    $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_atributosDinamicosLicenca").after('<div id="atributos-dinamicos-licenca" class="col s12"><span>Não existem atributos para o item selecionado.</span></div>');
    carregaAtributos();
    function carregaAtributos() {
        if (codTipo.val() == 7 || codTipo.val() == 8 || codTipo.val() == 9) {
            var params = {
                entidade: "CoreBundle:Imobiliario\\LicencaLote",
                fkEntidadeAtributoValor: "getFkImobiliarioAtributoTipoLicencaLoteValores",
                codModulo: "12",
                codCadastro: "10",
                fkEntidadeJoin: "fkImobiliarioAtributoTipoLicencas",
                codEntidadeJoin: {codTipo: codTipo.val()},
                codEntidade: {}
            };

            if (codLicenca.val() != undefined && codLicenca.val() != '') {
                params.codEntidade = {
                    codLicenca: codLicenca.val(),
                    exercicio: exercicio.val(),
                    codLote: lote.val()
                }
            }
        } else {
            var params = {
                entidade: "CoreBundle:Imobiliario\\LicencaImovel",
                fkEntidadeAtributoValor: "getFkImobiliarioAtributoTipoLicencaImovelValores",
                codModulo: "12",
                codCadastro: "10",
                fkEntidadeJoin: "fkImobiliarioAtributoTipoLicencas",
                codEntidadeJoin: {codTipo: codTipo.val()},
                codEntidade: {}
            };

            if (codLicenca.val() != undefined && codLicenca.val() != '') {
                params.codEntidade = {
                    codLicenca: codLicenca.val(),
                    exercicio: exercicio.val(),
                    inscricaoMunicipal: imovel.val()
                }
            }
        }

        AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(params, 'atributos-dinamicos-licenca', false);
        $(".atributoDinamicoLicenca").show();
    }

    window.varJsCodProfissao = profissao.val();
    profissao.on("change", function() {
        window.varJsCodProfissao = $(this).val();
    });

    window.varJsCodUf = uf.val();
    uf.on("change", function() {
        window.varJsCodUf = $(this).val();
    });

    function carregaAtributosEdificacao(codTipo, codConstrucao) {
        if (codTipo == '') {
            $('#atributos-dinamicos').empty();
            $('#atributos-dinamicos').html('<span>Não existem atributos para o item selecionado.</span>');
            return false;
        }
        var params = {
            tabela: "CoreBundle:Imobiliario\\ConstrucaoEdificacao",
            fkTabela: "getFkImobiliarioAtributoTipoEdificacaoValores",
            tabelaPai: "CoreBundle:Imobiliario\\TipoEdificacao",
            codTabelaPai: {
                codTipo: codTipo
            },
            fkTabelaPaiCollection: "getFkImobiliarioAtributoTipoEdificacoes",
            fkTabelaPai: "getFkImobiliarioAtributoTipoEdificacao"
        };

        if(codConstrucao != 0 || codConstrucao != '') {
            params.codTabela = { codTipo: codTipo, codConstrucao: codConstrucao };
        }

        AtributoDinamicoComponent.getAtributoDinamicoFields(params);
        $('.atributoDinamicoWith').show();
    }

    function carregaAtributosConstrucao() {
        var params = {
            entidade: "CoreBundle:Imobiliario\\ConstrucaoOutros",
            fkEntidadeAtributoValor: "getFkImobiliarioAtributoConstrucaoOutrosValores",
            codModulo: "12",
            codCadastro: "9",
            codEntidade: {}
        };

        if (codConstrucao.val() != undefined && codConstrucao.val() != '') {
            params.codEntidade = {
                codConstrucao: codConstrucao.val()
            }
        }

        AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(params);
        $(".atributoDinamicoWith").show();
    }

    function carregarConstrucoes(inscricaoMunicipal) {
        construcao.attr('disabled', true);
        var selected = construcao.val();
        $.ajax({
            url: "/tributario/cadastro-imobiliario/licencas/licenca/consultar-construcao",
            method: "POST",
            data: {inscricaoMunicipal: inscricaoMunicipal},
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, value) {
                    if (selected == index) {
                        construcao.append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        construcao.append("<option value=" + index + ">" + value + "</option>");
                    }
                });
                construcao.attr('disabled', false);
                construcao.select2('val', selected);
            }
        });
    }

    function carregarLotes(codLocalizacao) {
        lote.attr('disabled', true);
        var selected = lote.val();
        $.ajax({
            url: "/tributario/cadastro-imobiliario/licencas/licenca/consultar-lote",
            method: "POST",
            data: {codLocalizacao: codLocalizacao},
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, value) {
                    if (selected == index) {
                        lote.append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        lote.append("<option value=" + index + ">" + value + "</option>");
                    }
                });
                lote.attr('disabled', false);
                lote.select2('val', selected);
            }
        });
    }

    function carregarLoteamentos(codLote) {
        loteamento.attr('disabled', true);
        var selected = loteamento.val();
        $.ajax({
            url: "/tributario/cadastro-imobiliario/licencas/licenca/consultar-loteamento",
            method: "POST",
            data: {codLote: codLote},
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, value) {
                    if (selected == index) {
                        loteamento.append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        loteamento.append("<option value=" + index + ">" + value + "</option>");
                    }
                });
                loteamento.attr('disabled', false);
                loteamento.select2('val', selected);
            }
        });
    }

    function carregarDesmembramentos(codLote, codTipo) {
        parcelamentoSolo.attr('disabled', true);
        var selected = parcelamentoSolo.val();
        $.ajax({
            url: "/tributario/cadastro-imobiliario/licencas/licenca/consultar-parcelamento-solo",
            method: "POST",
            data: {codLote: codLote, codTipo: codTipo},
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, value) {
                    if (selected == index) {
                        parcelamentoSolo.append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        parcelamentoSolo.append("<option value=" + index + ">" + value + "</option>");
                    }
                });
                parcelamentoSolo.attr('disabled', false);
                parcelamentoSolo.select2('val', selected);
            }
        });
    }

    function carregarImoveis(codLote, novaUnidade) {
        imovel.attr('disabled', true);
        var selected = imovel.val();
        $.ajax({
            url: "/tributario/cadastro-imobiliario/licencas/licenca/consultar-imovel",
            method: "POST",
            data: {codLote: codLote, novaUnidade: novaUnidade},
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, value) {
                    if (selected == index) {
                        imovel.append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        imovel.append("<option value=" + index + ">" + value + "</option>");
                    }
                });
                imovel.attr('disabled', false);
                imovel.select2('val', selected);
            }
        });
    }

    function clearSelect(campo, placeholder) {
        campo.empty();
        if (placeholder) {
            campo.append('<option value="">Selecione</option>');
        }
        campo.select2('val', '');
    }
}());