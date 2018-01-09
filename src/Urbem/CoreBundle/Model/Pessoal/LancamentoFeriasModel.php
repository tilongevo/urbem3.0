<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\Pessoal\LancamentoFeriasRepository;

class LancamentoFeriasModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var LancamentoFeriasRepository|null */
    protected $repository = null;

    /**
     * LancamentoFeriasModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Pessoal\LancamentoFerias");
    }

    /**
     * @param $codFerias
     * @return array
     */
    public function recuperaLancamentoFerias($codFerias, $filtro = null)
    {
        return $this->repository->recuperaLancamentoFerias($codFerias, $filtro);
    }

    /**
     * @param $codFerias
     * @return null|object|\Urbem\CoreBundle\Entity\Pessoal\LancamentoFerias
     */
    public function recuperaLancamentoPorCodFerias($codFerias)
    {
        return $this->repository->findOneBy([
            'codFerias' => $codFerias
        ]);
    }
}
