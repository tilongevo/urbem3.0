<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CompensarPagamentoAdminController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class CompensarPagamentoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function emitirRelatorioAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getEntityManager();
        $container = $this->container;

        $entidade = $this->get('urbem.entidade')->getEntidade();

        $session = $this->getRequest()->getSession();
        $parcelasPagas = $session->get('parcelasPagas');
        $parcelasVencer = $session->get('parcelasVencer');
        $parcelasNovas = $session->get('parcelasNovas');

        $totalCompensacao = $this->getRequest()->query->get('totalCompensacao');
        $saldoRestante = $this->getRequest()->query->get('saldoRestante');
        $saldoDisponivel = $this->getRequest()->query->get('saldoDisponivel');
        $valorParcelasSelecionadas = $this->getRequest()->query->get('valorParcelasSelecionadas');
        $valorCompensar = $this->getRequest()->query->get('valorCompensar');
        $contribuinte = $this->getRequest()->query->get('contribuinte');
        $usuario = $container->get('security.token_storage')->getToken()->getUser();

        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $this->renderView(
                    'TributarioBundle:Arrecadacao/CompensarPagamento/Relatorios:pdf.html.twig',
                    [
                        'admin' => $this->admin,
                        'entidade' => $entidade,
                        'modulo' => 'Arrecadacao',
                        'subModulo' => 'Baixa de Débitos',
                        'funcao' => 'Compensar Pagamentos',
                        'nomRelatorio' => 'Exercicio ' . $this->admin->getExercicio(),
                        'contribuinte' => $contribuinte,
                        'exercicio' => $this->admin->getExercicio(),
                        'saldoDisponivel' => $saldoDisponivel,
                        'valorParcelasSelecionadas' => $valorParcelasSelecionadas,
                        'totalCompensacao' => $totalCompensacao,
                        'valorCompensar' => $valorCompensar,
                        'saldoRestante' => $saldoRestante,
                        'parcelasOrigem' => $parcelasPagas,
                        'parcelasCompensadas' => $parcelasVencer,
                        'parcelasNovas' => $parcelasNovas,
                        'versao' => $container->getParameter('version'),
                        'usuario' => $usuario,
                        'dtEmissao' => date('d-m-Y H:i:s')
                    ]
                ),
                [
                    'orientation' => 'Landscape',
                    'encoding' => 'utf-8',
                    'enable-javascript' => true,
                    'margin-top'    => 10,
                ]
            ),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf(
                    'attachment; filename="%s-%d-%d.pdf"',
                    'CompensarPagamentos',
                    date('d-m-Y'),
                    time()
                )
            ]
        );
    }
}
