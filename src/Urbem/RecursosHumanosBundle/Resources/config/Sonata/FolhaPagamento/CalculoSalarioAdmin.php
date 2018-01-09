<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Model\Administracao\AcaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\LogErroCalculoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoPeriodoModel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class CalculoSalarioAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_folhas_calculo_salario';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/folhas/calculo-salario';
    protected $exibirBotaoIncluir = false;
    protected $exibirMensagemFiltro = true;

    /**
     * @param string $name
     *
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'RecursosHumanosBundle:Sonata\FolhaPagamento\CalculoSalario\CRUD:list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->add('gera_relatorio_ficha_financeira', '{id}/gera-relatorio-ficha-financeira');
        $collection->add('recalcular', '{id}/recalcular');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/folhapagamento/calculoSalario.js',
        ]));

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

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
            'local' => 'local',
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
                'class' => 'select2-parameters ',
            ],
        ];

        $formGridOptions['fkPessoalContratoServidor'] = [
            'label' => 'label.cgmmatricula',
            'callback' => [
                $this,
                'getSearchFilter'
            ],
            'required' => true,
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
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
            'mapped' => false,
        ];

        $formGridOptions['lotacao'] = [
            'label' => 'label.recursosHumanos.folhas.grid.lotacao',
            'callback' => [$this, 'getSearchFilter'],
            'required' => true,
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
        ];

        $formGridOptions['lotacaoChoices'] = [
            'choices' => $lotacaoArray,
            'expanded' => false,
            'multiple' => true,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
        ];

        $formGridOptions['local'] = [
            'label' => 'label.recursosHumanos.folhas.grid.local',
            'callback' => [$this, 'getSearchFilter'],
            'required' => true,
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
        ];

        $formGridOptions['localChoices'] = [
            'class' => Local::class,
            'expanded' => false,
            'multiple' => true,
            'attr' => ['class' => 'select2-parameters select2-multiple-options-custom '],
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
            )->add(
                'local',
                'doctrine_orm_callback',
                $formGridOptions['local'],
                'entity',
                $formGridOptions['localChoices']
            );
    }

    /**
     * @param string $context
     *
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $query = parent::createQuery($context);

        $contratoList = $entityManager->getRepository("CoreBundle:Pessoal\Contrato")
            ->getContratoNotRescindido('');

        $contratos = array();

        foreach ($contratoList as $contrato) {
            array_push(
                $contratos,
                $contrato->cod_contrato
            );
        }

        $query->andWhere($query->expr()->in('o.codContrato', $contratos));
        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere("{$query->getRootAliases()[0]}.codContrato = :codContrato")->setParameters(['codContrato' => 0]);
        }

        return $query;
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
        $contratoModel = new ContratoModel($entityManager);

        $filter = $this->getDataGrid()->getValues();

        if (!$value['value']) {
            return;
        }

        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);
        /** @var RegistroEventoPeriodoModel $registroEventoPeriodoModel */
        $registroEventoPeriodoModel = new RegistroEventoPeriodoModel($entityManager);

        $paramsBo["boAtivos"] = true;
        $paramsBo["boAposentados"] = true;
        $paramsBo["boRescindidos"] = false;
        $paramsBo["boPensionistas"] = true;
        $paramsBo["stTipoFolha"] = ContratoModel::TIPO_FOLHA_SALARIO;

        $contratos = $contratosMovimentacao = [];
        if (isset($filter['tipo']['value'])) {
            $queryBuilder->resetDQLPart('where');
        }

        // FILTRO GERAL
        if (isset($filter['tipo']['value']) && ($filter['tipo']['value'] == 'geral')) {
            unset($filter['lotacao']['value']);
            unset($filter['codContrato']['value']);
            unset($filter['local']['value']);

            $contratoList = $registroEventoPeriodoModel->montaRecuperaContratosAutomaticos($periodoFinal->getCodPeriodoMovimentacao());

            if (empty($contratoList)) {
                $queryBuilder->andWhere('true = false');

                return true;
            }

            foreach ($contratoList as $contrato) {
                array_push(
                    $contratos,
                    $contrato['cod_contrato']
                );
            }

            $queryBuilder->andWhere($queryBuilder->expr()->in('o.codContrato', $contratos));

            return true;
        }

        // FILTRO POR LOTAÇÃO
        if (isset($filter['lotacao']['value'])) {
            $contratosArray = $contratoModel->montaRecuperaContratosCalculoFolha(
                $paramsBo,
                $periodoFinal->getCodPeriodoMovimentacao(),
                '',
                [],
                $filter['lotacao']['value'],
                []
            );

            foreach ($contratosArray as $contrato) {
                array_push(
                    $contratos,
                    $contrato['cod_contrato']
                );
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

        // FILTRO POR LOCAL
        if (isset($filter['local']['value'])) {
            $contratosArray = $contratoModel->montaRecuperaContratosCalculoFolha(
                $paramsBo,
                $periodoFinal->getCodPeriodoMovimentacao(),
                '',
                $filter['local']['value'],
                [],
                []
            );

            foreach ($contratosArray as $contrato) {
                array_push(
                    $contratos,
                    $contrato['cod_contrato']
                );
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
            if (!empty($filter['codContrato']['value'])) {
                $contratoSelected = $filter['codContrato']['value'];
                foreach ($contratoSelected as $contrato) {
                    $filtro = " AND contrato.cod_contrato = $contrato";
                    $cgm = $contratoModel->recuperaCgmDoRegistro($filtro);
                    array_push(
                        $contratos,
                        $cgm[0]['numcgm']
                    );
                }
            } else {
                $contratoList = $entityManager->getRepository("CoreBundle:Pessoal\Contrato")
                    ->getContratoNotRescindido('');

                foreach ($contratoList as $contrato) {
                    $filtro = " AND contrato.registro = $contrato->getRegistro()";
                    $cgm = $contratoModel->recuperaCgmDoRegistro($filtro);
                    array_push(
                        $contratos,
                        $cgm[0]['numcgm']
                    );
                }
            }

            $contratos = implode(",", $contratos);
            $contratoList = $registroEventoPeriodoModel->montaRecuperaContratosAutomaticos($periodoFinal->getCodPeriodoMovimentacao(), $contratos);

            if (empty($contratoList)) {
                $queryBuilder->andWhere('true = false');

                return true;
            }

            foreach ($contratoList as $contrato) {
                array_push(
                    $contratosMovimentacao,
                    $contrato['cod_contrato']
                );
            }

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.codContrato', $contratosMovimentacao)
            );

            return true;
        }

        // FILTRO POR EVENTO
        if (!empty($filter['evento']['value'])) {
            $contratosArray = $contratoModel->montaRecuperaContratosCalculoFolha(
                $paramsBo,
                $periodoFinal->getCodPeriodoMovimentacao(),
                '',
                [],
                [],
                $filter['evento']['value']
            );

            foreach ($contratosArray as $contrato) {
                array_push(
                    $contratos,
                    $contrato['cod_contrato']
                );
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
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'codContrato',
                null,
                [
                    'label' => 'label.codContrato',
                ]
            )
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

        /** @var LogErroCalculoModel $logErroCalculoModel */
        $logErroCalculoModel = new LogErroCalculoModel($entityManager);

        $stFiltro = " AND cod_periodo_movimentacao = " . $codPeriodoMovimentacao;
        $orderBy = " nom_cgm,numcgm";
        $contratoListErrors = $logErroCalculoModel->recuperaErrosDoContrato($stFiltro, $orderBy);

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
        $contrato->inCodConfiguracao = ContratoModel::FOLHA_COD_CONFIGURACAO_SALARIO;
        $contrato->inCodAcao = AcaoModel::CALCULAR_SALARIO;
        $contrato->link = 'urbem_recursos_humanos_folha_pagamento_folhas_calculo_salario_list';

        $showMapper
            ->add('codContrato')
            ->add('registro');
    }

    public function getBatchActions()
    {
        $actions = parent::getBatchActions();

        $actions['calcularSalario'] = array(
            'label' => $this->trans('label.recursosHumanos.folhas.folhaSalario.calcular', array(), 'CoreBundle'),
            'ask_confirmation' => true
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
