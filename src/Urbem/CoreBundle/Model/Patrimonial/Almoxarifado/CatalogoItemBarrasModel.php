<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemBarras;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca;

/**
 * Class CatalogoItemBarrasModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class CatalogoItemBarrasModel extends AbstractModel
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
        $this->repository = $this->entityManager->getRepository(CatalogoItemBarras::class);
    }

    /**
     * @param CatalogoItemMarca $catalogoItemMarca
     * @param string            $codigoBarras
     * @return null|CatalogoItemBarras
     */
    public function findOrCreateCatalogoItemBarras(CatalogoItemMarca $catalogoItemMarca, $codigoBarras)
    {
        /** @var CatalogoItemBarras $catalogoItemMarca */
        $calogoItemBarras = $this->repository->findOneBy([
            'fkAlmoxarifadoCatalogoItemMarca' => $catalogoItemMarca,
            'codigoBarras' => $codigoBarras
        ]);

        if (is_null($calogoItemBarras)) {
            $calogoItemBarras = new CatalogoItemBarras();
            $calogoItemBarras->getFkAlmoxarifadoCatalogoItemMarca($catalogoItemMarca);
            $calogoItemBarras->setCodigoBarras($codigoBarras);

            $this->save($catalogoItemMarca);
        }

        return $calogoItemBarras;
    }
}
