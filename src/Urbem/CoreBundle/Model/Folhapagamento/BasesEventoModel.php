<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

class BasesEventoModel extends AbstractModel
{
    /**
     * @var EntityManager|null
     */
    protected $entityManager = null;
    
    /**
     * @var BasesEventoRepository|null
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\BasesEvento");
    }
    
    /**
     * Retorna um array com eventos atrelados a uma base
     * @param  integer $codBase
     * @return array
     */
    public function getBasesEventoByCodBase($codBase)
    {
        $eventos = $this->repository->findByCodBase($codBase);
        
        $eventosArray = array();
        foreach ($eventos as $evento) {
            $eventosArray[] = $evento->getCodEvento();
        }
        
        return $eventosArray;
    }
}
