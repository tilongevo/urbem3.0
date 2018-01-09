<?php

namespace Urbem\FinanceiroBundle\Form\Contabilidade\PlanoConta;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EncerramentoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldOptions = array();
        $fieldOptions['dtEncerramento'] = array(
            'label'         => 'label.planoconta.dtEncerramento',
            'mapped'        => false,
            'attr' => [
                'class' => 'datepicker',
                'data-provide' => 'datepicker',
            ]
        );
        $fieldOptions['motivo'] = array(
            'label'         => 'label.planoconta.motivo',
            'mapped'        => false
        );

        $builder
            ->add('dtEncerramento','text', $fieldOptions['dtEncerramento'])
            ->add('motivo', 'textarea', $fieldOptions['motivo'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
