$(function () {
  "use strict";

  var tipoOpcao = $("#" + UrbemSonata.uniqId + "_tipoOpcao option:selected").val();

  var cgm = $("#" + UrbemSonata.uniqId + "_fkSwCgm_autocomplete_input"),
    quota = UrbemSonata.giveMeBackMyField('autorizacao_quota'),
    quotaContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_autorizacao_quota'),
    cgmContainer = $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_autorizacao_numcgm'),
    modeloAutorizacao = $('.row-modelo-autorizacao'),
    modeloLotacao = $('.row-modelo-lotacao'),
    complementoItem = UrbemSonata.giveMeBackMyField('complementoItem'),
    descricaoItem = UrbemSonata.giveMeBackMyField('descricaoItem'),
    descricao = UrbemSonata.giveMeBackMyField('descricao'),
    historico = UrbemSonata.giveMeBackMyField('fkFolhapagamentoConfiguracaoAutorizacaoEmpenhoHistorico'),
    tipo = UrbemSonata.giveMeBackMyField('tipo'),
    local = UrbemSonata.giveMeBackMyField('local'),
    lotacao = UrbemSonata.giveMeBackMyField('lotacao'),
    atributos = UrbemSonata.giveMeBackMyField('atributo'),
    pao = UrbemSonata.giveMeBackMyField('pao'),
    codCadastro = UrbemSonata.giveMeBackMyField('codCadastro'),
    codModulo = UrbemSonata.giveMeBackMyField('codModulo')
  ;

  jQuery('.atributoDinamicoWith').hide();

  local.prop('readonly', true);
  lotacao.prop('readonly', true);
  atributos.prop('readonly', true);

  $(tipo).on("change", function () {
    var opcao = $(this).val();
    if (opcao == 'local') {
      local.select2('readonly', false);
      lotacao.select2('readonly', true);
      atributos.select2('readonly', true);
      local.select2('val', '');
      lotacao.select2('val', '');
      atributos.select2('val', '');
    } else if (opcao == 'lotacao') {
      local.select2('readonly', true);
      lotacao.select2('readonly', false);
      atributos.select2('readonly', true);
      local.select2('val', '');
      lotacao.select2('val', '');
      atributos.select2('val', '');
    } else if (opcao == 'atributo') {
      local.select2('readonly', true);
      lotacao.select2('readonly', true);
      atributos.select2('readonly', false);
      local.select2('val', '');
      lotacao.select2('val', '');
      atributos.select2('val', '');
    } else {
      local.select2('readonly', true);
      lotacao.select2('readonly', true);
      atributos.select2('readonly', true);
      local.select2('val', '');
      lotacao.select2('val', '');
      atributos.select2('val', '');
    }
  });

  showHideForms(tipoOpcao);

  $("#" + UrbemSonata.uniqId + "_tipoOpcao").on("change", function () {
    var opcao = $(this).val();
    showHideForms(opcao);
  });

  function showHideForms(opcao) {
    var inputListarAtributos = $("#" + UrbemSonata.uniqId + "_listaAtributos");

    if (opcao == 1) { // Lotacao
      $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_lotacoes").show();
      $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_locais").hide();
      $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_listaAtributos").hide();
      $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_atributoValor").hide();

      inputListarAtributos.removeAttr("required");

    } else if (opcao == 2) { // Local
      $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_lotacoes").hide();
      $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_locais").show();
      $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_listaAtributos").hide();
      $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_atributoValor").hide();

      inputListarAtributos.removeAttr("required");

    } else if (opcao == 3) { // Atributo
      $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_lotacoes").hide();
      $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_locais").hide();
      $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_listaAtributos").show();
      $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_atributoValor").show();

      inputListarAtributos.attr("required", "required");

    } else {
      $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_lotacoes").hide();
      $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_locais").hide();
      $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_listaAtributos").hide();
      $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_atributoValor").hide();

      inputListarAtributos.removeAttr("required");
    }
  }

  $("#manuais").on("click", function () {
    if ($('#autorizacao-' + cgm.val()).length >= 1) {
      mensagemErro(cgmContainer, 'CGM já informado!');
      return false;
    }

    // if ((quotaTotal == 100) && (promitente.val() == 0)) {
    //   mensagemErro(quotaContainer, 'A soma das quotas já é igual a 100%!');
    //   return false;
    // } else if ((parseInt(quota.val()) > (100 - quotaTotal)) && ((promitente.val() == 0))) {
    //   mensagemErro(quota, 'Quota deve ter valor menor ou igual a ' + (100 - quotaTotal) + '!');
    //   return false;
    // }
    //
    // if ((quotaPromitente == 100) && (promitente.val() == 1)) {
    //   mensagemErro(quotaContainer, 'A soma das quotas já é igual a 100%!');
    //   return false;
    // } else if ((parseInt(quota.val()) > (100 - quotaPromitente)) && ((promitente.val() == 1))) {
    //   mensagemErro(quotaContainer, 'Quota deve ter valor menor ou igual a ' + (100 - quotaPromitente) + '!');
    //   return false;
    // }
    novaLinha();
  });

  function novaLinha() {
    $('.sonata-ba-field-error-messages').remove();
    var nome = cgm.select2('data').label;
    var value = '';
    if (nome != undefined) {
      nome = nome.split(' - ');
      nome = nome[1];
    }

    value = cgm.val() + ';' + descricao.val() + ';' + historico.val() + ';' + descricaoItem.val() + ';' + complementoItem.val();

    var row = modeloAutorizacao.clone();
    row.removeClass('row-modelo-autorizacao');
    row.addClass('row-autorizacao');
    row.attr('id', 'autorizacao-' + cgm.val());
    row.find('.cgm').append(cgm.val());
    row.find('.nome').html(nome);
    row.find('.descricaoItemAutorizacao').html(descricaoItem.val());
    row.find('.imput-autorizacao').attr('value', value);
    row.show();

    $('.empty-row-autorizacao').hide();
    $('#tableAutorizacaoManuais').append(row);

    cgm.select2('val', '');
    descricaoItem.val('');
    complementoItem.val('');
    descricao.val('');
    value.val('');
  }

  $("#manuaisLotacao").on("click", function () {
    // if ($('#autorizacao-' + cgm.val()).length >= 1) {
    //   mensagemErro(cgmContainer, 'CGM já informado!');
    //   return false;
    // }

    // if ((quotaTotal == 100) && (promitente.val() == 0)) {
    //   mensagemErro(quotaContainer, 'A soma das quotas já é igual a 100%!');
    //   return false;
    // } else if ((parseInt(quota.val()) > (100 - quotaTotal)) && ((promitente.val() == 0))) {
    //   mensagemErro(quota, 'Quota deve ter valor menor ou igual a ' + (100 - quotaTotal) + '!');
    //   return false;
    // }
    //
    // if ((quotaPromitente == 100) && (promitente.val() == 1)) {
    //   mensagemErro(quotaContainer, 'A soma das quotas já é igual a 100%!');
    //   return false;
    // } else if ((parseInt(quota.val()) > (100 - quotaPromitente)) && ((promitente.val() == 1))) {
    //   mensagemErro(quotaContainer, 'Quota deve ter valor menor ou igual a ' + (100 - quotaPromitente) + '!');
    //   return false;
    // }
    novaLinhaLotacao();
  });

  function novaLinhaLotacao() {
    $('.sonata-ba-field-error-messages').remove();
    tipo.select2('readonly',true);
    var opt = tipo.val()
    var opt2 = UrbemSonata.giveMeBackMyField(opt);
    var nome = opt2.select2('data').text;
    var value = '';
    if (nome != undefined) {
      nome = nome.split(' - ');
      nome = nome[1];
    }

    var paoLabel = pao.select2('data').text;
    var descLabel = tipo.select2('data').text+':'+nome;
    var row = modeloLotacao.clone();

    value = tipo.val() + ';' + opt2.val() + ';' + pao.val();

    row.removeClass('row-modelo-lotacao');
    row.addClass('row-lotacao');
    row.attr('id', 'lotacao-' + opt2.val());
    row.find('.descricao').append(descLabel);
    row.find('.pao').html(paoLabel);
    row.find('.imput-lotacao').attr('value', value);
    row.show();

    $('.empty-row-lotacao').hide();
    $('#tableLotacaoManuais').append(row);

    if (tipo.val() == 'atributo') {
      opt2.select2('readonly', true);
      $('#manuaisLotacao').hide();
    }
  }

  cgm.on('click', function () {
    $('.sonata-ba-field-error-messages').remove();
  });

  if ($(".row-autorizacao").length > 0) {
    $('.empty-row-autorizacao').hide();
    $('.imput-autorizacao-quota').each(function () {
      if ($(this).val() != '') {
        quotaTotal += parseInt($(this).val());
      }
    })
  }

  $('form').submit(function () {
    if ($(".row-autorizacao").length <= 0) {
      mensagemErro(cgmContainer, 'Deve ser informado ao menos um proprietário!');
      activeTab(2);
      return false;
    }
    if (($(".row-autorizacao").length > 0) && (quotaTotal < 100)) {
      mensagemErro(quotaContainer, 'A soma das quotas dos proprietários deve ser igual a 100%!');
      activeTab(2);
      return false;
    }
    return true;
  });

  $(document).on('click', '.remove', function () {
    $(this).parent().remove();
    if ($(".row-autorizacao").length <= 0) {
      $('.empty-row-autorizacao').show();
    }
  });

  $(document).on('click', '.removeLotacao', function () {
    $(this).parent().remove();
    if ($(".row-lotacao").length <= 0) {
      $('.empty-row-lotacao').show();
      tipo.select2('readonly',false);
      if (tipo.val() == 'atributo') {
        $('#manuaisLotacao').show();
        jQuery('.atributoDinamicoWith').hide();
      }
    }
  });

  function mensagemErro(campo, memsagem) {
    var message = '<div class="help-block sonata-ba-field-error-messages">' +
      '<ul class="list-unstyled">' +
      '<li><i class="fa fa-exclamation-circle"></i> ' + memsagem + '</li>' +
      '</ul></div>';
    campo.after(message);
  }

  function activeTab(identificador) {
    $('a[href^="#tab_' + UrbemSonata.uniqId + '"]').parent().removeClass('active');

    $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').attr('aria-expanded', true);
    $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').find('.has-errors').removeClass('hide');
    $('a[href="#tab_' + UrbemSonata.uniqId + '_' + identificador + '"]').parent().addClass('active');

    $('.tab-pane').removeClass('active in');
    $('#tab_' + UrbemSonata.uniqId + '_' + identificador).addClass('active in');
  }

  atributos.on('change', function () {
    var codAtributo = $(this).val();
    if(codAtributo == '' || codAtributo == '0' || codAtributo == 'Não há opções para o item escolhido.') {
      jQuery('.atributoDinamicoWith').hide();
      return ;
    }
    codAtributo = codAtributo.split('~');
    codAtributo = codAtributo[1];

    var params = {
      tabela: "CoreBundle:FolhaPagamento\\ConfiguracaoEmpenho",
      fkTabela: "getFkFolhapagamentoConfiguracaoEmpenhoLlaAtributos",
      tabelaPai: "CoreBundle:Administracao\\AtributoDinamico",
      codTabelaPai: {
        codModulo: codModulo.val(),
        codCadastro: codCadastro.val(),
        codAtributo: codAtributo
      },
      fkTabelaPaiCollection: "getFkFolhapagamentoConfiguracaoEmpenhoLlaAtributos",
      fkTabelaPai: "getFkFolhapagamentoConfiguracaoEmpenhoAtributos"
    };

    AtributoDinamicoPorCodCadastroModuloCodAtributoComponent.getAtributoDinamicoFields(params);
    jQuery('.atributoDinamicoWith').show();
  });
}());
