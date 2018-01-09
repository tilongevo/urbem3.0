<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\Desoneracao;
use Urbem\CoreBundle\Repository\Arrecadacao\DesoneracaoRepository;

/**
 * Class DesoneracaoModel
 * @package Urbem\CoreBundle\Model\Arrecadacao
 */
class DesoneracaoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var DesoneracaoRepository */
    protected $repository = null;

    /**
     * DesoneracaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Desoneracao::class);
    }

    /**
     * @param $params
     * @return int
     */
    public function concederDesoneracaoGrupo($params)
    {
        return $this->repository->concederDesoneracaoGrupo($params);
    }
}
