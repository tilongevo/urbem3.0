<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\ParametroCalculo;
use Urbem\CoreBundle\Repository\Arrecadacao\ParametroCalculoRepository;

/**
 * Class ParametroCalculoModel
 * @package Urbem\CoreBundle\Model\Arrecadacao
 */
class ParametroCalculoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var ParametroCalculoRepository  */
    protected $repository = null;

    /**
     * ParametroCalculoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ParametroCalculo::class);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getNextVal($params)
    {
        return $this->repository->getNextVal($params);
    }
}
