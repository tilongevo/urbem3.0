<?php

namespace Urbem\CoreBundle\Repository\Contabilidade;

use Urbem\CoreBundle\Entity\Tcemg\BalanceteExtmmaa;
use Urbem\CoreBundle\Repository\AbstractRepository;

class PlanoContaRepository extends AbstractRepository
{
    /**
     * @param $exercicio
     * @param $mascara
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findPlanoContaByExercicioAndMascara($exercicio, $mascara)
    {
        $query = $this->_em->getConnection()->prepare("SELECT publico.fn_mascarareduzida(:mascara)");
        $query->bindValue(':mascara', $mascara, \PDO::PARAM_STR);
        $query->execute();
        $resultMascara = array_shift(current($query->fetchAll()));
        $resultMascara = empty($resultMascara) ? '%s' : $resultMascara;

        $qb = $this->createQueryBuilder('pc');
        $qb->leftJoin('Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica', 'pa', 'WITH', 'pa.codConta = pc.codConta');

        $qb->where('pa.codConta is not null');

        $qb->andWhere('pa.exercicio = :exercicio');
        $qb->setParameter('exercicio', $exercicio);

        $qb->andWhere("pc.codEstrutural like :mascara");
        $qb->setParameter('mascara', $resultMascara);

        $qb->orWhere("pc.codEstrutural like '%'");

        return $qb;
    }

    /**
     * @param $exercicio
     * @param $nomeConta
     * @param $hasLike
     * @return array
     */
    public function getPlanoContabyNomeContaAndExercicio($exercicio, $nomeConta, $hasLike)
    {
        $hasLike
            ?
        $like = "AND 
		 ( pc.cod_estrutural like '1.1.2.%'
		OR pc.cod_estrutural like '1.1.3.%'
		OR pc.cod_estrutural like '1.1.4.9%' 
		OR pc.cod_estrutural like '1.2.1.%'
		OR pc.cod_estrutural like '2.1.1.%'
		OR pc.cod_estrutural like '2.1.2.%'
		OR pc.cod_estrutural like '2.1.8.%'
		OR pc.cod_estrutural like '2.1.9.%'
		OR pc.cod_estrutural like '2.2.1.%'
		OR pc.cod_estrutural like '2.2.2.%'
		OR pc.cod_estrutural like '3.5.%' )"
            :
        $like = '';

        $sql = "SELECT                                                                            
         pa.cod_plano,pc.cod_estrutural,pc.nom_conta,pc.cod_conta,                     
         publico.fn_mascarareduzida(pc.cod_estrutural) as cod_reduzido,                
         pc.cod_classificacao,pc.cod_sistema,                                          
         pb.exercicio, pb.cod_banco, pb.cod_agencia,                  
         pb.cod_entidade,pa.natureza_saldo,                           
         CASE WHEN publico.fn_nivel(cod_estrutural) > 4 THEN                           
                 5                                                                     
              ELSE                                                                     
                 publico.fn_nivel(cod_estrutural)                                      
         END as nivel                                                                  
         FROM                                                                              
             contabilidade.plano_conta as pc                                           
         LEFT JOIN contabilidade.plano_analitica as pa on (                            
         pc.cod_conta = pa.cod_conta and pc.exercicio = pa.exercicio )                     
         LEFT JOIN contabilidade.plano_banco as pb on (                                
         pb.cod_plano = pa.cod_plano and pb.exercicio = pa.exercicio                       
         )                                                                                 
         WHERE 
         pa.cod_plano is not null AND 
         pc.exercicio = :exercicio ".
         $like
        ." AND pc.nom_conta like UPPER(:nomeConta)
        ORDER BY cod_estrutural";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('nomeConta', '%'.$nomeConta.'%');
        $query->execute();
        return $query->fetchAll();
    }

