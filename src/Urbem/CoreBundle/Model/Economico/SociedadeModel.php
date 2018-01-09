<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\Sociedade;
use Urbem\CoreBundle\Repository\Economico\SociedadeRepository;

/**
 * Class SociedadeModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class SociedadeModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var SociedadeRepository */
    protected $repository = null;

    /**
     * SociedadeModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Sociedade::class);
    }

    /**
     * @param $params
     * @return array
     */
    public function getSociedadeCadastroEconomico($params)
    {
        return $this->repository->getSociedadeCadastroEconomico($params);
    }
}
