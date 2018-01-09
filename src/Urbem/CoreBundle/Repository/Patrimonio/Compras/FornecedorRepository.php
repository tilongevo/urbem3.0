<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 26/07/16
 * Time: 16:06
 */

namespace Urbem\CoreBundle\Repository\Patrimonio\Compras;

use Doctrine\DBAL\Types\Type;
use Doctrine\ORM;

class FornecedorRepository extends ORM\EntityRepository
{
    public function ativarFornecedor($codFornecedor)
    {
        $this->alterarInativacao($codFornecedor);
        return $this->atualizarFornecedor($codFornecedor, "true");
    }

    public function inativarFornecedor($codFornecedor)
    {
        $this->incluirInativacao($codFornecedor);
        return $this->atualizarFornecedor($codFornecedor, "false");
    }

    private function atualizarFornecedor($codFornecedor, $ativo)
    {
        $sql = "
            UPDATE 
                compras.fornecedor
            SET ativo = $ativo
            WHERE cgm_fornecedor = $codFornecedor
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    private function incluirInativacao($codFornecedor)
    {
        $sql = "
            INSERT INTO 
                compras.fornecedor_inativacao
                (cgm_fornecedor, timestamp_inicio, timestamp_fim, motivo)
            VALUES
                ($codFornecedor, NOW(), null, null)
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    private function alterarInativacao($codFornecedor)
    {
        $sql = "
            UPDATE
                compras.fornecedor_inativacao
            SET
                timestamp_fim = NOW()
            WHERE cgm_fornecedor = $codFornecedor
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function getFornecedores($exercicio, $codMapa, $codItem, $lote)
    {
        $sql = "SELECT sw_cgm.nom_cgm ,
                       marca.descricao ,
                       fornecedor.tipo ,
                       cotacao_fornecedor_item.lote ,
                       cotacao_fornecedor_item.vl_cotacao AS vl_total ,
                       cotacao_fornecedor_item.cgm_fornecedor ,
                       cotacao_fornecedor_item.lote ,
                       cotacao_item.quantidade ,
                       row_number() OVER () AS ordem,
                       CASE
                           WHEN cotacao_fornecedor_item_desclassificacao.cod_item IS NULL THEN julgamento_item.justificativa
                           ELSE cotacao_fornecedor_item_desclassificacao.justificativa
                       END AS justificativa ,
                       CAST ((cotacao_fornecedor_item.vl_cotacao / cotacao_item.quantidade) AS numeric(14,2)) AS vl_unitario ,
                            catalogo_item.descricao_resumida AS item ,
                            CASE
                                WHEN (EXISTS
                                        (SELECT cotacao_fornecedor_item_desclassificacao.cgm_fornecedor
                                         FROM compras.cotacao_fornecedor_item_desclassificacao
                                         WHERE cotacao_fornecedor_item.cgm_fornecedor = cotacao_fornecedor_item_desclassificacao.cgm_fornecedor
                                           AND cotacao_fornecedor_item.cod_item = cotacao_fornecedor_item_desclassificacao.cod_item
                                           AND cotacao_fornecedor_item.cod_cotacao = cotacao_fornecedor_item_desclassificacao.cod_cotacao
                                           AND cotacao_fornecedor_item.exercicio = cotacao_fornecedor_item_desclassificacao.exercicio
                                           AND cotacao_fornecedor_item.lote = cotacao_fornecedor_item_desclassificacao.lote )
                                      OR EXISTS
                                        (SELECT 1
                                         FROM compras.fornecedor_inativacao
                                         WHERE fornecedor_inativacao.timestamp_fim IS NULL
                                           AND fornecedor_inativacao.cgm_fornecedor = cotacao_fornecedor_item.cgm_fornecedor ) ) THEN 'desclassificado'
                                ELSE 'classificado'
                            END AS status ,
                            CASE
                                WHEN (julgamento.timestamp IS NOT NULL) THEN 'true'
                                ELSE 'false'
                            END AS julgado
                FROM compras.cotacao
                JOIN compras.cotacao_item ON (cotacao.exercicio = cotacao_item.exercicio
                                              AND cotacao.cod_cotacao = cotacao_item.cod_cotacao)
                JOIN almoxarifado.catalogo_item ON (cotacao_item.cod_item = catalogo_item.cod_item)
                JOIN compras.cotacao_fornecedor_item ON (cotacao_item.exercicio = cotacao_fornecedor_item.exercicio
                                                         AND cotacao_item.cod_cotacao = cotacao_fornecedor_item.cod_cotacao
                                                         AND cotacao_item.cod_item = cotacao_fornecedor_item.cod_item
                                                         AND cotacao_item.lote = cotacao_fornecedor_item.lote)
                LEFT JOIN compras.julgamento ON cotacao_fornecedor_item.exercicio = julgamento.exercicio
                AND cotacao_fornecedor_item.cod_cotacao = julgamento.cod_cotacao
                LEFT JOIN compras.julgamento_item ON (cotacao_fornecedor_item.exercicio = julgamento_item.exercicio
                                                      AND cotacao_fornecedor_item.cod_cotacao = julgamento_item.cod_cotacao
                                                      AND cotacao_fornecedor_item.cod_item = julgamento_item.cod_item
                                                      AND cotacao_fornecedor_item.lote = julgamento_item.lote
                                                      AND cotacao_fornecedor_item.cgm_fornecedor = julgamento_item.cgm_fornecedor)
                LEFT JOIN compras.cotacao_fornecedor_item_desclassificacao ON cotacao_fornecedor_item.cgm_fornecedor = cotacao_fornecedor_item_desclassificacao.cgm_fornecedor
                AND cotacao_fornecedor_item.cod_item = cotacao_fornecedor_item_desclassificacao.cod_item
                AND cotacao_fornecedor_item.cod_cotacao = cotacao_fornecedor_item_desclassificacao.cod_cotacao
                AND cotacao_fornecedor_item.exercicio = cotacao_fornecedor_item_desclassificacao.exercicio
                AND cotacao_fornecedor_item.lote = cotacao_fornecedor_item_desclassificacao.lote
                JOIN almoxarifado.catalogo_item_marca ON (catalogo_item_marca.cod_item = cotacao_fornecedor_item.cod_item
                                                          AND catalogo_item_marca.cod_marca = cotacao_fornecedor_item.cod_marca)
                JOIN almoxarifado.marca ON (marca.cod_marca = catalogo_item_marca.cod_marca)
                JOIN compras.fornecedor ON (cotacao_fornecedor_item.cgm_fornecedor = fornecedor.cgm_fornecedor)
                JOIN sw_cgm ON (sw_cgm.numcgm = fornecedor.cgm_fornecedor)
                JOIN compras.mapa_cotacao ON (mapa_cotacao.exercicio_cotacao = cotacao.exercicio
                                              AND mapa_cotacao.cod_cotacao = cotacao.cod_cotacao)
                WHERE mapa_cotacao.exercicio_mapa = :exercicio
                  AND mapa_cotacao.cod_mapa = :codMapa
                  AND cotacao_item.cod_item = :codItem
                  AND cotacao_item.lote = :lote
                  AND NOT EXISTS
                    ( SELECT 1
                     FROM compras.cotacao_anulada
                     WHERE cotacao_anulada.cod_cotacao = mapa_cotacao.cod_cotacao
                       AND cotacao_anulada.exercicio = mapa_cotacao.exercicio_cotacao )";
                      
        $query = $this->_em
            ->getConnection()
            ->prepare($sql);
        $query->execute([
          'exercicio' => $exercicio,
          'codMapa' => $codMapa,
          'codItem' => $codItem,
          'lote' => $lote
        ]);

        return  $query->fetchAll();
    }

    public function hasFornecedoresInativos($exercicio, $codMapa, $codItem, $lote)
    {
        return count($this->getFornecedoresInativos($exercicio, $codMapa, $codItem, $lote)) > 0;
    }

    public function getFornecedoresInativos($exercicio, $codMapa, $codItem, $lote)
    {
        $fornecedoresInativos = [];
        foreach ($this->getFornecedores($exercicio, $codMapa, $codItem, $lote) as $fornecedorItem) {
            $fornecedor = $this->getFornecedor($fornecedorItem['cgm_fornecedor']);
            if ($fornecedor['status'] == 'Inativo') {
                $fornecedoresInativos[] = $fornecedor;
            }
        }
        return $fornecedoresInativos;
    }

    public function getFornecedor($cgmFornecedor)
    {
        $sql = "SELECT                                                                              
                    cgm.nom_cgm                                                                     
                    ,f.cgm_fornecedor
                    ,CASE WHEN
                        ((fi.timestamp_fim is  null AND fi.timestamp_inicio is null) OR (fi.timestamp_fim is not null ))
                    THEN                                                 
                        'Ativo'                                                                   
                    ELSE                                                                            
                        'Inativo'                                                                     
                    END as status                                                                   
                    ,fi.motivo                                                                      
                    ,a.nom_atividade                                                                
                    ,cf.cod_catalogo                                                                
                    ,cf.cod_classificacao                                                           
                    ,f.vl_minimo_nf                                                                 
                    ,f.tipo                                                                         
                FROM                                                                                
                    sw_cgm as cgm                                                                   
                    ,compras.fornecedor as f                                                        
                    LEFT JOIN  
                        compras.fornecedor_classificacao as cf 
                    ON 
                        f.cgm_fornecedor = cf.cgm_fornecedor
                    LEFT JOIN 
                        compras.fornecedor_atividade as ca 
                    ON 
                        f.cgm_fornecedor = ca.cgm_fornecedor    
                    LEFT JOIN 
                        economico.atividade as a 
                    ON 
                        ca.cod_atividade = a.cod_atividade      
                    LEFT JOIN (SELECT
                                   coalesce(cfi.cgm_fornecedor,null) as cgm_fornecedor
                                  ,cfi.timestamp_inicio
                                  ,cfi.timestamp_fim
                                  ,cfi.motivo       
                               FROM
                                  compras.fornecedor_inativacao as cfi
                                  ,(SELECT        
                                       max(timestamp_inicio) as timestamp_inicio
                                       ,cgm_fornecedor
                                     FROM
                                        compras.fornecedor_inativacao
                                     GROUP BY
                                        cgm_fornecedor
                                    ) as ativacao
                                               
                               WHERE
                                        ativacao.cgm_fornecedor = cfi.cgm_fornecedor                     
                                   AND  ativacao.timestamp_inicio = cfi.timestamp_inicio
                              ) as fi 
                    ON 
                        fi.cgm_fornecedor = f.cgm_fornecedor
                WHERE cgm.numcgm = f.cgm_fornecedor                
                AND f.cgm_fornecedor = :cgmFornecedor     
        ";
        $query = $this->_em
            ->getConnection()
            ->prepare($sql);
        $result = $query->execute([
            'cgmFornecedor' => $cgmFornecedor,
        ]);

        return $result;
    }

    /**
     * @return array
     */
    public function getFornecedoresAtivos()
    {
        $sql = "select
                fornecedor.cgm_fornecedor
            from
                compras.fornecedor
            where
                not exists(
                    select
                        1
                    from
                        compras.fornecedor_inativacao
                    where
                        fornecedor_inativacao.cgm_fornecedor = fornecedor.cgm_fornecedor
                        and(
                            fornecedor_inativacao.timestamp_fim::date > now()::date
                            or fornecedor_inativacao.timestamp_fim is null
                        )
	    );";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function getByTermAsQueryBuilder($term)
    {
        $qb = $this->createQueryBuilder('Fornecedor');
        $qb->join('Fornecedor.fkSwCgm', 'fkSwCgm');

        $orx = $qb->expr()->orX();
        $orx->add($qb->expr()->like('STRING(fkSwCgm.numcgm)', ':term'));
        $orx->add($qb->expr()->like('LOWER(fkSwCgm.nomCgm)', ':term'));

        $qb->andWhere($orx);
        /* gestaoPatrimonial/fontes/PHP/compras/popups/fornecedor/LSProcurarFornecedor.php:118 */
        $qb->andWhere('Fornecedor.ativo = true');

        $qb->setParameter('term', sprintf('%%%s%%', $term), Type::STRING);
        $qb->orderBy('fkSwCgm.numcgm');
        $qb->setMaxResults(10);

        return $qb;
    }
}
