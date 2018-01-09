<?php

namespace Urbem\FinanceiroBundle\Controller\Contabilidade;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoConta;
use Urbem\CoreBundle\Model\Contabilidade\ConfiguracaoLancamentoReceitaModel;

/**
 * Class ConfiguracaoController
 * @package Urbem\FinanceiroBundle\Controller\Contabilidade
 */
class ConfiguracaoController extends BaseController
{
    const SELECIONE = [0, 'selecione', 'Selecione'];
    const ARRECADACAO_DIRETA = [1, 'arrecadacaoDireta', 'Arrecadação Direta'];
    const OPERACOES_CREDITO = [2, 'operacoesCredito', 'Operações de Crédito'];
    const ALIENACAO_BENS_MOVEIS_IMOVEIS = [3, 'alienacaoBens', 'Alienação Bens Móveis/Imóveis'];
    const DIVIDA_ATIVA = [4, 'dividaAtiva', 'Dívida Ativa'];

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Contabilidade/Configuracao/home.html.twig');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getConfiguracaoReceitaByContaReceitaAndExercicioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $codContaReceita = $request->query->get('codReceita');
        $configLancamentoReceitaModel = new ConfiguracaoLancamentoReceitaModel($em);
        $bool = $configLancamentoReceitaModel->isCheckConfiguracaoReceita($codContaReceita, $this->getExercicio());

        return new JsonResponse($bool);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getLancamentoAndCreditoByContaReceitaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $codContaReceita = $request->query->get('codReceita');
        $configLancamentoReceitaModel = new ConfiguracaoLancamentoReceitaModel($em);
        $result = $configLancamentoReceitaModel->getLancamentoAndCredito($codContaReceita, $this->getExercicio());

        $items = array();

        if ($result['tipo_arrecadacao'] == self::ARRECADACAO_DIRETA[1]) {
            $lancamento_arr = array(
                'id' => self::ARRECADACAO_DIRETA[0],
                'label' => self::ARRECADACAO_DIRETA[2]
            );
        } elseif ($result['tipo_arrecadacao'] == self::OPERACOES_CREDITO[1]) {
            $lancamento_arr = array(
                'id' => self::OPERACOES_CREDITO[0],
                'label' => self::OPERACOES_CREDITO[2]
            );
        } elseif ($result['tipo_arrecadacao'] == self::ALIENACAO_BENS_MOVEIS_IMOVEIS[1]) {
            $lancamento_arr = array(
                'id' => self::ALIENACAO_BENS_MOVEIS_IMOVEIS[0],
                'label' => self::ALIENACAO_BENS_MOVEIS_IMOVEIS[2]
            );
        } elseif ($result['tipo_arrecadacao'] == self::DIVIDA_ATIVA[2]) {
            $lancamento_arr = array(
                'id' => self::DIVIDA_ATIVA[0],
                'label' => self::DIVIDA_ATIVA[2]
            );
        }

        $codConta = $result['cod_conta'];
        $conta = $em->getRepository(PlanoConta::class)
            ->findOneBy(['codConta' => $codConta, 'exercicio' => $this->getExercicio()]);

        $conta_arr = array(
            'id' => $codConta,
            'label' => sprintf('%s - %s', $conta->getCodEstrutural(), $conta->getNomConta())
        );

        array_push($items, array(
            'lancamento' => $lancamento_arr,
            'conta' => $conta_arr
        ));

        return new JsonResponse($items);
    }

    /**
     * @return JsonResponse
     */
    public function getLancamentosAction()
    {
        $lancamentos = [self::SELECIONE, self::ARRECADACAO_DIRETA, self::OPERACOES_CREDITO, self::ALIENACAO_BENS_MOVEIS_IMOVEIS, self::DIVIDA_ATIVA];
        $lancamento_arr = array();
        foreach ($lancamentos as $lamento) {
            array_push($lancamento_arr, array(
                'id' => $lamento[0],
                'label' => $lamento[2]
            ));
        }

        $items = array();
        array_push($items, $lancamento_arr);

        return new JsonResponse($items);
    }

    /**
     * @return JsonResponse
     */
    public function getContasAction()
    {
        $em = $this->getDoctrine()->getManager();
        $planoConta = $em->getRepository(PlanoConta::class)
            ->getContaCreditoLancamentoListByExercicioAndCodEstrutural($this->getExercicio(), '', false);

        $contas_arr = array();
        foreach ($planoConta as $conta) {
            array_push($contas_arr, array(
                'id' => $conta['cod_conta'],
                'label' => $conta['cod_estrutural'].' - '.$conta['nom_conta']
            ));
        }

        $items = array();
        array_push($items, $contas_arr);

        return new JsonResponse($items);
    }
}
