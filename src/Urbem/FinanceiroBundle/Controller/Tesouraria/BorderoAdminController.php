<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\Tesouraria;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Model\Empenho\OrdemPagamentoModel;
use Urbem\CoreBundle\Model\Tesouraria\BorderoModel;

/**
 * Class BorderoAdminController
 * @package Urbem\FinanceiroBundle\Controller\Tesouraria
 */
class BorderoAdminController extends BaseController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function getContaPorEntidadeAndExercicioAction(Request $request)
    {
        $contas = (new BorderoModel($this->getDoctrine()->getEntityManager()))->getContaPorEntidadeAndExercicio($request->attributes->get('_id'), $this->getExercicio());

        $response = new Response();
        $response->setContent(json_encode(['dados' => $contas]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getOrdemPagamentoAction(Request $request)
    {
        $model = new BorderoModel($this->getDoctrine()->getEntityManager());
        $planoRecurso = $model->getPlanoRecursoPorCodPlanoAndExercicio($request->request->get('codPlano'), $request->request->get('exercicio'));

        $ordemPagamento = null;
        if (!empty($planoRecurso)) {
            $ordemPagamento = $model->clearOrdemPagamentoJaEfetuado(
                $model->getOrdemPagamentoPorEntidadeAndExercicioAndCodRecurso($request->request->get('codEntidade'), $request->request->get('exercicio'), $planoRecurso->getCodRecurso(), null),
                $request->request->get('codEntidade'),
                $request->request->get('exercicio')
            );
        }

        $response = new Response();
        $response->setContent(json_encode(['dados' => $ordemPagamento]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getValoresOrdemPagamentoAction(Request $request)
    {

        $model = new BorderoModel($this->getDoctrine()->getEntityManager());
        $codNota = $model->getCodNota($request->request->get('codOrdemPagamento'), $request->request->get('exercicio'), $request->request->get('codEntidade'));

        $valores = null;
        if (!empty($codNota)) {
            $valores = $model->getValoresPorOrdemDePagamento($request->request->get('codEntidade'), $request->request->get('exercicio'), $request->request->get('codOrdemPagamento'), current($codNota)['cod_nota']);
        }

        $planoRecurso = $model->getPlanoRecursoPorCodPlanoAndExercicio($request->request->get('codPlano'), $request->request->get('exercicio'));
        $ordemPagamento = null;
        if (!empty($planoRecurso)) {
            $ordemPagamento = $model->getOrdemPagamentoPorEntidadeAndExercicioAndCodRecurso($request->request->get('codEntidade'), $request->request->get('exercicio'), $planoRecurso->getCodRecurso(), $request->request->get('codOrdemPagamento'));
        }

        $valores = current($valores);
        $ordemPagamento = current($ordemPagamento);

        $obj = new \stdClass();
        $obj->credor = $ordemPagamento['cod_ordem'] . ' - ' . $ordemPagamento['beneficiario'];
        $obj->op = $ordemPagamento['cod_ordem'] . '/' . $ordemPagamento['exercicio'];
        $obj->codOrdemPag = $ordemPagamento['cod_ordem'];
        $obj->valor = $valores['vl_a_pagar'];
        $obj->vlPago = $valores['vl_pago'];
        $obj->entidade = $valores['cod_entidade'];
        $obj->vlTotalLiquidacao = $valores['vl_total_por_liquidacao'];
        $obj->notaEmpenho = trim($ordemPagamento['nota_empenho']);
        $obj->codNota = current($codNota)['cod_nota'];

        $response = new Response();
        $response->setContent(json_encode(['dados' => $obj]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getAgenciasPorBancoAction(Request $request)
    {
        $codBanco = $request->request->get('codBanco');
        $model = new BorderoModel($this->getDoctrine()->getEntityManager());
        $agencias = $model->getAgenciasPorBanco($codBanco);

        $response = new Response();
        $response->setContent(json_encode(['dados' => $agencias]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function relatorioAction(Request $request)
    {
        $objectId = $request->get('id');
        $container = $this->container;
        $entityManager = $this->getDoctrine()->getEntityManager();

        list($codBordero, $codEntidade, $exercicio) = explode('~', $objectId);

        /** @var Tesouraria\Bordero $bordero */
        $bordero = $this->admin->getObject($objectId);

        /** @var Orcamento\Entidade $entidade */
        $entidade = $entityManager
            ->getRepository(Orcamento\Entidade::class)
            ->findOneBy([
                'exercicio' => $exercicio,
                'codEntidade' => $codEntidade
            ]);

        $cgmPessoaJuridica = $entityManager
            ->getRepository(SwCgmPessoaJuridica::class)
            ->find($entidade->getNumcgm());

        $usuario = $container
            ->get('security.token_storage')
            ->getToken()
            ->getUser();


        $model = new BorderoModel($entityManager);

        /** @var Tesouraria\TransacoesPagamento $ultimaTransferencia */
        $ultimaTransferencia = $bordero->getFkTesourariaTransacoesPagamentos()->last();

        switch ($ultimaTransferencia->getCodTipo()) {
            case $model::NAO_INFORMADO:
                $ultimaTransferencia->setCodTipo(
                    $container->get('translator')->transChoice('label.bordero.labelsCodTipo.naoInformado', 0, [], 'messages')
                );
                break;
            case $model::TRANSFERENCIA_CC:
                $ultimaTransferencia->setCodTipo(
                    $container->get('translator')->transChoice('label.bordero.labelsCodTipo.transferenciaCCorrente', 0, [], 'messages')
                );
                break;
            case $model::TRANSFERENCIA_PO:
                $ultimaTransferencia->setCodTipo(
                    $container->get('translator')->transChoice('label.bordero.labelsCodTipo.transferenciaPoupanca', 0, [], 'messages')
                );
                break;
            case $model::DOC:
                $ultimaTransferencia->setCodTipo(
                    $container->get('translator')->transChoice('label.bordero.labelsCodTipo.doc', 0, [], 'messages')
                );
                break;
            case $model::TED:
                $ultimaTransferencia->setCodTipo(
                    $container->get('translator')->transChoice('label.bordero.labelsCodTipo.ted', 0, [], 'messages')
                );
                break;
        }

        $banco = $bordero->getFkConciliacaoPlanoBanco()->getCodBanco();
        $agencia = $bordero->getFkConciliacaoPlanoBanco()->getCodAgencia();
        $boletim = $bordero->getFkTesourariaBoletim();

        $ordemPagamentoDataCollection = [];
        $valorTotalBordero = 0;

        $ordemPagamentoModel = new OrdemPagamentoModel($entityManager);

        /** @var Tesouraria\TransacoesPagamento $transacoesPagamento */
        foreach ($bordero->getFkTesourariaTransacoesPagamentos() as $transacoesPagamento) {
            $ordemPagamentoRelatorio = $ordemPagamentoModel->recuperaDadosParaEmissaoBordero($transacoesPagamento);

            $valorTotalBordero =+
                $ordemPagamentoRelatorio['vl_nota_original'] - $ordemPagamentoRelatorio['vl_nota_anulacoes'];

            $ordemPagamentoDataCollection[] = $ordemPagamentoRelatorio;
        }

        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        $html = $this->renderView(
            'FinanceiroBundle:Tesouraria/Bordero:pdf.html.twig',
            [
                'entidade' => $entidade,
                'cgmPessoaJuridica' => $cgmPessoaJuridica,
                'modulo' => 'Tesouraria',
                'subModulo' => 'Pagamentos',
                'funcao' => 'Borderô - Pagamentos',
                'nomRelatorio' => 'Borderô - Pagamentos',
                'dtEmissao' => new \DateTime('now'),
                'usuario' => $usuario,
                'versao' => $container->getParameter('version'),
                'bordero' => $bordero,
                'ultimaTransacao' => $ultimaTransferencia,
                'boletim' => $boletim,
                'agencia' => $agencia,
                'banco' => $banco,
                'ordemPagamentoDataCollection' => $ordemPagamentoDataCollection,
                'valorTotalBordero' => $valorTotalBordero,
                'uf' => $entidade->getNumcgm()->getCodUf()
            ]
        );

        $filename = sprintf('Bordero-%s.pdf', date('Y-m-d'));

        $pdfFormatter = [
            'encoding' => 'utf-8',
            'enable-javascript' => true,
            'footer-line' => true,
            'footer-left' => 'URBEM - CNM',
            'footer-right' => '[page]',
            'footer-center' => 'www.cnm.org.br'
        ];

        $headerFormatter = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
        ];

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html, $pdfFormatter),
            200,
            $headerFormatter
        );
    }
}
