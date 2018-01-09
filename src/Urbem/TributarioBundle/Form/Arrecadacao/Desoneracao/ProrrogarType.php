<?php

namespace Urbem\TributarioBundle\Form\Arrecadacao\Desoneracao;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProrrogarType
 * @package Urbem\TributarioBundle\Form\Arrecadacao\Desoneracao
 */
class ProrrogarType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'dataProrrogacao',
                TextType::class,
                [
                    'label' => 'label.prorrogarDesoneracao.dataProrrogacao',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ],
                ]
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
