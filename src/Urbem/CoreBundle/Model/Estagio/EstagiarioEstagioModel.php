<?php

namespace Urbem\CoreBundle\Model\Estagio;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Repository\RecursosHumanos\Estagio\EstagiarioEstagioRepository;

class EstagiarioEstagioModel extends AbstractModel
{
    protected $entityManager = null;
    /**
     * @var EstagiarioEstagioRepository|null
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Estagio\\EstagiarioEstagio");
    }

    /**
     * @return array
     */
    public function montaRecuperaRelacionamento()
    {
        return $this->repository->montaRecuperaRelacionamento();
    }

    /**
     * @param $numcgm
     * @return array
     */
    public function montaRecuperaInstituicoesDaEntidade($numcgm)
    {
        return $this->repository->montaRecuperaInstituicoesDaEntidade($numcgm);
    }

    /**
     * @param $numCgm
     * @return array
     */
    public function montaRecuperaGrausDeInstituicaoEnsino($numCgm)
    {
        return $this->repository->montaRecuperaGrausDeInstituicaoEnsino($numCgm);
    }

    /**
     * @param $numCgm
     * @param $codGrau
     * @return array
     */
    public function montaRecuperarCursos($numCgm, $codGrau)
    {
        return $this->repository->montaRecuperarCursos($numCgm, $codGrau);
    }

    /**
     * @param $param
     * @return int
     */
    public function getNextCodConfiguracao($param)
    {
        return $this->repository->getNextCodConfiguracao($param);
    }
}
