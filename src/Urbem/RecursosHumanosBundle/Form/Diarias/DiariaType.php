<?php

namespace Urbem\RecursosHumanosBundle\Form\Diarias;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class DiariaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'numcgm',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:SwCgm',
                    'choice_label' => 'nomcgm',
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                    "label" => "label.diaria.numcgm",
                    "required" => true
                )
            )
            ->add(
                'manter',
                Type\CheckboxType::class,
                [
                    "label" => "label.diaria.manter",
                    "error_bubbling" => false,
                ]
            )
            ->add(
                'codNorma',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Normas\Norma',
                    'choice_label' => 'nomNorma',
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                    'label' => 'label.diaria.codNorma',
                )
            )
            ->add(
                'dtInicio',
                DateType::class,
                [
                    'html5' => false,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ],
                    'format' => 'dd/MM/yyyy',
                ]
            )
            ->add(
                'dtTermino',
                DateType::class,
                [
                    'html5' => false,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ],
                    'format' => 'dd/MM/yyyy'
                ]
            )
            ->add(
                'hrInicio',
                TimeType::class,
                [
                    'label' => 'label.diaria.hrInicio',
                    'error_bubbling' => false,
                    'widget' => 'single_text',
                    'html5' => false,
                ]
            )
            ->add(
                'hrTermino',
                TimeType::class,
                [
                    'label' => 'label.diaria.hrTermino',
                    'error_bubbling' => false,
                    'widget' => 'single_text',
                    'html5' => false,
                ]
            )
            ->add(
                'codUf',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:SwUf',
                    'choice_label' => 'nomUf',
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                    'label' => 'label.diaria.nomUf',
                )
            )
            ->add(
                'codMunicipio',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:SwMunicipio',
                    'choice_label' => 'nomMunicipio',
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                    'label' => 'label.diaria.codMunicipio',
                )
            )
            ->add('motivo', null, array('label' => 'label.diaria.motivo'))
            ->add(
                'codTipo',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Diarias\TipoDiaria',
                    'choice_label' => 'nomUf',
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                    'label' => 'label.diaria.codTipo',
                )
            )
            ->add('vlUnitario', null, array('label' => 'label.diaria.vlUnitario'))
            ->add('quantidade', null, array('label' => 'label.diaria.quantidade'))
            ->add('vlTotal', null, array('label' => 'label.diaria.vlTotal'))
            ->add(
                'codContrato',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Pessoal\Contrato',
                    'choice_label' => 'codContrato',
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                    'label' => 'label.diaria.codContrato',
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
            'data_class' => 'Urbem\CoreBundle\Entity\Diarias\Diaria'
        ));
    }
}
