<?php

namespace Urbem\RecursosHumanosBundle\Form\Pessoal;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeriasType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('faltas')
            ->add('diasFerias')
            ->add('diasAbono')
            ->add('dtInicialAquisitivo')
            ->add('dtFinalAquisitivo')
            ->add('rescisao')
            //->add('codContrato')
            ->add('codLote')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Pessoal\Ferias'
        ));
    }
}
