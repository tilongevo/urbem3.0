<?php

namespace Urbem\AdministrativoBundle\Form\Protocolo\Processo;

use Sonata\DoctrineORMAdminBundle\Admin\FieldDescription;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Entity\SwSituacaoProcesso;
use Urbem\CoreBundle\Repository\SwProcessoRepository;

/**
 * Class ApensarType
 *
 * @package Urbem\AdministrativoBundle\Form\Protocolo\Processo
 */
class ApensarType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var FieldDescription $fieldDescription */
        $fieldDescription = $options['sonata_field_description'];

        /** @var SwProcesso $swProcessoAtual */
        $swProcessoAtual = $fieldDescription->getOption('swProcesso');

        /** @var Orgao $orgao */
        $orgao = $fieldDescription->getOption('orgao');

        $builder
            ->add('swProcessos', EntityType::class, [
                'attr'          => ['class' => 'select2-parameters ',],
                'class'         => SwProcesso::class,
                'label'         => 'label.processo.apensar.processosApensar',
                'multiple'      => true,
                'expanded' => true,
                'query_builder' => function (SwProcessoRepository $repository) use ($swProcessoAtual, $orgao) {
                    $results = $repository->getProcessosFilhosApensar(
                        $swProcessoAtual->getAnoExercicio(),
                        $swProcessoAtual->getCodProcesso(),
                        $orgao->getCodOrgao(),
                        SwSituacaoProcesso::EM_ANDAMENTO_RECEBIDO
                    );

                    $codigos = [];
                    foreach ($results as $arrayKey => $result) {
                        $codigos[$arrayKey] = $result['ano_exercicio'] . $result['cod_processo'];
                    }

                    $codigos = empty($codigos) ? 0 : $codigos;

                    $queryBuilder = $repository->createQueryBuilder('p');
                    $queryBuilder
                        ->where(
                            $queryBuilder->expr()->in(
                                $queryBuilder->expr()->concat('p.anoExercicio', 'p.codProcesso'),
                                $codigos
                            )
                        );

                    return $queryBuilder;
                },
                'required'      => true,
                'placeholder'   => 'label.selecione'
            ]);
    }
}
