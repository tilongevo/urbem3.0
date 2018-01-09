$(function()
{
    isExibeInputs(false);

    if ( $("#" + UrbemSonata.uniqId + "_fkEconomicoNivelServicoValores__fkEconomicoNivelServico").is('.select-nivel-is-edit') ) {
        loading(true);
        checkMascara( UrbemSonata.giveMeBackMyField('fkEconomicoNivelServicoValores__fkEconomicoNivelServico').val() );
    }

    $("#" + UrbemSonata.uniqId + "_fkEconomicoNivelServicoValores__fkEconomicoNivelServico").on("change", function()
    {
        loading(true);
        checkMascara( UrbemSonata.giveMeBackMyField('fkEconomicoNivelServicoValores__fkEconomicoNivelServico').val() );
    });

    function codEstruturalAndAliquotaHide()
    {
        $("#" + UrbemSonata.uniqId + "_codEstrutural").attr('disabled', true);
        $("label[for='" + UrbemSonata.uniqId + "_fkEconomicoAliquotaServicos']").css('display', 'none');
        $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_fkEconomicoAliquotaServicos").css('display', 'none');
    }

    function checkMascara(nivel)
    {
        codEstruturalAndAliquotaHide();
        if(nivel) {
            $.ajax({
                url: '/tributario/cadastro-economico/servico/get-mascara-cod-estrutural',
                method: 'GET',
                data: {nivel: nivel},
                dataType: 'json',
                success: function (data) {
                    if (data) {
                        $("#" + UrbemSonata.uniqId + "_codEstrutural").mask(data['items']);
                    }
                    checkNivelSuperior(nivel);
                    isExibeInputs(true);
                }
            });
        } else {
            loading(false);
        }
    }

    function checkNivelSuperior(nivel)
    {
        $.ajax({
            url: '/tributario/cadastro-economico/hierarquia-servico/nivel/check-nivel-superior',
            method: 'GET',
            data: {nivel: nivel},
            dataType: 'json',
            success: function (data) {
                if (!data) {
                    $("label[for='" + UrbemSonata.uniqId + "_fkEconomicoAliquotaServicos']").css('display', 'block');
                    $("label[for='" + UrbemSonata.uniqId + "_fkEconomicoAliquotaServicos']").innerHTML += '*';
                    $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_fkEconomicoAliquotaServicos").css('display', 'block');
                    $("#" + UrbemSonata.uniqId + "_fkEconomicoAliquotaServicos").attr('disabled', false);
                }
                $("#" + UrbemSonata.uniqId + "_codEstrutural").attr('disabled', false);
                loading(false);
            }
        });
    }

    function isExibeInputs(param)
    {
        if (param) {
            $(".box-header")[1].style.display = 'block';
            $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_nomServico").show();
            $("#" + UrbemSonata.uniqId + "_nomServico").show();
            $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_codEstrutural").show();
            $("#" + UrbemSonata.uniqId + "_codEstrutural").show();
            $("#" + UrbemSonata.uniqId + "_fkEconomicoAliquotaServicos").attr('disabled', true);
        } else {
            $(".box-header")[1].style.display = 'none';
            $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_nomServico").hide();
            $("#" + UrbemSonata.uniqId + "_nomServico").hide();
            $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_codEstrutural").hide();
            $("#" + UrbemSonata.uniqId + "_codEstrutural").hide();
            $("#" + UrbemSonata.uniqId + "_fkEconomicoNivelServicoValores__fkEconomicoNivelServico").attr('disabled', false);
            $("#" + UrbemSonata.uniqId + "_fkEconomicoAliquotaServicos").attr('disabled', false);
            $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_fkEconomicoAliquotaServicos").css('display', 'none');
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
});