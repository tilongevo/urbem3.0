$(function()
{
    var addClass = function () {
        $("#form_codEntidade").select2();
        $("#form_codGrupo").select2();
    }();

    var ajusteLabels = function () {
        var labelEntidade = $("label[for='form_codEntidade']").text(),
            labelGrupo = $("label[for='form_codGrupo']").text();
        labelEntidade += ' *';
        labelGrupo += ' *';
        $("label[for='form_codEntidade']").text(labelEntidade);
        $("label[for='form_codGrupo']").text(labelGrupo);
    }();

    function valida(param)
    {
        var span = document.createElement('span'),
            area = null;

        if (param == 'entidade') {
            $('.error_input_entidade').remove();
            area = $("#form_codEntidade").parent();
            span.className = 'error_input_entidade'
            span.innerHTML = 'É necessário selecionar uma entidade';
        } else if (param == 'grupo') {
            $('.error_input_grupo').remove();
            area = $("#form_codGrupo").parent();
            span.className = 'error_input_grupo'
            span.innerHTML = 'É necessário selecionar um grupo';
        }
        span.style.top = '5px';
        span.style.color = 'red';
        area[0].appendChild(span);
    }

    $('#form_codEntidade').on('change', function () {
        $('.error_input_entidade').remove();
    });

    $('#form_codGrupo').on('change', function () {
        $('.error_input_grupo').remove();
    });

    $('.form-implantacao-saldo').on('submit', function(e)
    {
        var isSubmit = true,
            codGrupo = $('#form_codGrupo'),
            codEntidade = $('#form_codEntidade');

        if (!codEntidade.select2('data').id) {
            valida('entidade');
            isSubmit = false;
        }
        if (!codGrupo.select2('data').id) {
            valida('grupo');
            isSubmit = false;
        }

        return isSubmit;
    });
});
