<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;

class ContratoServidorComplementarAdminController extends CRUDController
{

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function preList(Request $request)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        /** @var FolhaComplementarModel $folhaComplementarModel */
        $folhaComplementarModel = new FolhaComplementarModel($entityManager);
        $complementar = $folhaComplementarModel->consultaFolhaComplementar($periodoFinal->getCodPeriodoMovimentacao());
        $container = $this->admin->getConfigurationPool()->getContainer();
        if (empty($complementar)) {
            $message = $this->trans('rh.folhas.folhaComplementar.errors.folhaComplementarNaoAberta', [], 'validators');
            $container->get('session')->getFlashBag()->add('error', $message);

            return $this->redirectToRoute('folha_pagamento_folhas_index');
        }
    }
}
