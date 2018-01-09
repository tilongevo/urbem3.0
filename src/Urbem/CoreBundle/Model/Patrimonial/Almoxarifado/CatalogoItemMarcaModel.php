<?php
/**
 * Created by PhpStorm.
 * User: gabrielvie
 * Date: 03/10/16
 * Time: 17:41
 */

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Class CatalogoItemMarcaModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class CatalogoItemMarcaModel extends AbstractModel
{
    protected $entityManager;
    protected $repository;

    /**
     * CatalogoItemMarcaModel constructor.
     *
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado\CatalogoItemMarca::class);
    }

    /**
     * @param int $catalogoItem
     * @param int $marca
     * @return null|Almoxarifado\CatalogoItemMarca
     */
    public function findOrCreateCatalogoItemMarca($catalogoItem, $marca)
    {
        $catalogoItemMarca = $this->findCatalogoItemMarca($catalogoItem, $marca);
        if (is_null($catalogoItemMarca)) {
            $catalogoItemMarca = new Almoxarifado\CatalogoItemMarca();
            $catalogoItemMarca->setCodItem($catalogoItem);
            if (is_object($marca)) {
                $catalogoItemMarca->setFkAlmoxarifadoMarca($marca);
            } else {
                $catalogoItemMarca->setCodMarca($marca);
            }
            $this->entityManager->persist($catalogoItemMarca);
        }

        return $catalogoItemMarca;
    }

    /**
     * @param $catalogoItem
     * @param $marca
     * @return null|object|Almoxarifado\CatalogoItemMarca
     */
    public function findCatalogoItemMarca($catalogoItem, $marca)
    {
        if (is_object($marca)) {
            $marca = $marca->getCodMarca();
        }
        return $this->repository->findOneBy([
            'codItem' => $catalogoItem,
            'codMarca' => $marca
        ]);
    }
}
