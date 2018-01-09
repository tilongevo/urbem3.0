<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Exception;
use Urbem\CoreBundle\Exception\Error;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Frota;
use Urbem\CoreBundle\Entity\Orcamento;

use Urbem\CoreBundle\Model\Empenho;
use Urbem\CoreBundle\Model\Patrimonial\Frota\ManutencaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\AutorizacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\EfetivacaoModel;

class ManutencaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_manutencao';
    protected $baseRoutePattern = 'patrimonial/frota/manutencao';

    protected $includeJs = [
        '/patrimonial/javascripts/frota/manutencao.js',
    ];

    public function configure()
    {
        $this->setTemplate('show', 'PatrimonialBundle:Sonata\Frota\Manutencao\CRUD:show.html.twig');
    }

    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'get_autorizacao_info',
            'get-autorizacao-info'
        );

        $collection->remove('delete');
    }

    /**
     * Lista Customizada
     *
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface|\Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery
     */
    public function createQuery($context = 'list')
    {
        /**
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->modelManager->getEntityManager(Frota\Manutencao::class);

        $manutencaoModel = new ManutencaoModel($entityManager);

        $query = parent::createQuery($context);
        $query = $manutencaoModel->getManutencaoList($query, $this->getExercicio());

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();

        $datagridMapper
            ->add(
                'fkFrotaVeiculo',
                'composite_filter',
                [
                    'label' => 'label.frotaManutencao.codVeiculo',
                ],
                'entity',
                [
                    'class' => 'CoreBundle:Frota\Veiculo',
                    'choice_label' => function (Frota\Veiculo $veiculo) {
                        return (string) $veiculo;
                    },
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                    'placeholder' => 'label.selecione'
                ]
            )
            ->add(
                'fkFrotaEfetivacoes.fkFrotaAutorizacao.codAutorizacao',
                null,
                [
                    'label' => 'label.frotaManutencao.codAutorizacao',
                ],
                null,
                [
                    'attr' => array(
                        'class' => 'numeric '
                    ),
                ]
            )
            ->add(
                'dtManutencao',
                null,
                [
                    'label' => 'label.frotaManutencao.dtManutencao',
                ],
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                ]
            )
            ->add(
                'observacao',
                null,
                [
                    'label' => 'label.frotaManutencao.observacao'
                ]
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
                'codManutencaoExercicio',
                null,
                [
                    'label' => 'label.frotaManutencao.manutencao'
                ]
            )
            ->add(
                'fkFrotaVeiculo',
                null,
                [
                    'label' => 'label.frotaManutencao.codVeiculo',
                ]
            )
            ->add(
                'km',
                'text',
                [
                    'label' => 'label.frotaManutencao.km'
                ]
            )
            ->add(
                'dtManutencao',
                null,
                [
                    'label' => 'label.frotaManutencao.dtManutencao',
                ]
            )
            ->add(
                'observacao',
                'text',
                [
                    'label' => 'label.frotaManutencao.observacao'
                ]
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig')
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $exercicio = $this->getExercicio();

        $dtManutencao = new \DateTime();


        $fieldOptions['tipoManutencao'] = [
            'label' => false,
            'choices' => [
                'Autorização de Abastecimento' => Frota\Manutencao::TIPOMANUTENCAOAUTORIZACAO,
                'Outros' => Frota\Manutencao::TIPOMANUTENCAOOUTROS
            ],
            'expanded' => true,
            'multiple' => false,
            'mapped' => false
        ];

        $fieldOptions['codAutorizacao'] = [
            'class' => Frota\Autorizacao::class,
            'choice_label' => function (Frota\Autorizacao $autorizacao) {
                return $autorizacao->getCodAutorizacao() . '/' . $autorizacao->getExercicio();
            },
            'label' => 'label.frotaManutencao.codAutorizacao',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'required' => false,
            'placeholder' => 'label.selecione',
            'query_builder' => function (EntityRepository $em) {
                $subQb = $em->createQueryBuilder('m');
                $subQb
                    ->select('e.codAutorizacao')
                    ->from(Frota\Efetivacao::class, 'e')
                    ->where("e.exercicioAutorizacao = '{$this->getExercicio()}'");

                $qb = $em->createQueryBuilder('a');
                $qb->where("a.exercicio = '{$this->getExercicio()}'");
                $qb->andWhere($qb->expr()->notIn("{$qb->getRootAlias()}.codAutorizacao", $subQb->getDQL()));
                return $qb;
            }
        ];

        $fieldOptions['codVeiculo'] = [
            'class' => 'CoreBundle:Frota\Veiculo',
            'choice_label' => function (Frota\Veiculo $veiculo) {
                return (string) $veiculo;
            },
            'label' => 'label.frotaManutencao.codVeiculo',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions['dtManutencao'] = [
            'label' => 'label.frotaManutencao.dtManutencao',
            'format' => 'dd/MM/yyyy',
            'data' => $dtManutencao
        ];

        $fieldOptions['exercicio'] = [
            'label' => 'label.frotaManutencao.exercicio',
            'mapped' => false,
            'data' => $exercicio,
            'required' => false,
        ];

        $fieldOptions['codEntidade'] = [
            'class' => Orcamento\Entidade::class,
            'choice_label' => function (Orcamento\Entidade $entidade) {
                return (string) $entidade;
            },
            'label' => 'label.frotaManutencao.codEntidade',
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'required' => false,
            'placeholder' => 'label.selecione',
            'query_builder' => function (EntityRepository $em) {
                $qb = $em->createQueryBuilder('e');
                $qb->where("e.exercicio = '{$this->getExercicio()}'");
                return $qb;
            }
        ];

        $fieldOptions['codEmpenho'] =
            [
                'label' => 'label.frotaManutencao.codEmpenho',
                'mapped' => false,
                'required' => false,
            ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['dtManutencao']['data'] = $this->getSubject()->getDtManutencao();


            // Recupera ManutencaoEmpenho
            if (!empty($this->getSubject()->getFkFrotaManutencaoEmpenho())) {
                $fieldOptions['exercicio']['data'] = $this->getSubject()->getFkFrotaManutencaoEmpenho()->getExercicio();
                $fieldOptions['codEntidade']['data'] = $this->getSubject()->getFkFrotaManutencaoEmpenho()->getFkEmpenhoEmpenho()->getFkOrcamentoEntidade();
                $fieldOptions['codEmpenho']['data'] = $this->getSubject()->getFkFrotaManutencaoEmpenho()->getCodEmpenho();
            }

            // Recupera Efetivacao
            if ($this->getSubject()->getEfetivacao()) {
                $fieldOptions['tipoManutencao']['data'] = 'Autorização de Abastecimento';
                $fieldOptions['codAutorizacao']['data'] = $this->getSubject()->getEfetivacao()->getFkFrotaAutorizacao();
            } else {
                $fieldOptions['tipoManutencao']['data'] = 'Outros';
            }
            $fieldOptions['tipoManutencao']['attr']['readonly'] = 'readonly';
            unset($fieldOptions['tipoManutencao']['choices']);
            unset($fieldOptions['tipoManutencao']['expanded']);
            unset($fieldOptions['tipoManutencao']['multiple']);
        }

        if ($this->id($this->getSubject())) {
            $formMapper
                ->with('label.frotaManutencao.tipoManutencao')
                ->add(
                    'tipoManutencao',
                    'text',
                    $fieldOptions['tipoManutencao']
                )
                ->end();
        } else {
            $formMapper
                ->with('label.frotaManutencao.tipoManutencao')
                ->add(
                    'tipoManutencao',
                    'choice',
                    $fieldOptions['tipoManutencao']
                )
                ->end();
        }

        $formMapper
            ->with('label.frotaManutencao.manutencaoVeiculo')
            ->add(
                'codAutorizacao',
                'entity',
                $fieldOptions['codAutorizacao']
            )
            ->add(
                'fkFrotaVeiculo',
                'entity',
                $fieldOptions['codVeiculo']
            )
            ->add(
                'km',
                'text',
                [
                    'label' => 'label.frotaManutencao.km',
                    'required' => true,
                    'attr' => [
                        'class' => 'km '
                    ]
                ]
            )
            ->add(
                'dtManutencao',
                'sonata_type_date_picker',
                $fieldOptions['dtManutencao']
            )
            ->add(
                'observacao',
                'textarea',
                [
                    'required' => false,
                    'label' => 'label.frotaManutencao.observacao'
                ]
            )
            ->end()
            ->with('label.frotaManutencao.dadosPagto')
            ->add(
                'exercicio',
                'text',
                $fieldOptions['exercicio']
            )
            ->add(
                'fkOrcamentoEntidade',
                'entity',
                $fieldOptions['codEntidade']
            )
            ->add(
                'codEmpenho',
                'text',
                $fieldOptions['codEmpenho']
            )
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
    }

    /**
     * @param ErrorElement $errorElement
     * @param Frota\Manutencao $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        if (!empty($this->getForm()->get('codAutorizacao')->getData())) {
            if (strpos($this->getRequest()->get('_sonata_name'), 'edit') &&
                $object->getFkFrotaEfetivacoes()
            ) {
                if ($this->getForm()->get('codAutorizacao')->getData()->getCodAutorizacao() . '/' . $this->getForm()->get('codAutorizacao')->getData()->getExercicio() !=
                    $object->getEfetivacao()->getFkFrotaAutorizacao()->getCodAutorizacao() . '/' . $object->getEfetivacao()->getFkFrotaAutorizacao()->getExercicio()
                ) {
                    $em = $this->modelManager->getEntityManager('CoreBundle:Frota\Efetivacao');
                    $efetivacaoModel = new EfetivacaoModel($em);

                    $efetivacao = $efetivacaoModel
                        ->getEfetivacaoInfo(
                            $this->getForm()->get('codAutorizacao')->getData()
                        );

                    if (!empty($efetivacao)) {
                        $message = $this->trans('manutencao.errors.autorizacao', [], 'validators');

                        $errorElement->with('codAutorizacao')->addViolation($message)->end();
                    }
                }
            } else {
                $em = $this->modelManager->getEntityManager('CoreBundle:Frota\Efetivacao');
                $efetivacaoModel = new EfetivacaoModel($em);

                $efetivacao = $efetivacaoModel
                    ->getEfetivacaoInfo(
                        $this->getForm()->get('codAutorizacao')->getData()
                    );

                if (!empty($efetivacao)) {
                    $message = $this->trans('manutencao.errors.autorizacao', [], 'validators');

                    $errorElement->with('codAutorizacao')->addViolation($message)->end();
                }
            }
        }

        if (!empty($this->getForm()->get('exercicio')->getData())
            && !empty($this->getForm()->get('fkOrcamentoEntidade')->getData())
            && !empty($this->getForm()->get('codEmpenho')->getData())
        ) {
            $manutencaoEmpenho = new Frota\ManutencaoEmpenho();
            $manutencaoEmpenho->setFkFrotaManutencao($object);

            $em = $this->modelManager->getEntityManager('CoreBundle:Empenho\Empenho');
            $empenhoModel = new Empenho\EmpenhoModel($em);

            $empenho = $empenhoModel
                ->getEmpenho(
                    [
                        'codEmpenho' => $this->getForm()->get('codEmpenho')->getData(),
                        'exercicio' => $this->getForm()->get('exercicio')->getData(),
                        'codEntidade' => $this->getForm()->get('fkOrcamentoEntidade')->getData()->getCodEntidade()
                    ]
                );

            if (empty($empenho)) {
                $message = $this->trans('manutencao.errors.empenho', [], 'validators');

                $errorElement->with('codEmpenho')->addViolation($message)->end();
                $errorElement->with('exercicio')->addViolation($message)->end();
                $errorElement->with('fkOrcamentoEntidade')->addViolation($message)->end();
            }
        }
    }

    /**
     * Função para Persistência/Manutenção de Dados
     *
     * @param  Frota\Manutencao $object
     * @param  \Symfony\Component\Form\Form $form
     */
    public function saveRelationships($object, $form)
    {
        $exercicio = $this->getExercicio();

        // Setar exercicio
        if (empty($object->getExercicio())) {
            $object->setExercicio($exercicio);
        }

        // Setar codManutencao
        if (empty($object->getCodManutencao())) {
            $em = $this->modelManager->getEntityManager('CoreBundle:Frota\Manutencao');
            $manutencaoModel = new ManutencaoModel($em);

            $codManutencao = $manutencaoModel
                ->getAvailableIdentifier();

            $object->setCodManutencao($codManutencao);
        }

        // Persist manutencaoEmpenho
        if (!empty($form->get('exercicio')->getData())
            && !empty($form->get('fkOrcamentoEntidade')->getData())
            && !empty($form->get('codEmpenho')->getData())
        ) {
            $manutencaoEmpenho = new Frota\ManutencaoEmpenho();
            $manutencaoEmpenho->setFkFrotaManutencao($object);

            $em = $this->modelManager->getEntityManager('CoreBundle:Empenho\Empenho');
            $empenhoModel = new Empenho\EmpenhoModel($em);

            $empenho = $empenhoModel
                ->getEmpenho(
                    [
                        'codEmpenho' => $form->get('codEmpenho')->getData(),
                        'exercicio' => $form->get('exercicio')->getData(),
                        'codEntidade' => $form->get('fkOrcamentoEntidade')->getData()->getCodEntidade()
                    ]
                );

            $manutencaoEmpenho->setFkEmpenhoEmpenho($empenho);
            $object->setFkFrotaManutencaoEmpenho($manutencaoEmpenho);
        }

        // Persist Efetivacao
        if ($form->get('tipoManutencao')->getData() == Frota\Manutencao::TIPOMANUTENCAOAUTORIZACAO) {
            $efetivacao = new Frota\Efetivacao();
            $efetivacao->setFkFrotaManutencao($object);
            $efetivacao->setFkFrotaAutorizacao($form->get('codAutorizacao')->getData());

            $object->addFkFrotaEfetivacoes($efetivacao);

            if (!strpos($this->getRequest()->get('_sonata_name'), 'edit')) {
                // Persist ManutencaoItem
                $manutencaoItem = new Frota\ManutencaoItem();
                $manutencaoItem->setFkFrotaManutencao($object);
                $manutencaoItem->setFkFrotaItem($form->get('codAutorizacao')->getData()->getFkFrotaItem());
                $manutencaoItem->setQuantidade($form->get('codAutorizacao')->getData()->getQuantidade());
                $manutencaoItem->setValor($form->get('codAutorizacao')->getData()->getValor());

                $object->addFkFrotaManutencaoItens($manutencaoItem);
            }
        }
    }

    /**
     * @param Frota\Manutencao $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect('/patrimonial/frota/manutencao/create');
        }
    }

    /**
     * @param Frota\Manutencao $object
     */
    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $id = $this->getAdminRequestId();
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            // Remove ManutencaoEmpenho
            if (!empty($object->getFkFrotaManutencaoEmpenho())) {
                $em->remove($object->getFkFrotaManutencaoEmpenho());
            }

            // Remove Efetivacao
            foreach ($object->getFkFrotaEfetivacoes() as $efetivacao) {
                $em->remove($efetivacao);
            }

            $em->flush();

            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect(
                "/patrimonial/frota/manutencao/{$object->getCodManutencao()}~{$object->getExercicio()}/edit"
            );
        }
    }

    /**
     * @param Frota\Manutencao $object
     */
    public function postPersist($object)
    {
        $this->forceRedirect(
            "/patrimonial/frota/manutencao/{$object->getCodManutencao()}~{$object->getExercicio()}/show"
        );
    }

    /**
     * @param Frota\Manutencao $object
     */
    public function postUpdate($object)
    {
        $this->forceRedirect(
            "/patrimonial/frota/manutencao/{$object->getCodManutencao()}~{$object->getExercicio()}/show"
        );
    }
}
