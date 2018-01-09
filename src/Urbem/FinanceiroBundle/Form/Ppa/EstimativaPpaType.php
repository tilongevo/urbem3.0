<?php

namespace Urbem\FinanceiroBundle\Form\Ppa;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstimativaPpaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldOptions = array();
        $fieldOptions['porcentagem'] = array(
            'choices'       => [
                'label.ppa.sintetica'     => 'S',
                'label.ppa.analitica'    => 'A'
            ],
            'label'         => 'label.ppa.porcentagem',
            'required' => false,
            'data' => 'S',
            'placeholder' => false,
            'attr'          => [
                'class'         => 'select2-parameters'
            ],
            'mapped'        => false
        );
        $fieldOptions['porcentagemAno1'] = array(
            'label'         => 'label.ppa.porcentagemAno1',
            'mapped'        => false,
            'required'      => false,
        );
        $fieldOptions['porcentagemAno2'] = array(
            'label'         => 'label.ppa.porcentagemAno2',
            'mapped'        => false,
            'required'      => false,
        );
        $fieldOptions['porcentagemAno3'] = array(
            'label'         => 'label.ppa.porcentagemAno3',
            'mapped'        => false,
            'required'      => false,
        );
        $fieldOptions['porcentagemAno4'] = array(
            'label'         => 'label.ppa.porcentagemAno4',
            'mapped'        => false,
            'required'      => false,
        );

        $builder
            ->add('porcentagem', 'choice', $fieldOptions['porcentagem'])
            ->add('porcentagemAno1', 'number', $fieldOptions['porcentagemAno1'])
            ->add('porcentagemAno2', 'number', $fieldOptions['porcentagemAno2'])
            ->add('porcentagemAno3', 'number', $fieldOptions['porcentagemAno3'])
            ->add('porcentagemAno4', 'number', $fieldOptions['porcentagemAno4'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
