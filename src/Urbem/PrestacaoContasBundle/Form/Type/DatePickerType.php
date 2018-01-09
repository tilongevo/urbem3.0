<?php

namespace Urbem\PrestacaoContasBundle\Form\Type;

use Sonata\CoreBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DatePickerType
 * @package Urbem\PrestacaoContasBundle\Form\Type
 */
class DatePickerType extends Type\DatePickerType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
   public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array_merge($this->getCommonDefaults(), [
            'dp_pick_time' => false,
            'html5' => false,
            'required' => true,
            'format' => 'dd/MM/yyyy',
            'moment_format' =>'DD/MM/YYYY',
            'label', false
        ]));
    }
}