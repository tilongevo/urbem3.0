<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;

/**
 * Class ContratoServidorRepository
 *
 * @package Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal
 */
class ContratoServidorRepository extends ORM\EntityRepository
{
    /**
     * @param $cod_periodo_movimentacao
     * @param $cod_complementar
     *
     * @return array
     */
    public function montaRecuperaContratosComRegistroDeEventoReduzido($cod_periodo_movimentacao, $cod_complementar)
    {
        $sql = <<<SQL
SELECT
    servidor_pensionista.*
FROM (
    SELECT
        servidor_contrato_servidor.cod_contrato,
        servidor.numcgm
    FROM
        pessoal.servidor_contrato_servidor,
        pessoal.servidor
    WHERE
        servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
    UNION
    SELECT
        contrato_pensionista.cod_contrato,
        pensionista.numcgm
    FROM
        pessoal.contrato_pensionista,
        pessoal.pensionista
    WHERE
        contrato_pensionista.cod_pensionista = pensionista.cod_pensionista
        AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente) AS servidor_pensionista
WHERE
    NOT EXISTS (
        SELECT
            1
        FROM
            pessoal.contrato_servidor_caso_causa
        WHERE
            servidor_pensionista.cod_contrato = contrato_servidor_caso_causa.cod_contrato)
        AND EXISTS (
            SELECT
                1
            FROM
                folhapagamento.registro_evento_complementar
            WHERE
                servidor_pensionista.cod_contrato = registro_evento_complementar.cod_contrato
                AND registro_evento_complementar.cod_periodo_movimentacao = :cod_periodo_movimentacao
                AND registro_evento_complementar.cod_complementar = :cod_complementar)
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('cod_periodo_movimentacao', $cod_periodo_movimentacao);
        $query->bindValue('cod_complementar', $cod_complementar);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @param string $term
     *
     * @return ORM\QueryBuilder
     */
    public function findByNomCgm($term)
    {
        $consultaContratoLegado = $this->_em->getRepository(Contrato::class)
            ->getContrato($term);

        $codContratoLista = [];
        foreach ($consultaContratoLegado as $codContrato) {
            $codContratoLista[] = $codContrato->cod_contrato;
        }

        $qb = $this->createQueryBuilder('cs');
        $qb->andWhere($qb->expr()->in('cs.codContrato', $codContratoLista));

        return $qb;
    }

    /**
     * Retorna o contrato do servidor pelo número do cgm
     *
     * @param  integer $numcgm
     *
     * @return Contrato|null
     */
    public function findOneByNumcgm($numcgm)
    {
        $qb = $this->createQueryBuilder('cs')
            ->innerJoin('cs.fkPessoalServidorContratoServidores', 'scs')
            ->innerJoin('scs.fkPessoalServidor', 's')
            ->innerJoin('s.fkSwCgmPessoaFisica', 'pf')
            ->innerJoin('pf.fkSwCgm', 'cgm')
            ->where('cgm.numcgm = :numcgm')
            ->setParameter('numcgm', $numcgm)
            ->orderBy('cs.codContrato', 'DESC')
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    /**
     * @param $exercicio
     * @param $entidade
     * @param $params
     *
     * @return array
     */
    public function montaRecuperaContratosServidorResumido($exercicio, $entidade, $params)
    {
        $stFiltro = '';
        $stSql = "SELECT
             pcs.*,
             ps.cod_servidor,
             pc.registro,
             cgm.nom_cgm as servidor,
             cgm.numcgm,
             orgao.cod_orgao,
             recuperaDescricaoOrgao(orgao.cod_orgao, '" . $exercicio . "-01-01') as lotacao,
             vw_orgao_nivel.orgao,
             cargo.cod_cargo,
             cargo.descricao as cargo,
             esp.descricao as esp_cargo,
             cargo_funcao.cod_cargo as cod_funcao,
             cargo_funcao.descricao as funcao,
             to_char(funcao.vigencia,'dd/mm/yyyy') as dt_alteracao_funcao,
             espf.descricao as esp_funcao,
             local.descricao as local,
             pcsl.cod_local,
             to_char(posse.dt_posse,'dd/mm/yyyy') as dt_posse,
             to_char(posse.dt_nomeacao,'dd/mm/yyyy') as dt_nomeacao,
             to_char(posse.dt_admissao,'dd/mm/yyyy') as dt_admissao,
             pcsp.cod_padrao,
             recuperarSituacaoDoContratoLiteral(pc.cod_contrato,0,'" . $entidade . "') as situacao
        	    , forma_pagamento.cod_forma_pagamento
        FROM
             pessoal.servidor_contrato_servidor as psc
        INNER JOIN pessoal.servidor as ps
                on psc.cod_servidor = ps.cod_servidor
        INNER JOIN pessoal.contrato_servidor as pcs
                on pcs.cod_contrato = psc.cod_contrato
        	INNER JOIN pessoal.contrato_servidor_forma_pagamento
         	ON contrato_servidor_forma_pagamento.cod_contrato = pcs.cod_contrato
         	AND contrato_servidor_forma_pagamento.timestamp = ( SELECT MAX(timestamp)
        								    FROM pessoal.contrato_servidor_forma_pagamento
        								    WHERE cod_contrato = pcs.cod_contrato )
         INNER JOIN pessoal.forma_pagamento
            	ON forma_pagamento.cod_forma_pagamento = contrato_servidor_forma_pagamento.cod_forma_pagamento
        INNER JOIN pessoal.contrato as pc
                on pcs.cod_contrato = pc.cod_contrato
        INNER JOIN sw_cgm_pessoa_fisica as pf
                ON ps.numcgm = pf.numcgm
        INNER JOIN sw_cgm as cgm
                ON pf.numcgm = cgm.numcgm
        INNER JOIN pessoal.contrato_servidor_nomeacao_posse as posse
                ON pcs.cod_contrato = posse.cod_contrato
               AND posse.timestamp = (select timestamp
                                        from pessoal.contrato_servidor_nomeacao_posse
                                       where cod_contrato = pcs.cod_contrato
                                    order by timestamp desc
                                       limit 1)
        INNER JOIN pessoal.contrato_servidor_funcao as funcao
                ON pcs.cod_contrato = funcao.cod_contrato
               AND funcao.timestamp = (select timestamp
                                         from pessoal.contrato_servidor_funcao
                                        where cod_contrato = pcs.cod_contrato
                                     order by timestamp desc
                                        limit 1)
        INNER JOIN pessoal.cargo as cargo_funcao
                ON funcao.cod_cargo = cargo_funcao.cod_cargo
        LEFT JOIN pessoal.contrato_servidor_especialidade_cargo as esp_cargo
                ON pcs.cod_contrato = esp_cargo.cod_contrato
         LEFT JOIN pessoal.especialidade as esp
                ON esp_cargo.cod_especialidade = esp.cod_especialidade
         LEFT JOIN pessoal.cargo as cargo
                ON pcs.cod_cargo = cargo.cod_cargo
         LEFT JOIN pessoal.contrato_servidor_local as pcsl
                ON pcs.cod_contrato = pcsl.cod_contrato
               AND pcsl.timestamp = (select timestamp
                                       from pessoal.contrato_servidor_local
                                      where cod_contrato = pcs.cod_contrato
                                   order by timestamp desc
                                      limit 1)
         LEFT JOIN organograma.local as local
                ON pcsl.cod_local = local.cod_local
         LEFT JOIN pessoal.contrato_servidor_padrao as pcsp
                ON pcs.cod_contrato = pcsp.cod_contrato
               AND pcsp.timestamp = (select timestamp
                                       from pessoal.contrato_servidor_padrao
                                      where cod_contrato = pcs.cod_contrato
                                   order by timestamp desc
                                      limit 1)
        LEFT JOIN pessoal.contrato_servidor_especialidade_funcao as esp_funcao
               ON pcs.cod_contrato = esp_funcao.cod_contrato
              AND esp_funcao.timestamp = (select timestamp
                                            from pessoal.contrato_servidor_especialidade_funcao
                                           where cod_contrato = pcs.cod_contrato
                                        order by timestamp desc
                                           limit 1)
         LEFT JOIN pessoal.especialidade as espf
                ON esp_funcao.cod_especialidade = espf.cod_especialidade
        INNER JOIN pessoal.contrato_servidor_orgao as pcso
                ON pcs.cod_contrato = pcso.cod_contrato
               AND pcso.timestamp = (select timestamp
                                       from pessoal.contrato_servidor_orgao
                                      where cod_contrato = pcs.cod_contrato
                                   order by timestamp desc
                                      limit 1)
        INNER JOIN organograma.orgao
                ON pcso.cod_orgao = orgao.cod_orgao
        INNER JOIN organograma.orgao_nivel
                ON orgao.cod_orgao = orgao_nivel.cod_orgao
        INNER JOIN organograma.nivel
                ON orgao_nivel.cod_nivel       = nivel.cod_nivel
               AND orgao_nivel.cod_organograma = nivel.cod_organograma
        INNER JOIN organograma.organograma
                ON nivel.cod_organograma = organograma.cod_organograma
        INNER JOIN organograma.vw_orgao_nivel
                ON orgao.cod_orgao             = vw_orgao_nivel.cod_orgao
               AND organograma.cod_organograma = vw_orgao_nivel.cod_organograma
               AND nivel.cod_nivel             = vw_orgao_nivel.nivel
             WHERE pc.cod_contrato NOT IN (
                                            SELECT cod_contrato
                                              FROM pessoal.contrato_servidor_caso_causa
                                          )";

        if (isset($params['numCgm'])) {
            $stFiltro .= " AND cgm.numcgm =" . $params['numCgm'];
        }

        if (isset($params['codContrato'])) {
            $stFiltro .= " AND pcs.cod_contrato =" . $params['codContrato'];
        }

        if (isset($params['registro'])) {
            $stFiltro .= " AND pc.registro =" . $params['registro'];
        }

        if (isset($params['codCargo'])) {
            $stFiltro .= " AND pcs.cod_cargo =" . $params['codCargo'];
        }

        if (isset($params['codEspecialidade'])) {
            $stFiltro .= " AND esp_cargo.cod_especialidade =" . $params['codEspecialidade'];
        }

        if (isset($params['funcaoCodEspecialidade'])) {
            $stFiltro .= " AND esp_funcao.cod_especialidade =" . $params['funcaoCodEspecialidade'];
        }

        if (isset($params['codPadrao'])) {
            $stFiltro .= " AND pcsp.cod_padrao =" . $params['codPadrao'];
        }

        if (isset($params['codOrgao'])) {
            $stFiltro .= " AND pcso.cod_orgao =" . $params['codOrgao'];
        }

        if (isset($params['codLocal'])) {
            $stFiltro .= " AND pcsl.cod_local =" . $params['codLocal'];
        }

        $stSql .= $stFiltro;

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $stJoin
     * @param $stFiltro
     *
     * @return array
     */
    public function recuperaContratosSEFIP($stJoin, $stFiltro)
    {
        $stSql = "SELECT contrato.*                                                                                       
      FROM pessoal.servidor                                                                                 
    LEFT JOIN (SELECT ctps.*                                                                                
                    , servidor_ctps.cod_servidor                                                            
                 FROM pessoal.servidor_ctps                                                                 
                    , pessoal.ctps                                                                          
                    , (SELECT cod_servidor                                                                  
                            , max(cod_ctps) as cod_ctps                                                     
                         FROM pessoal.servidor_ctps                                                         
                       GROUP BY cod_servidor) as max_servidor_ctps                                          
                WHERE servidor_ctps.cod_ctps = ctps.cod_ctps                                                
                  AND servidor_ctps.cod_ctps = max_servidor_ctps.cod_ctps                                   
                  AND servidor_ctps.cod_servidor = max_servidor_ctps.cod_servidor) as ctps                  
        ON servidor.cod_servidor = ctps.cod_servidor                                                        
         , pessoal.servidor_pis_pasep                                                                       
         , (SELECT cod_servidor                                                                             
                 , max(timestamp) as timestamp                                                              
              FROM pessoal.servidor_pis_pasep                                                               
            GROUP BY cod_servidor) as max_servidor_pis_pasep                                                
         , pessoal.servidor_contrato_servidor                                                               
         , pessoal.contrato_servidor_orgao                                                                  
         , (SELECT cod_contrato                                                                             
                 , max(timestamp) as timestamp                                                              
              FROM pessoal.contrato_servidor_orgao                                                          
            GROUP BY cod_contrato) as max_contrato_servidor_orgao                                           
         , pessoal.contrato_servidor_nomeacao_posse                                                         
         , (SELECT cod_contrato                                                                             
                 , max(timestamp) as timestamp                                                              
              FROM pessoal.contrato_servidor_nomeacao_posse                                                 
            GROUP BY cod_contrato) as max_contrato_servidor_nomeacao_posse                                  
         , pessoal.contrato_servidor                                                                        
         , pessoal.contrato ";

        if ($stJoin) {
            $stSql .= $stJoin;
        }

        $stSql .= "
         , sw_cgm                                                                                           
         , sw_cgm_pessoa_fisica                                                                             
         , pessoal.cargo                                                                                    
         , pessoal.contrato_servidor_ocorrencia                                                             
         , (SELECT cod_contrato                                                                             
                 , max(timestamp) as timestamp                                                              
              FROM pessoal.contrato_servidor_ocorrencia                                                     
            GROUP BY cod_contrato) as max_contrato_servidor_ocorrencia                                      
         , pessoal.ocorrencia                                                                               
     WHERE servidor.cod_servidor = servidor_pis_pasep.cod_servidor                                          
       AND servidor_pis_pasep.cod_servidor = max_servidor_pis_pasep.cod_servidor                            
       AND servidor_pis_pasep.timestamp = max_servidor_pis_pasep.timestamp                                  
       AND servidor.cod_servidor = servidor_contrato_servidor.cod_servidor                                  
       AND servidor_contrato_servidor.cod_contrato = contrato_servidor_nomeacao_posse.cod_contrato          
       AND contrato_servidor_nomeacao_posse.cod_contrato = max_contrato_servidor_nomeacao_posse.cod_contrato
       AND contrato_servidor_nomeacao_posse.timestamp = max_contrato_servidor_nomeacao_posse.timestamp      
       AND servidor_contrato_servidor.cod_contrato = contrato_servidor.cod_contrato                         
       AND servidor_contrato_servidor.cod_contrato = contrato.cod_contrato                                  
       AND contrato_servidor.cod_cargo = cargo.cod_cargo                                                    
       AND servidor.numcgm = sw_cgm.numcgm                                                                  
       AND servidor.numcgm = sw_cgm_pessoa_fisica.numcgm                                                    
       AND contrato_servidor.cod_contrato = contrato_servidor_ocorrencia.cod_contrato                       
       AND contrato_servidor_ocorrencia.cod_contrato = max_contrato_servidor_ocorrencia.cod_contrato        
       AND contrato_servidor_ocorrencia.timestamp = max_contrato_servidor_ocorrencia.timestamp              
       AND contrato_servidor.cod_contrato = contrato_servidor_orgao.cod_contrato                            
       AND contrato_servidor_orgao.cod_contrato = max_contrato_servidor_orgao.cod_contrato                  
       AND contrato_servidor_orgao.timestamp = max_contrato_servidor_orgao.timestamp                        
       AND contrato_servidor_ocorrencia.cod_ocorrencia = ocorrencia.cod_ocorrencia";

        if ($stFiltro) {
            $stSql .= $stFiltro;
        }

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $stFiltro
     * @param $params
     * @param $stOrdem
     *
     * @return array
     */
    public function recuperaRegistroTrabalhadoresSEFIP($stFiltro, $params, $stOrdem)
    {
        $sql = "
      SELECT servidor.numcgm                                                                                  
         , sw_cgm.nom_cgm                                                                                   
         , replace(replace(trim(sw_cgm_pessoa_fisica.servidor_pis_pasep),'.',''),'-','') as servidor_pis_pasep  
         , to_char(contrato_servidor_nomeacao_posse.dt_admissao,'ddmmyyyy') as dt_admissao                  
         , contrato_servidor_nomeacao_posse.dt_admissao as dt_admissao_n_formatado                          
         , cod_categoria                                                                                    
         , registro                                                                                         
         , contrato.cod_contrato                                                                            
         , ctps.numero                                                                                      
         , ctps.serie                                                                                       
         , to_char(contrato_servidor.dt_opcao_fgts,'ddmmyyyy') as dt_opcao_fgts                             
         , to_char(sw_cgm_pessoa_fisica.dt_nascimento,'ddmmyyyy') as dt_nascimento                          
         , (SELECT codigo FROM pessoal.cbo WHERE cbo_cargo.cod_cbo = cod_cbo) as cbo                        
         , ocorrencia.num_ocorrencia                                                                        
      FROM pessoal.servidor                                                                                 
    LEFT JOIN (SELECT ctps.*                                                                                
                    , servidor_ctps.cod_servidor                                                            
                 FROM pessoal.servidor_ctps                                                                 
                    , pessoal.ctps                                                                          
                    , (SELECT cod_servidor                                                                  
                            , max(cod_ctps) as cod_ctps                                                     
                         FROM pessoal.servidor_ctps                                                         
                       GROUP BY cod_servidor) as max_servidor_ctps                                          
                WHERE servidor_ctps.cod_ctps = ctps.cod_ctps                                                
                  AND servidor_ctps.cod_ctps = max_servidor_ctps.cod_ctps                                   
                  AND servidor_ctps.cod_servidor = max_servidor_ctps.cod_servidor) as ctps                  
        ON servidor.cod_servidor = ctps.cod_servidor                                                        
         , pessoal.servidor_pis_pasep                                                                       
         , (SELECT cod_servidor                                                                             
                 , max(timestamp) as timestamp                                                              
              FROM pessoal.servidor_pis_pasep                                                               
            WHERE timestamp <= (ultimotimestampperiodomovimentacao(:codPeriodoMovimentacao,:entidade)::timestamp)     
            GROUP BY cod_servidor) as max_servidor_pis_pasep                                                
         , pessoal.servidor_contrato_servidor                                                               
         , pessoal.contrato_servidor_orgao                                                                  
         , (SELECT cod_contrato                                                                             
                 , max(timestamp) as timestamp                                                              
              FROM pessoal.contrato_servidor_orgao                                                          
            WHERE timestamp <= (ultimotimestampperiodomovimentacao(:codPeriodoMovimentacao,:entidade)::timestamp)     
            GROUP BY cod_contrato) as max_contrato_servidor_orgao                                           
         , pessoal.contrato_servidor_nomeacao_posse                                                         
         , (SELECT cod_contrato                                                                             
                 , max(timestamp) as timestamp                                                              
              FROM pessoal.contrato_servidor_nomeacao_posse                                                 
            WHERE timestamp <= (ultimotimestampperiodomovimentacao(:codPeriodoMovimentacao,:entidade)::timestamp)     
            GROUP BY cod_contrato) as max_contrato_servidor_nomeacao_posse                                  
         , pessoal.contrato_servidor                                                                        
         , pessoal.contrato";

        if (!empty($stFiltro['stJoin'])) {
            $sql .= $stFiltro['stJoin'];
        }
        $sql .= "
         , sw_cgm                                                                                           
         , sw_cgm_pessoa_fisica                                                                             
         , pessoal.cargo                                                                                    
         , pessoal.cbo_cargo                                                                                
         , (SELECT cod_cargo                                                                                
                 , max(timestamp) as timestamp                                                              
              FROM pessoal.cbo_cargo                                                                         
            WHERE timestamp <= (ultimotimestampperiodomovimentacao(:codPeriodoMovimentacao,:entidade)::timestamp)     
            GROUP BY cod_cargo) as max_cbo_cargo                                                             

         , pessoal.contrato_servidor_ocorrencia                                                             
         , (SELECT cod_contrato                                                                             
                 , max(timestamp) as timestamp                                                              
              FROM pessoal.contrato_servidor_ocorrencia                                                     
            WHERE timestamp <= (ultimotimestampperiodomovimentacao(:codPeriodoMovimentacao,:entidade)::timestamp)     
            GROUP BY cod_contrato) as max_contrato_servidor_ocorrencia                                      
         , pessoal.ocorrencia                                                                               
     WHERE servidor.cod_servidor = servidor_pis_pasep.cod_servidor                                          
       AND servidor_pis_pasep.cod_servidor = max_servidor_pis_pasep.cod_servidor                            
       AND servidor_pis_pasep.timestamp = max_servidor_pis_pasep.timestamp                                  
       AND servidor.cod_servidor = servidor_contrato_servidor.cod_servidor                                  
       AND servidor_contrato_servidor.cod_contrato = contrato_servidor_nomeacao_posse.cod_contrato          
       AND contrato_servidor_nomeacao_posse.cod_contrato = max_contrato_servidor_nomeacao_posse.cod_contrato
       AND contrato_servidor_nomeacao_posse.timestamp = max_contrato_servidor_nomeacao_posse.timestamp      
       AND servidor_contrato_servidor.cod_contrato = contrato_servidor.cod_contrato                         
       AND servidor_contrato_servidor.cod_contrato = contrato.cod_contrato                                  
       AND contrato_servidor.cod_cargo = cargo.cod_cargo                                                    
       AND servidor.numcgm = sw_cgm.numcgm                                                                  
       AND servidor.numcgm = sw_cgm_pessoa_fisica.numcgm                                                    
       AND contrato_servidor.cod_contrato = contrato_servidor_ocorrencia.cod_contrato                       
       AND contrato_servidor_ocorrencia.cod_contrato = max_contrato_servidor_ocorrencia.cod_contrato        
       AND contrato_servidor_ocorrencia.timestamp = max_contrato_servidor_ocorrencia.timestamp              
       AND contrato_servidor.cod_contrato = contrato_servidor_orgao.cod_contrato                            
       AND contrato_servidor_orgao.cod_contrato = max_contrato_servidor_orgao.cod_contrato                  
       AND contrato_servidor_orgao.timestamp = max_contrato_servidor_orgao.timestamp                        
       AND contrato_servidor_ocorrencia.cod_ocorrencia = ocorrencia.cod_ocorrencia                          
       AND cargo.cod_cargo = cbo_cargo.cod_cargo                          
       AND cbo_cargo.cod_cargo = max_cbo_cargo.cod_cargo                          
       AND cbo_cargo.timestamp = max_cbo_cargo.timestamp                          
AND EXISTS (SELECT contrato_servidor_previdencia.cod_contrato                                                
  FROM pessoal.contrato_servidor_previdencia                                                                 
     , (SELECT cod_contrato                                                                                  
             , cod_previdencia                                                                               
             , max(timestamp) as timestamp                                                                   
          FROM pessoal.contrato_servidor_previdencia                                                         
        WHERE timestamp <= (ultimotimestampperiodomovimentacao(:codPeriodoMovimentacao,:entidade)::timestamp)     
         GROUP BY cod_contrato                                                                               
                , cod_previdencia) as max_contrato_servidor_previdencia                                      
      , folhapagamento.previdencia                                                                           
  WHERE contrato_servidor_previdencia.cod_contrato = max_contrato_servidor_previdencia.cod_contrato          
    AND contrato_servidor_previdencia.cod_previdencia = max_contrato_servidor_previdencia.cod_previdencia    
    AND contrato_servidor_previdencia.timestamp = max_contrato_servidor_previdencia.timestamp                
    AND contrato_servidor_previdencia.bo_excluido IS FALSE                                                   
    AND contrato_servidor_previdencia.cod_previdencia = previdencia.cod_previdencia                          
    AND previdencia.cod_regime_previdencia = 1                                                               
    AND contrato_servidor.cod_contrato = contrato_servidor_previdencia.cod_contrato)
";
        if (!empty($stFiltro['stFiltro'])) {
            $sql .= $stFiltro['stFiltro'];
        }

        if ($stOrdem) {
            $sql .= $stOrdem;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindParam(':codPeriodoMovimentacao', $params['codPeriodoMovimentacao'], \PDO::PARAM_STR);
        $query->bindParam(':entidade', $params['entidade'], \PDO::PARAM_STR);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
