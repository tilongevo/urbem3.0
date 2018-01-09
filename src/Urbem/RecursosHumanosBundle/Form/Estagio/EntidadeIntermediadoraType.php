<?php

namespace Urbem\RecursosHumanosBundle\Form\Estagio;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntidadeIntermediadoraType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'numcgm',
                EntityType::class,
                array(
                    'class' => 'Urbem\CoreBundle\Entity\SwCgmPessoaJuridica',
                    'choice_label' => function ($numcgm) {
                        return $numcgm->getNomFantasia();
                    },
                    'label' => 'label.estagio.entidadeIntermediadora',
                    'placeholder' => 'label.estagio.entidade_intermediadora_choice'
                )
            )
            ->add(
                'percentualAtual',
                Type\NumberType::class,
                array(
                    'label' => 'label.estagio.percentual'
                )
            )
            ->add(
                'cgmInstituicao',
                EntityType::class,
                array(
                    'class' => 'Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino',
                    'choice_label' => function ($cgmInstituicao) {
                        return $cgmInstituicao->getNumcgm()->getNomFantasia();
                    },
                    'label' => 'label.estagio.instituicao_ensino',
                    'placeholder' => 'label.estagio.cod_grau_choice'
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
            'data_class' => 'Urbem\CoreBundle\Entity\Estagio\EntidadeIntermediadora'
        ));
    }
}
