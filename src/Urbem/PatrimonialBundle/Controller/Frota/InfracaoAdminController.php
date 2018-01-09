<?php
namespace Urbem\PatrimonialBundle\Controller\Frota;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;

/**
 * Class InfracaoAdminController
 * @package Urbem\PatrimonialBundle\Controller\Frota
 */
class InfracaoAdminController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function getInfracaoInfoAction(Request $request)
    {
        $codInfracao = $request->attributes->get('id');

        $em = $this->getDoctrine()->getManager();
        $infracaoModel = new Model\Patrimonial\Frota\InfracaoModel($em);

        $infracaoInfo = $infracaoModel->getInfracaoInfo($codInfracao);

        $dados = [];
        $dados['baseLegal'] = $infracaoInfo->getBaseLegal();
        $dados['gravidade'] = $infracaoInfo->getGravidade();
        $dados['pontos']    = $infracaoInfo->getPontos();

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
