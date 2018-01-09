<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class TipoBaixaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_patrimonio_tipo_baixa';

    protected $baseRoutePattern = 'patrimonial/patrimonio/tipo-baixa';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codTipo',
                null,
                [
                    'label' => 'label.tipoBaixa.codTipo'
                ]
            )
            ->add(
                'descricao',
                null,
                [
                    'label' => 'label.tipoBaixa.descricao'
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
            ->add('codTipo', 'number', ['label' => 'label.tipoBaixa.codTipo', 'sortable' => false])
            ->add('descricao', 'text', ['label' => 'label.tipoBaixa.descricao', 'sortable' => false])
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
            ->add(
                'descricao',
                null,
                [
                    'label' => 'label.tipoBaixa.descricao'
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add(
                'codTipo',
                null,
                [
                    'label' => 'label.tipoBaixa.codTipo'
                ]
            )
            ->add(
                'descricao',
                null,
                [
                    'label' => 'label.tipoBaixa.descricao'
                ]
            )
        ;
    }
}
