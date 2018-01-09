<?php

namespace Urbem\FinanceiroBundle\Form\Ppa;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomologarPpaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldOptions = array();
        $fieldOptions['dataEncaminhamentoLegislativo'] = array(
            'required'      => true,
            'label'         => 'label.ppa.dataEncaminhamentoLegislativo'
        );
        $fieldOptions['numeroProtocolo'] = array(
            'required'      => true,
            'label'         => 'label.ppa.numeroProtocolo'
        );
        $fieldOptions['dataDevExecutivo'] = array(
            'required'      => true,
            'label'         => 'label.ppa.dataDevExecutivo'
        );
        $fieldOptions['nomeVeiculo'] = array(
            'required'      => true,
            'class' => 'CoreBundle:Licitacao\VeiculosPublicidade',
            'choice_label' => function ($value, $key, $index) {
                return $value->getFkLicitacaoTipoVeiculosPublicidade()->getDescricao() . ' - ' . $value->getFkSwCgm()->getNomCgm();
            },
            'placeholder' => 'label.selecione',
            'label'         => 'label.ppa.nomeVeiculo'
        );
        $fieldOptions['periodicidadeMetas'] = array(
            'required'      => true,
            'class' => 'CoreBundle:Ppa\Periodicidade',
            'choice_label' => 'nomPeriodicidade',
            'placeholder' => 'label.selecione',
            'label'         => 'label.ppa.periodicidadeMetas'
        );
        $fieldOptions['numeroNorma'] = array(
            'required'      => true,
            'class' => 'CoreBundle:Normas\Norma',
            'choice_label' => function ($value, $key, $index) {
                return 'LEI ' . str_pad($value->getNumNorma(), 6, '0', STR_PAD_LEFT) . '/' . $value->getExercicio() . ' - ' . $value->getNomNorma();
            },
            'placeholder' => 'label.selecione',
            'label'         => 'label.ppa.numeroNorma'
        );
        $builder
            ->add('dataEncaminhamentoLegislativo', 'text', $fieldOptions['dataEncaminhamentoLegislativo'])
            ->add('numeroProtocolo', 'text', $fieldOptions['numeroProtocolo'])
            ->add('dataDevExecutivo', 'text', $fieldOptions['dataDevExecutivo'])
            ->add('nomeVeiculo', EntityType::class, $fieldOptions['nomeVeiculo'])
            ->add('periodicidadeMetas', EntityType::class, $fieldOptions['periodicidadeMetas'])
            ->add('numeroNorma', EntityType::class, $fieldOptions['numeroNorma'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
