<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Urbem\CoreBundle\AbstractModel;
use Doctrine\ORM;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\ConfiguracaoEventosDescontoExternoRepository;

class ConfiguracaoEventosDescontoExternoModel extends AbstractModel
{
    protected $entityManager = null;
    /**
     * @var ConfiguracaoEventosDescontoExternoRepository|null
     */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\ConfiguracaoEventosDescontoExterno");
    }

    /**
     * @return int
     */
    public function getNextCodConfiguracao()
    {
        return $this->repository->getNextCodConfiguracao();
    }
}
