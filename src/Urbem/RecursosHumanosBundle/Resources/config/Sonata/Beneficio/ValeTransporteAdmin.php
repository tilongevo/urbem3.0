<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Beneficio;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Helper\DatePK;
use Sonata\CoreBundle\Validator\ErrorElement;

class ValeTransporteAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_beneficio_valetransporte';
    protected $baseRoutePattern = 'recursos-humanos/beneficio/vale-transporte';
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'codValeTransporte'
    ];

    protected $includeJs = [
        'recursoshumanos/javascripts/beneficio/valetransporte/valetransporte.js',
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('consultar_municipio_uf', 'consultar-municipio-uf/' . $this->getRouterIdParameter())
            ->add('faixa_desconto_salarial', 'faixa-desconto-salarial')
            ->remove('show');
    }

    /**
    * @param DatagridMapper $datagridMapper
    */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkComprasFornecedor.fkSwCgm.nomCgm',
                null,
                [
                    'label' => 'label.valetransporte.fornecedorValeTransporteFornecedorNomcgm',
                ],
                'text'
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
                        'edit' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'],
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
                'fornecedorValeTransporteFornecedorNumcgm',
                null,
                [
                    'label' => 'label.codigo'
                ]
            )
            ->add(
                'fkComprasFornecedor.cgmFornecedor.fkSwCgm.nomCgm',
                null,
                [
                    'label' => 'label.valetransporte.fornecedor'
                ]
            )
            ->add(
                'origem'
            )
            ->add(
                'destino'
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
    * @param FormMapper $formMapper
    */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formOptions = [];

        $formOptions['fkComprasFornecedor'] = [
            'class' => 'CoreBundle:Compras\Fornecedor',
            'property' => 'nomCgm',
            'label' => 'label.valetransporte.fornecedorValeTransporteFornecedorNomcgm',
            'to_string_callback' => function (\Urbem\CoreBundle\Entity\Compras\Fornecedor $fornecedor, $property) {
                return strtoupper($fornecedor->getFkSwCgm()->getNumcgm() . ' - ' . $fornecedor->getFkSwCgm()->getNomCgm());
            },
            'container_css_class' => 'select2-v4-parameters ',
        ];

        $formOptions['fkBeneficioItinerario'] = [
            'label' => false,
            'required' => true,
        ];

        $formOptions['valor'] = [
            'label' => 'label.valetransporte.valor',
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money ',
            ],
            'mapped' => false,
        ];

        $formOptions['inicioVigencia'] = [
            'label' => 'label.valetransporte.inicioVigencia',
            'dp_default_date' => (new \DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'mapped' => false,
        ];

        if ($this->id($this->getSubject())) {
            $formOptions['fkComprasFornecedor']['disabled'] = true;
        }

        $formMapper
            ->with('label.valetransporte.codValeTransporte')
                ->add(
                    'fkComprasFornecedor',
                    'sonata_type_model_autocomplete',
                    $formOptions['fkComprasFornecedor'],
                    [
                        'admin_code' => 'core.admin.filter.fornecedor'
                    ]
                )
            ->end()
            ->with('label.valetransporte.itinerarioCodItinerario')
                ->add(
                    'fkBeneficioItinerario',
                    'sonata_type_admin',
                    $formOptions['fkBeneficioItinerario'],
                    [
                        'edit' => 'inline',
                        'inline' => 'table',
                        'admin_code' => 'recursos_humanos.admin.itinerario'
                    ]
                )
            ->end()
            ->with('label.valetransporte.custoCodCusto')
                ->add(
                    'valor',
                    'money',
                    $formOptions['valor']
                )
                ->add(
                    'inicioVigencia',
                    'datepkpicker',
                    $formOptions['inicioVigencia']
                )
            ->end()
        ;

        if ($this->id($this->getSubject())) {
            $formMapper
            ->with('label.valetransporte.variacoesCustoUnitario')
                ->add(
                    'variacoesCustoUnitario',
                    'customField',
                    [
                        'label' => false,
                        'mapped' => false,
                        'template' => 'RecursosHumanosBundle::Sonata/Beneficio/ValeTransporte/variacoesCustoUnitario.html.twig',
                        'data' => []
                    ]
                )
            ->end()
            ;
        }

        $faixasDesconto = $entityManager
            ->getRepository('CoreBundle:Beneficio\FaixaDesconto')
            ->findBy([], null, 10);

        $formMapper
        ->with('label.valetransporte.faixadescontosalarial')
            ->add(
                'faixadesconto',
                'customField',
                array(
                    'label' => false,
                    'mapped' => false,
                    'template' => 'RecursosHumanosBundle::Sonata/Beneficio/ValeTransporte/faixadesconto.html.twig',
                    'data' => [
                        'faixas' => $faixasDesconto
                    ]
                )
            )
        ->end()
        ;
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        if (count($object->getFkBeneficioCustos()->toArray()) > 0) {
            if ($this->getForm()->get('inicioVigencia')->getData() <= $object->getFkBeneficioCustos()->last()->getInicioVigencia()) {
                $error = $this->trans(
                    'label.valetransporte.error.inicioVigencia',
                    [
                        '%ultimaVigencia%' => $object->getFkBeneficioCustos()->last()->getInicioVigencia()->format("d/m/Y")
                    ]
                );
                $errorElement->with('inicioVigencia')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        $object->setFkBeneficioItinerario(null);
    }

    /**
     * {@inheritdoc}
     */
    public function postPersist($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $form = (object) $this->getFormPost();

        (new \Urbem\CoreBundle\Model\Beneficio\ValeTransporteModel($entityManager))
        ->customPostPersist($object, $form, $this->getForm());

        (new \Urbem\CoreBundle\Model\Beneficio\ValeTransporteModel($entityManager))
        ->saveRelationship($object, $this->getForm());
    }

    /**
     * {@inheritdoc}
     */
    public function postUpdate($object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        (new \Urbem\CoreBundle\Model\Beneficio\ValeTransporteModel($entityManager))
        ->saveRelationship($object, $this->getForm());
    }
}
