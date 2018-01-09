<?php
namespace Urbem\FinanceiroBundle\Controller\Ppa;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProgramaAdminController extends Controller
{
    public function getMacroObjetivoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $macroObjetivos = (new \Urbem\CoreBundle\Model\Ppa\ProgramaSetorialModel($entityManager))
        ->getMacroObjetivo($request->request->get('inCodPPA'));

        return new JsonResponse($macroObjetivos);
    }

    public function getProgramaSetorialAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $macroObjetivos = (new \Urbem\CoreBundle\Model\Ppa\ProgramaModel($entityManager))
        ->getProgramaSetorial($request->request->get('inCodMacroObjetivo'));

        return new JsonResponse($macroObjetivos);
    }

    public function getUnidadeOrgaoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $macroObjetivos = (new \Urbem\CoreBundle\Model\Ppa\ProgramaModel($entityManager))
        ->getUnidadeByOrgao($request->request->get('codOrgao'), $request->request->get('exercicio'));

        return new JsonResponse($macroObjetivos);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getNumberProgramaAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $result = (new \Urbem\CoreBundle\Model\Ppa\ProgramaModel($entityManager))
            ->getNumberPrograma($request->query->get('numPrograma'));

        return new JsonResponse($result);
    }
}
