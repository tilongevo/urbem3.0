(function ($, urbem) {
    'use strict';

    var ano = urbem.giveMeBackMyField('ano'),
        mes = urbem.giveMeBackMyField('mes');

    ano.on('change', function() {
        if ($(this).val() != '') {
            abreModal('Carregando','Aguarde, buscando compentencias...');
            $.ajax({
                url: '/api-search-competencia-pagamento/preencher-competencia-folha-pagamento',
                method: "POST",
                data: {
                    ano: $(this).val()
                },
                dataType: "json",
                success: function (data) {
                    urbem.populateSelect(mes, data, {value: 'id', label: 'label'}, mes.data('mes'));
                    fechaModal();
                }
            });
        }
    });

})(jQuery, UrbemSonata);
