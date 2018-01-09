$(function () {
    "use strict";

    var tipoLicenca = UrbemSonata.giveMeBackMyField('fkImobiliarioTipoLicenca'),
        atributoDinamico = UrbemSonata.giveMeBackMyField('fkAdministracaoAtributoDinamico'),
        modeloDocumento = UrbemSonata.giveMeBackMyField('fkAdministracaoModeloDocumento');

    if (tipoLicenca == undefined) {
        return false;
    }

    atributoDinamico.select2('disable');
    modeloDocumento.select2('disable');

    tipoLicenca.on('change', function () {
        carregaModelosDocumento($(this).val(), modeloDocumento);
        carregaAtributosDinamicos($(this).val(), atributoDinamico);
    });

    function carregaModelosDocumento(codTipo, campoModeloDocumento) {
        campoModeloDocumento.select2('disable');
        $.ajax({
            url: "/tributario/cadastro-imobiliario/licencas/tipo-licenca/consultar-modelos-documento",
            method: "POST",
            data: {codTipo: codTipo},
            dataType: "json",
            success: function (data) {
                var selecteds = [];
                $.each(data, function (index, value) {
                    selecteds.push(index);
                });
                campoModeloDocumento.select2("val", selecteds);
                campoModeloDocumento.select2('enable');
            }
        });
    }

    function carregaAtributosDinamicos(codTipo, campoAtributoDinamico) {
        campoAtributoDinamico.select2('disable');
        $.ajax({
            url: "/tributario/cadastro-imobiliario/licencas/tipo-licenca/consultar-atributos-dinamicos",
            method: "POST",
            data: {codTipo: codTipo},
            dataType: "json",
            success: function (data) {
                var selecteds = [];
                $.each(data, function (index, value) {
                    selecteds.push(index);
                });
                campoAtributoDinamico.select2("val", selecteds);
                campoAtributoDinamico.select2('enable');
            }
        });
    }

    $(document).ready(function() {
        $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkImobiliarioTipoLicenca').find('label').addClass('required ');
        $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkImobiliarioTipoLicenca').mouseover(function() {
            $(this).find('.sonata-ba-field-error-messages').remove();
            $(this).removeClass('has-error');
        });
        $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkAdministracaoModeloDocumento').find('label').addClass('required ');
        $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkAdministracaoModeloDocumento').mouseover(function() {
            $(this).find('.sonata-ba-field-error-messages').remove();
            $(this).removeClass('has-error');
        });
    });

    $('form').submit(function() {
        if (tipoLicenca.val() == '') {
            UrbemSonata.setFieldErrorMessage('tipoLicenca', 'Preencha este campo.', tipoLicenca.parent());
            return false;
        }
        if (modeloDocumento.val() == null) {
            UrbemSonata.setFieldErrorMessage('modeloDocumento', 'Preencha este campo.', modeloDocumento.parent());
            return false;
        }
        return true;
    });
}());