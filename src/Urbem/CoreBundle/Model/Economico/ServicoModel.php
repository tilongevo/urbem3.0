<?php

namespace Urbem\CoreBundle\Model\Economico;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\Servico;

/**
 * Class ServicoModel
 * @package Urbem\CoreBundle\Model\Economico
 */
class ServicoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * ServicoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Servico::class);
    }

    /**
     * @param $codEstrutural
     * @return mixed
     */
    public function getServicoByCodEstrutural($codEstrutural)
    {
        return $this->repository->findOneByCodEstrutural($codEstrutural);
    }

    /**
     * @param $codServico
     * @return mixed
     */
    public function getServicoByCodServico($codServico)
    {
        return $this->repository->findOneByCodServico($codServico);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getServicoByCodAndVigencia(array $params)
    {
        return $this->repository->getServicoByCodAndVigencia($params);
    }
}
