<?php

namespace Urbem\RecursosHumanosBundle\Form\FolhaPagamento;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class FgtsType extends AbstractType
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
                DateType::class,
                [
                    'html5' => false,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                        'required' => true
                    ],
                    'format' => 'dd/MM/yyyy',
                    'label' => 'Vigência'
                ]
            )
            ->add(
                'btnAddCategoria',
                ButtonType::class,
                [
                    'label' => 'Adicionar Categoria'
                ]
            )
            ->add(
                'codCategoria',
                CollectionType::class,
                array(
                    'entry_type' => FgtsCategoriaType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'by_reference' => false,
                    'label' => false,
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
            'data_class' => 'Urbem\CoreBundle\Entity\FolhaPagamento\Fgts'
        ));
    }
}
