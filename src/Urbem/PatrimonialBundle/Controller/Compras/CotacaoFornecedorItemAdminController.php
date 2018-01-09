<?php

namespace Urbem\PatrimonialBundle\Controller\Compras;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CotacaoFornecedorItemModel;

use Urbem\CoreBundle\Entity\Compras;

class CotacaoFornecedorItemAdminController extends Controller
{
    public function getItemInfoAction(Request $request)
    {
        $codItem = $request->get('codItem');
        $codCotacao = $request->get('codCotacao');
        $exercicioCotacao = $request->get('exercicio');

        $em = $this->getDoctrine()->getManager();

        $ptiModel = new CotacaoFornecedorItemModel($em);
        $itemInfo = $ptiModel->getItemInfo($codCotacao, $exercicioCotacao, $codItem);
        $dados['quantidade'] = $itemInfo->getQuantidade();
        $dados['vlTotal'] = $itemInfo->getVlTotal();
        $dados['vlRef'] = ($itemInfo->getVlTotal() / $itemInfo->getQuantidade());

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
