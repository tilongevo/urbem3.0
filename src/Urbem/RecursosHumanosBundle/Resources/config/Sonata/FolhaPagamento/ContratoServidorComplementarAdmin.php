<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Folhapagamento\Complementar;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaOrgao;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorOrgao;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorSituacao;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\PadraoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoComplementarModel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ContratoServidorComplementarAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_contrato_servidor_complementar';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/contrato-servidor-complementar';
    protected $exibirBotaoIncluir = false;
    protected $exibirMensagemFiltro = false;

    const COD_FILTRAR_CGM_MATRICULA = 'cgm_contrato';
    const COD_FILTRAR_CARGO = 'cargo';
    const COD_FILTRAR_FUNCAO = 'funcao';
    const COD_FILTRAR_PADRAO = 'padrao';
    const COD_FILTRAR_LOTACAO = 'lotacao';
    const COD_FILTRAR_LOCAL = 'local';

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'show']);

        $collection->add('consultar_subdivisoes', 'consultar-subdivisoes');
        $collection->add('consultar_cargos', 'consultar-cargos');
        $collection->add('consultar_especialidade', 'consultar-especialidade');
    }

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

        $dtAtual = new \DateTime();

        $resOrganograma = (new OrganogramaModel($em))->getOrganogramaVigentePorTimestamp();
        $codOrganograma = $resOrganograma['cod_organograma'];
        $lotacoes = (new OrgaoModel($em))->montaRecuperaOrgaos($dtAtual->format('Y-m-d'), $codOrganograma);

        $lotacaoOptions = array();
        foreach ($lotacoes as $lotacao) {
            $lotacaoOptions[$lotacao->cod_orgao] = sprintf('%s - %s', $lotacao->cod_estrutural, $lotacao->descricao);
        }

        $opcoes = [
            self::COD_FILTRAR_CGM_MATRICULA => 'label.recursosHumanos.contratoServidorComplementar.cgmmatricula',
            self::COD_FILTRAR_CARGO => 'label.recursosHumanos.contratoServidorComplementar.cargo',
            self::COD_FILTRAR_FUNCAO => 'label.recursosHumanos.contratoServidorComplementar.funcao',
            self::COD_FILTRAR_PADRAO => 'label.recursosHumanos.contratoServidorComplementar.padrao',
            self::COD_FILTRAR_LOTACAO => 'label.recursosHumanos.contratoServidorComplementar.lotacao',
            self::COD_FILTRAR_LOCAL => 'label.recursosHumanos.contratoServidorComplementar.local'
        ];

        $padroes = (new PadraoModel($em))->getPadraoFilter();

        $padraoOptions = array();
        foreach ($padroes as $padrao) {
            $padraoOptions[$padrao->cod_padrao] = sprintf('%s - %s', $padrao->cod_padrao, $padrao->descricao);
        }

        $datagridMapper
            ->add(
                'tipo',
                'doctrine_orm_callback',
                [
                    'label' => 'label.recursosHumanos.contratoServidorComplementar.filtrar',
                    'mapped' => false,
                    'callback' => [$this, 'getSearchFilter']
                ],
                'choice',
                [
                    'choices' => array_flip($opcoes),
                    'expanded' => false,
                    'multiple' => false,
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'required' => true,
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add(
                'codContrato',
                'doctrine_orm_callback',
                [
                    'label' => 'label.matricula',
                    'callback' => [$this, 'getSearchFilter'],
                    'mapped' => false,
                    'required' => true
                ],
                'autocomplete',
                [
                    'class' => Contrato::class,
                    'route' => [
                        'name' => 'carrega_contrato_decimo'
                    ],
                    'attr' => [
                        'class' => 'select2-parameters ', 'required' => true
                    ],
                ]
            )
            ->add(
                'lotacao',
                'doctrine_orm_callback',
                [
                    'label' => 'label.recursosHumanos.contratoServidorComplementar.lotacao',
                    'callback' => [$this, 'getSearchFilter'],
                    'mapped' => false,
                    'required' => true
                ],
                'choice',
                [
                    'choices' => array_flip($lotacaoOptions),
                    'expanded' => false,
                    'multiple' => false,
                    'attr' => ['class' => 'select2-parameters ', 'required' => true],
                ]
            )
            ->add(
                'local',
                'doctrine_orm_callback',
                [
                    'label' => 'label.recursosHumanos.contratoServidorComplementar.local',
                    'callback' => [$this, 'getSearchFilter'],
                    'mapped' => false,
                    'required' => true
                ],
                'entity',
                [
                    'class' => Local::class,
                    'expanded' => false,
                    'multiple' => false,
                    'attr' => ['class' => 'select2-parameters ', 'required' => true]
                ]
            )
            ->add(
                'padrao',
                'doctrine_orm_callback',
                [
                    'label' => 'label.recursosHumanos.contratoServidorComplementar.padrao',
                    'callback' => [$this, 'getSearchFilter'],
                    'mapped' => false,
                    'required' => true
                ],
                'choice',
                [
                    'choices' => array_flip($padraoOptions),
                    'expanded' => false,
                    'multiple' => false,
                    'attr' => ['class' => 'select2-parameters ', 'required' => true],
                    'mapped' => false,
                ]
            )
            ->add(
                'cargo',
                'doctrine_orm_callback',
                [
                    'label' => 'label.recursosHumanos.contratoServidorComplementar.cargo',
                    'callback' => [$this, 'getSearchFilter'],
                    'mapped' => false,
                    'required' => true
                ],
                'autocomplete',
                [
                    'route' => ['name' => 'api_search_cargo_especialidade'],
                    'attr' => ['class' => 'select2-parameters ', 'required' => true],
                    'mapped' => false
                ]
            )
            ->add(
                'especialidade',
                'doctrine_orm_callback',
                [
                    'label' => 'label.recursosHumanos.contratoServidorComplementar.especialidade',
                    'callback' => [$this, 'getSearchFilter'],
                    'mapped' => false
                ],
                'choice',
                [
                    'choices' => [],
                    'expanded' => false,
                    'multiple' => false,
                    'attr' => ['class' => 'select2-parameters '],
                    'mapped' => false
                ]
            )
        ;
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

        if (!$value['value']) {
            return;
        }

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $contratoModel = new ContratoModel($em);

        if ((isset($filter['tipo']['value'])) && ($filter['tipo']['value'] != '')) {
            if ($filter['tipo']['value'] == self::COD_FILTRAR_CGM_MATRICULA) {
                $queryBuilder->resetDQLPart('where');
                $queryBuilder->andWhere('o.codContrato = :codContrato');
                $queryBuilder->setParameter('codContrato', $filter['codContrato']['value']);
            } elseif ($filter['tipo']['value'] == self::COD_FILTRAR_CARGO) {
                $valor = str_replace('~', '#', $filter['cargo']['value']);
                if ((isset($filter['especialidade']['value'])) && ($filter['especialidade']['value'] != '')) {
                    $valor .= sprintf('#%s', $filter['especialidade']['value']);
                }

                $resFiltro = $contratoModel->filtraContratoServidor('reg_sub_car_esp', $valor);
                $contratos = array();
                if (count($resFiltro)) {
                    $contratos = array_column($resFiltro, 'cod_contrato');
                    $queryBuilder->resetDQLPart('where');
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->in('o.codContrato', $contratos)
                    );
                }
            } elseif ($filter['tipo']['value'] == self::COD_FILTRAR_FUNCAO) {
                $valor = str_replace('~', '#', $filter['cargo']['value']);
                if ((isset($filter['especialidade']['value'])) && ($filter['especialidade']['value'] != '')) {
                    $valor .= sprintf('#%s', $filter['especialidade']['value']);
                }

                $resFiltro = $contratoModel->filtraContratoServidor('reg_sub_fun_esp', $valor);
                $contratos = array();
                if (count($resFiltro)) {
                    $contratos = array_column($resFiltro, 'cod_contrato');
                    $queryBuilder->resetDQLPart('where');
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->in('o.codContrato', $contratos)
                    );
                } else {
                    $queryBuilder->andWhere('1 = 0');
                }
            } elseif ($filter['tipo']['value'] == self::COD_FILTRAR_LOTACAO) {
                $resFiltro = $contratoModel->filtraContratoServidor('lotacao', $filter['lotacao']['value'], $this->getExercicio());
                $contratos = array();
                if (count($resFiltro)) {
                    $contratos = array_column($resFiltro, 'cod_contrato');
                    $queryBuilder->resetDQLPart('where');
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->in('o.codContrato', $contratos)
                    );
                } else {
                    $queryBuilder->andWhere('1 = 0');
                }
            } elseif ($filter['tipo']['value'] == self::COD_FILTRAR_LOCAL) {
                $resFiltro = $contratoModel->filtraContratoServidor('local', $filter['local']['value'], $this->getExercicio());
                $contratos = array();
                if (count($resFiltro)) {
                    $contratos = array_column($resFiltro, 'cod_contrato');
                    $queryBuilder->resetDQLPart('where');
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->in('o.codContrato', $contratos)
                    );
                } else {
                    $queryBuilder->andWhere('1 = 0');
                }
            } elseif ($filter['tipo']['value'] == self::COD_FILTRAR_PADRAO) {
                $resFiltro = $contratoModel->filtraContratoServidor('padrao', $filter['padrao']['value'], $this->getExercicio());
                $contratos = array();
                if (count($resFiltro)) {
                    $contratos = array_column($resFiltro, 'cod_contrato');
                    $queryBuilder->resetDQLPart('where');
                    $queryBuilder->andWhere(
                        $queryBuilder->expr()->in('o.codContrato', $contratos)
                    );
                } else {
                    $queryBuilder->andWhere('1 = 0');
                }
            }
        }
    }


    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $filter = $this->getRequest()->query->get('filter');
        if (!$filter) {
            $this->exibirMensagemFiltro = true;
            $query->andWhere('1 = 0');
        };
        return $query;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('registro', 'text', ['label' => 'label.recursosHumanos.contratoServidorComplementar.registro'])
            ->add(
                'servidor',
                'customField',
                [
                    'label' => 'label.recursosHumanos.contratoServidorComplementar.servidor',
                    'template' => 'RecursosHumanosBundle:FolhaPagamento\FolhaComplementar:custom_field__list.html.twig',
                    'data' => 'servidor'
                ]
            )
            ->add(
                'lotacao',
                'customField',
                [
                    'label' => 'label.recursosHumanos.contratoServidorComplementar.lotacao',
                    'template' => 'RecursosHumanosBundle:FolhaPagamento\FolhaComplementar:custom_field__list.html.twig',
                    'data' => 'lotacao'
                ]
            )
            ->add(
                'situacao',
                'customField',
                [
                    'label' => 'label.recursosHumanos.contratoServidorComplementar.situacao',
                    'template' => 'RecursosHumanosBundle:FolhaPagamento\FolhaComplementar:custom_field__list.html.twig',
                    'data' => 'situacao'
                ]
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                )
            ));
    }

    /**
     * @param ContratoServidorComplementar $contratoServidorComplementar
     */
    public function prePersist($contratoServidorComplementar)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao');

        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $folhaComplementarModel = new FolhaComplementarModel($em);
        $complementar = $folhaComplementarModel->consultaFolhaComplementar($periodoFinal->getCodPeriodoMovimentacao());

        /** @var Complementar $complementarObject */
        $complementarObject = $em->getRepository(Complementar::class)->findOneBy(
            [
                'codPeriodoMovimentacao' => $periodoFinal->getCodPeriodoMovimentacao(),
                'codComplementar' => $complementar['cod_complementar']
            ]
        );


        $contratoServidorComplementar->setFkFolhapagamentoComplementar($complementarObject);
        $contratoServidorComplementar->setFkPessoalContrato($contratoServidorComplementar->getCodContrato());
    }

    /**
     * @param ContratoServidorComplementar $contratoServidorComplementar
     */
    public function postPersist($contratoServidorComplementar)
    {
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-complementar/{$this->getObjectKey($contratoServidorComplementar)}/show");
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $em = $this->modelManager->getEntityManager($this->getClass());

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

        /** @var Contrato $contrato */
        $contrato = $this->getSubject();
        $contrato->periodo = $dtInicial->format('d/m/Y') . ' à ' . $dtFinal->format('d/m/Y');
        $contrato->competencia = $arDescMes[($arMes[1] - 1)] . '/' . $arMes[2];

        $swCgm = ($contrato->getFkPessoalContratoServidor())
            ? $contrato->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()
            : $contrato->getFkPessoalContratoPensionista()->getFkPessoalPensionista()->getFkSwCgmPessoaFisica()->getFkSwCgm();

        $contrato->matricula = $swCgm;

        $eventosCadastrados = array();
        if ($contrato->getFkFolhapagamentoContratoServidorComplementares()->count()) {
            $registroEvencoComplementar = new RegistroEventoComplementarModel($em);
            $eventosCadastrados = $registroEvencoComplementar->montaRecuperaRegistrosEventoDoContrato(
                $periodoFinal->getCodPeriodoMovimentacao(),
                $contrato->getFkFolhapagamentoContratoServidorComplementares()->last()->getCodComplementar(),
                $contrato->getCodContrato()
            );
        }

        $arEventosFixos = $arEventosBases = [];
        foreach ($eventosCadastrados as $key => $eventos) {
            if ($eventos['evento_sistema'] == false && $eventos['natureza'] != 'B') {
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
                    $arEventosBases[$bases['cod_evento_base']] = $arElementos;
                }
            }
        }

        $configuracaoModel = new ConfiguracaoModel($em);
        $boBase = $configuracaoModel->getConfiguracao('apresenta_aba_base', ConfiguracaoModel::MODULO_RH_FOLHAPAGAMENTO, true);
        $apresentaAbaBase = ($boBase == 'true') ? true : false;

        $contrato->apresentaAbaBase = $apresentaAbaBase;
        $contrato->eventosFixos = $arEventosFixos;
        $contrato->eventosBases = $arEventosBases;

        $showMapper
            ->add('codContrato');
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $contratoServidorComplementar
     */
    public function validate(ErrorElement $errorElement, $contratoServidorComplementar)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $folhaComplementarModel = new FolhaComplementarModel($em);
        $complementar = $folhaComplementarModel->consultaFolhaComplementar($periodoFinal->getCodPeriodoMovimentacao());

        if (is_null($complementar)) {
            $errorElement->addViolation($this->trans('rh.folhas.folhaComplementar.errors.folhaComplementarNaoAberta', [
            ], 'validators'));
        }
    }

    /**
     * @param Contrato $contrato
     * @param string $field
     * @return string
     */
    public function getFieldContrato($contrato, $field)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $pensionista = ($contrato->getFkPessoalContratoPensionista()) ? true : false;
        $encerrado = false;
        if ($contrato->getFkPessoalContratoPensionista()) {
            /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
            $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
            $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
            /** @var PeriodoMovimentacao $periodoFinal */
            $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);
            if (($contrato->getFkPessoalContratoPensionista()->getDtEncerramento()) && ($contrato->getFkPessoalContratoPensionista()->getDtEncerramento() < $periodoFinal->getDtFinal())) {
                $encerrado = true;
            }
        }

        if ($field == 'servidor') {
            if ($contrato->getFkPessoalContratoPensionista()) {
                return (string) $contrato->getFkPessoalContratoPensionista()->getFkPessoalPensionista()->getFkSwCgmPessoaFisica()->getFkSwCgm();
            } else {
                return (string) $contrato->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm();
            }
        } elseif ($field == 'lotacao') {
            if (!$pensionista) {
                /** @var ContratoServidorOrgao $contratoServidorOrgao */
                $contratoServidorOrgao = $em->getRepository(ContratoServidorOrgao::class)->findOneBy([
                    'codContrato' => $contrato->getCodContrato()
                ], ['timestamp' => 'DESC']);

                return sprintf('%s - %s', $contratoServidorOrgao->getFkOrganogramaOrgao()->getCodigoComposto(), $contratoServidorOrgao->getFkOrganogramaOrgao()->getDescricao());
            } else {
                /** @var ContratoPensionistaOrgao $contratoPensionistaOrgao */
                $contratoPensionistaOrgao = $em->getRepository(ContratoPensionistaOrgao::class)->findOneBy([
                    'codContrato' => $contrato->getCodContrato()
                ], ['timestamp' => 'DESC']);

                return sprintf('%s - %s', $contratoPensionistaOrgao->getFkOrganogramaOrgao()->getCodigoComposto(), $contratoPensionistaOrgao->getFkOrganogramaOrgao()->getDescricao());
            }
        } else {
            /** @var ContratoServidorSituacao $contratoServidorSituacao */
            $contratoServidorSituacao = $em->getRepository(ContratoServidorSituacao::class)->findOneBy([
                'codContrato' => $contrato->getCodContrato(),
                'deleted' => false
            ], ['timestamp' => 'DESC']);

            $situacao = $contratoServidorSituacao->getSituacaoLiteral();
            if ($encerrado) {
                $situacao .= ' Encerrado';
            }

            return $situacao;
        }
    }
}
