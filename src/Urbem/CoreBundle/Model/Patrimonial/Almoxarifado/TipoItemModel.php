<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;

use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Class TipoItemModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class TipoItemModel extends Model
{
    protected $entityManager = null;

    /** @var null|ORM\EntityRepository $repository */
    protected $repository = null;

    /**
     * TipoItemModel constructor.
     * @param ORM\EntityManager $manager
     */
    public function __construct(ORM\EntityManager $manager)
    {
        $this->entityManager = $manager;
        $this->repository = $manager->getRepository(Almoxarifado\TipoItem::class);
    }

    /**
     * @return ORM\QueryBuilder
     */
    public function getTiposItem()
    {
        $queryBuilder = $this->repository->createQueryBuilder('tipoItem');
        $queryBuilder->where('tipoItem.codTipo <> 0');

        return $queryBuilder;
    }

    /**
     * @param $descricao
     * @return null|Almoxarifado\TipoItem
     */
    public function getByDescricao($descricao)
    {
        return $this->repository->findOneBy(['descricao' => $descricao]);
    }
}
