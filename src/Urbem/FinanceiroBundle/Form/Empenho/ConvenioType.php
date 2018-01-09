<?php

namespace Urbem\FinanceiroBundle\Form\Empenho;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConvenioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fkEmpenhoEmpenhoConvenios', CollectionType::class, [
            'entry_type' => EmpenhoConvenioType::class,
            'allow_add' => true,
            'prototype' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'entry_options' => [
                'user' => $options['user'],
                'authorization_checker' => $options['authorization_checker'],
                'exercicio' => $options['exercicio'],
            ]
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['user', 'exercicio', 'authorization_checker']);
        $resolver->setAllowedTypes('user', ['\FOS\UserBundle\Model\UserInterface']);
        $resolver->setAllowedTypes('authorization_checker', ['\Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface']);
        $resolver->setAllowedTypes('exercicio', ['string']);

        $resolver->setDefaults(['data_class' => 'Urbem\CoreBundle\Entity\Licitacao\Convenio']);
    }
}
