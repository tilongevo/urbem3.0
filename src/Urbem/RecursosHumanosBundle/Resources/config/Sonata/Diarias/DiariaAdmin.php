<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Diarias;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Diarias\Diaria;
use Urbem\CoreBundle\Entity\Diarias\TipoDiaria;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\Normas\TipoNorma;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwPais;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractOrganogramaSonata as AbstractAdmin;

class DiariaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_diarias_diaria';
    protected $baseRoutePattern = 'recursos-humanos/diarias/diaria';
    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoEditar = false;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create','edit','show','list']);

        $collection
            ->add('recibo', '{id}/recibo', [], [], [], '', [], ['GET']);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/diarias/filter--diarias.js',
        ]));

        $datagridMapper
            ->add(
                'codContrato',
                'doctrine_orm_choice',
                array(
                    'label' => 'label.matricula'
                ),
                'autocomplete',
                array(
                    'class' => Contrato::class,
                    'route' => array(
                        'name' => 'carrega_contrato'
                    ),
                    'mapped' => false,
                )
            )
        ;
    }

    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add(
                '_action',
                'actions',
                [
                    'actions' => [
                        'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                        'recibo' => ['template' => 'RecursosHumanosBundle:Sonata/Diarias/Diaria/CRUD:list__action_recibo.html.twig'],
                    ]
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
                'matricula',
                'text',
                [
                    'label' => 'label.adidoscedidos.inContrato',
                    'row_align' => 'right'
                ]
            )
            ->add(
                'servidor',
                'text',
                [
                    'label' => 'label.servidor.modulo'
                ]
            )
            ->add(
                'dtInicio',
                null,
                [
                    'label' => 'label.diaria.dtInicio',
                ]
            )
            ->add(
                'dtTermino',
                null,
                [
                    'label' => 'label.diaria.dtTermino',
                ]
            )
            ->add(
                'vlTotal',
                'currency',
                [
                    'label' => 'valor',
                    'currency' => 'BRL',
                    'locale' => 'pt_BR',
                ]
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/diarias/form--diarias.js',
        ]));

        $entityManager = $this->getEntityManager();

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];

        $fieldOptions['fkPessoalContrato'] = [
            'class' => Contrato::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->findByNomCgm([
                    'nomCgm' => '%' . strtolower($term) . '%' ,
                    'exercicio' => $this->getExercicio()
                ]);
            },
            'json_choice_label' => function (Contrato $contrato) use ($entityManager) {
                return (new ContratoModel($entityManager))
                ->toStringContratoAutocomplete($contrato);
            },
            'label' => 'label.adidoscedidos.inContrato'
        ];

        $fieldOptions['codTipoNorma'] = [
            'label' => 'label.diaria.tipo',
            'class' => TipoNorma::class,
            'choice_label' => function ($tipoNorma) {
                return $tipoNorma->getCodTipoNorma()
                . " - "
                . $tipoNorma->getNomTipoNorma();
            },
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'required' => true,
        ];

        $fieldOptions['fkNormasNorma'] = [
            'label' => 'label.diaria.codNorma',
            'class' => Norma::class,
            'req_params' => [
                'codTipoNorma' => 'varJsCodTipoNorma'
            ],
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
            'required' => true,
        ];

        $fieldOptions['dtInicio'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.diaria.dtInicio',
        ];

        $fieldOptions['dtTermino'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.diaria.dtTermino',
        ];

        $fieldOptions['hrInicio'] = [
            'label' => 'label.diaria.hrInicio',
            'widget' => 'single_text',
            'input'  => 'datetime',
        ];

        $fieldOptions['hrTermino'] = [
            'label' => 'label.diaria.hrTermino',
            'widget' => 'single_text',
            'input'  => 'datetime',
        ];

        $fieldOptions['codPais'] = [
            'class' => SwPais::class,
            'choice_label' => function ($swPais) {
                return $swPais->getNomPais();
            },
            'label' => 'label.diaria.nomPais',
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'query_builder' => function ($swPais) {
                return $swPais->createQueryBuilder('p')
                    ->orderBy('p.nomPais', 'ASC');
            },
            'mapped' => false,
        ];

        $fieldOptions['codUf'] = [
            'class' => SwUf::class,
            'choice_label' => function ($codUf) {
                return $codUf->getNomUf();
            },
            'label' => 'label.diaria.nomUf',
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
        ];

        $fieldOptions['fkSwMunicipio'] = [
            'label' => 'label.diaria.codMunicipio',
            'class' => SwMunicipio::class,
            'req_params' => array(
                'codUf' => 'varJsCodUf'
            ),
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                $qb = $repo->createQueryBuilder('m')
                    ->where('LOWER(m.nomMunicipio) LIKE :nomMunicipio')
                    ->andWhere('m.codUf = :codUf')
                    ->setParameter('nomMunicipio', "%" . strtolower($term) . "%")
                    ->setParameter('codUf', $request->get('codUf'))
                ;

                return $qb;
            },
            'required' => true,
        ];

        $fieldOptions['motivo'] = [
            'label' => 'label.diaria.motivo'
        ];

        $fieldOptions['fkDiariasTipoDiaria'] = [
            'class' => TipoDiaria::class,
            'choice_label' => 'nomTipo',
            'label' => 'label.tipodiaria.nomTipo',
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['vlUnitario'] = [
            'label' => 'label.diaria.vlUnitario',
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money ',
                'readonly' => true
            ],
        ];

        $fieldOptions['quantidade'] = [
            'label' => 'label.diaria.quantidade',
            'attr' => [
                'class' => 'numeric '
            ]
        ];

        $fieldOptions['vlTotal'] = [
            'label' => 'label.diaria.vlTotal',
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money ',
                'readonly' => true
            ]
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['codTipoNorma']['data'] = $this->getSubject()
            ->getFkNormasNorma()->getFkNormasTipoNorma();
        }

        $formMapper
            ->with('label.diaria.dadosServidor')
                ->add(
                    'fkPessoalContrato',
                    'autocomplete',
                    $fieldOptions['fkPessoalContrato'],
                    [
                        'admin_code' => 'core.admin.contrato'
                    ]
                )
            ->end()
            ->with('label.diaria.informacoesDiarias')
                ->add(
                    'codTipoNorma',
                    'entity',
                    $fieldOptions['codTipoNorma']
                )
                ->add(
                    'fkNormasNorma',
                    'autocomplete',
                    $fieldOptions['fkNormasNorma']
                )
                ->add(
                    'dtInicio',
                    'sonata_type_date_picker',
                    $fieldOptions['dtInicio']
                )
                ->add(
                    'dtTermino',
                    'sonata_type_date_picker',
                    $fieldOptions['dtTermino']
                )
                ->add(
                    'hrInicio',
                    'time',
                    $fieldOptions['hrInicio']
                )
                ->add(
                    'hrTermino',
                    'time',
                    $fieldOptions['hrTermino']
                )
                ->add(
                    'codPais',
                    'entity',
                    $fieldOptions['codPais']
                )
                ->add(
                    'codUf',
                    'entity',
                    $fieldOptions['codUf']
                )
                ->add(
                    'fkSwMunicipio',
                    'autocomplete',
                    $fieldOptions['fkSwMunicipio']
                )
                ->add(
                    'motivo',
                    null,
                    $fieldOptions['motivo']
                )
                ->add(
                    'fkDiariasTipoDiaria',
                    'entity',
                    $fieldOptions['fkDiariasTipoDiaria']
                )
                ->add(
                    'vlUnitario',
                    'money',
                    $fieldOptions['vlUnitario']
                )
                ->add(
                    'quantidade',
                    null,
                    $fieldOptions['quantidade']
                )
                ->add(
                    'vlTotal',
                    'money',
                    $fieldOptions['vlTotal']
                )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.diaria.informacoesDiarias')
                ->add(
                    'matriculaServidor',
                    'text',
                    [
                        'label' => 'label.matricula'
                    ]
                )
                ->add(
                    'fkNormasNorma',
                    'text',
                    [
                        'label' => 'label.diaria.codNorma',
                    ]
                )
                ->add(
                    'fkNormasNorma.dtPublicacao',
                    'date',
                    [
                        'label' => 'label.diaria.dataLeiDecreto',
                    ]
                )
                ->add(
                    'dtInicio',
                    'date',
                    [
                        'label' => 'label.diaria.dtInicio',
                    ]
                )
                ->add(
                    'hrInicio',
                    'time',
                    [
                        'label' => 'label.diaria.hrInicio',
                    ]
                )
                ->add(
                    'dtTermino',
                    'date',
                    [
                        'label' => 'label.diaria.dtTermino',
                    ]
                )
                ->add(
                    'hrTermino',
                    'time',
                    [
                        'label' => 'label.diaria.hrTermino',
                    ]
                )
                ->add(
                    'fkSwMunicipio.fkSwUf.fkSwPais.nomPais',
                    'text',
                    [
                        'label' => 'label.diaria.nomPais',
                    ]
                )
                ->add(
                    'fkSwMunicipio.fkSwUf.nomUf',
                    'text',
                    [
                        'label' => 'label.diaria.nomUf',
                    ]
                )
                ->add(
                    'fkSwMunicipio',
                    'text',
                    [
                        'label' => 'label.diaria.codMunicipio',
                    ]
                )
                ->add(
                    'motivo',
                    null,
                    [
                        'label' => 'label.diaria.motivo'
                    ]
                )
                ->add(
                    'fkDiariasTipoDiaria.nomTipo',
                    'text',
                    [
                        'label' => 'label.tipodiaria.nomTipo',
                    ]
                )
                ->add(
                    'vlUnitario',
                    'currency',
                    [
                        'label' => 'label.diaria.vlUnitario',
                        'currency' => 'BRL',
                    ]
                )
                ->add(
                    'quantidade',
                    'decimal',
                    [
                        'label' => 'label.diaria.quantidade',
                        'attributes' => ['fraction_digits' => 2],
                    ]
                )
                ->add(
                    'vlTotal',
                    'currency',
                    [
                        'label' => 'label.diaria.vlTotal',
                        'currency' => 'BRL',
                    ]
                )
            ->end()
        ;
    }

    public function prePersist($diaria)
    {
        $entityManager = $this->getEntityManager();

        $codDiaria = $entityManager->getRepository(Diaria::class)
        ->getProximoCodDiaria($diaria->getCodContrato());

        $diaria->setCodDiaria($codDiaria);
        $diaria->setFkAdministracaoUsuario(
            $this->getContainer()->get('security.token_storage')->getToken()->getUser()
        );
    }
}
