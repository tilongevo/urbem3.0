<?php

namespace Urbem\TributarioBundle\Form\Imobiliario;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class TransferenciaPropriedadeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $dtEfetivacao = null;
        $fieldOptions = [];
        $fieldOptions['observacoes'] = ['label' => 'label.observacoes', 'required' => false];

        $builder
            ->add(
                'dtEfetivacao',
                Type\DateType::class,
                [
                    'label' => 'label.imobiliarioTransferenciaPropriedade.dataEfetivacao',
                    'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy',
                    'required' => true,
                    'attr' => array(
                        'class' => 'datepicker ',
                        'data-provide' => 'datepicker',
                        'data-date-format' => 'dd/mm/yyyy',
                    )
                ]
            )
            ->add(
                'observacoes',
                'textarea',
                $fieldOptions['observacoes']
            )
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
