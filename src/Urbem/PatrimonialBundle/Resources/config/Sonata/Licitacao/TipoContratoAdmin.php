<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TipoContratoAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_patrimonial_licitacao_tipo_contrato';

    protected $baseRoutePattern = 'patrimonial/licitacao/tipo-contrato';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper

            ->add('sigla')
            ->add('descricao', null, ['label' => 'label.patrimonial.compras.contrato.descricao'])
            ->add('tipoTc', null, ['label' => 'label.patrimonial.compras.contrato.tipoTc'])

        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codTipo', null, ['label' => 'label.patrimonial.compras.contrato.codTipo'])
            ->add('sigla')
            ->add('descricao', null, ['label' => 'label.patrimonial.compras.contrato.descricao'])
            ->add('tipoTc', null, ['label' => 'label.patrimonial.compras.contrato.tipoTc'])
            ->add('ativo')

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
            ->add('sigla')
            ->add('descricao', null, ['label' => 'label.patrimonial.compras.contrato.descricao'])
            ->add('tipoTc', null, ['label' => 'label.patrimonial.compras.contrato.tipoTc'])
            ->add('ativo')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $showMapper
            ->add('codTipo', null, ['label' => 'label.patrimonial.compras.contrato.codTipo'])
            ->add('sigla')
            ->add('descricao', null, ['label' => 'label.patrimonial.compras.contrato.descricao'])
            ->add('tipoTc', null, ['label' => 'label.patrimonial.compras.contrato.tipoTc'])
            ->add('ativo')
        ;
    }
}
