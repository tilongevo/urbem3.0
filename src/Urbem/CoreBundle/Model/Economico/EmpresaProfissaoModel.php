<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\EmpresaProfissao;

/**
 * Class EmpresaProfissaoModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class EmpresaProfissaoModel extends AbstractModel
{

    /**
     * EmpresaProfissaoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(EmpresaProfissao::class);
    }

    /**
     * @param $empresaProfissao
     * @return mixed
     */
    public function findByCodProfissao($empresaProfissao)
    {
        return $this->repository->findByCodProfissao($empresaProfissao);
    }

    /**
     * @param $empresaProfissao
     */
    public function save($empresaProfissao)
    {
        $this->entityManager->persist($empresaProfissao);
        $this->entityManager->flush();
    }
}
