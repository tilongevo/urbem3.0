(function(){
    'use strict';

    if (! UrbemSonata.checkModule('funcao')) {
        return;
    }

    $("#" + UrbemSonata.uniqId + "_nomFuncao").keyup(function() {
        var valor = $( this ).val().replace(/[^a-z0-9.\_]+/gi,'');
    		$( this ).val(valor);
	  });

    $("#" + UrbemSonata.uniqId + "_corpoPl").keyup(function() {
        var valor = $( this ).val();
        var newValor = valor;
        if(valor.toLowerCase().indexOf('drop') >= 0) {
            var cut = valor.slice(valor.toLowerCase().indexOf('drop'),valor.toLowerCase().indexOf('drop') + 4);
            newValor = valor.replace(cut, '');
        }
        if(valor.toLowerCase().indexOf('truncate') >= 0) {
            var cut = valor.slice(valor.toLowerCase().indexOf('truncate'),valor.toLowerCase().indexOf('truncate') + 8);
            newValor = valor.replace(cut, '');
        }
        if(valor.toLowerCase().indexOf('replace') >= 0) {
          var cut = valor.slice(valor.toLowerCase().indexOf('replace'),valor.toLowerCase().indexOf('replace') + 7);
            newValor = valor.replace(cut, '');
        }
    		$( this ).val(newValor);
	  });

    var filtermodulo = $("#filter_codModulo_value").val();
    if (filtermodulo == "") {
      $("#filter_codBiblioteca_value").empty().select2("val", "");
    }

    $("#filter_codModulo_value").on("change", function() {
        var id = $(this).val();
        $.ajax({
            url: "/administrativo/administracao/gerador-calculo/funcao/consultar-biblioteca/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#filter_codBiblioteca_value")
                    .empty()
                    .select2("val", "");

                $.each(data, function (index, value) {
                    $("#filter_codBiblioteca_value")
                        .append("<option value=" + value + ">" + index + "</option>");
                });
            }
        });
    });

}());
