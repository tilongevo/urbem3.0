(function(){
  'use strict';

  var modalLoad = new UrbemModal();

  function abreModal(title,body){
    modalLoad.hideCloseButton();
    modalLoad.setTitle(title);
    modalLoad.setBody(body);
    modalLoad.open();
  }

  function fechaModal(){
    modalLoad.close();
  }

  var formAction = $('form').prop('action'),
    descricaoField = UrbemSonata.giveMeBackMyField('descricao'),
    fieldsMustBeFilled = $('select.is-filled, input.is-filled'),
    callWhenFieldChanged = function (e) {
      var fieldValue = $(this).val();

      if (fieldValue != "") {
        var countFilledFields = 0;

        fieldsMustBeFilled.each(function () {
          if ($(this).val() != "") {
            countFilledFields++;
          }
        });

        if (countFilledFields === fieldsMustBeFilled.length) {
          var dateTimeAta = moment(UrbemSonata.giveMeBackMyField('dataAta').val()),
            splitedHour = UrbemSonata.giveMeBackMyField('horaAta').val().split(':');

          dateTimeAta = dateTimeAta.set({
            'hour': splitedHour[0],
            'minute': splitedHour[1]
          });

          var queryValues = {
            edital: UrbemSonata.giveMeBackMyField('numEdital').val(),
            data: dateTimeAta.format('YYYY-MM-DD'),
            hora: dateTimeAta.format('HH:mm')
          };

          console.log(queryValues);

          abreModal('Carregando', 'Aguarde, localizando descrição.');
          $.get('/patrimonial/api/search/sugestao/ata/descricao', queryValues)
            .done(function (data) {
              descricaoField.val("");
              descricaoField.val(data.sugestao);
              fechaModal();
            });

          descricaoField.prop('readonly', false);
        }
      } else {
        descricaoField.prop('readonly', true);
      }
    };

  descricaoField.prop('readonly', true);


  fieldsMustBeFilled.on('input', callWhenFieldChanged);
  fieldsMustBeFilled.on('change', callWhenFieldChanged);
  fieldsMustBeFilled.change();

}());
