<?php

namespace Urbem\RecursosHumanosBundle\Form\FolhaPagamento;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalarioFamiliaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'timestamp',
                DateTimeType::class,
                array(
                    'attr' => array(
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    )
                )
            )
            ->add(
                'vigencia',
                DateType::class,
                array(
                    'attr' => array(
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    )
                )
            )
            ->add('idadeLimite')
            ->add('codRegimePrevidencia')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia'
        ));
    }
}
