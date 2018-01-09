<?php

namespace Urbem\RecursosHumanosBundle\Form\FolhaPagamento;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrevidenciaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'codRegimePrevidencia',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Folhapagamento\RegimePrevidencia',
                    'choice_label' => 'descricao',
                    'choice_value' => 'codRegimePrevidencia',
                    'placeholder' => 'Selecione'
                )
            )
            ->add(
                'codVinculo',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Folhapagamento\Vinculo',
                    'choice_label' => 'descricao',
                    'choice_value' => 'codVinculo',
                    'placeholder' => 'Selecione'
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
            'data_class' => 'Urbem\CoreBundle\Entity\Folhapagamento\Previdencia'
        ));
    }
}
