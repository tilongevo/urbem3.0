<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoFeriasModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConsultaRegistrosEventoFeriasAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_consulta_registro_evento_ferias';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/consulta-registro-evento-ferias';
    protected $exibirBotaoIncluir = false;
    protected $exibirMensagemFiltro = true;
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    protected $maxPerPage = false;
    protected $includeJs = array('/recursoshumanos/javascripts/folhapagamento/dataGridRegistrosEventosFerias.js');

    protected $datagridValues = array(
        '_page' => 1,            // display the first page (default = 1)
        '_sort_order' => 'ASC', // reverse order (default = 'ASC')
        '_sort_by' => 'nomCgm'  // name of the ordered field
    );

    /**
     * @param RouteCollection $routes
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add(
            'detalhe',
            sprintf('detalhe/%s', $this->getRouterIdParameter())
        );
    }

    /**
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'RecursosHumanosBundle:FolhaPagamento\FolhaFerias\ConsultaRegistrosEventoFerias:list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $em = $this->getEntityManager();

        $eventoModel = new EventoModel($em);
        $eventos = $eventoModel->getEventoByParams(['P', 'D', 'B', 'I'], false, false);

        foreach ($eventos as $evento) {
            $codEventos[] = $evento;
        }

        $formGridOptions = array();

        /** @var PeriodoMovimentacaoModel $periodoMovimentacaoModel */
        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacaoModel->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacaoModel->getOnePeriodo($periodoUnico);
        $arData = explode("/", $periodoFinal->getDtFinal()->format('d/m/Y'));

        $boCompetenciaAtual = true;
        $boCompetenciaAnteriores = true;

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
            'label' => 'label.recursosHumanos.registrosEventoFerias.ano',
            'required' => true,
            'mapped' => false,
            'callback' => [$this, 'getSearchFilter'],
        ];

        // Mantem o valor do ano do submit anterior
        $ano = $this->getExercicio();
        if (array_key_exists('competenciaAno', $this->getDatagrid()->getValues())) {
            if ($this->getDatagrid()->getValues()['competenciaAno']['value'] !== '' && !empty($this->getDatagrid()->getValues()['competenciaAno']['value'])) {
                $ano = $this->getDatagrid()->getValues()['competenciaAno']['value'];
            }
        }

        $formGridOptions['competenciaAnoChoices'] = [
            'attr' => [
                'value' => $ano,
                'class' => 'ano '
            ],
        ];

        $formGridOptions['competenciaMeses'] = [
            'label' => 'label.recursosHumanos.registrosEventoFerias.mes',
            'required' => true,
            'mapped' => false,
            'callback' => [$this, 'getSearchFilter'],
            'attr' => [
                'class' => 'select2-parameters '
            ],
        ];

        $mes = $periodoMovimentacaoModel->getMesCompetenciaFolhaPagamento($ano);

        $formGridOptions['competenciaMesesChoices'] = [
            'choices' => $mes,
            'expanded' => false,
            'multiple' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters ',
                'required' => true
            ],
        ];

        $opcoesTipo = array(
            'Cgm/Matrícula' => 'cgmMatricula',
            'Evento' => 'evento'
        );

        $formGridOptions['tipo'] = array(
            'label' => 'label.recursosHumanos.registrosEventoFerias.tipo',
            'mapped' => false,
            'required' => true,
            'callback' => [$this, 'getSearchFilter']
        );

        $formGridOptions['tipoChoices'] = array(
            'placeholder' => 'label.selecione',
            'choices' => $opcoesTipo,
            'required' => true,
            'expanded' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
        );

        $formGridOptions['fkPessoalContratoServidor'] = [
            'label' => 'label.recursosHumanos.registrosEventoFerias.cgmMatricula',
            'callback' => [
                $this,
                'getSearchFilter'
            ],
        ];

        $formGridOptions['fkPessoalContratoServidorChoices'] = array(
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato'
            ],
            'json_choice_label' => function ($contrato) use ($em) {
                if (!is_null($contrato->getFkPessoalContratoServidor())) {
                    $nomcgm = $contrato->getFkPessoalContratoServidor()
                        ->getFkPessoalServidorContratoServidores()->last()
                        ->getFkPessoalServidor()
                        ->getFkSwCgmPessoaFisica()
                        ->getFkSwCgm()
                        ->getNomcgm();
                } else {
                    $nomcgm = "label.recursosHumanos.registrosEventoFerias.msgServidor";
                }
                return $nomcgm;
            },
            'attr' => [
                'class' => 'select2-parameters ',
                'required' => true
            ],
            'mapped' => false
        );

        $formGridOptions['fkFolhapagamentoEvento'] = array(
            'label' => 'label.recursosHumanos.registrosEventoFerias.evento',
            'callback' => [
                $this,
                'getSearchFilter'
            ],
        );

        $formGridOptions['evento'] = [
            'callback' => [$this, 'getSearchFilter'],
            'required' => true,
            'mapped' => false,
            'expanded' => false,
            'multiple' => false,
        ];

        $formGridOptions['eventoChoices'] = [
            'label' => 'label.recursosHumanos.registrosEventoFerias.evento',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'class' => Evento::class,
            'choice_label' => function ($evento) {
                return $evento->getCodigo() . ' - ' . $evento->getDescricao();
            },
            'query_builder' => function (EntityRepository $repo) use ($codEventos) {
                $qb = $repo->createQueryBuilder('e');
                $qb->where(
                    $qb->expr()->In('e.codigo', $codEventos)
                );
                return $qb;
            }
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
        $datagridMapper->add('competenciaAno', 'doctrine_orm_callback', $formGridOptions['competenciaAno'], 'number', $formGridOptions['competenciaAnoChoices']);
        $datagridMapper->add('competenciaMeses', 'doctrine_orm_callback', $formGridOptions['competenciaMeses'], 'choice', $formGridOptions['competenciaMesesChoices']);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'matricula',
                'customField',
                [
                    'label' => 'label.recursosHumanos.registrosEventoFerias.matricula',
                    'mapped' => false,
                    'template' => 'RecursosHumanosBundle:FolhaPagamento\FolhaFerias\ConsultaRegistrosEventoFerias:matricula.html.twig'
                ]
            )
            ->add(
                'nomCgm',
                'customField',
                [
                    'label' => 'label.recursosHumanos.registrosEventoFerias.nome',
                    'mapped' => false,
                    'template' => 'RecursosHumanosBundle:FolhaPagamento\FolhaFerias\ConsultaRegistrosEventoFerias:servidor.html.twig'
                ]
            )
            ->add(
                'descricao',
                'customField',
                [
                    'label' => 'label.recursosHumanos.registrosEventoFerias.desdobramento',
                    'mapped' => false,
                    'template' => 'RecursosHumanosBundle:FolhaPagamento\FolhaFerias\ConsultaRegistrosEventoFerias:desdobramento.html.twig'
                ]
            )
            ->add(
                'quantidade',
                null,
                [
                    'label' => 'label.recursosHumanos.registrosEventoFerias.quantidade',
                    'mapped' => false,
                ]
            )
            ->add(
                'valor',
                null,
                [
                    'label' => 'label.recursosHumanos.registrosEventoFerias.valor',
                    'mapped' => false,
                ]
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'detalhe' => array('template' => 'RecursosHumanosBundle::FolhaPagamento/FolhaFerias/ConsultaRegistrosEventoFerias/list__action_detalhe.html.twig')
                )
            ));
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere('1 = 0');
        }
        return $query;
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

        $filter = $this->getDataGrid()->getValues();

        if (!$value['value']) {
            return;
        }

        // Coloca zero quando o mês só tem um dígito
        $mes = $filter['competenciaMeses']['value'];
        if (strlen($mes) < 2) {
            $mes = '0'.$mes;
        }

        $competenciaFinal = $mes.'/'.$filter['competenciaAno']['value'];
        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodo = $periodoMovimentacao->recuperaPeriodoMovimentacao(null, $competenciaFinal);

        if (isset($filter['tipo']['value'])) {
            $queryBuilder->resetDQLPart('where');
        }

        // FILTRO POR MATRICULA
        if ($filter['tipo']['value'] == 'cgmMatricula' && !empty($filter['codContrato']['value']) && $periodo['cod_periodo_movimentacao']) {
            $queryBuilder->resetDQLPart('join');
            $queryBuilder->leftJoin('o.fkFolhapagamentoUltimoRegistroEventoFerias', 'uef');
            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.codContrato', $filter['codContrato']['value']),
                $queryBuilder->expr()->in('o.codPeriodoMovimentacao', $periodo['cod_periodo_movimentacao'])
            );

            $queryBuilder->andWhere('uef.codEvento is not null');

            // FILTRO POR EVENTO
        } elseif ($filter['tipo']['value'] == 'evento' && !empty($filter['evento']['value']) && $periodo['cod_periodo_movimentacao']) {
            $queryBuilder->resetDQLPart('join');
            $queryBuilder->leftJoin('o.fkFolhapagamentoUltimoRegistroEventoFerias', 'uef');
            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.codEvento', $filter['evento']['value']),
                $queryBuilder->expr()->in('o.codPeriodoMovimentacao', $periodo['cod_periodo_movimentacao'])
            );

            $queryBuilder->andWhere('uef.codEvento is not null');

            $total = (new RegistroEventoFeriasModel($entityManager))->recuperaRegistrosEventosFerias(array(
                'tipo' => 'soma',
                'codEvento' => $filter['evento']['value'],
                'codPeriodoMovimentacao' => $periodo['cod_periodo_movimentacao'],
            ));

            $this->setCustomBodyTemplate($total);
        } else {
            $queryBuilder->andWhere('1 = 0');
        }

        return true;
    }

    /**
     * @param $object
     * @return array|string
     */
    public function getServidor($object)
    {
        if (is_null($object)) {
            return '';
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        return (new RegistroEventoFeriasModel($entityManager))->recuperaRegistrosEventosFerias(array(
            'codContrato' => $object->getCodContrato(),
            'codEvento' => $object->getCodEvento(),
            'codPeriodoMovimentacao' => $object->getCodPeriodoMovimentacao(),
        ));
    }
}
