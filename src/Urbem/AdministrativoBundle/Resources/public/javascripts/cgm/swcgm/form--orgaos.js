(function(){
    'use strict';

    var codOrganograma = UrbemSonata.giveMeBackMyField('organograma').val(),
        createUser = UrbemSonata.giveMeBackMyField('createUser'),
        email = UrbemSonata.giveMeBackMyField('eMail'),
        fieldset = $('.create-user-fieldset');

    fieldset.hide();
    var firstFieldOrgao = getNivelField(0);
    firstFieldOrgao.attr('required', false);
    email.attr('required', false);
    createUser.on('ifChecked', function(){
        fieldset.show();
        firstFieldOrgao.attr('required', true);
        email.attr('required', true);
    });

    createUser.on('ifUnchecked', function(){
        fieldset.hide();
        firstFieldOrgao.attr('required', false);
        email.attr('required', false);
    });

    $( ".orgao-nivel" ).each(function( index ) {
        var nextField = getNivelField(parseInt($(this).attr('control')) + 1);
        if (nextField !== undefined) {
            $(this).on('change', function () {
                clearSelect(nextField);
                if ($(this).val() !== '') {
                    getOrgaos(nextField.attr('nivel'), $(this).val(), nextField);
                } else {
                    clearSelect(nextField)
                }
            });
        }
    });

    function getOrgaos(codNivel, codOrgao, field) {
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, carregando ' + field.attr('descricao') + '... </h4>');
        $.ajax({
            url: "/administrativo/organograma/orgao/consultar-orgaos",
            method: "POST",
            data: {
                codOrganograma: codOrganograma,
                nivel: codNivel,
                codOrgao: codOrgao
            },
            dataType: "json",
            success: function (data) {
                var selected = field.val();
                clearSelect(field);
                $.each(data, function (index, value) {
                    if (selected == index) {
                        field.append("<option value=" + index + " selected>" + value + "</option>");
                    } else {
                        field.append("<option value=" + index + ">" + value + "</option>");
                    }
                });
                field.select2('val', selected);
                field.select2('enable');
                fechaModal();
                field.trigger('change');
            },
            error: function(data) {
                field.select2('enable');
                fechaModal();
            }
        });
    }

    function clearSelect(field) {
        field
            .empty()
            .append("<option value=\"\">Selecione</option>")
            .select2("val", "")
            .select2('disable');
    }

    function getNivelField(control) {
        var field = undefined;
        $('.orgao-nivel').each(function() {
            if (parseInt($(this).attr('control')) === control) {
                field = $(this);
            }
        });
        return field;
    }
})(jQuery, window, UrbemSonata);