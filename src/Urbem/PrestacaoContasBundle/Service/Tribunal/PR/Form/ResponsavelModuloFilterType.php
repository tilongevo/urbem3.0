<?php

namespace Urbem\PrestacaoContasBundle\Service\Tribunal\PR\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Urbem\CoreBundle\Entity\Tcepr\TipoModulo;

class ResponsavelModuloFilterType extends AbstractType
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
        ]);
    }
}