<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Empenho;

/**
 * Class OrdemItemModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Compras
 */
class OrdemItemModel extends AbstractModel
{
    protected $entityManager;

    /** @var ORM\EntityRepository $repository */
    protected $repository;

    /**
     * OrdemItemModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Compras\OrdemItem::class);
    }

    /**
     * Recupera uma Ordem de Item usando uma Ordem de Compra e um Catalogo Item e Marca.
     *
     * @param Compras\Ordem $ordem
     * @param Almoxarifado\CatalogoItemMarca $catalogoItemMarca
     * @return null|Compras\OrdemItem
     */
    public function findByOrdemAndItemMarca(Compras\Ordem $ordem, Almoxarifado\CatalogoItemMarca $catalogoItemMarca)
    {
        return $this->repository->findOneBy([
            'fkComprasOrdem' => $ordem,
            'fkAlmoxarifadoCatalogoItemMarca' => $catalogoItemMarca
        ]);
    }

    /**
     * @param Compras\Ordem $ordem
     * @param Empenho\ItemPreEmpenho $itemPreEmpenho
     * @return null|Compras\OrdemItem
     */
    public function findByOrdemAndItemPreEmpenho(Compras\Ordem $ordem, Empenho\ItemPreEmpenho $itemPreEmpenho)
    {
        return $this->repository->findOneBy([
            'fkComprasOrdem' => $ordem,
            'fkEmpenhoItemPreEmpenho' => $itemPreEmpenho
        ]);
    }

    /**
     * @param Compras\OrdemItem $ordemItem
     * @param Almoxarifado\CentroCusto $centroCusto
     * @return void
     */
    public function checkAndUpdateItemPreEmpenhoWithCentroCusto(
        Compras\OrdemItem $ordemItem,
        Almoxarifado\CentroCusto $centroCusto
    ) {
        if (true == is_null($ordemItem->getCodCentro())) {
            $ordemItem->setFkAlmoxarifadoCentroCusto($centroCusto);
            $this->save($ordemItem);
        }
    }

    /**
     * @param Compras\OrdemItem $ordemItem
     * @param Almoxarifado\CatalogoItemMarca $catalogoItemMarca
     * @return void
     */
    public function checkAndUpdateItemPreEmpenhoWithCatalogoItemMarca(
        Compras\OrdemItem $ordemItem,
        Almoxarifado\CatalogoItemMarca $catalogoItemMarca
    ) {
        if (true == is_null($ordemItem->getCodItem())) {
            $ordemItem->setFkAlmoxarifadoCatalogoItemMarca($catalogoItemMarca);
            $this->save($ordemItem);
        }
    }
}
