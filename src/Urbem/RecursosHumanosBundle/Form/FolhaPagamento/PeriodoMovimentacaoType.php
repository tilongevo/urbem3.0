<?php

namespace Urbem\RecursosHumanosBundle\Form\FolhaPagamento;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;

class PeriodoMovimentacaoType extends AbstractType
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
                Type\TextType::class,
                [
                    'label' => 'label.recursosHumanos.periodoMovimentacao.dtInicial',
                    'mapped' => false
                ]
            )
            ->add(
                'dtFinal',
                Type\TextType::class,
                [
                    'label' => 'label.recursosHumanos.periodoMovimentacao.dtFinal',
                    'mapped' => false
                ]
            )
            ->add(
                'contratos',
                Type\HiddenType::class,
                [
                    'mapped' => false
                ]
            )
            ->add(
                'contratosStr',
                Type\HiddenType::class,
                [
                    'mapped' => false
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
            'data_class' => PeriodoMovimentacao::class
        ));
    }
}
