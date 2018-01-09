'use strict';
var AtributoDinamicoComponent = AtributoDinamicoComponent || {};
var AtributoDinamicoPorCadastroComponent = AtributoDinamicoComponent || {};

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
    getAtributoDinamicoFields: function ($params, campoEscolhido, fieldName, modal) {
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

                var arrayAtributos = [];
                $('#atributos-dinamicos').find('*').each(function(){
                    var id = $(this).attr("id");
                    arrayAtributos.push({id:id});
                });

                $('#atributos-dinamicos').children('div').hide();

                $.each(arrayAtributos, function (index, value) {

                    var id = value['id'];
                    if (!(id === undefined)) {
                        if (id.search('sonata-ba-field-container-' + campoEscolhido) != -1) {
                            $("#"+id).show();
                        }
                    }

                });

                if (modal !== false) {
                    fechaModal();
                }
            }
        });
    }
};

(function(){
    // Atributo Dinâmico
    jQuery("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_atributosDinamicos").hide();
    jQuery("#sonata-ba-field-container-" + UrbemSonata.uniqId + "_atributosDinamicos").after('<div id="atributos-dinamicos" class="col s12"></div>');
}());
