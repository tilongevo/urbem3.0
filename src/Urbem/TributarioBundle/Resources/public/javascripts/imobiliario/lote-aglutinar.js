$(function () {
    "use strict";

    var codCadastro = UrbemSonata.giveMeBackMyField('codCadastro'),
        codLote = UrbemSonata.giveMeBackMyField('codLote'),
        lote = UrbemSonata.giveMeBackMyField('lote'),
        proprietarios = UrbemSonata.giveMeBackMyField('codProprietario');

    carregaAtributos(codCadastro.val());

    function carregaAtributos(codCadastro) {
        var data = {
            urbano: {
                entidade: "CoreBundle:Imobiliario\\LoteUrbano",
                getFkEntidadeAtributoValor: "getFkImobiliarioAtributoLoteUrbanoValores"
            },
            rural: {
                entidade: "CoreBundle:Imobiliario\\LoteRural",
                getFkEntidadeAtributoValor: "getFkImobiliarioAtributoLoteRuralValores"
            }
        };

        var params = {
            entidade: (codCadastro == 2) ? data.urbano.entidade : data.rural.entidade,
            fkEntidadeAtributoValor:(codCadastro == 2) ? data.urbano.getFkEntidadeAtributoValor : data.rural.getFkEntidadeAtributoValor,
            codModulo: "12",
            codCadastro: codCadastro
        };

        if(codLote.val() != 0 || codLote.val() != '') {
            params.codEntidade = {
                codLote: codLote.val()
            };
        }

        AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(params);
    }

    lote.attr('required', false);
    lote.on('change', function() {
        $('.sonata-ba-field-error-messages').remove();
    });

    $("#lotesManuais").on("click", function() {
        if ($('#lote-' + lote.val()).length >= 1) {
            mensagemErro(lote, 'Lote já informado!');
            return false;
        }

        consultarImoveis(lote.val(), proprietarios.val());
    });

    function novaLinha()
    {
        $('.sonata-ba-field-error-messages').remove();

        var row = $('.row-modelo');
        row.removeClass('row-modelo');
        row.addClass('row-lote');
        row.attr('id', 'lote-' + lote.val());
        row.find('.lote').html($('select#' + UrbemSonata.uniqId + '_lote option:selected').text());
        row.find('.imput-lote').attr('value', lote.val());
        row.show();

        $('.empty-row-confrontacoes').hide();
        $('#tableLotesManuais').append(row);

        lote.select2('val', '');
    }

    $(document).on('click', '.remove', function () {
        $(this).parent().remove();
        if ($(".row-lote").length <= 0) {
            $('.empty-row-confrontacoes').show();
        }
    });

    function mensagemErro(campo, memsagem) {
        var message = '<div class="help-block sonata-ba-field-error-messages">' +
            '<ul class="list-unstyled">' +
            '<li><i class="fa fa-exclamation-circle"></i> ' + memsagem + '</li>' +
            '</ul></div>';
        campo.after(message);
    }

    $('form').submit(function() {
        $('.sonata-ba-field-error-messages').remove();
        if ($(".row-lote").length <= 0) {
            mensagemErro(lote, 'É necessário ao menos um lote para efetuar a aglutinação!');
            activeTab(3);
            return false;
        }
        return true;
    });

    function activeTab(identificador) {
        $('a[href^="#tab_' + UrbemSonata.uniqId + '"]').parent().removeClass('active');

        $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').attr('aria-expanded', true);
        $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').find('.has-errors').removeClass('hide');
        $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').parent().addClass('active');

        $('.tab-pane').removeClass('active in');
        $('#tab_' + UrbemSonata.uniqId + '_' + identificador).addClass('active in');
    }

    function consultarImoveis(codLote, proprietarios) {
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, carregando</h4>');
        $.ajax({
            url: "/tributario/cadastro-imobiliario/lote/consultar-imoveis",
            method: "POST",
            data: {codLote: codLote},
            dataType: "json",
            success: function (data) {
                if (data) {
                    consultarProprietarios(codLote, proprietarios);
                } else {
                    mensagemErro(lote, 'Lote informado não possui imóvel cadastrado!');
                    activeTab(3);
                    fechaModal();
                }
            }
        });
    }

    function consultarProprietarios(codLote, proprietarios) {
        $.ajax({
            url: "/tributario/cadastro-imobiliario/lote/consultar-proprietarios",
            method: "POST",
            data: {codLote: codLote, proprietarios: proprietarios},
            dataType: "json",
            success: function (data) {
                if (data) {
                    novaLinha();
                } else {
                    mensagemErro(lote, 'Lote não tem os mesmos proprietários que o lote remanescente.');
                    activeTab(3);
                }
                fechaModal();
            }
        });
    }
}());