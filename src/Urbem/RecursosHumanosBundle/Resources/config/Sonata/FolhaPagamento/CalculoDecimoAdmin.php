<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculoDecimo;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Model\Administracao\AcaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\ConcessaoDecimoModel;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\LogErroCalculoDecimoModel;
use Urbem\CoreBundle\Model\Folhapagamento\LogErroCalculoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorModel;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin;

class CalculoDecimoAdmin extends CalculoSalarioAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_folhas_calculo_decimo';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/folhas/calculo-decimo';
    protected $exibirMensagemFiltro = false;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/folhapagamento/calculoDecimo.js',
        ]));

        $entityManager = $this->getDoctrine();

        /** @var OrganogramaModel $organogramaModel */
        $organogramaModel = new OrganogramaModel($entityManager);
        /** @var OrgaoModel $orgaoModel */
        $orgaoModel = new OrgaoModel($entityManager);

        $resOrganograma = $organogramaModel->getOrganogramaVigentePorTimestamp();
        $codOrganograma = $resOrganograma['cod_organograma'];
        $dataFinal = $resOrganograma['dt_final'];
        $lotacoes = $orgaoModel->montaRecuperaOrgaos($dataFinal, $codOrganograma);

        $lotacaoArray = [];
        foreach ($lotacoes as $lotacao) {
            $key = $lotacao->cod_orgao;
            $value = $lotacao->cod_estrutural . " - " . $lotacao->descricao;
            $lotacaoArray[$value] = $key;
        }

        $formGridOptions = [];

        $opcoes = [
            'cgm' => 'cgm_contrato',
            'lotacao' => 'lotacao',
            'geral' => 'geral'
        ];

        $formGridOptions['tipo'] = [
            'label' => 'label.recursosHumanos.folhas.grid.tipo',
            'mapped' => false,
            'callback' => [$this, 'getSearchFilter'],
        ];

        $formGridOptions['tipoChoices'] = [
            'choices' => $opcoes,
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'required' => true,
                'class' => 'select2-parameters '
            ],
        ];

        $formGridOptions['fkPessoalContratoServidor'] = [
            'label' => 'label.cgmmatricula',
            'callback' => [
                $this,
                'getSearchFilter'
            ],
        ];

        $formGridOptions['fkPessoalContratoServidorChoices'] = [
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato_nao_rescindido'
            ],
            'multiple' => true,
            'json_choice_label' => function ($contrato) use ($entityManager) {
                $nomcgm = $this->getServidor($contrato);

                return $nomcgm;
            },
            'attr' => [
                'class' => 'select2-parameters select2-multiple-options-custom  ',
                'required' => true
            ],
            'mapped' => false
        ];

        $formGridOptions['lotacao'] = [
            'label' => 'label.recursosHumanos.folhas.grid.lotacao',
            'callback' => [$this, 'getSearchFilter'],
            'required' => true,
            'mapped' => false,
        ];

        $formGridOptions['lotacaoChoices'] = [
            'choices' => $lotacaoArray,
            'expanded' => false,
            'multiple' => true,
            'attr' =>
                [
                    'class' => 'select2-parameters select2-multiple-options-custom ',
                    'required' => true
                ],
        ];

        $datagridMapper
            ->add(
                'tipo',
                'doctrine_orm_callback',
                $formGridOptions['tipo'],
                'choice',
                $formGridOptions['tipoChoices']
            )
            ->add(
                'codContrato',
                'doctrine_orm_callback',
                $formGridOptions['fkPessoalContratoServidor'],
                'autocomplete',
                $formGridOptions['fkPessoalContratoServidorChoices']
            )->add(
                'lotacao',
                'doctrine_orm_callback',
                $formGridOptions['lotacao'],
                'choice',
                $formGridOptions['lotacaoChoices']
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'nomCgm',
                'customField',
                [
                    'label' => 'Servidor',
                    'mapped' => false,
                    'template' => 'RecursosHumanosBundle:Pessoal\Contrato:contratoServidor.html.twig',
                ]
            )
            ->add(
                'registro',
                null,
                [
                    'label' => 'label.matricula',
                ]
            );
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('codContrato')
            ->add('registro');
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        /** @var ContratoModel $contratoModel */
        $contratoModel = new ContratoModel($entityManager);

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $codPeriodoMovimentacao = $periodoFinal->getCodPeriodoMovimentacao();

        $stFiltro = " AND cod_periodo_movimentacao = " . $codPeriodoMovimentacao;
        $orderBy = " nom_cgm,numcgm";

        /** @var EntityManager $logErroCalculoDecimoModel */
        $logErroCalculoDecimoModel = new LogErroCalculoDecimoModel($entityManager);

        $contratoListErrors = $logErroCalculoDecimoModel->recuperaContratosComErro($stFiltro, $orderBy);

        $dtInicial = $periodoFinal->getDtInicial();
        $arMes = explode("/", $dtInicial->format('d/m/Y'));
        $arDescMes = ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

        $contratos = $this->getRequest()->get('codContratos');
        $contratosSuccess = $this->getRequest()->get('success');
        $contratosGeral = $this->getRequest()->get('codContratos');

        $calculadas = explode(",", $contratosGeral);
        $calculadasSuccess = explode(",", $contratosSuccess);
        $calculadasErrors = count($contratoListErrors);

        $contratosSuccess = (empty($contratosSuccess)) ? 0 : $contratosSuccess;
        $contratoList = $entityManager->getRepository("CoreBundle:Pessoal\Contrato")
            ->montaRecuperaContratosReport($contratosSuccess);

        /** @var Contrato $contrato */
        $contrato = $this->getSubject();
        $contrato->competencia = $arDescMes[($arMes[1] - 1)] . '/' . $arMes[2];

        $contrato->calculadas = count($calculadas);
        $contrato->calculadasSuccess = count($calculadasSuccess);
        $contrato->calculadasErrors = $calculadasErrors;
        $contrato->codPeriodoMovimentacao = $codPeriodoMovimentacao;
        $contrato->contratosSuccess = $contratoList;
        $contrato->contratosErrors = $contratoListErrors;
        $contrato->contratoStr = $contratos;
        $contrato->inCodConfiguracao = ContratoModel::FOLHA_COD_CONFIGURACAO_DECIMO;
        $contrato->inCodAcao = AcaoModel::CALCULAR_DECIMO;
        $contrato->link = 'urbem_recursos_humanos_folha_pagamento_folhas_calculo_decimo_list';

        $showMapper
            ->add('codContrato')
            ->add('registro');
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     *
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        /** @var ContratoModel $contratoModel */
        $contratoModel = new ContratoModel($entityManager);
        /** @var ConcessaoDecimoModel $concessaoDecimoModel */
        $concessaoDecimoModel = new ConcessaoDecimoModel($entityManager);

        $contratos = $contratosNew = [];

        $filter = $this->getDataGrid()->getValues();

        if (!$value['value']) {
            return;
        }

        $paramsBo["boAtivos"] = true;
        $paramsBo["boAposentados"] = true;
        $paramsBo["boRescindidos"] = false;
        $paramsBo["boPensionistas"] = true;
        $paramsBo["stTipoFolha"] = ContratoModel::TIPO_FOLHA_DECIMO;

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();

        if (empty($periodoUnico)) {
            $message = $this->getTranslator()->trans('recursosHumanos.folhaSituacao.errors.periodoMovimentacaoNaoAberto', [], 'validators');
            $this->getRequest()->getSession()->getFlashBag()->add("error", $message);
            $this->redirectByRoute('folha_pagamento_folhas_index');
        }

        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        if (isset($filter['tipo']['value'])) {
            $queryBuilder->resetDQLPart('where');
        }

        // FILTRO GERAL
        if (isset($filter['tipo']['value']) && ($filter['tipo']['value'] == 'geral')) {
            unset($filter['lotacao']['value']);
            unset($filter['codContrato']['value']);
            unset($filter['local']['value']);

            $contratoList = $contratoModel->montaRecuperaContratosCalculoFolha(
                $paramsBo,
                $periodoFinal->getCodPeriodoMovimentacao(),
                '',
                [],
                [],
                []
            );

            foreach ($contratoList as $contrato) {
                array_push(
                    $contratos,
                    $contrato['cod_contrato']
                );
            }

            if (empty($contratoList)) {
                $queryBuilder->andWhere('true = false');

                return true;
            }

            $queryBuilder->andWhere($queryBuilder->expr()->in('o.codContrato', $contratos));

            return true;
        }

        // FILTRO POR LOTAÇÃO
        if ($filter['tipo']['value'] == 'lotacao') {
            /** @var OrganogramaModel $organogramaModel */
            $organogramaModel = new OrganogramaModel($entityManager);
            /** @var OrgaoModel $orgaoModel */
            $orgaoModel = new OrgaoModel($entityManager);

            $resOrganograma = $organogramaModel->getOrganogramaVigentePorTimestamp();
            $codOrganograma = $resOrganograma['cod_organograma'];
            $dataFinal = $resOrganograma['dt_final'];
            $lotacoes = $orgaoModel->montaRecuperaOrgaos($dataFinal, $codOrganograma);

            $lotacaoArray = [];
            foreach ($lotacoes as $lotacao) {
                $key = $lotacao->cod_orgao;
                $value = $lotacao->cod_estrutural . " - " . $lotacao->descricao;
                $lotacaoArray[$value] = $key;
            }

            $contratosArray = $contratoModel->montaRecuperaContratosCalculoFolha(
                $paramsBo,
                $periodoFinal->getCodPeriodoMovimentacao(),
                '',
                [],
                $lotacaoArray,
                []
            );

            foreach ($contratosArray as $contrato) {
                array_push(
                    $contratos,
                    $contrato['cod_contrato']
                );
            }

            if (isset($filter['lotacao']['value'])) {
                $contratosSelecionados = $filter['lotacao']['value'];
                $contratosNew = $contratoModel->montaRecuperaContratosCalculoFolha(
                    $paramsBo,
                    $periodoFinal->getCodPeriodoMovimentacao(),
                    '',
                    [],
                    $contratosSelecionados,
                    []
                );

                if (empty($contratosNew)) {
                    $queryBuilder->resetDQLPart('where');
                    $queryBuilder->andWhere('true = false');

                    return true;
                }

                $contratos = $contratosNew;
            }
            if (empty($contratosArray)) {
                $queryBuilder->andWhere('true = false');

                return true;
            }

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.codContrato', $contratos)
            );

            return true;
        }

        // FILTRO POR MATRICULA
        if ($filter['tipo']['value'] == 'cgm_contrato') {
            $contratoList = $contratoModel->montaRecuperaContratosCalculoFolha(
                $paramsBo,
                $periodoFinal->getCodPeriodoMovimentacao(),
                '',
                [],
                [],
                []
            );

            foreach ($contratoList as $contrato) {
                array_push(
                    $contratos,
                    $contrato['cod_contrato']
                );
            }
            if (!empty($filter['codContrato']['value'])) {
                $contratosSelecionados = $filter['codContrato']['value'];

                foreach ($contratosSelecionados as $contrato) {
                    if (in_array($contrato, $contratos)) {
                        array_push(
                            $contratosNew,
                            $contrato
                        );
                    }
                }

                if (empty($contratosNew)) {
                    $queryBuilder->resetDQLPart('where');
                    $queryBuilder->andWhere('true = false');

                    return true;
                }

                $contratos = $contratosNew;
            }

            if (empty($contratoList)) {
                $queryBuilder->andWhere('true = false');

                return true;
            }

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.codContrato', $contratos)
            );

            return true;
        }
    }

    /**
     * @return array
     */
    public function getBatchActions()
    {
        $actions['calcularDecimo'] = array(
            'label' => $this->trans('label.recursosHumanos.folhas.folhaDecimo.calcular', array(), 'CoreBundle'),
            'ask_confirmation' => true,
        );

        return $actions;
    }

    /**
     * @param Contrato $contrato
     *
     * @return string
     */
    public function getServidor($contrato)
    {
        if (is_null($contrato)) {
            return '';
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        /** @var ContratoServidor $contratoServidor */
        $contratoServidor = (new ContratoServidorModel($entityManager))->findOneByCodContrato($contrato->getCodContrato());

        if (!is_null($contratoServidor)) {
            return $contratoServidor->getFkPessoalServidorContratoServidores()->last()
                    ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNumcgm()
                . " - "
                . $contratoServidor->getFkPessoalServidorContratoServidores()->last()
                    ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomcgm();
        }

        /** @var ContratoPensionista $contratoPensionista */
        $contratoPensionista = $entityManager->getRepository(ContratoPensionista::class)->findOneByCodContrato($contrato->getCodContrato());

        if (!is_null($contratoPensionista)) {
            return $contratoPensionista->getFkPessoalPensionista()->getFkSwCgmPessoaFisica()->getNumcgm()
                . " - "
                . $contratoPensionista->getFkPessoalPensionista()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomcgm();
        }

        return '';
    }
}
