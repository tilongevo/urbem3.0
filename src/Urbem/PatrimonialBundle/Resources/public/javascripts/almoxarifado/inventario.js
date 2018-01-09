(function(){
    'use strict';

    var formAction = $('form').prop("action")
      , regexpEdit = /(\/patrimonial\/almoxarifado\/inventario\/item\/)/g
      , regexpCreate = /(\/patrimonial\/compras\/compra-direta\/)/g

    $('.init-hidden').each(function (index) {
        $(this)
            .closest('.campo-sonata')
            .hide()
        ;
    });

    UrbemSonata
        .giveMeBackMyField('codCentro')
        .prop('readonly', true);

    $('.init-readonly').each(function () {
        $(this).prop('readonly', true);
    });

    $('.fixed-readonly').each(function () {
        $(this).prop('readonly', true);
    });

    var getNivelContainer = function (fieldCod) {
            var fieldStartId = UrbemSonata.uniqId + '_catalogo_nivel_' + fieldCod;

            return $("[id^='" + fieldStartId + "']");
        },
        getFieldNivelData = function (field) {
            var spritedFieldId = field.prop('id').split('_');

            return {
                fieldId: field.prop('id'),
                codClassificacao: field.val(),
                codCatalogo: spritedFieldId[3],
                nivel: spritedFieldId[4]
            };
        },
        populateSelect = function (select, data, prop) {
            var firstOption = select.find('option:first-child'),
                selectedOption = select.find('option:selected');

            select.empty().append(firstOption);

            $.each(data, function (index, item) {
                var attrs = {
                    value: item[prop.value],
                    text: item[prop.text]
                };

                if (selectedOption.val() == item[prop.value]) {
                    attrs.selected = true;
                }

                select.append($('<option>', attrs));
            });

            select.select2();
        };

    UrbemSonata
        .giveMeBackMyField('catalogo')
        .on('change', function() {
            var codCatalogo = $(this).val(),
                fields = getNivelContainer(codCatalogo).toArray(),
                allFields = $("[id^='" + UrbemSonata.uniqId + "_catalogo_nivel_']").toArray();

            $.each(allFields, function (index) {
                $.each(fields, function() {
                    var fieldToShow = $(this)[0],
                        fieldToShowIndex = allFields.indexOf(fieldToShow)
                    ;

                    if (index === fieldToShowIndex) {
                        allFields.splice(fieldToShowIndex, 1);
                    }
                });
            });

            $.each(allFields, function () {
                $(this)
                    .prop('disabled', true)
                    .select2("val", "")
                    .closest('.campo-sonata')
                    .hide();
            });

            $.each(fields, function (index) {
                $(this)
                    .closest('.campo-sonata')
                    .show();

                if (index === 0) {
                    $(this).prop('disabled', false);
                }
            });
        })
    ;

    $("[id^='" + UrbemSonata.uniqId + "_catalogo_nivel_']").on('change', function () {
        var fieldData = getFieldNivelData($(this)),
            fieldCodEstrutural = UrbemSonata.giveMeBackMyField('codEstrutural'),
            nextNivelField = function (previousCodNivelField) {
                var spritedFieldId = fieldData.fieldId.split('_');

                spritedFieldId[4] = parseInt(previousCodNivelField) + 1;
                var nextField = $('#' + spritedFieldId.join('_'));

                return nextField.length > 0 ? nextField : null;
            }
        ;

        const regex = /^[0-9\.]+/g;

        var nextField = nextNivelField(fieldData.nivel),
            optionSelected = $(this).find('option:selected'),
            fieldCodEstruturalValue = regex.exec(optionSelected.text())[0];

        fieldCodEstrutural.val(fieldCodEstruturalValue);

        if (nextField !== null) {
            var nextNivel = parseInt(fieldData.nivel) + 1;

            $.get('/patrimonial/api/search/classificacao', {
                'cod_classificacao': fieldData.codClassificacao,
                'nivel': nextNivel
            }).success(function (data) {
                populateSelect(nextField, data, {
                    value: 'cod_classificacao',
                    text: 'descricao'
                });
            });

            nextField.prop('disabled', false);
        } else {
            var codItemField = UrbemSonata.giveMeBackMyField('codItem');

            $.get('/patrimonial/api/search/classificacao/catalogo-items', {
                'cod_classificacao': fieldData.codClassificacao
            }).success(function (data) {
                populateSelect(codItemField, data, {
                    value: 'codItem',
                    text: 'descricao'
                });
            });

            $('.init-readonly').each(function () {
                $(this).removeAttr('readonly');
            });

            $('select.init-readonly').select2();
        }

    });

    UrbemSonata
        .giveMeBackMyField('codEntidade')
        .on('change', function () {
            var codEntidadeValue = $(this).val(),
                codCentroField = UrbemSonata.giveMeBackMyField('codCentro');

            $.get('/patrimonial/api/search/compra-direta/entidade', {
                'cod_entidade': codEntidadeValue
            }).success(function (data) {
                populateSelect(codCentroField, data, {
                    value: 'codCentro',
                    text: 'descricao'
                });

                codCentroField
                    .prop('readonly', false)
                    .select2();
            });
        })
    ;
}());
