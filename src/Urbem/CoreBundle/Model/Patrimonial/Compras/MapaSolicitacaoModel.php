<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\AbstractModel;

/**
 * Class MapaSolicitacaoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Compras
 */
class MapaSolicitacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * MapaSolicitacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\MapaSolicitacao::class);
    }

    /**
     * @param $codMapa
     * @param $exercicio
     * @return null|object
     */
    public function getOneMapaSolicitacao($codMapa, $exercicio)
    {
        return $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codMapa' => $codMapa,
        ]);
    }

    /**
     * @param $exercicio
     * @param $codSolicitacao
     * @param $codEntidade
     * @return mixed
     */
    public function montaRecuperaSolicitacoesMapaCompras($exercicio, $codSolicitacao, $codEntidade)
    {
        return $this->repository->montaRecuperaSolicitacoesMapaCompras($exercicio, $codSolicitacao, $codEntidade);
    }
}
