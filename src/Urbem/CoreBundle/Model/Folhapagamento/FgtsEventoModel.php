<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\FgtsEventoRepository;

class FgtsEventoModel extends AbstractModel
{
    protected $entityManager = null;
    /**
     * @var FgtsEventoRepository|null
     */
    protected $fgtsEventoRepository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->fgtsEventoRepository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\FgtsEvento");
    }

    public function getFgtsByCodFgts($codFgts)
    {
        $return = $this->fgtsEventoRepository->findByCodFgts($codFgts);

        return $return;
    }

    /**
     * @param Entity\Folhapagamento\Fgts           $fgts
     * @param Entity\Folhapagamento\Evento         $evento
     * @param Entity\Folhapagamento\TipoEventoFgts $tipoEventoFgts
     *
     * @return Entity\Folhapagamento\FgtsEvento
     */
    public function saveFgtsEvento(Entity\Folhapagamento\Fgts $fgts, Entity\Folhapagamento\Evento $evento, Entity\Folhapagamento\TipoEventoFgts $tipoEventoFgts)
    {
        $fgtsEvento = new Entity\Folhapagamento\FgtsEvento();
        $fgtsEvento->setFkFolhapagamentoFgts($fgts);
        $fgtsEvento->setFkFolhapagamentoEvento($evento);
        $fgtsEvento->setFkFolhapagamentoTipoEventoFgts($tipoEventoFgts);
        $this->save($fgtsEvento);

        return $fgtsEvento;
    }

    /**
     * @param $stFiltro
     *
     * @return mixed
     */
    public function recuperaRelacionamento($stFiltro = false)
    {
        return $this->fgtsEventoRepository->recuperaRelacionamento($stFiltro);
    }
}
