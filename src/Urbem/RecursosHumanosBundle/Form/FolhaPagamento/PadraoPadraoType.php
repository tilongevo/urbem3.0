<?php

namespace Urbem\RecursosHumanosBundle\Form\FolhaPagamento;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type;

class PadraoPadraoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $norma = $options['norma'];
        $builder
            ->add(
                'valor',
                Type\MoneyType::class,
                [
                    'label' => 'Valor',
                    'required' => true,
                    'currency' => false,
                    'attr' => [
                        'class' => ' '
                    ],
                    'label_attr' => [
                        'class' => 'required '
                    ]
                ]
            )
            ->add(
                'vigencia',
                Type\DateType::class,
                [
                    'html5' => false,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                        'data-date-format' => 'dd/mm/yyyy',
                        'required' => true
                    ],
                    'format' => 'dd/MM/yyyy',
                    'label' => 'Vigência'
                ]
            )
            ->add(
                'tipoNorma',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Normas\TipoNorma',
                    'choice_label' => 'nomTipoNorma',
                    "error_bubbling" => false,
                    'placeholder' => null,
                    'label' => 'label.orgao.codTipoNorma',
                    'mapped' => false,
                    'required' => true,
                    'query_builder' => function ($em) {
                        return $em->createQueryBuilder('tn')
                                  ->orderBy('tn.nomTipoNorma', 'ASC');
                    },
                    'preferred_choices' => function ($val) use ($norma) {
                        if(!empty($norma)) {
                            return $val->getCodTipoNorma() == $norma->getCodTipoNorma()->getCodTipoNorma();
                        }
                    }
                )
            )
            ->add(
                'codNorma',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Normas\Norma',
                    'choice_label' => 'nomNorma',
                    "error_bubbling" => false,
                    'placeholder' => false,
                    'label' => 'Norma',
                    'required' => true,
                    'query_builder' => function (EntityRepository $er) use ($norma) {
                        if(!empty($norma)) {
                            return $er->qbNormasPorTipo($norma->getCodTipoNorma()->getCodTipoNorma());
                        }
                    },
                    'preferred_choices' => function ($val) use ($norma) {
                        if(!empty($norma)) {
                            return $val->getCodNorma() == $norma->getCodNorma();
                        }
                    }
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Folhapagamento\PadraoPadrao'
        ));
        $resolver->setRequired(array(
            'norma'
        ));
    }
}
