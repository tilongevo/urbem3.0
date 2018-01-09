<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Frota\Motorista;
use Urbem\CoreBundle\Entity\Frota\MotoristaVeiculo;
use Urbem\CoreBundle\Entity\Frota\Veiculo;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Helper;
use Urbem\CoreBundle\Model;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\MotoristaModel;

class MotoristaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_motorista';

    protected $baseRoutePattern = 'patrimonial/frota/motorista';

    protected $model = Model\Patrimonial\Frota\MotoristaModel::class;

    protected $includeJs = [
        '/patrimonial/javascripts/frota/motorista.js',
    ];

    /**
     * @param Motorista $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect($container->get('router')->generate(
                'urbem_patrimonial_frota_motorista_create'
            ));
        }
    }

    /**
     * @param Motorista $motorista
     * @param $form
     */
    public function saveRelationships($motorista, $form)
    {
        $em = $this->getDoctrine();
        // Setar a entity swCGM do cgmMotorista
        if ($this->getAdminRequestId()) {
            $cgmMotorista = explode(' - ', $motorista->getCgmMotorista());
            $cgmMotorista = $cgmMotorista[0];
        } else {
            $cgmMotorista = $motorista->getCgmMotorista();
        }

        $swCgm = $em->getRepository('CoreBundle:SwCgm')->findOneByNumcgm($cgmMotorista);

        $motorista->setFkSwCgm($swCgm);

        // Atualizar cgmMotorista
        $em->getRepository(Motorista::class)
            ->updateCgmMotorista($cgmMotorista, $form->get('numCnh')->getData(), $form->get('dtValidadeCnh')->getData()->format('Y-m-d'), $form->get('categoriaCnh')->getData()->getCodCategoria());

        $veiculos = $this->getForm()->get("codVeiculo")->getData();

        foreach ($veiculos as $veiculo) {
            /** @var Veiculo $veiculo */

            $motoristaVeiculo = new MotoristaVeiculo();

            $motoristaVeiculo->setFkFrotaMotorista($motorista);
            $motoristaVeiculo->setFkFrotaVeiculo($veiculo);
            $motoristaVeiculo->setPadrao(false);

            $em->persist($motoristaVeiculo);
        }
    }

    /**
     * @param Motorista $object
     */
    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $motoristaModel = new MotoristaModel($em);

            // Remove CodVeiculo
            $motoristaModel->removeMotoristaVeiculo($object);

            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_EDIT_DATA);
            $this->forceRedirect($container->get('router')->generate(
                'urbem_patrimonial_frota_motorista_edit',
                ['id' => $this->getObjectKey($object)]
            ));
        }
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add(
            'consultar_dados_cgm_motorista',
            'consultar-dados-cgm-motorista/' . $this->getRouterIdParameter()
        );

        $collection->add(
            'get_veiculos_cnh_categoria',
            'get-veiculos-cnh-categoria/' . $this->getRouterIdParameter()
        );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCgm');
        $swModel = new SwCgmModel($em);

        $swCgm = $swModel->recuperaRelacionamentoVinculado('sw_cgm_pessoa_fisica', 'numcgm', false, false);

        $arrMotoristas = array();
        foreach ($swCgm as $cgm) {
            $arrMotoristas[$cgm['numcgm'] . ' - ' . $cgm['nom_cgm']] = $cgm['numcgm'];
        }

        $fieldOptions['cgmMotorista'] = [
            'choices' => $arrMotoristas,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $datagridMapper
            ->add(
                'cgmMotorista',
                'doctrine_orm_number',
                [
                    'label' => 'label.motorista.cgmMotorista',
                ],
                'choice',
                $fieldOptions['cgmMotorista']
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
                'fkSwCgm',
                'entity',
                [
                    'class' => 'CoreBundle:SwCgm',
                    'associated_property' => function (SwCgm $cgm) {
                        return $cgm;
                    },
                    'label' => 'Motorista'
                ]
            )
            ->add(
                'ativo',
                'boolean',
                [
                    'label' => 'Ativo',
                    'sortable' => false
                ]
            );

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwCgm');
        $swModel = new SwCgmModel($em);

        $filtroVinculo = '
            AND NOT EXISTS (
                SELECT 1
                FROM frota.motorista
                WHERE motorista.cgm_motorista = cgm.numcgm
            )';

        $swCgm = $swModel->recuperaRelacionamentoVinculado('sw_cgm_pessoa_fisica', 'numcgm', $filtroVinculo, false);

        $arrMotoristas = array();
        foreach ($swCgm as $cgm) {
            $arrMotoristas[$cgm['numcgm'] . ' - ' . $cgm['nom_cgm']] = $cgm['numcgm'];
        }

        // Dados Motorista
        $fieldOptions['numCnh'] = [
            'label' => 'label.motorista.numCnh',
            'mapped' => false,
        ];
        $fieldOptions['dtValidadeCnh'] = [
            'label' => 'label.motorista.dtValidadeCnh',
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
        ];
        $fieldOptions['categoriaCnh'] = [
            'class' => 'CoreBundle:SwCategoriaHabilitacao',
            'choice_label' => 'nomCategoria',
            'label' => 'label.motorista.categoriaCnh',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'mapped' => false,
            'placeholder' => 'label.selecione'
        ];
        $fieldOptions['ativo'] = [
            'required' => false
        ];

        //Auth Veiculo
        $fieldOptions['codVeiculo'] = [
            'class' => 'CoreBundle:Frota\Veiculo',
            'choice_label' => function (Veiculo $codVeiculo) {
                return $codVeiculo;
            },
            'label' => 'label.motorista.codVeiculo',
            'multiple' => true,
            'mapped' => false,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
        ];

        if ($this->id($this->getSubject())) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            /** @var Motorista $motorista */
            $motorista = $this->getSubject();

            // Processa Motorista
            $fieldOptions['cgmMotorista'] = [
                'label' => 'label.motorista.cgmMotorista',
                'mapped' => false,
                'attr' => array(
                    'readonly' => true,
                    'disabled' => true
                ),
                'data' => $motorista->getFkSwCgm()->getNumcgm() . ' - ' . $motorista->getFkSwCgm()->getNomCgm()
            ];

            // Processa Dados Motorista
            /** @var SwCgmPessoaFisica $swCgmPF */
            $swCgmPF = $motorista->getFkSwCgm()->getFkSwCgmPessoaFisica();
            $fieldOptions['numCnh']['data'] = $swCgmPF->getNumCnh();
            $fieldOptions['dtValidadeCnh']['data'] = $swCgmPF->getDtValidadeCnh();
            $fieldOptions['categoriaCnh']['data'] = $swCgmPF->getFkSwCategoriaHabilitacao();

            // Processa MotoristaVeiculo
            $veiculos = [];
            /** @var MotoristaVeiculo $motoristaVeiculo */
            foreach ($motorista->getFkFrotaMotoristaVeiculos() as $motoristaVeiculo) {
                $veiculos[] = $motoristaVeiculo->getFkFrotaVeiculo();
            }
            if (count($veiculos) > 0) {
                $fieldOptions['codVeiculo']['data'] = $veiculos;
            }
        } else {
            $fieldOptions['cgmMotorista'] = [
                'choices' => $arrMotoristas,
                'label' => 'label.motorista.cgmMotorista',
                'attr' => array(
                    'class' => 'select2-parameters '
                ),
                'placeholder' => 'label.selecione'
            ];
            $fieldOptions['ativo']['data'] = true;
        }

        $formMapper
            ->with('label.motorista.dadosMotorista')
            ->add(
                'cgmMotorista',
                ($this->id($this->getSubject()) ? 'text' : 'choice'),
                $fieldOptions['cgmMotorista']
            )
            ->add(
                'numCnh',
                'text',
                $fieldOptions['numCnh']
            )
            ->add(
                'dtValidadeCnh',
                'sonata_type_date_picker',
                $fieldOptions['dtValidadeCnh']
            )
            ->add(
                'categoriaCnh',
                'entity',
                $fieldOptions['categoriaCnh']
            )
            ->add(
                'ativo',
                'checkbox',
                $fieldOptions['ativo']
            )
            ->end()
            ->with('label.motorista.authVeiculo')
            ->add(
                'codVeiculo',
                'entity',
                $fieldOptions['codVeiculo']
            )
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        /** @var Motorista $motorista */
        $motorista = $this->getSubject();

        // Dados Motorista
        $fieldOptions['numCnh'] = [
            'label' => 'label.motorista.numCnh',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['dtValidadeCnh'] = [
            'label' => 'label.motorista.dtValidadeCnh',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        $fieldOptions['categoriaCnh'] = [
            'label' => 'label.motorista.categoriaCnh',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];

        $fieldOptions['fkFrotaMotoristaVeiculos'] = [
            'label' => 'label.motorista.codVeiculo',
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig'
        ];
        // Processa Dados Motorista
        $swCgmPF = $motorista->getFkSwCgm()->getFkSwCgmPessoaFisica();
        $fieldOptions['numCnh']['data'] = $swCgmPF->getNumCnh();
        $fieldOptions['dtValidadeCnh']['data'] = $swCgmPF->getDtValidadeCnh()->format('d/m/Y');
        $fieldOptions['categoriaCnh']['data'] = $swCgmPF->getFkSwCategoriaHabilitacao();


        $motoristaVeiculos = $this->getSubject()->getFkFrotaMotoristaVeiculos();
        $veiculos = [];
        /** @var MotoristaVeiculo $motoristaVeiculo */
        foreach ($motoristaVeiculos as $motoristaVeiculo) {
            $veiculos = $motoristaVeiculo->getFkFrotaVeiculo()->getCodVeiculo();
        }

        $fieldOptions['fkFrotaVeiculos']['data'] = $veiculos;
        $this->data['fkFrotaVeiculos'] = $this->getSubject()->getFkFrotaMotoristaVeiculos();
        $showMapper
            ->with('label.motorista.dadosMotorista')
            ->add(
                'cgmMotorista',
                'entity',
                [
                    'class' => 'CoreBundle:SwCgm',
                    'label' => 'label.motorista.cgmMotorista'
                ]
            )
            ->add(
                'numCnh',
                null,
                $fieldOptions['numCnh']
            )
            ->add(
                'dtValidadeCnh',
                null,
                $fieldOptions['dtValidadeCnh']
            )
            ->add(
                'categoriaCnh',
                null,
                $fieldOptions['categoriaCnh']
            )
            ->add(
                'ativo',
                'boolean',
                [
                    'label' => 'Ativo',
                    'sortable' => false
                ]
            )
            ->add(
                'fkFrotaMotoristaVeiculos.fkFrotaVeiculo',
                'entity',
                [
                    'label' => 'label.motorista.codVeiculo',
                    'template' => 'PatrimonialBundle:Frota\Veiculo:list_custom_motorista_veiculo.html.twig',
                    'mapped' => false
                ]
            )
            ->end();
    }
}
