$(function () {
    "use strict";

    var uf = UrbemSonata.giveMeBackMyField('fkSwUf'),
        municipio = UrbemSonata.giveMeBackMyField('fkSwMunicipio'),
        codBairroDe = UrbemSonata.giveMeBackMyField('codBairroDe'),
        codBairroAte = UrbemSonata.giveMeBackMyField('codBairroAte');

    if (uf == undefined) {
        return false;
    }

    function clearSelect(campo, placeholder) {
        campo.empty();
        if (placeholder) {
            campo.append('<option value="">Selecione</option>');
        }
        campo.select2('val', '');
    }

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
        clearSelect(municipio, true);
        municipio.attr('disabled', true);
        if (codUf != '') {
            $.ajax({
                url: "/tributario/cadastro-imobiliario/relatorios/logradouros/municipio",
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
}());