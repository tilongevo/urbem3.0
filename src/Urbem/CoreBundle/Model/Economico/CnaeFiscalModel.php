<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CnaeFiscal;
use Urbem\CoreBundle\Repository\Economico\CadastroEconomicoRepository;
use Urbem\CoreBundle\Repository\Economico\CnaeFiscalRepository;

/**
 * Class CadastroEconomicoModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class CnaeFiscalModel extends AbstractModel
{
    protected $entityManager;

    /** @var CnaeFiscalRepository */
    protected $repository;

    /**
     * CadastroEconomicoModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(CnaeFiscal::class);
    }

    public function findCnaeFiscal($codCnae = false)
    {
        return $this->repository->findCnaeFiscal($codCnae);
    }
}
