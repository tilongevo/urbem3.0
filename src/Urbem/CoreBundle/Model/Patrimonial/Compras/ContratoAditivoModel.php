<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Model;

class ContratoAditivoModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Licitacao\\ContratoAditivos");
    }

    public function canRemove($object)
    {
    }

    public function recuperaRelacionamentoVinculado($stTabelaVinculo, $stCampoVinculo, $filtroVinculo)
    {
        return $this->repository->recuperaRelacionamentoVinculado($stTabelaVinculo, $stCampoVinculo, $filtroVinculo);
    }
}
