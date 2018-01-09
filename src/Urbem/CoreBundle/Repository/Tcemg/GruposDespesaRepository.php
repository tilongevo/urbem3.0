<?php

namespace Urbem\CoreBundle\Repository\Tcemg;

use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\CoreBundle\Entity\Tcemg\CronogramaExecucaoMensalDesembolso;

/**
 * Class GruposDespesaRepository
 * @package Urbem\CoreBundle\Repository\Tcemg
 */
class GruposDespesaRepository extends AbstractRepository
{
    /**
     * * @see gestaoPrestacaoContas/fontes/PHP/TCEMG/classes/mapeamento/TTCEMGCronogramaExecucaoMensalDesembolso.class.php:126
     */
    const PERIODOS = 12;

    /**
     * @see gestaoPrestacaoContas/fontes/PHP/TCEMG/classes/mapeamento/TTCEMGCronogramaExecucaoMensalDesembolso.class.php:126
     * @var array
     */
    private $grupos = [1,2,3,4,5,6];

    /**
     * @param $exercicio
     * @param $entidade
     * @param $orgao
     * @param $unidade
     * @return array
     */
    public function getCronogramaMensalDesembolso($exercicio, $entidade, $orgao, $unidade)
    {
        $result = $this->findCronogramaMensalDesembolso($exercicio, $entidade, $orgao, $unidade);
        if (!count($result)) {
            $this->insertGruposPeriodo($exercicio, $entidade, $orgao, $unidade);

            return $this->findCronogramaMensalDesembolso($exercicio, $entidade, $orgao, $unidade);
        }

        return $result;
    }

    /**
     * @param $exercicio
     * @param $entidade
     * @param $orgao
     * @param $unidade
     * @return array
     */
    public function findCronogramaMensalDesembolso($exercicio, $entidade, $orgao, $unidade)
    {
        $qb = $this->createQueryBuilder('gruposDespesa')
            ->select('gruposDespesa.codGrupo', 'gruposDespesa.descricao','cronem.codEntidade', 'cronem.exercicio', 'cronem.periodo', 'cronem.valor', 'uniorcam.numUnidade', 'uniorcam.numOrgao')
            ->join('Urbem\CoreBundle\Entity\Tcemg\CronogramaExecucaoMensalDesembolso', 'cronem', 'WITH', 'gruposDespesa.codGrupo = cronem.codGrupo')
            ->join('Urbem\CoreBundle\Entity\Tcemg\Uniorcam', 'uniorcam', 'WITH', 'cronem.numUnidade = uniorcam.numUnidade AND cronem.numOrgao = uniorcam.numOrgao AND cronem.exercicio = uniorcam.exercicio')
            ->join('Urbem\CoreBundle\Entity\Orcamento\Orgao', 'orgao', 'WITH', 'uniorcam.numOrgao = orgao.numOrgao AND uniorcam.exercicio = orgao.exercicio')
            ->where('cronem.exercicio = :exercicio')
            ->andWhere('uniorcam.numOrgao = :orgao')
            ->andWhere('cronem.codEntidade = :entidade')
            ->andWhere('uniorcam.numUnidade = :unidade')
            ->groupBy('uniorcam.numOrgao')
            ->addGroupBy('uniorcam.numUnidade')
            ->addGroupBy('gruposDespesa.codGrupo')
            ->addGroupBy('cronem.codEntidade')
            ->addGroupBy('cronem.exercicio')
            ->addGroupBy( 'cronem.valor')
            ->addGroupBy('cronem.periodo')
            ->orderBy('gruposDespesa.codGrupo')
            ->addOrderBy('cronem.periodo')
            ->addOrderBy('uniorcam.numUnidade')
            ->addOrderBy('uniorcam.numOrgao')
            ->setParameters([
                'exercicio' => $exercicio,
                'orgao' => $orgao,
                'entidade' => $entidade,
                'unidade' => $unidade,
            ]);

        return $qb->getQuery()->getResult();
    }

    /**
     * @see gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/OCManterCronogramaExecucaoMensalDesembolso.php:152
     * @see gestaoPrestacaoContas/fontes/PHP/TCEMG/classes/mapeamento/TTCEMGCronogramaExecucaoMensalDesembolso.class.php:126
     *
     * @param $exercicio
     * @param $entidade
     * @param $orgao
     * @param $unidade
     *
     * @return void
     */
    protected function insertGruposPeriodo($exercicio, $entidade, $orgao, $unidade)
    {
        $em = $this->getEntityManager();
        for ($i = 1; $i <= self::PERIODOS; $i++) {
            foreach ($this->grupos as $grupo) {
                $entity = $this->getCronogramaExecucaoMensalDesembolso();
                $entity->setCodGrupo($grupo);
                $entity->setPeriodo($i);
                $entity->setCodEntidade($entidade);
                $entity->setExercicio($exercicio);
                $entity->setNumUnidade($unidade);
                $entity->setNumOrgao($orgao);
                $entity->setValor(0.00);
                $em->persist($entity);
            }
        }
        $em->flush();
    }

    /**
     * @return CronogramaExecucaoMensalDesembolso
     */
    protected function getCronogramaExecucaoMensalDesembolso()
    {
        return new CronogramaExecucaoMensalDesembolso();
    }
}