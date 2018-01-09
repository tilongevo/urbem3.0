<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Compras\Cotacao;

/**
 * Class CotacaoItemModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Compras
 */
class CotacaoItemModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * OrdemModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\CotacaoItem::class);
    }

    /**
     * @param $codCotacao
     * @return Compras\CotacaoItem|null
     */
    public function findOne($codCotacao)
    {
        /** @var Compras\CotacaoItem|null $cotacaoItem */
        $cotacaoItem = $this->repository->find($codCotacao);

        return $cotacaoItem;
    }

    /**
     * @param $exercicio
     * @param Cotacao $cotacao
     * @param $lote
     * @param CatalogoItem $catalogoItem
     * @param $qtdItem
     * @return Compras\CotacaoItem
     */
    public function findOrCreateCotacaoItem($exercicio, Cotacao $cotacao, $lote, CatalogoItem $catalogoItem, $qtdItem)
    {
        /** @var Compras\CotacaoItem $cotacaoItem */
        $cotacaoItem = $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codCotacao' => $cotacao->getCodCotacao(),
            'lote' => $lote,
            'codItem' => $catalogoItem->getCodItem()
        ]);

        if (is_null($cotacaoItem)) {
            /** @var Compras\CotacaoItem $cotacaoItem */
            $cotacaoItem = new Compras\CotacaoItem();
            $cotacaoItem->setFkAlmoxarifadoCatalogoItem($catalogoItem);
            $cotacaoItem->setExercicio($exercicio);
            $cotacaoItem->setFkComprasCotacao($cotacao);
            $cotacaoItem->setLote($lote);
            $cotacaoItem->setQuantidade($qtdItem);
            $this->save($cotacaoItem);
        }

        return $cotacaoItem;
    }
}
