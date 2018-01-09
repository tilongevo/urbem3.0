$(document).ready(function () {
    'use strict';

    var natureza = $('.js-natureza');
    var genero = $('.js-genero');

    $(".js-natureza").on("change", function () {
        getGenero($(this).val(),$(".js-genero"));
    });

    if(natureza.val() === "") {
        genero.empty();
        return;
    }

    function getGenero(naturezaVal,generoObj) {
        var selectedOption = generoObj.val();
        $.ajax({
            method: 'GET',
            url: '/tributario/cadastro-monetario/genero/index?natureza=' + naturezaVal,
            dataType: 'json',
            beforeSend: function () {
                generoObj.find('option').each( function (index, option) {
                    option.remove();
                });

               genero.append($('<option style="display:none" selected></option>').text('Carregando...'));
               $(".js-genero").attr("disabled",true);
               genero.trigger('change');
            },
            success: function (data) {
                genero.empty();
                $.each(data, function (index, item) {
                    genero.append($('<option style="display:none"></option>').attr('value', item.cod_genero).text(item.nom_genero));
                });

                generoObj.select2("val","");
                generoObj.select2("val", selectedOption);
                if(naturezaVal && !natureza.prop("disabled")) {
                    $(".js-genero").attr("disabled",false);
                }
            }
        });
    }

    $(".js-natureza").trigger("change");
}());



