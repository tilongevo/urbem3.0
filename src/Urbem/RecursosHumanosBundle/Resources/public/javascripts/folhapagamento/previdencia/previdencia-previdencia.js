$(function() {
    var regime_previdencia_nome = UrbemSonata.uniqId + "[codPrevidencia][codRegimePrevidencia]";
    var regime_previdencia_selector = 'select[name="'+ regime_previdencia_nome +'"]';
    var regime_previdencia = $.sonataField('#fkFolhapagamentoPrevidencia_fkFolhapagamentoRegimePrevidencia');

    regime_previdencia.on('change', function (event) {
        ShowHideAliquota();
    });

    function ShowHideAliquota()
    {
        var selected = regime_previdencia.find(':selected');

        if ( selected.val() == 1 ) { // RGPS = 1 - show aliquota
            $('.aliquota-group').show('fast');
        } else {
            $('.aliquota-group').hide('fast');
        }
    }
    var modal_d = new UrbemModal();
    var modal_b = new UrbemModal();
    // Dados via ajax
    $.ajax({
        url: '/recursos-humanos/api/search/prev-eventos',
        data: {
            // 'natureza': 'D'
        }
    }).done(function (result) {
        modal_d = createModal(result, 'D');
        modal_b = createModal(result, 'B');

        var table_d = writeTable(result.D, 'D');
        var table_b = writeTable(result.B, 'B');

        modal_d.setBody(table_d);
        modal_b.setBody(table_b);

        var dataTableOptions = {};

        if ( UrbemSonata.isEditPage() ) {
            var codigoSelectedD = $('#'+UrbemSonata.uniqId+"_cod_evento_d");
            var codigoSelectedB = $('#'+UrbemSonata.uniqId+"_cod_evento_b");

            var toogleElement = function (codigoSelected){
                var element = $('#id-'+codigoSelected.val());
                var toInsert = element.clone();
                $(toInsert).attr('class', 'highlight-tablerow');
                $(toInsert).prependTo(element.parent());
                element.remove();
            };

            toogleElement(codigoSelectedD);
            toogleElement(codigoSelectedB);

            dataTableOptions = {'ordering': false};
        }

        $('#modal-body-' + modal_d.getUuid() + " > table").UrbemDataTable(dataTableOptions);
        $('#modal-body-' + modal_b.getUuid() + " > table").UrbemDataTable(dataTableOptions);
    })
        .fail(function(){
            var error = new UrbemModal();
            error.setTitle('Erro ao carregar conteúdo');
            error.setContent('Houve um erro na aplicação, por favor contate o suporte técnico');
            error.open();
        });

    function putSelectedEvent(codEvento, codigo, descricao, natureza) {
        $("#"+UrbemSonata.uniqId+"_cod_evento_"+natureza+"_cod").val(codEvento);
        $("#"+UrbemSonata.uniqId+"_cod_evento_"+natureza).val(codigo);
        $("#"+UrbemSonata.uniqId+"_desc_evento_"+natureza).val(descricao);
    }

    function createModal(result, natureza) {
        var title;
        switch (natureza) {
            case 'D': // Descontos
                title = "Evento de Descontos";
                break;
            case 'B': // Base
                title = "Evento Base";
                break;
        }
        var modal = new UrbemModal();
        modal.setTitle(title);

        return modal;
    }

    function writeTable(result, natureza) {
        var table = $('<table/>', {});

        var theader = $('<thead/>').appendTo(table);

        var title = $('<tr/>', {}).appendTo(theader);

        $('<th/>').html('Código').appendTo(title);
        $('<th/>').html('Evento').appendTo(title);
        $('<th/>').html('Valor').appendTo(title);
        $('<th/>').html('Quantidade').appendTo(title);
        $('<th/>').html('Tipo').appendTo(title);
        $('<th/>').html('Texto Complementar').appendTo(title);
        $('<th/>').html('&nbsp;').appendTo(title);

        var tbody = $('<tbody/>').appendTo(table);

        for (var i = 0; i < result.length; i++) {
            var row = $('<tr/>', {'id': "id-" + result[i].codigo}).appendTo(tbody);
            $('<td/>').html(result[i].codigo).appendTo(row);
            $('<td/>').html(result[i].descricao).appendTo(row);
            $('<td/>').html(result[i].valor_quantidade).appendTo(row);
            $('<td/>').html(result[i].unidade_quantitativa).appendTo(row);
            $('<td/>').html(result[i].tipo).appendTo(row);
            $('<td/>').html(result[i].observacao).appendTo(row);
            var fieldAction = $('<td/>').appendTo(row);
            var action = $('<span/>', {
            }).appendTo(fieldAction);
            var a = $('<a/>', {
                'href': 'javascript:;',
                'class' : 'choose-event-' + S(natureza).toLowerCase(),
                'id': '' + result[i].codigo,
                'data-cod-evento': result[i].cod_evento
            }).  html(' <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> ').appendTo(action);
        }

        return table;
    }

    // Mostrar aliquota
    ShowHideAliquota();

    $('#'+UrbemSonata.uniqId+'_cod_evento_d').on('click', function (event) {
        event.preventDefault();
        modal_d.open();
        $('.choose-event-d').on('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            var objeto = $(this);

            var eventoCodigo = objeto.attr('id');
            var codEvento = objeto.attr('data-cod-evento');
            var tr = $("#id-" + eventoCodigo);
            var eventoNome = $(tr.children()[1]).html();

            putSelectedEvent(codEvento, eventoCodigo, eventoNome, 'd');
            modal_d.close();
        });
    });
    $('#'+UrbemSonata.uniqId+'_cod_evento_b').on('click', function (event) {
        event.preventDefault();
        modal_b.open();
        $('.choose-event-b').on('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            var objeto = $(this);

            var codEvento = objeto.attr('data-cod-evento');
            var eventoCodigo = $(this).attr('id');
            var tr = $("#id-" + eventoCodigo);
            var eventoNome = $(tr.children()[1]).html();

            putSelectedEvent(codEvento, eventoCodigo, eventoNome, 'b');
            modal_b.close();
        });
    });
});
