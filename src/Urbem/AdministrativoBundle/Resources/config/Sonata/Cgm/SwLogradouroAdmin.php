<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Cgm;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Entity\SwBairroLogradouro;
use Urbem\CoreBundle\Entity\SwCep;
use Urbem\CoreBundle\Entity\SwCepLogradouro;
use Urbem\CoreBundle\Entity\SwLogradouro;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwNomeLogradouro;
use Urbem\CoreBundle\Entity\SwTipoLogradouro;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\SwCepModel;
use Urbem\CoreBundle\Model\SwLogradouroModel;
use Urbem\CoreBundle\Repository\Normas\NormaRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @TODO    Cadastro de Historicos (Deixar por ultimo.).
 *
 * Class SwLogradouroAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao
 */
class SwLogradouroAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_administrativo_logradouro';
    protected $baseRoutePattern = 'administrativo/logradouro';

    protected $model = SwLogradouroModel::class;

    protected $datagridValues = [
        '_page'       => 1,
        '_sort_order' => 'DESC',
        '_sort_by'    => 'codLogradouro',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('api_municipios', 'api/municipios')
            ->add('consultar_logradouro', 'consultar-logradouro/' . $this->getRouterIdParameter())
            ->add('api_logradouro', 'api/' . $this->getRouterIdParameter());
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        array_push($this->includeJs, '/administrativo/javascripts/cgm/swlogradouro/form--datagrid.js');

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
            'class'      => SwMunicipio::class,
            'attr'       => ['class' => 'select2-parameters '],
            'route'      => ['name' => 'urbem_administrativo_logradouro_api_municipios'],
            'req_params' => ['codUf' => 'varJsCodUf']
        ];

        if (isset($data['fkSwMunicipio']) && !empty($data['fkSwMunicipio']['value'])) {
            $fieldOptions['fkSwMunicipio']['data'] =
                $this->getModelManager()->find(SwMunicipio::class, $data['fkSwMunicipio']['value']);
        }

        $datagridMapper
            ->add('fkSwNomeLogradouros.nomLogradouro', null, ['label' => 'label.swLogradouro.nome'])
            ->add('fkSwMunicipio.fkSwUf', null, [
                'label' => 'label.swBairro.codUf'
            ], null, $fieldOptions['fkSwMunicipio.fkSwUf'])
            /** Convertido para autcomplete para optimizar a busca. */
            ->add('fkSwMunicipio', 'composite_filter', [
                'label' => 'label.swBairro.codMunicipio'
            ], 'autocomplete', $fieldOptions['fkSwMunicipio']);
    }

    /**
     * {@inheritdoc}
     */
    protected function addActionsGrid(ListMapper $listMapper)
    {
        $listMapper
            ->add('_action', 'actions', [
                'actions' => [
                    'show'      => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'edit'      => ['template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'],
                    'historico' => ['template' => 'AdministrativoBundle:Sonata/Cgm/Logradouro/CRUD:list__action_historico.html.twig'],
                    'delete'    => ['template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'],
                ]
            ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codLogradouro', null, ['label' => 'label.swLogradouro.codigo'])
            ->add('currentFkSwNomeLogradouro', null, ['label' => 'label.swLogradouro.nome'])
            ->add('fkSwMunicipio.fkSwUf.nomUf', null, ['label' => 'label.swLogradouro.estado'])
            ->add('fkSwMunicipio.nomMunicipio', null, ['label' => 'label.swLogradouro.municipio']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->includeJs = array_merge($this->includeJs, [
            '/administrativo/javascripts/cgm/swlogradouro/form--estado-municipio.js',
            '/administrativo/javascripts/cgm/swlogradouro/form--municipio-bairros.js'
        ]);

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        /** @var SwLogradouro $swLogradouro */
        $swLogradouro = $this->getSubject();
        $isUpdate = is_null($swLogradouro) ? false : !$swLogradouro->getFkSwNomeLogradouros()->isEmpty();

        $exercicio = $this->getExercicio();

        $fieldOptions = [];
        $fieldOptions['codLogradouro'] = [
            'data'   => (new SwLogradouroModel($entityManager))->getNextCodLogradouro(),
            'label'  => 'label.swLogradouro.codLogradouro',
            'mapped' => false
        ];

        $fieldOptions['fkSwNomeLogradouros.fkSwTipoLogradouro'] = [
            'attr'   => ['class' => 'select2-parameters'],
            'class'  => SwTipoLogradouro::class,
            'label'  => 'label.swLogradouro.tipo',
            'mapped' => false,
        ];

        $fieldOptions['fkSwNomeLogradouros.nomLogradouro'] = [
            'label'  => 'label.swLogradouro.nomeAtual',
            'mapped' => false,
        ];

        $fieldOptions['fkSwLogradouro.fkSwUf'] = [
            'attr'          => ['class' => 'select2-parameters'],
            'class'         => SwUf::class,
            'choice_label'  => 'nomUf',
            'label'         => 'label.swBairro.codUf',
            'mapped'        => false,
            'placeholder'   => 'label.selecione',
            'required'      => true,
            'query_builder' => function (EntityRepository $repository) {
                return $repository
                    ->createQueryBuilder('e')
                    ->where('e.codUf != 0')
                    ->orderBy('e.nomUf', 'ASC');
            }
        ];

        $fieldOptions['fkSwMunicipio'] = [
            'attr'                 => ['class' => 'select2-parameters'],
            'class'                => SwMunicipio::class,
            'label'                => 'label.swBairro.codMunicipio',
            'json_choice_label'    => function (SwMunicipio $swMunicipio) {
                return $swMunicipio->getNomMunicipio();
            },
            'json_from_admin_code' => $this->code,
            'json_query_builder'   => function (EntityRepository $repository, $term, Request $request) {
                return $repository
                    ->createQueryBuilder('m')
                    ->join('m.fkSwUf', 'u')
                    ->join('m.fkSwBairros', 'b')
                    ->where('u.codUf = :cod_uf')
                    ->andWhere('lower(m.nomMunicipio) LIKE lower(:term)')
                    ->setParameters([
                        'cod_uf' => $request->get('codUf'),
                        'term'   => "%{$term}%"
                    ]);
            },
            'placeholder'          => $this->trans('label.selecione'),
            'req_params'           => ['codUf' => 'varJsCodUf'],
            'required'             => true
        ];

        $fieldOptions['fkSwNomeLogradouros.fkNormasNorma'] = [
            'attr'          => ['class' => 'select2-parameters'],
            'class'         => Norma::class,
            'label'         => 'label.swLogradouro.norma',
            'mapped'        => false,
            'query_builder' => function (NormaRepository $repository) use ($exercicio) {
                return $repository
                    ->createQueryBuilder('n')
                    ->where('n.exercicio = :exercicio')
                    ->setParameter('exercicio', $exercicio);
            },
            'placeholder'   => 'label.selecione',
        ];

        $fieldOptions['fkSwNomeLogradouros.dtInicio'] = [
            'label'  => 'label.swLogradouro.dtInicio',
            'format' => 'dd/MM/yyyy',
            'mapped' => false
        ];

        $fieldOptions['fkSwNomeLogradouros.dtFim'] = [
            'label'    => 'label.swLogradouro.dtFim',
            'format'   => 'dd/MM/yyyy',
            'mapped'   => false,
            'required' => false,
        ];

        $fieldOptions['fkSwBairroLogradouros'] = [
            'label'       => false,
            'constraints' => [new Assert\Callback([$this, 'validateSwBairroLogradouroDuplicates'])]
        ];

        $fieldOptions['fkSwCepLogradouros'] = [
            'label'       => false,
            'constraints' => [new Assert\Callback([$this, 'validateSwCepLogradouroDuplicates'])]
        ];

        $fieldDescriptionOptions = [];
        $fieldDescriptionOptions['fkSwBairroLogradouros'] = [
            'edit'   => 'inline',
            'inline' => 'table',
        ];

        $fieldDescriptionOptions['fkSwCepLogradouros'] = [
            'edit'   => 'inline',
            'inline' => 'table',
        ];

        if ($isUpdate) {
            /** @var SwNomeLogradouro $swNomeLogradouro */
            $swNomeLogradouro = $swLogradouro->getCurrentFkSwNomeLogradouro();

            $defaultCustomFieldOptions = [
                'attr'     => ['class' => 'form_row col s3 campo-sonata'],
                'label'    => false,
                'mapped'   => false,
                'template' => 'CoreBundle:Sonata\CRUD:edit_generic.html.twig'
            ];

            $fieldOptions['codLogradouro'] = array_merge($defaultCustomFieldOptions, [
                'data' => [
                    'value' => $swLogradouro->getCodLogradouro(),
                    'label' => 'label.swLogradouro.codLogradouro'
                ],
            ]);

            $fieldOptions['fkSwLogradouro.fkSwUf'] = array_merge($defaultCustomFieldOptions, [
                'data' => [
                    'value' => $swLogradouro->getFkSwMunicipio()->getFkSwUf()->getNomUf(),
                    'label' => 'label.swBairro.codUf'
                ],
            ]);

            $fieldOptions['fkSwMunicipio'] = array_merge($defaultCustomFieldOptions, [
                'data' => [
                    'value' => $swLogradouro->getFkSwMunicipio()->getNomMunicipio(),
                    'label' => 'label.swBairro.codMunicipio',
                ],
            ]);

            $fieldOptions['fkSwNomeLogradouros.fkSwTipoLogradouro']['data'] = $swNomeLogradouro->getFkSwTipoLogradouro();
            $fieldOptions['fkSwNomeLogradouros.nomLogradouro']['data'] = $swNomeLogradouro->getNomLogradouro();
            $fieldOptions['fkSwNomeLogradouros.fkNormasNorma']['data'] = $swNomeLogradouro->getFkNormasNorma();
            $fieldOptions['fkSwNomeLogradouros.dtInicio']['data'] = $swNomeLogradouro->getDtInicio();
            $fieldOptions['fkSwNomeLogradouros.dtFim']['data'] = $swNomeLogradouro->getDtFim();
        }

        $formMapper->with('label.dadosLogradouro');

        if ($isUpdate) {
            $fieldOptions['fkSwMunicipioH'] = [
                'mapped' => false,
                'data'   => $this->id($swLogradouro->getFkSwMunicipio())
            ];

            $formMapper->add('fkSwMunicipioH', 'hidden', $fieldOptions['fkSwMunicipioH']);
        }

        $formMapper
            ->add('codLogradouro', $isUpdate ? 'customField' : null, $fieldOptions['codLogradouro'])
            ->add('fkSwNomeLogradouros.fkSwTipoLogradouro', 'entity', $fieldOptions['fkSwNomeLogradouros.fkSwTipoLogradouro'])
            ->add('fkSwNomeLogradouros.nomLogradouro', 'text', $fieldOptions['fkSwNomeLogradouros.nomLogradouro']);

        // Campos auxliliares na busca do SwLogradouro
        $formMapper
            ->add('fkSwMunicipio.fkSwUf', $isUpdate ? 'customField' : 'entity', $fieldOptions['fkSwLogradouro.fkSwUf'])
            ->add('fkSwMunicipio', $isUpdate ? 'customField' : 'autocomplete', $fieldOptions['fkSwMunicipio']);

        $formMapper
            ->add('fkSwNomeLogradouros.fkNormasNorma', 'entity', $fieldOptions['fkSwNomeLogradouros.fkNormasNorma'])
            ->add('fkSwNomeLogradouros.dtInicio', 'sonata_type_date_picker', $fieldOptions['fkSwNomeLogradouros.dtInicio'])
            ->add('fkSwNomeLogradouros.dtFim', 'sonata_type_date_picker', $fieldOptions['fkSwNomeLogradouros.dtFim']);

        $formMapper->end();

        $formMapper
            ->with('label.swLogradouro.bairros')
            ->add(
                'fkSwBairroLogradouros',
                'sonata_type_collection',
                $fieldOptions['fkSwBairroLogradouros'],
                $fieldDescriptionOptions['fkSwBairroLogradouros'],
                ['admin_code' => 'administrativo.admin.sw_bairro_logradouro']
            )
            ->end();

        $formMapper
            ->with('label.swLogradouro.ceps')
            ->add(
                'fkSwCepLogradouros',
                'sonata_type_collection',
                $fieldOptions['fkSwCepLogradouros'],
                $fieldDescriptionOptions['fkSwCepLogradouros'],
                ['admin_code' => 'administrativo.admin.sw_cep_logradouro']
            )
            ->end();
    }

    /**
     * @param Collection                $collection
     * @param ExecutionContextInterface $context
     */
    public function validateSwBairroLogradouroDuplicates(Collection $collection, ExecutionContextInterface $context)
    {
        $hasDuplicated = false;

        /** @var SwBairroLogradouro $swBairroLogradouro */
        foreach ($collection as $index => $swBairroLogradouro) {
            $hasDuplicated = $collection->exists(
                function ($subIndex, SwBairroLogradouro $subSwBairroLogradouro) use ($index, $swBairroLogradouro) {
                    return $swBairroLogradouro->getFkSwBairro() === $subSwBairroLogradouro->getFkSwBairro() && $subIndex != $index;
                }
            );

            break;
        }

        if ($hasDuplicated) {
            $message = $this->trans('swLogradouros.errors.bairroDuplicado', [], 'validators');
            $context->addViolation($message);
        }

        if ($collection->isEmpty()) {
            $message = $this->trans('swLogradouros.errors.semBairro', [], 'validators');
            $context->addViolation($message);
        }
    }

    /**
     * @param Collection                $collection
     * @param ExecutionContextInterface $context
     */
    public function validateSwCepLogradouroDuplicates(Collection $collection, ExecutionContextInterface $context)
    {
        $hasDuplicated = false;

        /** @var SwCepLogradouro $swCepLogradouro */
        foreach ($collection as $index => $swCepLogradouro) {
            $hasDuplicated = $collection->exists(
                function ($subIndex, SwCepLogradouro $subSwCepLogradouro) use ($index, $swCepLogradouro) {
                    return $swCepLogradouro->getCep() === $subSwCepLogradouro->getCep() && $subIndex != $index;
                }
            );

            break;
        }

        if ($hasDuplicated) {
            $message = $this->trans('swLogradouros.errors.cepDuplicado', [], 'validators');
            $context->addViolation($message);
        }

        if ($collection->isEmpty()) {
            $message = $this->trans('swLogradouros.errors.semCEP', [], 'validators');
            $context->addViolation($message);
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param SwLogradouro $newSwLogradouro
     */
    public function validate(ErrorElement $errorElement, $newSwLogradouro)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $form = $this->getForm();

        if (is_null($newSwLogradouro->getCodLogradouro())) {
            $codLogradouro = $form->get('codLogradouro')->getData();

            /** @var SwLogradouro $swLogradouro */
            $swLogradouro = $entityManager->find(SwLogradouro::class, $codLogradouro);

            if (!is_null($swLogradouro)) {
                $message = $this->trans('swLogradouros.errors.codLogradouroRepetido', [
                    '%codigo'   => $codLogradouro,
                    '%sugestao' => (new SwLogradouroModel($entityManager))->getNextCodLogradouro()
                ], 'validators');

                $errorElement->with('codLogradouro')->addViolation($message)->end();
            }
        }

        /** @var \DateTime $dtInicio */
        $dtInicio = $form->get('fkSwNomeLogradouros__dtInicio')->getData();

        /** @var \DateTime $dtFim */
        $dtFim = $form->get('fkSwNomeLogradouros__dtFim')->getData();

        if (!is_null($dtFim) && $dtFim < $dtInicio) {
            $message = $this->trans('swLogradouros.errors.dtinicioMaiorDtFim', [
                '%dtInicio' => $dtInicio->format('dd/MM/yyyy')
            ], 'validators');

            $errorElement->with('fkSwNomeLogradouros.dtFim')->addViolation($message)->end();
        }
    }

    /**
     * @param SwLogradouro          $swLogradouro
     * @param SwNomeLogradouro|null $swNomeLogradouro
     */
    public function persistOneFkSwNomeLogradouro(SwLogradouro $swLogradouro, SwNomeLogradouro $swNomeLogradouro = null)
    {
        $form = $this->getForm();

        /** @var SwTipoLogradouro $swTipoLogradouro */
        $swTipoLogradouro = $form->get('fkSwNomeLogradouros__fkSwTipoLogradouro')->getData();

        /** @var Norma $norma */
        $norma = $form->get('fkSwNomeLogradouros__fkNormasNorma')->getData();

        $nomLogradouro = $form->get('fkSwNomeLogradouros__nomLogradouro')->getData();

        /** @var \DateTime $dtInicio */
        $dtInicio = $form->get('fkSwNomeLogradouros__dtInicio')->getData();

        /** @var \DateTime $dtFim */
        $dtFim = $form->get('fkSwNomeLogradouros__dtFim')->getData();

        if (is_null($swNomeLogradouro)) {
            $swNomeLogradouro = new SwNomeLogradouro();
        }

        $swNomeLogradouro->setFkSwTipoLogradouro($swTipoLogradouro);
        $swNomeLogradouro->setFkNormasNorma($norma);
        $swNomeLogradouro->setNomLogradouro($nomLogradouro);
        $swNomeLogradouro->setDtInicio($dtInicio);
        $swNomeLogradouro->setDtFim($dtFim);

        $swLogradouro->addFkSwNomeLogradouros($swNomeLogradouro);
    }

    /**
     * @param SwLogradouro $swLogradouro
     */
    public function persistFkBairroLogradouros(SwLogradouro $swLogradouro)
    {
        /** @var SwBairroLogradouro $swBairroLogradouro */
        foreach ($swLogradouro->getFkSwBairroLogradouros() as $swBairroLogradouro) {
            $swBairroLogradouro->setFkSwLogradouro($swLogradouro);
        }
    }

    /**
     * @param string          $index
     * @param SwCepLogradouro $swCepLogradouro
     */
    public function persistFkSwCepLogradourosNumeracao($index, SwCepLogradouro $swCepLogradouro)
    {
        $form = $this->getForm();

        /** @var Collection $fkSwCepLogradouroForm */
        $fkSwCepLogradouroForm = $form->get('fkSwCepLogradouros');

        $numeracao = $fkSwCepLogradouroForm->get($index)->get('numeracao')->getData();

        switch ($numeracao) {
            case 't':
                $swCepLogradouro->setPar(true);
                $swCepLogradouro->setImpar(true);
                break;
            case 'p':
                $swCepLogradouro->setPar(true);
                $swCepLogradouro->setImpar(false);
                break;
            case 'i':
                $swCepLogradouro->setPar(false);
                $swCepLogradouro->setImpar(true);
                break;
        }
    }

    /**
     * @param SwLogradouro $swLogradouro
     */
    public function persistFkSwCepLogradouros(SwLogradouro $swLogradouro)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->modelManager;
        $entityManager = $modelManager->getEntityManager($this->getClass());

        /** @var SwCepLogradouro $swCepLogradouro */
        foreach ($swLogradouro->getFkSwCepLogradouros() as $index => $swCepLogradouro) {
            $cep = $swCepLogradouro->getCep();

            /** @var SwCep $swCep */
            $swCep = $modelManager->find(SwCep::class, $cep);

            if (is_null($swCep)) {
                $swCep = (new SwCepModel($entityManager))->buidOne($cep);
                $entityManager->persist($swCep);
            }

            $this->persistFkSwCepLogradourosNumeracao($index, $swCepLogradouro);

            $swCep->addFkSwCepLogradouros($swCepLogradouro);
            $swCepLogradouro->setFkSwLogradouro($swLogradouro);
        }
    }

    /**
     * @param SwLogradouro $swLogradouro
     */
    public function prePersist($swLogradouro)
    {
        $codLogradouro = $this->getForm()->get('codLogradouro')->getData();
        $swLogradouro->setCodLogradouro($codLogradouro);

        $this->persistFkSwCepLogradouros($swLogradouro);
        $this->persistFkBairroLogradouros($swLogradouro);
        $this->persistOneFkSwNomeLogradouro($swLogradouro);
    }

    /**
     * @param SwLogradouro $swLogradouro
     */
    public function preUpdate($swLogradouro)
    {
        /** @var SwNomeLogradouro $swNomeLogradouro */
        $swNomeLogradouro = $swLogradouro->getCurrentFkSwNomeLogradouro();

        $this->persistFkSwCepLogradouros($swLogradouro);
        $this->persistFkBairroLogradouros($swLogradouro);

        $this->persistOneFkSwNomeLogradouro($swLogradouro, $swNomeLogradouro);
    }

    /**
     * @param SwLogradouro $swLogradouro
     *
     * @return string
     */
    public function toString($swLogradouro)
    {
        $collectionSwNomeLogradouros = $swLogradouro->getFkSwNomeLogradouros();

        if ($collectionSwNomeLogradouros->isEmpty()) {
            return $this->trans("swLogradouro");
        }

        /** @var SwNomeLogradouro $swNomeLogradouro */
        $swNomeLogradouro = $collectionSwNomeLogradouros->current();

        return $swNomeLogradouro->getNomLogradouro();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        /** @var SwLogradouro $swLogradouro */
        $swLogradouro = $this->getSubject();

        $this->setBreadCrumb(['id' => $this->id($swLogradouro)]);

        $defaultCustomFieldOptions = ['template' => 'CoreBundle:Sonata\CRUD:show_custom_value.html.twig'];

        $showMapper
            ->with('Dados para Logradouro')
            ->add('codLogradouro', null, ['label' => 'label.swLogradouro.codigo'])
            ->add('fkNomeLogradouros.fkSwTipoLogradouro', null, array_merge($defaultCustomFieldOptions, [
                'data'  => $swLogradouro->getCurrentFkSwNomeLogradouro()->getFkSwTipoLogradouro(),
                'label' => 'label.swLogradouro.tipo'
            ]))
            ->add('fkNomeLogradouros.nomLogradouro', null, array_merge($defaultCustomFieldOptions, [
                'data'  => $swLogradouro->getCurrentFkSwNomeLogradouro(),
                'label' => 'label.swLogradouro.nome'
            ]))
            ->add('fkSwMunicipio.fkSwUf.nomUf', null, ['label' => 'label.swLogradouro.estado'])
            ->add('fkSwMunicipio.nomMunicipio', null, ['label' => 'label.swLogradouro.municipio'])
            ->end();

        $showMapper
            ->with('label.swLogradouro.historico')
            ->add('fkSwNomeLogradouros', 'customField', [
                'template' => 'AdministrativoBundle:Sonata\Cgm\Logradouro\CRUD:show__fkSwNomeLogradouros.html.twig'
            ])
            ->end();

        $showMapper
            ->with('label.swLogradouro.bairros')
            ->add('fkSwBairroLogradouros', 'customField', [
                'template' => 'AdministrativoBundle:Sonata\Cgm\Logradouro\CRUD:show__fkSwBairroLogradouros.html.twig'
            ])
            ->end();

        $showMapper
            ->with('label.swLogradouro.ceps')
            ->add('fkSwCepLogradouros', 'customField', [
                'template' => 'AdministrativoBundle:Sonata\Cgm\Logradouro\CRUD:show__fkSwCepLogradouros.html.twig'
            ])
            ->end();
    }
}
