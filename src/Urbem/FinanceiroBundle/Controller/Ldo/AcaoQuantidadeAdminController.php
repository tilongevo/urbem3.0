<?php

namespace Urbem\FinanceiroBundle\Controller\Ldo;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class AcaoQuantidadeAdminController extends Controller
{
    public function getExercicioLdoAction(Request $request)
    {
        $inCodPPA = $request->request->get('inCodPPA');

        $em = $this->getDoctrine()->getManager();
        $ppa = $em->getRepository('CoreBundle:Ppa\Ppa')
            ->findOneByCodPpa($inCodPPA);

        $x = 1;
        $anos = array();
        for ($i = (int) $ppa->getAnoInicio(); $i <= (int) $ppa->getAnoFinal(); $i++) {
            $anos[$x] = $i;
            $x++;
        }

        return new JsonResponse($anos);
    }
}
