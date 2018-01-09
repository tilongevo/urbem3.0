(function(){
    'use strict';

    var fileField = $('input[type="file"]');

    fileField.each(function (index, file) {
        var data = file.defaultValue.split("~");
        var codItem = data[0];
        var descricaoItem = data[1];
        var id = file.id;

        var field = 'Item sem foto';
        if (codItem) {
             field = '<img src="/patrimonial/almoxarifado/catalogo-item/foto/' + codItem + '" alt="'+ descricaoItem +'" class="little-box" style="width: 200px !important; padding-left: 0 !important; padding-right: 0 !important;">';
        }

        $("#"+id).replaceWith(field);
    });
}());
