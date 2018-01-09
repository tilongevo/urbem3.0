<?php

namespace Urbem\RecursosHumanosBundle\Form\FolhaPagamento;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PadraoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $norma = $options['norma'];
        $builder
            ->add(
                'descricao',
                null,
                [
                'required' => true,
                    'label' => 'Descrição'
                ]
            )
            ->add('horasMensais', null, ['required' => true])
            ->add('horasSemanais', null, ['required' => true])
            ->add('codPadraoPadrao', PadraoPadraoType::class, [
                'label' => false,
                'data_class' => 'Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao',
                'norma' => $norma
            ])
            ->add(
                'codNivelPadraoNivel',
                CollectionType::class,
                array(
                    'entry_type' => NivelPadraoNivelType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'by_reference' => false,
                    'label' => false,
                    'prototype_name' => '__name__'
                )
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Folhapagamento\Padrao'
        ));
        $resolver->setRequired(array(
            'norma'
        ));
    }
}
