<?php

namespace Urbem\RecursosHumanosBundle\Controller\Api;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Monetario;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Urbem\CoreBundle\Model\Folhapagamento\PrevidenciaPrevidenciaModel;

/**
* Api\Monetario controller.
*/
class PrevidenciaEventosController extends ControllerCore\BaseController
{
    public function getEventosByNaturezaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $natureza = $request->get('natureza', false);

        $model = new PrevidenciaPrevidenciaModel($em);

        if (!$natureza) {
            $retorno = [
                'B' => $model->getEvents('B'),
                'D' => $model->getEvents('D'),
            ];

            return $this->sendRequest(json_encode($retorno));
        }

        $eventos = $model->getEvents($natureza);

        if (empty($eventos) || !$eventos) {
            return $this->sendRequest(json_encode(['error' => '1', 'msg' => 'Não há eventos a serem exibidos.']));
        }

        return $this->sendRequest(json_encode($eventos));
    }

    private function sendRequest($message)
    {
        $response = new Response();
        $response->setContent($message);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
