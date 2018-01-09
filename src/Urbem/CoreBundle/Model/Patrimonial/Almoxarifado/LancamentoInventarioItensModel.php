<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;

class LancamentoInventarioItensModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * @var EntityRepository $repository
     */
    protected $repository = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado\LancamentoInventarioItens::class);
    }

    /**
     * @param Almoxarifado\InventarioItens $inventarioItens
     * @param Almoxarifado\LancamentoMaterial $lancamentoMaterial
     * @return Almoxarifado\LancamentoInventarioItens
     * @deprecated
     */
    public function buildOne(Almoxarifado\InventarioItens $inventarioItens, Almoxarifado\LancamentoMaterial $lancamentoMaterial)
    {
        $lancamentoInventarioItens = new Almoxarifado\LancamentoInventarioItens();
        $lancamentoInventarioItens->setFkAlmoxarifadoInventarioItens($inventarioItens);
        $lancamentoInventarioItens->setFkAlmoxarifadoLancamentoMaterial($lancamentoMaterial);

        return $lancamentoInventarioItens;
    }

    /**
     * @param Almoxarifado\InventarioItens $inventarioItens
     * @param Almoxarifado\LancamentoMaterial $lancamentoMaterial
     * @return null|object|Almoxarifado\LancamentoInventarioItens
     */
    public function findOrCreateInventarioItens(Almoxarifado\InventarioItens $inventarioItens, Almoxarifado\LancamentoMaterial $lancamentoMaterial)
    {
        $lancamentoInventarioItens = $this->repository->findOneBy([
            'exercicio' => $inventarioItens->getExercicio(),
            'codAlmoxarifado' => $inventarioItens->getCodAlmoxarifado(),
            'codInventario' => $inventarioItens->getCodInventario(),
            'codItem' => $inventarioItens->getCodItem(),
            'codCentro' => $inventarioItens->getCodCentro(),
            'codMarca' => $inventarioItens->getCodMarca()
        ]);

        if (is_null($lancamentoInventarioItens)) {
            $lancamentoInventarioItens = new Almoxarifado\LancamentoInventarioItens();
            $lancamentoInventarioItens->setFkAlmoxarifadoInventarioItens($inventarioItens);
            $lancamentoInventarioItens->setFkAlmoxarifadoLancamentoMaterial($lancamentoMaterial);
        }

        return $lancamentoInventarioItens;
    }
}
