<?php

namespace Urbem\PatrimonialBundle\Form\Patrimonio\Inventario;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Organograma\Local;

/**
 * Class ExportarType
 * @package Urbem\PatrimonialBundle\Form\Patrimonio\Inventario
 */
class ExportarType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $em = $options['em'];

        $fieldOptions['places'] = [
            'class' => Local::class,
            'choice_label' => function ($places) {
                return $places->getDescricao();
            },
            'label' => 'label.configuracaoHsbc.local',
            'mapped' => false,
            'expanded' => false,
            'multiple' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $builder
            ->add('places', EntityType::class, $fieldOptions['places'])
            ->add('test', 'text', ['label' => 'lalalala', 'mapped' => false])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Local::class,
            'em' => null,
            'type' => null,
        ));
    }
}
