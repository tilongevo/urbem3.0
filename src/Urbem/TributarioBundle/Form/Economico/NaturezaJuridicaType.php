<?php

namespace Urbem\TributarioBundle\Form\Economico;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

/**
 * Class NaturezaJuridicaType
 * @package Urbem\TributarioBundle\Form\Economico
 */
class NaturezaJuridicaType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldOptions = array();
        $fieldOptions['motivo'] = [
            'label' => 'Motivo'
        ];
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
