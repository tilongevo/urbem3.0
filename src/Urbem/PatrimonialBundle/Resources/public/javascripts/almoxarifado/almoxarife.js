(function () {
  'use strict';
  //cgmAlmoxarife
  var fieldCgmAlmoxarife = UrbemSonata.giveMeBackMyField('fkAdministracaoUsuario');
  var fieldFkAlmoxarifadoPermissaoAlmoxarifados = UrbemSonata.giveMeBackMyFieldContainer('fkAlmoxarifadoPermissaoAlmoxarifados');

  if(fieldCgmAlmoxarife.val() == ''){
    fieldFkAlmoxarifadoPermissaoAlmoxarifados.hide();
  }

  fieldCgmAlmoxarife.on('change', function (e) {
    e.stopPropagation();
    if (jQuery(this).val() != '') {
      fieldFkAlmoxarifadoPermissaoAlmoxarifados.show();
    }
  });

  jQuery(document).on('sonata.add_element', function () {
    jQuery('input.padrao-field').on('ifChecked', function (e) {
      var checkedField = jQuery(this);
      jQuery('input.padrao-field').each(function (obj) {
        if (jQuery(this).attr('id') !== checkedField.attr('id')) {
          jQuery(this).iCheck('uncheck');
        }
      });
    });
  });

  jQuery('.sonata-ba-form form').on('submit', function (e) {
    var error = true;
    var errorfkAlmoxarifado = false;

    jQuery(document).find('input.padrao-field').each(function () {
      if (true === jQuery(this).prop('checked')) {
        error = false;
      }
    });

    jQuery(document).find('select.fkAlmoxarifadoAlmoxarifado-field').each(function () {
      if ('' === jQuery(this).val()) {
        errorfkAlmoxarifado = true;
      }
    });

    if(true === error) {
      if(!jQuery('.sonata-ba-form').parent().find('.alert').length) {
        jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> É necessário cadastrar ao menos um almoxarifado padrão. </div>');
      }
      return false;
    }

    if(true === errorfkAlmoxarifado) {
      if(!jQuery('.sonata-ba-form').parent().find('.alert').length) {
        jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Os almoxarifados não podem ficar em branco. </div>');
      }
      return false;
    }

    return true;
  });
}());
