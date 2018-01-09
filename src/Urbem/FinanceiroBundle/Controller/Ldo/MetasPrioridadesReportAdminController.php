<?php

namespace Urbem\FinanceiroBundle\Controller\Ldo;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Helper\ArrayHelper;

class MetasPrioridadesReportAdminController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function programasPorCodPpaAction(Request $request)
    {
        $codPpa = (int)$request->request->get('codPpa');
        $allProgramas = ArrayHelper::parseArrayToChoice($this->repositorySaldoTesouraria()->findAllProgramasPorCodPpa($codPpa), 'num_programa', 'identificacao');

        $response = new Response();
        $response->setContent(json_encode(['programas' => $allProgramas]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function exercicioLdoPorCodPpaAction(Request $request)
    {
        $codPpa = (int)$request->request->get('codPpa');
        $allExerciciosLdo = ArrayHelper::parseArrayToChoice($this->repositorySaldoTesouraria()->findAllExercicioLdoPorCodPpa($codPpa), 'ano', 'exercicio');

        $response = new Response();
        $response->setContent(json_encode(['exercicios' => $allExerciciosLdo]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function repositorySaldoTesouraria()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Ldo\MetasPrioridadesReport');
        return $repository;
    }
}
