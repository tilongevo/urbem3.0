$(function() {

    var uri = location.pathname.split('/');

    if(!uri[uri.length - 1].startsWith('show')) {
        $('div.box:last').hide();
    }

    if (uri[uri.length - 1].startsWith('edit')) {
        return;
    }

    var swcgm = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_swcgm'),
        classificacao = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkSwClassificacao'),
        assunto = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkSwAssunto'),
        observacao = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkEconomicoLicenca__fkEconomicoLicencaObservacao__observacao'),
        processo = $("#s2id_" + UrbemSonata.uniqId + "_codProcesso"),
        dtInicio = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkEconomicoLicenca__dtInicio'),
        dtTermino = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkEconomicoLicenca__dtTermino'),
        selectModelo = UrbemSonata.giveMeBackMyField("modeloDocumento"),
        modelo = $('#' + UrbemSonata.uniqId + '_modeloDocumento'),
        elemento =  $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkEconomicoElementoTipoLicencaDiversa'),
        tipoLicenca = $('#' + UrbemSonata.uniqId + '_fkEconomicoTipoLicencaDiversa'),
        labelModelo = $("label[for='"+UrbemSonata.uniqId+"_modeloDocumento']").text();

    labelModelo += ' *';
    $("label[for='"+UrbemSonata.uniqId+"_modeloDocumento']").text(labelModelo);
    ocultaCampos();
    tipoLicenca.on('change', function ()
    {
        loading(true);
        carregaModeloDocumento(tipoLicenca.val());
        carregaElementoTipoLicencaDiversa();
    });

    var uri = window.location.href;
    if (uri.indexOf('edit') != '-1' && uri.indexOf('uniqid') == '-1') {
        loading(true);
        carregaModeloDocumento(tipoLicenca.val())
    } else if (uri.indexOf('uniqid') != '-1') {
        exibeCampos();
        carregaModeloDocumento();
    }

    $('input[name$="[fkEconomicoElementoTipoLicencaDiversa]"]').html('<option>Selecione</option>');

    function ocultaCampos()
    {
        swcgm.hide();
        classificacao.hide();
        assunto.hide();
        observacao.hide();
        processo.hide();
        processo.parent().parent().parent().parent().parent().hide();
        dtInicio.parent().parent().parent().hide();
        dtInicio.hide();
        dtTermino.hide();
        modelo.hide();
        elemento.parent().parent().parent().hide();
        elemento.hide();
    }

    function exibeCampos()
    {
        swcgm.show();
        classificacao.show();
        assunto.show();
        observacao.show();
        processo.show();
        processo.parent().parent().parent().parent().parent().show();
        dtInicio.parent().parent().parent().show();
        dtInicio.show();
        dtTermino.show();
        modelo.show();
        elemento.parent().parent().parent().show();
        elemento.show();

        $('div.box:last').show();

        var uri = location.pathname.split('/');
        if (!uri[uri.length - 1].startsWith('create') && !uri[uri.length - 1].startsWith('edit')) {
            return;
        }

        atributoDinamicoParams = {
            tabela: 'CoreBundle:Economico\\AtributoTipoLicencaDiversa',
            fkTabela: 'getFkEconomicoAtributoLicencaDiversaValores',
            tabelaPai: 'CoreBundle:Economico\\TipoLicencaDiversa',
            codTabelaPai: {
                codTipo: tipoLicenca.val()
            },
            fkTabelaPaiCollection: 'getFkEconomicoAtributoTipoLicencaDiversas',
            fkTabelaPai: 'getFkEconomicoAtributoTipoLicencaDiversa'
        };

        window.AtributoDinamicoComponent.getAtributoDinamicoFields(atributoDinamicoParams);
    }

    function carregaModeloDocumento(tipoLicenca)
    {
        var selectModeloDocumento = UrbemSonata.giveMeBackMyField("modeloDocumento");
        $.ajax({
            url: "/tributario/cadastro-economico/licenca/get-modelo-documento-by-tipo-licenca",
            method: "GET",
            data: {tipoLicenca : tipoLicenca},
            dataType: "json",
            success: function (data) {
                clearSelect(selectModeloDocumento);
                selectModeloDocumento.append("<option selected>Selecione</option>");
                for (var i = 0; i < data.length; i++) {
                    selectModeloDocumento.append("<option value=" + data[i]['id'] + ">" + data[i]['id'] + " - " + data[i]['label'] + "</option>");
                }
                loading(false);
                exibeCampos();
            }
        });
    }

    function loading(display)
    {
        $('.class-spinner').remove();
        var block = null;
        if (display) {
            block = "style='display:block;'";
        }

        var spinner = "<div id='spinner' class='spinner-load-hide spinner-load ' " + block + ">" +
            "<i class='fa fa-spinner fa-spin fa-3x fa-fw'></i>" +
            "<span class='sr-only'>Loading...</span>" +
            "</div>";

        var div = document.createElement('div');
        div.className = 'class-spinner';
        div.style.marginTop = '50px';
        div.style.float = 'left';

        div.innerHTML = spinner;
        var formActions = document.querySelector(".sonata-ba-form-actions");
        document.forms[0].insertBefore(div, formActions);
    }

    function clearSelect(select) {
        select.val('');
        select.select2('val', '');
        select.find('option').each(function (index, option) {
            option.remove();
        });
    };

    function validaInputModelo()
    {
        $('.error_modelo').remove();
        var span = document.createElement('span');
        var area = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_modeloDocumento');
        span.className = 'error_modelo'
        span.style.color = 'red';
        span.innerHTML = 'É necessário selecionar um modelo';
        area[0].appendChild(span);
    }

    jQuery('.sonata-ba-form form').on('submit', function (e) {
        var isSubmit = true;
        if (!modelo.val() || modelo.val() == 'Selecione') {
            validaInputModelo();
            isSubmit = false;
        }

        return isSubmit;
    });

    function carregaElementoTipoLicencaDiversa() {
        $.ajax({
            method: 'GET',
            url: '/tributario/cadastro-economico/licenca/licenca-diversa/api/elementos-tipo-licenca',
            data: {codTipoLicenca: tipoLicenca.val()},
            dataType: 'json',
            beforeSend: function () {
                $('input[name$="[fkEconomicoElementoTipoLicencaDiversa]"]').html('');
            },
            success: function (data) {
                options = [];
                options.push('<option selected>Selecione</option>');
                $.each(data.items, function (i, item) {
                    options.push('<option value="' + item.id + '">' + item.label + '</option>');
                });

                $('input[name$="[fkEconomicoElementoTipoLicencaDiversa]"]').html(options.join('\n')).trigger('change');
            }
        });
    }
});


















