<?php

namespace Urbem\RecursosHumanosBundle\Form\Estagio;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EstagiarioEstagioContaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'codAgencia',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Monetario\Agencia',
                    'label' => 'label.agencia',
                    'choice_label' => function ($codAgencia) {
                        return $codAgencia->getNumAgencia() . " - " . $codAgencia->getNomAgencia();
                    }
                )
            )
            ->add(
                'numConta',
                Type\TextType::class,
                array(
                    'label' => 'label.contaCorrente'
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioConta',
            'cascade_validation' => true
        ));
    }
}
