$(function () {
    "use strict";
    if (! UrbemSonata.checkModule('entidade-intermediadora') && ! UrbemSonata.checkModule('instituicao-ensino')) {
        return;
    }
    var unique_id = $('meta[name="uniqid"]').attr("content");

    var field = UrbemSonata.giveMeBackMyField('fkSwCgmPessoaJuridica'),
        instituicaoEnsino = UrbemSonata.giveMeBackMyField('instituicaoEnsino'),
        entidadeIntermediadora = UrbemSonata.giveMeBackMyField('entidadeIntermediadora');

    var buscaDados = function () {
        abreModal('Carregando', 'Aguarde, pesquisando dados da instituição de ensino ');
        $.ajax({
            url: '/recursos-humanos/estagio/entidade-intermediadora/consultar-dados-entidade/' + field.val(),
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#' + unique_id + '_cnpj').val(data['cnpj']);
                $('#' + unique_id + '_endereco').val(data['endereco']);
                $('#' + unique_id + '_bairro').val(data['bairro']);
                $('#' + unique_id + '_cidade').val(data['municipio']);
                $('#' + unique_id + '_telefone').val(data['telefone']);
                $('#' + unique_id + '_email').val(data['email']);
                fechaModal();
            }
        });
    }

    if(field && field.val()){
        buscaDados();
    }

    if (entidadeIntermediadora && entidadeIntermediadora.val()) {
        field.select2("readonly", true);
    }

    $('#' + unique_id + '_fkSwCgmPessoaJuridica_autocomplete_input').on('change', function () {
        buscaDados();
    });

  var populateSelect = function (select, data, prop) {
    var firstOption = select.find('option:first-child');
    select.empty().append(firstOption);

    $.each(data, function (index, item) {
      var option = $('<option>', {value: item[prop.value], text: item[prop.text]});
      select.append(option);
    });

    $('select').material_select();
  };

  $('#estagiario_estagio_codGrau').on('change', function() {
    var selectedOptionGrau = $(this).find('option:selected'),
      selectedOptionInstituicao = $('select#estagiario_estagio_cgmInstituicaoEnsino option:selected'),
      selectTarget = $('#estagiario_estagio_codCurso');

    $.ajax({
      url: '/recursos-humanos/estagio/estagiario/consultar-curso',
      method: 'POST',
      data: {
        grau: selectedOptionGrau.val(),
        instituicao_ensino: selectedOptionInstituicao.val()
      },
      dataType: 'json',
      success: function (data) {
        populateSelect(selectTarget, data, {value: 'cod_curso', text: 'nom_curso'});
      }
    });
  });


});
