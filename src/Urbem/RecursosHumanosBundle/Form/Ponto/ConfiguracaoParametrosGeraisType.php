<?php

namespace Urbem\RecursosHumanosBundle\Form\Ponto;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ConfiguracaoParametrosGeraisType extends AbstractType
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
                    'label' => 'label.descricao',
                    'error_bubbling' => false
                ]
            )
            ->add(
                'limitarAtrasos',
                Type\CheckboxType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.limitarAtrasos',
                    'error_bubbling' => false,
                ]
            )
            ->add(
                'horaNoturno1',
                Type\TimeType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.horaNoturno1',
                    'error_bubbling' => false,
                    'widget' => 'single_text',
                    'html5' => false,
                ]
            )
            ->add(
                'horaNoturno2',
                Type\TimeType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.horaNoturno2',
                    'error_bubbling' => false,
                    'widget' => 'single_text',
                    'html5' => false,
                ]
            )
            ->add(
                'separarAdicional',
                Type\CheckboxType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.separarAdicional',
                    'error_bubbling' => false,
                ]
            )
            ->add(
                'lancarAbono',
                Type\CheckboxType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.lancarAbono',
                    'error_bubbling' => false,
                ]
            )
            ->add(
                'lancarDesconto',
                Type\CheckboxType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.lancarDesconto',
                    'error_bubbling' => false,
                ]
            )
            ->add(
                'trabalhoFeriado',
                Type\CheckboxType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.trabalhoFeriado',
                    'error_bubbling' => false,
                ]
            )
            ->add(
                'somarExtras',
                Type\CheckboxType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.somarExtras',
                    'error_bubbling' => false,
                ]
            )
            ->add(
                'vigencia',
                Type\DateType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.vigencia',
                    'error_bubbling' => false,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                        ]
                ]
            )
            ->add(
                'codDiaDsr',
                EntityType::class,
                [
                    'label' => 'label.configuracao_relogio_ponto.codDiaDsr',
                    'class' => 'CoreBundle:Administracao\DiasSemana',
                    'choice_label' => 'nom_dia',
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
            'data_class' => 'Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais'
        ));
    }
}
