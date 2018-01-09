<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Folhapagamento\Padrao;

/**
 * Class PadraoModel
 * @package Urbem\CoreBundle\Model\Folhapagamento
 */
class PadraoModel
{
    private $entityManager = null;
    private $padraoRepository = null;

    /**
     * PadraoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->padraoRepository = $this->entityManager->getRepository(Padrao::class);
    }

    /**
     * @param $codPadrao
     * @return mixed
     */
    public function getPadraoByCodPadrao($codPadrao)
    {
        $return = $this->padraoRepository->findOneByCodPadrao($codPadrao);
        return $return;
    }

    /**
     * @return mixed
     */
    public function getPadraoFilter()
    {
        $return = $this->padraoRepository->getPadraoFilter();
        return $return;
    }
}
