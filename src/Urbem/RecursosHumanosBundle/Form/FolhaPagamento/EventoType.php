<?php

namespace Urbem\RecursosHumanosBundle\Form\FolhaPagamento;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EventoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codigo')
            ->add('descricao')
            ->add('natureza')
            ->add('tipo')
            ->add('fixado')
            ->add('limiteCalculo')
            ->add('apresentaParcela')
            ->add('eventoSistema')
            ->add('sigla')
            ->add('apresentarContracheque')
            ->add(
                'codVerba',
                EntityType::class,
                array (
                  'class' => 'CoreBundle:Folhapagamento\VerbaRescisoriaMte',
                  'choice_label' => 'codVerba',
                  "label" => "label.nomVerba",
                  "error_bubbling" => false,
                  'multiple' => false,
                )
            )
            ->add(
                'codBase',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Folhapagamento\Bases',
                    'choice_label' => 'codBase',
                    "label" => "label.nomBase",
                    "error_bubbling" => false,
                    'multiple' => true,
                )
            )
            ->add(
                'codSequencia',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Folhapagamento\SequenciaCalculo',
                    'choice_label' => 'descricao',
                    "label" => "label.codSequencia",
                    "error_bubbling" => false,
                    'multiple' => true,
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
            'data_class' => 'Urbem\CoreBundle\Entity\Folhapagamento\Evento'
        ));
    }
}
