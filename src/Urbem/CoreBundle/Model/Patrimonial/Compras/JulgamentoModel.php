<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Repository\Patrimonio\Compras\JulgamentoRepository;

/**
 * Class JulgamentoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Compras
 */
class JulgamentoModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var JulgamentoRepository|null $repository */
    protected $repository = null;

    /**
     * JulgamentoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\Julgamento::class);
    }

    /**
     * @param $codCotacao
     * @param $exercicio
     * @return mixed
     */
    public function removeJulgamento($codCotacao, $exercicio)
    {
        return $this->repository->removeJulgamento($codCotacao, $exercicio);
    }

    /**
     * @param Compras\Cotacao $cotacao
     * @return Compras\Julgamento
     */
    public function findOne(Compras\Cotacao $cotacao)
    {
        /** @var Compras\Julgamento $julgamento */
        $julgamento = $this->repository->find([
            'exercicio' => $cotacao->getExercicio(),
            'codCotacao' => $cotacao->getCodCotacao()
        ]);

        return $julgamento;
    }
}
