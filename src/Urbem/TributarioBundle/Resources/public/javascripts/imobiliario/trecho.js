var uf = UrbemSonata.giveMeBackMyField('fkSwUf'),
    municipio = UrbemSonata.giveMeBackMyField('fkSwMunicipio'),
    bairro = UrbemSonata.giveMeBackMyField('fkSwBairro'),
    logradouro = UrbemSonata.giveMeBackMyField('fkSwLogradouro'),
    sequencia = UrbemSonata.giveMeBackMyField('sequencia'),
    extensao = UrbemSonata.giveMeBackMyField('extensao'),
    codTrecho = UrbemSonata.giveMeBackMyField('codTrecho'),
    filterUf = $('#filter_fkSwUf_value'),
    filterMunicipio = $('#filter_fkSwMunicipio_value'),
    filterBairro = $('#filter_fkSwBairro_value'),
    filterLogradouro = $('#filter_fkSwLogradouro_value'),
    submitStatus = true;

if ($('#codLogradouro').val() != undefined && $('#codLogradouro').val() != '') {
    var params = {
        entidade: "CoreBundle:Imobiliario\\Trecho",
        fkEntidadeAtributoValor: "getFkImobiliarioAtributoTrechoValores",
        codModulo: "12",
        codCadastro: "7",
        codEntidade: {
            codTrecho: $('#codTrecho').val(),
            codLogradouro: $('#codLogradouro').val()
        }
    };

    AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(params);
} else if (filterUf.val() == undefined) {
    var valorExtensao = extensao.val();

    extensao.mask('000.000,00', {reverse: true});
    extensao.val(UrbemSonata.convertFloatToMoney(UrbemSonata.convertMoneyToFloat(valorExtensao)));

    municipio.attr('disabled', true);
    bairro.attr('disabled', true);
    logradouro.attr('disabled', true);
    if (codTrecho.val() != '') {
        uf.attr('disabled', true);
        sequencia.attr('disabled', true);
    }

    if (uf.val() != '' && municipio.val() != '') {
        carregaMunicipios(uf.val(), municipio, bairro, logradouro, codTrecho.val(), true, false);
    }

    uf.on('change', function () {
        carregaMunicipios($(this).val(), municipio, bairro, logradouro, codTrecho.val(), true, false);
    });

    municipio.on('change', function () {
        carregaBairros(uf.val(), $(this).val(), bairro, logradouro, codTrecho.val(), true, false);
    });

    bairro.on('change', function () {
        carregaLogradouro(uf.val(), municipio.val(), $(this).val(), logradouro, codTrecho.val(), true, true);
    });

    logradouro.on('change', function () {
        carregaSequencia($(this).val());
    });

    var params = {
        entidade: "CoreBundle:Imobiliario\\Trecho",
        fkEntidadeAtributoValor: "getFkImobiliarioAtributoTrechoValores",
        codModulo: "12",
        codCadastro: "7"
    };

    if(codTrecho.val() != 0 || codTrecho.val() != '') {
        params.codEntidade = {
            codTrecho: codTrecho.val(),
            codLogradouro: logradouro.val()
        };
    }
    AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(params);

    sequencia.on('change', function () {
        if (logradouro.val() != '') {
            verificaSequencia(codTrecho.val(), logradouro.val(), $(this).val());
        }
    });

    $('form').submit(function() {
        extensao.val(UrbemSonata.convertMoneyToFloat(extensao.val()));
        return submitStatus;
    });
} else {
    if (filterUf.val() == '') {
        filterMunicipio.attr('disabled', true);
        filterBairro.attr('disabled', true);
        filterLogradouro.attr('disabled', true);
    } else {
        carregaMunicipios(filterUf.val(), filterMunicipio, filterBairro, filterLogradouro, '', false, false);
    }

    filterUf.on('change', function () {
        carregaMunicipios($(this).val(), filterMunicipio, filterBairro, filterLogradouro, '', false, true);
    });

    filterMunicipio.on('change', function () {
        carregaBairros(filterUf.val(), $(this).val(), filterBairro, filterLogradouro, '', false, true);
    });

    filterBairro.on('change', function () {
        carregaLogradouro(filterUf.val(), filterMunicipio.val(), $(this).val(), filterLogradouro, '', false, true);
    })
}

function clearSelect(campo, placeholder) {
    campo.empty();
    if (placeholder) {
        campo.append('<option value="">Selecione</option>');
    }
    campo.select2('val', '');
}