    public function findById($id)
    {
        $query = $this->_em->getConnection()->prepare("
        SELECT *  FROM contabilidade.plano_conta WHERE id = ". $id);
        $query->execute();
        $result = (current($query->fetchAll(\PDO::FETCH_OBJ)));

        return $result;
    }

    /**
     * @param $exercicio
     * @param $codEstrutural
     * @param bool $useLike
     * @return array
     */
    public function getContaCreditoLancamentoListByExercicioAndCodEstrutural($exercicio, $codEstrutural, $useLike = true)
    {
        $where = "pa.cod_conta = pc.cod_conta AND pa.exercicio = pc.exercicio";
        $where .= " AND pc.exercicio = '%s'";

        if ($useLike) {
            $where .= " AND ( pc.cod_estrutural like '%s%%' )";
        }

        $sql = sprintf(
            "SELECT
                pa.cod_conta ,
                pc.exercicio ,
                pc.nom_conta ,
                pc.cod_classificacao ,
                pc.cod_sistema ,
                pc.cod_estrutural
            FROM
                contabilidade.plano_analitica as pa,
                contabilidade.plano_conta as pc
            WHERE 
                $where
                ORDER BY pc.cod_estrutural ",
            $exercicio,
            $codEstrutural
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $codEstrutural
     * @param $destinacaoRecurso
     * @return array
     */
    public function getContaCreditoLancamentoListByExercicioCodEstruturalDestinacaoRecurso($exercicio, $codEstrutural, $destinacaoRecurso)
    {
        $sql = sprintf(
            "SELECT
                pa.cod_conta ,
                pc.exercicio ,
                pc.nom_conta ,
                pc.cod_classificacao ,
                pc.cod_sistema ,
                pc.cod_estrutural
            FROM
                contabilidade.plano_analitica as pa,
                contabilidade.plano_conta as pc
            WHERE pa.cod_conta = pc.cod_conta AND pa.exercicio = pc.exercicio
                AND pc.exercicio = '%s'
                AND (
                  ( pc.cod_estrutural like '%s%%' ) OR ( pc.cod_estrutural like '%s%%' )
                )
                ORDER BY pc.cod_estrutural ",
            $exercicio,
            $codEstrutural,
            $destinacaoRecurso
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @param $codPlano
     * @param $exercicio
     * @return array
     */
    public function getPlanoContaByIdAndExercicio($codPlano, $exercicio)
    {
        $sql = sprintf(
            "SELECT
                pa.cod_plano,
                pc.exercicio,
                pc.cod_conta,
                pc.nom_conta,
                pc.cod_estrutural,
                pa.natureza_saldo
            FROM
                contabilidade.plano_conta as pc,
                contabilidade.plano_analitica as pa
            WHERE pc.cod_conta  = pa.cod_conta
                AND pc.exercicio  = pa.exercicio
                AND pa.cod_plano = %d AND pa.exercicio = '%s'",
            $codPlano,
            $exercicio
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $codEstrutural
     * @return array
     */
    public function getPlanoContaByExercicioAndEntidadeAndCodEstrutura($exercicio, $codEntidade, $codEstrutural)
    {
        $sql = sprintf(
            "SELECT
                pa.cod_plano,pc.cod_estrutural,pc.nom_conta,pc.cod_conta,
                publico.fn_mascarareduzida(pc.cod_estrutural) as cod_reduzido,
                pc.cod_classificacao,pc.cod_sistema,
                pb.exercicio, pb.cod_banco, pb.cod_agencia,
                pb.cod_entidade,pa.natureza_saldo,
                CASE
                    WHEN publico.fn_nivel(cod_estrutural) > 4 THEN 5
                    ELSE publico.fn_nivel(cod_estrutural)
                END as nivel
            FROM contabilidade.plano_conta as pc
                LEFT JOIN contabilidade.plano_analitica as pa on (pc.cod_conta = pa.cod_conta and pc.exercicio = pa.exercicio )
                LEFT JOIN contabilidade.plano_banco as pb on (pb.cod_plano = pa.cod_plano and pb.exercicio = pa.exercicio)
                WHERE
                    pa.cod_plano is not null AND
                    pc.exercicio = '%s' AND
                    (( pb.cod_banco is not null AND
                    pb.cod_entidade in (%d) AND
                    pc.cod_estrutural like '%s%%'))
            ORDER BY cod_estrutural",
            $exercicio,
            $codEntidade,
            $codEstrutural
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $codEstrutural
     * @return array
     */
    public function verificaClassificacao($exercicio, $codEstrutural)
    {
        $sql = sprintf(
            "SELECT
                    exercicio,
                    cod_conta,
                    cod_norma,
                    trim( descricao ) as descricao,
                    cod_estrutural as mascara_classificacao,
                    publico.fn_mascarareduzida(cod_estrutural) as mascara_classificacao_reduzida
                FROM
                    orcamento.conta_receita
                WHERE
                    exercicio IS NOT NULL
                    AND exercicio = '%s'
                    AND cod_estrutural NOT LIKE '9%%'
                    AND cod_estrutural = '%s'",
            $exercicio,
            $codEstrutural
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @param $exercicio
     * @return int
     */
    public function getNewCodConta($exercicio)
    {
        return $this->nextVal('cod_conta', ['exercicio' => $exercicio]);
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function getGrupos($exercicio)
    {
        $sql = sprintf(
            "SELECT nom_conta, substr(cod_estrutural,1,1) as cod_grupo
             FROM contabilidade.plano_conta
             WHERE publico.fn_mascarareduzida(cod_estrutural)
	         IN ( 
	             SELECT DISTINCT substr(cod_estrutural,1,1) as cod_grupo
	             FROM contabilidade.plano_conta
	         )
	         AND  exercicio = '%s'  ORDER BY cod_grupo",
            $exercicio
        );
        $result = $this->_em->getConnection()->prepare($sql);
        $result->execute();
        $grupos = $result->fetchAll();

        $options = [];
        foreach ($grupos as $grupo) {
            $options[$grupo['cod_grupo'] . ' - ' . $grupo['nom_conta']] = (int) $grupo['cod_grupo'];
        }
        return $options;
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function getCodigoReduzido($exercicio)
    {
        $sql = sprintf(
            "SELECT
                pa.cod_plano,
                pc.cod_conta,
                pc.nom_conta
	        FROM
	            contabilidade.plano_conta as pc,
	            contabilidade.plano_analitica as pa
	        WHERE pc.cod_conta  = pa.cod_conta
	        AND pc.exercicio  = pa.exercicio
	        AND pa.exercicio = '%s'  ORDER BY pc.cod_estrutural",
            $exercicio
        );
        $result = $this->_em->getConnection()->prepare($sql);
        $result->execute();
        $contas = $result->fetchAll();

        $options = [];
        foreach ($contas as $conta) {
            $options[$conta['cod_plano'] . ' - ' . $conta['nom_conta']] = (int) $conta['cod_plano'];
        }
        return $options;
    }

    /**
     * @param $exercicio
     * @param null $codPlano
     * @param null $nomeConta
     * @return array
     */
    public function getCodReduzidoByCodPlanoOrNomConta($exercicio, $codPlano = null, $nomeConta = null)
    {
        $sql = "SELECT
                    pa.cod_plano,
                    pc.cod_conta,
                    pc.nom_conta
                FROM
                    contabilidade.plano_conta as pc,
                    contabilidade.plano_analitica as pa
                WHERE pc.cod_conta  = pa.cod_conta
                AND pc.exercicio  = pa.exercicio
                AND pa.exercicio = :exercicio ";

        if ($codPlano && $nomeConta) {
            $sql .= "AND  pa.cod_plano IN (:codPlano) || lower(pc.nom_conta) LIKE lower(:nomeConta) ";
        } elseif ($codPlano && !$nomeConta) {
            $sql .= "AND  pa.cod_plano IN (:codPlano) ";
        } elseif (!$codPlano && $nomeConta) {
            $sql .= "AND  UPPER(pc.nom_conta) LIKE lower(:nomeConta) ";
        }
        $sql .= "ORDER BY pc.cod_estrutural ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio, \PDO::PARAM_STR);
        ($codPlano) ? $query->bindValue('codPlano', $codPlano, \PDO::PARAM_INT) : null;
        ($nomeConta) ? $query->bindValue('nomeConta', '%'.$nomeConta.'%', \PDO::PARAM_STR) : null;
        $query->execute();

        return $query->fetch();
    }

    /**
     * @param $codEntidade
     * @param $codGrupo
     * @param $exercicio
     * @param null $codContaDe
     * @param null $codContaAte
     * @return array
     */
    public function getIntervaloContas($codEntidade, $codGrupo, $exercicio, $codContaDe = null, $codContaAte = null)
    {
        $sql = "
            SELECT 
                pc.cod_estrutural,
                pc.exercicio,
                pc.nom_conta,
                pc.cod_conta,
                publico.Fn_mascarareduzida(pc.cod_estrutural) AS cod_reduzido,
                tabela.vl_lancamento,
                pa.cod_plano,
                tabela.sequencia,
                pa.natureza_saldo,
                CASE
                    WHEN (
                        SELECT cod_plano
                        FROM contabilidade.plano_banco
                        WHERE exercicio = pc.exercicio 
                            AND cod_plano = pa.cod_plano
                    ) IS NOT NULL THEN 
                    CASE 
                        WHEN (
                            SELECT cod_entidade
                            FROM contabilidade.plano_banco
                            WHERE exercicio = pc.exercicio
                                AND cod_plano = pa.cod_plano
                                AND cod_entidade = :codEntidade
                        ) IS NOT NULL THEN 'OK'
                    ELSE 'NOK'
                    END 
                ELSE 'OK' 
                END AS plano_banco
            FROM 
                contabilidade.plano_conta AS pc,
                contabilidade.plano_analitica AS pa
            left join (
                SELECT
                    CASE WHEN pac.cod_plano IS NOT NULL THEN pac.cod_plano ELSE pad.cod_plano END AS cod_plano,
                    CASE WHEN cc.cod_entidade IS NOT NULL THEN cc.cod_entidade ELSE cd.cod_entidade END AS cod_entidade,
                    CASE WHEN vlc.vl_lancamento IS NOT NULL THEN vlc.vl_lancamento ELSE vld.vl_lancamento END AS vl_lancamento,
                    CASE WHEN vlc.sequencia IS NOT NULL THEN vlc.sequencia ELSE vld.sequencia END AS sequencia,
                    CASE WHEN cc.cod_entidade IS NOT NULL THEN cc.cod_entidade ELSE cd.cod_entidade END AS cod_entidade, 
                    CASE WHEN cc.exercicio IS NOT NULL THEN cc.exercicio ELSE cd.exercicio END AS exercicio
                FROM contabilidade.plano_analitica AS pad
                left join contabilidade.conta_debito AS cd
                ON (
                    pad.cod_plano = cd.cod_plano
                    AND pad.exercicio = cd.exercicio
                    AND cd.tipo = 'I'
                    AND cd.cod_lote = 1
                    AND cd.cod_entidade = :codEntidade
                )
                left join contabilidade.valor_lancamento AS vld
                ON (
                    cd.cod_lote = vld.cod_lote 
                    AND cd.tipo = vld.tipo 
                    AND cd.sequencia = vld.sequencia 
                    AND cd.exercicio = vld.exercicio 
                    AND cd.tipo_valor = vld.tipo_valor 
                    AND cd.cod_entidade = vld.cod_entidade
                ),
                contabilidade.plano_analitica AS pac
                left join contabilidade.conta_credito AS cc
                ON (
                    pac.cod_plano = cc.cod_plano
                    AND pac.exercicio = cc.exercicio
                    AND cc.tipo = 'I'
                    AND cc.cod_lote = 1
                    AND cc.cod_entidade = :codEntidade
                )
                left join contabilidade.valor_lancamento AS vlc
                ON (
                    cc.cod_lote = vlc.cod_lote
                    AND cc.tipo = vlc.tipo
                    AND cc.sequencia = vlc.sequencia
                    AND cc.exercicio = vlc.exercicio
                    AND cc.tipo_valor = vlc.tipo_valor
                    AND cc.cod_entidade = vlc.cod_entidade
                )
                WHERE
                    pad.cod_plano = pac.cod_plano 
                    AND pad.exercicio = pac.exercicio
                    AND ( cc.cod_entidade = :codEntidade OR cd.cod_entidade = :codEntidade )
            ) AS tabela
            ON ( pa.cod_plano = tabela.cod_plano AND pa.exercicio = tabela.exercicio )
            WHERE  pc.cod_conta = pa.cod_conta 
                AND pc.exercicio = pa.exercicio
        ";

        if ($codContaDe) {
            $sql .= " AND pa.cod_plano >= :codContaDe ";
        }
        if ($codContaAte) {
            $sql .= " AND pa.cod_plano <= :codContaAte";
        }

        $sql .= "
                AND pc.exercicio = :exercicio
                AND Substr(pc.cod_estrutural, 1, 1) = :codGrupo
            ORDER  BY cod_estrutural
        ";

        $result = $this->_em->getConnection()->prepare($sql);

        $result->bindValue("codEntidade", $codEntidade);
        if ($codContaDe) {
            $result->bindValue("codContaDe", $codContaDe);
        }

        if ($codContaAte) {
            $result->bindValue("codContaAte", $codContaAte);
        }

        $result->bindValue("exercicio", $exercicio);
        $result->bindValue("codGrupo", $codGrupo);

        $result->execute();
        $contas = $result->fetchAll();

        return $contas;
    }

    /**
     * @param $exercicio
     * @param $codPlanoDebito
     * @param $codPlanoCredito
     * @param $codEstruturalDebito
     * @param $codEstruturalCredito
     * @param $vlLancamento
     * @param $codLote
     * @param $codEntidade
     * @param $codHistorico
     * @param $tipo
     * @param $complemento
     * @return null
     */
    public function insertLancamento($exercicio, $codPlanoDebito, $codPlanoCredito, $codEstruturalDebito, $codEstruturalCredito, $vlLancamento, $codLote, $codEntidade, $codHistorico, $tipo, $complemento)
    {
        $sql = sprintf(
            "
            SELECT contabilidade.fn_insere_lancamentos(
                '%s', %d, %d, '%s', '%s', '%s', %d, %d, %d, '%s', '%s'
            ) as sequencia",
            $exercicio,
            $codPlanoDebito,
            $codPlanoCredito,
            $codEstruturalDebito,
            $codEstruturalCredito,
            $vlLancamento,
            $codLote,
            $codEntidade,
            $codHistorico,
            $tipo,
            $complemento
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        $retorno = $result->fetchAll();
        $sequencia = null;
        foreach ($retorno as $value) {
            $sequencia = $value['sequencia'];
        }
        return $sequencia;
    }

    /**
     * @param array $paramsWhere
     * @param null $paramsExtra
     * @return array
     */
    public function findContasArrecadacaoExtraReceita(array $paramsWhere, $paramsExtra = null)
    {
        $sql = sprintf(
            "SELECT
                     pa.cod_plano,pc.cod_estrutural,pc.nom_conta,pc.cod_conta,
                     publico.fn_mascarareduzida(pc.cod_estrutural) as cod_reduzido,
                     pc.cod_classificacao,pc.cod_sistema,
                     pb.exercicio, pb.cod_banco, pb.cod_agencia,
                     pb.cod_entidade,pa.natureza_saldo,
                     CASE WHEN publico.fn_nivel(cod_estrutural) > 4 THEN
                             5
                          ELSE
                             publico.fn_nivel(cod_estrutural)
                     END as nivel
                 FROM
                     contabilidade.plano_conta as pc
                 LEFT JOIN contabilidade.plano_analitica as pa on (
                 pc.cod_conta = pa.cod_conta and pc.exercicio = pa.exercicio )
                 LEFT JOIN contabilidade.plano_banco as pb on (
                 pb.cod_plano = pa.cod_plano and pb.exercicio = pa.exercicio
                 )
                 WHERE %s",
            implode(" AND ", $paramsWhere)
        );
        $sql .= $paramsExtra ? " ".$paramsExtra : "";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param string $tipo
     * @return array
     */
    public function recuperaSaldoInicialContas($exercicio, $codEntidade, $tipo = 'M')
    {
        $sql = "
            SELECT
                pc.exercicio,
                pc.nom_conta,
                pc.cod_estrutural,
                pa.cod_conta,
                tabela.cod_plano,
                pc.funcao,
                pa.natureza_saldo,
                tabela.nom_lote,
                tabela.cod_historico,
                tabela.cod_lote,
                tabela.vl_lancamento
            FROM
                contabilidade.plano_conta AS pc,
                contabilidade.plano_analitica AS pa
                LEFT JOIN (
                    SELECT
                        CASE
                            WHEN pac.cod_plano IS NOT NULL THEN pac.cod_plano
                            ELSE pad.cod_plano
                        END AS cod_plano,
                        CASE
                            WHEN cc.cod_entidade IS NOT NULL THEN cc.cod_entidade
                            ELSE cd.cod_entidade
                        END AS cod_entidade,
                        CASE
                            WHEN vlc.vl_lancamento IS NOT NULL THEN vlc.vl_lancamento
                            ELSE vld.vl_lancamento
                        END AS vl_lancamento,
                        CASE
                            WHEN vlc.sequencia IS NOT NULL THEN vlc.sequencia
                            ELSE vld.sequencia
                        END AS sequencia,
                        CASE
                            WHEN cc.cod_entidade IS NOT NULL THEN cc.cod_entidade
                            ELSE cd.cod_entidade
                        END AS cod_entidade,
                        CASE
                            WHEN cc.exercicio IS NOT NULL THEN cc.exercicio
                            ELSE cd.exercicio
                        END AS exercicio,
                        CASE
                            WHEN cld.nom_lote IS NOT NULL THEN cld.nom_lote
                            ELSE clc.nom_lote
                        END AS nom_lote,
                        CASE
                            WHEN lancamento_despesa.cod_lote IS NOT NULL THEN lancamento_despesa.cod_lote
                            ELSE lancamento_credito.cod_lote
                        END AS cod_lote,
                        CASE
                            WHEN lancamento_despesa.cod_historico IS NOT NULL THEN lancamento_despesa.cod_historico
                            ELSE lancamento_credito.cod_historico
                        END AS cod_historico --,lancamento.cod_lote
                        --,lancamento.cod_historico
                    FROM
                        contabilidade.plano_analitica AS PAD
                    LEFT JOIN contabilidade.conta_debito AS cd ON (
                        pad.cod_plano = cd.cod_plano
                        AND pad.exercicio = cd.exercicio
                        AND cd.tipo = :tipo
                        AND cd.cod_entidade = :codEntidade )
                    LEFT JOIN contabilidade.valor_lancamento AS vld ON (
                        cd.cod_lote = vld.cod_lote
                        AND cd.tipo = vld.tipo
                        AND cd.sequencia = vld.sequencia
                        AND cd.exercicio = vld.exercicio
                        AND cd.tipo_valor = vld.tipo_valor
                        AND cd.cod_entidade = vld.cod_entidade )
                    LEFT JOIN contabilidade.lancamento AS lancamento_despesa ON (
                        lancamento_despesa.exercicio = vld.exercicio
                        AND lancamento_despesa.cod_lote = vld.cod_lote
                        AND lancamento_despesa.tipo = vld.tipo
                        AND lancamento_despesa.sequencia = vld.sequencia
                        AND lancamento_despesa.cod_entidade = vld.cod_entidade )
                    LEFT JOIN contabilidade.lote AS cld ON (
                        cld.cod_lote = lancamento_despesa.cod_lote
                        AND cld.exercicio = lancamento_despesa.exercicio
                        AND cld.tipo = lancamento_despesa.tipo
                        AND cld.cod_entidade = lancamento_despesa.cod_entidade ),
                    contabilidade.plano_analitica AS pac
                LEFT JOIN contabilidade.conta_credito AS cc ON (
                    pac.cod_plano = cc.cod_plano
                    AND pac.exercicio = cc.exercicio
                    AND cc.tipo = :tipo
                    AND cc.cod_entidade = :codEntidade )
                LEFT JOIN contabilidade.valor_lancamento AS vlc ON (
                    cc.cod_lote = vlc.cod_lote
                    AND cc.tipo = vlc.tipo
                    AND cc.sequencia = vlc.sequencia
                    AND cc.exercicio = vlc.exercicio
                    AND cc.tipo_valor = vlc.tipo_valor
                    AND cc.cod_entidade = vlc.cod_entidade )
                LEFT JOIN contabilidade.lancamento AS lancamento_credito ON (
                    lancamento_credito.exercicio = vlc.exercicio
                    AND lancamento_credito.cod_lote = vlc.cod_lote
                    AND lancamento_credito.tipo = vlc.tipo
                    AND lancamento_credito.sequencia = vlc.sequencia
                    AND lancamento_credito.cod_entidade = vlc.cod_entidade )
                LEFT JOIN contabilidade.lote AS clc ON (
                    clc.cod_lote = vlc.cod_lote
                    AND clc.exercicio = vlc.exercicio
                    AND clc.tipo = vlc.tipo
                    AND clc.cod_entidade = vlc.cod_entidade )
            WHERE
                pad.cod_plano = pac.cod_plano
                AND pad.exercicio = pac.exercicio
                AND (
                    cc.cod_entidade = :codEntidade
                    OR cd.cod_entidade = :codEntidade ) ) AS tabela ON (
                    pa.cod_plano = tabela.cod_plano
                    AND pa.exercicio = tabela.exercicio )
            WHERE
                pc.cod_conta = pa.cod_conta
                AND pc.exercicio = pa.exercicio
                AND pc.exercicio = :exercicio
                AND tabela.cod_historico IN (
                    220,
                    221,
                    222,
                    223 )
                --AND   pa.natureza_saldo LIKE 'C'
                AND (
                    ---Receita Bruta Orcada para o Exercicio
                    (
                        pc.cod_estrutural LIKE '%5.2.1.1.1.00.00.00.00.00%'
                        AND tabela.cod_historico = 220 )
                    OR (
                        pc.cod_estrutural LIKE '%6.2.1.1.0.00.00.00.00.00%'
                        AND tabela.cod_historico = 220 )
                    --Receita Dedutora Bruta Orcada para o Exercicio
                    --Fundeb
                    OR (
                        pc.cod_estrutural LIKE '%5.2.1.1.2.01.01.00.00.00%'
                        AND tabela.cod_historico = 222 )
                    --Renuncia
                    OR (
                        pc.cod_estrutural LIKE '%5.2.1.1.2.02.00.00.00.00%'
                        AND tabela.cod_historico = 222 )
                    --Outras Deducoes
                    OR (
                        pc.cod_estrutural LIKE '%5.2.1.1.2.99.00.00.00.00%'
                        AND tabela.cod_historico = 222 )
                    --Despesa Prevista para o Exercicio
                    OR (
                        pc.cod_estrutural LIKE '%5.2.2.1.1.01.00.00.00.00%'
                        AND tabela.cod_historico = 221 )
                    OR (
                        pc.cod_estrutural LIKE '%6.2.2.1.1.00.00.00.00.00%'
                        AND tabela.cod_historico = 221 )
                    --Receita Dedutora Somatorio dos Outros Campos
                    --OR (pc.cod_estrutural LIKE '%6.2.1.1.0.00.00.00.00.00%' AND tabela.cod_historico = 222)
                    --Lancamentos de Abertura dos Recursos-Fontes
                    --OR (pc.cod_estrutural LIKE '%7.2.1.1.1.00.01.00.00.00%' AND tabela.cod_historico = 223)
                    --OR (pc.cod_estrutural LIKE '%8.2.1.1.1.00.01.00.00.00%' AND tabela.cod_historico = 223)
                )
            ORDER BY
                cod_historico
        ";

        $result = $this->_em->getConnection()->prepare($sql);
        $result->bindValue("exercicio", $exercicio);
        $result->bindValue("codEntidade", $codEntidade);
        $result->bindValue("tipo", $tipo);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function recuperaSaldoInicialRecurso($exercicio)
    {
        $sql = "
            SELECT
                contas.cod_recurso,
                sum ( vl_lancamento ) AS saldo
            FROM (
                    SELECT
                        plano_conta.cod_conta,
                        plano_conta.exercicio,
                        plano_conta.nom_conta,
                        plano_conta.cod_estrutural,
                        CPA.cod_plano,
                        CVL.tipo,
                        CVL.tipo_valor,
                        CVL.vl_lancamento,
                        CVL.sequencia,
                        CPR.cod_recurso
                    FROM
                        contabilidade.plano_conta,
                        contabilidade.plano_banco AS CPB,
                        contabilidade.plano_analitica AS CPA,
                        contabilidade.conta_debito AS CCD,
                        contabilidade.valor_lancamento AS CVL,
                        contabilidade.plano_recurso AS CPR -- JOIN com plano_analitica
                    WHERE
                        CPB.exercicio = CPA.exercicio
                        AND CPB.cod_plano = CPA.cod_plano -- JOIN com plano_conta
                        AND plano_conta.cod_conta = CPA.cod_conta
                        AND plano_conta.exercicio = CPA.exercicio -- JOIN com conta_debito
                        AND CPA.exercicio = CCD.exercicio
                        AND CPA.cod_plano = CCD.cod_plano -- JOIN com valor_lacamento
                        AND CCD.exercicio = CVL.exercicio
                        AND CCD.cod_entidade = CVL.cod_entidade
                        AND CCD.tipo = CVL.tipo
                        AND CCD.tipo_valor = CVL.tipo_valor
                        AND CCD.cod_lote = CVL.cod_lote
                        AND CCD.sequencia = CVL.sequencia
                        AND CPR.cod_plano = CPA.cod_plano
                        AND CPR.exercicio = CPA.exercicio -- Filtros
                        AND CPA.exercicio = :exercicio
                        AND CVL.tipo = 'I'
                    UNION
                    SELECT
                        plano_conta.cod_conta,
                        plano_conta.exercicio,
                        plano_conta.nom_conta,
                        plano_conta.cod_estrutural,
                        CPA.cod_plano,
                        CVL.tipo,
                        CVL.tipo_valor,
                        CVL.vl_lancamento,
                        CVL.vl_lancamento,
                        CPR.cod_recurso
                    FROM
                        contabilidade.plano_conta,
                        contabilidade.plano_banco AS CPB,
                        contabilidade.plano_analitica AS CPA,
                        contabilidade.conta_credito AS CCC,
                        contabilidade.valor_lancamento AS CVL,
                        contabilidade.plano_recurso AS CPR -- JOIN com plano_analitica
                    WHERE
                        CPB.exercicio = CPA.exercicio
                        AND CPB.cod_plano = CPA.cod_plano -- JOIN com plano_conta
                        AND plano_conta.cod_conta = CPA.cod_conta
                        AND plano_conta.exercicio = CPA.exercicio -- JOIN com conta_debito
                        AND CPA.exercicio = CCC.exercicio
                        AND CPA.cod_plano = CCC.cod_plano -- JOIN com valor_lacamento
                        AND CCC.exercicio = CVL.exercicio
                        AND CCC.cod_entidade = CVL.cod_entidade
                        AND CCC.tipo = CVL.tipo
                        AND CCC.tipo_valor = CVL.tipo_valor
                        AND CCC.cod_lote = CVL.cod_lote
                        AND CCC.sequencia = CVL.sequencia
                        AND CPR.cod_plano = CPA.cod_plano
                        AND CPR.exercicio = CPA.exercicio -- Filtros
                        AND CPA.exercicio = :exercicio
                        AND CVL.tipo = 'I' ) AS contas
                LEFT JOIN contabilidade.plano_recurso ON (
                    contas.cod_plano = plano_recurso.cod_plano
                    AND contas.exercicio = plano_recurso.exercicio )
                LEFT JOIN orcamento.recurso ON (
                    recurso.cod_recurso = plano_recurso.cod_recurso
                    AND recurso.exercicio = plano_recurso.exercicio )
            GROUP BY
                contas.cod_recurso
            ORDER BY
                contas.cod_recurso
        ";

        $result = $this->_em->getConnection()->prepare($sql);
        $result->bindValue("exercicio", $exercicio);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $codEstrutural
     * @return null
     */
    public function getContaByCodEstrutural($exercicio, $codEntidade, $codEstrutural)
    {
        $sql = "
            SELECT
                pc.cod_estrutural,
                pc.exercicio,
                pc.nom_conta,
                pc.cod_conta,
                publico.fn_mascarareduzida (
                    pc.cod_estrutural ) AS cod_reduzido,
                tabela.vl_lancamento,
                pa.cod_plano,
                tabela.sequencia,
                pa.natureza_saldo
            FROM
                contabilidade.plano_conta AS pc,
                contabilidade.plano_analitica AS pa
                LEFT JOIN (
                    SELECT
                        CASE
                            WHEN pac.cod_plano IS NOT NULL THEN pac.cod_plano
                            ELSE pad.cod_plano
                        END AS cod_plano,
                        CASE
                            WHEN cc.cod_entidade IS NOT NULL THEN cc.cod_entidade
                            ELSE cd.cod_entidade
                        END AS cod_entidade,
                        CASE
                            WHEN vlc.vl_lancamento IS NOT NULL THEN vlc.vl_lancamento
                            ELSE vld.vl_lancamento
                        END AS vl_lancamento,
                        CASE
                            WHEN vlc.sequencia IS NOT NULL THEN vlc.sequencia
                            ELSE vld.sequencia
                        END AS sequencia,
                        CASE
                            WHEN cc.cod_entidade IS NOT NULL THEN cc.cod_entidade
                            ELSE cd.cod_entidade
                        END AS cod_entidade,
                        CASE
                            WHEN cc.exercicio IS NOT NULL THEN cc.exercicio
                            ELSE cd.exercicio
                        END AS exercicio
                    FROM
                        contabilidade.plano_analitica AS PAD
                    LEFT JOIN contabilidade.conta_debito AS cd ON (
                        pad.cod_plano = cd.cod_plano
                        AND pad.exercicio = cd.exercicio
                        AND cd.tipo = 'I'
                        AND cd.cod_lote = 1
                        AND cd.cod_entidade = :codEntidade )
                    LEFT JOIN contabilidade.valor_lancamento AS vld ON (
                        cd.cod_lote = vld.cod_lote
                        AND cd.tipo = vld.tipo
                        AND cd.sequencia = vld.sequencia
                        AND cd.exercicio = vld.exercicio
                        AND cd.tipo_valor = vld.tipo_valor
                        AND cd.cod_entidade = vld.cod_entidade ),
                    contabilidade.plano_analitica AS pac
                LEFT JOIN contabilidade.conta_credito AS cc ON (
                    pac.cod_plano = cc.cod_plano
                    AND pac.exercicio = cc.exercicio
                    AND cc.tipo = 'I'
                    AND cc.cod_lote = 1
                    AND cc.cod_entidade = :codEntidade )
                LEFT JOIN contabilidade.valor_lancamento AS vlc ON (
                    cc.cod_lote = vlc.cod_lote
                    AND cc.tipo = vlc.tipo
                    AND cc.sequencia = vlc.sequencia
                    AND cc.exercicio = vlc.exercicio
                    AND cc.tipo_valor = vlc.tipo_valor
                    AND cc.cod_entidade = vlc.cod_entidade )
            WHERE
                pad.cod_plano = pac.cod_plano
                AND pad.exercicio = pac.exercicio
                AND (
                    cc.cod_entidade = :codEntidade
                    OR cd.cod_entidade = :codEntidade ) ) AS tabela ON (
                    pa.cod_plano = tabela.cod_plano
                    AND pa.exercicio = tabela.exercicio )
                LEFT JOIN contabilidade.plano_recurso AS pr ON pr.cod_plano = pa.cod_plano
                AND pr.exercicio = pa.exercicio
            WHERE
                pc.cod_conta = pa.cod_conta
                AND pc.exercicio = pa.exercicio
                AND pc.exercicio = :exercicio
                AND publico.fn_mascarareduzida (
                    cod_estrutural )
                LIKE (
                    publico.fn_mascarareduzida (
                        :codEstrutural )
                    || '%' )
            ORDER BY
                cod_estrutural
        ";

        $result = $this->_em->getConnection()->prepare($sql);
        $result->bindValue("exercicio", $exercicio);
        $result->bindValue("codEntidade", $codEntidade);
        $result->bindValue("codEstrutural", $codEstrutural);

        $result->execute();
        $retorno = $result->fetch();
        $conta = null;
        if ($retorno) {
            $conta = $retorno['cod_plano'];
        }
        return $conta;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $codLote
     * @param $codRecurso
     * @param $codEstrutural
     * @return null
     */
    public function getContaByRecurso($exercicio, $codEntidade, $codLote, $codRecurso, $codEstrutural)
    {
        $sql = "
            SELECT
                pc.cod_estrutural,
                pc.exercicio,
                pc.nom_conta,
                pc.cod_conta,
                publico.fn_mascarareduzida (
                    pc.cod_estrutural ) AS cod_reduzido,
                tabela.vl_lancamento,
                pa.cod_plano,
                tabela.sequencia,
                pa.natureza_saldo
            FROM
                contabilidade.plano_conta AS pc,
                contabilidade.plano_analitica AS pa
                LEFT JOIN (
                    SELECT
                        CASE
                            WHEN pac.cod_plano IS NOT NULL THEN pac.cod_plano
                            ELSE pad.cod_plano
                        END AS cod_plano,
                        CASE
                            WHEN cc.cod_entidade IS NOT NULL THEN cc.cod_entidade
                            ELSE cd.cod_entidade
                        END AS cod_entidade,
                        CASE
                            WHEN vlc.vl_lancamento IS NOT NULL THEN vlc.vl_lancamento
                            ELSE vld.vl_lancamento
                        END AS vl_lancamento,
                        CASE
                            WHEN vlc.sequencia IS NOT NULL THEN vlc.sequencia
                            ELSE vld.sequencia
                        END AS sequencia,
                        CASE
                            WHEN cc.cod_entidade IS NOT NULL THEN cc.cod_entidade
                            ELSE cd.cod_entidade
                        END AS cod_entidade,
                        CASE
                            WHEN cc.exercicio IS NOT NULL THEN cc.exercicio
                            ELSE cd.exercicio
                        END AS exercicio
                    FROM
                        contabilidade.plano_analitica AS PAD
                    LEFT JOIN contabilidade.conta_debito AS cd ON (
                        pad.cod_plano = cd.cod_plano
                        AND pad.exercicio = cd.exercicio
                        AND cd.tipo = 'I'
                        AND cd.cod_lote = :codLote
                        AND cd.cod_entidade = :codEntidade )
                    LEFT JOIN contabilidade.valor_lancamento AS vld ON (
                        cd.cod_lote = vld.cod_lote
                        AND cd.tipo = vld.tipo
                        AND cd.sequencia = vld.sequencia
                        AND cd.exercicio = vld.exercicio
                        AND cd.tipo_valor = vld.tipo_valor
                        AND cd.cod_entidade = vld.cod_entidade ),
                    contabilidade.plano_analitica AS pac
                LEFT JOIN contabilidade.conta_credito AS cc ON (
                    pac.cod_plano = cc.cod_plano
                    AND pac.exercicio = cc.exercicio
                    AND cc.tipo = 'I'
                    AND cc.cod_lote = :codLote
                    AND cc.cod_entidade = :codEntidade )
                LEFT JOIN contabilidade.valor_lancamento AS vlc ON (
                    cc.cod_lote = vlc.cod_lote
                    AND cc.tipo = vlc.tipo
                    AND cc.sequencia = vlc.sequencia
                    AND cc.exercicio = vlc.exercicio
                    AND cc.tipo_valor = vlc.tipo_valor
                    AND cc.cod_entidade = vlc.cod_entidade )
            WHERE
                pad.cod_plano = pac.cod_plano
                AND pad.exercicio = pac.exercicio
                AND (
                    cc.cod_entidade = :codEntidade
                    OR cd.cod_entidade = :codEntidade ) ) AS tabela ON (
                    pa.cod_plano = tabela.cod_plano
                    AND pa.exercicio = tabela.exercicio )
                LEFT JOIN contabilidade.plano_recurso AS pr ON pr.cod_plano = pa.cod_plano
                AND pr.exercicio = pa.exercicio
            WHERE
                pc.cod_conta = pa.cod_conta
                AND pc.exercicio = pa.exercicio
                AND pc.exercicio = :exercicio
                AND publico.fn_mascarareduzida (
                    cod_estrutural )
                LIKE (
                    publico.fn_mascarareduzida (
                        :codEstrutural )
                    || '%' )
                AND pr.cod_recurso = :codRecurso
            ORDER BY
                cod_estrutural
        ";
        $result = $this->_em->getConnection()->prepare($sql);
        $result->bindValue("exercicio", $exercicio);
        $result->bindValue("codEntidade", $codEntidade);
        $result->bindValue("codLote", $codLote);
        $result->bindValue("codEstrutural", $codEstrutural);
        $result->bindValue("codRecurso", $codRecurso);

        $result->execute();
        $retorno = $result->fetch();
        $conta = null;
        if ($retorno) {
            $conta = $retorno['cod_plano'];
        }
        return $conta;
    }


    /**
     * @param $codSistema
     * @param $exercicio
     * @return array
     */
    public function validarVerificadoSuperavit($codSistema, $exercicio)
    {
        $sql = "SELECT *              
                FROM contabilidade.sistema_contabil
                WHERE ('1' = ANY(string_to_array(grupos,','))
                    OR '2' = ANY(string_to_array(grupos,','))
                ) AND cod_sistema = :cod_sistema AND exercicio = :exercicio ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_sistema', $codSistema);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $codPlano
     * @param $numCgm
     * @return array
     */
    public function getPlanoContaSaldoPorEntidade($exercicio, $codPlano, $numCgm)
    {
        $periodoInicio = '01/01/'.$exercicio;
        $periodoFim ='31/12/'.$exercicio;
        $sql = "
        SELECT  ent.cod_entidade AS codigo, us.nom_cgm AS entidade, 
                contabilidade.fn_soma_valor_contabil(               
                 :exercicio,                   
                 :codPlano,                     
                '',              
                'S', --saldo                                                 
                :periodoInicio,             
                :periodoFim,             
                CAST( ent.cod_entidade AS VARCHAR ), TRUE) AS saldo                                          
         FROM                                                    
             orcamento.entidade AS ent,               
             sw_cgm AS us,             
             orcamento.usuario_entidade AS u                
        WHERE ent.numcgm = us.numcgm            
        AND ent.cod_entidade = u.cod_entidade  
        AND ent.exercicio    = u.exercicio                        
        AND u.exercicio = :exercicio
        AND  u.numcgm = :numCgm
        ORDER BY ent.cod_entidade ";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('periodoInicio', $periodoInicio);
        $query->bindValue('periodoFim', $periodoFim);
        $query->bindValue('codPlano', $codPlano);
        $query->bindValue('numCgm', $numCgm);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $codAcao
     * @return array
     */
    public function getNumCgmPorCodAcao($codAcao)
    {
        $sql = "
        SELECT
           U.numcgm, *
        FROM
           administracao.acao A,
           administracao.funcionalidade F,
           administracao.modulo M,
           administracao.gestao G,
           administracao.usuario U 
        WHERE
           A.cod_funcionalidade = F.cod_funcionalidade 
           AND F.cod_modulo = M.cod_modulo 
           AND G.cod_gestao = M.cod_gestao 
           AND M.cod_responsavel = U.numcgm 
           and cod_acao = :codAcao ";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codAcao', $codAcao);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $nomeConta
     * @param $like
     * @return array
     */
    public function getPlanoContaByExercicioAndCodEstruturalAndCodReduzido($exercicio, $nomeConta, $like)
    {
        $sql = "SELECT                                                   
	     pa.cod_plano,                                        
	     pc.exercicio,                                        
	     pc.cod_conta,                                        
	     pc.nom_conta,                                        
	     pc.cod_estrutural,                                   
	     pa.natureza_saldo                                    
	 FROM                                                     
	     contabilidade.plano_conta     as pc,                 
	     contabilidade.plano_analitica as pa                  
	 WHERE                                                    
	     pc.cod_conta  = pa.cod_conta                         
	 AND pc.exercicio  = pa.exercicio                         
	 AND ".$like." pa.exercicio =  :exercicio   
      AND pc.nom_conta like UPPER(:nomeConta)
      ORDER BY pc.cod_estrutural";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('nomeConta', '%'.$nomeConta.'%');
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $codEstrutural
     * @return array
     */
    public function verificaContaDesdobrada($exercicio, $codEstrutural)
    {
        $sql = "select case when( select contas from
                    ( select count( 1 ) as contas from contabilidade.plano_conta
                        where exercicio = '".$exercicio."' and cod_estrutural like publico.fn_mascarareduzida('".$codEstrutural."')|| '%' ) as stbl
                    )> 1 then true
                    else false
                end as RETORNO";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param $exercicio
     * @param $codEstrutural
     * @return array
     */
    public function verificaMovimentacaoConta($exercicio, $codEstrutural)
    {
        $sql = "select case when(
                    select count( pc.cod_estrutural ) from contabilidade.plano_conta as pc join(
                            select pad.cod_conta, pad.exercicio, cd.cod_plano from
                                contabilidade.plano_analitica as pad inner join contabilidade.conta_debito as cd on
                                ( pad.cod_plano = cd.cod_plano and pad.exercicio = cd.exercicio )
                        ) as pad on ( pc.cod_conta = pad.cod_conta and pc.exercicio = pad.exercicio ) join(
                            select pac.cod_conta, pac.exercicio, cc.cod_plano from
                                contabilidade.plano_analitica as pac inner join contabilidade.conta_credito as cc on
                                ( pac.cod_plano = cc.cod_plano and pac.exercicio = cc.exercicio ) ) as pac on
                        (  pc.cod_conta = pac.cod_conta and pc.exercicio = pac.exercicio )
                    where pc.cod_estrutural like publico.fn_mascarareduzida('".$codEstrutural."')||'%'
                    and pc.exercicio = '".$exercicio."' )> 1 then true
                else false
            end as RETORNO";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param $codEstrutural
     * @param $exercicio
     * @param $modulo
     * @return mixed
     */
    public function verificaLancamentosEmConta($codEstrutural, $exercicio, $modulo)
    {
        $sql = "select
                    count( cod_conta ) as quantidade
                from
                    contabilidade.plano_conta
                where
                    publico.fn_mascarareduzida(cod_estrutural) like(
                        publico.fn_mascarareduzida('".$codEstrutural."')|| '%'
                    )
                    and publico.fn_mascara_completa(
                        (
                            select
                                valor
                            from
                                administracao.configuracao
                            where
                                cod_modulo = ".$modulo."
                                and exercicio = '".$exercicio."'
                                and parametro = 'masc_plano_contas'
                        ),
                        cod_estrutural
                    )!= '".$codEstrutural."'
                    and exercicio = '".$exercicio."'";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $codOrdenacao
     * @return array
     */
    public function findContaBancaria($exercicio, $codEntidade, $codOrdenacao)
    {
        /**
         * @see gestaoPrestacaoContas/fontes/PHP/TCEMG/classes/mapeamento/TTCEMGContaBancaria.class.php:179
         */
        $codEstrutural = '1.1.1.1.1%';
        $codEstruturalAlternative = '1.1.1.1.1.50%';
        $codEntidadeAlternative = 3;
        $ordenacao = ' ORDER BY pc.cod_estrutural, banco.num_banco, agencia.num_agencia, conta_corrente.num_conta_corrente';

        if ($codEntidade == $codEntidadeAlternative) {
            $codEstrutural = $codEstruturalAlternative;
        }

        if ($codOrdenacao == 2 ) {
            $ordenacao = ' ORDER BY banco.num_banco, agencia.num_agencia, conta_corrente.num_conta_corrente';
        }

        $sql = "SELECT    pc.cod_estrutural
	                    , pc.exercicio
	                    , pc.nom_conta
	                    , pc.cod_conta
	                    , publico.fn_mascarareduzida(pc.cod_estrutural) as cod_reduzido
	                    , tabela.vl_lancamento
	                    , pa.cod_plano
	                    , tabela.sequencia
	                    , pa.natureza_saldo
	                    , cb.cod_tipo_aplicacao
	                    , cb.cod_ctb_anterior
	                    , banco.num_banco AS num_banco
	                    , agencia.num_agencia 
	                    , conta_corrente.num_conta_corrente 
	                      
	               FROM contabilidade.plano_conta as pc
	
	         INNER JOIN contabilidade.plano_analitica as pa
	                 ON pc.cod_conta = pa.cod_conta
	                AND pc.exercicio = pa.exercicio
	
	         INNER JOIN contabilidade.plano_banco as pb
	                 ON pb.cod_plano = pa.cod_plano
	                AND pb.exercicio = pa.exercicio
	                
	               JOIN monetario.banco
	                 ON banco.cod_banco = pb.cod_banco
	                  
	               JOIN monetario.agencia
	                 ON agencia.cod_agencia = pb.cod_agencia
	                AND agencia.cod_banco = pb.cod_banco
	                  
	               JOIN monetario.conta_corrente
	                 ON conta_corrente.cod_banco =pb.cod_banco
	                AND conta_corrente.cod_conta_corrente = pb.cod_conta_corrente
	               
	          LEFT JOIN tcemg.conta_bancaria as cb
	                 ON  cb.cod_conta = pc.cod_conta
	                AND cb.exercicio = pc.exercicio
	                
	          LEFT JOIN (
	                      SELECT CASE WHEN pac.cod_plano IS NOT NULL  THEN pac.cod_plano  ELSE pad.cod_plano END AS cod_plano
	                              , CASE WHEN cc.cod_entidade IS NOT NULL THEN cc.cod_entidade ELSE cd.cod_entidade END AS cod_entidade
	                              , CASE WHEN vlc.vl_lancamento IS NOT NULL  THEN vlc.vl_lancamento ELSE vld.vl_lancamento  END AS vl_lancamento
	                              , CASE WHEN vlc.sequencia IS NOT NULL THEN vlc.sequencia ELSE vld.sequencia END AS sequencia
	                              , CASE WHEN cc.cod_entidade IS NOT NULL THEN cc.cod_entidade ELSE cd.cod_entidade END AS cod_entidade
	                              , CASE WHEN cc.exercicio IS NOT NULL THEN cc.exercicio  ELSE cd.exercicio END AS exercicio
	                        FROM contabilidade.plano_analitica as pad
	
	                   LEFT JOIN contabilidade.conta_debito as cd
	                          ON (     pad.cod_plano = cd.cod_plano
	                               AND pad.exercicio = cd.exercicio
	                               AND cd.tipo = 'I'
	                               AND cd.cod_lote = 1
	                               AND cd.cod_entidade = :codEntidade
	                            )
	
	                   LEFT JOIN  contabilidade.valor_lancamento as vld
	                          ON (     cd.cod_lote = vld.cod_lote
	                               AND cd.tipo = vld.tipo
	                               AND cd.sequencia = vld.sequencia
	                               AND cd.exercicio = vld.exercicio
	                               AND cd.tipo_valor = vld.tipo_valor
	                               AND cd.cod_entidade = vld.cod_entidade
	                            )
	                               , contabilidade.plano_analitica as pac
	                   LEFT JOIN contabilidade.conta_credito as cc
	                          ON (     pac.cod_plano = cc.cod_plano
	                               AND pac.exercicio = cc.exercicio
	                               AND cc.tipo = 'I'
	                               AND cc.cod_lote = 1
	                               AND cc.cod_entidade = :codEntidade
	                            )
	
	                   LEFT JOIN contabilidade.valor_lancamento as vlc
	                          ON (     cc.cod_lote = vlc.cod_lote
	                               AND cc.tipo = vlc.tipo
	                               AND cc.sequencia = vlc.sequencia
	                               AND cc.exercicio = vlc.exercicio
	                               AND cc.tipo_valor = vlc.tipo_valor
	                               AND cc.cod_entidade = vlc.cod_entidade
	                           )
	
	                        WHERE   pad.cod_plano = pac.cod_plano
	                          AND     pad.exercicio = pac.exercicio
	                          AND     ( cc.cod_entidade = :codEntidade OR cd.cod_entidade = :codEntidade)
	            ) AS tabela
	            
	            ON (  pa.cod_plano = tabela.cod_plano AND pa.exercicio = tabela.exercicio
	            )
	
	        WHERE pc.exercicio    = :exercicio
	          AND pb.cod_entidade = :codEntidade AND (pc.cod_estrutural like :codEstrutural OR pc.cod_estrutural like '1.1.4%') {$ordenacao}
";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('codEntidade', (int) $codEntidade);
        $query->bindValue('codEstrutural', $codEstrutural);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $entidade
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findConvenioContaBancaria($exercicio, $entidade)
    {
        $qb = $this->createQueryBuilder('pc')
            ->innerJoin('Urbem\CoreBundle\Entity\Contabilidade\PlanoAnalitica', 'pa', 'WITH', 'pc.codConta = pa.codConta AND pc.exercicio = pa.exercicio')
            ->innerJoin('Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco', 'pb', 'WITH', 'pa.codPlano = pb.codPlano AND pa.exercicio = pb.exercicio')
            ->leftJoin('Urbem\CoreBundle\Entity\Tcemg\ConvenioPlanoBanco', 'tcepb', 'WITH', 'pb.codPlano = tcepb.codPlano AND pb.exercicio = tcepb.exercicio')
            ->where('pb.exercicio = :exercicio')
            ->andWhere('pb.codEntidade = :entidade')
            ->orderBy('pc.codEstrutural')
            ->setParameter('exercicio', $exercicio)
            ->setParameter('entidade', $entidade);

        return $qb;
    }

    /**
     * gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterExt.php:177
     * gestaoFinanceira/fontes/PHP/contabilidade/popups/planoConta/LSPlanoConta.php:160
     *
     * @param $term
     */
    public function getTCEMgContaAnaliticaEstruturalExtmmaByExericioAndTermAsQueryBuilder($exercicio, $term)
    {
        $notExitsQueryBuilder = $this->_em->getRepository(BalanceteExtmmaa::class)->createQueryBuilder('BalanceteExtmmaa');
        $notExitsQueryBuilder->andWhere('BalanceteExtmmaa.codPlano = fkContabilidadePlanoAnalitica.codPlano');

        $mainQueryBuilder = $this->createQueryBuilder('PlanoConta');
        $mainQueryBuilder->join('PlanoConta.fkContabilidadePlanoAnalitica', 'fkContabilidadePlanoAnalitica');

        // gestaoFinanceira/fontes/PHP/contabilidade/popups/planoConta/LSPlanoConta.php:169
        $mainQueryBuilder->andWhere($mainQueryBuilder->expr()->not($mainQueryBuilder->expr()->exists($notExitsQueryBuilder)));

        // gestaoFinanceira/fontes/PHP/contabilidade/popups/planoConta/LSPlanoConta.php:185
//        $orx = $mainQueryBuilder->expr()->orX();
//        foreach (['1.1.2.%', '1.1.3.%', '1.2.1.%', '2.1.1.%', '2.1.2.%', '2.1.9.%', '2.2.1.%', '2.2.2.%', '3.5.%', '4.5.%'] as $index => $codEstrutural) {
//            $parameter = sprintf(':codEstrutural_%d', $index);
//
//            $orx->add($mainQueryBuilder->expr()->like('PlanoConta.codEstrutural', $parameter));
//            $mainQueryBuilder->setParameter($parameter, $codEstrutural);
//        }

//        $mainQueryBuilder->andWhere($orx);

        // gestaoPrestacaoContas/fontes/PHP/TCEMG/instancias/configuracao/FMManterExt.php:117
        $orx = $mainQueryBuilder->expr()->orX();

        foreach (['1.%', '2.%', '3.5.%', '4.5.%', '5.%', '6.%'] as $index => $codEstrutural) {
            $parameter = sprintf(':codEstrutural_%d', $index);

            $orx->add($mainQueryBuilder->expr()->like('PlanoConta.codEstrutural', $parameter));
            $mainQueryBuilder->setParameter($parameter, $codEstrutural);
        }

        $mainQueryBuilder->andWhere($orx);

        $orx = $mainQueryBuilder->expr()->orX();
        $orx->add($mainQueryBuilder->expr()->like('LOWER(PlanoConta.codEstrutural)', ':term'));
        $orx->add($mainQueryBuilder->expr()->like('LOWER(PlanoConta.nomConta)', ':term'));
        $orx->add($mainQueryBuilder->expr()->like('LOWER(PlanoConta.funcao)', ':term'));

        $mainQueryBuilder->andWhere($orx);
        $mainQueryBuilder->setParameter('term', sprintf('%%%s%%', strtolower($term)));

        $mainQueryBuilder->andWhere('PlanoConta.exercicio = :exercicio');
        $mainQueryBuilder->setParameter('exercicio', $exercicio);

        $mainQueryBuilder->orderBy('PlanoConta.codEstrutural', 'DESC');
        $mainQueryBuilder->setMaxResults(10);

        return $mainQueryBuilder;
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function findGrupoContas($exercicio)
    {
        $sql = "
	        SELECT *                                                
	          ,substr(cod_estrutural,1,1) as cod_grupo          
	            FROM   contabilidade.plano_conta                     
	            WHERE publico.fn_mascarareduzida(cod_estrutural)    
	            IN ( SELECT DISTINCT                                    
	                substr(cod_estrutural,1,1) as cod_grupo            
	                  FROM                                                
	                    contabilidade.plano_conta                    
	                )                                                        
	            AND  exercicio = :exercicio  ORDER BY cod_grupo
";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $entidade
     * @param $codGrupo
     * @return array
     */
    public function findVincularPlanoContaMG($exercicio, $entidade, $codGrupo)
    {
        $initialDate = '01/01' . $exercicio;
        $finalDate = '31/12' . $exercicio;
        $sql = "	         SELECT tabela.cod_estrutural
	                    , pc.cod_conta
	                    , pc.nom_conta
	                    , pc.exercicio
	                    , pa.cod_plano
	                    , pct.cod_uf
	                    , pct.cod_plano AS cod_plano_estrutura
	                    , CASE WHEN pct.codigo_estrutural IS NULL
	                           THEN pce.codigo_estrutural
	                           ELSE pct.codigo_estrutural
	                      END AS cod_estrutural_estrutura
	                    , CASE WHEN pct.codigo_estrutural IS NULL
	                           THEN 'Não'
	                           ELSE ''
	                      END AS vinculado
	                 FROM contabilidade.fn_rl_balancete_verificacao( '{$exercicio}'
	                                                               , 'cod_entidade IN (". $entidade .") AND cod_estrutural LIKE ''". $codGrupo . ".%'' AND exercicio = ''"  . $exercicio . "'''
	                                                               , '{$initialDate}'
	                                                               , '{$finalDate}'
	                                                               , 'A'
	                                                               ) AS tabela
	                                                               ( cod_estrutural VARCHAR
	                                                               , nivel INTEGER
	                                                               , nom_conta VARCHAR
	                                                               , cod_sistema INTEGER
	                                                               , indicador_superavit CHAR(12)
	                                                               , vl_saldo_anterior NUMERIC
	                                                               , vl_saldo_debitos NUMERIC
	                                                               , vl_saldo_creditos NUMERIC
	                                                               , vl_saldo_atual NUMERIC
	                                                               )
	
	           INNER JOIN contabilidade.plano_conta AS pc 
	                   ON pc.cod_estrutural = tabela.cod_estrutural
	                  AND pc.exercicio = '{$exercicio}'
	
	           INNER JOIN contabilidade.plano_analitica as pa
	                   ON pa.cod_conta = pc.cod_conta
	                  AND pa.exercicio = pc.exercicio
	
	            LEFT JOIN tcemg.plano_contas AS pct
	                   ON pct.cod_conta = pc.cod_conta
	                  AND pct.exercicio = pc.exercicio
	
	            LEFT JOIN (
	                       select publico.fn_mascarareduzida(plano_conta_estrutura.codigo_estrutural)||'%' AS estrutural_teste
	                            , plano_conta_estrutura.codigo_estrutural
	                         from contabilidade.plano_conta_estrutura
	                        where plano_conta_estrutura.cod_uf = 11
	                          and plano_conta_estrutura.cod_plano = 1
	                          and plano_conta_estrutura.escrituracao = 'S' --CONTAS UTILIZADAS PELO TRIBUNAL DE CONTAS DO ESTADO DE MINAS GERAIS
	                          and plano_conta_estrutura.codigo_estrutural like '{$codGrupo}.%'
	                          and ( SELECT COUNT(plano_contas.cod_conta)
	                                  FROM contabilidade.plano_conta
	                            INNER JOIN tcemg.plano_contas
	                                    ON plano_contas.cod_conta = plano_conta.cod_conta
	                                   AND plano_contas.exercicio = plano_conta.exercicio
	                                   AND plano_contas.cod_uf    = plano_conta_estrutura.cod_uf
	                                   AND plano_contas.cod_plano = plano_conta_estrutura.cod_plano
	                                 WHERE plano_conta.cod_estrutural LIKE '{$codGrupo}.%'
	                                   AND plano_conta.exercicio = '{$exercicio}'
	                              ) = 0
	                      ) as pce
	                   ON pc.cod_estrutural ILIKE pce.estrutural_teste
	
	                WHERE pc.cod_estrutural LIKE '{$codGrupo}.%'
	                ORDER BY tabela.cod_estrutural
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
}
