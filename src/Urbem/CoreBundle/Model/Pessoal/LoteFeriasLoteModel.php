<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;

class LoteFeriasLoteModel extends AbstractModel
{
    protected $em = null;
    protected $repository = null;

    /**
     * LoteFeriasLoteModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->repository = $this->em->getRepository("CoreBundle:Pessoal\LoteFeriasLote");
    }

    /**
     * @param $codFerias
     * @return null|object|\Urbem\CoreBundle\Entity\Pessoal\LoteFeriasLote
     */
    public function recuperaLotePorCodFerias($codFerias)
    {
        return $this->repository->findOneBy(['codFerias' => $codFerias]);
    }
}
