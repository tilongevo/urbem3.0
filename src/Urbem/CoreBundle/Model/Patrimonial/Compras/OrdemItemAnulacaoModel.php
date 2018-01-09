<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras;

class OrdemItemAnulacaoModel
{
    private $entityManager = null;
    protected $repository = null;

    /**
     * OrdemItemAnulacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Compras\OrdemItemAnulacao::class);
    }

    /**
     * Persiste o OrdemItemAnulacao
     *
     * @param Compras\OrdemAnulacao $ordemAnulacao
     * @return Compras\OrdemAnulacao $ordemAnulacao
     */
    public function persistOrdemItemAnulacao($ordemAnulacao)
    {
        $paramsOrdem = [];
        $paramsOrdem['exercicio'] = $ordemAnulacao->getExercicio();
        $paramsOrdem['codEntidade'] = $ordemAnulacao->getCodEntidade();
        $paramsOrdem['codOrdem'] = $ordemAnulacao->getCodOrdem();
        $paramsOrdem['tipo'] = $ordemAnulacao->getTipo();

        $ordemItens = $this->entityManager
            ->getRepository(Compras\OrdemItem::class)
            ->findBy($paramsOrdem);

        foreach ($ordemItens as $ordemItem) {
            /** @var Compras\OrdemItem $ordemItem */
            $ordemItemAnulacao = new Compras\OrdemItemAnulacao();
            $ordemItemAnulacao->setFkComprasOrdemItem($ordemItem);
            $ordemItemAnulacao->setFkComprasOrdemAnulacao($ordemAnulacao);
            $ordemItemAnulacao->setQuantidade($ordemItem->getQuantidade());
            $ordemItemAnulacao->setVlTotal($ordemItem->getVlTotal());
            $ordemAnulacao->addFkComprasOrdemItemAnulacoes($ordemItemAnulacao);
        }

        return $ordemAnulacao;
    }
}
