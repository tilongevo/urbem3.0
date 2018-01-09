$(function () {
    "use strict";

    var inscricaoMunicipal = UrbemSonata.giveMeBackMyField('inscricaoMunicipal'),
        tipoLote = UrbemSonata.giveMeBackMyField('tipoLote'),
        localizacao = UrbemSonata.giveMeBackMyField('localizacao'),
        bairro = UrbemSonata.giveMeBackMyField('bairro'),
        lote = $("#" + UrbemSonata.uniqId + "_lote_autocomplete_input"),
        endereco = UrbemSonata.giveMeBackMyField('endereco'),
        cep = UrbemSonata.giveMeBackMyField('cep'),
        correspondenciaUf = UrbemSonata.giveMeBackMyField('fkSwUf'),
        correspondenciaMunicipio = UrbemSonata.giveMeBackMyField('fkSwMunicipio'),
        correspondenciaBairro = UrbemSonata.giveMeBackMyField('fkSwBairro'),
        correspondenciaLogradouro = $("#" + UrbemSonata.uniqId + "_fkSwLogradouro_autocomplete_input"),
        correspondenciaCep = UrbemSonata.giveMeBackMyField('correspondencia_cep'),
        correspondenciaNumero = UrbemSonata.giveMeBackMyField('correspondencia_numero'),
        imovelCorrespondencia = UrbemSonata.giveMeBackMyField('imovelCorrespondencia');

    if (imovelCorrespondencia == undefined) {
        return false;
    }

    function requireImovelCorrespondencia(require) {
        correspondenciaBairro.attr('disabled', require);
        correspondenciaCep.attr('disabled', require);
        correspondenciaNumero.attr('disabled', require);
    }

    if (imovelCorrespondencia.attr('checked') == undefined) {
        $('.imovel-correspondencia').hide();
        requireImovelCorrespondencia(true);
    }
    imovelCorrespondencia.on('ifChecked', function(event){
        $('.imovel-correspondencia').show();
        requireImovelCorrespondencia(false);
    });
    imovelCorrespondencia.on('ifUnchecked', function(event){
        $('.imovel-correspondencia').hide();
        requireImovelCorrespondencia(true);
    });

    window.varJsTipoLote = tipoLote.val();
    tipoLote.on("change", function() {
        window.varJsTipoLote = $(this).val();
    });

    window.varJsCodLocalizacao = localizacao.val();
    localizacao.on("change", function() {
        window.varJsCodLocalizacao = $(this).val();
    });

    if ((localizacao.val() == '') || ((localizacao.val() != '') && (lote.val() != ''))) {
        lote.select2('disable');
    }

    if (localizacao.val() != '') {
        lote.select2('enable');
    }

    localizacao.on('change', function () {
        if ($(this).val() == '') {
            lote.select2('disable');
        } else {
            lote.select2('enable');
        }
    });

    window.varJsCodUf = correspondenciaUf.val();
    correspondenciaUf.on("change", function() {
        window.varJsCodUf = $(this).val();
    });

    window.varJsCodMunicipio = correspondenciaMunicipio.val();
    correspondenciaMunicipio.on("change", function() {
        window.varJsCodMunicipio = $(this).val();
    });

    window.varJsCodBairro = correspondenciaBairro.val();
    correspondenciaBairro.on("change", function() {
        window.varJsCodBairro = $(this).val();
    });

    if (correspondenciaBairro.val() == '') {
        correspondenciaLogradouro.select2('disable');
    }

    correspondenciaBairro.on('change', function () {
        if ($(this).val() == '') {
            correspondenciaLogradouro.select2('disable');
        } else {
            correspondenciaLogradouro.select2('enable');
        }
    });

    if (correspondenciaUf.val() != '') {
        carregaMunicipios(correspondenciaUf.val(), correspondenciaMunicipio, correspondenciaBairro, correspondenciaLogradouro, true, false);
    } else {
        correspondenciaMunicipio.attr('disabled', true);
        correspondenciaBairro.attr('disabled', true);
    }

    correspondenciaUf.on('change', function () {
        carregaMunicipios($(this).val(), correspondenciaMunicipio, correspondenciaBairro, correspondenciaLogradouro, true, true);
    });

    correspondenciaMunicipio.on('change', function () {
        carregaBairros(correspondenciaUf.val(), $(this).val(), correspondenciaBairro, correspondenciaLogradouro, true, true)
    });

    if (inscricaoMunicipal.val() == '') {
        carregaAtributos();
    }

    function carregaAtributos() {
        var params = {
            entidade: "CoreBundle:Imobiliario\\Imovel",
            fkEntidadeAtributoValor: "getFkImobiliarioAtributoImovelValores",
            codModulo: "12",
            codCadastro: "4"
        };

        if(inscricaoMunicipal.val() != 0 || inscricaoMunicipal.val() != '') {
            params.codEntidade = {
                inscricaoMunicipal: inscricaoMunicipal.val()
            };
        }

        AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(params);
    }

    lote.on('change', function () {
        carregarLoteBairro($(this).val());
        carregarLoteEndereco($(this).val());
    });

    if (lote.val() != '') {
        carregarLoteBairro(lote.val());
        carregarLoteEndereco(lote.val());
    }

    correspondenciaLogradouro.on('change', function () {
        carregarLogradouroCep($(this).val());
    });

    function carregarLoteBairro(codLote) {
        $.ajax({
            url: "/tributario/cadastro-imobiliario/imovel/consultar-lote-bairro",
            method: "POST",
            data: {codLote: codLote},
            dataType: "json",
            success: function (data) {
                bairro.val(data);
            }
        });
    }

    function carregarLoteEndereco(codLote) {
        endereco.attr('disabled', true);
        var selected = endereco.val();
        $.ajax({
            url: "/tributario/cadastro-imobiliario/imovel/consultar-lote-endereco",
            method: "POST",
            data: {codLote: codLote},
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, value) {
                    if (selected == '') {
                        selected = index;
                        endereco.append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        endereco.append("<option value=" + index + ">" + value + "</option>");
                    }
                });
                endereco.attr('disabled', false);
                endereco.select2('val', selected);
                carregarLoteCep(codLote, selected)
            }
        });
    }

    function carregarLoteCep(codLote, codLogradouro) {
        cep.attr('disabled', true);
        var selected = '';
        clearSelect(cep, true);
        $.ajax({
            url: "/tributario/cadastro-imobiliario/imovel/consultar-lote-cep",
            method: "POST",
            data: {codLote: codLote, codLogradouro: codLogradouro},
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, value) {
                    if (selected == '') {
                        selected = index;
                        cep.append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        cep.append("<option value=" + index + ">" + value + "</option>");
                    }
                });
                cep.attr('disabled', false);
                cep.select2('val', selected);
            }
        });
    }

    function carregarLogradouroCep(codLogradouro) {
        correspondenciaCep.attr('disabled', true);
        var selected = '';
        clearSelect(correspondenciaCep, true);
        $.ajax({
            url: "/tributario/cadastro-imobiliario/imovel/consultar-logradouro-cep",
            method: "POST",
            data: {codLogradouro: codLogradouro},
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, value) {
                    if (selected == '') {
                        selected = index;
                        correspondenciaCep.append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        correspondenciaCep.append("<option value=" + index + ">" + value + "</option>");
                    }
                });
                correspondenciaCep.attr('disabled', false);
                correspondenciaCep.select2('val', selected);
            }
        });
    }

    function carregaMunicipios(codUf, campoMunicipio, campoBairro, campoLogradouro, placeholder, limpar) {
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
                campoMunicipio.attr('disabled', false);
                if (limpar) {
                    selected = '';
                    clearSelect(campoBairro, placeholder);
                    clearSelect(campoLogradouro, placeholder);
                }
                campoMunicipio.select2('val', selected);
                if (selected != '') {
                    carregaBairros(codUf, selected, campoBairro, campoLogradouro, placeholder, limpar);
                }
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
                if (selected != '') {
                    campoLogradouro.select2('enable');
                }
                campoBairro.attr('disabled', false);
                campoBairro.select2('val', selected);
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