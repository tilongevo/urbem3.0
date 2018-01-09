(function () {
  'use strict';

    var fieldCodLicitacao = $('#' + UrbemSonata.uniqId + '_codLicitacao'),
      fieldParticipantes = $('#' + UrbemSonata.uniqId + '_participantes'),
      fieldExercicio = $('#' + UrbemSonata.uniqId + '_exercicio'),
      fieldCodModalidade = $('#' + UrbemSonata.uniqId + '_codModalidade'),
      fieldCodEntidade = $('#' + UrbemSonata.uniqId + '_codEntidade'),
      loadTable = function () {
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, carregando itens da solicitação</h4>');
        $('.manutencao-items .box-body').html('');
        $.get('/patrimonial/api/search/itens/fornecedor', {
          cod_licitacao: fieldCodLicitacao.val(),
          exercicio: fieldExercicio.val(),
          cod_modalidade: fieldCodModalidade.val(),
          cod_entidade: fieldCodEntidade.val(),
          participante: fieldParticipantes.val(),
          mode: 'table'
        })
          .success(function (data) {
            $('.manutencao-items .box-body').html(data);
            fechaModal();
          });
      };

  fieldParticipantes.on('change', function (e) {
    e.stopPropagation();
    if(fieldParticipantes.val() != '') {
      loadTable();
    }
  });

  // Validações
  jQuery('.sonata-ba-form form').on('submit', function () {
    var error = false;
    var mensagem = '';
    jQuery('.sonata-ba-field-error-messages').remove();
    jQuery('.sonata-ba-form').parent().find('.alert.alert-danger.alert-dismissable').remove();

    jQuery('input[name="codItem[]"]').each(function () {
      var data = $('input[name="item_data['+$(this).val()+']"');
      var marca = $('select[name="item_marca['+$(this).val()+']"');
      var vlUnit = $('input[name="item_vlUnit['+$(this).val()+']"');
      var vlReferencia = $('input[name="item_vlReferencia['+$(this).val()+']"');

      // Validação: Se ao menos um item de cada linha for preenchido, todos devem ser preenchidos
      if(data.val() != "" || marca.val() != "" || vlUnit.val() != "") {
        mensagem = 'Há campos obrigatórios vazios, por favor, verifique.';
        if(data.val() == "") {
          error = true;
          data.parent().parent().removeClass('sonata-ba-field-error');
          if (!data.parent().parent().hasClass('sonata-ba-field-error')) {
            data.parent().parent().addClass('sonata-ba-field-error');
            data.parent().parent().append('<div class="help-block sonata-ba-field-error-messages" style="position: relative;"> <ul class="list-unstyled"> <li><i class="fa fa-exclamation-circle"></i> Campo deve ser preenchido.</li> </ul> </div>');
          }
        }

        if(marca.val() == "") {
          error = true;
          marca.parent().removeClass('sonata-ba-field-error');
          if (!marca.parent().hasClass('sonata-ba-field-error')) {
            marca.parent().addClass('sonata-ba-field-error');
            marca.parent().append('<div class="help-block sonata-ba-field-error-messages" style="position: relative;"> <ul class="list-unstyled"> <li><i class="fa fa-exclamation-circle"></i> Campo obrigatório vazio.</li> </ul> </div>');
          }
        }

        if(vlUnit.val() == "") {
          error = true;
          vlUnit.parent().removeClass('sonata-ba-field-error');
          if (!vlUnit.parent().hasClass('sonata-ba-field-error')) {
            vlUnit.parent().addClass('sonata-ba-field-error');
            vlUnit.parent().append('<div class="help-block sonata-ba-field-error-messages" style="position: relative;"> <ul class="list-unstyled"> <li><i class="fa fa-exclamation-circle"></i> Campo obrigatório vazio.</li> </ul> </div>');
          }
        }
      }

      // Validação: vlUnit não pode ser menor que o vlReferencia
      if(vlUnit.val() != "") {
        var valVlUnit = parseFloat( vlUnit.val().replace(/\./g, '').replace(/\,/g, '.') ).toFixed(2);
        mensagem = 'O valor unitário deve ser maior que o valor de referência do Item.';
        vlUnit.parent().removeClass('sonata-ba-field-error');
        if((vlReferencia.val() - valVlUnit) > 0) {
          error = true;
          vlUnit.parent().addClass('sonata-ba-field-error');
          vlUnit.parent().append('<div class="help-block sonata-ba-field-error-messages" style="position: relative;"> <ul class="list-unstyled"> <li><i class="fa fa-exclamation-circle"></i> Valor menor que o valor de Referência.</li> </ul> </div>');
        }
      }
    });
    if(error) {
      jQuery('.sonata-ba-form').parent().prepend('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> ' + mensagem + ' </div>');
      return false;
    }
  });
}());
