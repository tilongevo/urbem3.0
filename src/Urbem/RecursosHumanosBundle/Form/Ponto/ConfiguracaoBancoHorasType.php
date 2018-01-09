<?php

namespace Urbem\RecursosHumanosBundle\Form\Ponto;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfiguracaoBancoHorasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'ativarBanco',
                Type\CheckboxType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.ativarBanco',
                    'error_bubbling' => false,
                ]
            )
            ->add(
                'contagemLimites',
                Type\TextType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.contagemLimites',
                    'error_bubbling' => false,
                ]
            )
            ->add(
                'horasExcesso',
                Type\TextType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.horasExcesso',
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
            'data_class' => 'Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras'
        ));
    }
}
