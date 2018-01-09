<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;

class DecimoEventoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $eventoRepository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->eventoRepository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\DecimoEvento");
    }

    /**
     * @param Entity\Folhapagamento\TipoEventoDecimo $tipoEvento
     * @param Entity\Folhapagamento\Evento $evento
     */
    public function buildOneDecimoEvento(Entity\Folhapagamento\TipoEventoDecimo $tipoEvento, Entity\Folhapagamento\Evento $evento)
    {
        $decimoEvento = new Entity\Folhapagamento\DecimoEvento();
        $decimoEvento->setFkFolhapagamentoEvento($evento);
        $decimoEvento->setFkFolhapagamentoTipoEventoDecimo($tipoEvento);
        $this->save($decimoEvento);
    }
}
