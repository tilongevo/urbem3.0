<?php

namespace Urbem\RecursosHumanosBundle\Form\Pessoal;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ContratoServidorCasoCausaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'dtRescisao',
                Type\DateType::class,
                [
                    'label' => 'label.dtRescisao',
                    'error_bubbling' => false,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ]
                ]
            )
            ->add(
                'incFolhaSalario',
                Type\ChoiceType::class,
                array (
                    'choices' => array('Sim' => 1, 'Não' => 0),
                    "label" => "label.rescisaoContrato.folhaSalario",
                )
            )
            ->add(
                'incFolhaDecimo',
                Type\ChoiceType::class,
                array (
                    'choices' => array('Sim' => 1, 'Não' => 0),
                    "label" => "label.rescisaoContrato.folhaDecimo",
                )
            )
            ->add(
                'codCasoCausa',
                EntityType::class,
                [
                    'label' => 'label.rescisaoContrato.codigoCasoCausa',
                    'class' => 'CoreBundle:Pessoal\CasoCausa',
                    'choice_label' => 'descricao',
                    'error_bubbling' => false,
                    'placeholder' => 'label.selecione',
                ]
            )
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Pessoal\ContratoServidorCasoCausa'
        ));
    }
}
