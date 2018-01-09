<?php

namespace Urbem\RecursosHumanosBundle\Form\Folhapagamento;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BasesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomBase')
            ->add('tipoBase')
            ->add('apresentacaoValor')
            ->add('insercaoAutomatica')
            ->add('codModulo')
            ->add('codBiblioteca')
            ->add('codFuncao')
            ->add(
                'codEvento',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Folhapagamento\Evento',
                    'choice_label' => 'descricao',
                    "label" => "label.codEvento",
                    "error_bubbling" => false,
                    'multiple' => true,
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
            'data_class' => 'Urbem\CoreBundle\Entity\Folhapagamento\Bases'
        ));
    }
}
