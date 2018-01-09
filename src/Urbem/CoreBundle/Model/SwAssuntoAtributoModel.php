<?php

namespace Urbem\CoreBundle\Model;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\SwAssunto;

class SwAssuntoAtributoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository('CoreBundle:SwAssuntoAtributo');
    }

    public function getAtributosPorCodAssuntoECodClassificacao($codAssunto, $codClassificacao)
    {
        return $this->repository->getAtributosPorCodAssuntoECodClassificacao($codAssunto, $codClassificacao);
    }
}
