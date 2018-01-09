if ($('#codNivel').val() != undefined && $('#codNivel').val() != '') {
    var params = {
        tabela: "CoreBundle:Imobiliario\\Localizacao",
        fkTabela: "getFkImobiliarioAtributoNivelValores",
        tabelaPai: "CoreBundle:Imobiliario\\Nivel",
        codTabelaPai: {
            codNivel: $('#codNivel').val(),
            codVigencia: $('#codVigencia').val()
        },
        fkTabelaPaiCollection: "getFkImobiliarioAtributoNiveis",
        fkTabelaPai: "getFkImobiliarioAtributoNivel"
    };

    if($('#codLocalizacao').val() != 0 || $('#codLocalizacao').val() != '') {
        params.codTabela = $('#codLocalizacao').val();
    }

    AtributoDinamicoComponent.getAtributoDinamicoFields(params);
}

var vigencia = UrbemSonata.giveMeBackMyField('fkImobiliarioVigencia'),
    nivel = UrbemSonata.giveMeBackMyField('fkImobiliarioNivel'),
    localizacaoContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkImobiliarioLocalizacao'),
    localizacao = UrbemSonata.giveMeBackMyField('fkImobiliarioLocalizacao'),
    codLocalizacao = UrbemSonata.giveMeBackMyField('codLocalizacao'),
    id = UrbemSonata.giveMeBackMyField('id'),
    nomLocalizacao = UrbemSonata.giveMeBackMyField('nomLocalizacao'),
    filtroVigencia = $('#filter_fkImobiliarioVigencia_value'),
    filtroCodigoComposto = $('#filter_codigoComposto_value'),
    submitStatus = true;


if (filtroVigencia != undefined) {
    if (filtroVigencia.val() == '') {
        filtroCodigoComposto.attr('disabled', true);
    } else {
        carregaMascaraFiltro(filtroVigencia.val());
    }

    filtroVigencia.on('change', function () {
        carregaMascaraFiltro($(this).val());
    });

    function carregaMascaraFiltro(codVigencia) {
        filtroCodigoComposto.attr('disabled', true);
        if ((codVigencia != '') && (codVigencia != undefined)) {
            $.ajax({
                url: "/tributario/cadastro-imobiliario/localizacao/consultar-mascara-filtro",
                method: "POST",
                data: {codVigencia: codVigencia},
                dataType: "json",
                success: function (data) {
                    filtroCodigoComposto.mask(data);
                    filtroCodigoComposto.attr('disabled', false);
                    filtroCodigoComposto.val(filtroCodigoComposto.val());
                    filtroCodigoComposto.focus();
                }
            });
        }
    }
}

