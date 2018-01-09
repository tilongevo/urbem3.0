<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Beneficio;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Helper\DatePK;

class VigenciaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_beneficio_vigencia';
    protected $baseRoutePattern = 'recursos-humanos/beneficio/vigencia';
    protected $includeJs = [
        '/recursoshumanos/javascripts/beneficio/vigencia.js'
    ];
    protected $exibirBotaoEditar = false;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'vigencia',
                'doctrine_orm_datetime',
                [
                    'label' => 'Vigencia',
                    'field_type' => 'sonata_type_datetime_picker',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy'
                    ]
                ]
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
                        'delete' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'],
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
                'vigencia',
                'date',
                [
                    'label' => 'Vigencia'
                ]
            )
            ->add(
                'tipoTrans',
                'trans',
                [
                    'label' => 'label.tipo'
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
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $normaEm = $this->modelManager->getEntityManager('CoreBundle:Normas\Norma');
        $normaModel = new Model\Normas\NormaModel($normaEm);
        $normas = $normaModel->getNormasPorExercicio($this->getExercicio());
        
        $fieldOptions = [];
        
        $fieldOptions['fkNormasNorma'] = [
            'class' => 'CoreBundle:Normas\Norma',
            'query_builder' => $normas,
            'choice_label' => function ($norma) {
                $return = $norma->getFkNormasTipoNorma()->getNomTipoNorma() . ' - ' . $norma->getNomNorma();

                return $return;
            },
            'label' => 'label.faixaDesconto.fkNormasNorma',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];
        
        $fieldOptions['vigencia'] = [
            'label' => 'Vigencia',
            'dp_default_date' => (new \DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
        ];
        
        $fieldOptions['tipo'] = [
            'choices' => [
                'label.valeTransporte' => 'v',
                'label.auxilioRefeicao' => 'a'
            ],
            'expanded' => true,
            'multiple' => false,
            'label' => 'label.tipo',
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata'
            ]
        ];
        
        $fieldOptions['fkBeneficioFaixaDescontos'] = [
            'label' => false,
        ];
        
        $formMapper
            ->with("label.faixaDesconto.dadosFaixa")
                ->add(
                    'fkNormasNorma',
                    'entity',
                    $fieldOptions['fkNormasNorma']
                )
                ->add(
                    'vigencia',
                    'datepkpicker',
                    $fieldOptions['vigencia']
                )
                ->add(
                    'tipo',
                    'choice',
                    $fieldOptions['tipo']
                )
            ->end()
            ->with("label.faixaDesconto.faixadesconto")
                ->add(
                    'fkBeneficioFaixaDescontos',
                    'sonata_type_collection',
                    $fieldOptions['fkBeneficioFaixaDescontos'],
                    [
                        'edit' => 'inline',
                        'inline' => 'table',
                        'delete' => true,
                    ]
                )
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
            ->with("label.faixaDesconto.dadosFaixa")
                ->add(
                    'fkNormasNorma.fkNormasTipoNorma',
                    'string',
                    [
                        'label' => 'label.orgao.codTipoNorma'
                    ]
                )
                ->add(
                    'fkNormasNorma.nomNorma',
                    null,
                    [
                        'label' => 'label.orgao.codNorma'
                    ]
                )
                ->add(
                    'vigencia'
                )
                ->add(
                    'tipoTrans',
                    'trans',
                    [
                        'label' => 'label.tipo'
                    ]
                )
                ->add(
                    'faixas',
                    'string',
                    [
                        'label' => 'label.faixaDesconto.faixasCadastradas',
                        'template' => 'RecursosHumanosBundle:Beneficio/Vigencia:list.html.twig',
                    ]
                )
            ->end()
        ;
    }
    
    /**
     * Remonta o relacionamento
     * @param  object $object
     */
    public function saveRelationships($object)
    {
        $this->checkSelectedDeleteInListCollecion(
            $object,
            'fkBeneficioFaixaDescontos',
            'setFkBeneficioVigencia'
        );
    }
    
    /**
     * Prepara o objeto a ser gravado
     * @param  object $object
     */
    public function prePersist($object)
    {
        foreach ($object->getFkBeneficioFaixaDescontos() as $nivelPadraoNivel) {
            $object->removeFkBeneficioFaixaDescontos($nivelPadraoNivel);
        }
        
        $this->saveRelationships($object);
    }
    
    public function postPersist($object)
    {
        $entityManager = $this->getConfigurationPool()
        ->getContainer()
        ->get('doctrine')
        ->getManager();
        
        $faixaDescontoForms = $this->getForm()->get('fkBeneficioFaixaDescontos');
        
        foreach ($faixaDescontoForms as $faixaDescontoForm) {
            $codFaixa = (new \Urbem\CoreBundle\Model\Beneficio\FaixaDescontoModel($entityManager))
            ->getUltimaFaixaDesconto($object->getCodVigencia());
            
            /** FaixaDesconto @faixasDesconto **/
            $faixasDesconto = $faixaDescontoForm->getData();
            $faixasDesconto->setCodFaixa($codFaixa);
            $faixasDesconto->setFkBeneficioVigencia($object);
            $entityManager->persist($faixasDesconto);
            $entityManager->flush();
        }
    }
    
    public function preUpdate($object)
    {
        $this->saveRelationships($object);
    }
}
