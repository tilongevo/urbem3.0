<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Patrimonio\Bem;
use Urbem\CoreBundle\Entity\Patrimonio\Manutencao;
use Urbem\CoreBundle\Entity\Patrimonio\ManutencaoPaga;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\BemModel;
use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\GrupoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type;

class ManutencaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_patrimonio_manutencao';
    protected $baseRoutePattern = 'patrimonial/patrimonio/manutencao';
    protected $includeJs = [
        '/patrimonial/javascripts/patrimonio/manutencao.js',
    ];

    protected $exibirBotaoExcluir = false;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_grupo', 'consultar-grupo/' . $this->getRouterIdParameter());
        $collection->add('consultar_especie', 'consultar-especie/{id}/{cod_natureza}');
        $collection->add('consultar_bem', 'consultar-bem/' . $this->getRouterIdParameter());
    }

    public function createQuery($context = 'list')
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $manutencaoPaga = $entityManager->createQueryBuilder()
            ->select('(mp.codBem)')
            ->from(ManutencaoPaga::class, 'mp');
        
        $query = parent::createQuery($context);
        $query->andWhere(
            $query->expr()->notIn('o.codBem', $manutencaoPaga->getDql())
        );

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $bemModel = new BemModel($entityManager);

        $bem = $bemModel->getBemComManutencaoAgendada();

        $datagridMapper
            ->add(
                'fkPatrimonioBem',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.bem.modulo',
                ),
                'autocomplete',
                array(
                    'class' => Bem::class,
                    'route' => array(
                        'name' => 'patrimonio_carrega_bem'
                    ),
                    'mapped' => true,
                ),
                [
                    'admin_code' => 'app.admin.patrimonial.bem'
                ]
            )
            ->add(
                'dtAgendamento',
                'doctrine_orm_datetime',
                [
                    'field_type' => 'sonata_type_datetime_picker',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy'
                    ],
                    'label' => 'label.manutencaoPaga.dtAgendamento'
                ]
            )
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
                'fkPatrimonioBem',
                null,
                [
                    'label' => 'label.bem.modulo',
                    'admin_code' => 'app.admin.patrimonial.bem'
                ]
            )
            ->add(
                'dtAgendamento',
                'date',
                [
                    'label' => 'label.dtAgendamento',
                    'sortable' => false
                ]
            )
            ->add(
                'observacao',
                'text',
                [
                    'label' => 'label.observacoes',
                    'sortable' => false
                ]
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $bemSelecionado = null;
        if (!is_null($id)) {
            /** @var Manutencao $manutencao */
            $manutencao = $this->getSubject();
            $bemSelecionado = $manutencao->getFkPatrimonioBem();
        }

        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Patrimonio\Bem');
        $bemModel = new BemModel($entityManager);

        $formMapperOptions['codNatureza'] = [
            'attr' => [
                'readonly' => 'readonly',
            ],
            'mapped' => false,
            'label' => 'label.manutencaoPaga.codNatureza',
            'required' => false
        ];
        $formMapperOptions['codGrupo'] = [
            'attr' => [
                'readonly' => 'readonly',
            ],
            'mapped' => false,
            'label' => 'label.manutencaoPaga.codGrupo',
            'required' => false
        ];
        $formMapperOptions['codEspecie'] = [
            'attr' => [
                'readonly' => 'readonly',
            ],
            'mapped' => false,
            'label' => 'label.manutencaoPaga.codEspecie',
            'required' => false
        ];
        $formMapperOptions['numPlaca'] = [
            'attr' => [
                'readonly' => 'readonly',
            ],
            'mapped' => false,
            'label' => 'label.manutencaoPaga.numPlaca',
            'required' => false
        ];

        $bem = $bemModel->getBemComClassificacao();

        if (!$this->id($this->getSubject())) {
            $type = 'autocomplete';
            $formMapperOptions['fkPatrimonioBem'] = [
                'class' => Bem::class,
                'json_from_admin_code' => $this->code,
                'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                    return $repo->createQueryBuilder('bem')
                        ->join('bem.fkPatrimonioEspecie', 'natureza')
                        ->leftJoin('bem.fkPatrimonioManutencoes', 'manutencao')
                        ->leftJoin('bem.fkSwCgm', 'cgm')
                        ->where('bem.descricao LIKE :descricao')
                        ->setParameter('descricao', "%{$term}%");
                },
                'label' => 'label.bem.modulo',
                'placeholder' => 'Selecione',
                'json_choice_label' => function (Bem $bem) {
                    $especie = $bem->getFkPatrimonioEspecie()->getCodNatureza() . '.' . $bem->getFkPatrimonioEspecie()->getCodGrupo() . '.' . $bem->getFkPatrimonioEspecie()->getCodEspecie();
                    $descricao = $bem->getDescricao();
                    return (string) "{$especie} - {$descricao}";
                },
                'mapped' => false,
                'required' => true,
            ];
        } else {
            $type = 'entity';
            $formMapperOptions['fkPatrimonioBem'] = [
                'class' => Bem::class,
                'attr' => ['class' => 'select2-parameters '],
                'data' => $bemSelecionado,
                'label' => 'label.bem.modulo',
                'mapped' => false,
                'required' => true,
                'disabled' => true,
                'query_builder' => function (EntityRepository $entityRepository) use ($bemSelecionado) {
                    $queryBuilder = $entityRepository->createQueryBuilder('bem')
                        ->where('bem.codBem = :bem')
                        ->setParameter('bem', $bemSelecionado);

                    return $queryBuilder;
                },
            ];
        }


        $now = new \DateTime();
        $formMapperOptions['dtAgendamento'] = [
            'dp_default_date' => $now->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'label' => 'label.dtAgendamento',
            'required' => true,
        ];

        $formMapperOptions['fkSwCgm'] = [
            'label' => 'label.cgm',
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repository, $term, Request $request) {
                $queryBuilder = $repository->createQueryBuilder('swCgm');
                $queryBuilder
                    ->join('swCgm.fkSwCgmPessoaJuridica', 'fkSwCgmPessoaJuridica');
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

        $formMapper
            ->with('label.dadosAgendamento')
            ->add('fkPatrimonioBem', $type, $formMapperOptions['fkPatrimonioBem'], ['admin_code' => 'app.admin.patrimonial.bem'])
            ->add('codNatureza', 'text', $formMapperOptions['codNatureza'])
            ->add('codGrupo', 'text', $formMapperOptions['codGrupo'])
            ->add('codEspecie', 'text', $formMapperOptions['codEspecie'])
            ->add('numPlaca', 'text', $formMapperOptions['numPlaca'])
            ->add('fkSwCgm', 'autocomplete', $formMapperOptions['fkSwCgm'], ['admin_code' => 'core.admin.filter.sw_cgm'])
            ->add('dtAgendamento', 'datepkpicker', $formMapperOptions['dtAgendamento'])
            ->add('observacao', 'text', ['label' => 'label.observacoes'])
            ->end()
            ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('fkPatrimonioBem', null, [], ['admin_code' => 'app.admin.patrimonial.bem'])
            ->add(
                'dtAgendamento',
                null,
                [
                    'label' => 'label.dtAgendamento',
                ]
            )
            ->add(
                'dtRealizacao',
                null,
                [
                    'label' => 'label.dtRealizacao',
                ]
            )
            ->add(
                'observacao',
                null,
                [
                    'label' => 'label.observacao',
                ]
            )
        ;
    }

    /**
     * @param Manutencao $manutencao
     */
    public function prePersist($manutencao)
    {
        $dtAgendamento = new DatePK($manutencao->getDtAgendamento()->format('Y-m-d'));
        $bem = $this->getForm()->get('fkPatrimonioBem')->getData();
        $manutencao->setFkPatrimonioBem($bem);
        $manutencao->setDtAgendamento($dtAgendamento);
    }

    /**
     * @param Manutencao $manutencao
     * @return mixed
     */
    public function preUpdate($manutencao)
    {
        $manutencaoNew = clone $manutencao;

        $em = $this->modelManager->getEntityManager($this->getClass());

        $bemModel = new BemModel($em);

        $bemModel->remove($manutencao);
        $bemModel->save($manutencaoNew);

        $container = $this->getConfigurationPool()->getContainer();
        $message = $this->trans('patrimonial.patrimonio.manutencao.success', [], 'flashes');

        $container->get('session')
            ->getFlashBag()
            ->add('success', $message);


        return $this->redirectByRoute('urbem_patrimonial_patrimonio_manutencao_list', array());
    }
}
