var vigencia = UrbemSonata.giveMeBackMyField('fkImobiliarioVigencia'),
    nivelSuperior = UrbemSonata.giveMeBackMyField('nivelSuperior'),
    nomNivel = UrbemSonata.giveMeBackMyField('nomNivel'),
    mascara = UrbemSonata.giveMeBackMyField('mascara');

if (vigencia != undefined) {
    if ((vigencia.val() != '') && (nivelSuperior.attr('form-status') == undefined)) {
        nomNivel.focus();
        alteraNivelSuperior(vigencia.val());
    }
    nivelSuperior.attr('disabled', true);

    vigencia.on('change', function () {
        alteraNivelSuperior($(this).val());
    });

    nomNivel.keydown(function (event) {
        if ($(this).val().length >= 80 && (event.which != 8 && event.which != 16 && event.which != 37 && event.which != 39)) {
            return false;
        }
    });

    mascara.keydown(function (event) {
        if ($(this).val().length >= 10 && (event.which != 8 && event.which != 16 && event.which != 37 && event.which != 39)) {
            return false;
        }
    });

    function alteraNivelSuperior(vigencia) {
        $.ajax({
            url: "/tributario/cadastro-imobiliario/hierarquia/nivel/nivel-superior",
            method: "POST",
            data: {codVigencia: vigencia},
            dataType: "json",
            success: function (data) {
                nivelSuperior.select2('val', data);
            }
        });
    }
}