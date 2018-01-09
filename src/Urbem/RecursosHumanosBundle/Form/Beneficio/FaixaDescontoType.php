<?php

namespace Urbem\RecursosHumanosBundle\Form\Beneficio;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class FaixaDescontoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'vlInicial',
                Type\NumberType::class,
                [
                    'label' => 'label.faixadesconto.vlInicial',
                ]
            )
            ->add(
                'vlFinal',
                Type\NumberType::class,
                [
                    'label' => 'label.faixadesconto.vlFinal',
                ]
            )
            ->add(
                'percentualDesconto',
                Type\NumberType::class,
                [
                    'label' => 'label.faixadesconto.percentualDesconto',
                ]
            )
            ->add(
                'codVigencia',
                VigenciaType::class,
                [
                    'label' => false,
                    'data_class' => 'Urbem\CoreBundle\Entity\Beneficio\Vigencia'
                ]
            )
            // ->add('codVigencia')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Beneficio\FaixaDesconto'
        ));
    }
}
