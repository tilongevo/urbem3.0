<?php

namespace Urbem\CoreBundle\Model\Estagio;

use Doctrine\ORM;
use Urbem\CoreBundle\Model;

class InstituicaoEnsinoModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Estagio\\CursoInstituicaoEnsino");
    }

    public function canRemove($object)
    {
        $entidadeIntermediadoraRepository = $this->entityManager->getRepository("CoreBundle:Estagio\\EntidadeIntermediadora");
        $res_ei = $entidadeIntermediadoraRepository->findOneBy(['numcgm' => $object->getNumcgm()]);

        $estagiarioEstagioRepository = $this->entityManager->getRepository("CoreBundle:Estagio\\EstagiarioEstagio");
        $res_ee = $estagiarioEstagioRepository->findOneBy(['cgmInstituicaoEnsino' => $object->getNumcgm()]);

        return is_null($res_ei) && is_null($res_ee);
    }

    public function getInstituicoesEnsino()
    {
        return $this->repository->getInstituicaoEnsino();
    }
}
