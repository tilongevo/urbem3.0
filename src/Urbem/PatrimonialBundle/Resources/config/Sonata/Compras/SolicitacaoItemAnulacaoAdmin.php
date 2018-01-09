<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class SolicitacaoItemAnulacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_solicitacao_anulacao_item';
    protected $baseRoutePattern = 'patrimonial/compras/solicitacao/anulacao/item';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('codCentro')
            ->add('codItem')
            ->add('quantidade')
            ->add('vlTotal')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('codCentro')
            ->add('codItem')
            ->add('quantidade')
            ->add('vlTotal')
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
            ->add('id')
            ->add('codCentro')
            ->add('codItem')
            ->add('quantidade')
            ->add('vlTotal')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('codCentro')
            ->add('codItem')
            ->add('quantidade')
            ->add('vlTotal')
        ;
    }
}
