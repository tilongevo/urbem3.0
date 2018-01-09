<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Imobiliario\ConstrucaoModel;

class ConstrucaoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function cadastroImobiliarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $construcaoModel = new ConstrucaoModel($em);
        $cadastroImobiliario = $construcaoModel->cadastroImobiliario($request->request->get('inscricaoMunicipal'));

        $response = new Response();
        $response->setContent(json_encode($cadastroImobiliario));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function areaImovelAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $construcaoModel = new ConstrucaoModel($em);
        $areaImovel = $construcaoModel->areaImovel($request->request->get('inscricaoMunicipal'));

        $response = new Response();
        $response->setContent(json_encode($areaImovel));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function unidadeAutonomaAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $construcaoModel = new ConstrucaoModel($em);
        $unidadeAutonoma = $construcaoModel->unidadeAutonoma($request->request->get('inscricaoMunicipal'));

        $response = new Response();
        $response->setContent(json_encode(($unidadeAutonoma) ? true : false));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
