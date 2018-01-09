<?php

namespace Urbem\FinanceiroBundle\Controller\Empenho;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;

class LiquidarEmpenhoController extends BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function assinaturaAction(Request $request)
    {
        $container = $this->container;
        $container->get('session')->getFlashBag()->set('assinaturas', array());
        $container->get('session')->getFlashBag()->add('assinaturas', $request->request->get('assinaturas'));

        $response = new Response();
        $response->setContent(json_encode('true'));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
