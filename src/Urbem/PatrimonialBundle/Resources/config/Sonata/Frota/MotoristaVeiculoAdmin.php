<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Frota;

class MotoristaVeiculoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_motorista_veiculo';

    protected $baseRoutePattern = 'patrimonial/frota/motorista-veiculo';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codMotoristaVeiculo')
            ->add('padrao')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codMotoristaVeiculo')
            ->add('padrao')
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

        $fieldOptions['codVeiculo'] = [
            'class' => Frota\Veiculo::class,
            'choice_label' => function ($codVeiculo) {
                return $codVeiculo->getCodVeiculo().' - '.$codVeiculo->getPlaca().' - '.$codVeiculo->getCodMarca()->getNomMarca().' - '.$codVeiculo->getCodModelo()->getNomModelo();
            },
            'label' => 'label.motoristaVeiculo.codVeiculo',
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $formMapper
            ->add(
                'codVeiculo',
                'entity',
                $fieldOptions['codVeiculo']
            )
            ->add(
                'padrao',
                'checkbox',
                [
                    'label' => 'label.motoristaVeiculo.padrao',
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
            ->add('codMotoristaVeiculo')
            ->add('padrao')
        ;
    }
}
