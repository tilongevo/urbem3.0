<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

class ContratoServidorInicioProgressaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\ContratoServidorInicioProgressao");
    }

    /**
     * @param $codContrato
     * @return mixed
     */
    public function consultaDataInicioProgressaoMaxTimestamp($codContrato)
    {
        return $this->repository->consultaDataInicioProgressaoMaxTimestamp($codContrato);
    }
}
