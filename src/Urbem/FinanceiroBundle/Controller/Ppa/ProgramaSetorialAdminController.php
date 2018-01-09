<?php
namespace Urbem\FinanceiroBundle\Controller\Ppa;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProgramaSetorialAdminController extends Controller
{
    public function getMacroObjetivoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $macroObjetivos = (new \Urbem\CoreBundle\Model\Ppa\ProgramaSetorialModel($entityManager))
        ->getMacroObjetivo($request->request->get('codPpa'));

        return new JsonResponse($macroObjetivos);
    }
}
