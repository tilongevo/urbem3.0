$(function() {

    var inscricaoEconomica = UrbemSonata.giveMeBackMyField("inscricaoEconomica"),
        modelo = $('#'+ UrbemSonata.uniqId +'_fkEconomicoLicenca__fkEconomicoLicencaDocumentos__fkAdministracaoModeloDocumentos'),
        atividade = $('#custom_fkEconomicoAtividadeCadastroEconomico__fkEconomicoAtividade');

    var uri = window.location.href,
        atividade = $('#custom_fkEconomicoAtividadeCadastroEconomico__fkEconomicoAtividade'),
        labelModelo = $("label[for='"+UrbemSonata.uniqId+"_fkEconomicoLicenca__fkEconomicoLicencaDocumentos__fkAdministracaoModeloDocumentos']").text();

    labelModelo += ' *';
    $("label[for='"+UrbemSonata.uniqId+"_fkEconomicoLicenca__fkEconomicoLicencaDocumentos__fkAdministracaoModeloDocumentos']").text(labelModelo);

    if (atividade && uri.indexOf('edit') == '-1' && uri.indexOf('uniqid') == '-1') {
        atividade.attr('disabled', true);
    } else if (atividade && uri.indexOf('edit') != '-1' && uri.indexOf('uniqid') == '-1') {
        atividade.attr('disabled', true);
        $('#s2id_autogen1').attr('disabled', true);
        loading(true);
        var splittedUri = uri.split('/');
        var codLicenca = splittedUri[splittedUri.length-2].split('~')[0];
        var codAtividade = splittedUri[splittedUri.length-2].split('~')[2];
        preencheDiasSemana(codLicenca);
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

    var inputHorariosSelecionados = null;

    function newInputHidden() {
        inputHorariosSelecionados = document.createElement('input');
        inputHorariosSelecionados.id = 'id_HorariosSelecionados';
        inputHorariosSelecionados.name = 'ids_HorariosSelecionados';
        inputHorariosSelecionados.setAttribute('type', 'hidden');

        return inputHorariosSelecionados;
    }

    $('#horario').on('click', function (e) {
        e.preventDefault();
        $('.error_horario').remove();
        inputHorariosSelecionados = newInputHidden();
        var hrInicio = $('.input-hrInicio').attr('name', 'custom_input_diasSemana_horaInicio')[0];
        var hrTermino = $('.input-HrTermino').attr('name', 'custom_input_diasSemana_horaTermino')[0];
        if (hrInicio.value && hrTermino.value) {
            var registros = $('.dia-horario');
            var horariosSelecionados = [];
            var dias = $('.check-dias').attr('name', 'custom_check_diasSemana');
            var nome = $('.nomes-dias');
            var prosseguir = false;
            for (var i = 0; i < dias.length; i++) {
                if (dias[i].checked == true && registros.length == 0) {
                    horariosSelecionados.push({
                        dia: dias[i].value,
                        nome: nome[i].innerText,
                        inicio: hrInicio.value,
                        termino: hrTermino.value
                    });
                    prosseguir = true;
                } else if (dias[i].checked == true && registros.length > 0) {
                    var dia = $('#dia_' + dias[i].value);
                    if (nome[i].outerText == dia.text()) {
                        $('#tr_dia_' + dias[i].value).remove();
                    }
                    horariosSelecionados.push({
                        dia: dias[i].value,
                        nome: nome[i].innerText,
                        inicio: hrInicio.value,
                        termino: hrTermino.value
                    });
                    prosseguir = true;
                }
            }
            if (prosseguir) {
                getEntradaHorariosSelecionados(horariosSelecionados);
            }
        }
        console.log('oi');
    });

    function getEntradaHorariosSelecionados(horarios)
    {
        for (var j = 0; j < horarios.length; j++) {
            var tr = document.createElement('tr');
            tr.id = 'tr_dia_'+horarios[j]['dia'];

            var td1 = document.createElement('td');
            td1.innerHTML = horarios[j]['nome'];
            td1.id = 'dia_'+horarios[j]['dia'];
            td1.className = 'dia-horario';
            tr.appendChild(td1);

            var td2 = document.createElement('td');
            td2.innerHTML += horarios[j]['inicio'];
            td2.style.fontWeight = 'bold';
            tr.appendChild(td2);

            var td3 = document.createElement('td');
            td3.innerHTML = horarios[j]['termino'];
            td3.style.fontWeight = 'bold';
            tr.appendChild(td3);

            var td4 = document.createElement('td');
            var divExluir = document.createElement('div');
            divExluir.id = 'dia_'+horarios[j]['dia'];
            divExluir.className = 'blue-text text-darken-4 transparent z-depth-0 hide-on-med-and-down tooltipped btn-list excluir-horario-selecionado dia_' + horarios[j]['dia'];
            divExluir.style.cursor = 'pointer';
            divExluir.setAttribute('data-toggle', 'tooltip');
            divExluir.setAttribute('data-placement', 'bottom');
            divExluir.setAttribute('data-original-title', 'Excluir');

            var i = document.createElement('i');
            i.className = 'fa fa-trash fa-lg';

            divExluir.appendChild(i);
            td4.appendChild(divExluir);

            if (inputHorariosSelecionados == null) {
                inputHorariosSelecionados = newInputHidden();
            }
            tr.appendChild(td4);
            document.getElementById("tbodyHorariosSelecionados").appendChild(tr);
            document.getElementById("tbodyHorariosSelecionados").appendChild(inputHorariosSelecionados);
            $('.excluir-horario-selecionado').on('click', function (e) {
                $('#tr_' + e.target.parentElement.id).remove();
            });
        }
    }

    function preencheDiasSemana(codLicenca)
    {
        $.ajax({
            url: "/tributario/cadastro-economico/licenca/get-dias-semana-by-cod-licenca",
            method: "GET",
            data: {codLicenca: codLicenca},
            dataType: "json",
            success: function (data) {
                var horarios = [];
                for (var i = 0; i < data['items'].length; i++) {
                    horarios.push({
                        dia: data['items'][i]['dia'],
                        nome: data['items'][i]['nome'],
                        inicio: data['items'][i]['inicio'],
                        termino: data['items'][i]['termino']
                    });
                }
                $('.input-hrInicio').attr('name', 'custom_input_diasSemana_horaInicio').attr('required', false);
                $('.input-HrTermino').attr('name', 'custom_input_diasSemana_horaTermino').attr('required', false);
                getEntradaHorariosSelecionados(horarios);
            }
        });
    }

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
        span.style.top = '-320px';
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
        var isSubmit = true;
        var tbody = document.getElementById("tbodyHorariosSelecionados");
        if (!inputHorariosSelecionados) {
            var div = document.createElement('div');
            div.className = 'error_horario'
            div.style.color = 'red';
            div.style.marginRight = '0';
            div.style.marginTop = '8px';
            div.innerHTML = 'É necessário incluir um Horário';
            document.getElementById("error-horario").appendChild(div);
            isSubmit = false;
        }
        if (isSubmit) {
            var header = isTableHeader($('#table-atividades-selecionadas').length);
            if (!header) {
                validaInputAtividade('nao-foi-selecionada');
                isSubmit = false;
            }
            if (!modelo.val()) {
                validaInputModelo();
                isSubmit = false;
            }
        }
        if (isSubmit) {
            inputHorariosSelecionados.value = null;
            for (var i = 0; i < tbody.children.length; i++) {
                if (tbody.children[i].children[0]) {
                    var trId = tbody.children[i].id;
                    trId = trId.split('tr_dia_');
                    var dia = trId[1];
                    var inicio = tbody.children[i].children[1].innerText;
                    var termino = tbody.children[i].children[2].innerText;
                    if (inputHorariosSelecionados.value == null) {
                        inputHorariosSelecionados.value += dia + ';' + inicio + ';' + termino;
                    } else {
                        var count = (i) + 1;
                        if (count == tbody.children.length) {
                            inputHorariosSelecionados.value += dia + ';' + inicio + ';' + termino;
                        } else {
                            inputHorariosSelecionados.value += dia + ';' + inicio + ';' + termino + ',';
                        }
                    }
                }
            }
        }
        if (isSubmit) {
            if (inputHorariosSelecionados.value == null || tbody.children.length == 0) {
                isSubmit = false;
            }
        }
        return isSubmit;
    });

    var uri = location.pathname.split('/');
    if (uri[uri.length - 1].startsWith('edit')) {
        getNumCgmByInscricaoEconomica($('input[name$="[inscricaoEconomica]"]').val());
    }
    if (uri[uri.length - 1].startsWith('create') && uri.indexOf('uniqid')) {
        getNumCgmByInscricaoEconomica($('input[name$="[inscricaoEconomica]"]').val());
    }
});


















