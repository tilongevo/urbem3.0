<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CidAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_cid';

    protected $baseRoutePattern = 'recursos-humanos/cid';

    protected $model = null;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('sigla', null, ['label' => 'label.sigla'])
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('sigla', null, ['label' => 'label.sigla'])
            ->add('descricao', null, ['label' => 'label.descricao'])
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
            ->add('sigla', null, ['label' => 'label.sigla'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add(
                'fkPessoalTipoDeficiencia',
                'entity',
                [
                    'label' => 'Tipo Deficiência',
                    'class' => 'CoreBundle:Pessoal\TipoDeficiencia',
                    'choice_label' => 'descricao',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
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
            ->add('sigla', null, ['label' => 'label.sigla'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add(
                'fkPessoalTipoDeficiencia.descricao',
                'entity',
                [
                    'label' => 'Tipo Deficiência',
                ]
            );
    }
}
