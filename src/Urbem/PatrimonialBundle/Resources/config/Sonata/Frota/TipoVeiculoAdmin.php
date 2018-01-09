<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Frota\TipoVeiculo;
use Urbem\CoreBundle\Model\Patrimonial\Frota\TipoVeiculoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class TipoVeiculoAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_patrimonial_frota_tipo_veiculo';

    protected $baseRoutePattern = 'patrimonial/frota/tipo-veiculo';

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
                    'label' => 'label.codigo'
                ]
            )
            ->add(
                'nomTipo',
                null,
                [
                    'label' => 'label.descricao'
                ]
            )
            ->add(
                'placa',
                null,
                [
                    'label' => 'label.tipoVeiculo.exigePlaca'
                ]
            )
            ->add(
                'prefixo',
                null,
                [
                    'label' => 'label.tipoVeiculo.exigePrefixo'
                ]
            )
            ->add(
                'controlarHorasTrabalhadas',
                null,
                [
                    'label' => 'label.tipoVeiculo.controlarHorasTrabalhadas'
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
            ->add('codTipo', 'number', ['label' => 'label.tipoVeiculo.codigoDoTipo', 'sortable' => false])
            ->add('nomTipo', 'text', ['label' => 'label.tipoVeiculo.nomeDoTipo', 'sortable' => false])
            ->add('placa', 'boolean', ['label' => 'label.tipoVeiculo.placa', 'sortable' => false])
            ->add('prefixo', 'boolean', ['label' => 'label.tipoVeiculo.prefixo', 'sortable' => false])
            ->add('controlarHorasTrabalhadas', 'boolean', ['label' => 'label.tipoVeiculo.controlarHorasTrabalhadas', 'sortable' => false])
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
                'nomTipo',
                null,
                [
                    'label' => 'label.descricao'
                ]
            )
            ->add(
                'placa',
                null,
                [
                    'label' => 'label.tipoVeiculo.exigePlaca'
                ]
            )
            ->add(
                'prefixo',
                null,
                [
                    'label' => 'label.tipoVeiculo.exigePrefixo',
                    'attr' => ['display' => 'block']
                ]
            )
            ->add(
                'controlarHorasTrabalhadas',
                null,
                [
                    'label' => 'label.tipoVeiculo.controlarHorasTrabalhadas'
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
                'number',
                [
                    'label' => 'label.tipoVeiculo.codigoDoTipo',
                ]
            )
            ->add(
                'nomTipo',
                'text',
                [
                    'label' => 'label.tipoVeiculo.nomeDoTipo',
                ]
            )
            ->add(
                'placa',
                'boolean',
                [
                    'label' => 'label.tipoVeiculo.placa',
                ]
            )
            ->add(
                'prefixo',
                'boolean',
                [
                    'label' => 'label.tipoVeiculo.prefixo',
                ]
            )
            ->add(
                'controlarHorasTrabalhadas',
                'boolean',
                [
                    'label' => 'label.tipoVeiculo.controlarHorasTrabalhadas',
                ]
            )
        ;
    }
}
