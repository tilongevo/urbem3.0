(function ($, global, urbem) {
    'use strict';

    var fkSwCgmPessoaFisica = urbem.giveMeBackMyField('fkSwCgmPessoaFisica'),
        rg = urbem.giveMeBackMyField('rg'),
        cpf = urbem.giveMeBackMyField('cpf'),
        enderecoCompleto = urbem.giveMeBackMyField('endereco'),
        foneResidencial = urbem.giveMeBackMyField('tel_fixo'),
        foneCelular = urbem.giveMeBackMyField('tel_cel')
    ;

    var buscaDados = function () {
        abreModal('Carregando','Aguarde, buscando a dados do CGM...');
        $.ajax({
            url: "/recursos-humanos/pessoal/servidor/consulta-dados-cgm-pessoa-fisica/" + fkSwCgmPessoaFisica.val(),
            method: "GET",
            dataType: "json",
            success: function (data) {
                rg.val(data.rg);
                cpf.val(data.cpf);
                enderecoCompleto.val(data.enderecoCompleto);
                foneResidencial.val(data.foneResidencial);
                foneCelular.val(data.foneCelular);
                fechaModal();
            },
            fail: function () {
                fechaModal();
            }
        });
    };

    if (fkSwCgmPessoaFisica && fkSwCgmPessoaFisica.val()) {
        fkSwCgmPessoaFisica.select2('readonly',true);
        buscaDados();
    }

    if (fkSwCgmPessoaFisica) {
        fkSwCgmPessoaFisica.on('change', function() {
            if ($(this).val() != '') {
                buscaDados();
            }
        });
    }

})(jQuery, window, UrbemSonata);
