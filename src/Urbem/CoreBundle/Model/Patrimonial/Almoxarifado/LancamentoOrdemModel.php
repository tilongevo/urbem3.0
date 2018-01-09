<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoOrdem;
use Urbem\CoreBundle\Entity\Compras\OrdemItem;

/**
 * Class LancamentoOrdemModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class LancamentoOrdemModel extends AbstractModel
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
        $this->repository = $entityManager->getRepository(LancamentoOrdem::class);
    }

    /**
     * Procura ou cria uma Lançamento de Ordem de Compra do Item usando
     * uma Ordem de Compra de Item e um Lancamento de Material
     *
     * @param LancamentoMaterial $lancamentoMaterial
     * @param OrdemItem          $ordemItem
     * @return null|LancamentoOrdem
     */
    public function findOrCreateLancamentoOrdem(LancamentoMaterial $lancamentoMaterial, OrdemItem $ordemItem)
    {
        $lancamentoOrdem = $this->repository->findOneBy([
            'fkAlmoxarifadoLancamentoMaterial' => $lancamentoMaterial,
            'fkComprasOrdemItem' => $ordemItem
        ]);

        if (true == is_null($lancamentoOrdem)) {
            $lancamentoOrdem = new LancamentoOrdem();
            $lancamentoOrdem->setFkAlmoxarifadoLancamentoMaterial($lancamentoMaterial);
            $lancamentoOrdem->setFkComprasOrdemItem($ordemItem);

            $this->save($lancamentoOrdem);
        }

        return $lancamentoOrdem;
    }
}
