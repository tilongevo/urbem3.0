<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Pessoal\Cargo;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\Especialidade;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PadraoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoDecimoModel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ContratoServidorPeriodoDecimoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_periodo_decimo';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/contrato-servidor-periodo-decimo';
    protected $exibirMensagemFiltro = true;
    protected $exibirBotaoIncluir = false;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/folhapagamento/contratoServidorPeriodoDecimo.js',
        ]));

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        /** @var OrganogramaModel $organogramaModel */
        $organogramaModel = new OrganogramaModel($em);
        /** @var OrgaoModel $orgaoModel */
        $orgaoModel = new OrgaoModel($em);

        $resOrganograma = $organogramaModel->getOrganogramaVigentePorTimestamp();
        $codOrganograma = $resOrganograma['cod_organograma'];
        $dataFinal = $resOrganograma['dt_final'];
        $lotacoes = $orgaoModel->montaRecuperaOrgaos($dataFinal, $codOrganograma);

        $lotacaoArray = $padraoArray = [];
        foreach ($lotacoes as $lotacao) {
            $key = $lotacao->cod_orgao;
            $value = $lotacao->cod_estrutural . " - " . $lotacao->descricao;
            $lotacaoArray[$value] = $key;
        }

        /** @var PadraoModel $padraoModel */
        $padraoModel = new PadraoModel($em);
        $padroes = $padraoModel->getPadraoFilter();

        foreach ($padroes as $padrao) {
            $padraoArray[$padrao->cod_padrao . " - " . $padrao->descricao] = $padrao->cod_padrao;
        }

        $formGridOptions = [];

        $opcoes = [
            'cgm' => 'cgm_contrato',
            'lotacao' => 'lotacao',
            'local' => 'local',
            'Cargo' => 'cargo',
            'Função' => 'funcao',
            'Padrão' => 'padrao',
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

        $formGridOptions['lotacao'] = [
            'label' => 'label.recursosHumanos.folhas.grid.lotacao',
            'callback' => [$this, 'getSearchFilter'],
            'required' => true,
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters ', 'required' => true],
        ];

        $formGridOptions['lotacaoChoices'] = [
            'choices' => $lotacaoArray,
            'expanded' => false,
            'multiple' => false,
            'attr' => ['class' => 'select2-parameters ', 'required' => true],
        ];

        $formGridOptions['local'] = [
            'label' => 'label.recursosHumanos.folhas.grid.local',
            'callback' => [$this, 'getSearchFilter'],
            'required' => true,
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters ', 'required' => true],
        ];

        $formGridOptions['localChoices'] = [
            'class' => Local::class,
            'expanded' => false,
            'multiple' => false,
            'attr' => ['class' => 'select2-parameters ', 'required' => true],
        ];

        $formGridOptions['padrao'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.padrao',
            'callback' => [$this, 'getSearchFilter'],
            'required' => true,
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters ', 'required' => true],
        ];

        $formGridOptions['padraoChoices'] = [
            'choices' => $padraoArray,
            'expanded' => false,
            'multiple' => false,
            'attr' => ['class' => 'select2-parameters ', 'required' => true],
            'mapped' => false,
        ];

        $formGridOptions['cargo'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.cargo',
            'callback' => [$this, 'getSearchFilter'],
            'required' => true,
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters ', 'required' => true],
        ];

        $formGridOptions['cargoChoices'] = [
            'class' => Cargo::class,
            'route' => [
                'name' => 'api_search_cargo_especialidade'
            ],
            'attr' => [
                'class' => 'select2-parameters ', 'required' => true
            ],
            'mapped' => false,
        ];

        $formGridOptions['especialidade'] = [
            'label' => 'label.recursosHumanos.relatorios.folha.customizavelEventos.especialidade',
            'callback' => [$this, 'getSearchFilter'],
            'required' => true,
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters '],
        ];

        $formGridOptions['especialidadeChoices'] = [
            'choices' => [],
            'expanded' => false,
            'multiple' => false,
            'attr' => ['class' => 'select2-parameters '],
            'mapped' => false,
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
                [
                    'label' => 'label.matricula',
                    'callback' => [$this, 'getSearchFilter'],
                ],
                'autocomplete',
                [
                    'class' => Contrato::class,
                    'route' => [
                        'name' => 'carrega_contrato_decimo'
                    ],
                    'json_choice_label' => function ($contrato) use ($em) {
                        if (is_null($contrato)) {
                            return '';
                        }

                        /** @var EntityManager $entityManager */
                        $entityManager = $em;
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
                    },
                    'attr' => [
                        'class' => 'select2-parameters ', 'required' => true
                    ],
                ]
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
            )->add(
                'padrao',
                'doctrine_orm_callback',
                $formGridOptions['padrao'],
                'choice',
                $formGridOptions['padraoChoices']
            )->add(
                'cargo',
                'doctrine_orm_callback',
                $formGridOptions['cargo'],
                'autocomplete',
                $formGridOptions['cargoChoices']
            )->add(
                'especialidade',
                'doctrine_orm_callback',
                $formGridOptions['especialidade'],
                'choice',
                $formGridOptions['especialidadeChoices']
            );
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
        /** @var RegistroEventoDecimoModel $registroEventoDecimoModel */
        $registroEventoDecimoModel = new RegistroEventoDecimoModel($entityManager);
        $entidade = '';

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $exercicio = $this->getExercicio();

        $filter = $this->getDataGrid()->getValues();

        // FILTRO POR CARGO/FUNÇÃO
        if (in_array($filter['tipo']['value'], ['cargo', 'funcao'])) {
            if (isset($filter['cargo']['value']) && ($filter['cargo']['value'] != '')) {
                $cargos = $filter['cargo']['value'];

                $stFiltro = "  AND servidor.cod_cargo = " . $cargos;
                //FILTRO POR ESPECIALIDADE DO CARGO/FUNÇÃO
                if (isset($filter['especialidade']['value']) && $filter['especialidade']['value'] != '') {
                    $stFiltro .= " AND servidor.cod_especialidade_cargo = " . $filter['especialidade']['value'];
                }
                $contratoList = $registroEventoDecimoModel->recuperaContratosDoFiltro($exercicio, $entidade, false, $stFiltro);

                if (!empty($contratoList)) {
                    foreach ($contratoList as $contrato) {
                        $contratos[] = $contrato['cod_contrato'];
                    }
                    $queryBuilder->resetDQLPart('where');
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->in('o.codContrato', $contratos)
                    );
                }
            }

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere('true = false');
        }
        // FILTRO POR MATRICULA
        if ($filter['tipo']['value'] == 'cgm_contrato' && isset($filter['codContrato']['value'])) {
            if (isset($filter['codContrato']['value']) && ($filter['codContrato']['value'] != '')) {
                $contratosSelected = $filter['codContrato']['value'];

                /** @var Contrato $contratoObject */
                $contratoObject = $entityManager->getRepository(Contrato::class)->findOneBy(
                    [
                        'codContrato' => $contratosSelected
                    ]
                );

                $stFiltro = " AND  registro = " . $contratoObject->getRegistro();

                $contratoList = $registroEventoDecimoModel->recuperaContratosDoFiltro($exercicio, $entidade, false, $stFiltro);

                if (!empty($contratoList)) {
                    foreach ($contratoList as $contrato) {
                        $contratos[] = $contrato['cod_contrato'];
                    }
                    $queryBuilder->resetDQLPart('where');
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->in('o.codContrato', $contratos)
                    );
                }
            }

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere('true = false');
        }

        if ($filter['tipo']['value'] == 'local' && isset($filter['local']['value'])) {
            $locais = $filter['local']['value'];

            $stFiltro = "  AND servidor.cod_local = '" . $locais . "'";
            $contratoList = $registroEventoDecimoModel->recuperaContratosDoFiltro($exercicio, $entidade, false, $stFiltro);
            if (!empty($contratoList)) {
                foreach ($contratoList as $contrato) {
                    $contratos[] = $contrato['cod_contrato'];
                }
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->in('o.codContrato', $contratos)
                );
            } else {
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere('true = false');
            }
        }

        if ($filter['tipo']['value'] == 'padrao' && isset($filter['padrao']['value'])) {
            $locais = $filter['padrao']['value'];

            $stFiltro = "  AND servidor.cod_padrao = '" . $locais . "'";
            $contratoList = $registroEventoDecimoModel->recuperaContratosDoFiltro($exercicio, $entidade, false, $stFiltro);
            if (!empty($contratoList)) {
                foreach ($contratoList as $contrato) {
                    $contratos[] = $contrato['cod_contrato'];
                }
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->in('o.codContrato', $contratos)
                );
            } else {
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere('true = false');
            }
        }

        if ($filter['tipo']['value'] == 'lotacao' && isset($filter['lotacao']['value'])) {
            $lotacoes = $filter['lotacao']['value'];

            $stFiltro = "  AND vw_orgao_nivel.orgao = '" . $lotacoes . "'";
            $contratoList = $registroEventoDecimoModel->recuperaContratosDoFiltro($exercicio, $entidade, false, $stFiltro);
            if (!empty($contratoList)) {
                foreach ($contratoList as $contrato) {
                    $contratos[] = $contrato['cod_contrato'];
                }
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere(
                    $queryBuilder->expr()->in('o.codContrato', $contratos)
                );
            } else {
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere('true = false');
            }
        }

        $queryBuilder->andWhere("fc.codPeriodoMovimentacao = {$periodoFinal->getCodPeriodoMovimentacao()}");

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add(
                'fkPessoalContrato',
                'customField',
                [
                    'label' => 'Servidor',
                    'mapped' => false,
                    'template' => 'RecursosHumanosBundle:Pessoal\Contrato:contratoServidor.html.twig',
                    'admin_code' => 'recursos_humanos.admin.contrato_servidor'
                ]
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                )
            ));
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

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $query->innerJoin('o.fkFolhapagamentoPeriodoMovimentacao', 'fc');
        $query->andWhere("fc.codPeriodoMovimentacao = {$periodoFinal->getCodPeriodoMovimentacao()}");
        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere("{$query->getRootAliases()[0]}.codContrato = :codContrato")->setParameters(['codContrato' => 0]);
        }

        return $query;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $eventoModel = new EventoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();

        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);
        $dtInicial = $periodoFinal->getDtInicial();
        $dtFinal = $periodoFinal->getDtFinal();
        $arMes = explode("/", $dtInicial->format('d/m/Y'));
        $arDescMes = ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

        /** @var ContratoServidorPeriodo $contratoServidorPeridoDecimo */
        $contratoServidorPeridoDecimo = $this->getSubject();
        $contratoServidorPeridoDecimo->periodo = $dtInicial->format('d/m/Y') . ' à ' . $dtFinal->format('d/m/Y');
        $contratoServidorPeridoDecimo->competencia = $arDescMes[($arMes[1] - 1)] . '/' . $arMes[2];
        $contratoServidorPeridoDecimo->matricula = $contratoServidorPeridoDecimo->getFkPessoalContrato()->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
            ->getFkPessoalServidor()
            ->getFkSwCgmPessoaFisica()
            ->getFkSwCgm();

        /** @var RegistroEventoDecimoModel $registroEventoDecimoModel */
        $registroEventoDecimoModel = new RegistroEventoDecimoModel($em);
        $stFiltro = " AND cod_contrato =  " . $contratoServidorPeridoDecimo->getFkPessoalContrato()->getCodContrato() . "
         AND cod_periodo_movimentacao = " . $periodoFinal->getCodPeriodoMovimentacao() . " 
         AND evento.natureza != 'B'";
        $eventosCadastrados = $registroEventoDecimoModel->montaRecuperaRelacionamento($stFiltro);

        $arEventosFixos = $arEventosBases = [];
        foreach ($eventosCadastrados as $key => $eventos) {
            if ($eventos['evento_sistema'] == false) {
                $arEventosFixos[] = $eventos;
            }

            $rsEvento = $eventoModel->listarEvento($eventos['cod_evento']);
            $rsEventoBase = $eventoModel->listarEventosBase($eventos['cod_evento'], $rsEvento[0]['timestamp']);

            if (is_array($rsEventoBase)) {
                foreach ($rsEventoBase as $bases) {
                    $rsEventosBasePai = $eventoModel->listarEvento($bases['cod_evento']);
                    $rsEvento = $eventoModel->listarEvento($bases['cod_evento_base']);

                    $arElementos = [];
                    $arElementos['codigo'] = $rsEventosBasePai[0]['codigo'];
                    $arElementos['descricao'] = $rsEvento[0]['descricao'];
                    $arElementos['valor'] = $rsEvento[0]['valor_quantidade'];
                    $arElementos['quantidade'] = $rsEvento[0]['unidade_quantitativa'];
                    $arElementos['inCodRegistro'] = $eventos['cod_registro'];
                    $arElementos['inCodigo'] = $rsEventosBasePai[0]['codigo'];
                    $arEventosBases[] = $arElementos;
                }
            }
        }

        $configuracaoModel = new ConfiguracaoModel($em);
        $boBase = $configuracaoModel->getConfiguracao('apresenta_aba_base', ConfiguracaoModel::MODULO_RH_FOLHAPAGAMENTO, true);
        $apresentaAbaBase = ($boBase == 'true') ? true : false;

        $contratoServidorPeridoDecimo->apresentaAbaBase = $apresentaAbaBase;
        $contratoServidorPeridoDecimo->eventosFixos = $arEventosFixos;
        $contratoServidorPeridoDecimo->eventosBases = $arEventosBases;

        $showMapper
            ->add('codContrato');
    }

    /**
     * @param ContratoServidorPeriodo $contratoServidorPeriodo
     *
     * @return string
     */
    public function getServidor($contratoServidorPeriodo)
    {
        if (is_null($contratoServidorPeriodo)) {
            return '';
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $contratoServidor = (new ContratoServidorModel($entityManager))->findOneByCodContrato($contratoServidorPeriodo->getCodContrato());

        if (is_null($contratoServidorPeriodo->getFkPessoalContrato()->getFkPessoalContratoServidor())) {
            return '';
        }

        return $contratoServidorPeriodo->getFkPessoalContrato()->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
                ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNumcgm()
            . " - "
            . $contratoServidorPeriodo->getFkPessoalContrato()->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
                ->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomcgm();
    }
}
