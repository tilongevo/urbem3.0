<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Doctrine\ORM\Query;

class PeriodoMovimentacaoSituacaoModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\PeriodoMovimentacaoSituacao");
    }

    public function findAllByCodPeriodoMovimentacao($codPeriodoMovimentacao)
    {
        $return = $this->repository->findByCodPeriodoMovimentacao($codPeriodoMovimentacao);
        return $return;
    }

    public function deleteByMovimentacaoSituacao(Entity\Beneficio\PeriodoMovimentacaoSituacao $periodoMovimentacaoSituacao)
    {
        $em = $this->entityManager;
        $em->remove($periodoMovimentacaoSituacao);
        $em->flush();
    }

    public function proc($dtInicial, $dtFinal, $stExercicio)
    {
        $em = $this->entityManager;
        $qb = $em->createNativeQuery(
            'public.abrirperiodomovimentacao (' .
            ':dtInicial, :dtFinal, :stExercicio' .
            ')',
            new ResultSetMapping()
        );
        $qb->setParameters(
            array(
                'dtInicial' => $dtInicial,
                'dtFinal' => $dtFinal,
                'stExercicio' => $stExercicio
            )
        );
            $qb->execute();
            $em->flush();
    }
}
