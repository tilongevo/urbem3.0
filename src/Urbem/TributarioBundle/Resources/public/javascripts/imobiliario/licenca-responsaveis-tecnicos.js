$(function () {
    "use strict";

    var profissao = UrbemSonata.giveMeBackMyField('fkCseProfissao'),
        responsavelTecnico = $('#' + UrbemSonata.uniqId + '_fkImobiliarioResponsavelTecnico_autocomplete_input'),
        responsavelTecnicoContainer = $('#s2id_' + UrbemSonata.uniqId + '_fkImobiliarioResponsavelTecnico_autocomplete_input'),
        modeloResponsaveisTecnicos = $('.row-modelo-responsaveis-tecnicos');

    if (profissao == undefined) {
        return false;
    }

    $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_licencaResponsaveisTecnicos_lista").hide();

    $("#manuais").on("click", function() {
        if (responsavelTecnico.val() == '') {
            UrbemSonata.setFieldErrorMessage('responsavelTecnico', 'Preencha este campo.', responsavelTecnicoContainer);
            return false;
        }
        if ($('#responsavel-tecnico-' + responsavelTecnico.val().replace("~", "-")).length >= 1) {
            UrbemSonata.setFieldErrorMessage('responsavelTecnico', 'Responsável Técnico já informado!', responsavelTecnicoContainer);
            return false;
        }
        consultarResponsavelTecnico(responsavelTecnico.val());
    });


    function novaLinha(data)
    {
        $('.sonata-ba-field-error-messages').remove();

        var row = modeloResponsaveisTecnicos.clone();
        row.removeClass('row-modelo-responsaveis-tecnicos');
        row.addClass('row-responsaveis-tecnicos');
        row.attr('id', 'responsavel-tecnico-' + responsavelTecnico.val().replace("~", "-"));
        row.find('.codigo').append(data.numcgm);
        row.find('.nome').html(data.nomCgm);
        row.find('.registro').html(data.numRegistro);
        row.find('.profissao').html(data.nomProfissao);
        row.find('.input-responsavel-tecnico').attr('value', responsavelTecnico.val());
        row.show();

        $('.empty-row-responsaveis-tecnicos').hide();
        $('#tableResponsaveisTecnicosManuais').append(row);

        responsavelTecnico.select2('val', '');
    }

    if ($(".row-responsaveis-tecnicos").length > 0) {
        $('.empty-row-responsaveis-tecnicos').hide();
    }

    $('form').submit(function() {
        if ($(".row-responsaveis-tecnicos").length <= 0) {
            UrbemSonata.setFieldErrorMessage('responsavelTecnico', 'A lista de responsáveis está vazia!', responsavelTecnicoContainer);
            return false;
        }
        return true;
    });

    $(document).on('click', '.remove', function () {
        $(this).parent().remove();
        if ($(".row-responsaveis-tecnicos").length <= 0) {
            $('.empty-row-responsaveis-tecnicos').show();
        }
    });

    $(document).ready(function() {
        responsavelTecnicoContainer.mouseover(function() {
            $(this).find('.sonata-ba-field-error-messages').remove();
            $(this).parent().removeClass('has-error');
        });
    });

    function consultarResponsavelTecnico(responsavelTecnico) {
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Carregando, por favor aguarde.</h4>');
        $.ajax({
            url: "/tributario/cadastro-imobiliario/licencas/licenca/consultar-responsavel-tecnico",
            method: "POST",
            data: {responsavelTecnico: responsavelTecnico},
            dataType: "json",
            success: function (data) {
                if (data) {
                    novaLinha(data);
                    fechaModal();
                }
            }
        });
    }
}());