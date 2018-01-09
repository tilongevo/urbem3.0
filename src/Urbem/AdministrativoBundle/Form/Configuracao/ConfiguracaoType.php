<?php

namespace Urbem\AdministrativoBundle\Form\Configuracao;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfiguracaoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('exercicio')
            ->add('parametro')
            ->add('valor')
            ->add(
                'codModulo',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Administracao\Modulo',
                    'choice_label' => 'nomModulo',
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
            'data_class' => 'Urbem\CoreBundle\Entity\Administracao\Configuracao'
        ));
    }
}
