<?php

namespace Urbem\RecursosHumanosBundle\Form\Pessoal;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;

class AssentamentoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add(
                'gradeEfetividade',
                ChoiceType::class,
                array (
                    'choices' => array('Sim' => 1, 'Não' => 0),
                    "label" => "label.assentamento.gradeEfetividade",
                )
            )
            ->add(
                'relFuncaoGratificada',
                ChoiceType::class,
                array (
                    'choices' => array('Sim' => 1, 'Não' => 0),
                    "label" => "label.assentamento.relFuncaoGratificada",
                )
            )
            ->add(
                'eventoAutomatico',
                ChoiceType::class,
                array (
                    'choices' => array('Sim' => 1, 'Não' => 0),
                    "label" => "label.assentamento.eventoAutomatico",
                )
            )
            ->add(
                'assentamentoInicio',
                ChoiceType::class,
                array (
                    'choices' => array('Sim' => 1, 'Não' => 0),
                    "label" => "label.assentamento.assentamentoInicio",
                )
            )
            ->add(
                'assentamentoAutomatico',
                ChoiceType::class,
                array (
                    'choices' => array('Sim' => 1, 'Não' => 0),
                    "label" => "label.assentamento.assentamentoAutomatico",
                )
            )
            ->add('quantDiasOnusEmpregador')
            ->add('quantDiasLicencaPremio')
            ->add(
                'codEsfera',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Pessoal\EsferaOrigem',
                    'choice_label' => 'descricao',
                    "label" => "label.origemEsfera",
                    "error_bubbling" => false,
                    'placeholder' => 'label.selecione',
                )
            )
            ->add('codAssentamento')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Pessoal\Assentamento'
        ));
    }
}
