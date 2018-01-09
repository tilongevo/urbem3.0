(function() {
    'use strict';

    var populateSelect = function (select, data, prop) {
        var firstOption = select.find('option:first-child');
        select.empty().append(firstOption);

        $.each(data, function (index, item) {
            var option = $('<option>', {value: item[prop.value], text: item[prop.text]});
            select.append(option);
        });

        $('select').material_select();
    };

    var calculaBolsa = function () {
        if ($('#estagiario_estagio_estagiarioEstagioBolsa_0_vlBolsa').val() > 0){

            var faltas = $('#estagiario_estagio_estagiarioEstagioBolsa_0_faltas').val();

            if(((faltas) > 0) && (faltas <= 30)) {
              var valorBolsaAtual = $('#estagiario_estagio_estagiarioEstagioBolsa_0_vlBolsa').val();
              $('#novoValorBolsa').val((valorBolsaAtual - ((valorBolsaAtual / 30) * faltas).toFixed(2)).formatMoney('2','.',','));
              $('#novoValor').css("display", "block");
            }else{
              $('#novoValor').css("display", "none");
              $('#novoValorBolsa').val('0');
            }

        }
    }

    $('#estagiario_estagio_estagiarioEstagioBolsa_0_faltas')
      .parent('div')
      .append('<div id="novoValor" style="display:none">' +
        '<label class="control-label label-rh required active" for="novoValorBolsa">Novo Valor da Bolsa</label>' +
        '<input type="text" name="novoValorBolsa" id="novoValorBolsa" class="white input-rh browser-default"/>' +
        '</div>');

    $('#estagiario_estagio_cgmInstituicaoEnsino').on('change', function () {
        var selectedOption = $(this).find('option:selected'),
            selectTarget = $('#estagiario_estagio_codGrau');

        $.ajax({
            url: '/recursos-humanos/estagio/estagiario/consultar-grau',
            method: 'POST',
            data: {
                instituicao_ensino: selectedOption.val()
            },
            dataType: 'json',
            success: function (data) {
                populateSelect(selectTarget, data, {value: 'cod_grau', text: 'descricao'});
            }
        });
    });

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

    $("input[id^='estagiario_estagio_vinculoEstagio']").on('change', function () {
        
    })
  
    $('#estagiario_estagio_cgmEstagiario').on('change', function() {
        var selectedOption = $(this).find('option:selected');

        $.ajax({
            url: '/recursos-humanos/estagio/estagiario/consultar-cgm',
            method: 'POST',
            data: {
                cgm: selectedOption.val()
            },
            dataType: 'json',
            success: function (data) {
              $("#estagiario_estagio_rg").val(data['rg']);
              $("#estagiario_estagio_cpf").val(data['cpf']);
              $("#estagiario_estagio_endereco").val(data['endereco']);
              $("#estagiario_estagio_telefoneFixo").val(data['telefone']);
              $("#estagiario_estagio_telefoneCelular").val(data['celular']);
            }
        })
    });


    $('#estagiario_estagio_codEntitidadeIntermediadora').on('change', function() {
        var selectedOption = $(this).find('option:selected'),
            selectTarget = $("#estagiario_estagio_cgmInstituicaoEnsino");

        $.ajax({
            url: '/recursos-humanos/estagio/entidade-intermediadora/consultar-instituicoes',
            method: 'POST',
            data: {
                entidade_intermediadora: selectedOption.val()
            },
            dataType: 'json',
            success: function (data) {
                populateSelect(selectTarget, data, {value: 'id', text: 'cgm'});
            }
        })
    });

    $('#estagiario_estagio_codCurso').on('change', function() {

      var selectedOption = $(this).find('option:selected');

      $.ajax({
        url: '/recursos-humanos/estagio/estagiario/consultar-curso-valor',
        method: 'POST',
        data: {
          cgm: selectedOption.val()
        },
        dataType: 'json',
        success: function (data) {
          $("#estagiario_estagio_estagiarioEstagioBolsa_0_vlBolsa").val(data['vl_bolsa']);
          $("#estagiario_estagio_estagiarioEstagioBolsa_0_faltas").val('0');
        }
      })
    });

    $( "#estagiario_estagio_estagiarioEstagioBolsa_0_faltas" ).bind( "keyup", function() {
        calculaBolsa();
    });

    $( "#estagiario_estagio_estagiarioEstagioBolsa_0_vlBolsa" ).bind( "keyup", function() {
      calculaBolsa();
    });

    $( "#estagiario_estagio_codOrgao" ).on( "change", function() {

        var orgao             = $(this).find('option:selected').val();
        var classificacao     = $('#estagiario_estagio_classificacao');
        var arrClassificacao  = classificacao.val().split('.');

        arrClassificacao[0]   = orgao;

        if(orgao == ''){
          arrClassificacao[0] = '0';
        }

        classificacao.val(arrClassificacao.join('.'));

    });

    $( "#estagiario_estagio_codGrade" ).on( "change", function() {

      var selectedOption = $(this).find('option:selected');

      $.ajax({
        url: '/recursos-humanos/estagio/estagiario/consultar-grade',
        method: 'POST',
        data: {
          grade: selectedOption.val()
        },
        dataType: 'json',
        success: function (data) {

          if(selectedOption.val() == ''){
            $('#mostraGrade').html('');
            return;
          }

          var table = $('<table/>', {
          });

          var theader = $('<thead/>').appendTo(table);

          var title = $('<tr/>', {}).appendTo(theader);

          $('<th/>').html('Dia').appendTo(title);
          $('<th/>').html('Horário de Entrada').appendTo(title);
          $('<th/>').html('Horário de Saída').appendTo(title);
          $('<th/>').html('Horário de Entrada2').appendTo(title);
          $('<th/>').html('Horário de Saída2').appendTo(title);

          var tbody = $('<tbody/>').appendTo(table);

          for (var i = 0; i < data.length; i++) {
            var row = $('<tr/>', {}).appendTo(tbody);
            $('<td/>').html(data[i].nom_dia).appendTo(row);
            $('<td/>').html(data[i].hora_entrada).appendTo(row);
            $('<td/>').html(data[i].hora_saida).appendTo(row);
            $('<td/>').html(data[i].hora_entrada_2).appendTo(row);
            $('<td/>').html(data[i].hora_saida_2).appendTo(row);

          }

          $('#mostraGrade').html(table);

        }
      })
    });

  $("input[name='estagiario_estagio[vinculoEstagio]'").on('change', function () {
        if ($(this).val() == "e") {
            $('#codEntitidadeIntermediadoraContainer').removeClass('hide');
            $('select').material_select();
        } else if ($(this).val() == "i") {
            $('#codEntitidadeIntermediadoraContainer').addClass('hide');
        }
    });

    $('select').material_select();
}());
