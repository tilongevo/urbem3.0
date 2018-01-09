<?php

namespace Urbem\CoreBundle\Model\Estagio;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagio;
use Urbem\CoreBundle\Entity\Estagio\EstagiarioEstagioBolsa;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;

class EstagiarioEstagioBolsaModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * InterfaceModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param EstagiarioEstagio $estagio
     * @param $faltas
     * @return EstagiarioEstagioBolsa
     */
    public function saveEstagiarioEstagioBolsa(EstagiarioEstagio $estagio, $faltas, $vlBolsa)
    {
        $periodoMovimentacao = new PeriodoMovimentacaoModel($this->entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();

        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $estagioBolsa = new EstagiarioEstagioBolsa();
        $estagioBolsa
            ->setFkEstagioEstagiarioEstagio($estagio)
            ->setFkFolhapagamentoPeriodoMovimentacao($periodoFinal)
            ->setVlBolsa($vlBolsa)
            ->setFaltas($faltas)
            ->setValeRefeicao(false)
            ->setValeTransporte(false);

        $this->save($estagioBolsa);

        return $estagioBolsa;
    }
}
