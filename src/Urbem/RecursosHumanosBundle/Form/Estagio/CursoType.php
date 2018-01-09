<?php

namespace Urbem\RecursosHumanosBundle\Form\Estagio;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CursoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'nomCurso',
                null,
                array(
                    'label' => 'Nome do Curso'
                )
            )
            ->add(
                'codGrau',
                EntityType::class,
                array(
                    'label' => 'Codigo Grau',
                    'class' => 'CoreBundle:Estagio\Grau',
                    'choice_label' => 'descricao'
                )
            )
            ->add(
                'codAreaConhecimento',
                EntityType::class,
                array(
                    'label' => 'Nome do Curso',
                    'class' => 'CoreBundle:Estagio\AreaConhecimento',
                    'choice_label' => 'descricao'
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
            'data_class' => 'Urbem\CoreBundle\Entity\Estagio\Curso'
        ));
    }
}
