<?php

namespace Urbem\RecursosHumanosBundle\Controller\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Monetario;

/**
* Api\Monetario controller.
*/
class MonetarioController extends ControllerCore\BaseController
{
    public function findAgenciasByBancoAction(Request $request)
    {
        $em = $this->getDoctrine();

        $bancoId = $request->get('cod_banco');

        $agencias = $em->getRepository(Monetario\Agencia::class)->findBy(['codBanco' => $bancoId]);

        $jsonResponse = [];

        /**
         * @var Monetario\Agencia $agencia
         */
        foreach ($agencias as $agencia) {
            $jsonResponse[] = [
                'codAgencia' => $agencia->getCodAgencia(),
                'nomAgencia' => $agencia->getNumAgencia() . " - " . $agencia->getNomAgencia()
            ];
        }

        $agencias = json_encode($jsonResponse);

        $response = new Response();
        $response->setContent($agencias);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function findContasCorrenteByAgenciaAction(Request $request)
    {
        $em = $this->getDoctrine();

        $bancoId = $request->get('cod_banco');
        $agenciaId = $request->get('cod_agencia');

        $contasCorrente = $em->getRepository(Monetario\ContaCorrente::class)->findBy([
            'codBanco' => $bancoId,
            'codAgencia' => $agenciaId
        ]);

        $jsonResponse = [];

        /**
         * @var Monetario\ContaCorrente $contaCorrente
         */
        foreach ($contasCorrente as $contaCorrente) {
            $jsonResponse[] = [
                'codContaCorrente' => $contaCorrente->getCodContaCorrente(),
                'numContaCorrente' => $contaCorrente->getNumContaCorrente()
            ];
        }

        $contasCorrente = json_encode($jsonResponse);

        $response = new Response();
        $response->setContent($contasCorrente);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
