<?php

namespace Urbem\RecursosHumanosBundle\Form\Pessoal;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CargoSubDivisaoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nroVagaCriada')
            ->add(
                'codNorma',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Normas\Norma',
                    'choice_label' => 'nomNorma',
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'codSubDivisao',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Pessoal\SubDivisao',
                    'choice_label' => 'descricao',
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                )
            )
            ->add(
                'codCargo',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Pessoal\Cargo',
                    'choice_label' => 'descricao',
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
            'data_class' => 'Urbem\CoreBundle\Entity\Pessoal\CargoSubDivisao'
        ));
    }
}