function carregaMunicipios(codUf, campoMunicipio, campoBairro, campoLogradouro, codTrecho, placeholder, limpar) {
    campoMunicipio.attr('disabled', true);
    campoBairro.attr('disabled', true);
    campoLogradouro.attr('disabled', true);
    var selected = campoMunicipio.val();
    clearSelect(campoMunicipio, placeholder);
    $.ajax({
        url: "/tributario/logradouro/municipio",
        method: "POST",
        data: {codUf: codUf},
        dataType: "json",
        success: function (data) {
            $.each(data, function (index, value) {
                if (selected == index) {
                    campoMunicipio.append("<option value=" + index + " selected>" + value + "</option>");
                } else {
                    campoMunicipio.append("<option value=" + index + ">" + value + "</option>");
                }
            });
            if (codTrecho == '') {
                campoMunicipio.attr('disabled', false);
            }
            if (limpar) {
                selected = '';
                clearSelect(campoBairro, placeholder);
                clearSelect(campoLogradouro, placeholder);
            }
            campoMunicipio.select2('val', selected);
            if (selected != '') {
                carregaBairros(codUf, selected, campoBairro, campoLogradouro, codTrecho, placeholder, limpar);
            }
        }
    });
}

function carregaBairros(codUf, codMunicipio, campoBairro, campoLogradouro, codTrecho, placeholder, limpar) {
    campoBairro.attr('disabled', true);
    campoLogradouro.attr('disabled', true);
    var selected = campoBairro.val();
    clearSelect(campoBairro, placeholder);
    $.ajax({
        url: "/tributario/logradouro/bairro",
        method: "POST",
        data: {codUf: codUf, codMunicipio: codMunicipio},
        dataType: "json",
        success: function (data) {
            $.each(data, function (index, value) {
                if (selected == index) {
                    campoBairro.append("<option value=" + index + " selected>" + value + "</option>");
                } else {
                    campoBairro.append("<option value=" + index + ">" + value + "</option>");
                }
            });
            if (codTrecho == '') {
                campoBairro.attr('disabled', false);
            }
            if (limpar) {
                selected = '';
                clearSelect(campoLogradouro, placeholder);
            }
            campoBairro.select2('val', selected);
            carregaLogradouro(codUf, codMunicipio, selected, campoLogradouro, codTrecho, placeholder, limpar);
        }
    });
}

function carregaLogradouro(codUf, codMunicipio, codBairro, campoLogradouro, codTrecho, placeholder, limpar) {
    campoLogradouro.attr('disabled', true);
    var selected = campoLogradouro.val();
    clearSelect(campoLogradouro, placeholder);
    $.ajax({
        url: "/tributario/logradouro/logradouro",
        method: "POST",
        data: {codUf: codUf, codMunicipio: codMunicipio, codBairro: codBairro},
        dataType: "json",
        success: function (data) {
            $.each(data, function (index, value) {
                if (selected == index) {
                    campoLogradouro.append("<option value=" + index + " selected>" + value + "</option>");
                } else {
                    campoLogradouro.append("<option value=" + index + ">" + value + "</option>");
                }
            });
            if (codTrecho == '') {
                campoLogradouro.attr('disabled', false);
            }
            if (limpar) {
                selected = '';
            }
            campoLogradouro.select2('val', selected);
        }
    });
}

function carregaSequencia(codLogradouro) {
    $.ajax({
        url: "/tributario/cadastro-imobiliario/trecho/consultar-proxima-sequencia",
        method: "POST",
        data: {codLogradouro: codLogradouro},
        dataType: "json",
        success: function (data) {
            sequencia.val(data);
            extensao.val(extensao.val());
            extensao.focus();
        }
    });
}

function verificaSequencia(codigo, codLogradouro, valor) {
    submitStatus = false;
    $('.sonata-ba-field-error-messages').remove();
    $.ajax({
        url: "/tributario/cadastro-imobiliario/trecho/consultar-sequencia",
        method: "POST",
        data: {codTrecho: codigo, codLogradouro: codLogradouro, sequencia: valor},
        dataType: "json",
        success: function (data) {
            if (data) {
                sequencia.val('');
                var message = '<div class="help-block sonata-ba-field-error-messages">' +
                    '<ul class="list-unstyled">' +
                    '<li><i class="fa fa-exclamation-circle"></i> A sequência ' + valor + ' já foi informada para este logradouro!</li>' +
                    '</ul></div>';
                sequencia.after(message);
            } else {
                submitStatus = true;
            }
        }
    });
}
