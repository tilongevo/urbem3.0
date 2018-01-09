<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\AbstractModel;

class CotacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * OrdemModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\Cotacao::class);
    }

    /**
     * @param int $codCotacao
     * @return Compras\Cotacao|null
     */
    public function getCotacao($codCotacao, $exercicio)
    {
        /** @var Compras\Cotacao|null $cotacao */
        $cotacao = $this->repository->findOneBy([
            'codCotacao' => $codCotacao,
            'exercicio' => $exercicio,
        ]);
        return $cotacao;
    }

    public function getProximoCodCotacao($exercicio)
    {
        return $this->repository->getProximoCodCotacao($exercicio);
    }
}
