<?php

namespace Urbem\RecursosHumanosBundle\Form\Beneficio;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class VigenciaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'vigencia',
                Type\DateType::class,
                [
                    'html5' => false,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                        'label' => 'label.faixadesconto.vigencia'
                    ]
                ]
            )
            ->add(
                'tipo',
                Type\ChoiceType::class,
                [
                    'choices' => [
                        'label.faixadesconto.valetransporte' => 'v',
                        'label.faixadesconto.auxiliorefeicao' => 'a',
                    ],
                    'label' => 'label.faixadesconto.tipo',
                    'expanded' => true,
                    'multiple' => false,
                ]
            )
            ->add(
                'codNorma',
                EntityType::class,
                [
                    'class' => 'CoreBundle:Normas\Norma',
                    'choice_label' => 'nomNorma',
                    'placeholder' => 'label.selecione',
                    'label' => 'label.faixadesconto.codNorma'
                ]
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Beneficio\Vigencia'
        ));
    }
}
