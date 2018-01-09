<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;

use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\FaixaDescontoIrrf;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;

/**
 * Class FaixaDescontoIrrfModel
 * @package Urbem\CoreBundle\Model\Folhapagamento
 */
class FaixaDescontoIrrfModel extends AbstractModel
{
    /** @var ORM\EntityManager|null $entityManager */
    protected $entityManager = null;

    /** @var ORM\EntityRepository|null  */
    protected $repository = null;

    /**
     * FaixaDescontoIrrfModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(FaixaDescontoIrrf::class);
    }

    /**
     * @return mixed
     */
    public function getProximoCodFaixa()
    {
        return $this->repository->getProximoCodFaixa();
    }

    /**
     * @param $codTabela
     * @param $timestamp
     * @param null $codFaixa
     * @return mixed
     */
    public function getPrevOrLastCodFaixa($codTabela, $timestamp, $codFaixa = null)
    {
        if (!is_string($timestamp)) {
            $timestamp = $timestamp->format('Y-m-d H:i:s.u');
        }
        $query = $this->repository->createQueryBuilder('fd');
        $query = $query
            ->where('fd.codTabela = :codTabela')
            ->andWhere('fd.timestamp = :timestamp')
            ->setParameter('timestamp', $timestamp)
            ->setParameter('codTabela', $codTabela);
        if (!is_null($codFaixa)) {
            $query = $query
                ->andWhere('fd.codFaixa < :codFaixa')
                ->setParameter('codFaixa', $codFaixa);
        }
        $query = $query
            ->setMaxResults(1)
            ->orderBy('fd.codFaixa', 'DESC')
            ->getQuery();
        return $query->getOneOrNullResult();
    }

    /**
     * @param $codTabela
     * @param $timestamp
     * @param $codFaixa
     * @return mixed
     */
    public function getNextCodFaixa($codTabela, $timestamp, $codFaixa)
    {
        if (!is_string($timestamp)) {
            $timestamp = $timestamp->format('Y-m-d H:i:s.u');
        }
        $query = $this->repository->createQueryBuilder('fd')
            ->where('fd.codTabela = :codTabela')
            ->andWhere('fd.timestamp = :timestamp')
            ->setParameter('timestamp', $timestamp)
            ->setParameter('codTabela', $codTabela)
            ->andWhere('fd.codFaixa > :codFaixa')
            ->setParameter('codFaixa', $codFaixa)
            ->setMaxResults(1)
            ->orderBy('fd.codFaixa', 'ASC')
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * @param TabelaIrrf $tabelaIrrf
     * @param FaixaDescontoIrrf $faixaDescontoIrrf
     * @return FaixaDescontoIrrf
     */
    public function buildFaixaDescontoIrrf(TabelaIrrf $tabelaIrrf, FaixaDescontoIrrf $faixaDescontoIrrf)
    {
        $newFaixaDescontoIrrf = new FaixaDescontoIrrf();
        $newFaixaDescontoIrrf->setCodTabela($tabelaIrrf->getCodTabela());
        $newFaixaDescontoIrrf->setTimestamp($tabelaIrrf->getTimestamp());
        $newFaixaDescontoIrrf->setAliquota($faixaDescontoIrrf->getAliquota());
        $newFaixaDescontoIrrf->setCodFaixa($this->getProximoCodFaixa());
        $newFaixaDescontoIrrf->setParcelaDeduzir($faixaDescontoIrrf->getParcelaDeduzir());
        $newFaixaDescontoIrrf->setVlFinal($faixaDescontoIrrf->getVlFinal());
        $newFaixaDescontoIrrf->setVlInicial($faixaDescontoIrrf->getVlInicial());
        $newFaixaDescontoIrrf->setFkFolhapagamentoTabelaIrrf($tabelaIrrf);

        return $newFaixaDescontoIrrf;
    }
}
