<?php
namespace Urbem\PatrimonialBundle\Controller\Frota;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Frota\Autorizacao;
use Urbem\CoreBundle\Model\Patrimonial\Frota\AutorizacaoModel;

class ManutencaoAdminController extends Controller
{
    public function getAutorizacaoInfoAction(Request $request)
    {
        $params = [];
        $params['codAutorizacao'] = $request->get('codAutorizacao');
        $params['exercicioAutorizacao'] = $request->get('exercicioAutorizacao');

        $em = $this->getDoctrine()->getManager();
        $autorizacaoModel = new AutorizacaoModel($em);

        /** @var Autorizacao $autorizacao */
        $autorizacao = $autorizacaoModel
            ->getAutorizacaoInfo($params);

        $dados = array();
        $dados['codVeiculo'] = $autorizacao->getCodVeiculo();

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
