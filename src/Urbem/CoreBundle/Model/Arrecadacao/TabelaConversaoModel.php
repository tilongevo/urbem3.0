<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\TabelaConversao;
use Urbem\CoreBundle\Repository\Arrecadacao\TabelaConversaoRepository;

/**
 * Class TabelaConversaoModel
 * @package Urbem\CoreBundle\Model\Arrecadacao
 */
class TabelaConversaoModel extends AbstractModel
{
    protected $entityManager = null;

    /**
     * @var TabelaConversaoRepository $repository
     */
    protected $repository = null;

    /**
     * TabelaConversaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(TabelaConversao::class);
    }

    /**
     * @return mixed
     */
    public function getNextVal($exercicio)
    {
        return $this->repository->getNextVal($exercicio);
    }

    /**
     * @param $params
     * @return mixed
     */
    public function getTabelaConversaoJson($params)
    {
        return $this->repository->getTabelaConversaoJson($params);
    }
}
