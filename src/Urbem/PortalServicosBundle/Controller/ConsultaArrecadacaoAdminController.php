<?php

namespace Urbem\PortalServicosBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Arrecadacao\Lancamento;
use Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel;

/**
 * Class ConsultaArrecadacaoAdminController
 * @package Urbem\PortalServicosBundle\Controller
 */
class ConsultaArrecadacaoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getDetalheParcelaAction(Request $request)
    {
        $codLancamento = $request->query->get('codLancamento');
        $numeracao = $request->query->get('numeracao');
        $ocorrenciaPagamento = $request->query->get('ocorrenciaPagamento') ? :0;
        $codParcela = $request->query->get('codParcela');

        if (!$codLancamento || !$numeracao || !$codParcela) {
            return false;
        }

        $detalhes = $this->getDoctrine()
            ->getEntityManager()
            ->getRepository(Lancamento::class)
            ->getDetalheParcela($codLancamento, $numeracao, $ocorrenciaPagamento, $codParcela);

        $response = new Response();
        $response->setContent(json_encode(['data' => $detalhes]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getDetalhamentoPorCreditoAction(Request $request)
    {
        $detalhes = $this->getDoctrine()
            ->getEntityManager()
            ->getRepository(Lancamento::class)
            ->getDetalhamentoPorCredito($request);

        $response = new Response();
        $response->setContent(json_encode(['data' => $detalhes]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function relatorioCreateAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getEntityManager();
        $container = $this->container;

        $entidade = $this->get('urbem.entidade')->getEntidade();

        $lancamento = $this->em->getRepository(Lancamento::class)
            ->findOneByCodLancamento($request->get('id'));

        if (!$lancamento) {
            return;
        }

        $inscricao = $this->admin->getInscricao($lancamento);
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $this->renderView(
                    'TributarioBundle:Arrecadacao/Consultas/ConsultaArrecadacao/Relatorios:pdf.html.twig',
                    [
                        'object' => $lancamento,
                        'parcelas' => $this->admin->getListaParcelas($lancamento),
                        'contribuinte' => $this->admin->getContribuinte($lancamento),
                        'cobrancas' => $this->admin->getOrigemCobranca($lancamento),
                        'creditos' => $this->admin->getListaCreditos($lancamento),
                        'entidade' => $entidade,
                        'endereco' => sprintf('%d - %s', $inscricao, $this->admin->getEnderecoValue()),
                        'admin' => $this->admin,
                        'arrecadacao' => $this->admin->getArrecadacaoByInscricao($inscricao),
                        'situacaoImovel' => $this->admin->getSituacaoImovel($inscricao),
                        'versao' => $container->getParameter('version'),
                        'usuario' => $usuario,
                        'venal' => $this->admin->getUltimoVenal($inscricao, $lancamento),
                        'exercicio' => $this->admin->getExercicio()
                    ]
                ),
                [
                    'orientation' => 'Landscape',
                    'encoding' => 'utf-8',
                    'enable-javascript' => true,
                    'margin-top'    => 30,
                ]
            ),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf(
                    'inline; filename="%s-%d-%s.pdf"',
                    'ConsultaDeArrecadacao',
                    date('d-m-Y'),
                    $lancamento->getCodLancamento()
                )
            ]
        );
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function exportAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $model = new LancamentoModel($em);

        $qb = $this->admin->createQuery();

        $qb->addSelect(sprintf('%s.vencimento AS vencimento', $qb->getRootAlias()));

        $this->applyFilter($qb, $request);

        $lancamentos = [];
        foreach ($qb->getQuery()->getResult() as $index => $row) {
            $lancamento = reset($row);

            $origemCobranca = $model->getOrigemCobranca($lancamento);
            if ($origemCobranca) {
                $origemCobrancaSplit = explode('§', $origemCobranca);
                $origemCobranca = sprintf('%s/%d', $origemCobrancaSplit[2], $origemCobrancaSplit[3]);
            }

            $lancamentos[$index]['codLancamento'] = $lancamento->getCodLancamento();
            $lancamentos[$index]['origemCobranca'] = $origemCobranca;
            $lancamentos[$index]['situacao'] = $model->getSituacao($lancamento);
        }

        return new JsonResponse($lancamentos);
    }

    /**
    * @param ProxyQuery $qb
    * @param Request $request
    * @return void
    */
    protected function applyFilter(ProxyQuery $qb, Request $request)
    {
        if ($request->get('orderBy')) {
            $sort = $request->get('sort', 'ASC');

            $qb->orderBy($request->get('orderBy'), $sort);
        }

        $size = $request->get('size', 15);
        $qb->setMaxResults($size);
    }
}
