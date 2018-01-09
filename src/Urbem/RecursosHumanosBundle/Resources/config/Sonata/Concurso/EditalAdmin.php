<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Concurso;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Concurso\ConcursoCargo;
use Urbem\CoreBundle\Entity\Concurso\Edital;
use Urbem\CoreBundle\Entity\Concurso\Homologacao;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Model\Concurso\EditalModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class EditalAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_concurso';
    protected $baseRoutePattern = 'recursos-humanos/concurso';
    protected $includeJs = [
        '/recursoshumanos/javascripts/concurso/load_norma.js'
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('selecionar_norma', 'selecionar-norma/' . $this->getRouterIdParameter())
            ->add('filtra_norma_por_tipo', 'filtra-norma-por-tipo/' . $this->getRouterIdParameter());
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {

        $em = $this->modelManager->getEntityManager(Edital::class);

        $listaExercicio = new EditalModel($em);

        $datagridMapper
            ->add(
                'codNorma',
                'doctrine_orm_callback',
                [
                    'label' => 'label.concurso.exercicio',
                    'mapped' => false,
                    'callback' => array($this, 'getSearchFilter'),
                ],
                'choice',
                [
                    'choices' => $listaExercicio->listarExercicio(),
                    'attr' => ['class' => 'select2-parameters '],
                ]
            );
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        $queryBuilder->resetDQLPart('join');
        $queryBuilder->innerJoin('CoreBundle:Normas\Norma', 'n', 'WITH', 'n.codNorma = ' . $alias . '.fkNormasNorma');
        $queryBuilder->andWhere("n.exercicio = :exercicio");
        $queryBuilder->setParameter("exercicio", $filter['codNorma']['value']);

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('editalAbertura.codNorma', null, array('label' => 'label.concurso.edital'))
            ->add('fkNormasNorma.exercicio', null, ['label' => 'label.concurso.exercicio'])
            ->add('fkNormasNorma.dtPublicacao', null, array('label' => 'label.concurso.publicacao'))
            ->add('dtAplicacao', null, array('label' => 'label.concurso.aplicacao'))
            ->add('dtProrrogacao', null, array('label' => 'label.concurso.prorrogacao'));
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];

        $editalModel = new EditalModel($em);
        $editaisCadastrados  =$editalModel->getEditaisJaCadastrados();

        $fieldOptions["editalAbertura"] = [
            'class' => 'CoreBundle:Normas\Norma',
            'choice_label' => function ($codNorma) {
                $return = $codNorma->getNumNorma();
                $return .= '/'.$codNorma->getExercicio();
                $return .= ' - '.$codNorma->getDescricao();
                return $return;
            },
            'label' => 'label.concurso.editalAbertura',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione'
        ];

        $fieldOptions["codTipoNorma"] = [
            'class' => 'CoreBundle:Normas\TipoNorma',
            'choice_label' => 'nom_tipo_norma',
            'label' => 'label.concurso.inCodTipoNorma',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'mapped' => false
        ];

        $fieldOptions['dataPublicacao'] = [
            'mapped' => false,
            'label' => 'label.concurso.dataPublicacao',
            'attr' => [
                'disabled' => 'true'
            ],
        ];

        /**
         * @todo Implementar autocomplete em um campo que é populado via ajax
         * @todo Implementar modal para carregamento do ajax
         */
        $fieldOptions["fkNormasNorma1"] = [
            'class' => 'CoreBundle:Normas\Norma',
            'choice_label' => 'nom_norma',
            'label' => 'label.concurso.codNorma',
            'attr' => [
                'class' => 'select2-parameters ',
                'disabled' => 'true'
            ],
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions["tipoProva"] = [
            'choices' => [
                'label.concurso.teorico' => 'T',
                'label.concurso.teoricoPratico' => 'P'
            ],
            'label' => 'label.concurso.tipoProva',
            'expanded' => true,
            'multiple' => false,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ]
        ];

        $fieldOptions["codHomologacao"] = [
            'class' => 'CoreBundle:Normas\Norma',
            'choice_label' => function (Norma $norma) {
                return sprintf('%d/%s - %s', $norma->getCodNorma(), $norma->getExercicio(), $norma->getDescricao());
            },
            'label' => 'label.concurso.editalHomologacao',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['pessoalCargo'] = [
            'class' => 'CoreBundle:Pessoal\Cargo',
            'choice_label' => 'descricao',
            'label' => 'label.concurso.cargos',
            'multiple' => true,
            'attr' =>[
                'class' => 'select2-parameters '
            ],
            'mapped' => false
        ];

        if (!is_null($id)) {
            $tipoNorma  = $this->getSubject()->getFkNormasNorma1()->getCodTipoNorma();

            $concursoCargos = $this->getSubject()->getFkConcursoConcursoCargos();

            $homologacao = $em->getRepository('CoreBundle:Concurso\Homologacao')->findOneByCodEdital($id);
            $fieldOptions["editalAbertura"]["attr"] = [
                'class' => 'select2-parameters ',
                'disabled' => 'true'
            ];

            $fieldOptions["fkNormasNorma1"]["query_builder"] = function (EntityRepository $em) use ($tipoNorma) {
                $qb = $em->createQueryBuilder('norma');
                $result = $qb->where('norma.codTipoNorma = :tipoNorma')
                    ->setParameter(':tipoNorma', $tipoNorma);
                return $result;
            };

            $fieldOptions["fkNormasNorma1"]['attr']['disabled'] = false;

            $fieldOptions["codTipoNorma"]["choice_attr"] = function ($tipoNormaOptions, $key, $index) use ($tipoNorma) {

                if ($tipoNormaOptions->getCodTipoNorma() == $tipoNorma) {
                    return ['selected' => 'selected'];
                } else {
                    return ['selected' => false];
                }
            };

            $fieldOptions["codHomologacao"]["choice_attr"] = function ($tipoHomologacao, $key, $index) use ($homologacao) {
                if ($tipoHomologacao->getCodNorma() == $homologacao->getFkNormasNorma()->getCodNorma()) {
                    return ['selected' => 'selected'];
                } else {
                    return ['selected' => false];
                };
            };

            $fieldOptions["pessoalCargo"]["choice_attr"] = function ($cargos, $key, $index) use ($concursoCargos) {
                foreach ($concursoCargos as $codCargos) {
                    if ($codCargos->getCodCargo() == $cargos->getCodCargo()) {
                            return ['selected' => 'selected'];
                    }
                }
                return ['selected' => false];
            };
        } else {
            $fieldOptions["editalAbertura"]['query_builder'] = function ($em) use ($editaisCadastrados) {
                $qb = $em->createQueryBuilder('n');
                $result = $qb->where($qb->expr()->notIn('n.codNorma', $editaisCadastrados))
                    ->orderBy('n.nomNorma', 'ASC');
                return $qb;
            };
        }

        $formMapper
            ->with('label.concurso.dadosParaConcurso')
            ->add(
                'fkNormasNorma',
                'entity',
                $fieldOptions["editalAbertura"]
            )
            ->add(
                'dataPublicacao',
                'text',
                $fieldOptions['dataPublicacao']
            )
            ->add(
                'codTipoNorma',
                'entity',
                $fieldOptions["codTipoNorma"]
            )
            ->add(
                'fkNormasNorma1',
                'entity',
                $fieldOptions["fkNormasNorma1"]
            )
            ->add(
                'dtAplicacao',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.dtAplicacao'
                ]
            );

        if (!is_null($id)) {
            $formMapper->add(
                'dtProrrogacao',
                'sonata_type_date_picker',
                [
                    'format'    => 'dd/MM/yyyy',
                    'label'     => 'label.dtProrrogacao',
                    'required'  => false,
                ]
            );
        }

        $formMapper->add(
            'mesesValidade',
            null,
            [
                'label' => 'label.mesesValidade'
            ]
        )
            ->add(
                'notaMinima',
                null,
                [
                    'label' => 'label.notaMinima'
                ]
            )
            ->add(
                'fkConcursoHomologacoes',
                'entity',
                $fieldOptions["codHomologacao"]
            )
            ->end()
            ->with('label.concurso.avaliacao')
            ->add(
                'tipoProva',
                'choice',
                $fieldOptions["tipoProva"]
            )
            ->add(
                'avaliaTitulacao',
                null,
                [
                    'label' => 'label.avaliaTitulacao'
                ]
            )
            ->end()
            ->with('label.concurso.cargosDisponiveis')
            ->add(
                'pessoalCargo',
                'entity',
                $fieldOptions['pessoalCargo']
            )
            ->end();

        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($admin) {

                $form = $event->getForm();
                $data = $event->getData();

                if (!is_null($admin->getAdminRequestId())) {
                    $data['fkNormasNorma'] = $admin->getSubject()->getFkNormasNorma()->getCodNorma();
                    $event->setData($data);
                }

                $tipoNorma = $data['codTipoNorma'];
                $form
                    ->add('fkNormasNorma1', 'entity', [
                        'class' => 'CoreBundle:Normas\Norma',
                        'choice_label' => 'nom_norma',
                        'label' => 'label.concurso.codNorma',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                        'placeholder' => 'label.selecione',
                        'query_builder' => function (EntityRepository $em) use ($tipoNorma) {
                            $qb = $em->createQueryBuilder('norma');
                            $result = $qb->where('norma.codTipoNorma = :tipoNorma')
                                ->setParameter(':tipoNorma', $tipoNorma);
                            return $result;
                        }
                    ])
                ;
            }
        );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('normaExercicioDescricao', null, ['label' => 'label.concurso.codEdital'])
            ->add('tipoNormaExercicioDescricao', null, ['label' => 'label.concurso.codNorma'])
            ->add('dtAplicacao', null, array('label' => 'label.concurso.aplicacao'))
            ->add('dtProrrogacao', null, array('label' => 'label.concurso.prorrogacao'))
            ->add('notaMinima', null, ['label' => 'label.notaMinima'])
            ->add('mesesValidade', null, ['label' => 'label.mesesValidade'])
            ->add('avaliaTitulacao', null, ['label' => 'label.avaliaTitulacao'])
            ->add('tipoProva', 'choice', [
                'label'   => 'label.tipoProva',
                'choices' => [
                    Edital::PROVA_TEORICA         => 'Teórico',
                    Edital::PROVA_TEORICA_PRATICA => 'Teórico/Prático',
                ],
            ])
            ->add('fkConcursoConcursoCargos', null, [
                'associated_property' => function (ConcursoCargo $concursoCargo) {
                    return $concursoCargo->getFkPessoalCargo()->getDescricao();
                },
                'label'               => 'label.concurso.cargos',
            ]);
    }

    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        $dataPublic = $object->getFkNormasNorma()->getDtPublicacao();
        $dataAplic = $object->getDtAplicacao();

        if ($dataPublic > $dataAplic) {
            $message = $this->trans('recursosHumanos.concurso.dataAplicacao', [], 'flashes');
            $errorElement->with('dtAplicacao')->addViolation($message)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("data_aplicacao_invalida", $message);
        }

        if (!$this->id($this->getSubject())) {
        }
    }

    public function prePersist($object)
    {
        $form = $this->getForm();

        $homologacao = new Homologacao;
        $homologacao->setFkConcursoEdital($object);
        $homologacao->setFkNormasNorma($object->getFkConcursoHomologacoes());
        $object->setFkConcursoHomologacoes(array($homologacao));

        foreach ($form->get('pessoalCargo')->getData() as $pessoalCargo) {
            $concursoCargo = new ConcursoCargo;

            $concursoCargo->setFkPessoalCargo($pessoalCargo);
            $object->addFkConcursoConcursoCargos($concursoCargo);
        }
    }

    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $codHomologacao = $object->getFkNormasNorma()->getCodNorma();

        $form = $this->getForm();

        foreach ($object->getFkConcursoConcursoCargos() as $homolocacaoCargo) {
            $object->removeFkConcursoConcursoCargos($homolocacaoCargo);
        }

        $homologacao = $em->getRepository('CoreBundle:Concurso\Homologacao')->findOneByCodEdital($codHomologacao);
        $homologacao->setFkNormasNorma($form->get('fkConcursoHomologacoes')->getData());

        $object->setFkConcursoHomologacoes(array($homologacao));
    }

    public function postUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();

        foreach ($form->get('pessoalCargo')->getData() as $codCargo) {
            $concursoCargo = new ConcursoCargo;
            $concursoCargo->setCodEdital($object->getCodEdital());
            $concursoCargo->setCodCargo($codCargo->getCodCargo());
            $em->persist($concursoCargo);
        }
        $em->flush();
    }
}
