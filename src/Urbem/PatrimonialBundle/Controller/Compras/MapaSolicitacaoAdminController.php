<?php
namespace Urbem\PatrimonialBundle\Controller\Compras;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Urbem\CoreBundle\Model\Patrimonial\Compras\MapaItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoModel;

/**
 * Class MapaSolicitacaoAdminController
 *
 * @package Urbem\PatrimonialBundle\Controller\Compras
 */
class MapaSolicitacaoAdminController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function getSolicitacoesMapaCompraAction(Request $request)
    {
        $codEntidade = $request->get('codEntidade');
        $exercicio = $request->get('exercicio');
        $preco = $request->get('preco');

        $entityManager = $this->get('doctrine.orm.entity_manager');

        $solicitacoes = (new SolicitacaoModel($entityManager))
            ->getSolicitacoesMapaCompra($codEntidade, $exercicio, $preco);

        $dados = array();
        foreach ($solicitacoes as $index => $solicitacao) {
            $dados[$index] = [
                'label' => $solicitacao['cod_solicitacao'] . " / ". $solicitacao['exercicio'],
                'value' => $solicitacao['cod_solicitacao']
            ];
        }

        return new JsonResponse($dados);
    }

    public function getItemSolicitacaoMapaCompraAction(Request $request)
    {
        $codSolitacao = $request->get('codSolicitacao');
        $codEntidade = $request->get('codEntidade');
        $exercicio = $request->get('exercicio');
        $codMapa = $request->get('codMapa');

        $entityManager = $this->get('doctrine.orm.entity_manager');

        $items = (new MapaItemModel($entityManager))
            ->montaRecuperaItemsSolicitacaoParaMapa($codSolitacao, $codEntidade, $exercicio);

        return new JsonResponse($items);
    }
}
