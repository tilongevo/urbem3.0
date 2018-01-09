<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;

use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Class ControleEstoqueModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class ControleEstoqueModel extends Model
{
    protected $entityManager = null;

    /** @var null|ORM\EntityRepository $repository */
    protected $repository = null;

    /**
     * ControleEstoqueModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado\ControleEstoque::class);
    }

    /**
     * @param Almoxarifado\CatalogoItem $catalogoItem
     * @param array $params
     * @return Almoxarifado\ControleEstoque
     */
    public function createOrUpdateWithCatalogoItem(Almoxarifado\CatalogoItem $catalogoItem, array $params = [])
    {
        /** @var Almoxarifado\ControleEstoque $controleEstoque */
        $controleEstoque = $this->repository->find($catalogoItem->getCodItem());

        if (is_null($controleEstoque)) {
            $controleEstoque = new Almoxarifado\ControleEstoque();
        }

        foreach ($params as $key => $value) {
            $setMethod = sprintf('set%s', ucfirst($key));

            if (method_exists($controleEstoque, $setMethod)) {
                $controleEstoque->{$setMethod}($value);
            }
        }

        $catalogoItem->setFkAlmoxarifadoControleEstoque($controleEstoque);

        $this->save($controleEstoque);

        return $controleEstoque;
    }
}
