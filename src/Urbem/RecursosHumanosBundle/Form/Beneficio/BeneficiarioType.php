<?php

namespace Urbem\RecursosHumanosBundle\Form\Beneficio;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BeneficiarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cgmBeneficiario')
            ->add('cgmFornecedor')
            ->add(
                'codModalidade',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Beneficio\ModalidadeConvenioMedico',
                    'choice_label' => 'descricao',
                    'choice_value' => 'cod_modalidade',
                    'placeholder' => 'Selecione'
                )
            )
            ->add(
                'codTipoConvenio',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Beneficio\TipoConvenioMedico',
                    'choice_label' => 'descricao',
                    'choice_value' => 'cod_tipo_convenio',
                    'placeholder' => 'Selecione'
                )
            )
            ->add('codigoUsuario')
            ->add(
                'grauParentesco',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Cse\GrauParentesco',
                    'choice_label' => 'nom_grau',
                    'choice_value' => 'cod_grau',
                    'placeholder' => 'Selecione'
                )
            )
            ->add(
                'dtInicio',
                DateType::class,
                [
                    'html5' => false,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ]
                ]
            )
            ->add(
                'dtFim',
                DateType::class,
                [
                    'html5' => false,
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'datepicker',
                        'data-provide' => 'datepicker',
                    ]
                ]
            )
            ->add('valor')
            ->add(
                'codPeriodoMovimentacao',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Folhapagamento\PeriodoMovimentacao',
                    'choice_label' => 'cod_periodo_movimentacao',
                    'choice_value' => 'cod_periodo_movimentacao',
                    'placeholder' => 'Selecione'
                )
            )
            ->add('codContrato');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Urbem\CoreBundle\Entity\Beneficio\Beneficiario'
        ));
    }
}
