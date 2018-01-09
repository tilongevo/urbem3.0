<?php

namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Symfony\Component\HttpFoundation\Response;

class RegimeController extends ControllerCore\BaseController
{
    public function numCgmAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $numCgm = $request->attributes->get('id');
        if (empty($numCgm)) {
            return new Response();
        }

        $servidor = $em->getRepository('CoreBundle:Pessoal\Servidor')->findOneByNumcgm($numCgm);
        $response = new Response();

        $contratos = [
            'regime' => '-',
            'subdivisao' => '-'
        ];

        if ($servidor) {
            foreach ($servidor->getCodContrato() as $contrato) {
                $contratos[$contrato->getCodContrato()] = [
                    'regime' => $contrato->getCodRegime()->getDescricao(),
                    'subdivisao' => $contrato->getCodSubDivisao()->getDescricao()
                ];
            }
            krsort($contratos);
            $contratos = current($contratos);
        }

        $response->setContent(json_encode($contratos));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
