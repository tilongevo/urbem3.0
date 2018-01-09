(function ($, urbem, global) {

    var alteraFlag = function (dependenteDocumento) {
        $.ajax({
            url: '/recursos-humanos/pessoal/dependente/altera-flag-documentos',
            method: 'POST',
            data: dependenteDocumento,
            sucess: function (data) {
                console.log(data);
            },
            error: function (data) {
                console.log(data);
            }
        });
    };

    var matriculas = $('#matriculas-table').children();

    matriculas.each(function (val, linha) {
        var field = $(this).children('.checkbox-matricula');

        if (field.data('check')) {
            field.iCheck('check');
        }
    });

    var carteiras = $('#carteiras-table').children();

    carteiras.each(function (val, linha) {
        var field = $(this).children('.checkbox-carteira');

        if (field.data('check')) {
            field.iCheck('check');
        }
    });

    $('input').on('ifChanged', function(event){
        var dependenteDocumento = {
            codDependente: $(this).data("id"),
            codDocumento : $(this).data("cod_documento"),
            flag : $(this).context.checked,
            documento : $(this).data("documento")
        };

        alteraFlag(dependenteDocumento);
    });

    $(".mostrar-mais").on('click', function () {
        if ($(this).find('i').hasClass('fa-plus-square')) {
            $(this).find('i').removeClass('fa-plus-square');
            $(this).find('i').addClass('fa-minus-square');
        } else {
            $(this).find('i').removeClass('fa-minus-square');
            $(this).find('i').addClass('fa-plus-square');
        }
    });
})(jQuery, UrbemSonata, window);
