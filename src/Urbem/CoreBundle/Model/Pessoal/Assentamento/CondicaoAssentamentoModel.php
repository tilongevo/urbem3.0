<?php

namespace Urbem\CoreBundle\Model\Pessoal\Assentamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class CondicaoAssentamentoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager
            ->getRepository("CoreBundle:Pessoal\CondicaoAssentamento");
    }

    /**
     * @param $timestamp
     * @param $codAssentamento
     * @return mixed
     */
    public function getNextCodCondicao($timestamp, $codAssentamento)
    {
        return $this->repository->getNextCodCondicao($timestamp, $codAssentamento);
    }
}
