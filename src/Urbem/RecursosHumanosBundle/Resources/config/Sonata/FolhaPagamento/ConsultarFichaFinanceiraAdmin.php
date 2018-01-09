<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Model\Folhapagamento\EventoCalculadoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConsultarFichaFinanceiraAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_consulta_ficha_financeira';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/consulta-ficha-financeira';
    protected $exibirBotaoIncluir = false;
    protected $exibirMensagemFiltro = true;

    protected $includeJs = [
        '/recursoshumanos/javascripts/folhapagamento/dataGridConsultaFichaFinanceira.js'
    ];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
        $collection->add('gerar_relatorio', '{id}/gerar-relatorio');
        $collection->add('gerar_previa', '{id}/gerar-previa');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->createDataGridPadrao($datagridMapper);
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $query = parent::createQuery($context);

        $contratoList = $entityManager->getRepository("CoreBundle:Pessoal\Contrato")
            ->getContrato('');

        $contratos = array();

        foreach ($contratoList as $contrato) {
            array_push(
                $contratos,
                $contrato->cod_contrato
            );
        }

        $query->innerJoin('o.fkPessoalContratoServidor', 'cs');
        $query->andWhere($query->expr()->in('o.codContrato', $contratos));
        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere("{$query->getRootAliases()[0]}.codContrato = :codContrato")->setParameters(['codContrato' => 0]);
        }
        return $query;
    }


    /**
     * @inheritdoc
     */
    public function getFilterParameters()
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacaoModel->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacaoModel->getOnePeriodo($periodoUnico);
        $dtCompetenciaAtual = $periodoFinal->getDtFinal();
        $arData = explode("/", $periodoFinal->getDtFinal()->format('d/m/Y'));

        $inCodMes = $arData[1];
        $inAno = $arData[2];

        $this->datagridValues['competenciaMeses']['value'] = $inCodMes;
        $this->datagridValues['competenciaAno']['value'] = $inAno;

        return parent::getFilterParameters();
    }

    /**
     * @param DatagridMapper $datagridMapper
     * @return DatagridMapper
     */
    public function createDataGridPadrao(DatagridMapper $datagridMapper)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $organogramaModel = new OrganogramaModel($entityManager);
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

        $eventoModel = new EventoModel($entityManager);
        $eventoArray = $eventoModel->getEventoByParams(['P', 'D', 'I', 'B'], false, false);

        $codEventos = [];
        foreach ($eventoArray as $evento) {
            $codEventos[] = $evento;
        }


        $formGridOptions['tipo'] = [
            'label' => 'label.recursosHumanos.folhas.grid.tipo',
            'required' => true,
            'mapped' => false,
            'callback' => [$this, 'getSearchFilter'],
        ];

        /** @var PeriodoMovimentacaoModel $periodoMovimentacaoModel */
        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacaoModel->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacaoModel->getOnePeriodo($periodoUnico);
        $arData = explode("/", $periodoFinal->getDtFinal()->format('d/m/Y'));

        $boCompetenciaAtual = true;
        $boCompetenciaAnteriores = true;
        $formGridOptions['tipoChoices'] = [
            'choices' => [
                "CGM" => 'cgm',
                "Evento" => "evento",
            ],
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters ',
                'required' => true
            ],
        ];

        $inCodMes = $arData[1];
        $inAno = $arData[2];

        $arMeses = ["01" => "Janeiro",
            "02" => "Fevereiro",
            "03" => "Março",
            "04" => "Abril",
            "05" => "Maio",
            "06" => "Junho",
            "07" => "Julho",
            "08" => "Agosto",
            "09" => "Setembro",
            "10" => "Outubro",
            "11" => "Novembro",
            "12" => "Dezembro"];

        foreach ($arMeses as $stOption => $stValue) {
            if ($boCompetenciaAtual && !$boCompetenciaAnteriores) {
                if ($stOption >= $inCodMes) {
                    $opcoes[$stValue] = $stOption;
                }
            } elseif ($boCompetenciaAtual && $boCompetenciaAnteriores) {
                if ($stOption <= $inCodMes) {
                    $opcoes[$stValue] = $stOption;
                }
            } else {
                $opcoes[$stValue] = $stOption;
            }
        }

        $formGridOptions['competenciaAno'] = [
            'label' => 'label.recursosHumanos.folhas.grid.ano',
            'required' => true,
            'mapped' => false,
            'callback' => [$this, 'getSearchFilter'],
        ];

        $formGridOptions['competenciaAnoChoices'] = [
            'attr' => [
                'class' => 'ano '
            ],
        ];

        $formGridOptions['competenciaMeses'] = [
            'label' => 'label.recursosHumanos.folhas.grid.meses',
            'required' => true,
            'mapped' => false,
            'callback' => [$this, 'getSearchFilter'],
            'attr' => [
                'class' => 'select2-parameters '
            ],
        ];

        $mes = $periodoMovimentacaoModel->getMesCompetenciaFolhaPagamento($this->getExercicio());

        $lastMes = (is_array($mes)) ? end($mes) : $mes;

        $formGridOptions['competenciaMesesChoices'] = [
            'choices' => $mes,
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'Selecione',
            'choice_attr' => function ($competenciaMeses, $key, $index) use ($lastMes) {
                if ($index == $lastMes) {
                    return ['selected' => 'selected'];
                } else {
                    return ['selected' => false];
                }
            },
            'attr' => [
                'class' => 'select2-parameters ',
                'required' => true
            ],
        ];

        $formGridOptions['tipoCalculo'] = [
            'label' => 'label.recursosHumanos.folhas.grid.tipoCalculo',
            'required' => true,
            'mapped' => false,
            'callback' => [$this, 'getSearchFilter'],

        ];

        $formGridOptions['tipoCalculoChoices'] = [
            'choices' => [
                "Salário" => "1",
                "Férias" => "2",
                "13 Salário" => "3",
                "Rescisão" => "4",
            ],
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters ',
                'required' => true
            ],
        ];

        $formGridOptions['eventoChoices'] = [
            'class' => Evento::class,
            'choice_label' => function ($evento) {
                return $evento->getCodigo() . ' - ' . $evento->getDescricao();
            },

            'label' => 'label.recursosHumanos.folhas.grid.evento',
            'query_builder' => function (EntityRepository $repo) use ($codEventos) {
                $qb = $repo->createQueryBuilder('e');
                $qb->where(
                    $qb->expr()->In('e.codigo', $codEventos)
                );

                return $qb;
            },
            'attr' => [
                'class' => 'select2-parameters ',
                'required' => true
            ],

        ];

        $formGridOptions['evento'] = [
            'callback' => [$this, 'getSearchFilter'],
            'required' => true,
            'mapped' => false,
            'expanded' => false,
            'multiple' => true,
        ];

        $formGridOptions['fkPessoalContratoServidor'] = [
            'label' => 'label.recursosHumanos.folhas.grid.matricula',
            'callback' => [$this, 'getSearchFilter'],
        ];

        $contratoList = $entityManager->getRepository("CoreBundle:Pessoal\Contrato")
            ->getContrato('');

        $arrayContrato = [];
        foreach ($contratoList as $contrato) {
            $arrayContrato[] = $contrato->cod_contrato;
        }

        $formGridOptions['fkPessoalContratoServidorChoices'] = [
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato'
            ],
            'multiple' => false,
            'json_choice_label' => function ($contrato) use ($entityManager) {
                $nomcgm = $this->getServidor($contrato);

                return $nomcgm;
            },
            'attr' => [
                'class' => 'select2-parameters ',
                'required' => true
            ],

        ];

        $datagridMapper->add('tipo', 'doctrine_orm_callback', $formGridOptions['tipo'], 'choice', $formGridOptions['tipoChoices']);
        $datagridMapper->add(
            'codContrato',
            'doctrine_orm_callback',
            $formGridOptions['fkPessoalContratoServidor'],
            'autocomplete',
            $formGridOptions['fkPessoalContratoServidorChoices']
        );
        $datagridMapper->add('evento', 'doctrine_orm_callback', $formGridOptions['evento'], 'entity', $formGridOptions['eventoChoices']);
        $datagridMapper->add('tipoCalculo', 'doctrine_orm_callback', $formGridOptions['tipoCalculo'], 'choice', $formGridOptions['tipoCalculoChoices']);
        $datagridMapper->add('competenciaAno', 'doctrine_orm_callback', $formGridOptions['competenciaAno'], 'number', $formGridOptions['competenciaAnoChoices']);
        $datagridMapper->add('competenciaMeses', 'doctrine_orm_callback', $formGridOptions['competenciaMeses'], 'choice', $formGridOptions['competenciaMesesChoices']);

        return $datagridMapper;
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

        $paramsBo["boAtivos"] = true;
        $paramsBo["boAposentados"] = true;
        $paramsBo["boRescindidos"] = false;
        $paramsBo["boPensionistas"] = true;
        $paramsBo["stTipoFolha"] = "S";

        $contratos = ['-1'];
        if (isset($filter['tipo']['value'])) {
            $queryBuilder->resetDQLPart('where');
        }

        // FILTRO POR MATRICULA
        if ($filter['codContrato']['value']) {
            $contratos = $filter['codContrato']['value'];

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.codContrato', $contratos)
            );
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

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.codContrato', $contratos)
            );
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        $filter = $this->getDataGrid()->getValues();
        $tipoCalculo = (isset($filter['tipoCalculo']['value'])) ? $filter['tipoCalculo']['value'] : $this->getRequest()->get('tipoCalculo');
        $codMes = (isset($filter['competenciaMeses']['value'])) ? $filter['competenciaMeses']['value'] : $this->getRequest()->get('competenciaMeses');
        $codAno = (isset($filter['competenciaAno']['value'])) ? $filter['competenciaAno']['value'] : $this->getRequest()->get('competenciaAno');
        return [
            'tipoCalculo' => $tipoCalculo,
            'codMes' => $codMes,
            'codAno' => $codAno,
        ];
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
                    'template' => 'RecursosHumanosBundle:FolhaPagamento\Folhas:fichaFinanceiraServidor.html.twig',
                ]
            )
            ->add(
                'registro',
                null,
                [
                    'label' => 'label.matricula',
                ]
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                )
            ));
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $em = $this->modelManager->getEntityManager($this->getClass());
        $tipoFiltro = $this->getRequest()->get('tipoCalculo');
        $codComplementar = $this->getRequest()->get('codComplementar');
        $codMes = $this->getRequest()->get('codMes');
        $codAno = $this->getRequest()->get('codAno');
        $mes = ((int) $codMes < 10) ? "0" . $codMes : $codMes;
        $dtCompetencia = $mes . "/" . $codAno;

        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->recuperaPeriodoMovimentacao(null, $dtCompetencia);

        if (!is_null($periodoUnico)) {
            /** @var PeriodoMovimentacao $periodoFinal */
            $periodoFinal = $periodoMovimentacao->getMovimentacaoByCodPeriodoMovimentacao($periodoUnico['cod_periodo_movimentacao']);
            $dtInicial = $periodoFinal->getDtInicial();
            $arMes = explode("/", $dtInicial->format('d/m/Y'));
        } else {
            $arMes[1] = $codMes;
            $arMes[2] = $codAno;
        }

        $arDescMes = ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

        /** @var Contrato $contrato */
        $contrato = $this->getSubject();
        $contrato->competencia = $arDescMes[($arMes[1] - 1)] . '/' . $arMes[2];

        $contrato->matricula = $contrato->getRegistro(). " - ". $contrato->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()
            ->getFkPessoalServidor()
            ->getFkSwCgmPessoaFisica()
            ->getFkSwCgm()->getNomCgm();

        $codContrato = $this->getAdminRequestId();
        $eventoCalculadoModel = new EventoCalculadoModel($em);
        $codConfiguracao = ($tipoFiltro) ? $tipoFiltro : 1;
        $codComplementar = ($codComplementar) ? $codComplementar : 0;
        $entidade = '';
        $ordem = 'codigo';

        $codPeriodoMovimentacao = $periodoFinal->getCodPeriodoMovimentacao();
        $rsEventoCalculado = $eventoCalculadoModel->recuperarEventosCalculadosFichaFinanceira(
            $codConfiguracao,
            $codPeriodoMovimentacao,
            $codContrato,
            $codComplementar,
            $entidade,
            $ordem
        );

        $processados = $eventoCalculadoModel->processarEventoFichaFinanceira($codConfiguracao, $codContrato, $entidade, $codPeriodoMovimentacao);

        $eventosCalculados = $eventoCalculadoModel->processarEventos($rsEventoCalculado, 1);
        $basesCalculos = $eventoCalculadoModel->processarEventos($rsEventoCalculado, 2);
        $eventosInformativos = $eventoCalculadoModel->processarEventos($rsEventoCalculado, 3);
        $totaisCalculados = $eventoCalculadoModel->processarEventos($rsEventoCalculado, 4);

        $contrato->eventosCalculados = $eventosCalculados;
        $contrato->basesCalculos = $basesCalculos;
        $contrato->eventosInformativos = $eventosInformativos;
        $contrato->totaisCalculados = $totaisCalculados;
        $contrato->codConfiguracao = $codConfiguracao;
        $contrato->processados = $processados;
        $contrato->codAno = $codAno;
        $contrato->codMes = $codMes;

        $showMapper
            ->add('fkPessoalContrato');
    }

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
