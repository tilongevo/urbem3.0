<?php

namespace Urbem\PrestacaoContasBundle\Form\Type;

use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Compras\Modalidade;

class ModalidadeType extends AbstractType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('label', 'Modalidade');
        $resolver->setDefault('placeholder', 'Selecione');
        $resolver->setDefault('class', Modalidade::class);
        $resolver->setDefault('field_not_in', []);
        $resolver->setDefault('field_in', []);

        $resolver->setNormalizer('query_builder', function (OptionsResolver $resolver) {
            /** @var QueryBuilder $queryBuilder */
            $queryBuilder = $resolver['em']->getRepository($resolver['class'])->createQueryBuilder('Modalidade');
            $queryBuilder->addOrderBy('Modalidade.codModalidade');
            $queryBuilder->addOrderBy('Modalidade.descricao');

            foreach ($resolver['field_not_in'] as $notIn) {
                $notInColumn = sprintf('Modalidade.%s', $notIn['column']);
                $notInValue = $notIn['value'];

                $notInExpr = $queryBuilder->expr()->notIn($notInColumn, $notInValue);

                $queryBuilder->andWhere($notInExpr);
            }

            foreach ($resolver['field_in'] as $in) {
                $inColumn = sprintf('Modalidade.%s', $in['column']);
                $inValue = $in['value'];

                $inExpr = $queryBuilder->expr()->in($inColumn, $inValue);

                $queryBuilder->andWhere($inExpr);
            }

            return $queryBuilder;
        });
    }

    public function getParent()
    {
        return EntityType::class;
    }
}
