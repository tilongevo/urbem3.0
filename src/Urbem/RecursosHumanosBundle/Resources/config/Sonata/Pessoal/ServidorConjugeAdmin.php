<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Helper\UploadHelper;

class ServidorConjugeAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_servidor_conjuge';

    protected $baseRoutePattern = 'recursos-humanos/pessoal/servidor-conjuge';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('timestamp')
            ->add('boExcluido');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('timestamp')
            ->add('boExcluido')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->modelManager->getEntityManager('CoreBundle:SwCgm');

        $formMapper
            ->add(
                'fkSwCgmPessoaFisica',
                'autocomplete',
                [
                    'label' => 'label.servidor.codServidor',
                    'class' => 'CoreBundle:SwCgmPessoaFisica',
                    'route' => ['name' => 'filtra_sw_cgm_pessoa_fisica'],
                    'attr' => [
                        'class' => 'select2-parameters'
                    ],
                ],
                [
                    'admin_code' => 'administrativo.admin.sw_cgm_pessoa_fisica',
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('timestamp')
            ->add('boExcluido');
    }
}
