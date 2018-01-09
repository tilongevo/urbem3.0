<?php

namespace Urbem\CoreBundle\Model\Imobiliario;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelFoto;

class ImovelFotoModel extends AbstractModel
{
    /**
     * @var ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ORM\EntityRepository
     */
    protected $repository;

    /**
     * NivelModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ImovelFoto::class);
    }

    /**
     * @param int $inscricaoMunicipal
     * @return int
     */
    public function getNextVal($inscricaoMunicipal)
    {
        return $this->repository->getNextVal($inscricaoMunicipal);
    }
}
