$(function() {
    var responsavelTecnicoSelect = $('#' + UrbemSonata.uniqId + '_codResponsavelTecnico');

    var responsavelTecnicoModal = new UrbemModal();

    responsavelTecnicoSelect.on('click', function (event) {
        $.ajax({
            url: '/financeiro/api/search/orcamento/classificacao-institucional/responsavel-tenico/list'
        })
            .done(function (result) {
                if (result.length) {
                    responsavelTecnicoModal.setTitle('Responsável Técnico');
                    responsavelTecnicoModal.setBody(writeTable(result));
                    responsavelTecnicoModal.open();

                    $('.choose-responsavel-tecnico').on('click', function (event) {
                        var btn = $(this);

                        responsavelTecnicoSelect.val(btn.data('value'));
                        $('#' + UrbemSonata.uniqId + '_codProfissao').val(btn.data('profissao'));

                        responsavelTecnicoModal.close();
                    });
                }
            });
    });

    function writeTable(result) {
        var table = $('<table/>', {});

        var theader = $('<thead/>').appendTo(table);

        var title = $('<tr/>', {}).appendTo(theader);

        $('<th/>').html('CGM').appendTo(title);
        $('<th/>').html('Nome').appendTo(title);
        $('<th/>').html('Profissao').appendTo(title);
        $('<th/>').html('Registro').appendTo(title);
        $('<th/>').html('&nbsp;').appendTo(title);

        var tbody = $('<tbody/>').appendTo(table);

        for (var i = 0; i < result.length; i++) {
            var row = $('<tr/>', {'id': "id-" + result[i].numcgm}).appendTo(tbody);
            $('<td/>').html(result[i].numcgm).appendTo(row);
            $('<td/>').html(result[i].nom_cgm).appendTo(row);
            $('<td/>').html(result[i].nom_profissao).appendTo(row);
            $('<td/>').html(result[i].registro).appendTo(row);
            var fieldAction = $('<td/>').appendTo(row);

            var action = $('<a/>', {
                'href': 'javascript:;',
                'class' : 'choose-responsavel-tecnico',
                'id': '' + result[i].numcgm,
                'data-value': result[i].numcgm + ' - ' + result[i].nom_cgm,
                'data-profissao': result[i].cod_profissao
            }).appendTo(fieldAction);

            var spanAction = $('<span/>', {
                'class': 'glyphicon glyphicon-ok'
            }).appendTo(action);
        }

        return table;
    }

    jQuery('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_codUsuario').css({'width': '98.5%'});
});