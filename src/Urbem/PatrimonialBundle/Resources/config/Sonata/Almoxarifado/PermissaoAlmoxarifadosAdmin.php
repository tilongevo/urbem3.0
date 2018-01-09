<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class PermissaoAlmoxarifadosAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class PermissaoAlmoxarifadosAdmin extends AbstractAdmin
{
    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $fieldOptions = [];
        $fieldOptions['fkAlmoxarifadoAlmoxarifado'] = [
            'attr' => ['class' => 'select2-parameters fkAlmoxarifadoAlmoxarifado-field '],
            'choice_label' => function (Almoxarifado\Almoxarifado $almoxarifado) {
                return strtoupper($almoxarifado->getFkSwCgm()->getNomCgm());
            },
            'label' => 'label.almoxarife.codAlmoxarifado'
        ];

        $fieldOptions['padrao']['label'] = 'label.almoxarife.padrao';
        $fieldOptions['padrao']['attr'] = ['class' => 'padrao-field '];

        $formMapper
            ->add('fkAlmoxarifadoAlmoxarifado', null, $fieldOptions['fkAlmoxarifadoAlmoxarifado'])
            ->add('padrao', null, $fieldOptions['padrao'])
        ;
    }
}
