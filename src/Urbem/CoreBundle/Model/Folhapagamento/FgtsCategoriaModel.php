<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;

class FgtsCategoriaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $fgtsCategoriaRepository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->fgtsCategoriaRepository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\FgtsCategoria");
    }

    /**
     * @param $codFgts
     * @return mixed
     */
    public function getFgtsByCodFgts($codFgts)
    {
        $return = $this->fgtsCategoriaRepository->findByCodFgts($codFgts);
        return $return;
    }
}
