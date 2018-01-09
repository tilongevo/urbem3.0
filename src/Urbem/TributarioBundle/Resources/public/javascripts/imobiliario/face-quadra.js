var codFace = UrbemSonata.giveMeBackMyField('codFace'),
    codLocalizacao = UrbemSonata.giveMeBackMyField('fkImobiliarioLocalizacao'),
    trecho = UrbemSonata.giveMeBackMyField('fkImobiliarioTrecho'),
    uf = UrbemSonata.giveMeBackMyField('fkSwUf'),
    municipio = UrbemSonata.giveMeBackMyField('fkSwMunicipio'),
    filterUf = $('#filter_fkSwUf_value'),
    filterMunicipio = $('#filter_fkSwMunicipio_value'),
    filterBairro = $('#filter_fkSwBairro_value'),
    filterLogradouro = $('#filter_fkImobiliarioFaceQuadraTrechos__fkImobiliarioTrecho__fkSwLogradouro_value');

if ($('#codFace').val() != undefined && $('#codLocalizacao').val() != '') {
    var params = {
        entidade: "CoreBundle:Imobiliario\\FaceQuadra",
        fkEntidadeAtributoValor: "getFkImobiliarioAtributoFaceQuadraValores",
        codModulo: "12",
        codCadastro: "8",
        codEntidade: {
            codFace: $('#codFace').val(),
            codLocalizacao: $('#codLocalizacao').val()
        }
    };

    AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(params);
} else if (filterUf.val() != undefined) {
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
        carregaBairros(filterUf.val(), $(this).val(), filterBairro, filterLogradouro, false, true);
    });

    filterBairro.on('change', function () {
        carregaLogradouro(filterUf.val(), filterMunicipio.val(), $(this).val(), filterLogradouro, false, true);
    })
} else {
    uf.attr('required', false);
    municipio.attr('required', false);
    trecho.attr('required', false);

    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkImobiliarioFaceQuadraTrechos').hide();

    if (!codFace.val()) {
        $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_codFace').hide();
    }

    trecho.on('change', function () {
        $(this).parent().parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
        return false;
    });

    codLocalizacao.on('change', function () {
        $(this).parent().parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
        return false;
    });

    $("#manuais").on("click", function() {
        trecho.parent().parent().removeClass('sonata-ba-field-error').parent().removeClass('has-error');
        $('.sonata-ba-field-error-messages').remove();
        if (codLocalizacao.val() != '') {
            codLocalizacao.attr('disabled', true);
        }

        var text = $('select#' + UrbemSonata.uniqId + '_fkImobiliarioTrecho option:selected').text(),
            res = text.split(" - "),
            codigoComposto = res[0],
            res2 = codigoComposto.split('.'),
            codLogradouro = res2[0],
            logradouro = res[1];

        var col = '<tr class="tr-rh row-face-quadra-trecho">' +
            '<td class="td-rh codigo">' +
            '<input type="hidden" value="' + trecho.val() + '~' + codLogradouro +'" id="faceQuadraTrecho_' + trecho.val() + '_' + codLogradouro + '" name="faceQuadraTrecho[' + trecho.val() + '~' + codLogradouro + ']">' + codigoComposto +
            '</td>' +
            '<td class="td-rh codigo">' + logradouro + '</td>' +
            '<td face-quadra-trecho="' + trecho.val() + '~' + codLogradouro +'" class="td-rh remove"><i class="material-icons blue-text text-darken-4">delete</i></td>';

        if ($('#faceQuadraTrecho_' + trecho.val() + '_' + codLogradouro).val() == undefined) {
            if (codLocalizacao.val() != '') {
                consultaFaceQuadraTrecho(codLocalizacao.val(), trecho.val(), codLogradouro, codFace.val(), col);
            } else {
                UrbemSonata.setFieldErrorMessage('fkImobiliarioLocalizacao', 'Selecione uma localização antes de continuar!', codLocalizacao.parent());
                return false;
            }
        } else {
            UrbemSonata.setFieldErrorMessage('fkImobiliarioTrecho', 'Já existe uma face de quadra para a localização e o trecho selecionado!', trecho.parent());
            return false;
        }
        $('.empty-row-face-quadra-trecho').hide();
    });

    $(document).on('click', '.remove', function () {
        $(this).parent().remove();
        if ($(".row-face-quadra-trecho").length <= 0) {
            codLocalizacao.attr('disabled', false);
            $('.empty-row-face-quadra-trecho').show();
        }
    });

    if (uf.val() == '') {
        municipio.attr('disabled', true);
        trecho.attr('disabled', true);
    } else {
        carregaMunicipios(uf.val(), municipio, '', '', trecho, true, false);
    }

    uf.on('change', function () {
        carregaMunicipios($(this).val(), municipio, '', '', trecho, true, true);
    });

    municipio.on('change', function () {
        carregaTrechos(uf.val(), $(this).val(), trecho, true);
    });

    $('form').submit(function() {
        if ($(".row-face-quadra-trecho").length <= 0) {
            UrbemSonata.setFieldErrorMessage('fkImobiliarioTrecho', 'É necessário incluir pelo menos um trecho!', trecho.parent());
            return false;
        } else {
            codLocalizacao.attr('disabled', false);
            return true;
        }
    });

    var params = {
        entidade: "CoreBundle:Imobiliario\\FaceQuadra",
        fkEntidadeAtributoValor: "getFkImobiliarioAtributoFaceQuadraValores",
        codModulo: "12",
        codCadastro: "8"
    };

    if(codFace.val() != 0 || codFace.val() != '') {
        params.codEntidade = {
            codFace: codFace.val(),
            codLocalizacao: codLocalizacao.val()
        };
    }
    AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(params);
}

