/**
 * ORGANOGRAMA DINÂMICO COM OS DEVIDOS NÍVEIS
 */

/**
 * Responsável pelo controle do Modal para complemento e melhor uso do organograma
 * @type {UrbemModal}
 */
var modalOrganogramaDinamicoLoad = new UrbemModal();
modalOrganogramaDinamicoLoad.setTitle('Carregando...');

/**
 * Função responsável por desabilitar todos os níveis existentes sempre que um item for alterado
 * @param currentNivel
 */
function disableAnotherOrganogramaNivel(currentNivel)  {
  // OnChange deste desabilita todos os outros seguintes
  $("select.estrutura-organograma-dinamico").each(function(element) {
    var nextNivel = $(this).attr('class').split("organograma-nivel-");

    if (parseInt(nextNivel[1]) > parseInt(currentNivel)) {
      // desabilita e reseta
      $(this).empty().append("<option value=\"\">Selecione</option>").select2("val", "");
      $(this).select2().enable(false);
    }
  });
}
/**
 * Busca órgãos com base em seus níveis selecionados
 * @param codOrganograma
 * @param nivelInputFrom
 * @param nivelInputTo
 */
function montaOrgaoListByOrganogramaNivel(codOrganograma, nivelInputFrom, nivelInputTo) {
  // Abre modal
  modalOrganogramaDinamicoLoad.setBody("Aguarde, pesquisando órgãos...");
  modalOrganogramaDinamicoLoad.open();

  // Descobre qual é o nível atual
  var currentNivel = nivelInputTo.attr('class').split("organograma-nivel-");
  currentNivel = currentNivel[1];

  // Pesquisa se existe um valor default definido, geralmente usados nas páginas de edição
  var defaultValue = eval("typeof default_organograma_nivel_"+currentNivel+" !== 'undefined'") ? eval("default_organograma_nivel_"+currentNivel) : -1;

  // Pesquisa órgãos neste organograma e neste nível
  $.ajax({
    url: "/administrativo/organograma/orgao/consultar-orgaos",
    method: "POST",
    data: {
      nivel: currentNivel,
      codOrgao: nivelInputFrom.val(),
      codOrganograma: codOrganograma,
    },
    dataType: "json",
    success: function (data) {
      var selectedOption = '';
      nivelInputTo.empty().append("<option value=\"\">Selecione</option>").select2("val", "");

      if (Object.keys(data).length > 0) {
        $.each(data, function (index, value) {
          selectedOption = defaultValue == index ? ' selected' : '';

          nivelInputTo.append("<option value=" + index + " " + selectedOption + ">" + value + "</option>");
        });

        nivelInputTo.select2().enable(true);
      } else {
        // alert("Não existem órgãos cadastrados para este nível :(");
        nivelInputTo.select2().enable(false);
      }

      // Fecha modal
      modalOrganogramaDinamicoLoad.close();

      // Se código default existir, automaticamente chama próximo nível
      if (defaultValue >= 0) {
        nivelInputTo.trigger('change');
      }
    }
  });
}
