<?php

namespace Urbem\CoreBundle\Controller\Normas;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller as ControllerCore;

class NormaController extends ControllerCore\BaseController
{
    public function carregaNormaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $filtro = $request->get('q');
        $codTipoNorma = (null !== $request->get('codTipoNorma') ? $request->get('codTipoNorma') : false);
        
        $normasList = $em->getRepository("CoreBundle:Normas\Norma")
        ->findAllNormasPorTipo($codTipoNorma, $filtro);
        
        $normas = array();
        
        foreach ($normasList as $norma) {
            array_push(
                $normas,
                array(
                    'id' => $norma['codNorma'],
                    'label' => $norma['codNorma'] . " - " . $norma['nomNorma']
                )
            );
        }

        $items = array(
            'items' => $normas
        );
        
        return new JsonResponse($items);
    }
}
