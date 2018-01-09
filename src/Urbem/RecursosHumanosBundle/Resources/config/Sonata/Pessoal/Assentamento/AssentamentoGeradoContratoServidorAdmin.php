<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal\Assentamento;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Helper\DatePK;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Model\Pessoal\Assentamento\AssentamentoGeradoContratoServidorModel;

class AssentamentoGeradoContratoServidorAdmin extends AbstractAdmin
{
    const PERIODICIDADE = array(
        'label.dia' => 1,
        'label.mes' => 2,
        'label.ano' => 3,
        'label.intervalo' => 4
    );
    
    const MONTH = array(
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December'
    );
    
    protected $baseRouteName = 'urbem_recursos_humanos_assentamento_gerar_assentamento';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/assentamento/gerar-assentamento';
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'codAssentamentoGerado',
    );
    protected $includeJs = array(
        '/recursoshumanos/javascripts/pessoal/assentamento.js',
    );
    
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove("export");
        $collection->remove("batch");
        $collection->add('get_classificacao_assentamento', 'get-classificacao-assentamento', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_assentamento_classificacao', 'get-assentamento-classificacao', array(), array(), array(), '', array(), array('POST'));
        $collection->add('get_assentamento_by_codclassificacao', 'get-assentamento-by-codclassificacao', array(), array(), array(), '', array(), array('POST', 'GET'));
        $collection->add('get_assentamento_classificacao_matricula', 'get-assentamento-classificacao-matricula', array(), array(), array(), '', array(), array('POST'));
    }
    
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codContrato',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.gerarAssentamento.inContrato',
                ),
                'autocomplete',
                array(
                    'route' => array(
                        'name' => 'carrega_contrato'
                    ),
                    'class' => 'CoreBundle:Pessoal\Contrato',
                    'mapped' => false,
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                )
            )
            ->add(
                'codClassificacao',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.gerarAssentamento.inCodClassificacaoTxt',
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Pessoal\ClassificacaoAssentamento',
                    'choice_label' => function ($classificacaoAssentamento) {
                        return $classificacaoAssentamento->getCodClassificacao()
                        . " - "
                        . $classificacaoAssentamento->getDescricao();
                    },
                    'placeholder' => 'label.selecione',
                    'mapped' => false,
                )
            )
            ->add(
                'codAssentamento',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.gerarAssentamento.inCodAssentamentoTxt',
                ),
                'choice',
                array(
                    'choices' => array(),
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                    'placeholder' => 'label.selecione',
                    'mapped' => false,
                )
            )
            ->add(
                'tipoPeriodicidade',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.gerarAssentamento.tipoPeriodicidade',
                ),
                'choice',
                array(
                    'choices' => self::PERIODICIDADE,
                    'attr' => array(
                        'class' => 'select2-parameters',
                    ),
                    'mapped' => false,
                )
            )
            ->add(
                'dia',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.dia',
                ),
                'datepkpicker',
                array(
                    'format' => 'dd/MM/yyyy',
                    'pk_class' => DatePK::class,
                    'mapped' => false,
                )
            )
            ->add(
                'ano',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.ano',
                ),
                'number',
                array(
                    'attr' => array(
                        'value' => $this->getExercicio()
                    ),
                    'mapped' => false,
                )
            )
            ->add(
                'mes',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.mes',
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Administracao\Mes',
                    'choice_label' => 'descricao',
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                    'mapped' => false,
                )
            )
            ->add(
                'periodoInicial',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.gerarAssentamento.stDataInicial',
                ),
                'datepkpicker',
                array(
                    'format' => 'dd/MM/yyyy',
                    'pk_class' => DatePK::class,
                    'mapped' => false,
                )
            )
            ->add(
                'periodoFinal',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.gerarAssentamento.stDataFinal',
                ),
                'datepkpicker',
                array(
                    'format' => 'dd/MM/yyyy',
                    'pk_class' => DatePK::class,
                    'mapped' => false,
                )
            )
        ;
    }
    
    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        
        $filter = $this->getRequest()->query->get('filter');
        
        $query->leftJoin("o.fkPessoalAssentamentoGerados", "ag");
        
        if ($filter['codContrato']['value'] != '') {
            $query->andWhere('o.codContrato = :codContrato');
            $query->setParameters([
                'codContrato' => $filter['codContrato']['value']
            ]);
        }
        
        if ($filter['codAssentamento']['value'] != '') {
            $query->andWhere('ag.codAssentamento = :codAssentamento');
            $query->setParameters([
                'codAssentamento' => $filter['codAssentamento']['value']
            ]);
        }
        
        if ($filter['dia']['value'] != '' && $filter['tipoPeriodicidade']['value'] == 1) {
            $query->andWhere('ag.periodoInicial = :dia');
            $query->orWhere('ag.periodoFinal = :dia');
            $query->setParameters([
                'dia' => $filter['dia']['value']
            ]);
        }
        
        if ($filter['mes']['value'] != '' && $filter['ano']['value'] != '' && $filter['tipoPeriodicidade']['value'] == 2) {
            $month = self::MONTH[$filter['mes']['value']];
            
            $firstDay = date('Y-m-d', strtotime('first day of ' . $month . " " . $filter['ano']['value']));
            $lastDay = date('Y-m-d', strtotime('last day of ' . $month . " " . $filter['ano']['value']));
            
            $query->andWhere($query->expr()->between('ag.periodoInicial', "'" . $firstDay . "'", "'" . $lastDay . "'"));
            $query->orWhere($query->expr()->between('ag.periodoFinal', "'" . $firstDay . "'", "'" . $lastDay . "'"));
        }
        
        if ($filter['ano']['value'] != '' && $filter['tipoPeriodicidade']['value'] == 3) {
            $firstDay = date('Y-m-d', strtotime('first day of January ' . $filter['ano']['value']));
            $lastDay = date('Y-m-d', strtotime('last day of December ' . $filter['ano']['value']));
            
            $query->andWhere($query->expr()->between('ag.periodoInicial', "'" . $firstDay . "'", "'" . $lastDay . "'"));
            $query->orWhere($query->expr()->between('ag.periodoFinal', "'" . $firstDay . "'", "'" . $lastDay . "'"));
        }
        
        if ($filter['periodoInicial']['value'] != '' && $filter['periodoFinal']['value'] != '' && $filter['tipoPeriodicidade']['value'] == 4) {
            $query->andWhere($query->expr()->between('ag.periodoInicial', "'" . $filter['periodoInicial']['value'] . "'", "'" . $filter['periodoFinal']['value'] . "'"));
            $query->orWhere($query->expr()->between('ag.periodoFinal', "'" . $filter['periodoInicial']['value'] . "'", "'" . $filter['periodoFinal']['value'] . "'"));
        }
        
        if (! $filter) {
            $query->andWhere('1 = 0');
        }
        return $query;
    }
    
    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'RecursosHumanosBundle:Pessoal/AssentamentoGeradoContratoServidor:list__action_delete.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        
        $listMapper
            ->add(
                'fkPessoalContrato.registro',
                null,
                array(
                    'label' => 'label.gerarAssentamento.inContrato'
                )
            )
            ->add(
                'servidor'
            )
            ->add(
                'assentamento'
            )
            ->add(
                'periodo',
                null,
                array(
                    'label' => 'label.gerarAssentamento.periodo'
                )
            )
            ->add(
                'situacao',
                null,
                array(
                    'label' => 'label.gerarAssentamento.situacao',
                    'template' => 'RecursosHumanosBundle:Pessoal/Contrato:situacao.html.twig'
                )
            )
        ;
        
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();
        
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = array();
        
        // TODO: Voltar nessa parte quando pesquisa por Cargo e Lotação estiverem
        // funcionando no sistema antigo.
        $fieldOptions['stModoGeracao'] = array(
            'label' => 'label.gerarAssentamento.stModoGeracao',
            'choices' => array(
                'Matrícula' => 'contrato',
                'CGM/Matrícula' => 'cgm/contrato',
                'Cargo' => 'cargo',
                'Lotação' => 'lotacao'
            ),
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'mapped' => false,
        );

        $fieldOptions['codContrato'] = array(
            'label' => 'label.gerarAssentamento.inContrato',
            'route' => array(
                'name' => 'carrega_contrato'
            ),
            'class' => 'CoreBundle:Pessoal\Contrato',
            'json_choice_label' => function ($contrato) {
                return $contrato->getRegistro()
                . " - "
                . $contrato->getCodContrato()
                . " - "
                . $contrato->getFkPessoalContratoServidor()
                ->getFkPessoalServidorContratoServidores()->last()
                ->getFkPessoalServidor()
                ->getFkSwCgmPessoaFisica()
                ->getFkSwCgm()
                ->getNomcgm();
            },
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters'
            ),
        );
        
        $fieldOptions['codClassificacao'] = array(
            'label' => 'label.gerarAssentamento.inCodClassificacaoTxt',
            'choices' => array(),
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'placeholder' => 'label.selecione'
        );
        
        $fieldOptions['codAssentamento'] = array(
            'label' => 'label.gerarAssentamento.inCodAssentamentoTxt',
            'choices' => array(),
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'placeholder' => 'label.selecione'
        );
        
        $fieldOptions['codTipoNorma'] = array(
            'label' => 'label.gerarAssentamento.codTipoNorma',
            'class' => 'CoreBundle:Normas\TipoNorma',
            'choice_label' => 'nomTipoNorma',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'placeholder' => 'label.selecione',
            'required' => false,
        );
        
        $fieldOptions['codNorma'] = array(
            'label' => 'label.gerarAssentamento.stCodNorma',
            'class' => 'CoreBundle:Normas\Norma',
            'req_params' => array(
                'codTipoNorma' => 'varJsCodTipoNorma'
            ),
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                $qb = $repo->createQueryBuilder('n')
                    ->where('LOWER(n.nomNorma) LIKE :nomNorma')
                    ->andWhere('n.codTipoNorma = :codTipoNorma')
                    ->andWhere('n.exercicio = :exercicio')
                    ->setParameter('nomNorma', "%" . strtolower($term) . "%")
                    ->setParameter('codTipoNorma', $request->get('codTipoNorma'))
                    ->setParameter('exercicio', $this->getExercicio())
                ;
                
                return $qb;
            },
            'multiple' => true,
            'mapped' => false,
            'required' => false,
        );
        
        $fieldOptions['inQuantidadeDias'] = array(
            'label' => 'label.gerarAssentamento.inQuantidadeDias',
            'attr' => array(
                'class' => 'money '
            ),
            'mapped' => false,
        );
        
        $fieldOptions['periodoInicial'] = array(
            'label' => 'label.gerarAssentamento.stDataInicial',
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'mapped' => false,
        );
        
        $fieldOptions['periodoFinal'] = array(
            'label' => 'label.gerarAssentamento.stDataFinal',
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'mapped' => false,
        );
        
        $fieldOptions['observacao'] = array(
            'label' => 'label.gerarAssentamento.stObservacao',
            'mapped' => false,
        );
        
        if ($this->id($this->getSubject())) {
            $fieldOptions['codContrato']['data'] = $this->getSubject()->getFkPessoalContrato();
            $fieldOptions['codContrato']['disabled'] = true;
            $fieldOptions['periodoInicial']['data'] = $this->getSubject()->getFkPessoalAssentamentoGerados()->last()->getPeriodoInicial();
            $fieldOptions['periodoFinal']['data'] = $this->getSubject()->getFkPessoalAssentamentoGerados()->last()->getPeriodoFinal();
            $fieldOptions['observacao']['data'] = $this->getSubject()->getFkPessoalAssentamentoGerados()->last()->getObservacao();
            
            $fkPessoalAssentamentoGeradoNormas = $this->getSubject()
            ->getFkPessoalAssentamentoGerados()->last()->getFkPessoalAssentamentoGeradoNormas();
            
            if (count($fkPessoalAssentamentoGeradoNormas->toArray()) > 0) {
                $fieldOptions['codTipoNorma']['data'] = $fkPessoalAssentamentoGeradoNormas->last()
                ->getFkNormasNorma()->getFkNormasTipoNorma();
                $fieldOptions['codNorma']['data'] = (new AssentamentoGeradoContratoServidorModel($entityManager))
                ->getNormasList($fkPessoalAssentamentoGeradoNormas);
            }
            
            $fieldOptions['fkPessoalContrato']['disabled'] = true;
        }
        
        $formMapper
            ->with('label.gerarAssentamento.gerarassentamentomatricula')
                ->add(
                    'codContrato',
                    'autocomplete',
                    $fieldOptions['codContrato']
                )
            ->end()
            ->with('label.gerarAssentamento.informacoesassentamento')
                ->add(
                    'codClassificacao',
                    'choice',
                    $fieldOptions['codClassificacao']
                )
                ->add(
                    'codAssentamento',
                    'choice',
                    $fieldOptions['codAssentamento']
                )
                ->add(
                    'codTipoNorma',
                    'entity',
                    $fieldOptions['codTipoNorma']
                )
                ->add(
                    'codNorma',
                    'autocomplete',
                    $fieldOptions['codNorma']
                )
                ->add(
                    'inQuantidadeDias',
                    'number',
                    $fieldOptions['inQuantidadeDias']
                )
                ->add(
                    'periodoInicial',
                    'datepkpicker',
                    $fieldOptions['periodoInicial']
                )
                ->add(
                    'periodoFinal',
                    'datepkpicker',
                    $fieldOptions['periodoFinal']
                )
                ->add(
                    'observacao',
                    'textarea',
                    $fieldOptions['observacao']
                )
            ->end()
        ;
        
        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formMapper, $admin, $entityManager, $fieldOptions) {
                $form = $event->getForm();
                $data = $event->getData();
                $subject = $admin->getSubject($data);
                
                if ($this->id($this->getSubject())) {
                    $fieldOptions['codClassificacao']['auto_initialize'] = false;
                    $fieldOptions['codClassificacao']['choices'] = (new AssentamentoGeradoContratoServidorModel($entityManager))
                    ->getClassificacaoAssentamento($subject->getFkPessoalContrato()->getCodContrato(), true);
                    $fieldOptions['codClassificacao']['data'] = $subject->getFkPessoalAssentamentoGerados()->last()
                    ->getFkPessoalAssentamentoAssentamento()->getCodClassificacao();
                    
                    $codClassificacao = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codClassificacao',
                        'choice',
                        null,
                        $fieldOptions['codClassificacao']
                    );

                    $form->add($codClassificacao);
                
                    $fieldOptions['codAssentamento']['auto_initialize'] = false;
                    $fieldOptions['codAssentamento']['choices'] = (new AssentamentoGeradoContratoServidorModel($entityManager))
                    ->getAssentamentoByClassificacaoMatricula(
                        $subject->getFkPessoalContrato()->getCodContrato(),
                        $subject->getFkPessoalAssentamentoGerados()->last()->getFkPessoalAssentamentoAssentamento()->getCodClassificacao(),
                        true
                    );
                    
                    $fieldOptions['codAssentamento']['data'] = $subject->getFkPessoalAssentamentoGerados()->last()
                    ->getCodAssentamento();
                    
                    $codAssentamento = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codAssentamento',
                        'choice',
                        null,
                        $fieldOptions['codAssentamento']
                    );

                    $form->add($codAssentamento);
                }
            }
        );
        
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $entityManager, $fieldOptions) {
                $form = $event->getForm();
                $data = $event->getData();
                $subject = $admin->getSubject($data);
                
                $codContrato = "";
                if ($this->id($this->getSubject())) {
                    $codContrato = $subject->getFkPessoalContrato()->getRegistro();
                } else {
                    $codContrato = $data['codContrato'];
                }
                
                if (isset($data['codContrato']) && $data['codContrato'] != "") {
                    $fieldOptions['codClassificacao']['auto_initialize'] = false;
                    $fieldOptions['codClassificacao']['choices'] = (new AssentamentoGeradoContratoServidorModel($entityManager))
                    ->getClassificacaoAssentamento($data['codContrato'], true);
                    
                    $codClassificacao = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codClassificacao',
                        'choice',
                        null,
                        $fieldOptions['codClassificacao']
                    );

                    $form->add($codClassificacao);
                }
                
                if (isset($data['codClassificacao']) && $data['codClassificacao'] != "") {
                    $fieldOptions['codAssentamento']['auto_initialize'] = false;
                    $fieldOptions['codAssentamento']['choices'] = (new AssentamentoGeradoContratoServidorModel($entityManager))
                    ->getAssentamentoByClassificacaoMatricula($codContrato, $data['codClassificacao'], true);
                    
                    $codAssentamento = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codAssentamento',
                        'choice',
                        null,
                        $fieldOptions['codAssentamento']
                    );

                    $form->add($codAssentamento);
                }
            }
        );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        
        $showMapper
            ->add(
                'servidor',
                'string',
                array(
                    'label' => 'label.gerarAssentamento.cgm'
                )
            )
            ->add(
                'fkPessoalContrato.registro',
                'string',
                array(
                    'label' => 'label.gerarAssentamento.inContrato'
                )
            )
            ->add(
                'classificacao',
                'string',
                array(
                    'label' => 'label.gerarAssentamento.inCodClassificacaoTxt'
                )
            )
            ->add(
                'assentamento',
                'string',
                array(
                    'label' => 'label.gerarAssentamento.inCodAssentamentoTxt'
                )
            )
            ->add(
                'periodo',
                'string',
                array(
                    'label' => 'label.gerarAssentamento.periodo'
                )
            )
            ->add(
                'fkPessoalAssentamentoGerados.last.fkPessoalAssentamentoGeradoNormas',
                null,
                array(
                    'label' => false,
                    'template' => 'RecursosHumanosBundle:Pessoal/AssentamentoGeradoContratoServidor:normas.html.twig'
                )
            )
            ->add(
                'observacao',
                'string',
                array(
                    'label' => 'label.gerarAssentamento.stObservacao'
                )
            )
        ;
    }
    
    public function recuperarSituacaoDoContratoLiteral($object)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();
        
        return $entityManager->getRepository("CoreBundle:Pessoal\Contrato")
        ->recuperarSituacaoDoContratoLiteral($object->getCodContrato())
        ->situacao;
    }
    
    /**
     * Pre Persist
     * @param \Urbem\CoreBundle\Pessoal\AssentamentoGeradoContratoServidor $object
     */
    public function prePersist($object)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();
        
        $formData = $this->getRequest()->request->get($this->getUniqid());
        
        $fkPessoalContrato = $entityManager->getRepository("CoreBundle:Pessoal\Contrato")
        ->findOneByCodContrato($formData['codContrato']);
        
        $object->setFkPessoalContrato($fkPessoalContrato);
    }
    
    /**
     * Post persist
     * @param \Urbem\CoreBundle\Pessoal\AssentamentoGeradoContratoServidor $object
     */
    public function postPersist($object)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();
        
        (new AssentamentoGeradoContratoServidorModel($entityManager))
        ->create($object, $this->getForm());
    }
    
    /**
     * Pre update
     * @param \Urbem\CoreBundle\Pessoal\AssentamentoGeradoContratoServidor $object
     */
    public function preUpdate($object)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();
        
        (new AssentamentoGeradoContratoServidorModel($entityManager))
        ->create($object, $this->getForm());
    }
}
