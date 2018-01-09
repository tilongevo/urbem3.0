<?php

namespace Urbem\PrestacaoContasBundle\Form\Type;

use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Urbem\CoreBundle\Entity\Compras\TipoObjeto;

class TipoObjetoType extends AbstractType
{
    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('class', TipoObjeto::class);

        $resolver->setNormalizer('query_builder', function (OptionsResolver $resolver, $queryBuilder) {
            /** @var QueryBuilder $queryBuilder */
            $queryBuilder = $resolver['em']->getRepository($resolver['class'])->createQueryBuilder('TipoObjeto');
            $queryBuilder->addOrderBy('TipoObjeto.codTipoObjeto');

            return $queryBuilder;
        });
    }

    public function getParent()
    {
        return EntityType::class;
    }
}
