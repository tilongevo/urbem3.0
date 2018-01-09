<?php

namespace Urbem\CoreBundle\Model\Contabilidade;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class EncerramentoMesModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    const TYPE_SITUACAO_FECHADO = 'F';
    const TYPE_SITUACAO_ABERTO = 'A';

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Contabilidade\\EncerramentoMes");
    }

    public function getMesesEncerrados($params)
    {
        return $this->repository->getMesesEncerrados($params);
    }

    public function getMesesReabertos($params)
    {
        return $this->repository->getMesesReabertos($params);
    }
}
