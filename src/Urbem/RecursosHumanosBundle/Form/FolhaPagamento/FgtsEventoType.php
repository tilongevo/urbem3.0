<?php

namespace Urbem\RecursosHumanosBundle\Form\FolhaPagamento;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class FgtsEventoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'cod_tipo',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Folhapagamento\TipoEventoFgts',
                    'choice_label' => 'descricao',
                    "error_bubbling" => false,
                    'multiple' => false,
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
            'data_class' => 'Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento'
        ));
    }
}
