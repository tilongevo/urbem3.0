$(function () {
    "use strict";

    var condominio = UrbemSonata.giveMeBackMyField('codCondominio'),
        localizacao = $("#" + UrbemSonata.uniqId + "_fkImobiliarioLocalizacao_autocomplete_input"),
        lote = $("#" + UrbemSonata.uniqId + "_fkImobiliarioLote_autocomplete_input"),
        modelo = $('.row-modelo');

    if (condominio == undefined) {
        return false;
    }

    window.varJsCodLocalizacao = localizacao.val();
    localizacao.on("change", function() {
        if ($(this).val() != '') {
            lote.select2('enable');
        } else {
            lote.select2('val', '');
            lote.select2('disable');
        }
        console.log($(this).val());
        window.varJsCodLocalizacao = $(this).val();
    });

    if (localizacao.val() == '') {
        lote.select2('disable');
    }

    $("#manuais").on("click", function() {
        if ($('#lote-' + lote.val()).length >= 1) {
            mensagemErro(lote, 'Lote já informado!');
            return false;
        }
        novaLinha();
    });

    function novaLinha()
    {
        $('.sonata-ba-field-error-messages').remove();

        var nome = localizacao.select2('data').label;
        if (nome != undefined) {
            nome = nome.split(' - ');
            nome = nome[0];
        }

        var row = modelo.clone();
        row.removeClass('row-modelo');
        row.addClass('row-lote');
        row.attr('id', 'lote-' + lote.val());
        row.find('.localizacao').append(nome);
        row.find('.lote').html(lote.select2('data').label);
        row.find('.imput-lote').attr('value', lote.val());
        row.show();

        verificaLoteCondominio(condominio.val(), lote.val(), row);
    }

    function verificaLoteCondominio(codCondominio, codLote, row) {
        $.ajax({
            url: "/tributario/cadastro-imobiliario/condominio/consultar-lote-condominio",
            method: "POST",
            data: {codCondominio: codCondominio, codLote: codLote},
            dataType: "json",
            success: function (data) {
                if (data) {
                    var imoveis = '';
                    $.each(data, function (index, value) {
                        if (imoveis == '') {
                            imoveis += value;
                        } else {
                            imoveis += ', ' + value;
                        }
                    });
                    row.find('.imoveis').html(imoveis);
                    $('.empty-row-lote').hide();
                    $('#tableLotesManuais').append(row);
                    lote.select2('val', '');
                } else {
                    var message = '<div class="help-block sonata-ba-field-error-messages">' +
                        '<ul class="list-unstyled">' +
                        '<li><i class="fa fa-exclamation-circle"></i>  Lote já pertencente a outro condomínio!</li>' +
                        '</ul></div>';
                    lote.after(message);
                }
            }
        });
    }

    if ($(".row-lote").length > 0) {
        $('.empty-row-lote').hide();
    }

    $(document).on('click', '.remove', function () {
        $(this).parent().remove();
        if ($(".row-lote").length <= 0) {
            $('.empty-row-lote').show();
        }
    });

    $('form').submit(function() {
        if ($(".row-lote").length <= 0) {
            mensagemErro(lote, 'É necessário incluir ao menos um lote.');
            return false;
        }
        return true;
    });

    function mensagemErro(campo, memsagem) {
        var message = '<div class="help-block sonata-ba-field-error-messages">' +
            '<ul class="list-unstyled">' +
            '<li><i class="fa fa-exclamation-circle"></i> ' + memsagem + '</li>' +
            '</ul></div>';
        campo.after(message);
    }

    carregaAtributos();
    function carregaAtributos() {
        var params = {
            entidade: "CoreBundle:Imobiliario\\Condominio",
            fkEntidadeAtributoValor: "getFkImobiliarioAtributoCondominioValores",
            codModulo: "12",
            codCadastro: "6"
        };

        if(condominio.val() != 0 || condominio.val() != '') {
            params.codEntidade = {
                codCondominio: condominio.val()
            };
        }

        AtributoDinamicoPorCadastroComponent.getAtributoDinamicoFields(params);
    }
}());