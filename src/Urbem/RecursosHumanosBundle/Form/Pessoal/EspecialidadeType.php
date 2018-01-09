<?php

namespace Urbem\RecursosHumanosBundle\Form\Pessoal;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EspecialidadeType extends AbstractType
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
                    "label" => "Descrição da especialidade",
                    "error_bubbling" => false,
                ]
            );
    }

    /**
    * @param OptionResolver $resolver
    */
    public function configureOptions(OptionsResolver $resolver)
    {
            $resolver->setDefaults(array(
                'data_class' => 'Urbem\CoreBundle\Entity\Pessoal\Especialidade'
            ));
    }
}
