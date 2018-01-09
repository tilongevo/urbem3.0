<?php

namespace Urbem\RecursosHumanosBundle\Form\Estagio;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InstituicaoEnsinoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('vlBolsa')
            ->add(
                'numcgm',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:SwCgmPessoaJuridica',
                    'choice_label' => function ($numcgm) {
                        return "{$numcgm->getCnpj()} - {$numcgm->getNomFantasia()}";
                    }
                )
            )
            ->add(
                'codCurso',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Estagio\Curso',
                    'choice_label' => 'nom_curso'
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
            'data_class' => 'Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino'
        ));
    }
}
