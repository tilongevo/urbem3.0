<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;
use Urbem\CoreBundle\Entity\Tcepr\ResponsavelModulo;
use Urbem\CoreBundle\Entity\Tcepr\TipoModulo;
use Urbem\CoreBundle\Entity\Tcepr\TipoResponsavelModulo;
use Urbem\PrestacaoContasBundle\Form\Type\DatePickerType;
use Urbem\PrestacaoContasBundle\Form\Type\SwCgmType;

class ResponsavelModuloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fkTceprTipoModulo', EntityType::class, [
            'placeholder' => 'Selecione',
            'label' => 'Tipo do Módulo',
            'class' => TipoModulo::class,
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('o')->orderBy('o.idTipoModulo', 'ASC');
            },
            'required' => true,
            'constraints' => new NotNull()
        ]);

        $builder->add('fkTceprTipoResponsavelModulo', EntityType::class, [
            'placeholder' => 'Selecione',
            'label' => 'Tipo Responsável do Módulo',
            'class' => TipoResponsavelModulo::class,
            'query_builder' => function (EntityRepository $repository) {
                return $repository->createQueryBuilder('o')->orderBy('o.idTipoResponsavelModulo', 'ASC');
            },
            'required' => true,
            'constraints' => new NotNull()
        ]);

        $builder->add('fkSwCgm', SwCgmType::class, [
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
        $resolver->setDefault('data_class', ResponsavelModulo::class);
    }
}