<?php

namespace Urbem\RecursosHumanosBundle\Form\Ponto;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfiguracaoRelogioPontoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'configuracaoParametrosGerais',
                ConfiguracaoParametrosGeraisType::class,
                [
                    'data_class' => 'Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais',
                    'label' => false
                ]
            )
            ->add(
                'configuracaoHorasExtras2',
                ConfiguracaoHorasExtras2Type::class,
                [
                    'data_class' => 'Urbem\CoreBundle\Entity\Ponto\ConfiguracaoHorasExtras2',
                    'label' => false
                ]
            )
            ->add(
                'configuracaoBancoHoras',
                ConfiguracaoBancoHorasType::class,
                [
                    'data_class' => 'Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras',
                    'label' => false
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
            'data_class' => 'Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPonto'
        ));
    }
}
