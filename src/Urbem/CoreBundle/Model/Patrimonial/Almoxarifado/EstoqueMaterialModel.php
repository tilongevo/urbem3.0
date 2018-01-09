<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;

class EstoqueMaterialModel extends AbstractModel
{
    protected $entityManager;

    /** @var \Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\InventarioRepository $repository */
    protected $repository;

    /**
     * InventarioModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado\EstoqueMaterial::class);
    }

    /**
     * @param int $item
     * @param int $marca
     * @param int $centroCusto
     * @param int $almoxarifado
     * @return Almoxarifado\EstoqueMaterial
     */
    public function findOrCreateEstoqueMaterial($item, $marca, $centroCusto, $almoxarifado)
    {
        /** @var Almoxarifado\EstoqueMaterial $estoqueMaterial */
        $estoqueMaterial = $this->findEstoqueMaterial($item, $marca, $centroCusto, $almoxarifado);

        if (is_null($estoqueMaterial)) {
            $estoqueMaterial = new Almoxarifado\EstoqueMaterial();
            $estoqueMaterial->setCodItem($item);
            $estoqueMaterial->setCodMarca($marca);

            $catalogoItemMarcaModel = new CatalogoItemMarcaModel($this->entityManager);
            $catalogoItemMarca = $catalogoItemMarcaModel->findOrCreateCatalogoItemMarca($item, $marca);

            $estoqueMaterial->setFkAlmoxarifadoCatalogoItemMarca($catalogoItemMarca);
            $estoqueMaterial->setCodCentro($centroCusto);
            $estoqueMaterial->setCodAlmoxarifado($almoxarifado);

            $this->save($estoqueMaterial);
        }

        return $estoqueMaterial;
    }

    /**
     * @param $item
     * @param $marca
     * @param $centroCusto
     * @param $almoxarifado
     * @return Almoxarifado\EstoqueMaterial|null
     */
    public function findEstoqueMaterial($item, $marca, $centroCusto, $almoxarifado)
    {
        /** @var Almoxarifado\EstoqueMaterial $estoqueMaterial */
        $estoqueMaterial = $this->repository->find([
            'codItem' => $item,
            'codMarca' => $marca,
            'codCentro' => $centroCusto,
            'codAlmoxarifado' => $almoxarifado
        ]);

        return $estoqueMaterial;
    }
}
