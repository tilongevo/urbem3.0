<?php

namespace Urbem\CoreBundle\Repository\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\Orgao;
use Urbem\CoreBundle\Entity\Orcamento\Unidade;
use Urbem\CoreBundle\Entity\Stn\TipoVinculoRecurso;
use Urbem\CoreBundle\Entity\Stn\VinculoRecurso;
use Urbem\CoreBundle\Entity\Stn\VinculoStnRecurso;

/**
 * Class RecursoRepository
 * @package Urbem\CoreBundle\Repository\Orcamento
 */
class RecursoRepository extends ORM\EntityRepository
{
    /**
     * @param array $paramsWhere
     * @param null $paramsExtra
     * @return array
     */
    public function findRecurso(array $paramsWhere, $paramsExtra = null)
    {
        $sql = sprintf(
            "SELECT * FROM orcamento.recurso WHERE %s",
            implode(" AND ", $paramsWhere)
        );
        $sql .= $paramsExtra ? " ".$paramsExtra : "";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $exercicio
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function withExercicioQueryBuilder($exercicio)
    {
        $qb = $this->createQueryBuilder('r');
        $qb->where('r.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);
        $qb->orderBy('r.exercicio', 'ASC');
        $qb->addOrderBy('r.codRecurso', 'ASC');

        return $qb;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $unidade
     * @param $orgao
     * @return array
     */
    public function findRecursoFundeb($exercicio, $codEntidade, $unidade, $orgao)
    {
        $sql = "SELECT *
	                FROM orcamento.recurso
	                WHERE  recurso.exercicio = '{$exercicio}' 
                        AND EXISTS ( SELECT 1
                             FROM orcamento.despesa
                            WHERE despesa.cod_entidade = {$codEntidade}
                              AND despesa.num_unidade  = {$unidade}
                              AND despesa.num_orgao    = {$orgao}
                              AND despesa.cod_recurso = recurso.cod_recurso
                              AND despesa.exercicio   = recurso.exercicio
	                                     )
	                ORDER BY recurso.cod_recurso";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $unidade
     * @param $orgao
     * @param $recurso
     * @return array
     */
    public function findAcao($exercicio, $codEntidade, $unidade, $orgao, $recurso)
    {
        $qb = $this->createQueryBuilder('recurso')
            ->select('recurso.exercicio', 'recurso.codRecurso', 'recurso.codFonte', 'recurso.nomRecurso', 'acao.numAcao', 'dados.codAcao', 'dados.exercicio', 'dados.titulo')
            ->innerJoin('Urbem\CoreBundle\Entity\Orcamento\Despesa', 'despesa', 'WITH', 'despesa.codRecurso = recurso.codRecurso AND despesa.exercicio = recurso.exercicio')
            ->innerJoin('Urbem\CoreBundle\Entity\Orcamento\ContaDespesa', 'conta', 'WITH', 'conta.codConta = despesa.codConta AND conta.exercicio = despesa.exercicio')
            ->innerJoin('Urbem\CoreBundle\Entity\Orcamento\PaoPpaAcao', 'oacao', 'WITH', 'oacao.numPao = despesa.numPao AND oacao.exercicio = despesa.exercicio')
            ->innerJoin('Urbem\CoreBundle\Entity\Ppa\Acao', 'acao', 'WITH', 'oacao.codAcao = acao.codAcao AND despesa.codPrograma = acao.codPrograma AND acao.ativo = TRUE')
            ->innerJoin('Urbem\CoreBundle\Entity\Ppa\AcaoDados', 'dados', 'WITH', 'acao.codAcao = dados.codAcao AND acao.ultimoTimestampAcaoDados = dados.timestampAcaoDados')
            ->where('recurso.exercicio = :exercicio')
            ->andWhere('despesa.codEntidade = :codEntidade')
            ->andWhere('despesa.numUnidade = :unidade')
            ->andWhere('despesa.numOrgao = :orgao')
            ->andWhere('recurso.codRecurso = :recurso')
            ->setParameters([
                'exercicio' => $exercicio,
                'codEntidade' => $codEntidade,
                'unidade' => $unidade,
                'orgao' => $orgao,
                'recurso' => $recurso,
            ])
            ->groupBy('recurso.exercicio')
            ->addGroupBy('recurso.codRecurso')
            ->addGroupBy('recurso.codFonte')
            ->addGroupBy('recurso.nomRecurso')
            ->addGroupBy('acao.numAcao')
            ->addGroupBy('dados.codAcao')
            ->addGroupBy('dados.exercicio')
            ->addGroupBy('dados.titulo')
            ->orderBy('recurso.codRecurso')
            ->addOrderBy('acao.numAcao');

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $exercicio
     * @param array $filters
     * @return array
     */
    public function getRecursosByCodVinculo($exercicio, $filters = [])
    {
        $sql = sprintf("SELECT   vinculo_recurso.exercicio
	                        ,   vinculo_recurso.cod_entidade
	                        ,   vinculo_recurso.num_orgao
	                        ,   vinculo_recurso.num_unidade
	                        ,   recurso.cod_recurso
	                        ,   recurso.nom_recurso
	                        ,   vinculo_recurso.cod_vinculo
	                        ,   vinculo_recurso.cod_tipo
	                        ,   acao.cod_acao
	                        ,   acao.num_acao
	                        ,   acao_dados.titulo AS nom_acao
	                        ,   vinculo_recurso_acao.cod_tipo_educacao
	                     FROM   stn.vinculo_recurso
	               INNER JOIN   orcamento.recurso
	                       ON   recurso.exercicio = vinculo_recurso.exercicio
	                      AND   recurso.cod_recurso = vinculo_recurso.cod_recurso
	                LEFT JOIN   stn.vinculo_recurso_acao
	                       ON   vinculo_recurso_acao.exercicio = vinculo_recurso.exercicio
	                      AND   vinculo_recurso_acao.cod_entidade = vinculo_recurso.cod_entidade
	                      AND   vinculo_recurso_acao.num_orgao = vinculo_recurso.num_orgao
	                      AND   vinculo_recurso_acao.num_unidade = vinculo_recurso.num_unidade
	                      AND   vinculo_recurso_acao.cod_recurso = vinculo_recurso.cod_recurso
	                      AND   vinculo_recurso_acao.cod_vinculo = vinculo_recurso.cod_vinculo
	                      AND   vinculo_recurso_acao.cod_tipo = vinculo_recurso.cod_tipo
	                LEFT JOIN   ppa.acao
	                       ON   acao.cod_acao = vinculo_recurso_acao.cod_acao
	                      AND   acao.ativo = TRUE
	                LEFT JOIN   ppa.acao_dados
	                       ON   acao.cod_acao = acao_dados.cod_acao
	                      AND   acao.ultimo_timestamp_acao_dados = acao_dados.timestamp_acao_dados
	                    WHERE   true  AND vinculo_recurso.exercicio = '%s' %s ORDER BY vinculo_recurso.cod_entidade, vinculo_recurso.num_orgao, vinculo_recurso.num_unidade, recurso.cod_recurso
	                   ", $exercicio, $this->getFilters($filters));

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param array $filters
     * @return string
     */
    protected function getFilters($filters = [])
    {
        $queryFilter = "";
        foreach ($filters as $column => $value) {
            $queryFilter .= " AND vinculo_recurso.{$column} = {$value} ";
        }

        return $queryFilter;
    }

    /**
     * gestaoPrestacaoContas/fontes/PHP/STN/instancias/configuracao/OCManterRecurso.php:282
     *
     * @param Entidade $entidade
     * @param Unidade $unidade
     * @param Orgao $orgao
     * @return ORM\QueryBuilder
     */
    public function getRecursoOutrasDespesasVinculoOperacoesCreditoAsQueryBuilder(Entidade $entidade, Unidade $unidade)
    {
        $qb = $this->createQueryBuilder('Recurso');

        $notExitsQueryBuilder = $this->createQueryBuilder('_not_Recurso');
        $notExitsQueryBuilder->join('_not_Recurso.fkStnVinculoRecursos', 'VinculoRecurso');
        $notExitsQueryBuilder->andWhere('VinculoRecurso.codEntidade = :codEntidade');
        $notExitsQueryBuilder->andWhere('VinculoRecurso.exercicio = :exercicio');
        $notExitsQueryBuilder->andWhere('VinculoRecurso.numUnidade = :numUnidade ');
        $notExitsQueryBuilder->andWhere('VinculoRecurso.numOrgao = :numOrgao');
        $notExitsQueryBuilder->andWhere('VinculoRecurso.codTipo = :codTipo');

        $notExitsQueryBuilder->join('VinculoRecurso.fkStnVinculoStnRecurso', 'VinculoStnRecurso');
        $notExitsQueryBuilder->andWhere('VinculoStnRecurso.codVinculo = :codVinculo');

        $qb->andWhere($qb->expr()->not($qb->expr()->exists($notExitsQueryBuilder)));

        $qb->join('Recurso.fkOrcamentoDespesas', 'Despesa');
        $qb->andWhere('Despesa.codEntidade = :codEntidade');
        $qb->andWhere('Despesa.exercicio = :exercicio');
        $qb->andWhere('Despesa.numUnidade = :numUnidade');
        $qb->andWhere('Despesa.numOrgao = :numOrgao');

        $qb->setParameter('codEntidade', $entidade->getCodEntidade());
        $qb->setParameter('exercicio', $entidade->getExercicio());
        $qb->setParameter('numUnidade', $unidade->getNumUnidade());
        $qb->setParameter('numOrgao', $unidade->getNumOrgao());
        $qb->setParameter('codVinculo', VinculoStnRecurso::COD_VINCULO_OPERACOES_DE_CREDITO);
        $qb->setParameter('codTipo', TipoVinculoRecurso::COD_TIPO_RECURSOS_OUTRAS_DESPESAS);

        $qb->addGroupBy('Recurso.exercicio');
        $qb->addGroupBy('Recurso.codRecurso');

        return $qb;
    }
}