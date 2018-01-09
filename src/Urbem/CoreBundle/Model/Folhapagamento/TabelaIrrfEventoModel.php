<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrf;
use Urbem\CoreBundle\Entity\Folhapagamento\TabelaIrrfEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoIrrf;

/**
 * Class TabelaIrrfEventofModel
 * @package Urbem\CoreBundle\Model\Folhapagamento
 */
class TabelaIrrfEventoModel extends AbstractModel
{
    /** @var ORM\EntityManager|null $entityManager */
    protected $entityManager = null;

    /** @var ORM\EntityRepository|null  */
    protected $repository = null;

    /**
     * TabelaIrrEventofModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(TabelaIrrfEvento::class);
    }

    /**
     * @param TipoEventoIrrf $tipoEventoIrrf
     * @param TabelaIrrf $tabelaIrrf
     * @param Evento $evento
     * @param null $timestamp
     */
    public function buildOneBasedTabelaIrrf(TipoEventoIrrf $tipoEventoIrrf, TabelaIrrf $tabelaIrrf, Evento $evento, $timestamp = null)
    {
        if (is_null($timestamp)) {
            $tabelaIrrfEvento = new TabelaIrrfEvento();
        } else {
            $codTabela = $tabelaIrrf->getCodTabela();
            $codTipo = $tipoEventoIrrf->getCodTipo();
            $find = ['timestamp' => $timestamp, 'codTipo' => $codTipo, 'codTabela' => $codTabela];
            $tabelaIrrfEvento = $this->entityManager->getRepository(TabelaIrrfEvento::class)->findOneBy($find);
        }

        $tabelaIrrfEvento->setFkFolhapagamentoTipoEventoIrrf($tipoEventoIrrf);
        $tabelaIrrfEvento->setFkFolhapagamentoTabelaIrrf($tabelaIrrf);
        $tabelaIrrfEvento->setFkFolhapagamentoEvento($evento);

        $this->save($tabelaIrrfEvento);
    }

    /**
     * @param TabelaIrrf $tabelaIrrf
     * @param TabelaIrrfEvento $tabelaIrrfEvento
     * @return TabelaIrrfEvento
     */
    public function buildTabelaIrrfEventoModel(TabelaIrrf $tabelaIrrf, TabelaIrrfEvento $tabelaIrrfEvento)
    {
        $newTabelaIrrfEvento = new TabelaIrrfEvento();
        $newTabelaIrrfEvento->setCodTabela($tabelaIrrf->getCodTabela());
        $newTabelaIrrfEvento->setTimestamp($tabelaIrrf->getTimestamp());
        $newTabelaIrrfEvento->setCodTipo($tabelaIrrfEvento->getCodTipo());
        $newTabelaIrrfEvento->setFkFolhapagamentoEvento($tabelaIrrfEvento->getFkFolhapagamentoEvento());
        $newTabelaIrrfEvento->setFkFolhapagamentoTipoEventoIrrf($tabelaIrrfEvento->getFkFolhapagamentoTipoEventoIrrf());
        $newTabelaIrrfEvento->setFkFolhapagamentoTabelaIrrf($tabelaIrrf);

        return $newTabelaIrrfEvento;
    }
}
