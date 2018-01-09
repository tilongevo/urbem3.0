<?php

namespace Urbem\RecursosHumanosBundle\Form\Informacoes;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfiguracaoBanparaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descricao')
            ->add('numOrgaoBanpara')
            ->add(
                'vigencia',
                DateType::class,
                [
                    "label" => "label.vigencia",
                    "error_bubbling" => true,
                    'widget' => 'single_text',
                    'html5' => false,
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ]
                ]
            )
            ->add(
                'codEmpresa',
                EntityType::class,
                [
                    'label' => 'label.empresa',
                    'class' => 'CoreBundle:Ima\ConfiguracaoBanparaEmpresa',
                    'choice_label' => 'codigo',
                    'error_bubbling' => false,
                    'placeholder' => 'label.selecione',
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
            'data_class' => 'Urbem\CoreBundle\Entity\Ima\ConfiguracaoBanpara'
        ));
    }
}
