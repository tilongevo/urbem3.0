<?php

namespace Urbem\CoreBundle\Model\Orcamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Repository;

class SuplementacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;
    const CODIGO_HISTORICO_TRANSFERENCIA = 993;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Orcamento\\Suplementacao");
    }

    public function recuperaExcetoAnuladas()
    {
        $subQueryAnulacao = $this->entityManager->createQueryBuilder();
        $subQueryAnulacao
            ->select('codSuplementacao')
            ->from('CoreBundle:Orcamento\SuplementacaoAnulada', 'SuplementacaoAnulada');
        $subQueryAnulada = $this->entityManager->createQueryBuilder();
        $subQueryAnulada
            ->select('codSuplementacaoAnulacao')
            ->from('CoreBundle:Orcamento\SuplementacaoAnulada', 'SuplementacaoAnulada');

        $query = $this->entityManager->createQueryBuilder();
        $query->select('Suplementacao')
            ->from('CoreBundle:Orcamento\Suplementacao', 'Suplementacao')
            ->where($query->expr()->notIn('Suplementacao.codSuplementacao', $subQueryAnulacao->getDQL()))
            ->orWhere($query->expr()->notIn('Suplementacao.codSuplementacao', $subQueryAnulada->getDQL()));

        return $query;
    }

    public function filterSuplementacao($filter, $exercicio)
    {
        $sql = "
        SELECT OS.cod_suplementacao
        FROM orcamento.suplementacao          AS OS
        LEFT JOIN (
        		SELECT OSS.exercicio
        		     ,OSS.cod_suplementacao
        		     ,MAX( OSS.cod_despesa ) as cod_despesa
        		     ,MAX( RECURSO.cod_recurso ) as cod_recurso
        		     ,sum( OSS.valor ) as valor
        		     ,OD.cod_entidade
        	       FROM orcamento.suplementacao_suplementada AS OSS
        		   ,orcamento.despesa                    AS OD
        		   ,orcamento.recurso(:exercicio_1)  AS RECURSO
        	       WHERE
        		       OSS.cod_despesa = OD.cod_despesa
        		   AND OSS.exercicio   = OD.exercicio
        		   AND OD.cod_recurso  = RECURSO.cod_recurso
        		   AND OD.exercicio    = RECURSO.exercicio
        		GROUP BY OSS.exercicio
        		       ,OSS.cod_suplementacao
        		       ,RECURSO.cod_recurso
        		       ,OD.cod_entidade
        	       ORDER BY OSS.exercicio
        		       ,OSS.cod_suplementacao
        		       ,RECURSO.cod_recurso
        		     ) AS OSS
        	ON OS.exercicio         = OSS.exercicio
        	AND OS.cod_suplementacao = OSS.cod_suplementacao
        LEFT JOIN (
        		SELECT OSR.exercicio
        		     ,OSR.cod_suplementacao
        		     ,MAX( OSR.cod_despesa ) as cod_despesa
        		     ,( select sum( suplementacao_reducao.valor )
        			  from orcamento.suplementacao_reducao
        			 where suplementacao_reducao.exercicio = OSR.exercicio
        			   and suplementacao_reducao.cod_suplementacao = OSR.cod_suplementacao
        		      ) AS valor
        		     ,OD.cod_entidade
        		 FROM orcamento.suplementacao_reducao AS OSR
        		 INNER JOIN orcamento.despesa                    AS OD
        			 ON OSR.cod_despesa = OD.cod_despesa
        			AND OSR.exercicio   = OD.exercicio
        		      WHERE OSR.exercicio = :exercicio_2
        		 GROUP BY OSR.exercicio
        		       ,OSR.cod_suplementacao
        		       ,OD.cod_entidade
        		 ORDER BY OSR.exercicio
        		       ,OSR.cod_suplementacao
        		     ) AS OSR
        	ON OS.exercicio         = OSR.exercicio
        	AND OS.cod_suplementacao = OSR.cod_suplementacao
        LEFT JOIN orcamento.suplementacao_anulada AS OSA
        	ON (      OS.cod_suplementacao = OSA.cod_suplementacao_anulacao
        		OR OSR.cod_suplementacao = OSA.cod_suplementacao
        	     )
        	AND OS.exercicio         = OSA.exercicio
        LEFT JOIN contabilidade.tipo_transferencia     AS CTT
        	ON OS.cod_tipo          = CTT.cod_tipo
        	AND OS.exercicio         = CTT.exercicio
        LEFT JOIN contabilidade.transferencia_despesa  AS CTD
        	ON OS.cod_tipo          = CTD.cod_tipo
        	AND OS.exercicio         = CTD.exercicio
        	AND OS.cod_suplementacao = CTD.cod_suplementacao
        WHERE 1 = 1
        ";

        if (isset($filter['codEntidade']['value'])) {
            $sql .= " AND (OSS.cod_entidade IN (" . implode(',', $filter['codEntidade']['value']) . ") OR OSR.cod_entidade IN (" . implode(',', $filter['codEntidade']['value']) . "))";
        }

        if(isset($filter['leiDecreto'])){
            if ($filter['leiDecreto']['value'] !== "") {
                $sql .= " AND OS.cod_norma = :cod_norma";
            }
        }
        if(isset($filter['dotacao'])){
            if ($filter['dotacao']['value'] !== "") {
                $sql .= " AND (OSS.cod_despesa = :cod_despesa_1) OR (OSR.cod_despesa = :cod_despesa_2)";
            }
        }
        if(isset($filter['recurso'])){
            if ($filter['recurso']['value'] !== "") {
                $sql .= " AND OSS.cod_recurso = :recurso";
            }
        }
        if(isset($filter['periodoInicial'])){
            if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
                $sql .= " AND OS.dt_suplementacao BETWEEN :periodoInicial AND :periodoFinal";
            }
        }
        if(isset($filter['codTipo'])){
            if ($filter['codTipo']['value'] !== "") {
                $sql .= " AND OS.cod_tipo = :codTipo";
            }
        }
        if(isset($filter['situacao'])){
            if ($filter['situacao']['value'] !== "") {
                if($filter['situacao']['value'] == 'a'){
                    $sql .= " AND OS.cod_suplementacao IN ( SELECT cod_suplementacao FROM orcamento.suplementacao_anulada ) ";
                    $sql .= " AND OS.cod_suplementacao IN ( SELECT cod_suplementacao_anulacao FROM orcamento.suplementacao_anulada ) ";
                }
                elseif($filter['situacao']['value'] == 'v'){
                    $sql .= " AND OS.cod_suplementacao NOT IN ( SELECT cod_suplementacao FROM orcamento.suplementacao_anulada ) ";
                    $sql .= " AND OS.cod_suplementacao NOT IN ( SELECT cod_suplementacao_anulacao FROM orcamento.suplementacao_anulada ) ";
                }
            }
        }

        $query = $this->entityManager->getConnection()->prepare($sql);

        $query->bindValue(':exercicio_1', $exercicio, \PDO::PARAM_STR);
        $query->bindValue(':exercicio_2', $exercicio, \PDO::PARAM_STR);

        if(isset($filter['leiDecreto'])){
            if ($filter['leiDecreto']['value'] !== "") {
                $query->bindValue(':cod_norma', $filter['leiDecreto']['value'], \PDO::PARAM_INT);
            }
        }
        if(isset($filter['dotacao'])){
            if ($filter['dotacao']['value'] !== "") {
                $query->bindValue(':cod_despesa_1', $filter['dotacao']['value'], \PDO::PARAM_INT);
                $query->bindValue(':cod_despesa_2', $filter['dotacao']['value'], \PDO::PARAM_INT);
            }
        }
        if(isset($filter['recurso'])){
            if ($filter['recurso']['value'] !== "") {
                $query->bindValue(':recurso', $filter['recurso']['value'], \PDO::PARAM_INT);
            }
        }
        if(isset($filter['periodoInicial'])){
            if ($filter['periodoInicial']['value'] !== "" && $filter['periodoFinal']['value'] !== "") {
                $periodoInicial = \DateTime::createFromFormat("d/m/Y", $filter['periodoInicial']['value'])->format("Y-m-d");
                $periodoFinal = \DateTime::createFromFormat("d/m/Y", $filter['periodoFinal']['value'])->format("Y-m-d");
                $query->bindValue(':periodoInicial', $periodoInicial);
                $query->bindValue(':periodoFinal', $periodoFinal);
            }
        }
        if(isset($filter['codTipo'])){
            if ($filter['codTipo']['value'] !== "") {
                $query->bindValue(':codTipo', $filter['codTipo']['value'], \PDO::PARAM_INT);
            }
        }
        $query->execute();

        $res = $query->fetchAll(\PDO::FETCH_OBJ);

        return $res;
    }

    public function orcamentoSuplementacoesCreditoSuplementar($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar)
    {
        return $this->repository->orcamentoSuplementacoesCreditoSuplementar($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar);
    }

    public function orcamentoSuplementacoesCreditoEspecial($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar)
    {
        return $this->repository->orcamentoSuplementacoesCreditoEspecial($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar);
    }

    public function orcamentoSuplementacoesTransferencia($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $codHistorico)
    {
        return $this->repository->orcamentoSuplementacoesTransferencia($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $codHistorico);
    }

    public function orcamentoSuplementacoesCreditoExtraordinario($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar)
    {
        return $this->repository->orcamentoSuplementacoesCreditoExtraordinario($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar);
    }

    public function orcamentoAnulacaoSuplementacoesCreditoEspecial($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar)
    {
        return $this->repository->orcamentoAnulacaoSuplementacoesCreditoEspecial($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar);
    }

    public function orcamentoAnulacaoSuplementacoesCreditoSuplementar($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar)
    {
        return $this->repository->orcamentoAnulacaoSuplementacoesCreditoSuplementar($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar);
    }

    public function orcamentoAnulacaoSuplementacoesCreditoExtraordinario($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar)
    {
        return $this->repository->orcamentoAnulacaoSuplementacoesCreditoExtraordinario($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar);
    }

    public function orcamentoAnulacaoSuplementacoesTransferencia($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar)
    {
        return $this->repository->orcamentoAnulacaoSuplementacoesTransferencia($exercicio, $valor, $decreto, $codLote, $tipoLote, $entidade, $creditoSuplementar);
    }
}
