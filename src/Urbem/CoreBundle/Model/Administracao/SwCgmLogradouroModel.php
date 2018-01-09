<?php

namespace Urbem\CoreBundle\Model\Administracao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;

class SwCgmLogradouroModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Entity\SwCgmLogradouro::class);
    }
    public function findOneBynumcgm($numcgm)
    {
        return $this->repository->findOneBynumcgm($numcgm);
    }

    public function consulta($numcgm)
    {
        return $this->repository->consulta($numcgm);
    }

    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param Entity\SwCgm $swCgm
     * @param bool         $flush
     */
    public function remove($swCgm, $flush = true)
    {
        $swCgmLogradouro = $this->repository->findOneBy([
            'numcgm' => $swCgm
        ]);

        if (!is_null($swCgmLogradouro)) {
            parent::remove($swCgmLogradouro, $flush);
        }
    }
}
