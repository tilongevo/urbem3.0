<?php

namespace Urbem\TributarioBundle\Form\Economico\Elemento;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaixarType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldOptions = array();

        $fieldOptions['motivo'] = array(
            'label'         => 'label.economicoElemento.motivo',
            'mapped'        => false
        );

        $builder
            ->add('motivo', 'textarea', $fieldOptions['motivo'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
