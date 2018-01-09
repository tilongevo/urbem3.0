<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoManutencaoFrota;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Frota\Manutencao;

/**
 * Class LancamentoManutencaoFrotaModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class LancamentoManutencaoFrotaModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var EntityRepository $repository */
    protected $repository = null;

    /**
     * LancamentoManutencaoFrotaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(LancamentoManutencaoFrota::class);
    }

    /**
     * @param LancamentoMaterial $lancamentoMaterial
     * @param Manutencao         $manutencao
     * @return LancamentoManutencaoFrota
     */
    public function buildOne(LancamentoMaterial $lancamentoMaterial, Manutencao $manutencao)
    {
        $lancamentoManutencaoFrota = new LancamentoManutencaoFrota();
        $lancamentoManutencaoFrota->setFkAlmoxarifadoLancamentoMaterial($lancamentoMaterial);
        $lancamentoManutencaoFrota->setFkFrotaManutencao($manutencao);

        $this->save($lancamentoManutencaoFrota);

        return $lancamentoManutencaoFrota;
    }
}
