<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\Lancamento;

/**
 * Class ExtratoDebitosReportModel
 * @package Urbem\CoreBundle\Model\Arrecadacao
 */
class ExtratoDebitosReportModel extends AbstractModel
{
    protected $entityManager;
    protected $repository;

    /**
     * ExtratoDebitosReportModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Lancamento::class);
    }

    /**
     * @param $inscricaoEconomica
     * @return array
     */
    public function getSwCgmInscricaoEconomico($inscricaoEconomica)
    {
        $sql = "select distinct coalesce( ef.numcgm, ed.numcgm, au.numcgm )       as numcgm           
	        , ce.inscricao_economica                                                         
	        , ce.timestamp                                                                   
	        , TO_CHAR(ce.dt_abertura,'dd/mm/yyyy')                       as dt_abertura      
	        , cgm.nom_cgm                                                                    
	        , case                                                                           
	               when cast( ef.numcgm as varchar) is not null                              
	               then '1'                                                                  
	               when cast( au.numcgm as varchar) is not null                              
	               then '3'                                                                  
	               when cast( ed.numcgm as varchar) is not null                              
	               then '2'                                                                  
	          end                                                        as enquadramento    
	        , economico.fn_busca_sociedade(ce.inscricao_economica)       as sociedade        
	     FROM economico.cadastro_economico                               as ce               
        LEFT JOIN economico.cadastro_economico_empresa_fato                  as ef               
               ON ce.inscricao_economica = ef.inscricao_economica                                
        LEFT JOIN economico.cadastro_economico_autonomo                      as au               
               ON ce.inscricao_economica = au.inscricao_economica                                
        LEFT JOIN economico.cadastro_economico_empresa_direito               as ed               
               ON ce.inscricao_economica = ed.inscricao_economica                                
             LEFT JOIN (
                                SELECT
                                    baixa_cadastro_economico.*
                                FROM
                                    economico.baixa_cadastro_economico
        
                                INNER JOIN
                                    (
                                        SELECT
                                            max( timestamp ) as timestamp,
                                            inscricao_economica
        
                                        FROM
                                            economico.baixa_cadastro_economico
        
                                        GROUP BY
                                            inscricao_economica
                                    )AS tmp
                                ON
                                    tmp.inscricao_economica = baixa_cadastro_economico.inscricao_economica
                                    AND tmp.timestamp = baixa_cadastro_economico.timestamp
                            ) as ba 
            ON ce.inscricao_economica = ba.inscricao_economica,                  
            sw_cgm                                                     as cgm              
            where coalesce( ef.numcgm, ed.numcgm, au.numcgm ) = cgm.numcgm                       
         AND (LOWER(cgm.nom_cgm) ILIKE :nom_cgm OR cgm.numcgm = :num_cgm OR ce.inscricao_economica = :inscricao_economica)
         order by ce.inscricao_economica";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue(':nom_cgm', sprintf('%%%s%%', strtolower($inscricaoEconomica)), \PDO::PARAM_STR);
        $query->bindValue(':num_cgm', sprintf('%d', (int) $inscricaoEconomica), \PDO::PARAM_INT);
        $query->bindValue(':inscricao_economica', sprintf('%d', (int) $inscricaoEconomica), \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $filters
     * @return array
     */
    public function getListaParcelaEmAberto($filters)
    {
        $andWhere = '';
        $andInner = '';

        if ($filters['inscricaoMunicipal']) {
            $andInner .= ' INNER JOIN arrecadacao.imovel_calculo as aic ON aic.cod_calculo = ac.cod_calculo';
            $andWhere .= ' AND aic.inscricao_municipal = :inscricao_municipal';
        } elseif ($filters['inscricaoEconomica']) {
            $andInner .= ' INNER JOIN arrecadacao.cadastro_economico_calculo as cec ON cec.cod_calculo = ac.cod_calculo';
            $andWhere .= ' AND cec.inscricao_economica = :inscricao_economica';
        } elseif ($filters['numcgm']) {
            $andWhere .= ' AND accgm.numcgm = :num_cgm';
        }

        if ($filters['exercicio']) {
            $andWhere .= ' AND ac.exercicio = :exercicio';
        }

        $sql = "SELECT                                                                                  
	      origem                                                                              
	      , cod_lancamento                                                                     
	      , exercicio                                                                         
	      , count(cod_parcela) as qtde                                                        
	      , ( sum(valor) + sum(juros) + sum(multa) + sum(correcao) ) as valor                 
	  FROM                                                                                    
	      (                                                                                   
	          SELECT                                                                          
	              *                                                                           
	              , coalesce ( aplica_juro ( numeracao, exercicio, cod_parcela, now()::date)  
	                          , 0.0                                                           
	              ) as juros                                                                  
	              , coalesce ( aplica_multa ( numeracao, exercicio, cod_parcela, now()::date) 
	                          , 0.0                                                           
	              ) as multa                                                                  
	              , coalesce ( aplica_correcao( numeracao, exercicio, cod_parcela,now()::date)
	                          , 0.0                                                           
	              ) as correcao                                                               
	          FROM                                                                            
	              (                                                                           
	              SELECT                                                                      
	                  busca_parcelas.cod_lancamento                                           
	                  , max(carne.numeracao) as numeracao                                     
	                  , busca_parcelas.cod_parcela                                            
	                  , busca_parcelas.nr_parcela                                             
	                  , busca_parcelas.exercicio                                              
	                  , busca_parcelas.situacao_lancamento                                    
	                  , busca_parcelas.origem                                                 
	                  , busca_parcelas.valor                                                  
	                  , busca_parcelas.vencimento                                             
	                  , CASE WHEN (parcela_reemitida IS NOT NULL) THEN
	                                                CASE WHEN (
	                                                            SELECT COUNT(carne.numeracao) as qtd
	                                                              FROM arrecadacao.pagamento as pag
	                                                              JOIN arrecadacao.carne as carne
	                                                                ON carne.numeracao = pag.numeracao
	                                                               AND carne.cod_convenio = pag.cod_convenio
	                                                             WHERE carne.cod_parcela = parcela_reemitida
	                                                        ) > 0 THEN
	                                                                    'false'
	                                                              ELSE
	                                                                    'true'
	                                                    END
	                                            ELSE
	                                                'true'
	                                    END as situacao_reemissao
	              FROM                                                                        
	                  (                                                                       
	                      SELECT                                                              
	                          ( CASE WHEN dpc.num_parcelamento IS NULL THEN                   
	                              al.cod_lancamento::varchar                                  
	                            ELSE                                                          
	                              dp.numero_parcelamento||'/'||dp.exercicio                   
	                            END                                                           
	                          )::varchar as cod_lancamento                                    
	                          , ( arrecadacao.fn_busca_lancamento_situacao (al.cod_lancamento)
	                          ) as situacao_lancamento                                        
	                          , ( CASE WHEN dpc.cod_calculo IS NOT NULL THEN                  
	                                  divida.fn_lista_origem_cobranca (                       
	                                      dpc.num_parcelamento, dp.exercicio::int )           
	                            ELSE                                                          
	                              arrecadacao.fn_busca_origem_lancamento(                     
	                                  al.cod_lancamento,ac.exercicio::int, 1, 1 )             
	                            END                                                           
	                          ) as origem                                                     
	                          , ac.exercicio::integer                                         
	                          , ap.cod_parcela                                                
	                          , ap.nr_parcela                                                 
	                          , ap.vencimento                                                 
	                          , apr.cod_parcela as parcela_reemitida                          
	                          , ap.valor                                                      
	                      FROM                                                                
	                          arrecadacao.lancamento as al                                    
	                          INNER JOIN (                                                    
	                              SELECT                                                      
	                                  cod_lancamento                                          
	                                  , max(cod_calculo) as cod_calculo                       
	                              FROM                                                        
	                                  arrecadacao.lancamento_calculo                          
	                              GROUP BY                                                    
	                                  cod_lancamento                                          
	                          ) as alc                                                        
	                          ON alc.cod_lancamento = al.cod_lancamento                       
	                          INNER JOIN arrecadacao.calculo as ac                            
	                          ON ac.cod_calculo = alc.cod_calculo                             
	                          INNER JOIN monetario.credito as mc                              
	                          ON mc.cod_credito = ac.cod_credito                              
	                          AND mc.cod_especie = ac.cod_especie                             
	                          AND mc.cod_genero = ac.cod_genero                               
	                          AND mc.cod_natureza = ac.cod_natureza                           
	                          INNER JOIN arrecadacao.calculo_cgm as accgm                     
	                          ON accgm.cod_calculo = ac.cod_calculo                           
	                          $andInner                                                  
	                          LEFT JOIN divida.parcela_calculo as dpc                         
	                          ON dpc.cod_calculo = ac.cod_calculo                             
	                          LEFT JOIN divida.parcela as dpar                                
	                          ON dpar.num_parcelamento = dpc.num_parcelamento                 
	                          AND dpar.num_parcela = dpc.num_parcela                          
	                          LEFT JOIN divida.parcelamento as dp                             
	                          ON dp.num_parcelamento = dpc.num_parcelamento                   
	                          INNER JOIN arrecadacao.parcela as ap                            
	                          ON ap.cod_lancamento = al.cod_lancamento                        
	                          LEFT JOIN (
	                                                    SELECT
	                                                        parcela_origem.cod_parcela
	
	                                                    FROM
	                                                        divida.parcela_origem
	
	                                                    INNER JOIN
	                                                        divida.divida_parcelamento
	                                                    ON
	                                                        divida_parcelamento.num_parcelamento = parcela_origem.num_parcelamento
	
	                                                    INNER JOIN
	                                                        divida.divida_cancelada
	                                                    ON
	                                                        divida.divida_cancelada.cod_inscricao = divida_parcelamento.cod_inscricao
	                                                        AND divida.divida_cancelada.exercicio = divida_parcelamento.exercicio
	                                            )AS dpcanc
	                                            ON dpcanc.cod_parcela = ap.cod_parcela                          
	                          LEFT JOIN arrecadacao.parcela_reemissao AS apr                  
	                          ON apr.cod_parcela = ap.cod_parcela                             
	                          LEFT JOIN (                                                     
	                               SELECT                                                     
	                                  cod_parcela,                                            
	                                  TRUE as possui_cobranca                                 
	                               FROM                                                       
	                                    divida.parcela_origem AS dpo                          
	                               INNER JOIN divida.parcela AS dp                            
	                                  ON dp.num_parcelamento =  dpo.num_parcelamento          
	                               WHERE dp.paga = 'f' AND cancelada = 'f'                    
	                                     AND num_parcela <> 0                                 
	                              GROUP BY 1                                                  
	                            ) as dpo                                                      
	                         ON dpo.cod_parcela = ap.cod_parcela                              
	                      WHERE                                                               
	                           dpo.possui_cobranca is null
	                                            AND (
	                                                CASE WHEN
	                                                    (   SELECT
	                                                            count(*)
	                                                        FROM
	                                                            divida.parcela
	                                                        inner join
	                                                            divida.parcela_origem
	                                                        on
	                                                            parcela_origem.num_parcelamento = parcela.num_parcelamento
	                                                            AND parcela_origem.cod_parcela = ap.cod_parcela
	
	                                                        WHERE num_parcela = 0
	                                                        AND paga = true
	                                                        AND cancelada = false
	                                                    ) > 0
	                                                    THEN
	                                                        FALSE
	                                                    ELSE
	                                                        TRUE
	                                                    END
	                                            )
	                          $andWhere                                                                                                                              
	                          AND dpcanc.cod_parcela IS NULL                                  
	                          AND (
	                                                CASE WHEN
	                                                    (
	                                                        SELECT count(*)
	                                                        FROM arrecadacao.parcela
	                                                        WHERE nr_parcela != 0
	                                                        AND cod_lancamento = al.cod_lancamento
	                                                        AND now()::date > vencimento
	                                                    ) > 0
	                                                THEN
	                                                    CASE WHEN
	                                                        (
	                                                            SELECT
	                                                                count(*)
	                                                            FROM arrecadacao.parcela
	
	                                                            INNER JOIN arrecadacao.carne
	                                                            ON carne.cod_parcela = parcela.cod_parcela
	
	                                                            INNER JOIN arrecadacao.pagamento
	                                                            ON pagamento.numeracao = carne.numeracao
	                                                            WHERE nr_parcela = 0
	                                                            AND parcela.cod_lancamento = al.cod_lancamento
	                                                        ) > 0
	                                                    THEN
	                                                        FALSE
	                                                    ELSE
	                                                        TRUE
	                                                    END
	                                                ELSE
	                                                    TRUE
	                                                END                                                         
	                          )                                                               
	                          AND (                                                           
	                              CASE WHEN dpc.cod_calculo IS NOT NULL THEN                  
	                                 CASE WHEN dpar.cancelada = false OR dpar.paga = true THEN
	                                      TRUE                                                
	                                  ELSE                                                    
	                                      FALSE                                               
	                                  END                                                     
	                              ELSE                                                        
	                                  TRUE                                                    
	                              END                                                         
	                          )                                                               
	                      GROUP BY                                                            
	                          al.cod_lancamento , ac.exercicio                                
	                          , ap.cod_parcela, ap.nr_parcela, ap.valor, ap.vencimento        
	                          , apr.cod_parcela, ap.valor                                     
	                          , dpc.cod_calculo, dpc.num_parcelamento                         
	                          , dp.numero_parcelamento                                        
	                          , dp.exercicio                                                  
	                  ) as busca_parcelas                                                     
	                  INNER JOIN arrecadacao.carne                                            
	                  ON carne.cod_parcela = busca_parcelas.cod_parcela                       
	                  LEFT JOIN arrecadacao.pagamento as apag                                 
	                  ON apag.numeracao = carne.numeracao                                     
	                  AND apag.cod_convenio = carne.cod_convenio                              
	                  LEFT JOIN arrecadacao.tipo_pagamento as atp                             
	                  ON atp.cod_tipo = apag.cod_tipo                                         
	                  LEFT JOIN arrecadacao.carne_devolucao as acd                            
	                  ON acd.numeracao = carne.numeracao                                      
	                  AND acd.cod_convenio = carne.cod_convenio                               
	              WHERE                                                                       
	                  apag.numeracao IS NULL                                                  
	                  AND (                                                                   
	                      CASE WHEN acd.numeracao IS NOT NULL THEN                            
	                          CASE WHEN acd.cod_motivo = 11  THEN                             
	                              TRUE                                                        
	                          ELSE                                                            
	                              FALSE                                                       
	                          END                                                             
	                      ELSE                                                                
	                          TRUE                                                            
	                      END                                                                 
	                  )                                                                       
	              GROUP BY                                                                    
	                  busca_parcelas.cod_lancamento, situacao_lancamento                      
	                  , busca_parcelas.origem, busca_parcelas.cod_parcela                     
	                  , busca_parcelas.nr_parcela, busca_parcelas.valor                       
	                  , busca_parcelas.exercicio, busca_parcelas.parcela_reemitida            
	                  , busca_parcelas.vencimento                                             
	          ) as busca_carnes                                                               
	  ) as busca_valores                                                                      
	  GROUP BY                                                                                
	      exercicio, cod_lancamento,origem                                                    
	  ORDER BY                                                                                
	      exercicio, cod_lancamento                                                           
	  ;";

        $query = $this->entityManager->getConnection()->prepare($sql);

        if ($filters['inscricaoMunicipal']) {
            $query->bindValue(':inscricao_municipal', $filters['inscricaoMunicipal'], \PDO::PARAM_INT);
        } elseif ($filters['inscricaoEconomica']) {
            $query->bindValue(':inscricao_economica', $filters['inscricaoEconomica'], \PDO::PARAM_INT);
        } elseif ($filters['numcgm']) {
            $query->bindValue(':num_cgm', $filters['numcgm'], \PDO::PARAM_INT);
        }

        if ($filters['exercicio']) {
            $query->bindValue(':exercicio', $filters['exercicio'], \PDO::PARAM_STR);
        }

        $query->execute();

        return $query->fetchAll();
    }

    public function getListaParcelaEmAbertoAnalitico($filters, $lancamento)
    {
        if (!$lancamento) {
            return false;
        }
        $andInner = '';
        $andWhere = '';

        if ($filters['inscricaoMunicipal']) {
            $andInner .= ' INNER JOIN arrecadacao.imovel_calculo as aic ON aic.cod_calculo = ac.cod_calculo';
            $andWhere .= ' aic.inscricao_municipal = :inscricao_municipal';
        } elseif ($filters['inscricaoEconomica']) {
            $andInner .= ' INNER JOIN arrecadacao.cadastro_economico_calculo as cec ON cec.cod_calculo = ac.cod_calculo';
            $andWhere .= ' cec.inscricao_economica = :inscricao_economica';
        } elseif ($filters['numcgm']) {
            $andWhere .= ' accgm.numcgm = :num_cgm';
        }

        if ($filters['exercicio']) {
            $andWhere .= ' AND ac.exercicio = :exercicio';
        }
        $sql = "
	  SELECT                                                                                  
	      *                                                                                   
	      , ( valor + juros + multa + correcao ) as total                                     
	  FROM                                                                                    
	      (                                                                                   
	          SELECT                                                                          
	              *                                                                           
	              , coalesce ( aplica_juro ( numeracao, exercicio, cod_parcela, now()::date)  
	                          , 0.0                                                           
	              ) as juros                                                                  
	              , coalesce ( aplica_multa ( numeracao, exercicio, cod_parcela, now()::date) 
	                          , 0.0                                                           
	              ) as multa                                                                  
	              , coalesce (aplica_correcao( numeracao, exercicio, cod_parcela, now()::date)
	                          , 0.0                                                           
	              ) as correcao                                                               
	              , arrecadacao.fn_total_parcelas ( cod_lancamento ) as total_parcelas        
	          FROM                                                                            
	              (                                                                           
	              SELECT                                                                      
	                  busca_parcelas.cod_lancamento                                           
	                  , max(carne.numeracao) as numeracao                                     
	                  , busca_parcelas.cod_parcela                                            
	                  , busca_parcelas.nr_parcela                                             
	                  , busca_parcelas.exercicio                                              
	                  , busca_parcelas.situacao_lancamento                                    
	                  , busca_parcelas.origem                                                 
	                  , busca_parcelas.valor                                                  
	                  , busca_parcelas.vencimento                                             
	                  , to_char ( busca_parcelas.vencimento, 'dd/mm/yyyy' ) as vencimento_br  
	                  , ( CASE WHEN ( parcela_reemitida IS NOT NULL ) THEN                    
	                          CASE WHEN (                                                     
	                              SELECT count(carne.numeracao) as qtde_reemitidas_pagas      
	                              FROM                                                        
	                                  arrecadacao.pagamento as apag2                          
	                                  INNER JOIN arrecadacao.carne as carne2                  
	                                  ON carne2.numeracao = apag2.numeracao                   
	                                  AND carne2.cod_convenio = apag2.cod_convenio            
	                              WHERE                                                       
	                                  carne2.cod_parcela = parcela_reemitida                  
	                          ) > 0                                                           
	                          THEN                                                            
	                              'false'                                                     
	                          ELSE                                                            
	                              'true'                                                      
	                          END                                                             
	                      ELSE                                                                
	                          'true'                                                          
	                      END                                                                 
	                  ) as situacao_reemissao                                                 
	                  , ( CASE WHEN ( vencimento < now()::date ) THEN                         
	                          'vencida'                                                       
	                      ELSE                                                                
	                          'em aberto'                                                     
	                      END                                                                 
	                  ) as situacao_parcela                                                   
	              FROM                                                                        
	                  (                                                                       
	                      SELECT                                                              
	                          ( CASE WHEN dpc.cod_calculo IS NULL THEN                        
	                              al.cod_lancamento::varchar                                  
	                            ELSE                                                          
	                              dp.numero_parcelamento||'/'||dp.exercicio                   
	                            END                                                           
	                          )::varchar as lancamento_nominal                                
	                          , al.cod_lancamento                                             
	                          , ( arrecadacao.fn_busca_lancamento_situacao (al.cod_lancamento)
	                          ) as situacao_lancamento                                        
	                        , ( CASE WHEN dpc.cod_calculo IS NOT NULL THEN                    
	                                'Cobrança em D.A.'                                        
	                            ELSE                                                          
	                              arrecadacao.fn_busca_origem_lancamento(                     
	                                  al.cod_lancamento,ac.exercicio::int, 1, 1 )             
	                            END                                                           
	                          ) as origem                                                     
	                          , ac.exercicio::integer                                         
	                          , ap.cod_parcela                                                
	                          , ap.nr_parcela                                                 
	                          , ap.vencimento                                                 
	                          , apr.cod_parcela as parcela_reemitida                          
	                          , ap.valor                                                      
	                      FROM                                                                
	                          arrecadacao.lancamento as al                                    
	                          INNER JOIN (                                                    
	                              SELECT                                                      
	                                  cod_lancamento                                          
	                                  , max(cod_calculo) as cod_calculo                       
	                              FROM                                                        
	                                  arrecadacao.lancamento_calculo                          
	                              GROUP BY                                                    
	                                  cod_lancamento                                          
	                          ) as alc                                                        
	                          ON alc.cod_lancamento = al.cod_lancamento                       
	                          INNER JOIN arrecadacao.calculo as ac                            
	                          ON ac.cod_calculo = alc.cod_calculo                             
	                          INNER JOIN arrecadacao.calculo_cgm as accgm                     
	                          ON accgm.cod_calculo = ac.cod_calculo                           
	                          $andInner        
	                          LEFT JOIN divida.parcela_calculo as dpc                         
	                          ON dpc.cod_calculo = ac.cod_calculo                             
	                          LEFT JOIN divida.parcela as dpar                                
	                          ON dpar.num_parcelamento = dpc.num_parcelamento                 
	                          AND dpar.num_parcela = dpc.num_parcela                          
	                          LEFT JOIN divida.parcelamento as dp                             
	                          ON dp.num_parcelamento = dpc.num_parcelamento                   
	                          INNER JOIN arrecadacao.parcela as ap                            
	                          ON ap.cod_lancamento = al.cod_lancamento                        
	                          LEFT JOIN arrecadacao.parcela_reemissao AS apr                  
	                          ON apr.cod_parcela = ap.cod_parcela                             
	                      WHERE                                                               
	                        $andWhere                                                  
	                          AND (                                                           
	                              CASE WHEN ap.nr_parcela = 0 THEN                            
	                                  CASE WHEN now()::date > ap.vencimento THEN              
	                                      FALSE                                               
	                                  ELSE                                                    
	                                      TRUE                                                
	                                  END                                                     
	                              ELSE                                                        
	                                  CASE WHEN                                               
	                                      (   SELECT count(*)                                 
	                                          FROM arrecadacao.parcela                        
	                                          WHERE nr_parcela = 0                            
	                                          AND cod_lancamento = al.cod_lancamento          
	                                          AND now()::date <= vencimento                   
	                                      ) > 0                                               
	                                  THEN                                                    
	                                      FALSE                                               
	                                  ELSE                                                    
	                                      TRUE                                                
	                                  END                                                     
	                              END                                                         
	                          )                                                               
	                      GROUP BY                                                            
	                          al.cod_lancamento , ac.exercicio                                
	                          , ap.cod_parcela, ap.nr_parcela, ap.valor, ap.vencimento        
	                          , apr.cod_parcela, ap.valor, dpc.cod_calculo                    
	                          , dp.numero_parcelamento, dp.exercicio                          
	                  ) as busca_parcelas                                                     
	                  INNER JOIN arrecadacao.carne                                            
	                  ON carne.cod_parcela = busca_parcelas.cod_parcela                       
	                  AND carne.exercicio = busca_parcelas.exercicio::varchar                 
	                  LEFT JOIN arrecadacao.pagamento as apag                                 
	                  ON apag.numeracao = carne.numeracao                                     
	                  AND apag.cod_convenio = carne.cod_convenio                              
	                  LEFT JOIN arrecadacao.tipo_pagamento as atp                             
	                  ON atp.cod_tipo = apag.cod_tipo                                         
	                  LEFT JOIN arrecadacao.carne_devolucao as acd                            
	                  ON acd.numeracao = carne.numeracao                                      
	                  AND acd.cod_convenio = carne.cod_convenio                               
	              WHERE                                                                       
	                  apag.numeracao IS NULL                                                  
	                  AND (                                                                   
	                      CASE WHEN acd.cod_motivo != 11 THEN                            
	                          FALSE                                                           
	                      ELSE                                                                
	                          TRUE                                                            
	                      END                                                                 
	                  )                                                                       
	                   AND lancamento_nominal = :lancamento_nominal 
	                                                        
	              GROUP BY                                                                    
	                  busca_parcelas.cod_lancamento, situacao_lancamento                      
	                  , busca_parcelas.origem, busca_parcelas.cod_parcela                     
	                  , busca_parcelas.nr_parcela, busca_parcelas.valor                       
	                  , busca_parcelas.exercicio, busca_parcelas.parcela_reemitida            
	                  , busca_parcelas.vencimento, acd.cod_motivo                             
	          ) as busca_carnes                                                               
	      WHERE                                                                               
	          ( situacao_reemissao != 'false' )                                               
	          AND (   ( situacao_lancamento = 'Ativo' )                                       
	                  OR                                                                      
	                  ( situacao_lancamento = 'Cancelada por DA')
	                                    OR
	                                    ( situacao_lancamento = 'Inscrito em D.A.') )                           
	      ORDER BY                                                                            
	          exercicio, cod_lancamento, nr_parcela                                           
	  ) as busca_valores;";

        $query = $this->entityManager->getConnection()->prepare($sql);

        if ($filters['inscricaoMunicipal']) {
            $query->bindValue(':inscricao_municipal', $filters['inscricaoMunicipal'], \PDO::PARAM_INT);
        } elseif ($filters['inscricaoEconomica']) {
            $query->bindValue(':inscricao_economica', $filters['inscricaoEconomica'], \PDO::PARAM_INT);
        } elseif ($filters['numcgm']) {
            $query->bindValue(':num_cgm', $filters['numcgm'], \PDO::PARAM_INT);
        }

        if ($filters['exercicio']) {
            $query->bindValue(':exercicio', $filters['exercicio'], \PDO::PARAM_STR);
        }

        $query->bindValue(':lancamento_nominal', $lancamento, \PDO::PARAM_INT);

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $incricaoEconomica
     * @return mixed
     */
    public function getInscricaoEndereco($incricaoEconomica)
    {
        if (!$incricaoEconomica) {
            return false;
        }
        $sql = "SELECT * FROM arrecadacao.fn_consulta_endereco_empresa (:inscricao_economica) as endereco";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue(':inscricao_economica', $incricaoEconomica, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetch();
    }

    /**
     * @param $inscricaoMunicipal
     * @return bool|mixed
     */
    public function getConsultaLogradouro($inscricaoMunicipal)
    {
        if (!$inscricaoMunicipal) {
            return false;
        }
        $sql = "SELECT l[2] as endereco FROM imobiliario.fn_consulta_logradouro(:inscricao_municipal) as l";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue(':inscricao_municipal', $inscricaoMunicipal, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetch();
    }

    /**
     * @param $codLancamento
     * @return array
     */
    public function getCodigoAndVencimentoParcela($codLancamento)
    {
        $sql = "select
                    distinct parcela.cod_parcela,
                    parcela.vencimento
                from
                    arrecadacao.lancamento inner join arrecadacao.parcela on
                    lancamento.cod_lancamento = parcela.cod_lancamento inner join arrecadacao.carne on
                    carne.cod_parcela = parcela.cod_parcela left join arrecadacao.pagamento on
                    pagamento.numeracao = carne.numeracao
                where
                    parcela.nr_parcela > 0
                    and pagamento is null
                    and lancamento.cod_lancamento = ".$codLancamento;

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $codLancamento
     * @param $exercicio
     * @return array
     */
    public function getListaParcelaDivida($codLancamento, $exercicio)
    {
        $sql = "select
                    distinct arrecadacao.parcela.cod_parcela,
                    arrecadacao.parcela.vencimento
                from
                    divida.parcelamento inner join divida.parcela on
                    divida.parcela.num_parcelamento = parcelamento.num_parcelamento inner join divida.parcela_calculo on
                    parcela_calculo.num_parcelamento = divida.parcela.num_parcelamento
                    and parcela_calculo.num_parcela = divida.parcela.num_parcela inner join arrecadacao.lancamento_calculo on
                    lancamento_calculo.cod_calculo = parcela_calculo.cod_calculo inner join arrecadacao.parcela on
                    arrecadacao.parcela.cod_lancamento = lancamento_calculo.cod_lancamento inner join arrecadacao.carne on
                    carne.cod_parcela = arrecadacao.parcela.cod_parcela left join arrecadacao.pagamento on
                    pagamento.numeracao = carne.numeracao
                where
                    arrecadacao.parcela.nr_parcela > 0
                    and pagamento is null 
                    parcelamento.numero_parcelamento = ".$codLancamento.
                    "AND parcelamento.exercicio = ".$exercicio;

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
}
