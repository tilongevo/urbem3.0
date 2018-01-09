<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Folhapagamento\FolhaSituacao;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;
use Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento\FolhaSituacaoAdmin;

/**
 * Class PeriodoMovimentacaoController
 * @package Urbem\RecursosHumanosBundle\Controller\FolhaPagamento
 */
class PeriodoMovimentacaoController extends ControllerCore\BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $periodoMovimentacao = new PeriodoMovimentacao();
        $form = $this->createForm('Urbem\RecursosHumanosBundle\Form\FolhaPagamento\PeriodoMovimentacaoType', $periodoMovimentacao);
        $form->handleRequest($request);

        $this->setBreadCrumb();

        $container = $this->container;

        if ($form->isSubmitted() && $form->isValid()) {
            $container->get('session')->getFlashBag()->clear();
            $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.recursosHumanos.periodoMovimentacao.msgSucesso'));
            return $this->redirectToRoute('urbem_recursos_humanos_folha_pagamento_periodo_movimentacao_list');
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($em);

        $periodoUnico = $periodoMovimentacaoModel->listPeriodoMovimentacao();
        $periodo = $periodoMovimentacaoModel->getOnePeriodo($periodoUnico);
        $codPeriodoMovimentacao = $periodo->getCodPeriodoMovimentacao();

        /** @var FolhaSituacao $folhaSituacao */
        $folhaSituacao = $em->getRepository(FolhaSituacao::class)
            ->findOneBy(
                [
                    'codPeriodoMovimentacao' => $periodo->getCodPeriodoMovimentacao(),
                ],
                [
                    'timestamp' => 'DESC'
                ]
            );

        if (($folhaSituacao) && ($folhaSituacao->getSituacao() == FolhaSituacaoAdmin::SITUACAO_ABERTA)) {
            $container->get('session')->getFlashBag()->clear();
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.recursosHumanos.periodoMovimentacao.folhaSalarioAberta'));
            return $this->redirectToRoute('urbem_recursos_humanos_folha_pagamento_periodo_movimentacao_list');
        }

        if ($periodo) {
            $dataInicial = $periodo->getDtFinal();
            $dataInicial = $dataInicial->modify('+1 day');
        } else {
            $dataInicial = new \DateTime();
            $dataInicial = $dataInicial->modify('first day of this month');
        }

        $dataFinal = clone $dataInicial;
        $dataFinal = $dataFinal->modify('last day of this month');

        $periodoMovimentacao->setDtInicial($dataInicial);
        $periodoMovimentacao->setDtFinal($dataFinal);


        /** @var ContratoModel $contratoModel */
        $contratoModel = new ContratoModel($em);
        $contratos = [];
        $paramsBo["boAtivos"] = true;
        $paramsBo["boAposentados"] = false;
        $paramsBo["boRescindidos"] = false;
        $paramsBo["boPensionistas"] = true;
        $paramsBo["stTipoFolha"] = ContratoModel::TIPO_FOLHA_SALARIO;
        $contratosArray = $contratoModel->montaRecuperaContratosCalculoFolha(
            $paramsBo,
            $codPeriodoMovimentacao,
            '',
            [],
            [],
            []
        );

        foreach ($contratosArray as $contrato) {
            $contratos[] = $contrato['cod_contrato'];
        }

        $contratosStr = implode(',', $contratos);
        $contratos = count($contratos);

        return $this->render('RecursosHumanosBundle::FolhaPagamento/PeriodoMovimentacao/new.html.twig', array(
            'periodoMovimentacao' => $periodoMovimentacao,
            'contratos' => $contratos,
            'contratosStr' => $contratosStr,
            'form' => $form->createView()
        ));
    }
}
