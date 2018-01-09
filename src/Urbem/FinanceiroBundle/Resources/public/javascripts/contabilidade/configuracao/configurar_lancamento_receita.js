$(function () {
    "use strict";
    var contaReceita = $("#" + UrbemSonata.uniqId + "_codContaReceita"),
        lancamento = $("#s2id_" + UrbemSonata.uniqId + "_lancamento"),
        contaCredito = $("#s2id_" + UrbemSonata.uniqId + "_codConta"),
        inpLancamento = $("#" + UrbemSonata.uniqId + "_lancamento"),
        inpContaCredito = $("#" + UrbemSonata.uniqId + "_codConta"),
        selLancamento =  $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_lancamento'),
        selContaCredito = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_codConta'),
        labelContaReceita = $("label[for='"+UrbemSonata.uniqId+"_codContaReceita']").text(),
        camposPreenchidos = false;

    contaCredito.attr("disabled", true);

    isOcultaCampos(true);
    contaReceita.on("change", function() {
        isOcultaCampos(true);
        loading(true);
        $.ajax({
            url: "/financeiro/api/search/get-configuracao-receita",
            data: {codReceita : contaReceita.val()},
            method: "GET",
            dataType: "json",
            success: function (data) {
                if (data) {
                    preencheCampos('configuracao-feita');
                } else {
                    preencheCampos('todos-parametros');
                }
            }
        });
    });

    lancamento.on("change", function() {
        var opcao = $(this).val();
        var exercicio = $("#" + UrbemSonata.uniqId + "_exercicio").val();
        $.ajax({
            url: "/financeiro/api/search/receita-exercicio-estrutura?exercicio=" + exercicio
                + "&opcao=" + opcao,
            method: "GET",
            dataType: "json",
            success: function (data) {
                contaCredito.attr("disabled", false);
                contaCredito.empty().append("<option value=\"\">Selecione</option>");
                $.each(data, function (index, value) {
                    contaCredito.append("<option value=" + index + ">" + value + "</option>");
                });
            }
        });
    });

    function isOcultaCampos(param) {
        if (!param) {
            selContaCredito.parent().parent().parent().show();
            selLancamento.parent().parent().parent().show();
            contaCredito.show();
            lancamento.show();
            isDesabilitaCampos(false);
        } else {
            contaCredito.hide();
            lancamento.hide();
            selContaCredito.parent().parent().parent().hide();
            selLancamento.parent().parent().parent().hide();
        }
        loading(false);
    }

    function isDesabilitaCampos(param) {
        if (!param) {
            inpContaCredito.attr('disabled', false);
            inpLancamento.attr('disabled', false);
        } else {
            inpContaCredito.attr('disabled', true);
            inpLancamento.attr('disabled', true);
        }
    }

    function preencheCampos(param) {
        if (param && param == ('configuracao-feita')) {
            $.ajax({
                url: "/financeiro/api/search/get-lancamento-and-credito-by-conta-receita",
                data: {codReceita: contaReceita.val()},
                method: "GET",
                dataType: "json",
                success: function (data) {
                    inpLancamento.empty();
                    inpLancamento[0].appendChild(new Option(data[0]['lancamento']['label'], data[0]['lancamento']['id'], true, true));
                    $('#select2-chosen-4')[0].innerHTML = data[0]['lancamento']['label'];
                    inpContaCredito.empty();
                    inpContaCredito[0].appendChild(new Option(data[0]['conta']['label'], data[0]['conta']['id'], true, true));
                    $('#select2-chosen-5')[0].innerHTML = data[0]['conta']['label'];
                    isOcultaCampos(false);
                    isDesabilitaCampos(true);
                    camposPreenchidos = true;
                }
            });
            isDesabilitaCampos(true);
        } else if (param && param == ('todos-parametros')) {
            isOcultaCampos(true);
            loading(true);
            inpLancamento.empty();
            $.ajax({
                url: "/financeiro/api/search/get-lancamentos",
                method: "GET",
                dataType: "json",
                success: function (data) {
                    $('#select2-chosen-4')[0].innerHTML = 'Selecione';
                    var i, len;
                    for (i = 0; len = data[0].length, i < len; i++) {
                        inpLancamento[0].appendChild(new Option(data[0][i]['label'], data[0][i]['id'], false, false));
                    }
                }
            });
            inpContaCredito.empty();
            $.ajax({
                url: "/financeiro/api/search/get-contas",
                method: "GET",
                dataType: "json",
                success: function (data) {
                    $('#select2-chosen-5')[0].innerHTML = 'Selecione';
                    var i, len;
                    for (i = 0; len = data[0].length, i < len; i++) {
                        inpContaCredito[0].appendChild(new Option(data[0][i]['label'], data[0][i]['id'], false, false));
                    }
                    isOcultaCampos(false);
                }
            });
        }
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

    $('form').on('submit', function (e) {
        if ($('#select2-chosen-4')[0].innerHTML == 'Selecione' || $('#select2-chosen-5')[0].innerHTML == 'Selecione') {
            return false;
        }
        if (camposPreenchidos) {
            var inputHiddenConta = document.createElement('input');
            inputHiddenConta.name = 'codConta_';
            inputHiddenConta.setAttribute('type', 'hidden');
            inputHiddenConta.value = parseInt(inpContaCredito[0].children[0].value);
            $('form')[0].appendChild(inputHiddenConta);
            return true;
        }
    });
}());