<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Cgm;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\SwBairroModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class SwBairroAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Cgm
 */
class SwBairroAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_cgm_sw_bairro';
    protected $baseRoutePattern = 'administrativo/cgm/manutencao-bairro';

    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'nomBairro, codBairro',
    ];

    protected $model = SwBairroModel::class;

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_municipio', 'consultar-municipio/' . $this->getRouterIdParameter());
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        array_push($this->includeJs, '/administrativo/javascripts/cgm/swbairro/form--datagrid.js');

        $data = $this->getDatagrid()->getValues();

        $fieldOptions = [];
        $fieldOptions['fkSwMunicipio.fkSwUf'] = [
            'attr'          => ['class' => 'select2-parameters '],
            'choice_label'  => 'nomUf',
            'query_builder' => function (EntityRepository $repository) {
                return $repository
                    ->createQueryBuilder('u')
                    ->join('u.fkSwMunicipios', 'm')
                    ->join('m.fkSwBairros', 'b')
                    ->orderBy('u.nomUf', 'ASC');
            },
        ];

        $fieldOptions['fkSwMunicipio'] = [
            'attr'         => ['class' => 'select2-parameters '],
            'class'        => SwMunicipio::class,
            'choice_label' => 'nomMunicipio',
            'choices'      => [],
            'disabled'     => true,
        ];

        if (isset($data['fkSwMunicipio__fkSwUf']) && !empty($data['fkSwMunicipio__fkSwUf']['value'])) {
            unset($fieldOptions['fkSwMunicipio']['disabled']);
            unset($fieldOptions['fkSwMunicipio']['choices']);

            $fieldOptions['fkSwMunicipio']['query_builder'] = function (EntityRepository $repository) use ($data) {
                return $repository
                    ->createQueryBuilder('m')
                    ->where('m.codUf = :cod_uf')
                    ->setParameter('cod_uf', $data['fkSwMunicipio__fkSwUf']['value'])
                    ->orderBy('m.nomMunicipio', 'ASC');
            };
        }

        $datagridMapper
            ->add('nomBairro', null, ['label' => 'label.swBairro.nomBairro'])
            ->add('fkSwMunicipio.fkSwUf', null, [
                'label' => 'label.swBairro.codUf'
            ], null, $fieldOptions['fkSwMunicipio.fkSwUf'])

            /** Populado com js para optimizar a busca. */
            ->add('fkSwMunicipio', 'composite_filter', [
                'label' => 'label.swBairro.codMunicipio'
            ], 'entity', $fieldOptions['fkSwMunicipio']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codBairro', null, ['label' => 'label.codigo'])
            ->add('fkSwMunicipio.fkSwUf.nomUf', null, ['label' => 'label.swBairro.codUf'])
            ->add('fkSwMunicipio.nomMunicipio', null, ['label' => 'label.swBairro.codMunicipio'])
            ->add('nomBairro', null, ['label' => 'label.swBairro.nomBairro'])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $this->label = 'label.swBairro.dadosBairro';

        array_push($this->includeJs, '/administrativo/javascripts/cgm/swbairro/form.js');

        /** @var SwBairro $swBairro */
        $swBairro = $this->getSubject();

        $fieldOptions = [];
        $fieldOptions['fkSwUf'] = [
            'attr'          => ['class' => 'select2-parameters'],
            'class'         => SwUf::class,
            'choice_label'  => 'nomUf',
            'label'         => 'label.swBairro.codUf',
            'mapped'        => false,
            'placeholder'   => 'label.selecione',
            'query_builder' => function (EntityRepository $repository) {
                return $repository
                    ->createQueryBuilder('e')
                    ->where('e.codUf != 0')
                    ->orderBy('e.nomUf', 'ASC');
            }
        ];

        $fieldOptions['fkSwMunicipio'] = [
            'attr'                 => ['class' => 'select2-parameters'],
            'label'                => 'label.swBairro.codMunicipio',
            'placeholder'          => $this->trans('label.selecione'),
            'class'                => SwMunicipio::class,
            'json_choice_label'    => function (SwMunicipio $swMunicipio) {
                return $swMunicipio->getNomMunicipio();
            },
            'json_from_admin_code' => $this->code,
            'json_query_builder'   => function (EntityRepository $repository, $term, Request $request) {
                return $repository
                    ->createQueryBuilder('m')
                    ->join('m.fkSwUf', 'u')
                    ->where('u.codUf = :cod_uf')
                    ->andWhere('lower(m.nomMunicipio) LIKE lower(:term)')
                    ->setParameters([
                        'cod_uf' => $request->get('codUf'),
                        'term'   => "%{$term}%"
                    ]);
            },
            'req_params'           => [
                'codUf' => 'varJsCodUf'
            ],
            'required'             => true,
        ];

        $fieldOptions['nomBairro'] = ['label' => 'label.swBairro.nomBairro'];

        $isEdit = !is_null($this->id($swBairro));

        if ($isEdit) {
            $fieldOptionCustomGeneric = [
                'attr'     => ['class' => 'form_row col s3 campo-sonata'],
                'label'    => false,
                'mapped'   => false,
                'template' => 'CoreBundle:Sonata\CRUD:edit_generic.html.twig'
            ];

            $fieldOptions['fkSwUf'] = array_merge($fieldOptionCustomGeneric, [
                'data' => [
                    'label' => 'label.swBairro.codUf',
                    'value' => $swBairro->getFkSwMunicipio()->getFkSwUf()->getNomUf()
                ]
            ]);

            $fieldOptions['fkSwMunicipio'] = array_merge($fieldOptionCustomGeneric, [
                'data' => [
                    'label' => 'label.swBairro.codMunicipio',
                    'value' => $swBairro->getFkSwMunicipio()->getNomMunicipio()
                ]
            ]);

            $formMapper->add('fkSwUf', 'customField', $fieldOptions['fkSwUf']);
            $formMapper->add('fkSwMunicipio', 'customField', $fieldOptions['fkSwMunicipio']);
        } else {
            $fieldOptions['fkSwUf'] = [
                'attr'          => ['class' => 'select2-parameters'],
                'class'         => SwUf::class,
                'choice_label'  => 'nomUf',
                'label'         => 'label.swBairro.codUf',
                'mapped'        => false,
                'placeholder'   => 'label.selecione',
                'query_builder' => function (EntityRepository $repository) {
                    return $repository
                        ->createQueryBuilder('e')
                        ->where('e.codUf != 0')
                        ->orderBy('e.nomUf', 'ASC');
                }
            ];

            $fieldOptions['fkSwMunicipio'] = [
                'attr'                 => ['class' => 'select2-parameters'],
                'label'                => 'label.swBairro.codMunicipio',
                'placeholder'          => $this->trans('label.selecione'),
                'class'                => SwMunicipio::class,
                'json_choice_label'    => function (SwMunicipio $swMunicipio) {
                    return $swMunicipio->getNomMunicipio();
                },
                'json_from_admin_code' => $this->code,
                'json_query_builder'   => function (EntityRepository $repository, $term, Request $request) {
                    return $repository
                        ->createQueryBuilder('m')
                        ->join('m.fkSwUf', 'u')
                        ->where('u.codUf = :cod_uf')
                        ->andWhere('lower(m.nomMunicipio) LIKE lower(:term)')
                        ->setParameters([
                            'cod_uf' => $request->get('codUf'),
                            'term'   => "%{$term}%"
                        ]);
                },
                'req_params'           => [
                    'codUf' => 'varJsCodUf'
                ],
                'required'             => true,
            ];

            $formMapper->add('fkSwUf', 'entity', $fieldOptions['fkSwUf']);
            $formMapper->add('fkSwMunicipio', 'autocomplete', $fieldOptions['fkSwMunicipio']);
        }

        $formMapper->add('nomBairro', null, $fieldOptions['nomBairro']);
    }

    /**
     * @param SwBairro $swBairro
     */
    public function prePersist($swBairro)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $codBairro = (new SwBairroModel($entityManager))->nextVal($swBairro->getFkSwMunicipio());

        $swBairro->setCodBairro($codBairro);
    }


    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->with('label.swBairro.modulo')
            ->add('codBairro', null, ['label' => 'label.codigo'])
            ->add('fkSwMunicipio.fkSwUf.nomUf', null, ['label' => 'label.swBairro.codUf'])
            ->add('fkSwMunicipio.nomMunicipio', null, ['label' => 'label.swBairro.codMunicipio'])
            ->add('nomBairro', null, ['label' => 'label.swBairro.nomBairro'])
            ->end();
        ;
    }
}
