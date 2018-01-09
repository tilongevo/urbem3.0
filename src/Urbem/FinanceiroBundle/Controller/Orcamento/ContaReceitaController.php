<?php

namespace Urbem\FinanceiroBundle\Controller\Orcamento;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Helper\ArrayHelper;

class ContaReceitaController extends BaseController
{
    public function getContaReceitaListByExercicioAction(Request $request)
    {
        $opcao = $request->query->get('opcao');
        $exercicio = $request->query->get('exercicio');

        $codEstrutural = '';
        if ($opcao == 1) {
            $codEstrutural = '1.1.5.6';
        }

        if ($opcao == 2) {
            $codEstrutural = '1.2.3';
        }

        if ($opcao == 3) {
            $codEstrutural = '3.';
        }

        if ($opcao == 4) {
            $codEstrutural = '3.';
        }

        $contaReceitaList = $this->getDoctrine()->getRepository('CoreBundle:Contabilidade\PlanoConta')
            ->getContaCreditoLancamentoListByExercicioAndCodEstrutural($exercicio, $codEstrutural);

        $listContas = array();
        foreach ($contaReceitaList as $conta) {
            $descricao = $conta['nom_conta'];
            $mascara = $conta['cod_estrutural'];
            $choiceValue = $conta['cod_conta'];
            $choiceKey = $mascara . " - " . $descricao;
            $listContas[$choiceValue] = $choiceKey;
        }

        $response = new Response();
        $response->setContent(json_encode($listContas));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
