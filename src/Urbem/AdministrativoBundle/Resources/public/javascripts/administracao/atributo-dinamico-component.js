'use strict';
var AtributoDinamicoComponent = AtributoDinamicoComponent || {};
var AtributoDinamicoPorCadastroComponent = AtributoDinamicoComponent || {};
var AtributoDinamicoPorCodCadastroModuloCodAtributoComponent = AtributoDinamicoComponent || {};

AtributoDinamicoComponent = {
    /**
     * Ajax que carregará os atributos na tela, e também trará o valor dos atributos, caso esteja numa edição
     * @param $params            object  {tabela, fkTabela, codTabela, tabelaPai, codTabelaPai, fkTabelaPaiCollection, fkTabelaPai}
     *        tabela                string  obrigatório   Entity referente a tela onde os atributos dinâmicos estão
     *                                                    sendo inseridos. Exemplo: "CoreBundle:Patrimonio\\Bem"
     *        fkTabela              string  obrigatório   Get da entity onde está salvo os valores dos atributos
     *                                                    dinâmicos da tela. Exemplo: "getFkPatrimonioBemAtributoEspecies"
     *        codTabela             string  opcional      Quando edição, PK/CK da Entity referente a tela onde os
     *                                                    atributos dinâmicos estão sendo inseridos. Exemplo: "1~2016"
     *        tabelaPai             string  obrigatório   Entity responsável pelos atributos dinâmicos que estão sendo
     *                                                    inseridos. Exemplo: "CoreBundle:Patrimonio\\Especie"
     *        codTabelaPai          object  obrigatório   Objeto com a(s) chave(s) da Entity responsável. Exemplo:
     *                                                    {'codEspecie' : codEspecie, 'codGrupo' : codGrupo, 'codNatureza' : codNatureza}
     *        fkTabelaPaiCollection string  obrigatório   Get da entity onde estão salvo os atributos que estão sendo
     *                                                    inseridos. Exemplo: "getFkPatrimonioEspecieAtributos"
     *        fkTabelaPai           string  obrigatório   Get da entity onde estão salvo os atributos que estão sendo
     *                                                    inseridos, a partir da entity onde estão os valores dos atributos
     *                                                    dinâmicos da tela. Exemplo: "getFkPatrimonioEspecieAtributo"
     */
      getAtributoDinamicoFields: function ($params) {
        abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, processando atributos</h4>');
        jQuery("#atributos-dinamicos").html("");

        jQuery.ajax({
            url: "/administrativo/administracao/atributo/consultar-campos/",
            method: "POST",
            data: $params,
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, value) {
                    if(value) {
                        jQuery("#atributos-dinamicos").append(value);
                    } else {
                        jQuery("#atributos-dinamicos").append('<span>Não existem atributos para o item selecionado.</span>');
                    }
                });
                fechaModal();
            }
        });
    }
};

AtributoDinamicoPorCadastroComponent = {
    /**
     * Ajax que carregará os atributos na tela, e também trará o valor dos atributos, caso esteja numa edição
     * @param $params            object  {tabela, fkTabela, codTabela, tabelaPai, codTabelaPai, fkTabelaPaiCollection, fkTabelaPai}
     *        Entidade                  string  obrigatório   Entity referente a tela onde os atributos dinâmicos estão
     *                                                    sendo inseridos. Exemplo: "CoreBundle:Patrimonio\\Bem"
     *        fkEntidadeAtributoValor   string  obrigatório   Get da entity onde está salvo os valores dos atributos
     *                                                    dinâmicos da tela. Exemplo: "getFkPatrimonioBemAtributoEspecies"
     *        codEntidade               string  opcional      Quando edição, PK/CK da Entity referente a tela onde os
     *                                                    atributos dinâmicos estão sendo inseridos. Exemplo: "1~2016"
     *        codModulo                 string  obrigatório   PK do Modulo. Exemplo: 12
     *        codCadastro               string  obrigatório   PK do Cadastro Exemplo: 7
     */
    getAtributoDinamicoFields: function ($params, fieldName, modal) {
        if (modal !== false) {
            abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, processando atributos</h4>');
        }
        if (fieldName != undefined) {
            var field = jQuery("#" + fieldName);
        } else {
            var field = jQuery("#atributos-dinamicos");
        }
        field.html("");

        jQuery.ajax({
            url: "/administrativo/administracao/atributo/consultar-campos-por-cadastro",
            method: "POST",
            data: $params,
            dataType: "json",
            success: function (data) {
                $.each(data, function (index, value) {
                    if(value) {
                        field.append(value);
                    } else {
                        field.append('<span>Não existem atributos para o item selecionado.</span>');
                    }
                });
                if (modal !== false) {
                    fechaModal();
                }
            }
        });
    }
};

AtributoDinamicoPorCodCadastroModuloCodAtributoComponent = {
  /**
   * Ajax que carregará os atributos na tela, e também trará o valor dos atributos, caso esteja numa edição
   * @param $params            object  {tabela, fkTabela, codTabela, tabelaPai, codTabelaPai, fkTabelaPaiCollection, fkTabelaPai}
   *        tabela                string  obrigatório   Entity referente a tela onde os atributos dinâmicos estão
   *                                                    sendo inseridos. Exemplo: "CoreBundle:Patrimonio\\Bem"
   *        fkTabela              string  obrigatório   Get da entity onde está salvo os valores dos atributos
   *                                                    dinâmicos da tela. Exemplo: "getFkPatrimonioBemAtributoEspecies"
   *        codTabela             string  opcional      Quando edição, PK/CK da Entity referente a tela onde os
   *                                                    atributos dinâmicos estão sendo inseridos. Exemplo: "1~2016"
   *        tabelaPai             string  obrigatório   Entity responsável pelos atributos dinâmicos que estão sendo
   *                                                    inseridos. Exemplo: "CoreBundle:Patrimonio\\Especie"
   *        codTabelaPai          object  obrigatório   Objeto com a(s) chave(s) da Entity responsável. Exemplo:
   *                                                    {'codEspecie' : codEspecie, 'codGrupo' : codGrupo, 'codNatureza' : codNatureza}
   *        fkTabelaPaiCollection string  obrigatório   Get da entity onde estão salvo os atributos que estão sendo
   *                                                    inseridos. Exemplo: "getFkPatrimonioEspecieAtributos"
   *        fkTabelaPai           string  obrigatório   Get da entity onde estão salvo os atributos que estão sendo
   *                                                    inseridos, a partir da entity onde estão os valores dos atributos
   *                                                    dinâmicos da tela. Exemplo: "getFkPatrimonioEspecieAtributo"
   */
  getAtributoDinamicoFields: function ($params) {
    abreModal('<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, processando atributos</h4>');
    jQuery("#atributos-dinamicos").html("");

    jQuery.ajax({
      url: "/administrativo/administracao/atributo/consultar-campos-por-modulo-cadastro-e-atributo",
      method: "POST",
      data: $params,
      dataType: "json",
      success: function (data) {
        $.each(data, function (index, value) {
          if(value) {
            jQuery("#atributos-dinamicos").append(value);
          } else {
            jQuery("#atributos-dinamicos").append('<span>Não existem atributos para o item selecionado.</span>');
          }
        });
        fechaModal();
      }
    });
  }
};

(function(){
    // Atributo Dinâmico
    jQuery("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_atributosDinamicos").hide();
    jQuery("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_atributosDinamicos").after('<div id="atributos-dinamicos" class="col s12"></div>');
}());
