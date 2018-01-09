<?php

namespace Urbem\RecursosHumanosBundle\Form\Informacoes;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfiguracaoHsbcType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codAgencia')
            ->add('descricao')
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
                'codConvenio',
                EntityType::class,
                [
                    'label' => 'label.convenio',
                    'class' => 'CoreBundle:Ima\ConfiguracaoConvenioHsbc',
                    'choice_label' => 'codConvenio',
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
            'data_class' => 'Urbem\CoreBundle\Entity\Ima\ConfiguracaoHsbcConta'
        ));
    }
}
