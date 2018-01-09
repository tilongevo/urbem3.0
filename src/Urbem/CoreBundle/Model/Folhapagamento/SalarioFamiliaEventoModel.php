<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\Folhapagamento\SalarioFamiliaEventoRepository;

class SalarioFamiliaEventoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var SalarioFamiliaEventoRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\SalarioFamiliaEvento");
    }

    /**
     * @param bool $filtro
     *
     * @return array
     */
    public function recuperaRelacionamento($filtro = false)
    {
        return $this->repository->recuperaRelacionamento($filtro);
    }
}
