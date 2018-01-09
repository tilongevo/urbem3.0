<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class DocumentoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao
 */
class DocumentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_documento';

    protected $baseRoutePattern = 'patrimonial/licitacao/documento';
    
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nomDocumento', null, ['label' => 'label.nomeDocumento'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('codDocumento', 'number', ['label' => 'label.codigo','row_align' => 'right'])
            ->add('nomDocumento', null, ['label' => 'label.nomeDocumento'])
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
        $formMapper
            ->add('nomDocumento', null, ['label' => 'label.nomeDocumento'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $showMapper
            ->add('codDocumento', null, ['label' => 'label.codigo'])
            ->add('nomDocumento', null, ['label' => 'label.nomeDocumento'])
        ;
    }
}
