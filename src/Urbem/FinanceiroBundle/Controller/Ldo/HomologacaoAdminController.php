<?php

namespace Urbem\FinanceiroBundle\Controller\Ldo;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomologacaoAdminController extends Controller
{
    public function getExercicioLdoHomologadoAction(Request $request)
    {
        $codPpa = $request->request->get('codPpa');

        $em = $this->getDoctrine()->getManager();
        $anos = (new \Urbem\CoreBundle\Model\Ldo\HomologacaoModel($em))
        ->getExercicioLdoHomologado($codPpa);

        return new JsonResponse($anos);
    }

    public function getVeiculoPublicacaoTipoAction(Request $request)
    {
        $codTipoVeiculosPublicidade = $request->request->get('codTipoVeiculosPublicidade');

        $em = $this->getDoctrine()->getManager();
        $numcgmVeiculo = (new \Urbem\CoreBundle\Model\Ldo\HomologacaoModel($em))
        ->getVeiculoPublicacaoTipo($codTipoVeiculosPublicidade);

        return new JsonResponse($numcgmVeiculo);
    }
}
