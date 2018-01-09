<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Economico\NivelServico;

/**
 * Class NivelServicoAdminController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class NivelServicoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function nivelSuperiorAction(Request $request)
    {
        $codVigencia = $request->request->get('codVigencia');

        $lastNivel = $this->getDoctrine()
            ->getRepository(NivelServico::class)
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
