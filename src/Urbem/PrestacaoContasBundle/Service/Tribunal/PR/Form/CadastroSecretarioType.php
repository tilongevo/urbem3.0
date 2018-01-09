<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Tcepr\CadastroSecretario;
use Urbem\CoreBundle\Form\Type\Organograma\OrgaoType;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;
use Urbem\PrestacaoContasBundle\Form\Type\NormaType;
use Urbem\PrestacaoContasBundle\Form\Type\SwCgmPessoaFisicaType;

class CadastroSecretarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fkOrganogramaOrgao', OrgaoType::class, [
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('fkSwCgmPessoaFisica', SwCgmPessoaFisicaType::class, [
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('fkNormasNorma', NormaType::class, [
            'required' => true,
            'constraints' => [new NotNull()]
        ]);

        $builder->add('dtInicioVinculo', DatePickerType::class, [
            'label' => 'Data de Início',
            'required' => true,
            'constraints' => [new NotNull()]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', CadastroSecretario::class);
    }
}