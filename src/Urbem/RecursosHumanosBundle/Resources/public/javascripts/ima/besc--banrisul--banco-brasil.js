/*global $*/
(function() {
    'use strict';

    var codBancoSelect = $('#' + UrbemSonata.uniqId + '_codBanco'),
        UrbemSearch = UrbemSonata.UrbemSearch || {},
        populateSelect = function (select, data, prop) {
            var firstOption = select.find('option:first-child');
            select.empty().append(firstOption);

            $.each(data, function (index, item) {
                var option = $('<option>', {value: item[prop.value], text: item[prop.text]});
                select.append(option);
            });
        },
        getAllSelects = function(regexp) {
            return $('select[name^="' + UrbemSonata.uniqId + '"]').map(function() {
                var match;
                if ((match = regexp.exec($(this).attr('id'))) !== null) {
                    return $(this);
                }
            }).get();
        },
        bancoWasSelected = function (selectBanco) {
            var selectedOption = selectBanco.find('option:selected');

            UrbemSearch
                .findAgenciasByBanco(selectedOption.val())
                .success(function(data) {
                    var selectsDeAgencia = $('select[data-related-from=_codBanco]');

                    $.each(selectsDeAgencia, function () {
                        populateSelect($(this), data, {value: 'codAgencia', text: 'nomAgencia'});
                    });
                });
        };

    codBancoSelect.on('change', function () {
        bancoWasSelected($(this));
    });

    $(document).on('change', "select[data-related-from=_codBanco]", function(e) {
		    e.stopPropagation();

        var selectedOption = $(this).find('option:selected'),
            regexp = /([a-zA-Z0-9]+)/g,
            currentRow = $(this).attr('name').match(regexp);

        UrbemSearch
            .findContasCorrenteByAgencia(selectedOption.val())
            .success(function(data) {
                var selectId = "#" + currentRow[0] + "_" + currentRow[1] + "_" + currentRow[2] + "_codContaCorrente",
                    contaCorrenteField = $(selectId);

                populateSelect(contaCorrenteField, data, {value: 'codContaCorrente', text: 'numContaCorrente'});
            });
    });

    var optionsDoSelectDeOrgaos = [{}],
        optionsDeSelectDeLocais = [{}];

    $(document).on('click', '.sonata-ba-action', function(e) {
        var selectsDeOrgaos = getAllSelects(/\_+(orgao)/),
            selectsDeLocais = getAllSelects(/\_+(local)/);

        $.each(selectsDeOrgaos, function() {
            var options = $(this).val();

            optionsDoSelectDeOrgaos.push({
                id: $(this).attr('id'),
                options: options
            });
        });

        $.each(selectsDeLocais, function() {
            var options = $(this).val();

            optionsDeSelectDeLocais.push({
                id: $(this).attr('id'),
                options: options
            });
        });
    });

    $(document).on('sonata.add_element', function() {
        var selectsDeAgencias = getAllSelects(/\_+(codAgencia)/),
            selectsDeContasCorrente = getAllSelects(/\_+(codContaCorrente)/),
            selectsDeOrgaos = getAllSelects(/\_+(orgao)/),
            selectsDeLocais = getAllSelects(/\_+(local)/);

        $.each(selectsDeAgencias, function() {
            var selectedOption = $(this).find('option:selected'),
                firstOption = $(this).find('option:first-child');

            if (codBancoSelect.find('option:selected').text() !==
                codBancoSelect.find('option:first-child').text()) {
                $(this).empty().append(firstOption);
                bancoWasSelected(codBancoSelect);
                $(this).append(selectedOption);
            } else {
                $(this).empty().append(firstOption);
            }
        });

        $.each(selectsDeContasCorrente, function() {
            var selectedOption = $(this).find('option:selected'),
                firstOption = $(this).find('option:first-child');

            $(this)
                .empty()
                .append(firstOption)
                .append(selectedOption);
        });

        $.each(selectsDeOrgaos, function() {
            var selectOrgao = $(this);

            $.each(optionsDoSelectDeOrgaos, function(index) {
                if (this.id == selectOrgao.attr('id')) {
                    $('#s2id_' + $(this).attr('id')).select2('val', optionsDoSelectDeOrgaos[index].options);
                }
            });
        });

        $.each(selectsDeLocais, function() {
            var selectOrgao = $(this);

            $.each(optionsDeSelectDeLocais, function(index) {
                if (this.id == selectOrgao.attr('id')) {
                    $('#s2id_' + $(this).attr('id')).select2('val', optionsDeSelectDeLocais[index].options);
                }
            });
        });
    });

}(jQuery));
