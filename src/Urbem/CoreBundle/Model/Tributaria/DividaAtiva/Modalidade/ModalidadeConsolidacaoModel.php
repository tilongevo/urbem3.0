<?php

namespace Urbem\CoreBundle\Model\Tributaria\DividaAtiva\Modalidade;

use Doctrine\ORM\EntityManager;

class ModalidadeConsolidacaoModel extends ModalidadeCustomModel
{
    const MODALIDADE = 2;

    /**
     * AutoridadeModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
    }

    /**
     * @param $codModalidade
     * @param $descricao
     * @param $queryBuilder
     * @param $alias
     */
    public function findModalidades($codModalidade, $descricao, $queryBuilder, $alias)
    {
        parent::findModalidadesBusca($codModalidade, $descricao, self::MODALIDADE, $queryBuilder, $alias);
    }

    /**
     * @param $object
     * @param $request
     * @param $childrens
     */
    public function prePersist($object, $request, $childrens)
    {
        parent::prePersistCustom($object, $request, $childrens, self::MODALIDADE);
    }
}
