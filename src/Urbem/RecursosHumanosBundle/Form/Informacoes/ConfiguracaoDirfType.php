<?php

namespace Urbem\RecursosHumanosBundle\Form\Informacoes;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfiguracaoDirfType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('responsavelPrefeitura')
            ->add('responsavelEntrega')
            ->add('telefone')
            ->add('ramal')
            ->add('fax')
            ->add('email')
            ->add('pagamentoMesCompetencia')
            ->add('codEventoMolestia')
            ->add(
                'codNatureza',
                EntityType::class,
                [
                    'label' => 'label.naturezaEstabelecimento',
                    'class' => 'CoreBundle:Ima\NaturezaEstabelecimento',
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
            'data_class' => 'Urbem\CoreBundle\Entity\Ima\ConfiguracaoDirf'
        ));
    }
}
