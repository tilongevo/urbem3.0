<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Entity\Patrimonio\Bem;
use Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem;
use Urbem\CoreBundle\Entity\Patrimonio\Inventario;
use Urbem\CoreBundle\Entity\Patrimonio\InventarioHistoricoBem;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\Patrimonio\HistoricoBemRepository;

/**
 * Class InventarioHistoricoBemModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Patrimonio
 */
class InventarioHistoricoBemModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * InventarioHistoricoBemModel constructor.
     *
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(InventarioHistoricoBem::class);
    }

    /**
     * @param InventarioHistoricoBem $inventarioHistorico
     * @param Bem $bem
     * @param Orgao $orgao
     * @param Inventario $inventario
     * @return null|object|InventarioHistoricoBem
     */
    public function findOrCreateInventarioHistoricoBem(InventarioHistoricoBem $inventarioHistorico, Bem $bem, Orgao $orgao, Inventario $inventario)
    {
        $inventarioHistoricoBem = $this->repository->findOneBy([
            'exercicio' => $inventario->getExercicio(),
            'idInventario' => $inventario->getIdInventario(),
            'codBem' => $bem->getCodBem()
        ]);

        if ($inventarioHistoricoBem) {
            $this->entityManager->remove($inventarioHistoricoBem);
            $this->entityManager->flush();
        }

        $inventarioHistoricoBem = new InventarioHistoricoBem();

        $inventarioHistoricoBem->setDescricao($inventarioHistorico->getDescricao());
        $inventarioHistoricoBem->setCodOrgao($inventarioHistorico->getCodOrgao());
        $inventarioHistoricoBem->setCodLocal($inventarioHistorico->getCodLocal());
        $inventarioHistoricoBem->setCodSituacao($inventarioHistorico->getCodSituacao());
        $inventarioHistoricoBem->setFkPatrimonioBem($bem);
        $inventarioHistoricoBem->setFkPatrimonioSituacaoBem($inventarioHistorico->getCodSituacao());
        $inventarioHistoricoBem->setTimestamp(new DateTimeMicrosecondPK());
        $inventarioHistoricoBem->setFkOrganogramaLocal($inventarioHistorico->getCodLocal());
        $inventarioHistoricoBem->setExercicio($inventario->getExercicio());
        $inventarioHistoricoBem->setIdInventario($inventario->getIdInventario());
        $inventarioHistoricoBem->setFkOrganogramaOrgao($orgao);
        $inventarioHistoricoBem->setFkPatrimonioInventario($inventario);
        $inventarioHistoricoBem->setFkPatrimonioHistoricoBem($bem->getFkPatrimonioHistoricoBens()->last());

        $this->entityManager->persist($inventarioHistoricoBem);
        $this->entityManager->flush();


        return $inventarioHistoricoBem;
    }

    /**
     * Busca todos os Patrimonio\HistoricoBem usando os códigos de
     *  Organograma\Orgao e Organograma\Local
     *
     * @param Orgao $orgao
     * @param Local $local
     *
     * @return array
     */
    public function getHistoricoBemWithLocalAndOrgao(Orgao $orgao, Local $local)
    {
        /** @var HistoricoBemRepository $historicoBemRepository */
        $historicoBemRepository = $this->entityManager->getRepository(HistoricoBem::class);

        return $historicoBemRepository
            ->getHistoricoBemWithLocalAndOrgao($orgao->getCodOrgao(), $local->getCodLocal());
    }
}
