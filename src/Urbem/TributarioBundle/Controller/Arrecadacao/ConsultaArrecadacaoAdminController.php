<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;
use Urbem\CoreBundle\Entity\Arrecadacao\Lancamento;

/**
 * Class ConsultaArrecadacaoAdminController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
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
}
