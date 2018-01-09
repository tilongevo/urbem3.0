<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Imobiliario\DocumentoNatureza;

class DocumentoNaturezaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_documento_natureza';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/documento-natureza';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codDocumento')
            ->add('codNatureza')
            ->add('nomDocumento')
            ->add('cadastro')
            ->add('transferencia')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codDocumento')
            ->add('codNatureza')
            ->add('nomDocumento')
            ->add('cadastro')
            ->add('transferencia')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('codNatureza')
            ->add('nomDocumento')
            ->add('cadastro')
            ->add('transferencia')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codDocumento')
            ->add('codNatureza')
            ->add('nomDocumento')
            ->add('cadastro')
            ->add('transferencia')
        ;
    }
}
