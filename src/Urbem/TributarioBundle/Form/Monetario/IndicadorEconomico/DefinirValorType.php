<?php

namespace Urbem\TributarioBundle\Form\Monetario\IndicadorEconomico;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sonata\AdminBundle\Form\FormMapper;

class DefinirValorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldOptions = array();

        $fieldOptions['valor'] = array(
            'label' => 'label.monetarioIndicadorEconomico.valor',
            'required' => false,
            'mapped' => false,
            'attr' => array(
                'class' => 'mask-monetaria '
            )
        );

        $fieldOptions['dtVigencia'] = array(
            'label' => 'label.monetarioIndicadorEconomico.dtVigencia',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'datepicker',
                'data-provide' => 'datepicker',
            ],
        );

        $builder
            ->add('valor', TextType::class, $fieldOptions['valor'])
            ->add('dtVigencia', TextType::class, $fieldOptions['dtVigencia'])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
    }
}
