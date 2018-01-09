<?php

namespace Urbem\PatrimonialBundle\Form\Patrimonio;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BemBaixadoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'dtBaixa',
                DateType::class,
                [
                    "label" => "label.dtBaixa",
                    "error_bubbling" => true,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ]
                ]
            )
            ->add('motivo')
            ->add(
                'tipoBaixa',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Patrimonio\TipoBaixa',
                    'choice_label' => 'descricao',
                    'placeholder' => 'Selecione'
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
            'data_class' => 'Urbem\CoreBundle\Entity\Patrimonio\BemBaixado'
        ));
    }
}
