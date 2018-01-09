<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;

class CalculoRescisaoAdminController extends CalculoSalarioAdminController
{
    /**
     * @return RedirectResponse
     */
    public function listAction()
    {
        /** @var EntityManager $entityManager */
        $em = $this->getDoctrine()->getManager();

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);
        $container = $this->container;

        $folhaComplementarModel = new FolhaComplementarModel($em);
        $complementar = $folhaComplementarModel->consultaFolhaComplementarStatus($periodoFinal->getCodPeriodoMovimentacao());

        if ($complementar['situacao'] == 'a') {
            $message = $this->admin()->trans('rh.folhas.folhaFerias.errors.folhaComplementarAberta', [], 'validators');
            $container->get('session')->getFlashBag()->add('error', $message);

            return new RedirectResponse(
                $this->redirectToRoute('folha_pagamento_folhas_index')
            );
        }
        return parent::listAction();
    }
}
