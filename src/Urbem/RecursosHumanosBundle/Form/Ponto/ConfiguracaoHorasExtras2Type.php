<?php

namespace Urbem\RecursosHumanosBundle\Form\Ponto;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfiguracaoHorasExtras2Type extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'anteriorPeriodo1',
                Type\CheckboxType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.anteriorPeriodo1',
                    'error_bubbling' => false,
                ]
            )
            ->add(
                'entrePeriodo12',
                Type\CheckboxType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.entrePeriodo12',
                    'error_bubbling' => false,
                ]
            )
            ->add(
                'posteriorPeriodo2',
                Type\CheckboxType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.posteriorPeriodo2',
                    'error_bubbling' => false,
                ]
            )
            ->add(
                'autorizacao',
                Type\CheckboxType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.autorizacao',
                    'error_bubbling' => false,
                ]
            )
            ->add(
                'atrasos',
                Type\CheckboxType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.atrasos',
                    'error_bubbling' => false,
                ]
            )
            ->add(
                'faltas',
                Type\CheckboxType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.faltas',
                    'error_bubbling' => false,
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
            'data_class' => 'Urbem\CoreBundle\Entity\Ponto\ConfiguracaoHorasExtras2'
        ));
    }
}
