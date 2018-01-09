(function(){
    'use strict';
    
    function getClassificacaoAssentamento( source, target ) {
        abreModal('Carregando','Aguarde, pesquisando classificações de assentamento...');
        $.ajax({
            url: '/recursos-humanos/pessoal/assentamento/gerar-assentamento/get-classificacao-assentamento',
            method: 'POST',
            data: {
                codContrato: source.val()
            },
            dataType: "json",
            success: function (data) {
                target.empty().append("<option value=\"\">Selecione</option>");

                for (var i in data) {
                    target.append("<option value=" + i + ">" + data[i] + "</option>");
                }
                
                target.val('').trigger("change");
                fechaModal();
            }
        });
    }
    
    function getAssentamentoByClassificacao( source, target ) {
        if (source.val() != '') {
            abreModal('Carregando','Aguarde, pesquisando assentamentos...');
            $.ajax({
                url: '/recursos-humanos/pessoal/assentamento/gerar-assentamento/get-assentamento-classificacao',
                method: 'POST',
                data: {
                    codClassificacao: source.val()
                },
                dataType: "json",
                success: function (data) {
                    target.empty().append("<option value=\"\">Selecione</option>");
                    
                    for (var i in data) {
                      target.append("<option value=" + i + ">" + data[i] + "</option>");
                    }
                    
                    target.val('').trigger("change");
                    fechaModal();
                }
            });
        }
    }

  function getAssentamentoByCodClassificacao( source, target ) {
    if (source.val() != '') {
      abreModal('Carregando','Aguarde, pesquisando assentamentos...');
      $.ajax({
        url: '/recursos-humanos/pessoal/assentamento/gerar-assentamento/get-assentamento-by-codclassificacao',
        method: 'POST',
        data: {
          codClassificacao: source.val()
        },
        dataType: "json",
        success: function (data) {
          target.empty().append("<option value=\"\">Selecione</option>");

          for (var i in data) {
            target.append("<option value=" + i + ">" + data[i] + "</option>");
          }

          target.val('').trigger("change");
          fechaModal();
        }
      });
    }
  }
    
    function getAssentamentoByClassificacaoMatricula( source, target ) {
        if (source.val() != '') {
            abreModal('Carregando','Aguarde, pesquisando assentamentos...');
            $.ajax({
                url: '/recursos-humanos/pessoal/assentamento/gerar-assentamento/get-assentamento-classificacao-matricula',
                method: 'POST',
                data: {
                    codContrato: $("#" + UrbemSonata.uniqId + "_codContrato_autocomplete_input").val(),
                    codClassificacao: source.val()
                },
                dataType: "json",
                success: function (data) {
                    target.empty().append("<option value=\"\">Selecione</option>");
                    
                    for (var i in data) {
                      target.append("<option value=" + i + ">" + data[i] + "</option>");
                    }
                    
                    target.val('').trigger("change");
                    fechaModal();
                }
            });
        }
    }
    
    function diffPeriodo() {
        var periodoInicial = moment($("#" + UrbemSonata.uniqId + "_periodoInicial").val(), "DD/MM/YYYY");
        var periodoFinal = moment($("#" + UrbemSonata.uniqId + "_periodoFinal").val(), "DD/MM/YYYY");
        
        $("#" + UrbemSonata.uniqId + "_inQuantidadeDias").val(periodoInicial.diff(periodoFinal, 'days') * -1)
    }
    
    $("#" + UrbemSonata.uniqId + "_codContrato_autocomplete_input").on("change", function() {
        getClassificacaoAssentamento($(this), $("#" + UrbemSonata.uniqId + "_codClassificacao"));
    });
    
    $("#" + UrbemSonata.uniqId + "_codClassificacao").on("change", function() {
        getAssentamentoByClassificacaoMatricula($(this), $("#" + UrbemSonata.uniqId + "_codAssentamento"));
    });
    
    $("#filter_codClassificacao_value").on("change", function() {
        getAssentamentoByClassificacao($(this), $("#filter_codAssentamento_value"));
    });
    
    window.varJsCodTipoNorma = $("#" + UrbemSonata.uniqId + "_codTipoNorma").val();
    $("#" + UrbemSonata.uniqId + "_codTipoNorma").on("change", function() {
        window.varJsCodTipoNorma = $(this).val();
    });
    
    $("#" + UrbemSonata.uniqId + "_periodoInicial").on("blur", function() {
        var periodoInicial = $(this).val();
        if (periodoInicial != '') {
            var m = moment(periodoInicial, "DD/MM/YYYY");
            var periodoFinal = m.add(parseInt($("#" + UrbemSonata.uniqId + "_inQuantidadeDias").val()), 'days');
            $("#dp_" + UrbemSonata.uniqId + "_periodoFinal").data("DateTimePicker").setValue(periodoFinal.format("DD/MM/YYYY"));
        }
    });

    $("#" + UrbemSonata.uniqId + "_codClassificacaoAssentamento").on("change", function() {
      getAssentamentoByCodClassificacao($(this), $("#" + UrbemSonata.uniqId + "_fkPessoalAssentamentoAssentamento"));
    });
    
    diffPeriodo();
    $("#" + UrbemSonata.uniqId + "_periodoFinal").on("blur", function() {
        diffPeriodo();
    });
    
    UrbemSonata.sonataFieldFilterHide("dia");
    UrbemSonata.sonataFieldFilterHide("ano");
    UrbemSonata.sonataFieldFilterHide("mes");
    
    $("#filter_tipoPeriodicidade_value").on("change", function () {
        switch ($(this).val()) {
          case '1':
              UrbemSonata.sonataFieldFilterShow("dia");
              UrbemSonata.sonataFieldFilterHide("mes");
              UrbemSonata.sonataFieldFilterHide("ano");
              UrbemSonata.sonataFieldFilterHide("periodoInicial");
              UrbemSonata.sonataFieldFilterHide("periodoFinal");
              break;
          case '2':
              UrbemSonata.sonataFieldFilterHide("dia");
              UrbemSonata.sonataFieldFilterShow("mes");
              UrbemSonata.sonataFieldFilterShow("ano");
              UrbemSonata.sonataFieldFilterHide("periodoInicial");
              UrbemSonata.sonataFieldFilterHide("periodoFinal");
              break;
          case '3':
              UrbemSonata.sonataFieldFilterHide("dia");
              UrbemSonata.sonataFieldFilterHide("mes");
              UrbemSonata.sonataFieldFilterShow("ano");
              UrbemSonata.sonataFieldFilterHide("periodoInicial");
              UrbemSonata.sonataFieldFilterHide("periodoFinal");
              break;
          case '4':
              UrbemSonata.sonataFieldFilterHide("dia");
              UrbemSonata.sonataFieldFilterHide("mes");
              UrbemSonata.sonataFieldFilterHide("ano");
              UrbemSonata.sonataFieldFilterShow("periodoInicial");
              UrbemSonata.sonataFieldFilterShow("periodoFinal");
              break;
        }
    });
    
    $("#filter_tipoPeriodicidade_value").trigger("change");
}());
