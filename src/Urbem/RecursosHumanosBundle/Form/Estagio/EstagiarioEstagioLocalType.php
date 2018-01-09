<?php

namespace Urbem\RecursosHumanosBundle\Form\Estagio;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class EstagiarioEstagioLocalType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'codLocal',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Organograma\Local',
                    'label' => 'label.local',
                    'choice_label' => function ($codLocal) {
                        return $codLocal->getCodLocal() . " - " . $codLocal->getDescricao();
                    }
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioLocal',
            'cascade_validation' => true
        ));
    }
}
