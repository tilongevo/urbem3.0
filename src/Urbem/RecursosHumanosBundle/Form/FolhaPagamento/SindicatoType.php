<?php

namespace Urbem\RecursosHumanosBundle\Form\Folhapagamento;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SindicatoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dataBase')
            ->add(
                'codEvento',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:FolhaPagamento\Evento',
                    'choice_label' => 'codEvento',
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                  )
            )
            ->add(
                'numcgm',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:SwCgmPessoaJuridica',
                    'choice_label' => 'numcgm',
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
            'data_class' => 'Urbem\CoreBundle\Entity\folhapagamento\sindicato'
        ));
    }
}