function consultaFaceQuadraTrecho(codLocalizacao, codTrecho, codLogradouro, codFace, col) {
    return $.ajax({
        url: "/tributario/cadastro-imobiliario/face-quadra/consulta-face-quadra-trecho",
        method: "POST",
        data: {
            codLocalizacao: codLocalizacao,
            codTrecho: codTrecho,
            codLogradouro: codLogradouro,
            codFace: codFace
        },
        dataType: "json",
        success: function (data) {
            if (!data) {
                $('#tableFaceQuadraTrechoManuais').append(col);
            } else {
                UrbemSonata.setFieldErrorMessage('fkImobiliarioTrecho', 'Já existe uma face de quadra para a localização e o trecho selecionado!', trecho.parent());
            }
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

function carregaMunicipios(codUf, campoMunicipio, campoBairro, campoLogradouro, campoTrecho, placeholder, limpar) {
    campoMunicipio.attr('disabled', true);
    if (campoTrecho != '') {
        campoTrecho.attr('disabled', true);
    } else {
        campoBairro.attr('disabled', true);
        campoLogradouro.attr('disabled', true);
    }
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
            if (limpar) {
                selected = '';
                if (campoTrecho != '') {
                    clearSelect(campoTrecho, placeholder);
                } else {
                    clearSelect(campoBairro, placeholder);
                    clearSelect(campoLogradouro, placeholder);
                }
            }
            campoMunicipio.select2('val', selected);
            campoMunicipio.attr('disabled', false);
            if (selected != '') {
                if (campoTrecho != '') {
                    carregaTrechos(codUf, selected, campoTrecho, placeholder);
                } else {
                    carregaBairros(codUf, selected, campoBairro, campoLogradouro, placeholder, limpar);
                }
            }
        }
    });
}

function carregaTrechos(codUf, codMunicipio, campoTrecho, placeholder) {
    campoTrecho.attr('disabled', true);
    var selected = campoTrecho.val();
    clearSelect(campoTrecho, placeholder);
    $.ajax({
        url: "/tributario/logradouro/trecho",
        method: "POST",
        data: {codUf: codUf, codMunicipio: codMunicipio},
        dataType: "json",
        success: function (data) {
            $.each(data, function (index, value) {
                if (selected == index) {
                    campoTrecho.append("<option value=" + index + " selected>" + value + "</option>");
                } else {
                    campoTrecho.append("<option value=" + index + ">" + value + "</option>");
                }
            });
            campoTrecho.select2('val', selected);
            campoTrecho.attr('disabled', false);
        }
    });
}

function carregaBairros(codUf, codMunicipio, campoBairro, campoLogradouro, placeholder, limpar) {
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
            if (limpar) {
                selected = '';
                clearSelect(campoLogradouro, placeholder);
            }
            campoBairro.select2('val', selected);
            campoBairro.attr('disabled', false);
            carregaLogradouro(codUf, codMunicipio, selected, campoLogradouro, placeholder, limpar);
        }
    });
}

function carregaLogradouro(codUf, codMunicipio, codBairro, campoLogradouro, placeholder, limpar) {
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
            if (limpar) {
                selected = '';
            }
            campoLogradouro.select2('val', selected);
            campoLogradouro.attr('disabled', false);
        }
    });
}
