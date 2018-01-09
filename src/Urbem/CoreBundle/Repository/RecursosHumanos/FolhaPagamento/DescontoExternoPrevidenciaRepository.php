<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class DescontoExternoPrevidenciaRepository extends ORM\EntityRepository
{
    public function getMatriculaCgm($codContrato)
    {
        $filter = '';
        $fetchAll = true;

        if ($codContrato) {
            $filter = 'AND cod_contrato = ' . $codContrato . '';
            $fetchAll = false;
        }

        $sql = '
                SELECT * FROM (                                                             
                    SELECT sw_cgm.numcgm                                                        
                         , sw_cgm.nom_cgm                                                       
                         , contrato.*                                                           
                         , recuperarSituacaoDoContratoLiteral(contrato.cod_contrato, 0, \'\') as situacao 
                      FROM pessoal.contrato                                                     
                         , pessoal.servidor_contrato_servidor                                   
                         , pessoal.servidor                                                     
                         , sw_cgm                                                               
                     WHERE contrato.cod_contrato = servidor_contrato_servidor.cod_contrato      
                       AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor      
                       AND servidor.numcgm = sw_cgm.numcgm                                      
                    UNION                                                                       
                    SELECT sw_cgm.numcgm                                                        
                         , sw_cgm.nom_cgm                                                       
                         , contrato.*                                                           
                         , recuperarSituacaoDoContratoLiteral(contrato.cod_contrato, 0, \'\') as situacao 
                      FROM pessoal.contrato                                                     
                         , pessoal.contrato_pensionista                                         
                         , pessoal.pensionista                                                  
                         , sw_cgm                                                               
                     WHERE contrato.cod_contrato = contrato_pensionista.cod_contrato            
                       AND contrato_pensionista.cod_pensionista = pensionista.cod_pensionista   
                       AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente   
                       AND pensionista.numcgm = sw_cgm.numcgm                                   
                       ) as contrato WHERE registro is not null ' . $filter . '
                     ORDER BY  nom_cgm      
        ';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        if (!$fetchAll) {
            $result = $query->fetch(\PDO::FETCH_OBJ);
        } else {
            $result = $query->fetchAll(\PDO::FETCH_OBJ);
        }

        return $result;
    }

    /**
     * @param $params
     * @param $stFiltro
     *
     * @return array
     */
    public function recuperaRelacionamento($params, $stFiltro)
    {
        $sql = "SELECT desconto_externo_previdencia.*  
       , to_char(desconto_externo_previdencia.vigencia,'dd/mm/yyyy') as vigencia_formatado  
       , to_real(desconto_externo_previdencia.vl_base_previdencia) as vl_base_previdencia_formatado  
       , to_real(desconto_externo_previdencia_valor.valor_previdencia) as valor_previdencia  
       , servidor.numcgm 
       , (SELECT sw_cgm.nom_cgm FROM sw_cgm where numcgm = servidor.numcgm) as nom_cgm  
       , contrato.registro   
    FROM folhapagamento.desconto_externo_previdencia 
       , (SELECT max(timestamp) as timestamp 
           , cod_contrato 
        FROM folhapagamento.desconto_externo_previdencia 
       WHERE NOT EXISTS (SELECT 1  
                  FROM folhapagamento.desconto_externo_previdencia_anulado 
                 WHERE desconto_externo_previdencia_anulado.cod_contrato = desconto_externo_previdencia.cod_contrato 
                   AND desconto_externo_previdencia_anulado.timestamp = desconto_externo_previdencia.timestamp) 
         AND vigencia = (SELECT max(vigencia) FROM folhapagamento.desconto_externo_previdencia a1 WHERE a1.cod_contrato = desconto_externo_previdencia.cod_contrato) 
       GROUP BY cod_contrato) as max_desconto 
         LEFT JOIN folhapagamento.desconto_externo_previdencia_valor 
           ON desconto_externo_previdencia_valor.timestamp = max_desconto.timestamp 
          AND desconto_externo_previdencia_valor.cod_contrato = max_desconto.cod_contrato  
         LEFT JOIN pessoal.contrato 
           ON contrato.cod_contrato = max_desconto.cod_contrato 
         LEFT JOIN pessoal.servidor_contrato_servidor 
           ON servidor_contrato_servidor.cod_contrato = max_desconto.cod_contrato 
         LEFT JOIN pessoal.servidor 
           ON servidor.cod_servidor = servidor_contrato_servidor.cod_servidor 
    WHERE desconto_externo_previdencia.timestamp = max_desconto.timestamp 
    AND desconto_externo_previdencia.cod_contrato = max_desconto.cod_contrato";

        if (isset($params["cod_contrato"])) {
            $sql .= " AND desconto_externo_previdencia.cod_contrato = " . $params["cod_contrato"];
        }
        if (isset($params["timestamp"])) {
            $sql .= " AND desconto_externo_previdencia.timestamp = " . $params["timestamp"];
        }
        if (isset($params["registro"])) {
            $sql .= " AND contrato.registro = " . $params["registro"];
        }

        if ($stFiltro) {
            $sql .= $stFiltro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }
}
