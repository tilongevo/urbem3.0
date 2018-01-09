<?php

namespace Urbem\FinanceiroBundle\Controller\Orcamento;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;

class ContaDespesaController extends BaseController
{
    public function getContaDespesaByMascaraAndExercicioAndModuloAction(Request $request)
    {
        $mascara = trim($request->query->get('mascara'));
        $exercicio = $request->query->get('exercicio');
        $modulo = $request->query->get('modulo');

        $contas = $this->getDoctrine()
            ->getRepository('CoreBundle:Orcamento\ContaDespesa')
            ->getContaByMascaraAndExercicioAndModulo($mascara, $exercicio, $modulo);

        $listContas = array();
        foreach ($contas as $conta) {
            $descricao = $conta['descricao'];
            $mascara = $conta['mascara_classificacao'];
            $choiceValue = $conta['cod_conta'];
            $choiceKey = $mascara . " - " . $descricao;
            $listContas[$choiceValue] = $choiceKey;
        }

        $response = new Response();
        $response->setContent(json_encode($listContas));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function getContaDespesaByTipoAndExercicioAction(Request $request)
    {
        $tipo = $request->query->get('tipo');
        $exercicio = $request->query->get('exercicio');

        $debitoLiquidacaoMascara = '1.1.5.6';
        $creditoLiquidacaoMascara = '2.1.3.1.1';

        if ($tipo == 1) {
            $debitoLiquidacaoMascara = '1.1.5.6';
            $creditoLiquidacaoMascara = '2.1.3.1.1';
        }

        if ($tipo == 2) {
            $debitoLiquidacaoMascara = '1.2.3';
            $creditoLiquidacaoMascara = '2.1.3.1.1.01';
        }

        if ($tipo == 3) {
            $debitoLiquidacaoMascara = '3.';
            $creditoLiquidacaoMascara = '2.1.1';
        }

        if ($tipo == 4) {
            $debitoLiquidacaoMascara = '3.';
            $creditoLiquidacaoMascara = '2.1.3.1.1.01';
        }

        $debitoLiquidacaoLancamentoList = $this->getDoctrine()->getRepository('CoreBundle:Orcamento\ContaDespesa')
            ->getContasByMascarasAndExercicio($exercicio, $debitoLiquidacaoMascara, true);

        $creditoLiquidacaoLancamentoList = $this->getDoctrine()->getRepository('CoreBundle:Orcamento\ContaDespesa')
            ->getContasByMascarasAndExercicio($exercicio, $creditoLiquidacaoMascara, false);

        $info = [
            'debitoLiquidacaoLancamentoList' => $debitoLiquidacaoLancamentoList,
            'creditoLiquidacaoLancamentoList' => $creditoLiquidacaoLancamentoList,
        ];

        $response = new Response();
        $response->setContent(json_encode($info));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteContaDespesaAction(Request $request)
    {
        $parameter = $request->get('q');
        $exercicio = $request->get('exercicio');

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository(ContaDespesa::class);
        $result = $repository->getDotacaoOrcamentaria($exercicio, $parameter);

        $contaDespesa = [];
        foreach ($result as $value) {
            array_push($contaDespesa, ['id' => $value['cod_despesa'], 'label' => sprintf('%s - %s', $value['cod_despesa'], $value['descricao'])]);
        }

        return new JsonResponse(array('items' => $contaDespesa));
    }
}
