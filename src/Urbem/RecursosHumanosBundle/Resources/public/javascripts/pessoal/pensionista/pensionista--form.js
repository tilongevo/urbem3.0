(function ($, global, urbem) {
    'use strict';

    var fkSwCgmPessoaFisica = urbem.giveMeBackMyField('fkSwCgmPessoaFisica'),
        codPrevidencia = urbem.giveMeBackMyField('codPrevidencia'),
        codCid = urbem.giveMeBackMyField('codCid'),
        codContratoCedente = urbem.giveMeBackMyField('codContratoCedente'),
        codBanco = urbem.giveMeBackMyField('codBanco'),
        codAgencia = urbem.giveMeBackMyField('codAgencia'),
        codProcesso = urbem.giveMeBackMyField('codProcesso'),
        dtInclusaoProcesso = urbem.giveMeBackMyField('dtInclusaoProcesso'),
        percentualPagamento = urbem.giveMeBackMyField('percentualPagamento')
    ;

    fkSwCgmPessoaFisica.on('change', function() {
        if ($(this).val() != '') {
            abreModal('Carregando','Aguarde, buscando a dados do CGM...');
            $.ajax({
                url: "/recursos-humanos/pessoal/servidor/consulta-dados-cgm-pessoa-fisica/" + $(this).val(),
                method: "GET",
                dataType: "json",
                success: function (data) {
                    for (var i in data) {
                        $("." + i).html(data[i]);
                    }
                    fechaModal();
                }
            });
            $.ajax({
                url: "/recursos-humanos/pessoal/pensionista/previdencia",
                method: "POST",
                data: {
                    numcgm: $(this).val()
                },
                dataType: "json",
                success: function (data) {
                    urbem.populateMultiSelect(codPrevidencia, data, {value: 'codPrevidencia', label: 'descricao'}, codPrevidencia.val());
                }
            });
        }
    });

    codCid.on("change", function() {
        $("#dp_" + urbem.uniqId + "_dtLaudo").data("DateTimePicker").enable();
    });

    codContratoCedente.on("change", function() {
        percentualPagamento.prop("disabled", false);
    });

    codBanco.on("change", function() {
        if ($(this).val() != "") {
          abreModal('Carregando','Aguarde, buscando agências...');
          urbem.UrbemSearch.findAgenciasByBanco($(this).val())
          .success(function (data) {
              urbem.populateSelect(codAgencia, data, {value: 'codAgencia', label: 'nomAgencia'});
              fechaModal();
          });
        }
    });

    codProcesso.on("change", function () {
        abreModal('Carregando','Aguarde, buscando a data de inclusão do processo...');
        $.ajax({
            url: "/recursos-humanos/pessoal/pensionista/consultar-data-inclusao-processo",
            method: "POST",
            data: {
                codProcesso: $(this).val(),
            },
            dataType: "json",
            success: function (data) {
                dtInclusaoProcesso.val(data);
                fechaModal();
            }
        });
    });

    fkSwCgmPessoaFisica.trigger("change");

    $(document).ready(function() {
        if (codCid.val() == "") {
            $("#dp_" + urbem.uniqId + "_dtLaudo").data("DateTimePicker").disable();
        }

        if (codContratoCedente.val() == "") {
            percentualPagamento.prop("disabled", true);
        }
    });
})(jQuery, window, UrbemSonata);
