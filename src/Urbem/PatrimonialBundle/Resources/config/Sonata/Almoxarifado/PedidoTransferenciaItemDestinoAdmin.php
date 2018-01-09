<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class PedidoTransferenciaItemDestinoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_pedido_transferencia_item_destino';

    protected $baseRoutePattern = 'patrimonial/almoxarifado/pedido-transferencia-item-destino';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['codCentroDestino'] = [
            'class' => 'CoreBundle:Almoxarifado\CentroCusto',
            'choice_label' => function ($codCentroDestino) {
                return $codCentroDestino->getCodCentro().' - '.$codCentroDestino->getDescricao();
            },
            'label' => 'label.pedidoTransferencia.codCentroDestino',
            'attr' => array(
                'class' => 'select2-parameters ',
                'disabled' => true
            ),
            'placeholder' => 'Selecione o Item'
        ];

        $formMapper
            ->add(
                'codCentroDestino',
                'entity',
                $fieldOptions['codCentroDestino']
            )
        ;
    }
}
