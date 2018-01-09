<?php

namespace Urbem\RecursosHumanosBundle\Form\FolhaPagamento;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class FgtsCategoriaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'aliquota_deposito',
                NumberType::class,
                array (
                    'scale' => 2,
                )
            )
            ->add(
                'aliquota_contribuicao',
                NumberType::class,
                array (
                    'scale' => 2,
                )
            )
            ->add(
                'cod_categoria',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Pessoal\Categoria',
                    'choice_label' => 'descricao',
                    'choice_value' => 'codCategoria',
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
            'data_class' => 'Urbem\CoreBundle\Entity\Folhapagamento\FgtsCategoria'
        ));
    }
}
