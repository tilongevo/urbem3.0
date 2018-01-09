<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfComprovanteRendimento;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoIrrf;

/**
 * Class TabelaIrrfComprovanteRendimentoModel
 * @package Urbem\CoreBundle\Model\Folhapagamento
 */
class TabelaIrrfComprovanteRendimentoModel extends AbstractModel
{
    /** @var ORM\EntityManager|null $entityManager */
    protected $entityManager = null;

    /** @var ORM\EntityRepository|null  */
    protected $repository = null;

    /**
     * TabelaIrrfComprovanteRendimentoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(TabelaIrrfComprovanteRendimento::class);
    }

    /**
     * @param TabelaIrrf $tabelaIrrf
     * @param TabelaIrrfComprovanteRendimento $tabelaIrrfComprovanteRendimento
     * @return TabelaIrrfComprovanteRendimento
     */
    public function buildTabelaIrrfComprovanteRendimento(TabelaIrrf $tabelaIrrf, TabelaIrrfComprovanteRendimento $tabelaIrrfComprovanteRendimento)
    {
        $newTabelaIrrfComprovanteRendimento = new TabelaIrrfComprovanteRendimento();
        $newTabelaIrrfComprovanteRendimento->setCodTabela($tabelaIrrf->getCodTabela());
        $newTabelaIrrfComprovanteRendimento->setTimestamp($tabelaIrrf->getTimestamp());
        $newTabelaIrrfComprovanteRendimento->setFkFolhapagamentoEvento($tabelaIrrfComprovanteRendimento->getFkFolhapagamentoEvento());
        $newTabelaIrrfComprovanteRendimento->setFkFolhapagamentoTabelaIrrf($tabelaIrrf);

        return $newTabelaIrrfComprovanteRendimento;
    }
}
