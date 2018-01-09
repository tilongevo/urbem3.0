<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;

class ElaboracaoOrcamentoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\\RegistrosMetasArrecadacaoReceitaView");
    }

    public function getListaMetasArrecadacaoReceita($exercicio, $codEntidade)
    {
        return $this->repository->findListaMetasArrecadacaoReceita($exercicio, $codEntidade);
    }
}
