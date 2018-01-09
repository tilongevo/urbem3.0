var filterCodPlanoDebito = $("#filter_codPlanoDebito_value_autocomplete_input"),
    filterCodPlanoCredito = $("#filter_codPlanoCredito_value_autocomplete_input"),
    filterCodBarras = $("#filter_codBarras_value"),
    filterEntidade = $("#filter_fkContabilidadeLote__fkOrcamentoEntidade_value"),
    filterCodRecibo = $("#filter_fkTesourariaReciboExtraTransferencias__codReciboExtra_value"),
    filterDtBoletim = $("#filter_fkTesourariaBoletim__dtBoletim_value"),
    filterCodBoletim = $("#filter_codBoletim_value");

filterCodPlanoDebito.on("change", function() {
    localStorage.setItem('codPlanoDebitoId', $(this).select2('data').id);
    localStorage.setItem('codPlanoDebitoLabel', $(this).select2('data').label);
});

if ($("input[name='filter[codPlanoDebito][value]']").val()) {
    filterCodPlanoDebito.select2('data', {
        id: localStorage.getItem('codPlanoDebitoId'),
        label: localStorage.getItem('codPlanoDebitoLabel')
    });
}

filterCodPlanoCredito.on("change", function() {
    localStorage.setItem('codPlanoCreditoId', $(this).select2('data').id);
    localStorage.setItem('codPlanoCreditoLabel', $(this).select2('data').label);
});

if ($("input[name='filter[codPlanoCredito][value]']").val()) {
    filterCodPlanoCredito.select2('data', {
        id: localStorage.getItem('codPlanoCreditoId'),
        label: localStorage.getItem('codPlanoCreditoLabel')
    });
}

localStorage.removeItem('codPlanoDebitoId');
localStorage.removeItem('codPlanoDebitoLabel');
localStorage.removeItem('codPlanoCreditoId');
localStorage.removeItem('codPlanoCreditoLabel');

filterCodBarras.on('change', function() {
    $('.sonata-ba-field-error-messages').remove();
    var codBarras = $(this).val();
    if (codBarras.length == 20) {
        getData($(this).val());
    } else if (codBarras.length != 0) {
        filterCodBarras.after(
            '<div class="help-block sonata-ba-field-error-messages">' +
            '<ul class="list-unstyled">' +
            '<li><i class="fa fa-exclamation-circle"></i> Código de barras inválido!</li>' +
            '</ul>' +
            '</div>'
        );
    }
});

filterCodBarras.on('click', function () {
    if ($(this).val().length == 0) {
        $('.sonata-ba-field-error-messages').remove();
    }
});

function getData(codBarras)
{
    $('.sonata-ba-field-error-messages').remove();
    $.ajax({
        url: "/financeiro/tesouraria/arrecadacao/extra-estornos/ler-codigo-de-barras",
        method: "POST",
        data: {codBarras: codBarras},
        dataType: "json",
        success: function (data) {
            if (data.length != 0) {
                filterEntidade.select2('val', data.codEntidade);
                filterCodRecibo.val(data.codReciboExtra);
                filterDtBoletim.val(data.dtBoletim);
                filterCodBoletim.val(data.codBoletim);
                filterCodPlanoCredito.select2('data', {
                    id: data.codPlanoCredito,
                    label: data.codPlanoContaCredito
                });
                localStorage.setItem('codPlanoCreditoId', filterCodPlanoCredito.select2('data').id);
                localStorage.setItem('codPlanoCreditoLabel', filterCodPlanoCredito.select2('data').label);
                $("input[name='filter[codPlanoCredito][value]']").val(data.codPlanoCredito);
                filterCodPlanoDebito.select2('data', {
                    id: data.codPlanoDebito,
                    label: data.codPlanoContaDebito
                });
                localStorage.setItem('codPlanoDebitoId', filterCodPlanoDebito.select2('data').id);
                localStorage.setItem('codPlanoDebitoLabel', filterCodPlanoDebito.select2('data').label);
                $("input[name='filter[codPlanoDebito][value]']").val(data.codPlanoDebito);
            } else {
                filterCodBarras.after(
                    '<div class="help-block sonata-ba-field-error-messages">' +
                    '<ul class="list-unstyled">' +
                    '<li><i class="fa fa-exclamation-circle"></i> Código de barras inválido!</li>' +
                    '</ul>' +
                    '</div>'
                );
                localStorage.removeItem('codPlanoDebitoId');
                localStorage.removeItem('codPlanoDebitoLabel');
                localStorage.removeItem('codPlanoCreditoId');
                localStorage.removeItem('codPlanoCreditoLabel');

                filterEntidade.select2('val', '');
                filterCodRecibo.val('');
                filterDtBoletim.val('');
                filterCodBoletim.val('');
                filterCodPlanoCredito.select2('data', {
                    id: '',
                    label: ''
                });
                $("input[name='filter[codPlanoCredito][value]']").val('');
                filterCodPlanoDebito.select2('data', {
                    id: '',
                    label: ''
                });
                $("input[name='filter[codPlanoDebito][value]']").val('');
            }
        }
    });
}


