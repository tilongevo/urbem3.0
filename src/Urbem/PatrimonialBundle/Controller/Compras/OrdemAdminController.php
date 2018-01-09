<?php
namespace Urbem\PatrimonialBundle\Controller\Compras;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model\Patrimonial\Compras\OrdemModel;

/**
 * Class OrdemAdminController
 * @package Urbem\PatrimonialBundle\Controller\Compras
 */
class OrdemAdminController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function getEmpenhoInfoAction(Request $request)
    {
        $empenho = $request->attributes->get('id');

        $em = $this->getDoctrine()->getManager();
        $OrdemModel = new OrdemModel($em);

        $empenhoInfo = $OrdemModel->getEmpenhoInfo($empenho);

        $dados = [];
        $dados['fornecedor'] = $empenhoInfo[0]['cgm_fornecedor'].' - '.$empenhoInfo[0]['fornecedor'];
        $dados['entidade'] = $empenhoInfo[0]['cod_entidade'].' - '.$empenhoInfo[0]['entidade'];
        $dados['codEntidade'] = $empenhoInfo[0]['cod_entidade'];
        $dados['exercicioEmpenho'] = $empenhoInfo[0]['exercicio_empenho'];

        $itemPreEmpenho = $OrdemModel->getItemPreEmpenho($empenhoInfo[0]['exercicio_empenho'], $empenhoInfo[0]['cod_empenho'], $empenhoInfo[0]['cod_entidade'], 1);

        $dados['item']['numItem'] = $itemPreEmpenho[0]['num_item'];
        $dados['item']['codPreEmpenho'] = $itemPreEmpenho[0]['cod_pre_empenho'];
        $dados['item']['nomItem'] = $itemPreEmpenho[0]['nom_item'];
        $dados['item']['exercicioPreEmpenho'] = $itemPreEmpenho[0]['exercicio'];
        $dados['item']['quantidade'] = $itemPreEmpenho[0]['quantidade'];
        $dados['item']['ocSaldo'] = $itemPreEmpenho[0]['oc_saldo'];
        $dados['item']['ocQtdAtendido'] = $itemPreEmpenho[0]['oc_quantidade_atendido'];
        $dados['item']['ocVlAtendido'] = $itemPreEmpenho[0]['oc_vl_atendido'];
        $dados['item']['vlUnit'] = $itemPreEmpenho[0]['vl_unitario'];
        $dados['item']['ocVlTotal'] = $itemPreEmpenho[0]['oc_vl_total'];

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
