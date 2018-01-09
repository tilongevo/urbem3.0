<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Doctrine\ORM\EntityRepository;
use DateTime;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Contabilidade\EncerramentoMes;
use Urbem\CoreBundle\Entity\Contabilidade\Lancamento;
use Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho;
use Urbem\CoreBundle\Entity\Empenho\AtributoLiquidacaoValor;
use Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao;
use Urbem\CoreBundle\Entity\Empenho\NotaLiquidacaoItemAnulado;
use Urbem\CoreBundle\Entity\Empenho\PreEmpenho;
use Urbem\CoreBundle\Entity\Empenho\PreEmpenhoDespesa;
use Urbem\CoreBundle\Entity\Orcamento\Despesa;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Empenho\EmpenhoModel;
use Urbem\CoreBundle\Model\Contabilidade\LiquidacaoModel;
use Urbem\CoreBundle\Model\Empenho\NotaLiquidacaoItemModel;
use Urbem\CoreBundle\Model\Empenho\NotaLiquidacaoModel;
use Urbem\CoreBundle\Model\Empenho\PreEmpenhoModel;
use Urbem\CoreBundle\Model\Orcamento\DespesaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Services\Financeiro\Empenho\Liquidacao\DocumentoFiscal\DocumentoFiscal;
use Urbem\CoreBundle\Services\Financeiro\Empenho\Liquidacao\DocumentoFiscal\DocumentoFiscalFactory;

class LiquidarEmpenhoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_liquidar_empenho';
    protected $baseRoutePattern = 'financeiro/empenho/liquidar-empenho';
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoIncluir = false;
    protected $exibirMensagemFiltro = true;
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Salvar'];
    protected $empenhoList = [];
    protected $empenhoListErrors = [];
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'codEmpenho'
    );
    protected $includeJs = array('/financeiro/javascripts/empenho/liquidar-empenho.js');

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('anular_liquidacao', 'anular-liquidacao/' . $this->getRouterIdParameter());
        $collection->add('reemitir_liquidacao', 'reemitir-liquidacao/' . $this->getRouterIdParameter());
        $collection->add('reemitir_anulacao_liquidacao', 'reemitir-anulacao-liquidacao/' . $this->getRouterIdParameter());
        $collection->add('assinatura', 'assinatura/' . $this->getRouterIdParameter());
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->getRequest()->query->get('filter')) {
            $query->where('o.exercicio = :exercicio');
            $query->setParameter('exercicio', $this->getExercicio());
        }
        return $query;
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        $id = $this->getAdminRequestId();
        if (is_null($id)) {
            return array();
        }

        return array(
            'tipo' => $this->getRequest()->get('tipo')
        );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codEntidade',
                'doctrine_orm_callback',
                [
                    'callback' => [$this, 'getSearchFilter'],
                    'label' => 'label.preEmpenho.codEntidade',
                ],
                'entity',
                [
                    'class' => Entidade::class,
                    'choice_value' => 'codEntidade',
                    'choice_label' => 'fkSwCgm.nomCgm',
                    'attr' => [
                        'class' => 'select2-parameters',
                        'required' => 'required'
                    ],
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder("e")
                            ->where("e.exercicio = '" . $this->getExercicio() . "'");
                    },
                    'placeholder' => 'label.selecione',
                ]
            )
            ->add(
                'exercicio',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.exercicio',
                )
            )
            ->add(
                'codEmpenhoInicial',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codEmpenhoInicial',
                )
            )
            ->add(
                'codEmpenhoFinal',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.codEmpenhoFinal',
                )
            )
            ->add(
                'periodoInicial',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.periodoInicial',
                ),
                'sonata_type_date_picker',
                array(
                    'format' => 'dd/MM/yyyy',
                    'mapped' => false,
                )
            )
            ->add(
                'periodoFinal',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.preEmpenho.periodoFinal',
                ),
                'sonata_type_date_picker',
                array(
                    'format' => 'dd/MM/yyyy',
                    'mapped' => false,
                )
            )
            ->add(
                'numeroLiquidacaoInicial',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.liquidacaoEmpenho.numeroLiquidacaoInicial',
                )
            )
            ->add(
                'numeroLiquidacaoFinal',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.liquidacaoEmpenho.numeroLiquidacaoFinal',
                )
            )
            ->add(
                'vencimento',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.dtVencimento',
                ),
                'sonata_type_date_picker',
                array(
                    'format' => 'dd/MM/yyyy',
                    'mapped' => false,
                )
            )
            ->add(
                'fkEmpenhoPreEmpenho.fkSwCgm',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'label.responsavel',
                    'mapped' => false,
                ],
                'sonata_type_model_autocomplete',
                [
                    'property' => 'nomCgm',
                    'to_string_callback' => function (SwCgm $pessoa, $property) {
                        return $pessoa->getNumcgm() . ' - ' . $pessoa->getNomCgm();
                    }
                ]
            );
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
        if (!$value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $empenhoModel = new EmpenhoModel($entityManager);
        $codEmpenhoList = $empenhoModel->filterEmpenhoLiquidacao($filter);

        $ids = array();
        $entidades = array();
        foreach ($codEmpenhoList as $codEmpenho) {
            $ids[] = $codEmpenho->cod_empenho;
            $entidades[] = $codEmpenho->cod_entidade;
        }

        if (count($codEmpenhoList) > 0) {
            $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codEmpenho", $ids));
            $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codEntidade", $entidades));
            $queryBuilder->andWhere("{$alias}.exercicio = :exercicio");
            $queryBuilder->setParameter("exercicio", $this->getExercicio());
        } else {
            $queryBuilder->andWhere('1 = 0');
        }

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $listMapper
            ->add(
                'fkOrcamentoEntidade.fkSwCgm.nomCgm',
                null,
                [
                    'label' => 'entidade'
                ]
            )
            ->add(
                'codEmpenho',
                null,
                [
                    'label' => 'label.ordemPagamento.empenho',
                ]
            )
            ->add(
                'dtEmpenho',
                'date',
                [
                    'label' => 'label.ordemPagamento.dtEmpenho'
                ]
            )
            ->add(
                'numeroLiquidacao',
                'customField',
                [
                    'label' => 'label.ordemPagamento.numeroLiquidacao',
                    'template' => 'FinanceiroBundle::Empenho/Liquidacao/numeroLiquidacao.html.twig'
                ]
            )
            ->add('fkEmpenhoPreEmpenho.fkSwCgm', null, ['label' => 'label.ordemPagamento.credor'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'FinanceiroBundle:Sonata/Empenho/Liquidacao/CRUD:list__action_edit.html.twig'),
                    'reemitir' => array('template' => 'FinanceiroBundle:Sonata/Empenho/Liquidacao/CRUD:list__action_reemitir.html.twig'),
                    'anular' => array('template' => 'FinanceiroBundle:Sonata/Empenho/Liquidacao/CRUD:list__action_anular.html.twig'),
                    'reemitir_anulacao' => array('template' => 'FinanceiroBundle:Sonata/Empenho/Liquidacao/CRUD:list__action_reemitir_anulacao.html.twig'),
                )
            ));
    }

    /**
     * @param $object
     * @return array
     */
    public function getDadosEmpenho($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $preEmpenhoDespesa = $entityManager->getRepository(PreEmpenhoDespesa::class)
            ->findOneBy([
                'codPreEmpenho' => $object->getCodPreEmpenho(),
                'exercicio' => $object->getExercicio()
            ]);

        $despesa = $entityManager->getRepository(Despesa::class)
            ->getDespesaLiquidacaoEmpenho(
                $this->getExercicio(),
                $preEmpenhoDespesa->getCodDespesa()
            );

        if ($despesa['num_orgao']) {
            $unidadeObject = $entityManager->getRepository(Unidade::class)
                ->findOneBy([
                    'numOrgao' => $despesa['num_orgao'],
                    'exercicio' => $despesa['exercicio'],
                    'numUnidade' => $despesa['num_unidade']
                ]);

            $despesa['unidadeObject'] = $unidadeObject;
        }

        $preEmpenho = $entityManager->getRepository(PreEmpenho::class)
            ->findOneBy([
                'codPreEmpenho' => $object->getCodPreEmpenho(),
                'exercicio' => $object->getExercicio()
            ]);

        $atributoDinamicoModel = new AtributoDinamicoModel($entityManager);
        $atributosDinamicosPreEmpenho = $atributoDinamicoModel
            ->getAtributosDinamicosPreEmpenho($object->getCodPreEmpenho(), $this->getExercicio());

        // Parse dos atributos do tipo Lista
        foreach ($atributosDinamicosPreEmpenho as $key => $atributoDinamico) {
            if ($atributoDinamico['nom_tipo'] == 'Lista') {
                $valores = explode('[][][]', $atributoDinamico['valor_padrao_desc']);

                if (array_key_exists($atributoDinamico['valor'] - 1, $valores)) {
                    $atributosDinamicosPreEmpenho[$key]['valor'] = $valores[$atributoDinamico['valor'] - 1];
                }
            }
        }

        $despesaModel = new DespesaModel($entityManager);
        $saldoDotacao = $despesaModel->recuperaSaldoDotacao($object->getExercicio(), $preEmpenhoDespesa->getCodDespesa());
        $saldoDotacao = array_shift($saldoDotacao);

        return [
            'empenho' => $object,
            'despesa' => $despesa,
            'preEmpenho' => $preEmpenho,
            'atributosDiamicosPreEmpenho' => $atributosDinamicosPreEmpenho,
            'saldoDotacao' => $saldoDotacao['saldo_dotacao']
        ];
    }

    /**
     * @return mixed
     */
    private function getUf()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $configuracaoModel = new ConfiguracaoModel($em);
        $configuracaoUf = $configuracaoModel->pegaConfiguracao('cod_uf', 2, $this->getExercicio());
        $configuracaoUf = array_shift($configuracaoUf);

        return $em->getRepository('CoreBundle:SwUf')
            ->findOneByCodUf($configuracaoUf['valor']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();

        $empenhoListErros = $this->getRequest()->getSession()->get('empenhoListErros');

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $tipo = $this->getRequest()->query->get('tipo');
        if (is_null($tipo)) {
            $tipo = 'liquidar';
        }

        if ($tipo == 'anular') {
            $this->setLegendButtonSave('block', 'Anular');
        }

        if ($tipo == 'detalhe') {
            $this->exibirBotaoSalvar = false;
        }

        $exercicio = $this->getSubject()->getExercicio();

        $uf = $this->getUf();

        $documentoFiscal = new DocumentoFiscal(new DocumentoFiscalFactory(), $em, $container->get('session'));
        $documentoFiscal->setType($uf->getSiglaUf());
        $documentoFiscalFields = $documentoFiscal->form();

        $empenhoModel = new EmpenhoModel($em);

        $itensArray = $empenhoModel->consultarValorItemLiquidacaoEmpenho(
            $this->getSubject()->getCodEmpenho(),
            $this->getSubject()->getExercicio(),
            $this->getSubject()->getCodEntidade()
        );

        // Faz um parse apenas para calcular o vl_liquidado_real e o vl_a_liquidar
        $itens = $empenhoModel->parseItensLiquidacaoEmpenho($itensArray, $empenhoListErros);

        $this->setEmpenhoList($itens['itens']);

        $assinaturaList = $em->getRepository('CoreBundle:Empenho\\EmpenhoAssinatura')
            ->getCgmAssinatura($this->getSubject()->getExercicio(), $this->getSubject()->getCodEntidade());

        $assinaturasChoice = [];
        foreach ($assinaturaList as $key) {
            $assinaturasChoice[$key->nom_cgm . ' - ' . $key->cargo] = $key->nom_cgm . ' - ' . $key->cargo;
        }

        $formMapper
            ->with('label.emitirEmpenhoAutorizacao.dadosEmpenho')
            ->add('tipo', 'hidden', [
                'data' => $tipo,
                'mapped' => false
            ])
            ->add('id', 'hidden', [
                'data' => $id,
                'mapped' => false
            ])
            ->add(
                'dadosEmpenho',
                'customField',
                [
                    'mapped' => false,
                    'label' => false,
                    'template' => 'FinanceiroBundle::Empenho/Liquidacao/header.html.twig',
                    'data' => [
                        'empenhoInfo' => $this->getDadosEmpenho($this->getSubject()),
                        'tipo' => $tipo,
                        'totalEmpenho' => !$itens['totalEmpenho'] ? 0 : $itens['totalEmpenho']
                    ],
                    'attr' => [
                        'class' => ''
                    ]
                ]
            )
            ->end();

        $formMapper
            ->with('label.itensEmpenho')
            ->add(
                'itensEmpenho',
                'customField',
                [
                    'mapped' => false,
                    'label' => false,
                    'template' => 'FinanceiroBundle::Empenho/Liquidacao/edit.html.twig',
                    'data' => [
                        'itens' => $itens['itens'],
                        'errors' => $empenhoListErros,
                        'tipo' => $tipo
                    ],
                    'attr' => [
                        'class' => ''
                    ]
                ]
            );

        if ($tipo == 'anular') {
            $formMapper->end();
        }

        if ($tipo == 'liquidar') {
            $formMapper
                ->add(
                    'totalEmpenho',
                    'money',
                    [
                        'label' => 'label.totalEmpenho',
                        'mapped' => false,
                        'data' => !$itens['totalEmpenho'] ? 0 : $itens['totalEmpenho'],
                        'currency' => 'BRL',
                        'attr' => [
                            'class' => ' ',
                            'readonly' => $id ? true : false
                        ]
                    ]
                )
                ->add(
                    'totalLiquidar',
                    'money',
                    [
                        'label' => 'label.totalALiquidar',
                        'mapped' => false,

                        'data' => (!isset($itens['totaLiquidar']) || !$itens['totaLiquidar']) ? 0 : $itens['totaLiquidar'],
                        'currency' => 'BRL',
                        'attr' => [
                            'class' => ' ',
                            'readonly' => $id ? true : false
                        ]
                    ]
                )
                ->add(
                    'saldoLiquidar',
                    'money',
                    [
                        'label' => 'label.saldoALiquidar',
                        'mapped' => false,
                        'data' => !$itens['saldoALiquidar'] ? 0 : $itens['saldoALiquidar'],
                        'currency' => 'BRL',
                        'attr' => [
                            'class' => 'money ',
                            'readonly' => $id ? true : false

                        ]
                    ]
                )
                ->end()
                ->with('label.liquidacao')
                ->add(
                    'dtLiquidacao',
                    'sonata_type_date_picker',
                    [
                        'label' => 'label.dtLiquidacao',
                        'format' => 'dd/MM/yyyy',
                        'mapped' => false,
                        'dp_default_date' => date('d/m/Y')
                    ]
                )
                ->add(
                    'dtVencimento',
                    'sonata_type_date_picker',
                    [
                        'label' => 'label.dtVencimento',
                        'format' => 'dd/MM/yyyy',
                        'mapped' => false,
                        'dp_default_date' => '31/12/' . $this->getExercicio()
                    ]
                )
                ->end();

            $formMapper
                ->with('label.documentoFiscal');

            $formMapper
                ->add('incluirDocumentoFiscal', 'choice', [
                    'label' => 'label.incluirDocumentoFiscal',
                    'choices' => [
                        'label_type_yes' => 1,
                        'label_type_no' => 0
                    ],
                    'data' => 0,
                    'expanded' => true,
                    'required' => true,
                    'mapped' => false,
                    'label_attr' => ['class' => 'checkbox-sonata'],
                    'attr' => ['class' => 'checkbox-sonata ppa-sub-tipo-acao']
                ]);

            foreach ($documentoFiscalFields as $key => $field) {
                $formMapper->add(
                    $key,
                    $field['type'],
                    $field['options']
                );
            }

            $formMapper->end();

            $formMapper
                ->with('label.atributos');


            $atributoDinamicoModel = new AtributoDinamicoModel($em);
            $atributosDinamicosPreEmpenho = $atributoDinamicoModel
                ->getAtributosDinamicosPreEmpenho($this->getSubject()->getCodPreEmpenho(), $this->getExercicio());

            $atributosModalidade = array_filter($atributosDinamicosPreEmpenho, function ($atributosModalidade) {
                return $atributosModalidade['nom_atributo'] == 'Modalidade';
            });

            $preEmpenhoModel = new PreEmpenhoModel($em);
            $atributos = $preEmpenhoModel->getAtributosDinamicos();

            foreach ($atributos as $atributo) {
                if ($atributo->nom_atributo != 'Modalidade') {
                    continue;
                }
                $type = "choice";
                $field_name = 'Atributo_' . $atributo->cod_atributo . '_' . $atributo->cod_cadastro;
                $valor_padrao = explode(",", $atributo->valor_padrao);
                $valor_padrao_desc = explode("[][][]", $atributo->valor_padrao_desc);
                $choices = array();

                foreach ($valor_padrao_desc as $key => $desc) {
                    $choices[$desc] = $valor_padrao[$key];
                }

                $formOptions[$field_name] = array(
                    'label' => $atributo->nom_atributo,
                    'choices' => $choices,
                    'required' => !$atributo->nao_nulo,
                    'mapped' => false,
                    'disabled' => true,
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                    'data' => current($atributosModalidade)['valor'],
                    'placeholder' => 'label.selecione',
                );

                $formMapper->add(
                    $field_name,
                    $type,
                    $formOptions[$field_name]
                );
            }

            $formMapper->end()
                ->with('label.assinaturas')
                ->add('exercicio', 'hidden', [
                    'data' => $exercicio,
                    'mapped' => false
                ])
                ->add('assinaturas', 'choice', [
                    'choices' => $assinaturasChoice,
                    'label' => 'label.assinaturas',
                    'multiple' => true,
                    'mapped' => false,
                    'required' => false,
                    'attr' => ['class' => 'select2-parameters']
                ])
                ->end();
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $empenhoListErros = $this->getRequest()->getSession()->get('empenhoListErros');

        $em = $this->modelManager->getEntityManager($this->getClass());

        $tipo = $this->getRequest()->query->get('tipo');
        if (is_null($tipo)) {
            $tipo = 'liquidar';
        }

        if ($tipo == 'anular') {
            $this->setLegendButtonSave('block', 'Anular');
        }

        if ($tipo == 'detalhe') {
            $this->exibirBotaoSalvar = false;
        }

        $empenhoModel = new EmpenhoModel($em);

        $itensArray = $empenhoModel->consultarValorItemLiquidacaoEmpenho(
            $this->getSubject()->getCodEmpenho(),
            $this->getSubject()->getExercicio(),
            $this->getSubject()->getCodEntidade()
        );

        // Faz um parse apenas para calcular o vl_liquidado_real e o vl_a_liquidar
        $itens = $empenhoModel->parseItensLiquidacaoEmpenho($itensArray, $empenhoListErros);

        $showMapper
            ->add(
                'dadosEmpenho',
                'customField',
                [
                    'mapped' => false,
                    'label' => false,
                    'template' => 'FinanceiroBundle::Empenho/Liquidacao/header_show.html.twig',
                    'data' => [
                        'empenhoInfo' => $this->getDadosEmpenho($this->getSubject()),
                        'tipo' => $tipo,
                        'totalEmpenho' => !$itens['totalEmpenho'] ? 0 : $itens['totalEmpenho']
                    ],
                    'attr' => [
                        'class' => ''
                    ]
                ]
            )
            ->add(
                'itensEmpenho',
                'customField',
                [
                    'mapped' => false,
                    'label' => false,
                    'template' => 'FinanceiroBundle::Empenho/Liquidacao/registros.html.twig',
                    'data' => [
                        'itens' => $itens['itens'],
                    ],
                    'attr' => [
                        'class' => ''
                    ]
                ]
            );
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $container = $this->getContainer();
        $entityManager = $this->getContainer()->get('doctrine')->getManager();

        $entityManager->getConnection()->beginTransaction();

        try {
            $uniqid = $this->getRequest()->query->get('uniqid');
            $dataForm = $this->getRequest()->request->all();

            $info = null;
            $tipo = $dataForm[$uniqid]['tipo'];

            if ($tipo == 'liquidar') {
                $liquidar = $this->liquidar($object);

                list($notaLiquidacao, $total) = $liquidar;

                // Função que gera o lote e sequencia
                $liquidacaoModel = new LiquidacaoModel($entityManager);
                $info = $liquidacaoModel->executaRestosAPagar($object, $this->getExercicio(), $notaLiquidacao, $total);
            } elseif ($tipo == 'anular') {
                $anular = $this->anular($object);

                list($notaLiquidacao, $total) = $anular;

                if (!$total) {
                    $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.liquidacaoEmpenho.nunhumItem'));
                    return false;
                }

                // Função que gera o lote e sequencia
                $liquidacaoModel = new LiquidacaoModel($entityManager);
                $info = $liquidacaoModel->executaAnulacaoLiquidacao($object, $this->getExercicio(), $notaLiquidacao, $total);
            }

            if (!count($info)) {
                $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.liquidacaoEmpenho.erroLoteSequencia'));
                return false;
            }

            $codLote = $info['codLote'];
            $sequencia = $info['sequencia'];

            // Salva lancamento_empenho
            $lancamentoEmpenho = new LancamentoEmpenho();
            $lancamentoEmpenho->setExercicio($this->getExercicio());
            $lancamentoEmpenho->setCodEntidade($object->getCodEntidade());
            $lancamentoEmpenho->setTipo('L');
            $lancamentoEmpenho->setCodLote($codLote);
            $lancamentoEmpenho->setSequencia($sequencia);

            $lancamento = $entityManager->getRepository(Lancamento::class)
                ->findOneBy([
                    'exercicio' => $this->getExercicio(),
                    'codEntidade' => $object->getCodEntidade(),
                    'tipo' => 'L',
                    'codLote' => $codLote,
                    'sequencia' => $sequencia
                ]);

            $lancamentoEmpenho->setFkContabilidadeLancamento($lancamento);

            if ($tipo == 'liquidar') {
                $uf = $this->getUf();

                // Salva documento fiscal conforme o UF e caso tenha sido selecionada a opção
                $documentoFiscal = new DocumentoFiscal(
                    new DocumentoFiscalFactory(),
                    $entityManager,
                    $container->get('session')
                );
                $documentoFiscal->setType($uf->getSiglaUf());
                $documentoFiscal->setNotaLiquidacao($notaLiquidacao);
                $documentoFiscal->setDataForm($this->getForm()->all());
                $documentoFiscal->execute();
            }
        } catch (\Exception $e) {
            $entityManager->getConnection()->rollback();
            $error = 'Erro ao realizar a Liquidação do Empenho';
            $container->get('session')->getFlashBag()->add('error', $error);
        }

        $entityManager->persist($lancamentoEmpenho);
        $entityManager->getConnection()->commit();
        $entityManager->flush();

        $this->forceRedirect(sprintf('/financeiro/empenho/liquidar-empenho/%d~%s~%d/show', $object->getCodEmpenho(), $object->getExercicio(), $object->getCodEntidade()));
        $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.liquidacaoEmpenho.msgSucesso'));
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $uniqid = $this->getRequest()->query->get('uniqid');
        $formData = $this->getRequest()->request->get($uniqid);

        if ($formData['tipo'] == 'liquidar') {
            $entityManager = $this->modelManager->getEntityManager($this->getClass());

            $ultimoMesEncerrado = $entityManager->getRepository(EncerramentoMes::class)
                ->getUltimoMesEncerrado($this->getExercicio());

            $dtLiquidacao = $formData['dtLiquidacao'];
            $dtEmissaoNF = \DateTime::createFromFormat("d/m/Y", $formData['dtEmissaoNF']);

            $dtValidacao = explode('/', $dtLiquidacao);

            list(, $mesLiquidacao,) = $dtValidacao;

            if ($ultimoMesEncerrado != false && $ultimoMesEncerrado->mes >= (int) $mesLiquidacao) {
                $error = "Mês da Autorização encerrado!";
                $errorElement->with('motivo')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
            }

            if ($this->getForm()->get('dtLiquidacao')->getData()->format('Y-m-d') > date('Y-m-d')) {
                $error = "A data de liquidação deve ser menor ou igual atual.";
                $errorElement->with('dtLiquidacao')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
            }

            $formatDtLiquidacao = new DateTime($dtValidacao[2] . '-' . $dtValidacao[1] . '-' . $dtValidacao[0]);
            $formatDtExercicio = new DateTime($this->getExercicio() . '-' . 12 . '-' . 31);

            if ($formatDtLiquidacao->format('Y-m-d') < $dtEmissaoNF->format('Y-m-d')) {
                $error = $this->getTranslator()->trans(
                    'label.liquidacaoEmpenho.erroDataMaiorEmissaoNF',
                    [
                        '%dtEmissaoNF%' => $dtEmissaoNF->format('d/m/Y') ,
                        '%dtLiquidacao%' => $formatDtLiquidacao->format('d/m/Y')
                    ]
                );
                $errorElement->with('dtEmissaoNF')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
            }

            if ($formatDtLiquidacao->format('Y-m-d') > $formatDtExercicio->format('Y-m-d')) {
                $error = $this->getTranslator()->trans(
                    'label.liquidacaoEmpenho.erroDataMenorEmpenho',
                    [
                        '%dtLiquidacao%' => $dtLiquidacao,
                        '%dtExercicio%' => $formatDtExercicio->format('d/m/Y')
                    ]
                );
                $errorElement->with('dtLiquidacao')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
            }

            $totalLiquidar = number_format((float) $formData['totalLiquidar'], 2, '.', '');
            $totalEmpenho = number_format((float) $formData['totalEmpenho'], 2, '.', '');

            if ($totalLiquidar > $totalEmpenho) {
                $error = $this->getTranslator()->trans(
                    'label.liquidacaoEmpenho.erroValorMaiorEmpenho',
                    [
                        '%totalLiquidar%' => $formData['totalLiquidar'],
                        '%totalEmpenho%' => $formData['totalEmpenho']
                    ]
                );
                $errorElement->with('totalLiquidar')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
            }
        }

        if ($formData['tipo'] == 'anular') {
            $empenhoList = $this->getEmpenhoList();

            $dataForm = $this->getRequest()->request->all();

            $itens = $dataForm['itensEmpenho'];

            $errorEmpenhoList = [];
            $this->getRequest()->getSession()->set('empenhoListErros', $errorEmpenhoList);

            foreach ($itens as $key => $item) {
                if (!$item) {
                    continue;
                }

                if ((int) $item > $empenhoList[$key - 1]['valor_restante_anular']) {
                    $errorEmpenhoList[$key] = $empenhoList[$key - 1];
                }
            }

            if (count($errorEmpenhoList) > 0) {
                $this->getRequest()->getSession()->set('empenhoListErros', $errorEmpenhoList);

                $error = "Valor a anular informado é maior que o disponível";
                $errorElement->with('dtAnulacao')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
            } else {
                $this->getRequest()->getSession()->set('empenhoListErros', []);
            }

            $formatDtAnulacao = (new DateTime())->createFromFormat('d/m/Y', $dataForm['dtAnulacao']);

            if ($object->getFkEmpenhoNotaLiquidacoes()->last()->getDtLiquidacao() && $formatDtAnulacao < $object->getFkEmpenhoNotaLiquidacoes()->last()->getDtLiquidacao()) {
                $error = $this->getTranslator()->trans(
                    'label.liquidacaoEmpenho.erroDataMenorLiquidacao',
                    [
                        '%dtAnulacao%' => (string) $dataForm['dtAnulacao'],
                        '%dtLiquidacao%' => (string) $object->getFkEmpenhoNotaLiquidacoes()->last()->getDtLiquidacao()->format('d/m/Y')
                    ]
                );
                $errorElement->with('dtAnulacao')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
            }
        }
    }

    /**
     * @param $object
     * @return array
     */
    public function verificaStatus($object)
    {
        $empenhoListErros = $this->getRequest()->getSession()->get('empenhoListErros');

        $em = $this->modelManager->getEntityManager($this->getClass());

        $empenhoModel = new EmpenhoModel($em);

        $itensArray = $empenhoModel->consultarValorItemLiquidacaoEmpenho(
            $object->getCodEmpenho(),
            $object->getExercicio(),
            $object->getCodEntidade()
        );

        // Faz um parse apenas para calcular o vl_liquidado_real e o vl_a_liquidar
        $itens = $empenhoModel->parseItensLiquidacaoEmpenho($itensArray, $empenhoListErros);

        $notaLiquidacaoRepository = $em->getRepository(NotaLiquidacao::class);
        $notaLiquidacao = $notaLiquidacaoRepository->findOneBy([
            'exercicio' => $object->getExercicio(),
            'codEntidade' => $object->getCodEntidade(),
            'codEmpenho' => $object->getCodEmpenho()
        ]);

        $anulado = [];
        if ($notaLiquidacao) {
            $notaLiquidacaoItemAnuladoRepository = $em->getRepository(NotaLiquidacaoItemAnulado::class);
            $anulado = $notaLiquidacaoItemAnuladoRepository->findBy([
                'exercicio' => $object->getExercicio(),
                'codEntidade' => $object->getCodEntidade(),
                'codPreEmpenho' => $object->getCodPreEmpenho(),
                'codNota' => $notaLiquidacao->getCodNota()
            ]);
        }

        return [
            'liquidacao' => count($notaLiquidacao) > 0,
            'anulacao' => count($anulado) > 0,
            'totalLiquidar' => $itens['totalLiquidar'] > 0,
            'saldoALiquidar' => $itens['saldoALiquidar'] > 0
        ];
    }

    /**
     * @param $object
     * @return array
     */
    protected function liquidar($object)
    {
        $uniqid = $this->getRequest()->query->get('uniqid');
        $dataForm = $this->getRequest()->request->all();

        $entityManager = $this->getContainer()->get('doctrine')->getManager();

        $atributos = [];
        foreach ($dataForm[$uniqid] as $key => $field) {
            $pos = strpos($key, 'Atributo_');
            if ($pos === false) {
                continue;
            }
            $atributos[$key] = $field;
        }

        // Salva em nota_liquidacao
        $notaLiquidacaoModel = new NotaLiquidacaoModel($entityManager);

        $notaLiquidacao = $notaLiquidacaoModel
            ->populaNotaLiquidacao($object, $dataForm, $this->getExercicio(), $uniqid);

        // Salva em nota_liquidacao_item
        $itens = $dataForm['itensEmpenho'];

        $notaLiquidacaoItemModel = new NotaLiquidacaoItemModel($entityManager);

        $total = 0;
        foreach ($itens as $key => $item) {
            $total += $item;
            $notaLiquidacaoItem = $notaLiquidacaoItemModel
                ->populaNotaLiquicaoItem($object, $notaLiquidacao, $key, $item, $this->getExercicio());

            $notaLiquidacao->addFkEmpenhoNotaLiquidacaoItens($notaLiquidacaoItem);
            $entityManager->persist($notaLiquidacao);
        }

        // Salva Atributos Dinamicos
        foreach ($atributos as $key => $atributo) {
            $valores = explode('_', $key);
            list(, $codAtributo, $codCadastro) = $valores;

            $atributoLiquidacao = new AtributoLiquidacaoValor();
            $atributoLiquidacao->setFkEmpenhoNotaLiquidacao($notaLiquidacao);
            $atributoLiquidacao->setValor($atributo);

            $atributoDinamico = $entityManager->getRepository(AtributoDinamico::class)
                ->findOneBy([
                    'codModulo' => ConfiguracaoModel::MODULO_FINANCEIRO_EMPENHO,
                    'codCadastro' => $codCadastro,
                    'codAtributo' => $codAtributo
                ]);

            $atributoLiquidacao->setFkAdministracaoAtributoDinamico($atributoDinamico);

            $entityManager->persist($atributoLiquidacao);
        }

        return [
            $notaLiquidacao,
            $total
        ];
    }

    /**
     * @param $object
     * @return array
     */
    protected function anular($object)
    {
        // Insere em empenho.nota_liquidacao_item_anulado
        $dataForm = $this->getRequest()->request->all();

        $entityManager = $this->getContainer()->get('doctrine')->getManager();

        // Salva em nota_liquidacao_item_anulado
        $itens = $dataForm['itensEmpenho'];

        $notaLiquidacaoItem = null;

        $total = 0;
        $qtdItensAnulados = 0;
        foreach ($itens as $key => $item) {
            if (!$item) {
                continue;
            }

            // Busca a nota liquidacao do empenho para anular os itens
            $notaLiquidacaoItem = $entityManager->getRepository('CoreBundle:Empenho\\NotaLiquidacaoItem')
                ->findOneBy([
                    'exercicio' => $object->getExercicio(),
                    'codEntidade' => $object->getCodEntidade(),
                    'codPreEmpenho' => $object->getCodPreEmpenho(),
                    'numItem' => $key
                ]);

            $notaLiquidacaoItemAnulado = new NotaLiquidacaoItemAnulado();
            $notaLiquidacaoItemAnulado->setFkEmpenhoNotaLiquidacaoItem($notaLiquidacaoItem);
            $notaLiquidacaoItemAnulado->setVlAnulado($item);
            $notaLiquidacaoItemAnulado->setTimestamp(new DateTimeMicrosecondPK());

            $entityManager->persist($notaLiquidacaoItemAnulado);

            $total += $item;

            $qtdItensAnulados++;
        }

        if (!$qtdItensAnulados) {
            return [];
        }

        $entityManager->flush();

        return [
            $notaLiquidacaoItem->getFkEmpenhoNotaLiquidacao(),
            $total
        ];
    }

    /**
     * @param $empenhoList
     */
    public function setEmpenhoList($empenhoList)
    {
        $this->empenhoList = $empenhoList;
    }

    /**
     * @return array
     */
    public function getEmpenhoList()
    {
        return $this->empenhoList;
    }

    public function getEmpenhoListErrors()
    {
        return $this->empenhoListErrors;
    }

    public function setEmpenhoListErrors($empenhoListErrors)
    {
        $this->empenhoListErrors = $empenhoListErrors;
    }
}
