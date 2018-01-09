<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;

class CalculoComplementarAdminController extends CalculoSalarioAdminController
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
            $message = $this->trans('rh.folhas.folhaComplementar.errors.calculoFolhaComplementarNaoAberta', [], 'validators');
            $container->get('session')->getFlashBag()->add('error', $message);

            return $this->redirectToRoute('folha_pagamento_folhas_index');
        }
    }

    /**
     * @param ProxyQueryInterface $selectedModelQuery
     *
     * @return RedirectResponse
     */
    public function batchActionCalcularComplementar(ProxyQueryInterface $selectedModelQuery)
    {
        $request = $this->admin->getRequest()->request->get('data');
        $request = json_decode($request);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        /** @var FolhaComplementarModel $folhaComplementarModel */
        $folhaComplementarModel = new FolhaComplementarModel($em);
        $complementar = $folhaComplementarModel->consultaFolhaComplementar($periodoFinal->getCodPeriodoMovimentacao());

        try {
            //Contratos selecionados pelo usuário
            $contratos = $request->idx;

            /** @var ContratoModel $contratoModel */
            $contratoModel = new ContratoModel($em);
            $contratoModel->calcularFolha($contratoModel::TIPO_FOLHA_COMPLEMENTAR, $contratos, $this->admin->getExercicio(), $complementar['cod_complementar']);
        } catch (\Exception $e) {
            $this->addFlash('sonata_flash_error', $this->admin->trans('label.contratosCalculadosFalha'));

            return new RedirectResponse(
                $this->admin->generateUrl('list', $this->admin->getFilterParameters())
            );
        }

        $this->addFlash('sonata_flash_success', $this->admin->trans('label.contratosCalculadosSucesso'));

        return new RedirectResponse(
            $this->admin->generateUrl('list')
        );
    }
}
