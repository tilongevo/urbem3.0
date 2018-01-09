<?php

namespace Urbem\AdministrativoBundle\Form\Protocolo\Processo;

use Sonata\DoctrineORMAdminBundle\Admin\FieldDescription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Entity\SwProcessoApensado;
use Urbem\CoreBundle\Entity\SwSituacaoProcesso;
use Urbem\CoreBundle\Repository\SwProcessoRepository;

/**
 * Class ApensarType
 *
 * @package Urbem\AdministrativoBundle\Form\Protocolo\Processo
 */
class DesapensarType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var FieldDescription $fieldDescription */
        $fieldDescription = $options['sonata_field_description'];

        /** @var SwProcesso $swProcesso */
        $swProcesso = $fieldDescription->getOption('swProcesso');

        $builder
            ->add('swProcessos', EntityType::class, [
                'attr'          => ['class' => 'select2-parameters ',],
                'class'         => SwProcesso::class,
                'label'         => 'label.processo.apensar.processosDesapensar',
                'multiple'      => true,
                'expanded'      => true,
                'query_builder' => function (SwProcessoRepository $repository) use ($swProcesso) {
                    $queryBuilder = $repository->createQueryBuilder('p');
                    $queryBuilder
                        ->join('p.fkSwProcessoApensados', 'pa')
                        ->where('pa.codProcessoPai = :codProcesso')
                        ->andWhere('pa.exercicioPai = :anoExercicio')
                        ->andWhere('pa.timestampDesapensamento IS NULL')
                        ->setParameters([
                            'codProcesso'  => $swProcesso->getCodProcesso(),
                            'anoExercicio' => $swProcesso->getAnoExercicio()
                        ]);

                    return $queryBuilder;
                },
                'required'      => true,
                'placeholder'   => 'label.selecione'
            ]);
    }
}
