<?php

namespace Urbem\CoreBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PercentType extends Type\PercentType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'scale' => 0,
            'type' => 'fractional',
            'compound' => false,
            'attr' => array(
                'class' => 'percent '
            )
        ));

        $resolver->setAllowedValues('type', array(
            'fractional',
            'integer',
        ));

        $resolver->setAllowedTypes('scale', 'int');
    }
}
