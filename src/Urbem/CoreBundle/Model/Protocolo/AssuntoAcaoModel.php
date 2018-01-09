<?php

namespace Urbem\CoreBundle\Model\Protocolo;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

class AssuntoAcaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:Protocolo\AssuntoAcao');
    }

    public function getAcoesByCodAssuntoAndCodClassificacao($codAssunto, $codClassificacao)
    {
        return $this->repository->getAcoesByCodAssuntoAndCodClassificacao($codAssunto, $codClassificacao);
    }
}
