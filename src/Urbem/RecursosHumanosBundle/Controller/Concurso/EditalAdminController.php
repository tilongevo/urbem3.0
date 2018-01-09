<?php
namespace Urbem\RecursosHumanosBundle\Controller\Concurso;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Concurso\EditalModel;

class EditalAdminController extends Controller
{

    public function selecionarNormaAction(Request $request)
    {

        $swCodNorma = $request->attributes->get('id');

        $swNorma = $this->getDoctrine()
            ->getRepository('CoreBundle:Normas\Norma')
            ->findOneBy(['codNorma' => $swCodNorma])
        ;

        $jsonNorma = [];

        if (!is_null($swNorma)) {
            $jsonNorma['dtPublicacao'] = $swNorma->getDtPublicacao()->format('d/m/Y');
            $jsonNorma['link'] = $swNorma->getLink();
        }

        $response = new Response();
        $response->setContent(json_encode($jsonNorma));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function filtraNormaPorTipoAction(Request $request)
    {
        $normas = $this->getDoctrine()
            ->getRepository('CoreBundle:Normas\Norma')
            ->findBy(['codTipoNorma' => (int) $request->attributes->get('id')])
        ;

        $listNorma = [];

        foreach ($normas as $norma) {
            $listNorma[$norma->getCodNorma()] = $norma->getNomNorma();
        }

        $response = new Response();
        $response->setContent(json_encode($listNorma));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
