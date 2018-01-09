<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico;

/**
 * Class ResponsavelTecnicoModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class ResponsavelTecnicoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * ResponsavelTecnicoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ResponsavelTecnico::class);
    }

    /**
     * @param $codProfissao
     */
    public function getProfissao($codProfissao)
    {
        $repository = $this->entityManager->getRepository('CoreBundle:Cse\\Profissao');
        return $repository->findOneByCodProfissao($codProfissao);
    }

    /**
     * @param $codUf
     * @return mixed
     */
    public function getUf($codUf)
    {
        $repository = $this->entityManager->getRepository('CoreBundle:SwUf');
        return $repository->findOneByCodUf($codUf);
    }

    /**
     * @param $codProfissao
     * @return mixed
     */
    public function getConselhoClasse($codConselho)
    {
        $repository = $this->entityManager->getRepository('CoreBundle:Cse\\Conselho');
        return $repository->findOneByCodConselho($codConselho);
    }

    /**
     * @param $numCgm
     * @return mixed
     */
    public function getResponsavelTecnico($numCgm)
    {
        return $this->repository->findBy(['numcgm' => $numCgm]);
    }

    /**
     * @param $numCgm
     * @param $codProfissao
     * @return array
     */
    public function getResponsavelTecnicoAndCodProfissao($numCgm, $codProfissao)
    {
        return $this->repository->findBy(['numcgm' => $numCgm, 'codProfissao' => $codProfissao]);
    }
}
