<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Urbem\CoreBundle\Entity\Licitacao\Comissao;
use Urbem\CoreBundle\Entity\Licitacao\ComissaoMembros;
use Urbem\CoreBundle\Entity\Licitacao\NaturezaCargo;
use Urbem\CoreBundle\Entity\Licitacao\TipoComissao;
use Urbem\CoreBundle\Entity\Licitacao\TipoMembro;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ComissaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ComissaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_comissao';
    protected $baseRoutePattern = 'patrimonial/licitacao/comissao';
    protected $fkLicitacaoComissao = [];
    protected $exibirBotaoExcluir = false;

    protected $includeJs = [
        '/patrimonial/javascripts/licitacao/norma-vigencia.js',
        '/patrimonial/javascripts/licitacao/norma-vigencia-membro.js',
        '/patrimonial/javascripts/licitacao/lista-membros.js'
    ];

    protected function createFkLicitacaoComissao(Comissao $comissao)
    {
        /** @var $comissaoMembros ComissaoMembros */
        foreach ($comissao->getFkLicitacaoComissaoMembros() as $comissaoMembros) {
            $this->fkLicitacaoComissao[] = clone $comissaoMembros;
            $comissao->removeFkLicitacaoComissaoMembros($comissaoMembros);
        }

        // Caso for edição ou exclusão de membros
        if (null != $comissao->getCodComissao()) {
            $this->saveObject($comissao);
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param Comissao $comissao
     */
    public function validate(ErrorElement $errorElement, $comissao)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $anoAtual = (int) $this->getExercicio();

        $this->createFkLicitacaoComissao($comissao);
        $this->populateObject($comissao);

        $route = $this->getRequest()->get('_sonata_name');
        if (null != $route) {
            if (is_null($comissao->getFkNormasNorma()->getFkNormasNormaDataTermino()->getDtTermino())) {
                $message = $this->trans('comissaoVigencia.errors.vigenciaNula', [], 'validators');
                $errorElement->with('vigencia')->addViolation($message)->end();
            } else {
                $dataTermino = (int) $comissao->getFkNormasNorma()->getFkNormasNormaDataTermino()->getDtTermino()->format("Y");
                if ($anoAtual > $dataTermino) {
                    $message = $this->trans('comissaoVigencia.errors.vigenciaDataExpirada', [], 'validators');
                    $errorElement->with('vigencia')->addViolation($message)->end();
                }
            }
        }

        $comissaoModel = new ComissaoModel($entityManager);
        $valida = $comissaoModel->validaComissao($comissao, $this->fkLicitacaoComissao);
        $validaComissaoVigencia = $comissaoModel->validaComissaoVigencia($comissao, $this->fkLicitacaoComissao, $anoAtual);

        if ($validaComissaoVigencia) {
            $message = $this->trans($validaComissaoVigencia, [], 'validators');
            $errorElement->with('fkLicitacaoComissaoMembros')->with('vigencia')->addViolation($message)->end();
        }

        if ($valida) {
            $message = $this->trans($valida, [], 'validators');
            $errorElement->with('fkLicitacaoComissaoMembros')->with('fkLicitacaoTipoMembro')->addViolation($message)->end();
        };
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codComissao', null, ['label' => 'label.patrimonial.licitacao.codComissao'])
            ->add('fkLicitacaoTipoComissao', null, [
                'label' => 'label.patrimonial.licitacao.tipoComissao'
            ], 'entity', [
                'class' => 'CoreBundle:Licitacao\TipoComissao',
                'choice_label' => function ($codComissao) {
                    return $codComissao->getDescricao();
                }
            ])
            ->add(
                'fkNormasNorma',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.patrimonial.licitacao.norma',
                ),
                'autocomplete',
                array(
                    'class' => Norma::class,
                    'route' => array(
                        'name' => 'patrimonio_licitacao_comissao_licitacao_get_normas'
                    ),
                    'mapped' => true,
                )
            )
            ->add('ativo', null, ['label' => 'Ativo'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $comissao = $this->fkLicitacaoComissao;

        $listMapper
            ->add('codComissao', null, ['label' => 'label.patrimonial.licitacao.codComissao'])
            ->add('fkLicitacaoTipoComissao', null, array(
                'associated_property' => 'descricao',
                'label' => 'label.patrimonial.licitacao.tipoComissao',
            ))
            ->add('fkNormasNorma', null, ['label' => 'label.patrimonial.licitacao.norma'])
            ->add('ativo', null, ['label' => 'Ativo'])
            ->add('fkNormasNorma.fkNormasNormaDataTermino.dtTermino', null, ['label' => 'label.vigencia'])
            ->add('fkLicitacaoComissaoMembros', 'customField', ['label' => 'label.presidente', 'template' => 'PatrimonialBundle:Sonata/Licitacao/Comissao/CRUD:comissaoPresidente.html.twig'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'ativar' => array('template' => 'PatrimonialBundle:Sonata/Licitacao/Comissao/CRUD:list__action_ativar_inativar.html.twig'),
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $session = new Session();
        $codComissao = '2';
        $licitacaoTipoComissao = $session->get('licitacaoTipoComissao');
        if (isset($licitacaoTipoComissao)) {
            $codComissao = $licitacaoTipoComissao;
        }

        switch ($codComissao) {
            case '1':
                $stFiltro = [1, 2];
                break;
            case '2':
                $stFiltro = [1, 2, 3];
                break;
            case '3':
                $stFiltro = [1, 3];
                break;
            case '4':
                $stFiltro = [1];
                break;
        }

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $comissao = $this->getSubject();

        $fieldOptions['fkSwCgmPessoaFisica'] = [
            'label' => 'label.estagio.cgm',
            'mapped' => false,
            'required' => false,
            'class' => SwCgmPessoaFisica::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repository, $term, Request $request) {
                $queryBuilder = $repository->createQueryBuilder('SwCgmPessoaFisica');
                $queryBuilder
                    ->join('SwCgmPessoaFisica.fkSwCgm', 'swCgm');
                if (!is_numeric($term)) {
                    $queryBuilder->where(
                        $queryBuilder->expr()->like(
                            $queryBuilder->expr()->lower('swCgm.nomCgm'),
                            $queryBuilder->expr()->lower(':term')
                        )
                    )
                        ->setParameter('term', '%'.$term.'%');
                } else {
                    $term = (int) $term;
                    $queryBuilder
                        ->where('swCgm.numcgm = :term')
                        ->setParameter('term', $term);
                }

                $queryBuilder->orderBy('swCgm.nomCgm');
                return $queryBuilder;
            }
        ];

        $fieldOptions['dataComissao'] = [
            'required' => false,
            'label' => 'label.patrimonial.licitacao.dadosDesignacaoComissao',
            'mapped' => false,
            'attr' => [
                'readonly' => true
            ]
        ];

        $fieldOptions['vigencia'] = [
            'required' => false,
            'label' => 'label.patrimonial.licitacao.vigencia',
            'attr' => [
                'readonly' => true
            ],
            'mapped' => false
        ];

        $fieldOptions['tipoMembro'] = [
            'class' => 'CoreBundle:Licitacao\TipoMembro',
            'choice_label' => function ($codTipoMembro) {
                return $codTipoMembro->getDescricao();
            },
            'query_builder' => function (EntityRepository $repository) use ($stFiltro) {
                /** @var QueryBuilder $qb */
                $qb = $repository->createQueryBuilder('tipoMembro');
                $qb->where($qb->expr()->in('tipoMembro.codTipoMembro', $stFiltro));
                return $qb;
            },
            'placeholder' => 'Selecione',
            'label' => 'label.patrimonial.licitacao.tipoMembro',
            'required' => false,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters tipoMembro'
            ]
        ];

        $comissaoMembros = array();
        $codComissao = $comissao ? $comissao->getCodComissao() : null;
        if ($codComissao) {
            foreach ($comissao->getFkLicitacaoComissaoMembros() as $membro) {
                array_push($comissaoMembros, $membro);
            }
        }

        $fieldOptions['fkLicitacaoComissaoMembros'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'PatrimonialBundle::Licitacao/ComissaoLicitacao/membros.html.twig',
            'attr' => array(
                'style' => 'display:none;'
            ),
            'data' => array(
                'membros' => $comissaoMembros
            )
        );

        $formMapper
            ->add('fkLicitacaoTipoComissao', 'entity', ['class' => 'CoreBundle:Licitacao\TipoComissao',
                'choice_label' => function ($codComissao) {
                    if (empty($codComissao)) {
                        return;
                    }
                    return $codComissao->getDescricao();
                },
                'placeholder' => 'Selecione',
                'label' => 'label.patrimonial.licitacao.tipoComissao',
                'required' => true,
                'attr' => [
                    'class' => 'select2-parameters '
                ]
            ])
            ->add(
                'fkNormasNorma',
                'autocomplete',
                [
                    'label' => 'label.patrimonial.licitacao.norma',
                    'multiple' => false,
                    'attr' => ['class' => 'select2-parameters '],
                    'class' => Norma::class,
                    'json_from_admin_code' => $this->code,
                    'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                        return $repo->createQueryBuilder('o')
                            ->where('lower(o.nomNorma) LIKE lower(:nomNorma)')
                            ->orWhere('o.numNorma = :codNorma')
                            ->setParameter('nomNorma', "%{$term}%")
                            ->setParameter('codNorma', $term);
                    },
                    'required' => true,
                ]
            )
            ->add('dataComissao', 'text', $fieldOptions['dataComissao'])
            ->add('vigencia', 'text', $fieldOptions['vigencia'])
            ->end();
        $formMapper
            ->with('label.patrimonial.licitacao.dadosMembrosComissao')
            ->add(
                'fkSwCgm',
                'autocomplete',
                $fieldOptions['fkSwCgmPessoaFisica']
            )
            ->add(
                'normaMembro',
                'autocomplete',
                [
                    'label' => 'label.patrimonial.licitacao.norma',
                    'multiple' => false,
                    'attr' => ['class' => 'select2-parameters '],
                    'class' => Norma::class,
                    'json_from_admin_code' => $this->code,
                    'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                        return $repo->createQueryBuilder('o')
                            ->where('lower(o.nomNorma) LIKE lower(:nomNorma)')
                            ->setParameter('nomNorma', "%{$term}%");
                    },
                    'required' => false,
                    'mapped' => false,
                ]
            )
            ->add('dataComissaoMembro', 'text', $fieldOptions['dataComissao'])
            ->add('vigenciaMembro', 'text', $fieldOptions['vigencia'])
            ->add('cargo', 'text', [
                'label' => 'label.patrimonial.licitacao.cargoMembro',
                'attr' => [
                    'style' => 'min-width:100px'
                ],
                'required' => false,
                'mapped' => false,
            ])
            ->add(
                'fkLicitacaoTipoMembro',
                'entity',
                $fieldOptions['tipoMembro']
            )
            ->add(
                'fkLicitacaoNaturezaCargo',
                'entity',
                [
                    'class' => 'CoreBundle:Licitacao\NaturezaCargo',
                    'choice_label' => function ($naturezaCargo) {
                        return $naturezaCargo->getDescricao();
                    },
                    'placeholder' => 'Selecione',
                    'label' => 'label.patrimonial.licitacao.naturezaCargo',
                    'required' => false,
                    'mapped' => false,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add('fkLicitacaoComissaoMembros', 'customField', $fieldOptions['fkLicitacaoComissaoMembros'])
            ->end();

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $comissao, $entityManager) {
                $data = $event->getData();
                $tipoComissao = '';
                if ($data['fkLicitacaoTipoComissao'] != '') {
                    $findTipoComissao = ['codTipoComissao' => $data['fkLicitacaoTipoComissao']];
                    $tipoComissao = $entityManager->getRepository(TipoComissao::class)->findOneBy($findTipoComissao);
                }
                $session = new Session();
                $session->set('licitacaoTipoComissao', $data['fkLicitacaoTipoComissao']);
                $form = $event->getForm();
                $formOptions['fkLicitacaoTipoComissao'] = [
                    'class' => 'CoreBundle:Licitacao\TipoComissao',
                    'choice_label' => function ($codComissao) {
                        if (empty($codComissao)) {
                            return;
                        }
                        return $codComissao->getDescricao();
                    },
                    'data' => $tipoComissao,
                    'placeholder' => 'Selecione',
                    'label' => 'label.patrimonial.licitacao.tipoComissao',
                    'required' => true,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ];

                $codComissao = '2';
                $licitacaoTipoComissao = $session->get('licitacaoTipoComissao');
                if (isset($licitacaoTipoComissao)) {
                    $codComissao = $licitacaoTipoComissao;
                }

                switch ($codComissao) {
                    case '1':
                        $stFiltro = [1, 2];
                        break;
                    case '2':
                        $stFiltro = [1, 2, 3];
                        break;
                    case '3':
                        $stFiltro = [1, 3];
                        break;
                    case '4':
                        $stFiltro = [1];
                        break;
                }

                $fieldOptions['tipoMembro'] = [
                    'class' => 'CoreBundle:Licitacao\TipoMembro',
                    'choice_label' => function ($codTipoMembro) {
                        return $codTipoMembro->getDescricao();
                    },
                    'query_builder' => function (EntityRepository $repository) use ($stFiltro) {
                        /** @var QueryBuilder $qb */
                        $qb = $repository->createQueryBuilder('tipoMembro');
                        $qb->where($qb->expr()->in('tipoMembro.codTipoMembro', $stFiltro));
                        return $qb;
                    },
                    'placeholder' => 'Selecione',
                    'label' => 'label.patrimonial.licitacao.tipoMembro',
                    'required' => false,
                    'mapped' => false,
                    'attr' => [
                        'class' => 'select2-parameters tipoMembro'
                    ]
                ];

                $form->add('fkLicitacaoTipoComissao', 'entity', $formOptions['fkLicitacaoTipoComissao']);
                $form->add('fkLicitacaoTipoMembro', 'entity', $fieldOptions['tipoMembro']);
            }
        );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $comissao = $this->getSubject();
        $this->data['fkLicitacaoComissaoMembros'] = $comissao->getFkLicitacaoComissaoMembros();

        $showMapper
            ->add('codComissao', null, ['label' => 'label.patrimonial.licitacao.codComissao'])
            ->add('fkLicitacaoTipoComissao.descricao', null, ['label' => 'label.patrimonial.licitacao.finComissao'])
            ->add('fkNormasNorma', null, ['label' => 'label.patrimonial.licitacao.norma'])
            ->add('fkNormasNorma.dtAssinatura', null, ['label' => 'label.patrimonial.licitacao.dtDesignacao'])
            ->add('fkNormasNorma.fkNormasNormaDataTermino', null, ['label' => 'label.vigencia'])
            ->add('ativo')
            ->add(
                'fkLicitacaoComissaoMembros',
                null,
                [
                    'label' => 'label.patrimonial.licitacao.comissaoMembros',
                    'template' => 'PatrimonialBundle:Sonata/Licitacao/Comissao/CRUD:comissaoMembros.html.twig'
                ]
            );
    }

    /**
     * @param Comissao $comissao
     */
    public function prePersist($comissao)
    {
        $this->createFkLicitacaoComissao($comissao);
    }

    /**
     * @param Comissao $comissao
     */
    public function postPersist($comissao)
    {
        $this->populateObject($comissao);
        $this->saveObject($comissao);
    }

    /**
     * @param mixed $comissao
     */
    public function preUpdate($comissao)
    {
        $this->saveObject($comissao);
    }

    /**
     * @param $comissao
     */
    public function saveObject($comissao)
    {
        $em = $this->configurationPool->getContainer()->get('doctrine.orm.default_entity_manager');
        $em->persist($comissao);
        $em->flush();
    }

    /**
     * @param Comissao $comissao
     * @return Comissao
     */
    protected function populateObject(Comissao $comissao)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        foreach ((array) $this->getRequest()->get('membros') as $membro) {
            $comissaoMembros = new ComissaoMembros();

            $comissaoMembros->setCargo($membro['cargo']);
            $comissaoMembros->setCodComissao($comissao->getCodComissao());
            $comissaoMembros->setCodNorma($membro['normaMembro']);
            $comissaoMembros->setCodTipoMembro($membro['fkLicitacaoTipoMembro']);
            $comissaoMembros->setNaturezaCargo($membro['fkLicitacaoNaturezaCargo']);
            $comissaoMembros->setFkSwCgm($em->getRepository(SwCgm::class)->find($membro['fkSwCgm']));

            $norma = $em->getRepository(Norma::class)->find($membro['normaMembro']);

            list($dia, $mes, $ano) = explode('/', $membro['vigenciaMembro']);
            $vigenciaMembro = new \DateTime(sprintf('%s-%s-%s', $ano, $mes, $dia));

            list($dia, $mes, $ano) = explode('/', $membro['dataComissaoMembro']);
            $dataComissaoMembro = new \DateTime(sprintf('%s-%s-%s', $ano, $mes, $dia));

            $norma->getFkNormasNormaDataTermino()->setDtTermino($vigenciaMembro);
            $norma->setDtPublicacao($dataComissaoMembro);
            $comissaoMembros->setFkNormasNorma($norma);

            $comissaoMembros->setFkLicitacaoNaturezaCargo($em->getRepository(NaturezaCargo::class)->find($membro['fkLicitacaoNaturezaCargo']));
            $comissaoMembros->setFkLicitacaoTipoMembro($em->getRepository(TipoMembro::class)->find($membro['fkLicitacaoTipoMembro']));

            $comissao->addFkLicitacaoComissaoMembros($comissaoMembros);
        }

        return $comissao;
    }
}
