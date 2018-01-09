$(function () {
    "use strict";

    var localizacao = $('#filter_codLocalizacao_value_autocomplete_input'),
        lote = $('#filter_codLote_value_autocomplete_input'),
        uf = $('#filter_codUf_value'),
        municipio = $('#filter_codMunicipio_value'),
        bairro = $('#filter_codBairro_value_autocomplete_input'),
        logradouro = $('#filter_codLogradouro_value_autocomplete_input');

    if (localizacao == undefined) {
        return false;
    }

    window.varJsCodLocalizacao = localizacao.val();
    localizacao.on("change", function() {
        window.varJsCodLocalizacao = $(this).val();
    });

    window.varJsCodLote = lote.val();
    lote.on("change", function() {
        window.varJsCodLote = $(this).val();
    });

    window.varJsCodUf = uf.val();
    uf.on("change", function() {
        window.varJsCodUf = $(this).val();
    });

    window.varJsCodMunicipio = municipio.val();
    municipio.on("change", function() {
        window.varJsCodMunicipio = $(this).val();
    });

    window.varJsCodBairro = bairro.val();
    bairro.on("change", function() {
        window.varJsCodBairro = $(this).val();
    });

    function clearSelect(campo, placeholder) {
        campo.empty();
        if (placeholder) {
            campo.append('<option value="">Selecione</option>');
        }
        campo.select2('val', '');
    }

    if (municipio.val() == '') {
        bairro.select2('disable');
        logradouro.select2('disable');
    }

    municipio.on('change', function () {
       if ($(this).val() != '') {
           bairro.select2('enable');
           logradouro.select2('enable');
       } else {
           bairro.select2('disable');
           logradouro.select2('disable');
       }
    });

    if (uf.val() != '') {
        carregaMunicipio(uf.val());
    } else {
        municipio.attr('disabled', true);
    }

    uf.on('change', function () {
        carregaMunicipio($(this).val());
    });

    function carregaMunicipio(codUf) {
        var selected = municipio.val();
        clearSelect(municipio, false);
        municipio.attr('disabled', true);
        window.varJsCodMunicipio = '';
        if (codUf != '') {
            $.ajax({
                url: "/tributario/cadastro-imobiliario/consultas/cadastro-imobiliario/consultar-municipio",
                method: "POST",
                data: {codUf: codUf},
                dataType: "json",
                success: function (data) {
                    $.each(data, function (index, value) {
                        if (selected == index) {
                            municipio.append("<option value=" + index + " selected>" + value + "</option>");
                        } else {
                            municipio.append("<option value=" + index + ">" + value + "</option>");
                        }
                    });
                    municipio.select2('val', selected);
                    municipio.attr('disabled', false);
                }
            });
        }
    }

    $(".btn_details").on("click", function() {
        var status = $(this).html();
        var content = $(this).attr('data-content');
        $('.details-content').each(function () {
            $(this).hide();
        });
        $(".btn_details").each(function () {
            if ($(this).attr('data-content') != content) {
                $(this).html('add');
            }
        });
        if (status == 'add') {
            $('#data_' + content).show();
            $(this).html('remove');
        }
    });

    $(".btn_meta").on("click", function() {
        var loteProcesso = $(this).attr('data-lote-processo');
        if($(this).html() == 'add'){
            $('#lote_processo_' + loteProcesso).show();
            $(this).html('remove');
        }
        else{
            $('#lote_processo_' + loteProcesso).hide();
            $(this).html('add');
        }
    });
}());