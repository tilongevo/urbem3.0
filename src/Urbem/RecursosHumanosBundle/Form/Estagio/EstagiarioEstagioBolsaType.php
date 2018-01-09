<?php

namespace Urbem\RecursosHumanosBundle\Form\Estagio;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class EstagiarioEstagioBolsaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'vlBolsa',
                NumberType::class,
                array(
                    'label' => 'label.estagio.valor_bolsa'
                )
            )
            ->add(
                'faltas',
                NumberType::class,
                array(
                    'label' => 'label.estagio.faltas'
                )
            )
            ->add(
                'valeRefeicao',
                CheckboxType::class,
                array(
                    "label" => 'label.estagio.vale_refeicao'
                )
            )
            ->add(
                'valeTransporte',
                CheckboxType::class,
                array(
                    "label" => 'label.estagio.vale_transporte'
                )
            )
            //->add('codPeriodoMovimentacao')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa'
        ));
    }
}
