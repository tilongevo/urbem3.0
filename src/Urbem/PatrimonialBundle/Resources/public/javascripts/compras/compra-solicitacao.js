(function(){
  'use strict';

    var regexpClassificacaoEdit = /edit/,
        locationHref = document.location.href;


    $("#" + UrbemSonata.uniqId + "_fkOrcamentoEntidade").on("change", function () {
        var codEntidade = $(this).val();
        carregaDtSolicitacao(codEntidade);
    });

    function carregaDtSolicitacao(codEntidade)
    {
        if (codEntidade == 0 || codEntidade == '') {
            $("#" + UrbemSonata.uniqId + "_dataSolicitacao").val('');
            $("#" + UrbemSonata.uniqId + "_dataSolicitacao").prop('readonly', false);
        }else{
            var exercicio = $("#" + UrbemSonata.uniqId + "_exercicio").val();

            abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando data da solicitação</h4>');
            $.ajax({
                url: "/patrimonial/compras/solicitacao/get-data-solicitacao?exercicio=" + exercicio + "&codEntidade=" + codEntidade,
                method: "GET",
                dataType: "json",
                success: function (data) {
                    if(data.dataFixaSolicitacao != '' || data.dataFixaSolicitacao != null){
                        $("#" + UrbemSonata.uniqId + "_dataSolicitacao").val(data.dataFixaSolicitacao);
                    }
                    if(data.liberaDataSolicitacao == false){
                        $("#" + UrbemSonata.uniqId + "_dataSolicitacao").prop('readonly', true);
                    }else{
                        $("#" + UrbemSonata.uniqId + "_dataSolicitacao").prop('readonly', false);
                    }
                    fechaModal();
                },
                fail: function() {
                    fechaModal();
                    abreModal('<h5 class="text-center"></h5> <h4 class="grey-text text-center">Erro ao carregar conteúdo</h4> <p class="grey-text text-center">Houve um erro na aplicação, por favor contate o suporte técnico</p>');
                }
            });
        }
    }

  var fieldcodEntidade = $('#filter_fkOrcamentoEntidade_value'),
    fieldExercicio = $('#filter_exercicio_value'),
    fieldUserLogado = $('#filter_userLogado_value'),
    fieldDotacao = $('#filter_fkComprasSolicitacaoItens__fkComprasSolicitacaoItemDotacoes_value');


  fieldcodEntidade.on('change', function (e) {
   var fieldcodEntidadeValue = $(this).val(),
   fieldExercicioValue = fieldExercicio.val();
   carregaDotacao(fieldExercicioValue, fieldcodEntidadeValue);
   });

  fieldExercicio.on('keyup', function (e) {
    var fieldExercicioValue = $(this).val(),
      fieldcodEntidadeValue = fieldcodEntidade.val();
    carregaDotacao(fieldExercicioValue, fieldcodEntidadeValue);
  });

  function carregaDotacao(fieldExercicioValue, fieldcodEntidadeValue)
  {

    if (fieldExercicioValue.length == 4 && fieldcodEntidadeValue != '') {

      abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, pesquisando dotação orçamentária</h4>');
       $.ajax({
       url: "/patrimonial/compras/solicitacao/recupera-lista-dotacao?exercicio=" + fieldExercicioValue + "&codEntidade=" + fieldcodEntidadeValue,
       method: "GET",
       dataType: "json",
       success: function (data) {

         var options = "";
         var selected = '';
         var ctrSelecione = true;
         fieldDotacao.parent().find('div').find('span').first().html('Selecione');
         if (data != null) {
           fieldDotacao.find('option').remove();
           $.each(data, function (key, value) {
             if(ctrSelecione == true){
               options += '<option value="" '+ selected +'>Selecione</option>';
               ctrSelecione = false;
             }
             if(getUrlVars()["filter%5BfkComprasSolicitacaoItens__fkComprasSolicitacaoItemDotacoes%5D%5Bvalue%5D"] == value.cod_despesa){
               fieldDotacao.parent().find('div').find('span').first().html(value.cod_despesa + ' - ' + value.descricao);
               selected = 'selected';
             }
             options += '<option value="' + value.cod_despesa + '" '+ selected +'>' + value.cod_despesa + ' - ' + value.descricao + '</option>';
             selected = ''
             fieldDotacao.html(options);
           });
         } else {
           fieldDotacao.parent().find('div').find('span').first().html('Selecione');
           fieldDotacao.html(options);
         }
         fechaModal();
       },
       fail: function() {
       fechaModal();
       abreModal('<h5 class="text-center"></h5> <h4 class="grey-text text-center">Erro ao carregar conteúdo</h4> <p class="grey-text text-center">Houve um erro na aplicação, por favor contate o suporte técnico</p>');
       }
       });


    }else{
      fieldDotacao.parent().find('div').find('span').first().html('Selecione');
      fieldDotacao.html('');
    }
  }

  function getUrlVars()
  {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
    }
    return vars;
  }

  function reload() {
    var fieldcodEntidadeValue = fieldcodEntidade.val(),
      fieldExercicioValue = fieldExercicio.val();
    if(fieldExercicioValue && fieldcodEntidadeValue){
      carregaDotacao(fieldExercicioValue, fieldcodEntidadeValue);
      fieldDotacao.val(getUrlVars()["filter%5BfkComprasSolicitacaoItens__fkComprasSolicitacaoItemDotacoes%5D%5Bvalue%5D"]);
    }
  }

  reload();

}());
