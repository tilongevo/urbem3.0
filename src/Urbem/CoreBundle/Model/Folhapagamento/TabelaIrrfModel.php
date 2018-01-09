<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;

use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfCid;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Repository\Folhapagamento\TabelaIrrfRepository;

/**
 * Class TabelaIrrfModel
 * @package Urbem\CoreBundle\Model\Folhapagamento
 */
class TabelaIrrfModel extends AbstractModel
{
    /** @var ORM\EntityManager|null $entityManager */
    protected $entityManager = null;

    /** @var \Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\TabelaIrrfRepository|null  */
    protected $repository = null;

    /**
     * TabelaIrrfModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(TabelaIrrf::class);
    }

    /**
     * @param $timestamp
     * @return mixed
     */
    public function getProximoCodTabela($timestamp)
    {
        return $this->repository->getProximoCodTabela($timestamp);
    }

    /**
     * @return mixed
     */
    public function getTabelaIrrfYear()
    {
        return $this->repository->getTabelaIrrfYear();
    }

    /**
     * @return mixed
     */
    public function montaRecuperaUltimaVigencia()
    {
        return $this->repository->montaRecuperaUltimaVigencia();
    }

    /**
     * @param TabelaIrrf $tabelaIrrf
     * @return TabelaIrrf
     */
    public function cloneTabelaIrrf(TabelaIrrf $tabelaIrrf)
    {
        $timestamp = new DateTimeMicrosecondPK();
        $codTabela = $this->getProximoCodTabela($timestamp);
        /** @var TabelaIrrf $newTabelaIrrf */
        $newTabelaIrrf = clone($tabelaIrrf);
        $newTabelaIrrf->setCodTabela($codTabela);
        $newTabelaIrrf->setTimestamp($timestamp);
        $newTabelaIrrf->setVigencia($tabelaIrrf->getVigencia());
        $newTabelaIrrf->setVlDependente($tabelaIrrf->getVlDependente());
        $newTabelaIrrf->setVlLimiteIsencao($tabelaIrrf->getVlLimiteIsencao());

        foreach ($tabelaIrrf->getFkFolhapagamentoFaixaDescontoIrrfs() as $faixaDescontoIrrf) {
            $faixaDescontoIrrfModel = new FaixaDescontoIrrfModel($this->entityManager);
            $buildTabelaIrrfCid = $faixaDescontoIrrfModel->buildFaixaDescontoIrrf($newTabelaIrrf, $faixaDescontoIrrf);
            $newTabelaIrrf->addFkFolhapagamentoFaixaDescontoIrrfs($buildTabelaIrrfCid);
        }

        foreach ($tabelaIrrf->getFkFolhapagamentoTabelaIrrfEventos() as $tabelaIrrfEventos) {
            $tabelaIrrfEventoModel = new TabelaIrrfEventoModel($this->entityManager);
            $buildTabelaIrrfEventoModel = $tabelaIrrfEventoModel->buildTabelaIrrfEventoModel($newTabelaIrrf, $tabelaIrrfEventos);
            $newTabelaIrrf->addFkFolhapagamentoTabelaIrrfEventos($buildTabelaIrrfEventoModel);
        }

        /** @var TabelaIrrfCid $tabelaIrrfCids */
        foreach ($tabelaIrrf->getFkFolhapagamentoTabelaIrrfCids() as $tabelaIrrfCids) {
            $tabelaIrrfCidModel = new TabelaIrrfCidModel($this->entityManager);
            $buildTabelaIrrfCid = $tabelaIrrfCidModel->buildTabelaIrrfCid($newTabelaIrrf, $tabelaIrrfCids);
            $newTabelaIrrf->addFkFolhapagamentoTabelaIrrfCids($buildTabelaIrrfCid);
        }

        foreach ($tabelaIrrf->getFkFolhapagamentoTabelaIrrfComprovanteRendimentos() as $tabelaIrrfComprovanteRendimentos) {
            $tabelaIrrfComprovanteRendimentoModel = new TabelaIrrfComprovanteRendimentoModel($this->entityManager);
            $buildTabelaIrrfComprovanteRendimento = $tabelaIrrfComprovanteRendimentoModel->buildTabelaIrrfComprovanteRendimento($newTabelaIrrf, $tabelaIrrfComprovanteRendimentos);
            $newTabelaIrrf->addFkFolhapagamentoTabelaIrrfComprovanteRendimentos($buildTabelaIrrfComprovanteRendimento);
        }
        return $newTabelaIrrf;
    }
}
