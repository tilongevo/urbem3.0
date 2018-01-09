<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Imobiliario\Nivel;

class NivelAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function nivelSuperiorAction(Request $request)
    {
        $codVigencia = $request->request->get('codVigencia');

        $lastNivel = $this->getDoctrine()
            ->getRepository(Nivel::class)
            ->findOneByCodVigencia($codVigencia, array('codNivel' => 'DESC'));

        $response = new Response();
        $response->setContent(
            json_encode(
                ($lastNivel) ? $lastNivel->getCodNivel() : ''
            )
        );
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
