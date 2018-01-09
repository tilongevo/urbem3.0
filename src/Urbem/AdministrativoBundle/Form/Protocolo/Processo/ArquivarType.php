<?php

namespace Urbem\AdministrativoBundle\Form\Protocolo\Processo;

use Doctrine\ORM\EntityRepository;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

use Urbem\CoreBundle\Entity\SwHistoricoArquivamento;
use Urbem\CoreBundle\Entity\SwSituacaoProcesso;

/**
 * Class ArquivarType
 *
 * @package Urbem\AdministrativoBundle\Form\Protocolo\Processo
 */
class ArquivarType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fkSwSituacaoProcesso', EntityType::class, [
                'attr'          => ['class' => 'select2-parameters '],
                'class'         => SwSituacaoProcesso::class,
                'choice_label'  => 'nomSituacao',
                'label'         => 'label.processo.arquivamento.arquivar',
                'placeholder'   => 'label.selecione',
                'query_builder' => function (EntityRepository $repository) {
                    $queryBuilder = $repository->createQueryBuilder('sp');

                    return $queryBuilder->where(
                        $queryBuilder->expr()->in('sp.codSituacao', [
                            SwSituacaoProcesso::ARQUIVADO_TEMPORARIO,
                            SwSituacaoProcesso::ARQUIVADO_DEFINITIVO
                        ])
                    );
                },
                'required'      => true
            ])
            ->add('fkSwHistoricoArquivamento', EntityType::class, [
                'attr'         => ['class' => 'select2-parameters '],
                'class'        => SwHistoricoArquivamento::class,
                'choice_label' => 'nomHistorico',
                'label'        => 'label.processo.motivoArquivamento',
                'placeholder'  => 'label.selecione',
                'required'     => true,
            ])
            ->add('localizacao', TextType::class, [
                'label'    => 'label.processo.localizacao',
                'required' => false,
            ])
            ->add('textoComplementar', TextareaType::class, [
                'label'    => 'label.processo.textoComplementar',
                'required' => false,
            ]);
    }
}
