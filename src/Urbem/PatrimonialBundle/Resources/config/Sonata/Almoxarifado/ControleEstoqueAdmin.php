<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class ControleEstoqueAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_controle_estoque';

    protected $baseRoutePattern = 'patrimonial/almoxarifado/controle-estoque';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        # Estoque
        $fieldOptions['estoqueMinimo'] = [
            'label' => 'label.catalogoItem.estoqueMinimo',
            'required' => false,
            'attr' => array(
                'class' => 'quantity '
            )
        ];
        $fieldOptions['pontoPedido'] = [
            'label' => 'label.catalogoItem.pontoPedido',
            'required' => false,
            'attr' => array(
                'class' => 'quantity '
            )
        ];
        $fieldOptions['estoqueMaximo'] = [
            'label' => 'label.catalogoItem.estoqueMaximo',
            'required' => false,
            'attr' => array(
                'class' => 'quantity '
            )
        ];

        $formMapper
            ->add(
                'estoqueMinimo',
                'number',
                $fieldOptions['estoqueMinimo']
            )
            ->add(
                'pontoPedido',
                'number',
                $fieldOptions['pontoPedido']
            )
            ->add(
                'estoqueMaximo',
                'number',
                $fieldOptions['estoqueMaximo']
            )
        ;
    }
}
