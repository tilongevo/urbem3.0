<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\Pessoal\EspecialidadeSubDivisaoRepository;

class EspecialidadeSubDivisaoModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * @var EspecialidadeSubDivisaoRepository
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\\EspecialidadeSubDivisao");
    }

    public function getEspecialidadeSubDivisaoPorTimestamp($info, $codEspecialidade)
    {
        return $this->repository->getEspecialidadeSubDivisaoPorTimestamp($info, $codEspecialidade);
    }

    public function getVagasOcupadasEspecialidade($codRegime, $codSubDivisao, $codEspecialidade)
    {
        return $this->repository->getVagasOcupadasEspecialidade($codRegime, $codSubDivisao, $codEspecialidade);
    }
}
