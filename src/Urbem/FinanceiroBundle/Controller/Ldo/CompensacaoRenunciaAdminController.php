<?php

namespace Urbem\FinanceiroBundle\Controller\Ldo;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class CompensacaoRenunciaAdminController extends Controller
{
    public function getExercicioLdoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $inCodPPA = $request->request->get('inCodPPA');

        $anos = (new \Urbem\CoreBundle\Model\Ldo\CompensacaoRenunciaModel($entityManager))
        ->getExercicioLdo($inCodPPA);

        return new JsonResponse($anos);
    }
}
