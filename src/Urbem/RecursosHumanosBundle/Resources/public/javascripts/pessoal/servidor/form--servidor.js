var varJsCodUf;

(function ($, urbem, global) {
    var modal,
        fkSwUf = urbem.giveMeBackMyField('fkSwUf'),
        fkSwCgmPessoaFisica = urbem.giveMeBackMyField('fkSwCgmPessoaFisica'),
        dtNascimento = urbem.giveMeBackMyField('dtNascimento'),
        endereco = urbem.giveMeBackMyField('endereco'),
        bairro = urbem.giveMeBackMyField('bairro'),
        cep = urbem.giveMeBackMyField('cep'),
        fone = urbem.giveMeBackMyField('fone'),
        escolaridade = urbem.giveMeBackMyField('escolaridade'),
        cpf = urbem.giveMeBackMyField('cpf'),
        rg = urbem.giveMeBackMyField('rg'),
        orgaoemissor = urbem.giveMeBackMyField('orgaoemissor'),
        numerocnh = urbem.giveMeBackMyField('numerocnh'),
        categoriacnh = urbem.giveMeBackMyField('categoriacnh'),
        pis = urbem.giveMeBackMyField('pis'),
        sexo = urbem.giveMeBackMyField('sexo'),
        uf = urbem.giveMeBackMyField('uf'),
        municipio = urbem.giveMeBackMyField('municipio'),
        nacionalidade = urbem.giveMeBackMyField('nacionalidade')
    ;

    if (UrbemSonata.isFunction($.urbemModal)) {
        modal = $.urbemModal();
    }

    fkSwUf.on('change', function () {
        varJsCodUf = $(this).val();
        $('#municipioCgm_autocomplete_input').select2('data', {
            id: null,
            label: null
        });
    });

    fkSwCgmPessoaFisica.on('change', function () {
        $.ajax({
            url: "/recursos-humanos/pessoal/servidor/consulta-dados-cgm-pessoa-fisica/" + $(this).val(),
            method: 'GET',
            dataType: 'json',
            beforeSend: function (xhr) {
              modal
                .disableBackdrop()
                .setBody('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, Buscando dados do CGM...</h4>')
                .open();
            },
            error: function (xhr, textStatus, error) {
                modal.close();

                modal
                    .disableBackdrop()
                    .setTitle(error)
                    .setBody('Contate o administrador do sistema.')
                    .open();

                global.setTimeout(function () {
                    modal.close();
                }, 5000);
            },
            success: function (data) {
                if (data.dtNascimento == '') {
                    dtNascimento.val('');
                } else {
                    $("#dp_" + UrbemSonata.uniqId + "_dtNascimento").data("DateTimePicker").setValue(moment(data.dtNascimento, 'DD/MM/YYYY').format("DD/MM/YYYY"));
                }

                endereco.val(data.endereco);
                bairro.val(data.bairro);
                cep.val(data.cep);
                fone.val(data.fone);
                escolaridade.val(data.escolaridade);
                cpf.val(data.cpf);
                rg.val(data.rg);
                orgaoemissor.val(data.orgaoemissor);
                numerocnh.val(data.numerocnh);
                categoriacnh.val(data.categoriacnh);
                pis.val(data.pis);
                sexo.val(data.sexo);
                uf.val(data.uf);
                municipio.val(data.municipio);
                nacionalidade.val(data.nacionalidade);
                modal.close();
            }
        });
    })

    pis.mask('999.99999.99-9');

    fkSwUf.trigger("change");
})(jQuery, UrbemSonata, window);
