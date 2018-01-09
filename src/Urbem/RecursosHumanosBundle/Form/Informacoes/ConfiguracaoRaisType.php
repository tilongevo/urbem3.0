<?php

namespace Urbem\RecursosHumanosBundle\Form\Informacoes;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfiguracaoRaisType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numcgm')
            ->add('tipoInscricao')
            ->add('telefone')
            ->add('email')
            ->add('naturezaJuridica')
            ->add('codMunicipio')
            ->add('dtBaseCategoria')
            ->add('ceiVinculado')
            ->add('prefixo')
            ->add('numeroCei')
            ->add(
                'codTipoControlePonto',
                EntityType::class,
                [
                    'label' => 'label.configuracaoRais.tipoControlePonto',
                    'class' => 'CoreBundle:Ima\TipoControlePonto',
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
            'data_class' => 'Urbem\CoreBundle\Entity\Ima\ConfiguracaoRais'
        ));
    }
}
