<?php
namespace Urbem\RecursosHumanosBundle\Controller\Beneficio;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ValeTransporteAdminController extends Controller
{
    public function consultarMunicipioUfAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $municipios = (new \Urbem\CoreBundle\Model\SwMunicipioModel($entityManager))
        ->getChoicesMunicipioByUf($request->attributes->get('id'));
        
        $response = new Response();
        $response->setContent(json_encode($municipios));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
