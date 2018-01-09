<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;

class ContratoServidorPrevidenciaRepository extends ORM\EntityRepository
{
    public function getListaPrevidencia()
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf(
                "SELECT previdencia.*
                         , previdencia_previdencia.*
                         , CASE WHEN contrato_servidor_previdencia.cod_contrato IS NULL THEN ''
                           ELSE                           'true'
                           END as booleano
                         , CASE previdencia_previdencia.tipo_previdencia
                           WHEN 'o' THEN 'Oficial'
                           WHEN 'p' THEN 'Privada'
                           END as tipo_previdencia
                      FROM folhapagamento.previdencia_previdencia
                         , (  SELECT cod_previdencia
                                   , max(timestamp) as timestamp
                                FROM folhapagamento.previdencia_previdencia
                            GROUP BY cod_previdencia) max_previdencia_previdencia
                         , folhapagamento.previdencia
                LEFT JOIN (SELECT contrato_servidor_previdencia.cod_contrato
                                , contrato_servidor_previdencia.cod_previdencia
                                , contrato_servidor_previdencia.bo_excluido
                             FROM pessoal.contrato_servidor_previdencia
                                , (  SELECT cod_contrato
                                          , max(timestamp) as timestamp
                                       FROM pessoal.contrato_servidor_previdencia
                                   GROUP BY cod_contrato) max_contrato_servidor_previdencia
                            WHERE contrato_servidor_previdencia.cod_contrato = max_contrato_servidor_previdencia.cod_contrato
                    AND contrato_servidor_previdencia.timestamp    = max_contrato_servidor_previdencia.timestamp
                    AND contrato_servidor_previdencia.bo_excluido IS FALSE
                    AND contrato_servidor_previdencia.cod_contrato is null
                ) as contrato_servidor_previdencia
                      ON previdencia.cod_previdencia = contrato_servidor_previdencia.cod_previdencia
                   WHERE previdencia.cod_previdencia = previdencia_previdencia.cod_previdencia
                    AND previdencia_previdencia.cod_previdencia = max_previdencia_previdencia.cod_previdencia
                    AND previdencia_previdencia.timestamp       = max_previdencia_previdencia.timestamp
                 ORDER BY lower(previdencia_previdencia.descricao)"
            )
        );

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getListaPrevidenciaSelecionados($cod_contrato)
    {
        $query = $this->_em->getConnection()->prepare(
            sprintf(
                "SELECT previdencia.*
                         , previdencia_previdencia.*
                         , CASE WHEN contrato_servidor_previdencia.cod_contrato IS NULL THEN ''
                           ELSE                           'true'
                           END as booleano
                         , CASE previdencia_previdencia.tipo_previdencia
                           WHEN 'o' THEN 'Oficial'
                           WHEN 'p' THEN 'Privada'
                           END as tipo_previdencia
                      FROM folhapagamento.previdencia_previdencia
                         , (  SELECT cod_previdencia
                                   , max(timestamp) as timestamp
                                FROM folhapagamento.previdencia_previdencia
                            GROUP BY cod_previdencia) max_previdencia_previdencia
                         , folhapagamento.previdencia
                LEFT JOIN (SELECT contrato_servidor_previdencia.cod_contrato
                                , contrato_servidor_previdencia.cod_previdencia
                                , contrato_servidor_previdencia.bo_excluido
                             FROM pessoal.contrato_servidor_previdencia
                                , (  SELECT cod_contrato
                                          , max(timestamp) as timestamp
                                       FROM pessoal.contrato_servidor_previdencia
                                   GROUP BY cod_contrato) max_contrato_servidor_previdencia
                            WHERE contrato_servidor_previdencia.cod_contrato = max_contrato_servidor_previdencia.cod_contrato
                    AND contrato_servidor_previdencia.timestamp    = max_contrato_servidor_previdencia.timestamp
                    AND contrato_servidor_previdencia.bo_excluido IS FALSE
                ) as contrato_servidor_previdencia
                      ON previdencia.cod_previdencia = contrato_servidor_previdencia.cod_previdencia
                   WHERE previdencia.cod_previdencia = previdencia_previdencia.cod_previdencia
                    AND previdencia_previdencia.cod_previdencia = max_previdencia_previdencia.cod_previdencia
                    AND previdencia_previdencia.timestamp       = max_previdencia_previdencia.timestamp
                    AND contrato_servidor_previdencia.cod_contrato = '%s'
                 ORDER BY lower(previdencia_previdencia.descricao)",
                $cod_contrato
            )
        );

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function deleteContratoServidorPrevidencia($codContrato)
    {

        $sql = "
        DELETE
        FROM pessoal.contrato_servidor_previdencia
        WHERE cod_contrato = $codContrato";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @param $filtro
     *
     * @return mixed
     */
    public function recuperaRelacionamento($filtro)
    {
        $sql = "
        SELECT contrato_servidor_previdencia.*                                                             
      FROM pessoal.contrato_servidor_previdencia                                                       
         , (  SELECT cod_contrato                                                                      
                   , max(timestamp) as timestamp                                                       
                FROM pessoal.contrato_servidor_previdencia                                             
            GROUP BY cod_contrato) as max_contrato_servidor_previdencia                                
     WHERE contrato_servidor_previdencia.cod_contrato = max_contrato_servidor_previdencia.cod_contrato 
       AND contrato_servidor_previdencia.timestamp = max_contrato_servidor_previdencia.timestamp";

        if ($filtro) {
            $sql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $queryResult = array_shift($query->fetchAll(\PDO::FETCH_OBJ));
        $result = $queryResult;

        return $result;
    }

    /**
     * @param $codPrevidencia
     * @return array
     */
    public function getDadosRelatorioServidor($codPrevidencia)
    {
        $sql = "select
                        fp.cod_previdencia,
                        fpp.timestamp,
                        fpp.descricao,
                        fpp.aliquota,
                        fpp.aliquota_rat,
                        fpp.aliquota_fap,
                        fpp.tipo_previdencia,
                        fp.cod_vinculo,
                        fv.descricao as descricao_vinculo,
                        to_char(
                            fpp.vigencia,
                            'dd/mm/yyyy'
                        ) as vigencia,
                        fp.cod_regime_previdencia
                    from
                        folhapagamento.previdencia fp join(
                            select
                                fpp2.*,
                                previdencia_regime_rat.aliquota_rat,
                                previdencia_regime_rat.aliquota_fap
                            from
                                folhapagamento.previdencia_previdencia fpp2 left join folhapagamento.previdencia_regime_rat on
                                fpp2.cod_previdencia = previdencia_regime_rat.cod_previdencia
                                and fpp2.timestamp = previdencia_regime_rat.timestamp join(
                                    select
                                        cod_previdencia,
                                        max( timestamp ) as timestamp
                                    from
                                        folhapagamento.previdencia_previdencia
                                    group by
                                        cod_previdencia
                                ) max_fpp on
                                max_fpp.cod_previdencia = fpp2.cod_previdencia
                                and max_fpp.timestamp = fpp2.timestamp
                        ) fpp on
                        fpp.cod_previdencia = fp.cod_previdencia join folhapagamento.vinculo fv on
                        fv.cod_vinculo = fp.cod_vinculo
                    where
                        true
                        and fp.cod_previdencia = ".$codPrevidencia;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
