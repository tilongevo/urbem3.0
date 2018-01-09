<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras;

class OrdemAnulacaoModel
{
    private $entityManager = null;
    protected $repository = null;

    /**
     * OrdemAnulacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\OrdemAnulacao::class);
    }

    /**
     * Persiste o OrdemAnulacao
     *
     * @param Compras\OrdemAnulacao $ordemAnulacao
     * @return Compras\OrdemAnulacao $ordemAnulacao
     */
    public function persistOrdemAnulacao($ordemAnulacao)
    {
        $paramsOrdem = [];
        $paramsOrdem['exercicio'] = $ordemAnulacao->getExercicio();
        $paramsOrdem['codEntidade'] = $ordemAnulacao->getCodEntidade();
        $paramsOrdem['codOrdem'] = $ordemAnulacao->getCodOrdem();
        $paramsOrdem['tipo'] = $ordemAnulacao->getTipo();

        $ordem = $this->entityManager
            ->getRepository(Compras\Ordem::class)
            ->findOneBy($paramsOrdem);

        $ordemAnulacao->setFkComprasOrdem($ordem);

        return $ordemAnulacao;
    }
}
