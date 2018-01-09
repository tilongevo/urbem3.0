<?php

namespace Urbem\RecursosHumanosBundle\Form\Concurso;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EditalType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'editalAbertura',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Normas\Norma',
                    'choice_label' => 'nomNorma',
                    "label" => "label.concurso.editalAbertura",
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'inCodTipoNorma',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Normas\TipoNorma',
                    'choice_label' => 'nomTipoNorma',
                    "label" => "label.concurso.inCodTipoNorma",
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                    'mapped' => false,
                )
            )
            ->add(
                'lbldtPublicacao',
                Type\TextType::class,
                [
                    "label" => "label.concurso.lbldtPublicacao",
                    "disabled" => true,
                    'mapped' => false,
                ]
            )
            ->add(
                'spnlinkEdital',
                Type\TextType::class,
                [
                    "label" => "label.concurso.spnlinkEdital",
                    "disabled" => true,
                    'mapped' => false,
                ]
            )
            ->add(
                'codNorma',
                Type\ChoiceType::class,
                [
                    "label" => "label.concurso.codNorma",
                    "choices" => [],
                    "placeholder" => 'label.selecione',
                ]
            )
            ->add(
                'dtAplicacao',
                Type\DateType::class,
                [
                    "label" => "label.dtAplicacao",
                    "error_bubbling" => true,
                    'widget' => 'single_text',
                    'html5' => false,
                    'attr' => [
                        'data-provide' => 'datepicker',
                    ],
                    'format' => 'dd/MM/yyyy'
                ]
            )
            ->add(
                'codCargo',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Pessoal\Cargo',
                    'choice_label' => 'descricao',
                    "label" => "label.codCargo",
                    "error_bubbling" => false,
                    'multiple' => true,
                )
            )
        ;

        $builder
        ->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();

                $form
                ->add('codNorma', EntityType::class, array(
                    'class' => 'CoreBundle:Normas\Norma',
                    'choice_label' => 'nomNorma',
                    "label" => "label.concurso.codNorma",
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                ))
                ;
            }
        )
        ->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();

                $form->add('codNorma', EntityType::class, array(
                    'class' => 'CoreBundle:Normas\Norma',
                    'choice_label' => 'nomNorma',
                    "label" => "label.concurso.codNorma",
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                ));
            }
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Concurso\Edital'
        ));
    }
}
