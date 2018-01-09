<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Model\Contabilidade\PlanoContaModel;

class RelatoriosController extends BaseController
{
    /**
     * Home
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Tesouraria/Relatorios/home.html.twig');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getPlanoContasReceitaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $planoContaModel = new PlanoContaModel($em);

        $nomeConta = $request->query->get('q');

        $result = $planoContaModel->getPlanoContabyNomeContaAndExercicioReceita($this->getExercicio(), $nomeConta);

        $planoContas = array();

        foreach ($result as $r) {
            array_push($planoContas, ['id' => $r['cod_plano'], 'label' => $r['cod_estrutural']. " - " . $r['nom_conta']]);
        }

        $items = [
            'items' => $planoContas
        ];

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getPlanoContasBancoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $planoContaModel = new PlanoContaModel($em);

        $nomeConta = $request->query->get('q');

        $result = $planoContaModel->getPlanoContabyNomeContaAndExercicioBanco($this->getExercicio(), $nomeConta);

        $planoContas = array();

        foreach ($result as $r) {
            array_push($planoContas, ['id' => $r['cod_plano'], 'label' => $r['cod_estrutural']. " - " . $r['nom_conta']]);
        }

        $items = [
            'items' => $planoContas
        ];

        return new JsonResponse($items);
    }
}
