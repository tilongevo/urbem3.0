<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class PadraoAdminController extends Controller
{
    public function getNormasTipoNormaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tipo = $request->request->get('codTipoNorma');
        
        $normas = (new \Urbem\CoreBundle\Model\Normas\NormaModel($em))
        ->findAllNormasPorTipo($tipo);
        
        $response = new Response();
        $response->setContent(json_encode($normas));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
