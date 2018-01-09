<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\Pessoal\LoteFeriasRepository;

class LoteFeriasModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var LoteFeriasRepository | object */
    protected $repository = null;

    /**
     * LoteFeriasModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\LoteFerias");
    }

    /**
     * @param $codLote
     * @return null|object|\Urbem\CoreBundle\Entity\Pessoal\LoteFerias
     */
    public function recuperaLoteFeriasPorCodigoLote($codLote)
    {
        return $this->repository->findOneBy(['codLote' => $codLote]);
    }
}
