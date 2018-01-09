(function ($, global, urbem) {
    'use strict';

    var codContrato = urbem.giveMeBackMyField('codContrato', true),
        numcgm = urbem.giveMeBackMyField('numcgm', true),
        codCausaRescisao = urbem.giveMeBackMyField('codCausaRescisao'),
        codTipoNorma = urbem.giveMeBackMyField('codTipoNorma'),
        dtRescisao = urbem.giveMeBackMyField('dtRescisao')
    ;

    function getCasoCausa() {
        var dtRescisao = urbem.giveMeBackMyField('dtRescisao'),
            codCausaRescisao = urbem.giveMeBackMyField('codCausaRescisao'),
            codContrato = urbem.giveMeBackMyField('codContrato'),
            codCasoCausa = urbem.giveMeBackMyField('codCasoCausa'),
            casoCausa = urbem.giveMeBackMyField('casoCausa')
        ;

        if (dtRescisao.val() !== "" && codCausaRescisao.val() !== "") {
            abreModal('Carregando','Aguarde, buscando descrição do Caso da Causa...');
            $.ajax({
                url: "/recursos-humanos/rescisao-contrato/caso-causa",
                method: "POST",
                data: {
                    codContrato: codContrato.val(),
                    codCausaRescisao: codCausaRescisao.val(),
                    dtRescisao: moment(dtRescisao.val(), dtRescisao.attr("data-date-format")).add(1, 'd').format()
                },
                dataType: "json",
                success: function (data) {
                    if (data) {
                        codCasoCausa.val(data.cod_caso_causa);
                        casoCausa.val(data.descricao);
                    } else {
                        codCasoCausa.val('');
                        casoCausa.val('');
                    }
                    fechaModal();
                }
            });
        }
    }

    if (typeof(codContrato) != "undefined") {
        codContrato.on("change", function() {
            localStorage.setItem('matriculaId', $(this).select2('data').id);
            localStorage.setItem('matriculaLabel', $(this).select2('data').label);
        });

        if (localStorage.getItem('matriculaId') != null) {
            codContrato.select2('data', {
                id: localStorage.getItem('matriculaId'),
                label: localStorage.getItem('matriculaLabel')
            });
        }

        localStorage.removeItem('matriculaId');
        localStorage.removeItem('matriculaLabel');

        numcgm.on("change", function() {
            localStorage.setItem('numcgmId', $(this).select2('data').id);
            localStorage.setItem('numcgmLabel', $(this).select2('data').label);
        });

        if (localStorage.getItem('numcgmId') != null) {
            numcgm.select2('data', {
                id: localStorage.getItem('numcgmId'),
                label: localStorage.getItem('numcgmLabel')
            });
        }

        localStorage.removeItem('numcgmId');
        localStorage.removeItem('numcgmLabel');
    }

    if (typeof(codTipoNorma) != "undefined") {
        $("#dp_" + UrbemSonata.uniqId + "_dtRescisao").on("change", function () {
            dtRescisao.focus();
        });

        codCausaRescisao.on("change", function () {
            getCasoCausa();
        });

        dtRescisao.on("change", function () {
            getCasoCausa();
        });

        window.varJsCodTipoNorma = codTipoNorma.val();
        codTipoNorma.on("change", function() {
            window.varJsCodTipoNorma = $(this).val();
        });
    }
})(jQuery, window, UrbemSonata);
