(function ($, urbem, catalogoClassificacao) {
  'use strict';

  urbem.giveMeBackMyField('catalogo').on('change', function () {
    var codCatalogo = $(this).val();

    if (codCatalogo !== undefined) {
      catalogoClassificacao.getNivelCategorias(codCatalogo);
    } else {
      $('.catalogoClassificacaoContainer').hide();
    }
  });

  $(document).ready(function () {
    $('#catalogo-classificao').removeClass('col').removeClass('s12');
  });

})(jQuery, UrbemSonata, CatalogoClassificaoComponent);
