<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\CoreBundle\Entity\Tcemg\CronogramaExecucaoMensalDesembolso;

/**
 * Class ArquivoEmpRepository
 * @package Urbem\CoreBundle\Repository\Tcemg
 */
class ArquivoEmpRepository extends AbstractRepository
{
    /**
     * @return array
     */
    public function getEmpenhos()
    {
        $qb = $this->createQueryBuilder('ae')
            ->select('ae.exercicio', 'ae.codEntidade', 'ae.codEmpenho', 'ae.codLicitacao', 'ae.exercicioLicitacao', 'ae.codModalidade','m.descricao','sc.nomCgm')
            ->join('Urbem\CoreBundle\Entity\Empenho\Empenho', 'e', 'WITH', 'ae.codEmpenho = e.codEmpenho AND ae.codEntidade = e.codEntidade AND ae.exercicio = e.exercicio')
            ->join('Urbem\CoreBundle\Entity\Empenho\PreEmpenho', 'pe', 'WITH', 'e.codPreEmpenho = pe.codPreEmpenho AND e.exercicio = pe.exercicio')
            ->join('Urbem\CoreBundle\Entity\SwCgm', 'sc', 'WITH', 'pe.cgmBeneficiario = sc.numcgm')
            ->join('Urbem\CoreBundle\Entity\Compras\Modalidade', 'm', 'WITH', 'ae.codModalidade = m.codModalidade')
            ->orderBy('ae.exercicio')
            ->addOrderBy('ae.exercicioLicitacao')
            ->addOrderBy('ae.codEmpenho');

        return $qb->getQuery()->getResult();
    }
}
