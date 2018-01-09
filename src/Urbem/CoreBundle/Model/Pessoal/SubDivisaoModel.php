<?php

namespace Urbem\CoreBundle\Model\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;

class SubDivisaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(SubDivisao::class);
    }

    /**
     * @param $paramsWhere
     */
    public function getSubDivisoesDisponiveisJson($paramsWhere)
    {
        return $this->repository->getSubDivisoesDisponiveisJson($paramsWhere);
    }

    /**
     * Retorna os dados de subdivisao por regime
     * @param $codRegime
     * @return array
     */
    public function consultaSubDivisaoRegime($codRegime, $sonata = false)
    {
        $subdivisoes = $this->repository->findByCodRegime($codRegime);

        $results = [];
        foreach ($subdivisoes as $subdivisao) {
            if (! $sonata) {
                $results[] = [
                    'id' => $subdivisao->getCodSubDivisao(),
                    'descricao' => $subdivisao->getCodSubDivisao() . " - " . $subdivisao->getDescricao()
                ];
            } else {
                $results[$subdivisao->getCodSubDivisao() . " - " . $subdivisao->getDescricao()] = $subdivisao->getCodSubDivisao();
            }
        }
        
        return $results;
    }
}
