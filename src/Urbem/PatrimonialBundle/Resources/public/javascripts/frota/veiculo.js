(function(){
    'use strict';

    var frotaModelo = UrbemSonata.giveMeBackMyField('fkFrotaModelo');
    var frotaMarca = UrbemSonata.giveMeBackMyField('fkFrotaMarca');

    if (! UrbemSonata.checkModule('veiculo')) {
        return;
    }

    var modalLoad = new UrbemModal();
    modalLoad.setTitle('Carregando...');

    $("#" + UrbemSonata.uniqId + "_fkFrotaTipoVeiculo").on("change", function() {
        abreModal('Carregando','Aguarde, processando dados');
        var id = $(this).val();
        $.ajax({
            url: "/patrimonial/frota/veiculo/consultar-restricoes-tipo-veiculo/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                if(data.placa) {
                    $('#' + UrbemSonata.uniqId + '_placa').attr('required', true);
                    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_placa label').html(
                        $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_placa label').html().replace('*', '')
                    );
                    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_placa label').html(
                        $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_placa label').html() + '*'
                    );
                } else {
                    $('#' + UrbemSonata.uniqId + '_placa').attr('required', false);
                    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_placa label').html(
                        $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_placa label').html().replace('*', '')
                    );
                }

                if(data.codPrefixo) {
                    $('#' + UrbemSonata.uniqId + '_prefixo').attr('required', true);
                    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_prefixo label').html(
                        $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_prefixo label').html().replace('*', '')
                    );
                    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_prefixo label').html(
                        $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_prefixo label').html() + '*'
                    );
                } else {
                    $('#' + UrbemSonata.uniqId + '_prefixo').attr('required', false);
                    $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_prefixo label').html(
                        $('#sonata-ba-field-container-' + UrbemSonata.uniqId + '_prefixo label').html().replace('*', '')
                    );
                }

                fechaModal();
            }
        });
    });

    frotaMarca.on("change", function() {
        var id = $(this).val();

        if (!id) {
            frotaModelo.empty();
            return;
        }
        frotaModelo.empty();

        abreModal('Carregando','Aguarde, pesquisando modelos');

        $.ajax({
            url: "/patrimonial/frota/veiculo/consultar-marca-modelos/" + id,
            method: "GET",
            dataType: "json",
            success: function (data) {
                frotaModelo.empty();
                UrbemSonata.populateSelect(frotaModelo, data, {
                    label: 'label',
                    value: 'id'
                }, frotaModelo.val());

                fechaModal();
            }
        });
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
}());
