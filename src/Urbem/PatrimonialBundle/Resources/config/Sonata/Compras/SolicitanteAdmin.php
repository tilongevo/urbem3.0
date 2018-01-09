<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SolicitanteAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_patrimonial_compras_solicitante';
    protected $baseRoutePattern = 'patrimonial/compras/solicitante';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $fieldOptions['swcgm'] = [
            'label' => 'Solicitante',
            'property' => 'nomCgm',
            'to_string_callback' => function (SwCgm $swcgm, $property) {
                return $swcgm->getNumcgm() . ' - ' . $swcgm->getNomCgm();
            },
            'placeholder' => 'Selecione'
        ];

        $datagridMapper
            ->add('fkSwCgm',
                'doctrine_orm_model_autocomplete',
                ['label' => 'Solicitante'],
                'sonata_type_model_autocomplete',
                $fieldOptions['swcgm'],
                ['admin_code' => 'core.admin.filter.sw_cgm']
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
            ->add('fkSwCgm', null, [
                'label' => 'Solicitante',
                'associated_property' => 'nomCgm'])
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

        $fieldOptions['swcgm'] = [
            'label' => 'Solicitante',
            'property' => 'nomCgm',
            'to_string_callback' => function (SwCgm $swcgm, $property) {
                return $swcgm->getNumcgm() . ' - ' . $swcgm->getNomCgm();
            },
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['ativo'] = [
            'attr' => array(
                'checked' => 'checked'
            )
        ];

        $route = $this->getRequest()->get('_sonata_name');
        if ($this->baseRouteName . "_edit" == $route) {
            $fieldOptions['swcgm']['disabled'] = true;
        }

        $formMapper
            ->add(
                'fkSwCgm',
                'sonata_type_model_autocomplete',
                $fieldOptions['swcgm'],
                ['admin_code' => 'core.admin.filter.sw_cgm']
            )
            ->add('ativo', null, $fieldOptions['ativo'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {


        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $showMapper
            ->add('fkSwCgm', null, [
                'label' => 'Solicitante',
                'associated_property' => 'nomCgm'])
            ->add('ativo')
        ;
    }
}
