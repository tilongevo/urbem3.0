$(function () {

    var inscricaoEconomica = UrbemSonata.giveMeBackMyField("inscricaoEconomica"),
        modelo = $('#'+ UrbemSonata.uniqId +'_fkEconomicoLicenca__fkEconomicoLicencaDocumentos__fkAdministracaoModeloDocumentos'),
        atividade = $('#custom_fkEconomicoAtividadeCadastroEconomico__fkEconomicoAtividade');

    var uri = window.location.href,
        labelAtividade = $('.select-atividade label').text(),
        atividade = $('#custom_fkEconomicoAtividadeCadastroEconomico__fkEconomicoAtividade'),
        labelModelo = $("label[for='"+UrbemSonata.uniqId+"_fkEconomicoLicenca__fkEconomicoLicencaDocumentos__fkAdministracaoModeloDocumentos']").text();


    $("label[for='"+UrbemSonata.uniqId+"_fkEconomicoLicenca__fkEconomicoLicencaDocumentos__fkAdministracaoModeloDocumentos']").text(labelModelo);

    if (atividade && uri.indexOf('edit') == '-1' && uri.indexOf('uniqid') == '-1') {
        atividade.attr('disabled', true);
    } else if (atividade && uri.indexOf('edit') != '-1' && uri.indexOf('uniqid') == '-1') {
        $('#s2id_autogen1').attr('disabled', true);
        loading(true);
        var splittedUri = uri.split('/');
        var codLicenca = splittedUri[splittedUri.length-2].split('~')[0];
        var codAtividade = splittedUri[splittedUri.length-2].split('~')[2];
        preencheTableAtividades(codAtividade);
    } else if (uri.indexOf('uniqid') != '-1') {
        atividade.attr('disabled', false);
        loading(true);
    }

    $(inscricaoEconomica).on("click", function () {
        var numCgm = null;
        var selecionado = $('#select2-chosen-1').text();
        if (selecionado.indexOf('-') != -1) {
            numCgm = selecionado.split('-');
            numCgm = numCgm[1];
        }
        preencheOptionsAtividade(numCgm);
    });

    $('button[name="incluir-atividade-btn"]').on("click", function () {
        var codAtividade = atividade.val();
        $('.error_atividade').remove();
        if (!!codAtividade && codAtividade != '' && codAtividade != null && codAtividade != 'Selecione') {
            loading(true);
            preencheTableAtividades(codAtividade);
        } else if(codAtividade == 'Selecione') {
            loading(false);
        }
    });

    function getNumCgmByInscricaoEconomica(inscricaoEconomica) {
        $.ajax({
            url: "/tributario/cadastro-economico/licenca/get-numcgm-by-inscricao-economica",
            method: "GET",
            data: {inscricaoEconomica: inscricaoEconomica},
            dataType: "json",
            success: function (data) {
                if (data) {
                    var numcgm = data['items'];
                    preencheOptionsAtividade(numcgm);
                }
            }
        });
    }

    function preencheTableAtividades(codAtividade) {
        $.ajax({
            url: "/tributario/cadastro-economico/licenca/get-atividade",
            method: "GET",
            data: {codAtividade: codAtividade},
            dataType: "json",
            success: function (data) {
                outputAtividade(data[0]);
            }
        });
    }

    function preencheOptionsAtividade(numCgm)
    {
        if(numCgm) {
            atividade.attr('disabled', false);
            atividade.empty();
            $.ajax({
                url: "/tributario/cadastro-economico/licenca/get-atividade-by-swcgm",
                method: "GET",
                data: {numCgm: numCgm},
                dataType: "json",
                success: function (data) {
                    for (var i = 0; i < data.length; i++) {
                        atividade.append("<option class='atividade' value=" + data[i]['id'] + ">" + data[i]['label'] + "</option>");
                    }
                    atividade.attr('disabled', false);
                    loading(false);
                }
            });
        }
    }

    function outputAtividade(atividade)
    {
        var header = isTableHeader( $('#table-atividades-selecionadas').length );

        if(!header) {
            var table = document.createElement('table');
            table.className = 'table-atividade-container';
            table.id = 'table-atividades-selecionadas';
            table.style.marginLeft = '10px';
            table.style.marginBottom = '30px';

            var tbody = document.createElement('tbody');
            tbody.id = 'tbody-atividade';
        }

        var divExluir = document.createElement('div');
        divExluir.className = 'blue-text text-darken-4 transparent z-depth-0 hide-on-med-and-down tooltipped btn-list';
        divExluir.style.cursor = 'pointer';
        divExluir.setAttribute('data-toggle', 'tooltip');
        divExluir.setAttribute('data-placement', 'bottom');
        divExluir.setAttribute('data-original-title', 'Excluir');
        var i = document.createElement('i');
        i.className = 'fa fa-trash fa-lg';
        divExluir.appendChild(i);

        if(!header) {
            var trTitle = document.createElement('tr');
            trTitle.id = 'atividade_title';
            trTitle.className = 'sonata-ba-list-field-header';
            trTitle.style.background = '#d0d0d0';
            trTitle.innerHTML = "<th>Código</th>" +
                "<th>Nome</th>" +
                "<th>Data de Início</th>" +
                "<th>Data de Término</th>" +
                "<th>Principal</th>" +
                "<th>Excluir</th>";
        }
        var trContent = document.createElement('tr');
        trContent.id = 'atividade_' + atividade["codAtividade"];

        divExluir.onclick = function() {
            $('#atividade_' + atividade["codAtividade"]).remove();
        }

        var tdCodAtvidade = document.createElement('td');
        tdCodAtvidade.innerHTML = atividade["codAtividade"];

        if(!$('#id_CodAtividade').length) {
            var inputCodAtividade = document.createElement('input');
            inputCodAtividade.id = 'id_CodAtividade';
            inputCodAtividade.name = 'ids_CodAtividade';
            inputCodAtividade.setAttribute('type', 'hidden');
            inputCodAtividade.value = atividade['codAtividade'];
            document.forms[0].appendChild(inputCodAtividade);
        } else {
            var value = $('#id_CodAtividade').val() + ',' + atividade["codAtividade"];
            $('#id_CodAtividade').val(value);
        }

        var tdNomAtvidade = document.createElement('td');
        tdNomAtvidade.innerHTML = atividade["nomAtividade"];

        var tdInicioAtvidade = document.createElement('td');
        tdInicioAtvidade.innerHTML = atividade["dtInicioAtividade"];

        var tdTerminoAtvidade = document.createElement('td');
        tdTerminoAtvidade.innerHTML = atividade["dtTerminoAtividade"];

        var tdPrincipalAtividade = document.createElement('td');
        tdPrincipalAtividade.innerHTML = atividade["principal"];

        var tdExcluirAtividade = document.createElement('td');
        tdExcluirAtividade.appendChild(divExluir);

        if(!header) {
            tbody.appendChild(trTitle);
        }

        trContent.appendChild(tdCodAtvidade);
        trContent.appendChild(tdNomAtvidade);
        trContent.appendChild(tdInicioAtvidade);
        trContent.appendChild(tdTerminoAtvidade);
        trContent.appendChild(tdPrincipalAtividade);
        trContent.appendChild(tdExcluirAtividade);

        if(!header) {
            tbody.appendChild(trContent);
            table.appendChild(tbody);

            var formActions = document.querySelector(".sonata-ba-form-actions");
            document.forms[0].insertBefore(table, formActions);
            loading(false);
        } else {
            $('#tbody-atividade')[0].appendChild(trContent);
            loading(false);
        }
    }

    var label_atividade = $('.select-atividade label').text();
    label_atividade += ' *';
    $('.select-atividade label').text(label_atividade);

    function validaInputModelo()
    {
        $('.error_modelo').remove();
        var span = document.createElement('span');
        var area = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_fkEconomicoLicenca__fkEconomicoLicencaDocumentos__fkAdministracaoModeloDocumentos');
        span.className = 'error_modelo'
        span.style.color = 'red';
        span.innerHTML = 'É necessário selecionar um modelo';
        area[0].appendChild(span);
    }

    function validaInputAtividade(param)
    {
        $('.error_atividade').remove();
        var span = document.createElement('span');
        var area = $('.select-atividade');
        span.className = 'error_atividade'
        span.style.color = 'red';
        span.style.top = '-250px';
        if (param == 'nao-ha-atividade') {
            span.innerHTML = 'Não foram encontradas atividades';
        } else if (param == 'nao-foi-selecionada') {
            span.innerHTML = 'É necessário selecionar uma atividade';
        }
        area[1].appendChild(span);
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
        $('button[name="incluir-atividade-btn"]').parent().after(div);
    }

    function isTableHeader(length)
    {
        if(length == 0) {
            return false;
        } else {
            return true;
        }
    }

    jQuery('.sonata-ba-form form').on('submit', function (e) {
        var header = isTableHeader( $('#tbody-atividade tr').length );
        var isSubmit = true;
        if (!modelo.val()) {
            validaInputModelo();
            isSubmit = false;
        }
        if (!header) {
            validaInputAtividade('nao-foi-selecionada');
            isSubmit = false;
        }

        if($('input[name$="[inscricaoEconomica]"]').val() != '') {
            getNumCgmByInscricaoEconomica($('input[name$="[inscricaoEconomica]"]').val());
        }

        return isSubmit;
    });

    var uri = location.pathname.split('/');
    if (uri[uri.length - 1].startsWith('edit')) {
        getNumCgmByInscricaoEconomica($('input[name$="[inscricaoEconomica]"]').val());
    }

    if (uri[uri.length - 1].startsWith('create') && uri.indexOf('uniqid')) {
        if(inscricaoEconomica.val()) {
            getNumCgmByInscricaoEconomica(inscricaoEconomica.val());

            $('#'+ UrbemSonata.uniqId +'_codAtividade option').each(function () {
                preencheTableAtividades($(this).val());
            });
        }
    }
});
