(function () {
  'use strict';

  var varJsCodClassificacao;

  var classificacaoField = UrbemSonata.giveMeBackMyField('classificacao')
    , assuntoField = UrbemSonata.giveMeBackMyField('assunto')
    , processoField =  UrbemSonata.giveMeBackMyField('processo')
  ;

  classificacaoField.on('change', function (e) {
    varJsCodClassificacao = jQuery(this).val();

    var modalLoading = jQuery.urbemModal();

    jQuery.ajax({
      method: 'GET',
      url: '/core/filter/swassunto/search/classificacao/' + varJsCodClassificacao,
      dataType: 'json',
      beforeSend: function (xhr) {
        modalLoading
          .disableBackdrop()
          .setTitle('Aguarde...')
          .setBody('Buscando assuntos.')
          .open();
      },
      success: function (data) {
        data = jQuery.parseJSON(data);

        if ('object' == typeof data
            || 'array' == typeof data) {
          jQuery.each(data, function (index, item) {
            data[index]["selectOptionValue"] = [item.codAssunto, item.codClassificacao].join('~');

            var formattedCodAssunto =
              "000".substring(0, "000".length - item.codAssunto.toString().length) + item.codAssunto.toString();

            data[index]["selectOptionLabel"] = [formattedCodAssunto, item.nomAssunto].join(' - ');
          });
        }

        UrbemSonata.populateSelect(assuntoField, data, {
          value: "selectOptionValue",
          label: "selectOptionLabel"
        });

        assuntoField.prop('disabled', false);

        modalLoading.close();
      }
    });
  });

  assuntoField.on('change', function (e) {
    window.varJsCodAssunto = jQuery(this).val();
  });
}());
