/*global $*/
(function() {
    'use strict';
    var pagina = window.location.href;

    if(pagina.search('recursos-humanos/ima/configuracao-hsbc') != '-1')
    {
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
            bancoWasSelected = function (selectBanco) {
                var selectedOption = selectBanco.find('option:selected');

                UrbemSearch
                    .findAgenciasByBanco(selectedOption.val())
                    .success(function(data) {
                        populateSelect($('#' + UrbemSonata.uniqId + '_codAgencia'), data, {value: 'codAgencia', text: 'nomAgencia'});
                    });
            };

        codBancoSelect.on('change', function () {
            bancoWasSelected($(this));
        });

        $(document).on('change', "*[id*=_codAgencia]", function(e) {
            e.stopPropagation();

            var selectedOption = $(this).find('option:selected');
            var codBanco = $('#' + UrbemSonata.uniqId + '_codBanco').val();

            console.log(selectedOption.val());

            UrbemSearch
                .findContasCorrenteByAgencia(codBanco,selectedOption.val())
                .success(function(data) {
                    var contaCorrenteField = $('#' + UrbemSonata.uniqId + '_codContaCorrente');
                    populateSelect(contaCorrenteField, data, {value: 'codContaCorrente', text: 'numContaCorrente'});
                });
        });

        codBancoSelect.trigger('change');
    }

}(jQuery));