if (vigencia != undefined) {
    if ((vigencia.attr('disabled') == undefined) || ((nivel.val() == '') || (nivel.val() == 1))) {
        if (localizacao.val() == '') {
            localizacaoContainer.hide();
            localizacao.attr('required', false);
        }
        nivel.attr('disabled', true);
    }

    if (vigencia.val() != '') {
        carregaNivel(vigencia.val());
    }

    vigencia.on('change', function () {
        carregaNivel($(this).val());
    });

    if ((nivel.val() != '') && (vigencia.val() != '')) {
        carregaLocalizacao(vigencia.val(), nivel.val());
        carregaMascara(vigencia.val(), nivel.val());
    }

    nivel.on('change', function () {
        if (vigencia.val() != '') {
            carregaLocalizacao(vigencia.val(), $(this).val());
            carregaMascara(vigencia.val(), $(this).val());
        }
    });

    nomLocalizacao.keydown(function (event) {
        if ($(this).val().length >= 80 && (event.which != 8 && event.which != 16 && event.which != 37 && event.which != 39)) {
            return false;
        }
    });

    function limpaCampo(campo, placeholder) {
        campo.empty();
        if (placeholder) {
            campo.append("<option value=\"\">Selecione</option>");
        }
        campo.select2("val", "");
    }

    function carregaNivel(codVigencia) {
        nivel.attr('disabled', true);
        if (codVigencia == '') {
            limpaCampo(nivel, true);
        } else {
            $.ajax({
                url: "/tributario/cadastro-imobiliario/localizacao/consultar-nivel",
                method: "POST",
                data: {codVigencia: codVigencia},
                dataType: "json",
                success: function (data) {
                    var selected = nivel.val();
                    limpaCampo(nivel, true);
                    $.each(data, function (index, value) {
                        if (selected == index) {
                            nivel.append("<option value=" + index + " selected>" + value + "</option>");
                        } else {
                            nivel.append("<option value=" + index + ">" + value + "</option>");
                        }
                    });
                    nivel.select2("val", selected);
                    carregaAtributos(selected, vigencia.val(), id.val());
                    if (vigencia.attr('disabled') == undefined) {
                        nivel.attr('disabled', false);
                    }
                }
            });
        }
    }

    function carregaLocalizacao(codVigencia, codNivel) {
        localizacao.attr('disabled', true);
        if ((codVigencia == '') && (codNivel == '')) {
            limpaCampo(nivel, true);
            limpaCampo(localizacao, true);
        } else {
            if (parseInt(codNivel) - 1) {
                $.ajax({
                    url: "/tributario/cadastro-imobiliario/localizacao/consultar-localizacao",
                    method: "POST",
                    data: {codVigencia: codVigencia, codNivel: parseInt(codNivel) - 1},
                    dataType: "json",
                    success: function (data) {
                        var selected = localizacao.val();
                        limpaCampo(localizacao, true);
                        var aux = [];
                        $.each(data, function (index, value) {
                            aux.push(index);
                            if (selected == index) {
                                localizacao.append("<option value=" + index + " selected>" + value + "</option>");
                            } else {
                                localizacao.append("<option value=" + index + ">" + value + "</option>");
                            }
                        });
                        if ($.inArray( selected, aux ) < 0) {
                            selected = '';
                        }
                        localizacao.select2("val", selected);
                        localizacaoContainer.show();
                        localizacao.attr('required', true);
                        if (vigencia.attr('disabled') == undefined) {
                            localizacao.attr('disabled', false);
                        }
                    }
                });
            } else {
                localizacaoContainer.hide();
            }
        }
    }

    function carregaMascara(codVigencia, codNivel) {
        if ((codVigencia != '') && (codNivel != '')) {
            $.ajax({
                url: "/tributario/cadastro-imobiliario/localizacao/consultar-mascara",
                method: "POST",
                data: {codVigencia: codVigencia, codNivel: codNivel},
                dataType: "json",
                success: function (data) {
                    codLocalizacao.mask(data);
                    codLocalizacao.val(codLocalizacao.val());
                    codLocalizacao.focus();
                }
            });
        }
    }

    nivel.trigger("change");

    nivel.on('change', function () {
        if ($(this).val() != '') {
            carregaAtributos($(this).val(), vigencia.val(), id.val())
        } else {
            $('#atributos-dinamicos').empty();
            $('#atributos-dinamicos').html('<span>Não existem atributos para o item selecionado.</span>');
        }
    });

    $('form').on('submit', function () {
        return submitStatus;
    });

    function carregaAtributos(codNivel, codVigencia, codLocalizacao) {
        if (codNivel == '') {
            $('#atributos-dinamicos').empty();
            $('#atributos-dinamicos').html('<span>Não existem atributos para o item selecionado.</span>');
            return false;
        }
        var params = {
            tabela: "CoreBundle:Imobiliario\\Localizacao",
            fkTabela: "getFkImobiliarioAtributoNivelValores",
            tabelaPai: "CoreBundle:Imobiliario\\Nivel",
            codTabelaPai: {
                codNivel: codNivel,
                codVigencia: codVigencia
            },
            fkTabelaPaiCollection: "getFkImobiliarioAtributoNiveis",
            fkTabelaPai: "getFkImobiliarioAtributoNivel"
        };

        if(codLocalizacao != 0 || codLocalizacao != '') {
            params.codTabela = codLocalizacao;
        }

        AtributoDinamicoComponent.getAtributoDinamicoFields(params);
        $('.atributoDinamicoWith').show();
    }


    if (nivel.val() == '') {
        $('.atributoDinamicoWith').hide();
    }

    codLocalizacao.on('change', function () {
        verificaCodigo(vigencia.val(), nivel.val(), $(this).val(), id.val())
    });

    function verificaCodigo(codVigencia, codNivel, codigo, localizacao) {
        submitStatus = false;
        $('.sonata-ba-field-error-messages').remove();
        $.ajax({
            url: "/tributario/cadastro-imobiliario/localizacao/consultar-codigo",
            method: "POST",
            data: {codVigencia: codVigencia, codNivel: codNivel, codigo: codigo, codLocalizacao: localizacao},
            dataType: "json",
            success: function (data) {
                if (data) {
                    codLocalizacao.val('');
                    var message = '<div class="help-block sonata-ba-field-error-messages">' +
                        '<ul class="list-unstyled">' +
                        '<li><i class="fa fa-exclamation-circle"></i> Localização com o codigo ' + codigo + ' ja existe para este nível!</li>' +
                        '</ul></div>';
                    codLocalizacao.after(message);
                } else {
                    submitStatus = true;
                }
            }
        });
    }
}