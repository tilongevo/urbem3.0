<?php

namespace Urbem\CoreBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CurrencyType extends Type\MoneyType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'scale' => 2,
            'grouping' => false,
            'divisor' => 1,
            'compound' => false,
            'attr' => array(
                'class' => 'money vl-lancamento '
            )
        ));
        $resolver->setDefault('currency', 'BRL');
        $resolver->setAllowedTypes('scale', 'int');
    }
}
