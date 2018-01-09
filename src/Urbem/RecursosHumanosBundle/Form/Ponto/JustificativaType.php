<?php

namespace Urbem\RecursosHumanosBundle\Form\Ponto;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type;

class JustificativaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
               ->add(
                   'descricao',
                   Type\TextType::class,
                   [
                    "label" => "label.descricao",
                    "error_bubbling" => false,
                   ]
               )
                ->add(
                    'anularFaltas',
                    Type\CheckboxType::class,
                    [
                    "label" => "label.anularFaltas",
                    "error_bubbling" => true,
                    ]
                )
                   ->add(
                       'lancarDiasTrabalho',
                       Type\CheckboxType::class,
                       [
                       "label" => "label.lancarDiasTrabalho",
                       "error_bubbling" => true,
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
            'data_class' => 'Urbem\CoreBundle\Entity\Ponto\Justificativa'
        ));
    }
}
