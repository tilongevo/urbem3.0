<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Tributaria\DividaAtiva\Autoridade\AutoridadeModel;

class AutoridadeController extends BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function buscarMatriculasAction(Request $request)
    {
        $filter = $request->get('q');
        $autoridadeModel = new AutoridadeModel($this->getDoctrine()->getManager());
        $response = new Response();
        $response->setContent(json_encode($autoridadeModel->getMatriculas($filter)));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function buscarFuncaoCargoAction(Request $request)
    {
        $id = $request->attributes->get('_id');
        $autoridadeModel = new AutoridadeModel($this->getDoctrine()->getManager());

        $response = new Response();
        $response->setContent(json_encode(['data' => $autoridadeModel->getFuncaoCargo($id)]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function buscarFundamentacaoLegalAction(Request $request)
    {
        $id = $request->attributes->get('_id');
        $autoridadeModel = new AutoridadeModel($this->getDoctrine()->getManager());
        $response = new Response();
        $response->setContent(json_encode(['data' => $autoridadeModel->getFundamentacaoLegal($id)->toArray()]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
