<?php

namespace Urbem\RecursosHumanosBundle\Form\Pessoal;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CargoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'descricao',
                Type\TextType::class,
                [
                    "label" => "label.descricao",
                    "error_bubbling" => false,
                ]
            )
            ->add(
                'cargoCc',
                Type\CheckboxType::class,
                [
                    "label" => "label.cargo.cargoCc",
                    "error_bubbling" => false,
                ]
            )
            ->add(
                'funcaoGratificada',
                Type\CheckboxType::class,
                [
                    "label" => "label.cargo.funcaoGratificada",
                    "error_bubbling" => false,
                ]
            )
            ->add(
                'codEscolaridade',
                EntityType::class,
                array (
                  'class' => 'CoreBundle:SwEscolaridade',
                  'choice_label' => 'descricao',
                  "label" => "label.cargo.codEscolaridade",
                  "error_bubbling" => false,
                  'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'atribuicoes',
                Type\TextareaType::class,
                [
                    "label" => "label.cargo.atribuicoes",
                    "error_bubbling" => false,
                ]
            )
            ->add(
                'codRequisito',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Pessoal\Requisito',
                    'choice_label' => 'descricao',
                    "label" => "label.cargo.codRequisito",
                    "error_bubbling" => false,
                    'multiple' => true,
                )
            )
            ->add(
                'codLote',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Pessoal\LoteFerias',
                    'choice_label' => 'nome',
                    "label" => "label.cargo.codLote",
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                "padrao",
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Folhapagamento\Padrao',
                    'choice_label' => function ($padrao, $key, $index) {
                        /** @var Padrao $padrao */
                        return $padrao->getCodPadrao() . " - " . $padrao->getDescricao();
                    },
                    "label" => "label.cargo.padrao",
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                "cbo",
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Pessoal\Cbo',
                    'choice_label' => 'descricao',
                    "label" => "label.cargo.cbo",
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
            'data_class' => 'Urbem\CoreBundle\Entity\Pessoal\Cargo'
        ));
    }
}
