<?php

namespace Urbem\CoreBundle\Form\Type;

use Sonata\CoreBundle\Form\Type\DatePickerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Form\Transform\DatePKTransform;

class DatePKPickerType extends DatePickerType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addModelTransformer(new DatePKTransform([
            'class' => $options['pk_class'],
            'force_hour' => $options['pk_force_hour'],
            'force_minute' => $options['pk_force_minute'],
            'force_second' => $options['pk_force_second'],
            'force_microsecond' => $options['pk_force_microsecond'],
            'force_timezone' => $options['pk_force_timezone'],
            'force_default' => $options['pk_force_default'],
        ]), true);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired(['pk_class']);

        $resolver->setDefaults([
            'pk_force_hour' => false,
            'pk_force_minute' => false,
            'pk_force_second' => false,
            'pk_force_microsecond' => false,
            'pk_force_timezone' => false,
            'pk_force_default' => false,
        ]);
    }
}
