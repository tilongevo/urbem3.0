<?php

namespace Urbem\CoreBundle\Repository\Contabilidade;

use Doctrine\ORM;
use Urbem\CoreBundle\Helper\MascaraHelper;
use Urbem\CoreBundle\Repository\AbstractRepository;

class PlanoAnaliticaRepository extends AbstractRepository
{
    public function listarSaldoContaAnalitica($exercicio)
    {
        $sql = sprintf(
            " SELECT * FROM (
                 SELECT
                     cod_plano,
                     cod_estrutural,
                     cod_entidade,  
                     coalesce(sum(vl_lancamento),0.00) as saldo
                 FROM(
                     SELECT 
                         cd.cod_plano,
                         pc.cod_estrutural,
                         cd.cod_entidade,  
                         coalesce(sum(vl.vl_lancamento),0.00) as vl_lancamento,
                         cd.tipo_valor
                     FROM
                         contabilidade.plano_conta       as pc,
                         contabilidade.plano_analitica   as pa,
                         contabilidade.conta_debito      as cd,
                         contabilidade.valor_lancamento  as vl,
                         contabilidade.lancamento        as la,
                         contabilidade.lote              as lo 
                     WHERE pc.cod_conta  = pa.cod_conta
                         AND pc.exercicio    = pa.exercicio
                         AND pa.cod_plano    = cd.cod_plano
                         AND pa.exercicio    = cd.exercicio
                         AND cd.cod_lote     = vl.cod_lote 
                         AND cd.tipo         = vl.tipo     
                         AND cd.sequencia    = vl.sequencia
                         AND cd.exercicio    = vl.exercicio
                         AND cd.tipo_valor   = vl.tipo_valor                             
                         AND cd.cod_entidade = vl.cod_entidade                           
                         AND vl.cod_lote     = la.cod_lote 
                         AND vl.tipo         = la.tipo     
                         AND vl.sequencia    = la.sequencia
                         AND vl.exercicio    = la.exercicio
                         AND vl.cod_entidade = la.cod_entidade                           
                         AND la.cod_lote     = lo.cod_lote 
                         AND la.tipo         = lo.tipo     
                         AND la.exercicio    = lo.exercicio
                         AND la.cod_entidade = lo.cod_entidade
                         AND lo.exercicio = '%s'
                         AND lo.dt_lote >= '%s-01-01'
                         AND lo.dt_lote <= '%s-12-31'
                         GROUP BY pc.cod_estrutural,cd.cod_plano,cd.cod_entidade,cd.tipo_valor
                     UNION
                     SELECT
                         cd.cod_plano,
                         pc.cod_estrutural,
                         cd.cod_entidade,  
                         coalesce(sum(vl.vl_lancamento),0.00) as vl_lancamento,
                         cd.tipo_valor
                     FROM  
                         contabilidade.plano_conta       as pc,                          
                         contabilidade.plano_analitica   as pa,                          
                         contabilidade.conta_credito     as cd,                          
                         contabilidade.valor_lancamento  as vl,                          
                         contabilidade.lancamento        as la,                          
                         contabilidade.lote              as lo                           
                     WHERE pc.cod_conta    = pa.cod_conta
                         AND pc.exercicio    = pa.exercicio
                         AND pa.cod_plano    = cd.cod_plano
                         AND pa.exercicio    = cd.exercicio
                         AND cd.cod_lote     = vl.cod_lote 
                         AND cd.tipo         = vl.tipo     
                         AND cd.sequencia    = vl.sequencia
                         AND cd.exercicio    = vl.exercicio
                         AND cd.tipo_valor   = vl.tipo_valor
                         AND cd.cod_entidade = vl.cod_entidade
                         AND vl.cod_lote     = la.cod_lote
                         AND vl.tipo         = la.tipo
                         AND vl.sequencia    = la.sequencia
                         AND vl.exercicio    = la.exercicio
                         AND vl.cod_entidade = la.cod_entidade
                         AND la.cod_lote     = lo.cod_lote 
                         AND la.tipo         = lo.tipo
                         AND la.exercicio    = lo.exercicio
                         AND la.cod_entidade = lo.cod_entidade
                         AND lo.exercicio = '%s'
                         AND lo.dt_lote >= '%s-01-01'
                         AND lo.dt_lote <= '%s-12-31'
                         GROUP BY pc.cod_estrutural,cd.cod_plano,cd.cod_entidade,cd.tipo_valor 
                 ) as tabela
                 GROUP BY cod_estrutural,cod_plano,cod_entidade                          
                 ORDER BY cod_plano 
             ) AS tabela   
             WHERE saldo <> 0.00 ",
            $exercicio,
            $exercicio,
            $exercicio,
            $exercicio,
            $exercicio,
            $exercicio
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    public function listarLoteImplantacao($params)
    {
        $sql = sprintf(
            "
            SELECT
                pc.cod_estrutural,
                pc.exercicio,
                pc.nom_conta,
                pc.cod_conta,
                publico.fn_mascarareduzida(pc.cod_estrutural) AS cod_reduzido,
                tabela.vl_lancamento,
                pa.cod_plano,
                tabela.sequencia,
                pa.natureza_saldo
            FROM
                contabilidade.plano_conta AS pc,
                contabilidade.plano_analitica AS pa LEFT JOIN (
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
                    FROM contabilidade.plano_analitica AS pad LEFT JOIN contabilidade.conta_debito AS cd ON
                        (
                            pad.cod_plano = cd.cod_plano
                            AND pad.exercicio = cd.exercicio
                            AND cd.tipo = 'I'
                            AND cd.cod_lote = 1
                            AND cd.cod_entidade = %d
                        ) LEFT JOIN contabilidade.valor_lancamento AS vld ON
                        (
                            cd.cod_lote = vld.cod_lote
                            AND cd.tipo = vld.tipo
                            AND cd.sequencia = vld.sequencia
                            AND cd.exercicio = vld.exercicio
                            AND cd.tipo_valor = vld.tipo_valor
                            AND cd.cod_entidade = vld.cod_entidade
                        ),
                        contabilidade.plano_analitica as pac LEFT JOIN contabilidade.conta_credito as cc on
                        (
                            pac.cod_plano = cc.cod_plano
                            AND pac.exercicio = cc.exercicio
                            AND cc.tipo = 'I'
                            AND cc.cod_lote = 1
                            AND cc.cod_entidade = %d
                        ) LEFT JOIN contabilidade.valor_lancamento AS vlc ON
                        (
                            cc.cod_lote = vlc.cod_lote
                            AND cc.tipo = vlc.tipo
                            AND cc.sequencia = vlc.sequencia
                            AND cc.exercicio = vlc.exercicio
                            AND cc.tipo_valor = vlc.tipo_valor
                            AND cc.cod_entidade = vlc.cod_entidade
                        )
                    where
                        pad.cod_plano = pac.cod_plano
                        AND pad.exercicio = pac.exercicio
                        AND (cc.cod_entidade = %d OR cd.cod_entidade = %d)
                ) AS tabela ON (pa.cod_plano = tabela.cod_plano AND pa.exercicio = tabela.exercicio) 
                LEFT JOIN contabilidade.plano_recurso AS pr ON pr.cod_plano = pa.cod_plano
                AND pr.exercicio = pa.exercicio
            WHERE
                pc.cod_conta = pa.cod_conta
                AND pc.exercicio = pa.exercicio
                AND pc.exercicio = '%s'
                AND publico.fn_mascarareduzida(cod_estrutural) like (
                  publico.fn_mascarareduzida('%s') || '%%'
                )
            ORDER BY cod_estrutural",
            $params['codEntidade'],
            $params['codEntidade'],
            $params['codEntidade'],
            $params['codEntidade'],
            $params['exercicio'],
            $params['codEstrutural']
        );

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    private function getPlanoContaSinteticaAtivoPermanenteAsQueryBuilder($exercicio, $codEstrutural)
    {
        $codEstrutural = MascaraHelper::reduzida($codEstrutural);

        $qb = $this->createQueryBuilder('pa');
        $qb->select('pa, pc');

        $qb->join('pa.fkContabilidadePlanoConta', 'pc');

        $qb->andWhere('pa.exercicio = :exercicio AND pa.codConta IS NOT NULL');
        $qb->setParameter('exercicio', $exercicio);

        if (0 < strlen($codEstrutural)) {
            $qb->andWhere($qb->expr()->like('pc.codEstrutural', $qb->expr()->literal(sprintf('%%%s%%', $codEstrutural))));
        }

        $qb->orderBy('pc.nomConta');

        return $qb;
    }

    public function getNewCodPlano($exercicio)
    {
        return $this->nextVal('cod_plano',['exercicio' => $exercicio]);
    }

    public function getPlanoContaContabilBemAsQueryBuilder($exercicio)
    {
        return $this->getPlanoContaSinteticaAtivoPermanenteAsQueryBuilder($exercicio, '1.2.3');
    }

    public function getPlanoContaTransferenciaAsQueryBuilder($exercicio)
    {
        return $this->getPlanoContaSinteticaAtivoPermanenteAsQueryBuilder($exercicio, '3');
    }

    public function getPlanoContaDoacaoAsQueryBuilder($exercicio)
    {
        return $this->getPlanoContaSinteticaAtivoPermanenteAsQueryBuilder($exercicio, '3');
    }

    public function getPlanoContaPerdaInvoluntariaAsQueryBuilder($exercicio)
    {
        return $this->getPlanoContaSinteticaAtivoPermanenteAsQueryBuilder($exercicio, '3');
    }

    public function getPlanoContaAlienacaoGanhoAsQueryBuilder($exercicio)
    {
        return $this->getPlanoContaSinteticaAtivoPermanenteAsQueryBuilder($exercicio, '4.6.2.2.1');
    }

    public function getPlanoContaAlienacaoPerdaAsQueryBuilder($exercicio)
    {
        return $this->getPlanoContaSinteticaAtivoPermanenteAsQueryBuilder($exercicio, '3.6.2.2.1');
    }

    public function getPlanoContaDepreciacaoAsQueryBuilder($exercicio)
    {
        return $this->getPlanoContaSinteticaAtivoPermanenteAsQueryBuilder($exercicio, '1.2.3.8.1');
    }

    /**
     * @param $codPlano
     * @param $exercicio
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findOneContaContabilByCodPlanoQueryBuilder($codPlano, $exercicio)
    {
        $qb = $this->createQueryBuilder('pa');
        $qb->join('pa.fkContabilidadePlanoConta', 'pc');
        $qb->andWhere('pa.exercicio = :exercicio AND pa.codPlano = :codPlano');
        $qb->setParameter('exercicio', $exercicio);
        $qb->setParameter('codPlano', $codPlano);

        return $qb;
    }

    /**
     * @param $codConta
     * @param $exercicio
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findOneContaContabilByCodContaQueryBuilder($codConta, $exercicio)
    {
        $qb = $this->createQueryBuilder('pa');
        $qb->join('pa.fkContabilidadePlanoConta', 'pc');
        $qb->andWhere('pa.exercicio = :exercicio AND pa.codConta = :codConta');
        $qb->setParameter('exercicio', $exercicio);
        $qb->setParameter('codConta', $codConta);

        return $qb;
    }

    /**
     * @param $codPlano
     * @param $exercicio
     * @return mixed
     */
    public function findOneContaContabilByCodPlano($codPlano, $exercicio)
    {
        return $this->findOneContaContabilByCodPlanoQueryBuilder($codPlano, $exercicio)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * @param $codConta
     * @param $exercicio
     * @return mixed
     */
    public function findOneContaContabilByCodConta($codConta, $exercicio)
    {
        return $this->findOneContaContabilByCodContaQueryBuilder($codConta, $exercicio)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * @param $exercicio
     * @param $term
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getPlanoContaByTermAsQueryBuilder($exercicio, $term)
    {
        $qb = $this->createQueryBuilder('PlanoAnalitica');
        $qb->leftJoin('\Urbem\CoreBundle\Entity\Contabilidade\PlanoConta', 'PlanoConta', 'WITH', 'PlanoAnalitica.codConta = PlanoConta.codConta AND PlanoAnalitica.exercicio = PlanoConta.exercicio');
        $qb->leftJoin('\Urbem\CoreBundle\Entity\Contabilidade\PlanoBanco', 'PlanoBanco', 'WITH', 'PlanoAnalitica.codPlano = PlanoBanco.codPlano AND PlanoAnalitica.exercicio = PlanoBanco.exercicio');
        $qb->where('PlanoBanco.codBanco IS NOT NULL');
        $qb->andWhere('PlanoConta.codEstrutural LIKE :codEstrutural');
        $qb->andWhere('PlanoConta.exercicio = :exercicio');

        $orx = $qb->expr()->orX();
        $orx->add($qb->expr()->like('LOWER(PlanoConta.nomConta)', ':term'));
        $qb->andWhere($orx);

        $qb->setParameter('term', sprintf('%%%s%%', strtolower($term)));
        $qb->setParameter('codEstrutural', '1.1.1.%');
        $qb->setParameter('exercicio', $exercicio);
        $qb->orderBy('PlanoConta.codEstrutural', 'ASC');

        return $qb;
    }
}
