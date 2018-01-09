<?php

namespace Urbem\RecursosHumanosBundle\Form\Calendario;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalendarioDiaCompensadoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add(
            'codFeriado',
            EntityType::class,
            array (
              'class' => 'CoreBundle:Calendario\Feriado',
              'choice_label' => 'descricao',
              "label" => "label.calendario_dia_compensado.codFeriado",
              "error_bubbling" => false,
              'placeholder' => 'label.selecione',
            )
        )
        ->add(
            'codCalendar',
            EntityType::class,
            array (
              'class' => 'CoreBundle:Calendario\CalendarioCadastro',
              'choice_label' => 'descricao',
              'label' => 'label.calendario_dia_compensado.codCalendar',
              "error_bubbling" => false,
              'placeholder' => 'label.selecione',
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
            'data_class' => 'Urbem\CoreBundle\Entity\Calendario\CalendarioDiaCompensado'
        ));
    }
}
