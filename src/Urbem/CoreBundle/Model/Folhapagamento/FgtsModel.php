<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository\AbstractRepository;

class FgtsModel extends AbstractModel
{
    protected $entityManager = null;
    protected $fgtsRepository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->fgtsRepository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\Fgts");
    }

    public function getRecord()
    {
        $return = $this->fgtsRepository->findAll();
        return $return;
    }

    public function getFgtsByCodFgts($codFgts)
    {
        $return = $this->fgtsRepository->findOneByCodFgts($codFgts);
        return $return;
    }

    /**
     * @return int
     */
    public function getNextCodFgts()
    {
        return $this->fgtsRepository->getNextCodFgts('cod_fgts');
    }
}
