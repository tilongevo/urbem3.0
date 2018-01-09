(function () {
    'use strict';

    var centroCustoContainerDiv = $('div.centro-custo-container')
        , fkSwCgmField = UrbemSonata.giveMeBackMyField('fkSwCgm')
        , fkSwCgmFieldContainer
        , centrosCustosField = UrbemSonata.giveMeBackMyField('centroCustos')
        , buildSpinnerElement = function (suggestedId) {
        var spinnerDiv = $('div.spinner-load')
            , spinnerIco = $('i.fa.fa-spinner.fa-spin.fa-3x.fa-fw')
            , spinnetTex = $('span.sr-only').text('Loading...')
            , spinnerElement;

        spinnerDiv.prop('id', suggestedId.concat('_spinner'));

        spinnerElement = spinnerDiv.append(spinnerIco).append(spinnetTex);

        return spinnerElement;
    }
        , spinner
        , fkSwCgmFieldId;

    fkSwCgmFieldId = fkSwCgmField.prop('id');

    if (fkSwCgmField.val() != '') {
        updateField(fkSwCgmField);
    }

    spinner = buildSpinnerElement(fkSwCgmFieldId);
    fkSwCgmFieldContainer = fkSwCgmField.parent();
    fkSwCgmFieldContainer.append(spinner);

    fkSwCgmField.on('change', function () {
        updateField(this);
    });

    jQuery('button[name="btn_create_and_list"]').on('click', function (event) {
        var mensagem = '';
        jQuery('.sonata-ba-field-error-messages').remove();
        jQuery('.sonata-ba-form').parent().find('.alert.alert-danger.alert-dismissable').remove();

        if (fkSwCgmField.val() == '') {
            event.preventDefault();
            mensagem = 'O Campo Usuário não pode ficar vazio';

            $(".sonata-ba-field-error-messages").remove();
            UrbemSonata.setFieldErrorMessage(
                fkSwCgmFieldId,
                mensagem,
                fkSwCgmFieldContainer
            );

            jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' + mensagem + ' </div>');
            return false;
        }
    });

    function updateField(field) {
        var numcgm = $(field).val();

        if ($(spinner).hasClass("spinner-load-hide")) {
            spinner.removeClass('spinner-load-hide');
        }

        $.get('/patrimonial/almoxarifado/centro-custo/permissao/search', {
            'numcgm': numcgm
        }).success(function (data) {
            if (data.items.length > 0) {
                clearField(centrosCustosField);
                $.each(data.items, function () {
                    centrosCustosField.find('option[value="' + this.id + '"]').prop('selected', true);
                    centrosCustosField.select2();
                });
            } else {
                clearField(centrosCustosField);
                selecionaTodasOpcoes(centrosCustosField);
            }

            spinner.addClass('spinner-load-hide');
            centroCustoContainerDiv.removeClass('hidden');
        }).fail(function () {
            UrbemSonata.setFieldErrorMessage(
                fkSwCgmFieldId,
                'Ocorreu um erro ao processar a requisiçao desse campo.',
                fkSwCgmFieldContainer
            );
        });
    }

    function clearField(field) {
        field.val('');
        field.select2('val', '');
    }

    function selecionaTodasOpcoes(field) {
        var selected = [];
        field.find("option").each(function(i,e){
            selected[selected.length]=$(e).attr("value");
        });
        field.select2("val", selected);
    }

}());
