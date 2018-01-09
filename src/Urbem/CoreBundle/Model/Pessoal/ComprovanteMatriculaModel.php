<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\Entity\Pessoal\ComprovanteMatricula;

class ComprovanteMatriculaModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ComprovanteMatricula::class);
    }

    /**
     * @param $codComprovanteMatricula
     * @param $flag
     */
    public function alteraFlagApresentada($codComprovanteMatricula, $flag)
    {
        $comprovante = $this->repository->findOneBy(['codComprovante' => $codComprovanteMatricula]);
        $comprovante
            ->setApresentada($flag);

        $this->entityManager->persist($comprovante);
        $this->entityManager->flush();
    }
}
