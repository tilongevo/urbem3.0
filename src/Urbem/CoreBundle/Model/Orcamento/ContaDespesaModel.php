<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Orcamento;

class ContaDespesaModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var \Doctrine\ORM\EntityRepository|\Urbem\CoreBundle\Repository\Orcamento\ContaDespesaRepository */
    protected $repository = null;

    /**
     * ContaDespesaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager
            ->getRepository(Orcamento\ContaDespesa::class);
    }

    /**
     * @param string        $exercicio
     * @param string        $mascaraReduzida
     *      Exemplo: '3.3.9.0.30'
     * @param null|string   $notThisCodEstrutural
     *      Exemplo: '3.3.9.0.30.00.00.00.00'
     *
     * @return array [] {
     *      @option string "cod_estrutural"
     *      @option string "cod_conta"
     *      @option string "mascara_reduzida"
     *      @option string "descricao"
     * }
     */
    public function getListaCodEstruturalDespesa($exercicio, $mascaraReduzida, $notThisCodEstrutural = null)
    {
        return $this->repository->getListaCodEstruturalDespesa($exercicio, $mascaraReduzida, $notThisCodEstrutural);
    }

    /**
     * @param string $exercicio
     * @return \Doctrine\ORM\QueryBuilder $queryBuilder
     */
    public function getListaDeContasDepesas($exercicio)
    {
        $codContas = [];
        foreach ($this->getListaCodEstruturalDespesa($exercicio, '3.3.9.0.30', '3.3.9.0.30.00.00.00.00') as $desdobramento) {
            $codContas[] = $desdobramento['cod_conta'];
        }

        $codContas = (empty($codContas) ? 0 : $codContas);
        
        $queryBuilder = $this->repository->createQueryBuilder('contaDespesa');
        $queryBuilder
            ->where($queryBuilder->expr()->in('contaDespesa.codConta', ':codContas'))
            ->andWhere('contaDespesa.exercicio = :exercicio')
            ->setParameters([
                'codContas' => $codContas,
                'exercicio' => $exercicio
            ])
        ;

        return $queryBuilder;
    }
}
