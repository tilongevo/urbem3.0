<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Helper;
use Urbem\CoreBundle\Model;

class CboAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_cbo';

    protected $baseRoutePattern = 'recursos-humanos/cbo';

    protected $model = Model\Pessoal\CboModel::class;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setBreadCrumb();

        $datagridMapper
            ->add('codigo', null, ['label' => 'label.cbo.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add(
                'dtInicial',
                'doctrine_orm_datetime',
                [
                    'field_type' => 'sonata_type_datetime_picker',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy',
                    ],
                    'label' => 'label.dtInicial'
                ]
            )
            ->add(
                'dtFinal',
                'doctrine_orm_datetime',
                [
                    'field_type' => 'sonata_type_datetime_picker',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy',
                    ],
                    'label' => 'label.dtFinal'
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
            ->add('codigo', null, ['label' => 'label.cbo.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add('dtInicial', null, ['label' => 'label.dtInicial'])
            ->add('dtFinal', null, ['label' => 'label.dtFinal'])
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
            ->add('codigo', null, ['label' => 'label.cbo.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add(
                'dtInicial',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.dtInicial'
                ]
            )
            ->add(
                'dtFinal',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.dtFinal',
                    'required' => false
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
            ->add('codigo', null, ['label' => 'label.cbo.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add('dtInicial', null, ['label' => 'label.dtInicial'])
            ->add('dtFinal', null, ['label' => 'label.dtFinal'])
        ;
    }
}
