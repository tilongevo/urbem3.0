(function(){
    'use strict';

    var fotoField = UrbemSonata.giveMeBackMyField('foto');
    var descricaoField = UrbemSonata.giveMeBackMyField('descricao');

    $('input[type="checkbox"]').on('ifChecked', function() {
        jQuery('.fotoInclusao').hide();
        fotoField.val('');
        descricaoField.val('');
        descricaoField.attr('required', false);
    });

    $('input[type="checkbox"]').on('ifUnchecked', function() {
        jQuery('.fotoInclusao').show();
        descricaoField.attr('required', true);
    });

}());
