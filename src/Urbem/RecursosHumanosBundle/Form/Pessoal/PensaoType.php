<?php

namespace Urbem\RecursosHumanosBundle\Form\Pessoal;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class PensaoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codDependente')
            ->add('codServidor')
            ->add('tipoPensao')
            ->add('dtInclusao', 'date')
            ->add(
                'dtInclusao',
                Type\DateType::class,
                [
                    "label" => "label.dtInicial",
                    "error_bubbling" => true,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ]
                ]
            )
            ->add(
                'dtLimite',
                Type\DateType::class,
                [
                    "label" => "label.dtInicial",
                    "error_bubbling" => true,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ]
                ]
            )
            ->add('percentual')
            ->add('observacao')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Pessoal\Pensao'
        ));
    }
}
