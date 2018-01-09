<?php

namespace Urbem\TributarioBundle\Form\Arrecadacao\Desoneracao;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RevogarType
 * @package Urbem\TributarioBundle\Form\Arrecadacao\Desoneracao
 */
class RevogarType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'dataRevogacao',
                TextType::class,
                [
                    'label' => 'label.revogarDesoneracao.dataRevogacao',
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
