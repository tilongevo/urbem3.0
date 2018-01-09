<?php

namespace Urbem\CoreBundle\Repository\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Helper\MascaraHelper;
use Urbem\CoreBundle\Repository\AbstractRepository;

class ReceitaRepository extends AbstractRepository
{
    public function getReceitasByExercicio($exercicio)
    {
        $sql = sprintf(
            "SELECT
                CR.mascara_classificacao,
                CR.descricao,
                O.*
            FROM orcamento.VW_CLASSIFICACAO_RECEITA  AS CR, ORCAMENTO.RECEITA AS O
            LEFT JOIN (
                 SELECT dr.exercicio , dr.cod_receita_secundaria
                 FROM contabilidade.desdobramento_receita as dr, orcamento.receita as ore
                 WHERE ore.cod_receita = dr.cod_receita_secundaria AND ore.exercicio = dr.exercicio
                    AND ore.exercicio = '%s'
            ) as recsec ON (O.cod_receita = recsec.cod_receita_secundaria
            AND O.exercicio   = recsec.exercicio )
            WHERE CR.exercicio IS NOT NULL AND O.cod_conta = CR.cod_conta AND O.exercicio = CR.exercicio
            AND O.exercicio = '%s'
            AND recsec.cod_receita_secundaria is null
            AND CR.exercicio = '%s' ORDER BY cod_receita",
            $exercicio,
            $exercicio,
            $exercicio
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $descricao
     * @return mixed
     */
    public function getReceitaByExercicioAndDescricao($exercicio, $descricao)
    {
        $sql = "
        SELECT
            exercicio,
            cod_conta,
            cod_norma,
            trim( descricao ) as descricao,
            cod_estrutural,
            publico.fn_mascarareduzida(cod_estrutural) AS mascara_classificacao_reduzida
        FROM
            orcamento.conta_receita
        WHERE
            exercicio IS NOT NULL
            AND (descricao LIKE UPPER(:descricao) OR cod_estrutural LIKE :descricao)
            AND exercicio = :exercicio
            AND cod_estrutural NOT LIKE '9%'
        ORDER BY
            cod_estrutural";

        $result = $this->_em->getConnection()->prepare($sql);
        $result->bindValue(':exercicio', $exercicio, \PDO::PARAM_STR);
        $result->bindValue(':descricao', '%'.$descricao.'%', \PDO::PARAM_STR);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $codConta
     * @return array
     */
    public function getContaReceitaByCodConta($exercicio, $codConta)
    {
        $sql = "SELECT rec.cod_receita, con.cod_conta, con.descricao, con.cod_estrutural
                FROM orcamento.receita rec
                INNER JOIN orcamento.conta_receita con
                ON rec.cod_conta = con.cod_conta
                AND rec.exercicio = con.exercicio
                WHERE rec.exercicio = :exercicio
                AND con.cod_conta = :codConta ";

        $result = $this->_em->getConnection()->prepare($sql);
        $result->bindValue(':exercicio', $exercicio);
        $result->bindValue(':codConta', $codConta);
        $result->execute();
        return $result->fetchAll();
    }
    /**
     * @param $exercicio
     * @return mixed
     */
    public function getNewCodReceita($exercicio)
    {
        return $this->nextVal('cod_receita', ['exercicio' => $exercicio]);
    }

    public function getReceitaByExercicioAndCodReceita($exercicio, $codReceita)
    {
        $sql = sprintf(
            "SELECT                   
                CR.mascara_classificacao,
                TRIM(CR.descricao) AS descricao,
                O.*,
                R.nom_recurso,
                R.masc_recurso_red,
                R.cod_detalhamento,
                R.cod_recurso,
                D.percentual
            FROM orcamento.vw_classificacao_receita AS CR
            INNER JOIN orcamento.receita O
            ON   CR.cod_conta = O.cod_conta
            AND CR.exercicio = O.exercicio
            INNER JOIN orcamento.recurso('%s') R
            ON  O.cod_recurso = R.cod_recurso
            AND O.exercicio   = R.exercicio
            INNER JOIN contabilidade.desdobramento_receita D
            ON O.cod_receita = D.cod_receita_principal
            AND O.exercicio = D.exercicio
            WHERE CR.exercicio = '%s'
            AND O.cod_receita = %d ",
            $exercicio,
            $exercicio,
            $codReceita
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    public function getLancamentosCreditosReceber($params)
    {
        $sql = sprintf(
            "SELECT
                receita.exercicio,
                receita.cod_entidade,
                receita.vl_original,
                receita.cod_receita,
                conta_receita.descricao,
                conta_receita.cod_estrutural,
                plano_analitica.cod_plano,
                plano_conta.nom_conta,
                plano_conta.cod_estrutural AS cod_estrutural_plano,
                conta_receita.cod_conta,
                configuracao_lancamento_receita.cod_conta,
                (
                    SELECT plano_conta.cod_estrutural
                    FROM contabilidade.plano_conta
                    WHERE
                        plano_conta.cod_conta = configuracao_lancamento_receita.cod_conta
                        AND plano_conta.exercicio = configuracao_lancamento_receita.exercicio
                ) AS cod_estrutural_credito,
                (
                    SELECT plano_analitica.cod_plano
                    FROM
                        contabilidade.plano_conta INNER JOIN contabilidade.plano_analitica ON
                        plano_analitica.cod_conta = plano_conta.cod_conta
                        AND plano_analitica.exercicio = plano_conta.exercicio
                    WHERE
                        plano_conta.cod_conta = configuracao_lancamento_receita.cod_conta
                        AND plano_conta.exercicio = configuracao_lancamento_receita.exercicio
                ) AS cod_plano_credito
            FROM orcamento.receita INNER JOIN orcamento.conta_receita ON (
                    conta_receita.cod_conta = receita.cod_conta
                    AND conta_receita.exercicio = receita.exercicio
                )
                INNER JOIN orcamento.receita_credito_tributario ON (
                    receita_credito_tributario.cod_receita = receita.cod_receita
                    AND receita_credito_tributario.exercicio = receita.exercicio
                )
                INNER JOIN contabilidade.plano_analitica ON (
                    plano_analitica.cod_conta = receita_credito_tributario.cod_conta
                    AND plano_analitica.exercicio = receita_credito_tributario.exercicio
                )
                INNER JOIN contabilidade.plano_conta ON (
                    plano_conta.cod_conta = receita_credito_tributario.cod_conta
                    AND plano_conta.exercicio = receita_credito_tributario.exercicio
                )
                INNER JOIN contabilidade.configuracao_lancamento_receita ON (
                    configuracao_lancamento_receita.cod_conta_receita = conta_receita.cod_conta
                    AND configuracao_lancamento_receita.exercicio = conta_receita.exercicio
                    AND configuracao_lancamento_receita.estorno = false
                )
            WHERE
                receita.credito_tributario = true
                AND receita.cod_entidade = %d
                AND receita.vl_original > 0
                AND receita.exercicio = '%s'",
            $params['codEntidade'],
            $params['exercicio']
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @param $codEntidade
     * @param $exercicio
     * @param $codEstrutural
     * @param $dtInicio
     * @param $dtTermino
     * @return float
     */
    public function getValorArrecadadoReceitaPorPeriodo($codEntidade, $exercicio, $codEstrutural, $dtInicio, $dtTermino)
    {
        $sql = "
            SELECT SUM(vl_lancamento) AS vl_periodo
	          FROM ( SELECT conta_receita.cod_estrutural
	                      , SUM(valor_lancamento.vl_lancamento) * -1 AS vl_lancamento
	                   FROM orcamento.receita
	             INNER JOIN orcamento.conta_receita
	                     ON receita.exercicio               = conta_receita.exercicio
	                    AND receita.cod_conta               = conta_receita.cod_conta
	
	             INNER JOIN contabilidade.lancamento_receita
	                     ON receita.exercicio               = lancamento_receita.exercicio
	                    AND receita.cod_receita             = lancamento_receita.cod_receita
	
	             INNER JOIN contabilidade.lancamento
	                     ON lancamento_receita.cod_lote     = lancamento.cod_lote
	                    AND lancamento_receita.sequencia    = lancamento.sequencia
	                    AND lancamento_receita.exercicio    = lancamento.exercicio
	                    AND lancamento_receita.cod_entidade = lancamento.cod_entidade
	                    AND lancamento_receita.tipo         = lancamento.tipo
	
	             INNER JOIN contabilidade.valor_lancamento
	                     ON lancamento.exercicio            = valor_lancamento.exercicio
	                    AND lancamento.sequencia            = valor_lancamento.sequencia
	                    AND lancamento.cod_entidade         = valor_lancamento.cod_entidade
	                    AND lancamento.cod_lote             = valor_lancamento.cod_lote
	                    AND lancamento.tipo                 = valor_lancamento.tipo
	
	             INNER JOIN contabilidade.lote
	                     ON lancamento.cod_lote             = lote.cod_lote
	                    AND lancamento.cod_entidade         = lote.cod_entidade
	                    AND lancamento.exercicio            = lote.exercicio
	                    AND lancamento.tipo                 = lote.tipo
	
	                  WHERE lancamento_receita.estorno      = true
	                    AND lancamento_receita.tipo         = 'A'
	                    AND valor_lancamento.tipo_valor     = 'D'
	                     AND receita.cod_entidade IN(:codEntidade) AND receita.exercicio = :exercicio AND conta_receita.cod_estrutural = :codEstrutural AND lote.dt_lote BETWEEN to_date(:dtInicio,'dd/mm/yyyy') AND to_date(:dtTermino,'dd/mm/yyyy') 
	               GROUP BY cod_estrutural
	
	            UNION
	
	                 SELECT conta_receita.cod_estrutural
	                      , SUM(valor_lancamento.vl_lancamento) * -1 AS vl_lancamento
	                   FROM orcamento.receita
	             INNER JOIN orcamento.conta_receita
	                     ON receita.exercicio = conta_receita.exercicio
	                    AND receita.cod_conta = conta_receita.cod_conta
	
	             INNER JOIN contabilidade.lancamento_receita
	                     ON receita.exercicio               = lancamento_receita.exercicio
	                    AND receita.cod_receita             = lancamento_receita.cod_receita
	
	             INNER JOIN contabilidade.lancamento
	                     ON lancamento_receita.cod_lote     = lancamento.cod_lote
	                    AND lancamento_receita.sequencia    = lancamento.sequencia
	                    AND lancamento_receita.exercicio    = lancamento.exercicio
	                    AND lancamento_receita.cod_entidade = lancamento.cod_entidade
	                    AND lancamento_receita.tipo         = lancamento.tipo
	
	             INNER JOIN contabilidade.valor_lancamento
	                     ON lancamento.exercicio            = valor_lancamento.exercicio
	                    AND lancamento.sequencia            = valor_lancamento.sequencia
	                    AND lancamento.cod_entidade         = valor_lancamento.cod_entidade
	                    AND lancamento.cod_lote             = valor_lancamento.cod_lote
	                    AND lancamento.tipo                 = valor_lancamento.tipo
	
	             INNER JOIN contabilidade.lote
	                     ON lancamento.cod_lote             = lote.cod_lote
	                    AND lancamento.cod_entidade         = lote.cod_entidade
	                    AND lancamento.exercicio            = lote.exercicio
	                    AND lancamento.tipo                 = lote.tipo
	
	                  WHERE lancamento_receita.estorno      = false
	                    AND lancamento_receita.tipo         = 'A'
	                    AND valor_lancamento.tipo_valor     = 'C'
	                     AND receita.cod_entidade IN(:codEntidade) AND receita.exercicio = :exercicio AND conta_receita.cod_estrutural = :codEstrutural AND lote.dt_lote BETWEEN to_date(:dtInicio,'dd/mm/yyyy') AND to_date(:dtTermino,'dd/mm/yyyy') 
	               GROUP BY cod_estrutural
	
	
	                ) AS tb1
	      GROUP BY tb1.cod_estrutural
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':codEntidade', $codEntidade, \PDO::PARAM_INT);
        $query->bindValue(':exercicio', $exercicio, \PDO::PARAM_STR);
        $query->bindValue(':codEstrutural', $codEstrutural, \PDO::PARAM_STR);
        $query->bindValue(':dtInicio', $dtInicio, \PDO::PARAM_STR);
        $query->bindValue(':dtTermino', $dtTermino, \PDO::PARAM_STR);
        $query->execute();
        return (float) $query->fetchColumn(0);
    }

    /**
     * @param $exercicio
     * @param array $filters
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getIdentificadorDeducao($exercicio, array $filters = [])
    {
        $queryFilters = '';
        foreach ($filters as $field => $value) {
            $queryFilters .= $this->addQueryFilterIdentificadorDeducao($field, $value);
        }

        $sql = "
            SELECT
	     trim(CR.descricao) as descricao,
	     O.cod_receita,
	     valores_identificadores.cod_identificador,
	     valores_identificadores.descricao as caracteristica
	 FROM
	     orcamento.vw_classificacao_receita AS CR,
	     orcamento.recurso(:exercicio) AS R,
	     orcamento.receita        AS O
	     LEFT JOIN tcemg.receita_indentificadores_peculiar_receita
	     ON (receita_indentificadores_peculiar_receita.exercicio  = o.exercicio
	    AND receita_indentificadores_peculiar_receita.cod_receita = o.cod_receita )
	     LEFT JOIN tcemg.valores_identificadores
	     ON (valores_identificadores.cod_identificador = receita_indentificadores_peculiar_receita.cod_identificador )
	 WHERE
	         CR.exercicio IS NOT NULL
	     AND O.cod_conta   = CR.cod_conta
	     AND O.exercicio   = CR.exercicio
	     AND O.cod_recurso = R.cod_recurso
	     AND O.exercicio   = R.exercicio
            {$queryFilters}
	     AND o.exercicio = :exercicio
	     AND CR.mascara_classificacao like '9.%'
	       ORDER BY  O.cod_receita, CR.mascara_classificacao
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':exercicio', $exercicio);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param string $field
     * @param string $value
     * @return string
     */
    protected function addQueryFilterIdentificadorDeducao($field, $value)
    {
        $sql = '';
        switch ($field) {
            case 'classificacaoDedutora':
                $value = MascaraHelper::reduzida($value, true);
                $sql = " AND CR.mascara_classificacao like '{$value}%' ";
                break;
            case 'recurso':
                return " AND R.cod_recurso = " . $value;
            case 'inicioCodigoReduzido':
                $sql = " AND o.cod_receita >= " . $value;
                break;
            case 'fimCodigoReduzido':
                $sql = " AND o.cod_receita <= " . $value;
                break;

            case 'descricao':
                $sql = " AND lower(CR.descricao) like lower('%{$value}%') ";
                break;
        }

        return $sql;
    }

    /**
     * @param $exercicio
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function withExercicioQueryBuilder($exercicio)
    {
        $qb = $this->createQueryBuilder('r');
        $qb->select('r.codReceita, v.mascaraClassificacao, v.descricao');
        $qb->join('\Urbem\CoreBundle\Entity\Orcamento\VwClassificacaoReceitaView', 'v', 'WITH', 'r.codConta = v.codConta AND r.exercicio = v.exercicio');
        $qb->where('v.exercicio IS NOT NULL');
        $qb->andWhere('v.exercicio = :exercicio');
        $qb->andWhere('v.mascaraClassificacao like :mascaraAnd OR v.mascaraClassificacao like :mascaraOr');
        $qb->andWhere('v.mascaraClassificacao like :mascaraOr');
        $qb->setParameter('exercicio', $exercicio);
        $qb->setParameter('mascaraAnd', '9.7%');
        $qb->setParameter('mascaraOr', '9%');
        $qb->orderBy('r.codReceita', 'ASC');

        return $qb;
    }

    /**
     * @param $exercicio
     * @param $term
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getReceitaByTermAsQueryBuilder($exercicio, $term)
    {
        $qb = $this->createQueryBuilder('r');
        $qb->join('\Urbem\CoreBundle\Entity\Orcamento\VwClassificacaoReceitaView', 'v', 'WITH', 'r.codConta = v.codConta AND r.exercicio = v.exercicio');
        $qb->leftJoin('Urbem\CoreBundle\Entity\Contabilidade\DesdobramentoReceita', 'dr', 'WITH','r.codReceita = dr.codReceitaSecundaria AND r.exercicio = dr.exercicio');
        $qb->where('r.exercicio IS NOT NULL');
        $qb->andWhere('dr.codReceitaSecundaria IS NULL');
        $qb->andWhere('r.exercicio = :exercicio');

        $orx = $qb->expr()->orX();

        $orx->add($qb->expr()->like('LOWER(v.descricao)', ':term'));

        $qb->andWhere($orx);

        $qb->setParameter('term', sprintf('%%%s%%', strtolower($term)));

        $qb->setParameter('exercicio', $exercicio);
        $qb->orderBy('r.codReceita', 'ASC');

        return $qb;
    }
}