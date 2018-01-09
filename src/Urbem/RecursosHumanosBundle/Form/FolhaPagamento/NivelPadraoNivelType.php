<?php

namespace Urbem\RecursosHumanosBundle\Form\FolhaPagamento;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NivelPadraoNivelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'descricao',
                null,
                array(
                    'label' => 'Descrição',
                    'required' => true
                )
            )
            ->add(
                'valor',
                MoneyType::class,
                [
                    'label' => 'Valor',
                    'currency' => false,
                    'attr' => [
                        'class' => ' '
                    ]
                ]
            )
            ->add(
                'percentual',
                null,
                array(
                    'label' => 'Percentual',
                    'required' => true
                )
            )
            ->add(
                'qtdmeses',
                null,
                array(
                    'label' => 'Meses',
                    'required' => true
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
            'data_class' => 'Urbem\CoreBundle\Entity\Folhapagamento\NivelPadraoNivel'
        ));
    }
}
