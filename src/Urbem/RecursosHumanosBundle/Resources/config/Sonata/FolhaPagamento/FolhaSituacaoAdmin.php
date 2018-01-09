<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Folhapagamento\FolhaSituacao;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaSituacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class FolhaSituacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_folha_situacao';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/folha-situacao';

    const SITUACAO_ABERTA = 'a';
    const SITUACAO_FECHADA = 'f';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao');

        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();

        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        if (empty($periodoFinal)) {
            $container = $this->getConfigurationPool()->getContainer();
            $message = $this->trans('recursosHumanos.folhaSituacao.errors.periodoMovimentacaoNaoAberto', [], 'validators');
            $container->get('session')->getFlashBag()->add('error', $message);

            return $this->redirectByRoute('urbem_recursos_humanos_folha_pagamento_periodo_movimentacao_list');
        }

        $dtFinal = $periodoFinal->getDtFinal();
        $dtInicial = $periodoFinal->getDtInicial();

        $formOptions['dtInicial'] = [
            'label' => 'label.recursosHumanos.folhaSituacao.dataInicial',
            'data' => $dtInicial->format('d/m/Y'),
            'attr' => [
                'readonly' => 'readonly'
            ],
            'mapped' => false
        ];

        $formOptions['dtFinal'] = [
            'label' => 'label.recursosHumanos.folhaSituacao.dataFinal',
            'data' => $dtFinal->format('d/m/Y'),
            'attr' => [
                'readonly' => 'readonly'
            ],
            'mapped' => false
        ];
        $arMes = explode("/", $dtInicial->format('d/m/Y'));
        $arDescMes = ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

        $competencia = $arDescMes[($arMes[1] - 1)];

        $formOptions['competencia'] = [
            'label' => 'label.recursosHumanos.folhaSituacao.competencia',
            'data' => $competencia,
            'attr' => [
                'readonly' => 'readonly'
            ],
            'mapped' => false
        ];

        /** @var FolhaSituacao $folhaSituacao */
        $folhaSituacao = $em->getRepository(FolhaSituacao::class)
            ->findOneBy(
                [
                    'codPeriodoMovimentacao' => $periodoFinal->getCodPeriodoMovimentacao(),
                ],
                [
                    'timestamp' => 'DESC'
                ]
            );

        if ($folhaSituacao->getSituacao() == self::SITUACAO_FECHADA) {
            $situacaoAtual = 'Fechado em ' . $folhaSituacao->getTimestamp()->format('d/m/Y H:i:s');
        } else {
            $situacaoAtual = 'Aberto em ' . $folhaSituacao->getTimestamp()->format('d/m/Y H:i:s');
        }

        $formOptions['situacaoAtual'] = [
            'label' => 'label.recursosHumanos.folhaSituacao.situacaoAtual',
            'data' => $situacaoAtual,
            'attr' => [
                'readonly' => 'readonly'
            ],
            'mapped' => false
        ];

        $formOptions['situacao'] = [
            'label' => 'label.recursosHumanos.folhaSituacao.situacao',
            'choices' => [
                'Fechar' => 'f',
                'Reabrir' => 'a'
            ],
            'choice_attr' => function ($situacao, $key, $index) use ($folhaSituacao) {
                if ($index == $folhaSituacao->getSituacao()) {
                    return [
                        'disabled' => true
                    ];
                }
                return [];
            },
            'expanded' => false,
            'multiple' => false,
            'data' => ($folhaSituacao->getSituacao() == self::SITUACAO_ABERTA) ? self::SITUACAO_FECHADA : self::SITUACAO_ABERTA,
            'attr' => ['class' => 'select2-parameters '],
        ];

        $formMapper
            ->with('label.recursosHumanos.folhaSituacao.periodoAberto')
            ->add('dtInicial', 'text', $formOptions['dtInicial'])
            ->add('dtFinal', 'text', $formOptions['dtFinal'])
            ->end()
            ->with('label.recursosHumanos.folhaSituacao.folhaSalario')
            ->add('competencia', 'text', $formOptions['competencia'])
            ->add('situacaoAtual', 'text', $formOptions['situacaoAtual'])
            ->add('situacao', 'choice', $formOptions['situacao'])
            ->end();
    }

    /**
     * @param FolhaSituacao $folhaSituacao
     */
    public function prePersist($folhaSituacao)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao');

        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);
        $folhaSituacao->setFkFolhapagamentoPeriodoMovimentacao($periodoFinal);

        $folhaSituacaoModel = new FolhaSituacaoModel($em);
        if ($folhaSituacao->getSituacao() == self::SITUACAO_FECHADA) {
            $folhaSituacaoModel->manterComplementarSituacaoFechada($folhaSituacao);
        }
    }

    /**
     * @param FolhaSituacao $folhaSituacao
     */
    public function postPersist($folhaSituacao)
    {
        (new RedirectResponse($this->generateUrl('create')))->send();
    }
}
