(function(){
    'use strict';
    var fieldNorma =  UrbemSonata.giveMeBackMyField('fkNormasNorma')
        , fieldTipoComissao =  UrbemSonata.giveMeBackMyField('fkLicitacaoTipoComissao')
        , fieldDataComissao = $(".dataComissao")
        , fieldVigencia= $(".vigencia")
        , modal = jQuery.urbemModal()
        , urlEndPoint = '/patrimonial/licitacao/comissao-licitacao/norma-vigencia?id='
        , urlEndPointFinalidade = '/patrimonial/licitacao/comissao-licitacao/get-tipo-membro'
        , collectionCount = 0
        , collectionAdminPrefix = "fkLicitacaoComissaoMembros"
        , optionsFinalidade = [];

    var fieldNormaOnChangeAction = function () {
        var modal = jQuery.urbemModal();
        var collectionCount = $(this)[0]
            .id
            .replace('_fkNormasNorma_autocomplete_input', '')
            .replace(UrbemSonata.uniqId + '_' + collectionAdminPrefix + '_', '');
        var prefixFieldName = collectionAdminPrefix + '_' + collectionCount + '_';

        if (collectionCount.length > 4) {
            var dataComissao = UrbemSonata.giveMeBackMyField('dataComissao');
            var vigencia = UrbemSonata.giveMeBackMyField('vigencia');
        }else {
            var dataComissao = UrbemSonata.giveMeBackMyField(prefixFieldName + 'dataComissao');
            var vigencia = UrbemSonata.giveMeBackMyField(prefixFieldName + 'vigencia');
        }

        var codValue = $(this).val();
        if (!codValue) {
            return;
        }
        if (codValue != '' && dataComissao) {
            jQuery.ajax({
                method: 'GET',
                url: urlEndPoint + codValue,
                dataType: 'json',
                beforeSend: function (xhr) {
                    modal
                        .disableBackdrop()
                        .setTitle('Aguarde...')
                        .setBody('Carregando data de Designação da Comissão e Vigência.')
                        .open();
                },
                success: function (data) {
                    var datePublicacao = 'Não informado'
                        , dateTermino = 'Não informado';
                    if (data.item.datePublicacao != null) {
                        datePublicacao = data.item.datePublicacao;
                    }

                    if (data.item.dateTermino != null) {
                        dateTermino = data.item.dateTermino;
                    }
                    dataComissao.val(datePublicacao);
                    vigencia.val(dateTermino);
                    modal.close();
                }
            });
        }

    };

    var changeFinalidade = function () {
        if(optionsFinalidade.length <= 0) {
            addFinalidade();
        }

        var newFieldsFinalidade = []
            , valFinalidade = $(this).val()
            , fieldActive = [];
        if (valFinalidade == 1) {
            fieldActive = ['','1','2'];
        }
        if (valFinalidade == 2) {
            fieldActive = ['','1','2','3'];
        }
        if (valFinalidade == 3) {
            fieldActive = ['','1','3'];
        }
        if (valFinalidade == 4) {
            fieldActive = ['','1'];
        }


        $.each(optionsFinalidade, function (index, data) {
            var valOption = data.value;
            if ($.inArray( valOption, fieldActive ) > -1) {
                newFieldsFinalidade.push(data);
            }
        });
        var dataParam = [];
        $.each(newFieldsFinalidade, function (index, data) {
            var addNewParam = {
                'value' : data.value,
                'label' : data.label
            };

            dataParam.push(addNewParam);
        });
        $('select.tipoMembro').empty().select2();
        UrbemSonata.populateSelect($('select.tipoMembro'), dataParam, {
            value: "value",
            label: "label"
        });
    };

    function addFinalidade()
    {
        jQuery.ajax({
            method: 'GET',
            async: false,
            url: urlEndPointFinalidade,
            dataType: 'json',
            beforeSend: function (xhr) {
                modal
                    .disableBackdrop()
                    .setTitle('Aguarde...')
                    .setBody('Carregando tipos de membro.')
                    .open();
            },
            success: function (data) {
                $.each(data.item, function (index, item) {
                    var addNewParam = {
                        'value' : item.value,
                        'label' : item.label
                    };
                    optionsFinalidade.push(addNewParam);
                });
                modal.close();
            }
        });
    }

    $(document).on('sonata.add_element', function (e) {
        if(optionsFinalidade.length <= 0) {
            addFinalidade();
        }
        for (var i = 0; i <= collectionCount; i++) {
            var prefixFieldName = collectionAdminPrefix + '_' + i + '_';
            var norma = UrbemSonata.giveMeBackMyField(prefixFieldName + 'fkNormasNorma');

            if (norma) {
                norma.on('change', fieldNormaOnChangeAction);
                norma.trigger('change');
            }
        }
        collectionCount++;
    });
    var norma = jQuery('input[id*=fkNormasNorma]');
    collectionCount = norma.length;
    norma.on('change', fieldNormaOnChangeAction);
    norma.trigger('change');

    if (fieldTipoComissao) {
        fieldTipoComissao.on('change', changeFinalidade);
    }
}());