<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Tcepr\ResponsavelModulo;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;

class BaixaResponsavelModuloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dtBaixa', DatePickerType::class, [
            'label' => 'Data Baixa',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('descricaoBaixa', TextareaType::class, [
            'required' => true,
            'constraints' => [new NotNull(), new Length(['min' => 1, 'max' => 250])]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', ResponsavelModulo::class);
    }
}