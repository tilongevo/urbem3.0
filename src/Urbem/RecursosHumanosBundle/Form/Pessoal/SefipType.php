<?php

namespace Urbem\RecursosHumanosBundle\Form\Pessoal;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class SefipType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descricao')
            ->add('numSefip')
            ->add(
                'repetirMensal',
                Type\ChoiceType::class,
                array (
                    'choices' => array('Sim' => 1, 'Não' => 0),
                    "label" => "label.sefip.repetirMensal",
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
            'data_class' => 'Urbem\CoreBundle\Entity\Pessoal\Sefip'
        ));
    }
}
