<?php

namespace Urbem\RecursosHumanosBundle\Form\Beneficio;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LayoutFornecedorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'cgmFornecedor',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Compras\Fornecedor',
                    'choice_label' => 'cgm_fornecedor',
                    'choice_value' => 'cgm_fornecedor',
                    'placeholder' => 'Selecione'
                )
            )
            ->add(
                'codLayout',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Beneficio\LayoutPlanoSaude',
                    'choice_label' => 'padrao',
                    'choice_value' => 'cod_layout',
                    'placeholder' => 'Selecione'
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Beneficio\LayoutFornecedor'
        ));
    }
}
