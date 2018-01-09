<?php

namespace Urbem\RecursosHumanosBundle\Form\Pessoal;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AposentadoriaEncerramentoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'motivo',
                Type\TextareaType::class,
                [
                    'label' => 'label.aposentadoria.motivo'
                ]
            )
            ->add(
                'dtEncerramento',
                Type\DateType::class,
                [
                    'label' => 'label.aposentadoria.dtEncerramento',
                    'error_bubbling' => true,
                    'widget' => 'single_text',
                    'html5' => false,
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provider' => 'datapicker',
                        'maxlength' => 160
                    ],
                    'format' => 'dd/MM/yyyy'
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
            'data_class' => 'Urbem\CoreBundle\Entity\Pessoal\AposentadoriaEncerramento'
        ));
    }
}
