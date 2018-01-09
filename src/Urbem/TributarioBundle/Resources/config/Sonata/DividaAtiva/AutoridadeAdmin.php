<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\DividaAtiva;

use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Tributaria\DividaAtiva\Autoridade\AutoridadeModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class AutoridadeAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_divida_ativa_autoridade';
    protected $baseRoutePattern = 'tributario/divida-ativa/autoridade';
    protected $includeJs = ['/tributario/javascripts/dividaAtiva/autoridade/script.js'];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'tipoAutoridade',
                'doctrine_orm_callback',
                [
                    'label' => 'label.dividaAtivaAutoridade.tipoAutoridade',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'choice',
                [
                    'choices' => [
                        'label.dividaAtivaAutoridade.procuradorMunicipal'=> 'procurador',
                        'label.dividaAtivaAutoridade.autoridadeCompetente' => 'autoridade'
                    ],
                    'placeholder' => 'label.selecione'
                ]
            )
            ->add(
                'fkSwCgmPessoaFisica.fkSwCgm',
                'doctrine_orm_model_autocomplete',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.dividaAtivaAutoridade.servidor',
                ),
                'sonata_type_model_autocomplete',
                array(
                    'class' => SwCgm::class,
                    'property' => 'nomCgm',
                    'to_string_callback' => function ($swCgm, $property) {
                        return sprintf('%s - %s', $swCgm->getNumcgm(), $swCgm->getNomCgm());
                    },
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                ),
                array(
                    'admin_code' => 'core.admin.filter.sw_cgm'
                )
            )
        ;
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
        if (! $value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();
        $this->getDoctrine()->getRepository($this->getClass())->findAutoridadeBusca(
            $filter['tipoAutoridade']['value'],
            $filter['fkSwCgmPessoaFisica__fkSwCgm']['value'],
            $queryBuilder,
            $alias
        );

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('numcgm', null, ['label' => "cgm"])
            ->add('getNomCgm', null, ['label' => "label.dividaAtivaAutoridade.servidor"])
            ->add('getFuncaoCargo', null, ['label' => "label.dividaAtivaAutoridade.cargoFuncao"])
            ->add('getTipoAutoridade', null, ['label' => "label.dividaAtivaAutoridade.tipoAutoridade"])
            ;
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $autoridadeModel = new AutoridadeModel($this->getDoctrine());
        $fieldInit = $autoridadeModel->init($this->getSubject(), $this->getConfigurationPool()->getContainer());

        $disabled = ['disabled' => false];
        if (!empty($this->getSubject()->getCodAutoridade())) {
            $disabled['disabled'] = true;
        }

        $formMapper
            ->with('label.dividaAtivaAutoridade.dados')
            ->add(
                'tipoAutoridade',
                'choice',
                [
                    'label' => 'label.dividaAtivaAutoridade.tipoAutoridade',
                    'choices' => [
                        'label.dividaAtivaAutoridade.procuradorMunicipal'=> 'procurador',
                        'label.dividaAtivaAutoridade.autoridadeCompetente' => 'autoridade'
                    ],
                    'data' => $fieldInit['tipoAutoridade']['data'],
                    'mapped' => false,
                    'disabled' => $disabled['disabled'],
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add(
                'matriculas',
                'autocomplete',
                [
                    'label' => 'label.dividaAtivaAutoridade.matricula',
                    'multiple' => false,
                    'mapped' => false,
                    'required' => true,
                    'data' => $fieldInit['matriculas']['data'],
                    'route' => ['name' => 'tributario_divida_ativa_autoridade_matricula']
                ]
            )
            ->add(
                'funcaoCargo',
                'text',
                [
                    'label' => 'label.dividaAtivaAutoridade.informacoesFuncao',
                    'mapped' => false,
                    'disabled' => true,
                    'required' => false,
                    'data' => $fieldInit['funcaoCargo']['data']
                ]
            )
            ->add(
                'tipo',
                'choice',
                [
                    'label' => 'label.dividaAtivaAutoridade.tipoNorma',
                    'choices' => $autoridadeModel->getAllTipoNormas()->toArray(),
                    'required' => true,
                    'mapped' => false,
                    'placeholder' => 'Selecione',
                    'data' => $fieldInit['tipo']['data'],
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'fundamentacaoLegal',
                'choice',
                [
                    'label' => 'label.dividaAtivaAutoridade.fundamentacaoLegal',
                    'choices' => $autoridadeModel->getFundamentacaoLegal(null)->toArray(),
                    'required' => true,
                    'mapped' => false,
                    'placeholder' => 'Selecione',
                    'data' => $fieldInit['fundamentacaoLegal']['data'],
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'tipoAssinatura',
                'file',
                [
                    'label' => 'label.dividaAtivaAutoridade.tipoAssinatura',
                    'data_class' => null,
                    'help' => (!empty($fieldInit['tipoAssinatura']['help']) ? $fieldInit['tipoAssinatura']['help'] : '')
                ]
            )
            ->add(
                'oab',
                'text',
                [
                    'label' => 'label.dividaAtivaAutoridade.oab',
                    'mapped' => false,
                    'required' => true,
                    'data' => $fieldInit['oab']['data'],
                ]
            )
            ->add(
                'codUf',
                'choice',
                [
                    'label' => 'label.uf',
                    'choices' => $autoridadeModel->getSwUf()->toArray(),
                    'required' => true,
                    'mapped' => false,
                    'data' => $fieldInit['codUf']['data'],
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'file',
                'hidden',
                array(
                    'data' => $fieldInit['file']['data'],
                    'mapped' => false,
                )
            )
            ->add(
                'fundamentacaoLegalEdit',
                'hidden',
                array(
                    'data' => $fieldInit['fundamentacaoLegal']['data'],
                    'mapped' => false,
                )
            )
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $autoridadeModel = new AutoridadeModel($this->getDoctrine());
        $autoridadeModel->prePersist($this->getForm()->all(), $object);
        $autoridadeModel->upload($object, $this->getConfigurationPool()->getContainer());
    }

    /**
     * @param mixed $object
     */
    public function postPersist($object)
    {
        $autoridadeModel = new AutoridadeModel($this->getDoctrine());
        $autoridadeModel->postPersist($this->getForm()->all(), $object);
        $autoridadeModel->save($object);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $autoridadeModel = new AutoridadeModel($this->getDoctrine());
        $autoridadeModel->prePersist($this->getForm()->all(), $object);
        $autoridadeModel->uploadUpdate($object, $this->getConfigurationPool()->getContainer(), $this->getForm()->all());
        $autoridadeModel->postPersist($this->getForm()->all(), $object);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $autoridadeModel = new AutoridadeModel($this->getDoctrine());
        $fieldInit = $autoridadeModel->init($this->getSubject(), $this->getConfigurationPool()->getContainer());
        $fundamentacaoLegal = $autoridadeModel->getFundamentacaoLegalAndTipo($fieldInit['fundamentacaoLegal']['data']);

        $showMapper
            ->with('label.dividaAtivaAutoridade.dados')
            ->add(
                'tipoAutoridade',
                null,
                [
                    'label' => 'label.dividaAtivaAutoridade.tipoAutoridade',
                    'mapped' => false,
                    'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                    'data' => $fieldInit['tipoAutoridade']['data']
                ]
            )
            ->add(
                'matricula',
                null,
                [
                    'label' => 'label.dividaAtivaAutoridade.matricula',
                    'mapped' => false,
                    'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                    'data' => $fieldInit['matriculas']['data']
                ]
            )
            ->add(
                'informacoesFuncao',
                null,
                [
                    'label' => 'label.dividaAtivaAutoridade.informacoesFuncao',
                    'mapped' => false,
                    'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                    'data' => $fieldInit['funcaoCargo']['data']
                ]
            )
            ->add(
                'tipo',
                null,
                [
                    'label' => 'label.dividaAtivaAutoridade.tipoNorma',
                    'mapped' => false,
                    'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                    'data' => $fundamentacaoLegal['tipo']
                ]
            )
            ->add(
                'fundamentacaoLegal',
                null,
                [
                    'label' => 'label.dividaAtivaAutoridade.fundamentacaoLegal',
                    'mapped' => false,
                    'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                    'data' => $fundamentacaoLegal['fundamentacaoLegal']
                ]
            )
            ->add(
                'file',
                null,
                [
                    'label' => 'label.dividaAtivaAutoridade.tipoAssinatura',
                    'mapped' => false,
                    'template' => 'TributarioBundle:Sonata/DividaAtiva/CRUD:show_html.html.twig',
                    'data' => $fieldInit['tipoAssinatura']['help']
                ]
            )
        ;

        if (!empty($fieldInit['oab']['data']) && !empty($fieldInit['codUf']['data'])) {
            $showMapper
                ->add(
                    'oab',
                    null,
                    [
                        'label' => 'label.dividaAtivaAutoridade.oab',
                        'mapped' => false,
                        'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                        'data' => $fieldInit['oab']['data']
                    ]
                )
                ->add(
                    'uf',
                    null,
                    [
                        'label' => 'label.uf',
                        'mapped' => false,
                        'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                        'data' => $this->getDoctrine()->getRepository(SwUf::class)->find($fieldInit['codUf']['data'])->getNomUf()
                    ]
                )
            ;
        }
    }
}
