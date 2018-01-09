<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;

use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfCid;

/**
 * Class TabelaIrrfCidModel
 * @package Urbem\CoreBundle\Model\Folhapagamento
 */
class TabelaIrrfCidModel extends AbstractModel
{
    /** @var ORM\EntityManager|null $entityManager */
    protected $entityManager = null;

    /** @var ORM\EntityRepository|null  */
    protected $repository = null;

    /**
     * TabelaIrrfCidModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(TabelaIrrfCid::class);
    }

    /**
     * @param TabelaIrrf $tabelaIrrf
     * @param TabelaIrrfCid $tabelaIrrfCids
     * @return TabelaIrrfCid
     */
    public function buildTabelaIrrfCid(TabelaIrrf $tabelaIrrf, TabelaIrrfCid $tabelaIrrfCids)
    {
        $tabelaIrrfCid = new TabelaIrrfCid();
        $tabelaIrrfCid->setCodTabela($tabelaIrrf->getCodTabela());
        $tabelaIrrfCid->setTimestamp($tabelaIrrf->getTimestamp());
        $tabelaIrrfCid->setFkFolhapagamentoTabelaIrrf($tabelaIrrf);
        $tabelaIrrfCid->setFkPessoalCid($tabelaIrrfCids->getFkPessoalCid());

        return $tabelaIrrfCid;
    }
}
