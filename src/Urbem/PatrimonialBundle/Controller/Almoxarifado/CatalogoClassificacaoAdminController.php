<?php
namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoClassificacaoModel;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\CatalogoItemRepository;

/**
 * Class CatalogoClassificacaoAdminController
 * @package Urbem\PatrimonialBundle\Controller\Almoxarifado
 */
class CatalogoClassificacaoAdminController extends Controller
{
    public function getNiveisCatalogoAction(Request $request)
    {
        $catalogo = $request->attributes->get('id');

        $niveis = $this->getDoctrine()
            ->getRepository('CoreBundle:Almoxarifado\CatalogoNiveis')
            ->findBy(array('codCatalogo' => $catalogo), array('nivel' => 'ASC'));

        $dados = array();
        /** @var Almoxarifado\CatalogoNiveis $nivel */
        foreach ($niveis as $nivel) {
            $dados[$nivel->getNivel()] = $nivel->getNivel() . ' - ' .
                $nivel->getDescricao();
        }

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getNivelCategoriasWithMascaraAction(Request $request)
    {
        $codNivel = $_GET['codNivel'];
        $catalogo = $_GET['codCatalogo'];
        $mask = $_GET['mascara'];
        $nivel = (isset($_GET['nivel'])) ? $_GET['nivel'] : '';

        $params = array(
            'codNivel' => $codNivel,
            'codCatalogo' => $catalogo,
            'mascara' => $mask,
            'nivel' => $nivel
        );

        $entityManager = $this->getDoctrine()->getManager();

        $catalogoClassificacaoModel = new CatalogoClassificacaoModel($entityManager);
        $nivelClassificacoes = $catalogoClassificacaoModel->getNivelCategoriasWithMascara($params);

        $valorPadrao = [];
        foreach ($nivelClassificacoes as $niv) {
            $valorPadrao[$niv['nivel']][] = '<option value="' . $niv['cod_estrutural_reduzido'] . '">' . str_pad($niv['cod_nivel'], strlen($niv['mascara']), "0", STR_PAD_LEFT) . " - " . $niv['descricao'] . '</option>';
        }

        $response = new Response();
        $response->setContent(json_encode($valorPadrao));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getNivelCategoriasAction(Request $request)
    {
        $nivel = $_GET['codNivel'];
        $catalogo = $_GET['codCatalogo'];

        $params = array(
            'codNivel' => $nivel,
            'codCatalogo' => $catalogo
        );

        $entityManager = $this->getDoctrine()->getManager();

        $catalogoClassificacaoModel = new CatalogoClassificacaoModel($entityManager);
        $nivelClassificacoes = $catalogoClassificacaoModel->getClassificacaoMae($params);

        $result = $this->montaValoresArray($nivelClassificacoes, $catalogo);
        $return = $this->montaHtmlNiveis($result['arrClassificacao'], $result['valorPadrao'], $catalogo, $result['mascaras']);

        $response = new Response();
        $response->setContent(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param array $nivelClassificacoes
     * @param $catalogo
     * @return array
     */
    public function montaValoresArray(array $nivelClassificacoes, $catalogo)
    {
        $selected = '';
        foreach ($nivelClassificacoes as $classificacao) {
            $arrClassificacao[$classificacao['nivel']]['label'] = $classificacao['descricao'];
            $arrClassificacao[$classificacao['nivel']]['labelPosicao'] = $classificacao['nivel'];
            if (isset($classificacao['mascara'])) {
                $arrClassificacao[$classificacao['nivel']]['mascara'] = $classificacao['mascara'];
            }
            $paramsInterno = array(
                'codNivel' => $classificacao['nivel'],
                'codCatalogo' => $catalogo
            );
            $entityManager = $this->getDoctrine()->getManager();
            $catalogoClassificacaoModel = new CatalogoClassificacaoModel($entityManager);
            $niveis = $catalogoClassificacaoModel->getClassificacoesByClassificacaoMae($paramsInterno);

            if (count($niveis) > 0) {
                $valorPadrao[$classificacao['nivel']][] = '<option value=0> Selecione </option>';
                foreach ($niveis as $niv) {
                    $mascaras[$classificacao['nivel']] = $niv['mascara'];
                    $arrClassificacao[$classificacao['nivel']]['data'][$niv['cod_nivel']] = $niv['descricao'];
                    $valorPadrao[$classificacao['nivel']][] = '<option ' . $selected . ' value="' . $niv['cod_estrutural_reduzido'] . '">' . str_pad($niv['cod_nivel'], strlen($niv['mascara']), "0", STR_PAD_LEFT) . " - " . $niv['descricao'] . '</option>';
                }
            }
        }

        $result = [
            'mascaras' => $mascaras,
            'arrClassificacao' => $arrClassificacao,
            'valorPadrao' => $valorPadrao,
        ];
        return $result;
    }


    /**
     * @param array $arrClassificacao
     * @param array $valorPadrao
     * @param $catalogo
     * @param array $mascaras
     * @param null $help
     * @return array
     */
    public function montaHtmlNiveis(array $arrClassificacao, array $valorPadrao, $catalogo, $mascaras, $help = null)
    {
        $labelOld = '';
        foreach ($arrClassificacao as $classificacao) {
            $res = '';
            if ($classificacao['labelPosicao'] != count($arrClassificacao) || ($classificacao['labelPosicao'] == 1 && count($arrClassificacao) == 1)) {
                $mascaras[] = $classificacao['mascara'];
                $novaPosicao = $classificacao['labelPosicao'] + 1;
                $strMascara = implode(".", $mascaras);
                if ($classificacao['labelPosicao'] == 1) {
                    $res .= '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $classificacao['labelPosicao'] . '_nivelDinamico" style="display: block;">
                            <label class=" control-label" for="' . $classificacao['labelPosicao'] . '_nivelDinamico">
                                    ' . $classificacao['label'] . '*
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <select class="select2-parameters classificacao_niveis" id="' . $classificacao['labelPosicao'] . '_nivelDinamico" name="catalogoClassificacaoComponent[' . $classificacao['labelPosicao'] . '][nivelDinamico]">
                                    ' . implode("", $valorPadrao[$classificacao['labelPosicao']]) . '
                                </select>
                            </div>
                            ' . $help . '
                        </div>';
                } else {
                    $res .= '
                        <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $classificacao['labelPosicao'] . '_nivelDinamico" style="display: block;">
                            <label class=" control-label" for="' . $classificacao['labelPosicao'] . '_nivelDinamico">
                                    ' . $classificacao['label'] . '*
                            </label>
                            <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                                <select class="select2-parameters classificacao_niveis" disabled="disabled" id="' . $classificacao['labelPosicao'] . '_nivelDinamico" name="catalogoClassificacaoComponent[' . $classificacao['labelPosicao'] . '][nivelDinamico]">
                                    <option value=0> Selecione  ' . $labelOld . ' </option>
                                </select>
                            </div>
                            ' . $help . '
                        </div>
                        <script type="text/javascript">
                            jQuery(function ($) {
                                $(\'#' . $classificacao['labelPosicao'] . '_nivelDinamico\').select2({
                                    width: function(){
                                        // Select2 v3 and v4 BC. If window.Select2 is defined, then the v3 is installed.
                                        // NEXT_MAJOR: Remove Select2 v3 support.
                                        return Admin.get_select2_width(window.Select2 ? this.element : select);
                                    },
                                    dropdownAutoWidth: true,
                                    minimumResultsForSearch: 10,
                                    allowClear: true
                                });
                            });
                        </script>';
                }

                $res .= '
                    <script type="text/javascript">
                        jQuery(function ($) {
                            $(\'#' . $classificacao['labelPosicao'] . '_nivelDinamico\').select2({
                                width: function(){
                                    // Select2 v3 and v4 BC. If window.Select2 is defined, then the v3 is installed.
                                    // NEXT_MAJOR: Remove Select2 v3 support.
                                    return Admin.get_select2_width(window.Select2 ? this.element : select);
                                },
                                dropdownAutoWidth: true,
                                minimumResultsForSearch: 10,
                                allowClear: true
                            });
                            $(\'#' . $classificacao['labelPosicao'] . '_nivelDinamico\').on(\'change\', function(){ atualizaSelectNextLevel( ' . $novaPosicao . ',' . $catalogo . ',"' . $strMascara . '", $(this).val());});
                              function atualizaSelectNextLevel(codNivel, codCatalogo, mascara,nivel) {
                                if (codNivel == 0 || nivel == 0) {
                                  $("#" + codNivel + "_nivelDinamico").attr("disabled", "disabled");
                                  return;
                                }
                                
                                var modalNivelDinamico = $.urbemModal().disableBackdrop().setTitle(\'<h5 class="text-center"><i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw text-center blue-text text-darken-4"></i></h5> <h4 class="grey-text text-center">Aguarde, atualizando os niveis</h4>\').open();                                
                                $.ajax({
                                  url: "/patrimonial/almoxarifado/catalogo-classificacao/get-nivel-categorias-with-mascara/?codNivel=" + codNivel + "&codCatalogo=" + codCatalogo + "&mascara=" + mascara + "&nivel=" + nivel,
                                  method: "GET",
                                  dataType: "json",
                                  success: function (data) {
                                    if (data.toString()) {
                                        $.each(data, function (index, value) {
                                          if (value) {
                                            $("#" + codNivel + "_nivelDinamico").html("<option value=\'0\'>Selecione</option>");
                                            $("#" + codNivel + "_nivelDinamico").append(value);
                                            $("#" + codNivel + "_nivelDinamico").attr("disabled", false);
                                          } else {
                                            $("#" + codNivel + "_nivelDinamico").html(\'<option>Não há opções para o item escolhido.</option>\');
                                            $("#" + codNivel + "_nivelDinamico").attr("disabled", "disabled");
                                          }
                                        });
                                     } else {
                                        $("#" + codNivel + "_nivelDinamico").html(\'<option>Não há opções para o item escolhido.</option>\');
                                        $("#" + codNivel + "_nivelDinamico").attr("disabled", "disabled");
                                     }
                                    modalNivelDinamico.close();
                                    
                                    $("#" + codNivel + "_nivelDinamico").select2({
                                        width: function(){
                                            // Select2 v3 and v4 BC. If window.Select2 is defined, then the v3 is installed.
                                            // NEXT_MAJOR: Remove Select2 v3 support.
                                            return Admin.get_select2_width(window.Select2 ? this.element : select);
                                        },
                                        dropdownAutoWidth: true,
                                        minimumResultsForSearch: 10,
                                        allowClear: true
                                    });
                                    if(CatalogoClassificaoComponent.estrutural()[(codNivel-1)]) {
                                        $("#" + codNivel + "_nivelDinamico").val(CatalogoClassificaoComponent.buildEstrutural(codNivel));
                                        $("#" + codNivel + "_nivelDinamico").trigger("change");
                                    }
                                  }
                                });
                              }
                            
                            if(CatalogoClassificaoComponent.estrutural()[(' . $classificacao['labelPosicao'] . '-1)] && ' . $classificacao['labelPosicao'] . ' == 1) {
                                fechaModal();
                                $("#' . $classificacao['labelPosicao'] . '_nivelDinamico").val(CatalogoClassificaoComponent.estrutural()[(' . $classificacao['labelPosicao'] . '-1)]);
                                $("#' . $classificacao['labelPosicao'] . '_nivelDinamico").trigger("change");
                            }
                        });
                    </script>';
                $return[] = $res;
                $labelOld = $classificacao['label'];
            } else {
                $return[] = '
                <div class="form_row col s3 campo-sonata" id="sonata-ba-field-container-' . $classificacao['labelPosicao'] . '_nivelDinamico" style="display: block;">
                    <label class=" control-label" for="' . $classificacao['labelPosicao'] . '_nivelDinamico">
                            ' . $classificacao['label'] . '*
                    </label>
                    <div class="sonata-ba-field sonata-ba-field-standard-natural ">
                        <select class="select2-parameters classificacao_niveis" disabled="disabled" id="' . $classificacao['labelPosicao'] . '_nivelDinamico" name="catalogoClassificacaoComponent[' . $classificacao['labelPosicao'] . '][nivelDinamico]">
                            <option value=0> Selecione  ' . $labelOld . ' </option>
                        </select>
                    </div>
                    ' . $help . '
                </div>
                    <script type="text/javascript">
                        jQuery(function ($) {
                            $(\'#' . $classificacao['labelPosicao'] . '_nivelDinamico\').select2({
                                width: function(){
                                    // Select2 v3 and v4 BC. If window.Select2 is defined, then the v3 is installed.
                                    // NEXT_MAJOR: Remove Select2 v3 support.
                                    return Admin.get_select2_width(window.Select2 ? this.element : select);
                                },
                                dropdownAutoWidth: true,
                                minimumResultsForSearch: 10,
                                allowClear: true
                            });
                            
                            if(' . $classificacao['labelPosicao'] . ' == ' . count($arrClassificacao) . ') {
                                $(\'#' . $classificacao['labelPosicao'] . '_nivelDinamico\').trigger(\'change\');
                            }
                        });
                    </script>';
            }
        }

        return $return;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function searchAction(Request $request)
    {
        $codCatalogo = (int) $request->get('codCatalogo');

        $classificacoes = [];

        /** @var CatalogoItemRepository $catalogoItemRepository */
        $catalogoItemRepository = $this->getDoctrine()
            ->getRepository(Almoxarifado\CatalogoItem::class);

        $results = $catalogoItemRepository->getCatalogoClassificacaoLike([
            'cod_catalogo' => $codCatalogo,
            'descricao' => $request->get('q')
        ]);

        foreach ($results as $result) {
            $id = sprintf("%d~%d", $result['cod_classificacao'], $result['cod_catalogo']);
            $label = sprintf("%s - %s", $result['cod_estrutural'], $result['descricao']);
            array_push($classificacoes, ['id' => $id, 'label' => $label]);
        }

        $items = [
            'items' => $classificacoes
        ];

        return new JsonResponse($items);
    }
}
