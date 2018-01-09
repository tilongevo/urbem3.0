<?php

namespace Urbem\CoreBundle\Model\Contabilidade;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Model;

class ValorLancamentoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    const VALOR_INICIAL = 1;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Contabilidade\\ValorLancamento");
    }

    /**
     * @param $sequencia
     * @param $codLote
     * @param $tipo
     * @param $exercicio
     * @param $codEntidade
     * @param $tipoValor
     * @return null|object
     */
    public function getOneValorLancamento($sequencia, $codLote, $tipo, $exercicio, $codEntidade, $tipoValor)
    {
        $valorLancamento = $this->repository->findOneBy([
            'sequencia'=> $sequencia,
            'codLote'=> $codLote,
            'tipo'=> $tipo,
            'exercicio'=> $exercicio,
            'codEntidade'=> $codEntidade,
            'tipoValor'=> $tipoValor
        ]);

        return $valorLancamento;
    }

    /**
     * @return int
     */
    public function getOidLancamento()
    {
        $qb = $this->repository->createQueryBuilder('o');
        $qb->select('MAX(o.oidLancamento)');
        $oidLancamento = $qb->getQuery()->getSingleScalarResult();
        return $oidLancamento ? $oidLancamento : self::VALOR_INICIAL;
    }
}
