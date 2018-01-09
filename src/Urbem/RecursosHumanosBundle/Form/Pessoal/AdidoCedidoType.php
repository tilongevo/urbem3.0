<?php

namespace Urbem\RecursosHumanosBundle\Form\Pessoal;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdidoCedidoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'dtInicial',
                Type\DateType::class,
                [
                    "label" => "label.dtInicial",
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
                'dtFinal',
                Type\DateType::class,
                [
                    "label" => "label.dtFinal",
                    "error_bubbling" => true,
                    'widget' => 'single_text',
                    'html5' => false,
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ]
                ]
            )
            ->add('tipoCedencia')
            ->add('indicativoOnus')
            ->add('numConvenio')
            ->add(
                'cgmCedenteCessionario',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:SwCgm',
                    'choice_label' => 'numcgm',
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'codNorma',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Normas\Norma',
                    'choice_label' => 'nomNorma',
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
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
            'data_class' => 'Urbem\CoreBundle\Entity\Pessoal\AdidoCedido'
        ));
    }
}
