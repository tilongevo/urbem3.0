(function(){
    'use strict';

    if (! UrbemSonata.checkModule('bem')) {
      return;
    }

    // var natureza = $('#' + UrbemSonata.uniqId + '_codNatureza').find(":selected").val();
    // var grupo = $('#' + UrbemSonata.uniqId + '_codGrupo').find(":selected").val();

    $("#" + UrbemSonata.uniqId + "_codGrupo").prop("readonly", true);
    $("#" + UrbemSonata.uniqId + "_codEspecie").prop("readonly", true);
    $('#' + UrbemSonata.uniqId + '_classificacao').val($('#' + UrbemSonata.uniqId + '_classificacao').val());

    $("#" + UrbemSonata.uniqId + "_codNatureza").on("change", function() {
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando grupos</h4>');
        $("#" + UrbemSonata.uniqId + "_codGrupo").empty();
        $("#" + UrbemSonata.uniqId + "_codGrupo").prop("readonly", true);
        $('select').select2();
        var id = $(this).val();
        $.ajax({
            url: "/patrimonial/patrimonio/manutencao/consultar-grupo/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_codGrupo")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                $.each(data, function (index, value) {
                    $("#" + UrbemSonata.uniqId + "_codGrupo")
                        .append("<option value=" + index + ">" + value + "</option>");
                });
                $("#" + UrbemSonata.uniqId + "_codGrupo").prop("readonly", false);
                $('select').select2();
                fechaModal();
            }
        });
        if ($(this).find(":selected").val() != undefined) {
            $('#' + UrbemSonata.uniqId + '_classificacao').val($(this).find(":selected").val());
        }
    });

    $("#" + UrbemSonata.uniqId + "_codGrupo").on("change", function() {
        $("#" + UrbemSonata.uniqId + "_codEspecie").empty();
        $("#" + UrbemSonata.uniqId + "_codEspecie").prop("readonly", true);
        $('select').select2();
        abreModal('Carregando','Aguarde, pesquisando espécies');
        var id = $(this).val();
        var natureza = $('#' + UrbemSonata.uniqId + '_codNatureza').find(":selected").val();
        $.ajax({
            url: "/patrimonial/patrimonio/manutencao/consultar-especie/" + id + "/" + natureza,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#" + UrbemSonata.uniqId + "_codEspecie")
                    .empty()
                    .append("<option value=\"\">Selecione</option>");

                $.each(data, function (index, value) {
                    $("#" + UrbemSonata.uniqId + "_codEspecie")
                        .append("<option value=" + index + ">" + value + "</option>");
                });
                $("#" + UrbemSonata.uniqId + "_codEspecie").prop("readonly", false);
                $('select').select2();
                fechaModal();
            }
        });

      var natureza = $('#' + UrbemSonata.uniqId + '_codNatureza').find(":selected").val();
      if (natureza != undefined && $(this).find(":selected").val() != undefined) {
            $('#' + UrbemSonata.uniqId + '_classificacao').val(natureza + '.' + $(this).find(":selected").val());
        }
    });

    $("#" + UrbemSonata.uniqId + "_codEspecie").on("change", function() {
        var id = $(this).val();

      var natureza = $('#' + UrbemSonata.uniqId + '_codNatureza').find(":selected").val();
      var grupo = $('#' + UrbemSonata.uniqId + '_codGrupo').find(":selected").val();
      if (natureza != undefined && grupo != undefined && $(this).find(":selected").val() != undefined) {
          $('#' + UrbemSonata.uniqId + '_classificacao').val(natureza + '.' + grupo + '.' + $(this).find(":selected").val());
      }
    });


    var unique_id = $('meta[name="uniqid"]').attr('content'),
        identificacao = $('#' + unique_id + '_identificacao'),
        assegurado = $('#' + unique_id + '_assegurado'),
        cbLote = $('#' + unique_id + '_cbLote'),
        depreciavel = $('#' + unique_id + '_depreciavel'),
        depreciacaoAcelerada = $('#' + unique_id + '_depreciacaoAcelerada');

    if (identificacao.is(':checked')) {
        UrbemSonata.sonataFieldContainerShow('_numPlaca');
    } else {
        UrbemSonata.sonataFieldContainerHide('_numPlaca');
    }

    identificacao.on('ifChecked', function() {
        UrbemSonata.sonataFieldContainerShow('_numPlaca');
    });

    identificacao.on('ifUnchecked', function() {
        UrbemSonata.sonataFieldContainerHide('_numPlaca');
    });

    if (assegurado.is(':checked')) {
        UrbemSonata.sonataFieldContainerShow('_apolicesCollection');
    } else {
        UrbemSonata.sonataFieldContainerHide('_apolicesCollection');
    }

    assegurado.on('ifChecked', function() {
        UrbemSonata.sonataFieldContainerShow('_apolicesCollection');
    });

    assegurado.on('ifUnchecked', function() {
        UrbemSonata.sonataFieldContainerHide('_apolicesCollection');
    });

    if (cbLote.is(':checked')) {
        UrbemSonata.sonataFieldContainerShow('_qtdLote');
    } else {
        UrbemSonata.sonataFieldContainerHide('_qtdLote');
    }

    cbLote.on('ifChecked', function() {
        UrbemSonata.sonataFieldContainerShow('_qtdLote');
    });

    cbLote.on('ifUnchecked', function() {
        UrbemSonata.sonataFieldContainerHide('_qtdLote');
    });


    if (depreciavel.is(':checked')) {
        UrbemSonata.sonataFieldContainerShow('_quotaDepreciacaoAnual');
        UrbemSonata.sonataFieldContainerShow('_contaContabil');
        UrbemSonata.sonataFieldContainerShow('_depreciacaoAcelerada');
    } else {
        UrbemSonata.sonataFieldContainerHide('_quotaDepreciacaoAnual');
        UrbemSonata.sonataFieldContainerHide('_contaContabil');
        UrbemSonata.sonataFieldContainerHide('_depreciacaoAcelerada');
    }

    depreciavel.on('ifChecked', function() {
        UrbemSonata.sonataFieldContainerShow('_quotaDepreciacaoAnual');
        UrbemSonata.sonataFieldContainerShow('_contaContabil');
        UrbemSonata.sonataFieldContainerShow('_depreciacaoAcelerada');
    });

    depreciavel.on('ifUnchecked', function() {
        UrbemSonata.sonataFieldContainerHide('_quotaDepreciacaoAnual');
        UrbemSonata.sonataFieldContainerHide('_contaContabil');
        UrbemSonata.sonataFieldContainerHide('_depreciacaoAcelerada');
    });


    if (depreciacaoAcelerada.is(':checked')) {
        UrbemSonata.sonataFieldContainerShow('_quotaDepreciacaoAnualAcelerada');
    } else {
        UrbemSonata.sonataFieldContainerHide('_quotaDepreciacaoAnualAcelerada');
    }

    depreciacaoAcelerada.on('ifChecked', function() {
        UrbemSonata.sonataFieldContainerShow('_quotaDepreciacaoAnualAcelerada');
    });

    depreciacaoAcelerada.on('ifUnchecked', function() {
        UrbemSonata.sonataFieldContainerHide('_quotaDepreciacaoAnualAcelerada');
    });

  $("#" + UrbemSonata.uniqId + "_orgao").on("change", function () {
    var orgao;
    var codOrganograma =  $("#" + UrbemSonata.uniqId + "_codOrganograma").val();
    var codOrgao = $(this).val();

    if (codOrgao == 0) {
      $("#" + UrbemSonata.uniqId + "_secretarias").empty();
      $("#" + UrbemSonata.uniqId + "_secretarias").prop("disabled", true);
      $("#" + UrbemSonata.uniqId + "_unidades").empty();
      $("#" + UrbemSonata.uniqId + "_unidades").prop("disabled", true);
      $('select').select2();
      return;
    }
    abreModal('Carregando','Aguarde, pesquisando secretarias');
    consultaOrgao(codOrganograma,codOrgao,1);
  });

  $("#" + UrbemSonata.uniqId + "_secretarias").on("change", function () {
    var orgao;
    var codOrganograma =  $("#" + UrbemSonata.uniqId + "_codOrganograma").val();
    var codOrgao = $(this).val();
    if (codOrgao == 0) {
      $("#" + UrbemSonata.uniqId + "_secretarias").empty();
      $("#" + UrbemSonata.uniqId + "_secretarias").prop("disabled", true);
      $("#" + UrbemSonata.uniqId + "_unidades").empty();
      $("#" + UrbemSonata.uniqId + "_unidades").prop("disabled", true);
      $('select').select2();
      return;
    }
    abreModal('Carregando','Aguarde, pesquisando unidades');
    consultaOrgao(codOrganograma,codOrgao,2);
  });

  $("#" + UrbemSonata.uniqId + "_unidades").on("change", function () {
    var orgao;
    var codOrganograma =  $("#" + UrbemSonata.uniqId + "_codOrganograma").val();
    var codOrgao = $(this).val();
    if (codOrgao == 0) {
      return;
    }
    abreModal('Carregando','Aguarde, processando unidade');
    consultaOrgao(codOrganograma,codOrgao,3);
  });

  function consultaOrgao(codOrganograma,codOrgao,nivel){
    $.ajax({
      url: "/api-search-fn-consulta-orgao/find-consulta-orgao/?codOrganograma=" + codOrganograma + "&codOrgao=" + codOrgao,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#" + UrbemSonata.uniqId + "_classificacaoHist").val(data);
        if(nivel == '1') {
          findSecretaria(codOrganograma, codOrgao);
        } else if(nivel == '2') {
          findUnidades(codOrganograma, codOrgao);
        } else {
          fechaModal();
        }
      }
    });
  }

  function findUnidades(codOrganograma,codOrgao){
    var orgao;
    orgao = $("#" + UrbemSonata.uniqId + "_classificacaoHist").val();
    $.ajax({
      url: "/api-search-unidades/find-unidades-by-orgao/?codOrganograma=" + codOrganograma + "&codOrgao=" + orgao,
      method: "GET",
      dataType: "json",
      success: function (data) {
        $("#" + UrbemSonata.uniqId + "_unidades")
          .empty()
          .append("<option value='0'>Selecione...</option>");
        $.each(data, function (index, value) {
          $("#" + UrbemSonata.uniqId + "_unidades")
            .append("<option value='" + value.cod_orgao + "'>" + value.descricao + "</option>");
        });
        $("#" + UrbemSonata.uniqId + "_unidades").prop("disabled", false);
        $("#" + UrbemSonata.uniqId + "_unidades").select2();
        fechaModal();
      }
    });
  }

  function findSecretaria(codOrganograma,codOrgao){
    var orgao;
    orgao = $("#" + UrbemSonata.uniqId + "_classificacaoHist").val();
      $.ajax({
        url: "/api-search-secretaria-unidades/find-secretaria-unidades-by-orgao/?codOrganograma=" + codOrganograma + "&codOrgao=" + orgao,
        method: "GET",
        dataType: "json",
        success: function (data) {
          $("#" + UrbemSonata.uniqId + "_secretarias")
            .empty()
            .append("<option value='0'>Selecione...</option>");
          $.each(data, function (index, value) {
            $("#" + UrbemSonata.uniqId + "_secretarias")
              .append("<option value='" + value.cod_orgao + "'>" + value.descricao + "</option>");
          });
          $("#" + UrbemSonata.uniqId + "_secretarias").prop("disabled", false);
          $("#" + UrbemSonata.uniqId + "_secretarias").select2();
          fechaModal();
        }
      });
  }

  $("#" + UrbemSonata.uniqId + "_unidade").prop("readonly", true);
  $("#" + UrbemSonata.uniqId + "_orgaoOrg").on("change", function() {
    abreModal('Carregando','Aguarde, pesquisando unidades');
    $("#" + UrbemSonata.uniqId + "_unidade").empty();
    $("#" + UrbemSonata.uniqId + "_unidade").prop("readonly", true);
    $('select').select2();
    var codOrgao = $(this).val();
    $.ajax({
      url: "/financeiro/plano-plurianual/acao/consultar-unidades",
      method: "POST",
      data: {codOrgao: codOrgao},
      dataType: "json",
      success: function (data) {
        $("#" + UrbemSonata.uniqId + "_unidade")
          .empty()
          .append("<option value=\"\">Selecione</option>");

        $.each(data, function (index, value) {
          $("#" + UrbemSonata.uniqId + "_unidade")
            .append("<option value=" + index + ">" + value + "</option>");
        });
        $("#" + UrbemSonata.uniqId + "_unidade").prop("readonly", false);
        $('select').select2();
        fechaModal();
      }
    });
  });

  // Atributo Dinâmico
  // Carrega os dados do atributo, caso haja dados (edição)
  $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_atributosDinamicos").hide();
  $("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_atributosDinamicos").after('<div id="atributos-dinamicos" style="margin-bottom: 30px" class="col s12"><span>Selecione a espécie.</span></div>');
  var classificacao = $("#" + UrbemSonata.uniqId + "_classificacao").val();
  if (classificacao !== "" && classificacao != undefined && classificacao !== "0.0.0") {
    classificacao = classificacao.split('.');
    var codNatureza = classificacao[0];
    var codGrupo = classificacao[1];
    var codEspecie = classificacao[2];
    var bem = $("#" + UrbemSonata.uniqId + "_codBem").val();

    abreModal('Carregando','Aguarde, processando atributos');
    $("#atributos-dinamicos").html("");
    $.ajax({
      url: "/administrativo/administracao/atributo/consultar-campos/",
      method: "POST",
      data: {
        // Entity referênte a tela onde o Atributo está sendo consumido
        tabela: "CoreBundle:Patrimonio\\Bem",
        // Get entity de relacionamento do atributo
        fkTabela: "getFkPatrimonioBemAtributoEspecies",
        // PK/CK da entity referênte a tela
        codTabela: bem,
        // Entity pai do atributo
        tabelaPai: 'CoreBundle:Patrimonio\\Especie',
        // PK/CK da entity pai do atributo
        codTabelaPai: {'codEspecie' : codEspecie, 'codGrupo' : codGrupo, 'codNatureza' : codNatureza},
        // Get collection do atributo
        fkTabelaPaiCollection: "getFkPatrimonioEspecieAtributos",
        // Get entity do atributo
        fkTabelaPai: "getFkPatrimonioEspecieAtributo"
      },
      dataType: "json",
      success: function (data) {
        $.each(data, function (index, value) {
          if(value) {
            $("#atributos-dinamicos").append(value);
          } else {
            $("#atributos-dinamicos").append('<span>Não existem atributos para essa espécie.</span>');
          }
        });
        fechaModal();
      }
    });
  }

  // Carrega os dados do atributo
  $("#" + UrbemSonata.uniqId + "_codEspecie").on("change", function() {
    var classificacao = $("#" + UrbemSonata.uniqId + "_classificacao").val();

    if(!classificacao) {
      return;
    }

    classificacao = classificacao.split('.');
    var codNatureza = classificacao[0];
    var codGrupo = classificacao[1];
    var codEspecie = classificacao[2];

    abreModal('Carregando','Aguarde, processando atributos');
    $("#atributos-dinamicos").html("");
    $.ajax({
      url: "/administrativo/administracao/atributo/consultar-campos/",
      method: "POST",
      data: {
        // Entity referênte a tela onde o Atributo está sendo consumido
        tabela: "CoreBundle:Patrimonio\\Bem",
        // Get entity de relacionamento do atributo
        fkTabela: "getFkPatrimonioBemAtributoEspecies",
        // Entity pai do atributo
        tabelaPai: 'CoreBundle:Patrimonio\\Especie',
        // PK/CK da entity pai do atributo
        codTabelaPai: {'codEspecie' : codEspecie, 'codGrupo' : codGrupo, 'codNatureza' : codNatureza},
        // Get collection do atributo
        fkTabelaPaiCollection: "getFkPatrimonioEspecieAtributos",
        // Get entity do atributo
        fkTabelaPai: "getFkPatrimonioEspecieAtributo"
      },
      dataType: "json",
      success: function (data) {
        $.each(data, function (index, value) {
          if(value) {
            $("#atributos-dinamicos").append(value);
          } else {
            $("#atributos-dinamicos").append('<span>Não existem atributos para essa espécie.</span>');
          }
        });
        fechaModal();
      }
    });
  });
}());
