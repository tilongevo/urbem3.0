<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento\Suplementacao;

use Doctrine\ORM\EntityRepository;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Contabilidade\LancamentoTransferencia;
use Urbem\CoreBundle\Entity\Contabilidade\TipoTransferencia;
use Urbem\CoreBundle\Entity\Contabilidade\TransferenciaDespesa;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\Recurso;
use Urbem\CoreBundle\Entity\Orcamento\Suplementacao;
use Urbem\CoreBundle\Model\Tesouraria\TipoTransferenciaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Services\Orcamento\Suplementacao\Lancamento;
use Urbem\CoreBundle\Services\Orcamento\Suplementacao\LancamentoFactory;

class SuplementacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_suplementacao';
    protected $baseRoutePattern = 'financeiro/orcamento/suplementacao';
    protected $defaultObjectId = 'codSuplementacao';
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoEditar = false;
    protected $suplementadas = ['2', '4', '5', '6_1', '7', '9', '10', '11', '11_1'];
    protected $subTipo = null;
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'codSuplementacao',
    ];
    protected $exibirMensagemFiltro = false;
    protected $includeJs = array(
        '/financeiro/javascripts/orcamento/suplementacao/suplementacao.js'
    );

    protected function addButtonsCollection()
    {
        $this->addlegendBtnCatalogue(['icon' => 'add_circle', 'text' => 'Adicionar Dotações Redutoras'], 'firstButton');
        $this->addlegendBtnCatalogue(['icon' => 'add_circle', 'text' => 'Adicionar Dotações Suplementadas'], 'secondButton');
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('anular', 'anular/' . $this->getRouterIdParameter());
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $this->getExercicio());

        if (! $this->getRequest()->query->get('filter')) {
            $query->andWhere('1 = 0');
            $this->exibirMensagemFiltro = true;
        } else {
            $this->exibirMensagemFiltro = false;
        }

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('codSuplementacao'));

        $datagridMapper
            ->add(
                'leiDecreto',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.suplementacao.leiDecreto',
                ),
                'autocomplete',
                array(
                    'route' => array(
                        'name' => 'urbem_financeiro_ppa_acao_autocomplete_norma'
                    )
                )
            )
            ->add(
                'dotacao',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.suplementacao.dotacoes',
                ),
                'autocomplete',
                array(
                    'route' => array(
                        'name' => 'financeiro_api_orcamento_autocomplete_conta_despesa'
                    ),
                    'req_params' => array(
                        'exercicio' => $this->getExercicio()
                    )
                )
            )
            ->add(
                'recurso',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.suplementacao.recurso',
                ),
                'entity',
                array(
                    'class' => Recurso::class,
                    'placeholder' => 'label.selecione',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('o')
                            ->where('o.exercicio = :exercicio')
                            ->setParameter('exercicio', $this->getExercicio());
                    }
                )
            )
            ->add(
                'periodoInicial',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.suplementacao.periodoInicial',
                ),
                'sonata_type_date_picker',
                array(
                    'format' => 'dd/MM/yyyy',
                )
            )
            ->add(
                'periodoFinal',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.suplementacao.periodoFinal',
                ),
                'sonata_type_date_picker',
                array(
                    'format' => 'dd/MM/yyyy',
                )
            )
            ->add(
                'fkContabilidadeTipoTransferencia',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.suplementacao.tipo',
                ),
                'entity',
                array(
                    'class' => TipoTransferencia::class,
                    'placeholder' => 'label.selecione',
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('o')
                            ->where('o.exercicio = :exercicio')
                            ->setParameter('exercicio', $this->getExercicio());
                    }
                )
            )
            ->add(
                'situacao',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.suplementacao.situacao',
                ),
                'choice',
                array(
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                    'choices' => array(
                        'Válidas' => 'v',
                        'Anuladas' => 'a'
                    ),
                    'placeholder' => 'Todas'
                )
            )
            ->add(
                'codEntidade',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.suplementacao.entidade',
                ),
                'entity',
                array(
                    'class' => 'CoreBundle:Orcamento\Entidade',
                    'choice_value' => 'codEntidade',
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('o')
                            ->where('o.exercicio = :exercicio')
                            ->setParameter('exercicio', $this->getExercicio());
                    },
                    'multiple'  => true
                )
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $ids = explode('~', $id);
        list($exercicio, $codSuplementacao) = $ids;

        $em = $this->modelManager->getEntityManager($this->getClass());
        $suplementacaoObj = $em->getRepository('CoreBundle:Orcamento\Suplementacao')->findOneBy([
            'exercicio' => $exercicio,
            'codSuplementacao' => $codSuplementacao
        ]);

        $suplementacao = $em->getRepository('CoreBundle:Orcamento\Suplementacao')
            ->getSuplementacaoDados($suplementacaoObj);
        $suplementacao = array_shift($suplementacao);

        $suplementacao['anulado'] = 'Válida';
        if (!is_null($suplementacao['dt_anulacao'])) {
            $suplementacao['anulado'] = 'Anulada';
        }

        $showMapper
            ->with('label.suplementacao.dados')
            ->add(
                'fkNormasNorma.nomNorma',
                'entity',
                [
                    'label' => 'label.suplementacao.leiDecreto',
                ]
            )
            ->add(
                'dtSuplementacao',
                null,
                [
                    'label' => 'label.suplementacao.dtSuplementacao'
                ]
            )
            ->add(
                'fkContabilidadeTipoTransferencia.nomTipo',
                'entity',
                [
                    'label' => 'label.suplementacao.tipo'
                ]
            )
            ->add(
                'motivo',
                'text',
                [
                    'label' => 'label.suplementacao.motivo'
                ]
            )
            ->add(
                'valor',
                'text',
                [
                    'label'      => 'label.suplementacao.valor',
                    'data'       => $suplementacao['vl_suplementacao'],
                    'template'   => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                ]
            )
            ->add(
                'status',
                'text',
                [
                    'label'      => 'label.suplementacao.status',
                    'data'       => $suplementacao['anulado'],
                    'template'   => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                ]
            )
            ->add(
                'dtAnulacao',
                'text',
                [
                    'label'      => 'label.suplementacao.dtAnulacao',
                    'data'       => $suplementacao['dt_anulacao'],
                    'template'   => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                ]
            )
            ->add(
                'fkOrcamentoSuplementacaoSuplementadas',
                'string',
                [
                    'label' => 'label.dotacaoSuplementada',
                    'template' => 'FinanceiroBundle:Orcamento/CreditoSuplementar:list_suplementada.html.twig',
                ]
            )
            ->add(
                'fkOrcamentoSuplementacaoReducoes',
                'string',
                [
                    'label' => 'label.dotacaoReduzida',
                    'template' => 'FinanceiroBundle:Orcamento/CreditoSuplementar:list_reducao.html.twig',
                ]
            )
        ;

        $showMapper->end();
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $codSuplementacaoList = (new \Urbem\CoreBundle\Model\Orcamento\SuplementacaoModel($entityManager))
            ->filterSuplementacao($filter, $this->getExercicio());

        $ids = array();
        foreach ($codSuplementacaoList as $codSuplementacao) {
            $ids[] = $codSuplementacao->cod_suplementacao;
        }

        if (count($codSuplementacaoList) > 0) {
            $queryBuilder->andWhere($queryBuilder->expr()->in("{$alias}.codSuplementacao", $ids));
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
        $this->setBreadCrumb();

        $listMapper
            ->add('codSuplementacao', null, array('label' => 'label.codigo'))
            ->add('fkContabilidadeTipoTransferencia.nomTipo', null, array('label' => 'label.tipo'))
            ->add('dtSuplementacao', null, array('label' => 'label.suplementacao.dtSuplementacao'))
        ;
        $this->addActionsGrid($listMapper);
    }

    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'anular' => array('template' => 'FinanceiroBundle:Sonata/Acao/CRUD:list__action_anular.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->addButtonsCollection();

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions = array();

        $tipoTransferenciaRepository = $em->getRepository("CoreBundle:Contabilidade\\TipoTransferencia");
        $tipos = $tipoTransferenciaRepository->findBy([
            'exercicio' => $this->getExercicio()
        ]);

        $tipoChoice = array();
        foreach ($tipos as $tipoTransferencia) {
            $tipoChoice[$tipoTransferencia->getNomTipo()] = $tipoTransferencia->getCodTipo();
        }
        $tipoChoice[TipoTransferenciaModel::TYPE_REABRIR_CREDITO_EXTRAORDINARIO] = '11_1';
        $tipoChoice[TipoTransferenciaModel::TYPE_REABRIR_CREDITO_ESPECIAL] = '6_1';

        $fieldOptions['codTipo'] = array(
            'label'         => 'label.suplementacao.tipo',
            'placeholder' => 'label.selecione',
            'attr'          => [
                'class'       => 'select2-parameters'
            ],
            'mapped'       => false,
            'choices'         => $tipoChoice
        );

        $fieldOptions['entidade'] = array(
            'class' => Entidade::class,
            'choice_value' => 'codEntidade',
            'label'         => 'label.suplementacao.entidade',
            'mapped'       => false,
            'placeholder' => 'label.selecione',
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('o')
                    ->where('o.exercicio = :exercicio')
                    ->setParameter('exercicio', $this->getExercicio());
            },
            'attr'          => [
                'class'         => 'select2-parameters'
            ]
        );

        $fieldOptions['norma'] = array(
            'label' => 'label.suplementacao.leiDecreto',
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'route' => [
                'name' => 'urbem_financeiro_ppa_acao_autocomplete_norma'
            ]
        );

        $fieldOptions['valor'] = array(
            'label'         => 'label.suplementacao.valorTotal',
            'mapped'        => false,
            'currency' => 'BRL',
            'attr'          => array(
                'class' => 'money '
            ),
        );

        $fieldOptions['valorRestante'] = array(
            'label'         => 'label.suplementacao.valorRestante',
            'mapped'        => false,
            'required'      => false,
            'attr'          => array(
                'class' => 'quantity',
                'readonly' => 'readonly'
            )
        );

        $fieldOptions['dtSuplementacao'] = array(
            'label' => 'label.suplementacao.dtSuplementacao',
            'format' => 'dd/MM/yyyy',
            'data' => new \Datetime()
        );

        $fieldOptions['codSuplementacaoReducao'] = array(
            'by_reference' => false,
            'label' => false,
            'required' => false,
        );

        $fieldOptions['codSuplementacaoReducaoOptions'] = array(
            'edit' => 'inline',
            'inline' => 'table',
            'delete' => false,
            'extra_fields_message' => [
                'name_button' => 'firstButton'
            ],
            'sortable' => 'position'
        );

        $fieldOptions['codSuplementacaoSuplementada'] = array(
            'by_reference' => false,
            'label' => false,
            'required' => false
        );

        $fieldOptions['codSuplementacaoSuplementadaOptions'] = array(
            'edit' => 'inline',
            'inline' => 'table',
            'delete' => false,
            'extra_fields_message' => [
                'name_button' => 'secondButton'
            ]
        );

        $formMapper
            ->with('label.suplementacao.dados')
                ->add('exercicio', 'hidden', ['mapped' => false, 'data' => $this->getExercicio()])
                ->add('codTipo', 'choice', $fieldOptions['codTipo'])
                ->add('entidade', 'entity', $fieldOptions['entidade'])
                ->add('norma', 'autocomplete', $fieldOptions['norma'])
                ->add('dtSuplementacao', 'sonata_type_date_picker', $fieldOptions['dtSuplementacao'])
                ->add('motivo', null, array('label' => 'label.suplementacao.motivo'))
                ->add('valor', 'money', $fieldOptions['valor'])
            ->end()
            ->with('label.suplementacao.dotacoes')
                ->add('fkOrcamentoSuplementacaoReducoes', 'sonata_type_collection', $fieldOptions['codSuplementacaoReducao'], $fieldOptions['codSuplementacaoReducaoOptions'])
                ->add('fkOrcamentoSuplementacaoSuplementadas', 'sonata_type_collection', $fieldOptions['codSuplementacaoSuplementada'], $fieldOptions['codSuplementacaoSuplementadaOptions'])
            ->end()
        ;
    }

    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $entityManager->getConnection()->beginTransaction();

        try {
            $uniqid = $this->getRequest()->query->get('uniqid');
            $formData = $this->getRequest()->request->get($uniqid);

            $codTipo = $formData['codTipo'];

            $tipo = explode('_', $formData['codTipo']);
            if (count($tipo) > 1) {
                list($codTipo, $codSubTipo) = $tipo;
                $this->subTipo = $codSubTipo;
            }

            // Salva suplementacao
            $emTipoTransferencia = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Contabilidade\TipoTransferencia');
            $tipoTransferencia = $emTipoTransferencia->getRepository('CoreBundle:Contabilidade\\TipoTransferencia')
                ->findOneBy(['codTipo' => $codTipo, 'exercicio' => $this->getExercicio()]);

            $object->setFkContabilidadeTipoTransferencia($tipoTransferencia);

            $emNorma = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Normas\Norma');
            $codNorma = $emNorma->getRepository('CoreBundle:Normas\\Norma')->findOneByCodNorma($formData['norma']);

            $object->setFkNormasNorma($codNorma);

            $object->setExercicio($this->getExercicio());

            $emSuplementacao = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Orcamento\Suplementacao');
            $codSuplementacao = $emSuplementacao->getRepository('CoreBundle:Orcamento\\Suplementacao')
                ->getNewCodSuplementacao($this->getExercicio());
            $object->setCodSuplementacao($codSuplementacao);

            // Salva suplamentacao_suplementada
            $suplementacaoSuplementadaCollection = $object->getFkOrcamentoSuplementacaoSuplementadas();
            if ($suplementacaoSuplementadaCollection->count()) {
                foreach ($suplementacaoSuplementadaCollection as $suplementacaoSuplementada) {
                    $suplementacaoSuplementada->setFkOrcamentoSuplementacao($object);
                }
            }

            // Salva suplementacao_reducao
            $suplementacaoReducaoCollection = $object->getFkOrcamentoSuplementacaoReducoes();
            foreach ($suplementacaoReducaoCollection as $suplementacaoReducao) {
                $suplementacaoReducao->setFkOrcamentoSuplementacao($object);
            }
        } catch (\Exception $e) {
            $entityManager->getConnection()->rollback();
            $container->get('session')->getFlashBag()
                ->add('error', $this->getTranslator()->trans('label.suplementacao.erroRealizarSuplementacao'));
        } finally {
            $this->forceRedirect('/financeiro/orcamento/suplementacao/list');
        }
    }

    public function preValidate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        $isValidSuplementacao = true;
        $suplementacaoSuplementadaCollection = $object->getFkOrcamentoSuplementacaoSuplementadas();
        if ($suplementacaoSuplementadaCollection->count()) {
            $suplementacoes = [];
            foreach ($suplementacaoSuplementadaCollection as $index => $suplementacaoSuplementada) {
                if (in_array($suplementacaoSuplementada->getCodDespesa(), $suplementacoes)) {
                    $isValidSuplementacao = false;
                    break;
                }
                array_push($suplementacoes, $suplementacaoSuplementada->getCodDespesa());
            }
        }

        if (!$isValidSuplementacao) {
            $container->get('session')->getFlashBag()
                ->add('error', $this->getTranslator()->trans('label.suplementacao.suplementacaoDuplicada'));
            (new RedirectResponse($this->request->headers->get('referer')))->send();
        }

        $suplementacaoReducaoCollection = $object->getFkOrcamentoSuplementacaoReducoes();
        $reducoes = [];
        $isValidReducao = true;
        foreach ($suplementacaoReducaoCollection as $index => $suplementacaoReducao) {
            if (in_array($suplementacaoReducao->getCodDespesa(), $reducoes)) {
                $isValidReducao = false;
                continue;
            }
            array_push($reducoes, $suplementacaoReducao->getCodDespesa());
        }

        if (!$isValidReducao) {
            $container->get('session')->getFlashBag()
                ->add('error', $this->getTranslator()->trans('label.suplementacao.reducaoDuplicada'));
            (new RedirectResponse($this->request->headers->get('referer')))->send();
        }
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $uniqid = $this->getRequest()->query->get('uniqid');

        $formData = $this->getRequest()->request->get($uniqid);
        $codTipo = $formData['codTipo'];

        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $ultimoMesEncerrado = $entityManager->getRepository("CoreBundle:Contabilidade\\EncerramentoMes")
            ->getUltimoMesEncerrado($this->getExercicio());

        $dtAutorizacao = date("m", mktime(0, 0, 0, date("m"), date("d"), $this->getExercicio()));

        if ($ultimoMesEncerrado && $ultimoMesEncerrado->mes >= (int) $dtAutorizacao) {
            $error = $this->getTranslator()->trans('mesAutorizacaoEncerrado');
            $errorElement->with('dtSuplementacao')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }

        if ($object->getDtSuplementacao()->format('Y-m-d') > date('Y-m-d')) {
            $error = $this->getTranslator()->trans('errorDataMaiorQueAtual');
            $errorElement->with('dtSuplementacao')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }

        if (in_array($codTipo, $this->suplementadas)) {
            if ((!$object->getFkOrcamentoSuplementacaoSuplementadas()->count())) {
                $mensagem = $this->getTranslator()->trans('label.suplementacao.suplementacaoRequerida');
                $errorElement->with('[codSuplementacaoSuplementada]')->addViolation($mensagem)->end();
            }
            return;
        }

        if ((!$object->getFkOrcamentoSuplementacaoReducoes()->count())) {
            $mensagem = $this->getTranslator()->trans('label.suplementacao.reducaoRequerida');
            $errorElement->with('[codSuplementacaoReducao]')->addViolation($mensagem)->end();
        }
    }

    public function postPersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $entityManager->getConnection()->beginTransaction();

        try {
            $uniqid = $this->getRequest()->query->get('uniqid');
            $formData = $this->getRequest()->request->get($uniqid);

            $emNorma = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Normas\Norma');
            $codNorma = $emNorma->getRepository('CoreBundle:Normas\\Norma')->findOneByCodNorma($formData['norma']);

            // Realiza Lançamento
            $lancamento = new Lancamento(new LancamentoFactory(), $entityManager, $container->get('session'));
            $lancamento->setType($object->getCodTipo());
            $lancamento->setExercicio($this->getExercicio());
            $lancamento->setEntidade($formData['entidade']);
            $lancamento->setDescricaoDecreto($codNorma);
            $lancamento->setValor($formData['valor']);

            if (!is_null($this->subTipo)) {
                $lancamento->setSubType((int) $this->subTipo);
            }

            // Realiza o lancamento
            $lancamento->execute();

            if (is_null($lancamento->getCodLote()) || is_null($lancamento->getSequencia())) {
                $container->get('session')->getFlashBag()
                    ->add('error', $this->getTranslator()->trans('label.suplementacao.erroLoteSequencia'));
                return false;
            }

            $lancamentoObj = $entityManager->getRepository('CoreBundle:Contabilidade\\Lancamento')
                ->findOneBy([
                    'sequencia' => $lancamento->getSequencia(),
                    'codLote' => $lancamento->getCodLote(),
                    'tipo' => 'S',
                    'exercicio' => $this->getExercicio()
                ]);

            // Realiza transferência
            $lancamentoTransferencia = new LancamentoTransferencia();
            $lancamentoTransferencia->setFkContabilidadeTipoTransferencia($object->getFkContabilidadeTipoTransferencia());
            $lancamentoTransferencia->setFkContabilidadeLancamento($lancamentoObj);

            $entityManager->persist($lancamentoTransferencia);

            $transferenciaDespesa = new TransferenciaDespesa();
            $transferenciaDespesa->setFkOrcamentoSuplementacao($object);
            $transferenciaDespesa->setFkContabilidadeLancamentoTransferencia($lancamentoTransferencia);

            $entityManager->persist($transferenciaDespesa);
            $entityManager->flush();
            $entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            $entityManager->getConnection()->rollback();
            $container->get('session')->getFlashBag()
                ->add('error', $this->getTranslator()->trans('label.suplementacao.erroLancamentoSuplementacao'));
        } finally {
            $this->forceRedirect('/financeiro/orcamento/suplementacao/list');
        }
    }

    public function canAnular($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $suplementacaoAnuladaRepository = $em->getRepository('CoreBundle:Orcamento\SuplementacaoAnulada');
        $suplementacaoAnulada = $suplementacaoAnuladaRepository->findBy([
            'exercicio' => $object->getExercicio(),
            'codSuplementacao' => $object->getCodSuplementacao()
        ]);

        if (count($suplementacaoAnulada) > 0) {
            return false;
        }
        return true;
    }

    public function toString($object)
    {
        return $object instanceof Suplementacao
            ? $object->getCodSuplementacao()
            : 'Suplementação';
    }
}
