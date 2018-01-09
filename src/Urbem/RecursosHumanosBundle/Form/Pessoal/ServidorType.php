<?php

namespace Urbem\RecursosHumanosBundle\Form\Pessoal;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServidorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codUf')
            ->add('codMunicipio')
            ->add('nomePai')
            ->add('nomeMae')
            ->add('zonaTitulo')
            ->add('secaoTitulo')
            ->add('caminhoFoto')
            ->add('nrTituloEleitor')
            ->add(
                'codRaca',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Cse\Raca',
                    'choice_label' => 'nomRaca',
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'codEstadoCivil',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Cse\EstadoCivil',
                    'choice_label' => 'nomEstado',
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
            'data_class' => 'Urbem\CoreBundle\Entity\Pessoal\Servidor'
        ));
    }
}
