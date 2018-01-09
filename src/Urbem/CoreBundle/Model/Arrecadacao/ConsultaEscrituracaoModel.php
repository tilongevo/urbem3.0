<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;

/**
 * Class ConsultaEscrituracaoModel
 * @package Urbem\CoreBundle\Model\Arrecadacao
 */
class ConsultaEscrituracaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository;

    /**
     * ConsultaEscrituracaoModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(CadastroEconomico::class);
    }

    /**
     * @param $filter
     * @return array
     */
    public function filterEscrituracao($filter)
    {
        $sql = "select                                                                                                                                            
             cadastro_economico.inscricao_economica,                                                                                                       
             to_char(cadastro_economico.dt_abertura,'dd/mm/yyyy') as dt_abertura,                                                                          
             coalesce(cadastro_economico_empresa_direito.numcgm, cadastro_economico_empresa_fato.numcgm, cadastro_economico_autonomo.numcgm ) as numcgm,   
             (select                                                                                                                                       
                 nom_cgm                                                                                                                                   
              from                                                                                                                                         
                 sw_cgm                                                                                                                                    
              where                                                                                                                                        
                 numcgm = coalesce(cadastro_economico_empresa_direito.numcgm, cadastro_economico_empresa_fato.numcgm, cadastro_economico_autonomo.numcgm ) 
             ) as nom_cgm,                                                                                                                                 
             cadastro_economico_faturamento.competencia,                                                                                                   
             cadastro_economico_faturamento.timestamp                                                                                                      
         from                                                                                                                                              
             economico.cadastro_economico                                                                                                                  
         left join                                                                                                                                         
             economico.cadastro_economico_empresa_direito                                                                                                  
         on                                                                                                                                                
             cadastro_economico.inscricao_economica = cadastro_economico_empresa_direito.inscricao_economica                                               
         left join                                                                                                                                         
             economico.cadastro_economico_empresa_fato                                                                                                     
         on                                                                                                                                                
             cadastro_economico.inscricao_economica = cadastro_economico_empresa_fato.inscricao_economica                                                  
         left join                                                                                                                                         
             economico.cadastro_economico_autonomo                                                                                                         
         on                                                                                                                                                
             cadastro_economico.inscricao_economica = cadastro_economico_autonomo.inscricao_economica                                                      
         inner join                                                                                                                                        
             arrecadacao.cadastro_economico_faturamento                                                                                                    
         on                                                                                                                                                
             cadastro_economico.inscricao_economica = cadastro_economico_faturamento.inscricao_economica and                                               
             trim(cadastro_economico_faturamento.competencia) != ''                                                                                        
         where                                                                                                                                             
         exists ( select *                                                                                                                                 
                  from                                                                                                                                     
                      arrecadacao.faturamento_servico                                                                                                      
                  where                                                                                                                                    
                      cadastro_economico_faturamento.inscricao_economica = faturamento_servico.inscricao_economica                                         
                      and cadastro_economico_faturamento.timestamp           = faturamento_servico.timestamp )                                             
        ";

        if (isset($filter['inscricaoEconomica']['value']) && $filter['inscricaoEconomica']['value'] !== "") {
            $sql .= " AND cadastro_economico.inscricao_economica =:inscricaoEconomica";
        }

        if (isset($filter['fkSwCgm']['value']) && $filter['fkSwCgm']['value'] !== "") {
            $sql .= " AND coalesce(cadastro_economico_empresa_direito.numcgm, cadastro_economico_empresa_fato.numcgm, cadastro_economico_autonomo.numcgm ) =:numcgm";
        }

        $sql.= " order by cadastro_economico.inscricao_economica,  
	                    cadastro_economico_faturamento.timestamp";

        $query = $this->entityManager->getConnection()->prepare($sql);

        if (isset($filter['inscricaoEconomica']['value']) && $filter['inscricaoEconomica']['value'] !== "") {
            $query->bindValue(':inscricaoEconomica', $filter['inscricaoEconomica']['value'], \PDO::PARAM_INT);
        }
        if (isset($filter['fkSwCgm']['value']) && $filter['fkSwCgm']['value'] !== "") {
            $query->bindValue(':numcgm', $filter['fkSwCgm']['value'], \PDO::PARAM_INT);
        }

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $codCalculo
     * @param $dataBase
     */
    public function getDetalhamentoValores($codCalculo, $dataBase)
    {
        $sql = "SELECT                                                                                      
                  consulta.*                                                                              
                  , ( CASE WHEN consulta.pagamento_data is not null THEN                                  
                          CASE WHEN                                                                       
                              ( consulta.pagamento_valor !=                                               
                              ( (consulta.parcela_valor - parcela_valor_desconto ) +                      
                              consulta.parcela_juros_pagar + consulta.parcela_multa_pagar                 
                              + parcela_correcao_pagar                                                    
                              + consulta.tmp_pagamento_diferenca )                                        
                              )                                                                           
                          THEN                                                                            
                              coalesce (                                                                  
                                  consulta.pagamento_valor -                                              
                                  (( consulta.parcela_valor - consulta.parcela_valor_desconto ) +         
                                  ( consulta.parcela_juros_pagar )                                        
                                  + ( consulta.parcela_multa_pagar )                                      
                                  + ( consulta.parcela_correcao_pagar )                                   
                                  ), 0.00 )                                                               
                              + coalesce( (                                                               
                              ( consulta.parcela_juros_pago - consulta.parcela_juros_pagar )              
                              + ( consulta.parcela_multa_pago - consulta.parcela_multa_pagar )            
                              + ( consulta.parcela_correcao_pago - consulta.parcela_correcao_pagar )      
                              ), 0.00 )                                                                   
                          ELSE                                                                            
                              consulta.tmp_pagamento_diferenca                                            
                          END                                                                             
                      ELSE                                                                                
                          0.00                                                                            
                      END                                                                                 
                  ) as pagamento_diferenca                                                                
                  , ( CASE WHEN  consulta.situacao = 'Em Aberto' THEN                                     
                          consulta.parcela_juros_pagar                                                    
                      ELSE                                                                                
                          CASE WHEN consulta.pagamento_data is not null THEN                              
                              consulta.parcela_juros_pago                                                 
                          ELSE                                                                            
                              0.00                                                                        
                          END                                                                             
                      END                                                                                 
                  ) as parcela_juros                                                                      
                  , ( CASE WHEN  consulta.situacao = 'Em Aberto' THEN                                     
                          consulta.parcela_multa_pagar                                                    
                      ELSE                                                                                
                          CASE WHEN consulta.pagamento_data is not null THEN                              
                              consulta.parcela_multa_pago                                                 
                          ELSE                                                                            
                              0.00                                                                        
                          END                                                                             
                      END                                                                                 
                  ) as parcela_multa                                                                      
                  , ( CASE WHEN consulta.situacao = 'Em Aberto' THEN                                      
                          ( consulta.parcela_valor - parcela_valor_desconto                               
                          + consulta.parcela_juros_pagar + consulta.parcela_multa_pagar                   
                          + consulta.parcela_correcao_pagar )                                             
                      ELSE                                                                                
                          CASE WHEN consulta.pagamento_data is not null THEN                              
                              consulta.pagamento_valor                                                    
                          ELSE                                                                            
                              0.00                                                                        
                          END                                                                             
                      END                                                                                 
                  ) as valor_total                                                                        
              FROM                                                                                        
                  (                                                                                       
                      select DISTINCT                                                                     
                          al.cod_lancamento                                                               
                          , carne.numeracao                                                               
                          , carne.cod_convenio                                                            
                      ---- PARCELA                                                                        
                          , ap.cod_parcela                                                                
                          , ap.nr_parcela                                                                 
                          , ( CASE WHEN apr.cod_parcela is not null THEN                                  
                                  to_char (arrecadacao.fn_atualiza_data_vencimento(apr.vencimento),       
                                  'dd/mm/YYYY')                                                           
                              ELSE                                                                        
                                  to_char (arrecadacao.fn_atualiza_data_vencimento(ap.vencimento),        
                                  'dd/mm/YYYY')                                                           
                              END                                                                         
                          )::varchar as parcela_vencimento_original                                       
                          , ( CASE WHEN apr.cod_parcela is null THEN                                      
                                  arrecadacao.fn_atualiza_data_vencimento(ap.vencimento)                  
                              ELSE                                                                        
                                  arrecadacao.fn_atualiza_data_vencimento(apr.vencimento)                 
                              END                                                                         
                          )::varchar as parcela_vencimento_US                                             
                          , to_char (arrecadacao.fn_atualiza_data_vencimento(ap.vencimento), 'dd/mm/YYYY')
                          as vencimento_original --VENCIMENTO PARA EXIBIÇÃO                               
                          , ap.valor as parcela_valor                                                     
                          , ( CASE WHEN apd.cod_parcela is not null        
                                   AND (ap.vencimento >= '$dataBase' ) THEN                       
                                  (ap.valor - apd.valor)                                                  
                              ELSE                                                                        
                                  0.00                                                                    
                              END                                                                         
                          )::numeric(14,2) as parcela_valor_desconto                                      
                          , ( select arrecadacao.buscaValorOriginalParcela( carne.numeracao ) as valor    
                          ) as parcela_valor_original                                                     
                          , ( CASE WHEN apd.cod_parcela is not null AND apag.numeracao is NULL            
                                   AND (ap.vencimento >= '$dataBase' ) THEN                       
                                  arrecadacao.fn_percentual_desconto_parcela( ap.cod_parcela,             
                                  ap.vencimento, (carne.exercicio)::int )                                 
                              ELSE                                                                        
                                  0.00                                                                    
                              END                                                                         
                          ) as parcela_desconto_percentual                                                
                          , ( CASE WHEN ap.nr_parcela = 0 THEN                                            
                                  'Única'::VARCHAR                                                        
                              ELSE                                                                        
                                  ap.nr_parcela::varchar||'/'||                                           
                                  arrecadacao.fn_total_parcelas(al.cod_lancamento)                        
                              END                                                                         
                          ) as info_parcela                                                               
                          , ( CASE WHEN apag.numeracao is not null THEN                                   
                                  apag.pagamento_tipo                                                     
                              ELSE                                                                        
                                  CASE WHEN acd.devolucao_data is not null THEN                           
                                      acd.devolucao_descricao                                             
                                  ELSE                                                                    
                                      CASE WHEN ap.nr_parcela = 0                                         
                                                  and (ap.vencimento < '$dataBase')               
                                                  and baixa_manual_unica.valor = 'nao'                    
                                      THEN                                                                
                                          'Cancelada (Parcela única vencida)'                             
                                      ELSE                                                                
                                          'Em Aberto'                                                     
                                      END                                                                 
                                  END                                                                     
                              END                                                                         
                          )::varchar as situacao                                                          
                      ---- PARCELA FIM                                                                    
                          , al.valor as lancamento_valor                                                  
                      ---- PAGAMENTO                                                                      
                          , to_char(apag.pagamento_data,'dd/mm/YYYY') as pagamento_data                   
                          , apag.pagamento_data_baixa                                                     
                          , apag.processo_pagamento                                                       
                          , apag.observacao                                                               
                          , apag.tp_pagamento                                                             
                          , apag.pagamento_tipo                                                           
                          , pag_lote.pagamento_cod_lote                                                   
                          , coalesce ( apag_dif.pagamento_diferenca, 0.00 ) as tmp_pagamento_diferenca    
                          , apag.pagamento_valor                                                          
                          , ( CASE WHEN pag_lote.numeracao is not null THEN                               
                                  pag_lote.cod_banco                                                      
                              ELSE                                                                        
                                  pag_lote_manual.cod_banco                                               
                              END                                                                         
                          ) as pagamento_cod_banco                                                        
                          , ( CASE WHEN pag_lote.numeracao is not null THEN                               
                                  pag_lote.num_banco                                                      
                              ELSE                                                                        
                                  pag_lote_manual.num_banco                                               
                              END                                                                         
                          ) as pagamento_num_banco                                                        
                          , ( CASE WHEN pag_lote.numeracao is not null THEN                               
                                  pag_lote.nom_banco                                                      
                              ELSE                                                                        
                                  pag_lote_manual.nom_banco                                               
                              END                                                                         
                          ) as pagamento_nom_banco                                                        
                          , ( CASE WHEN pag_lote.numeracao is not null THEN                               
                                  pag_lote.cod_agencia                                                    
                              ELSE                                                                        
                                  pag_lote_manual.cod_agencia                                             
                              END                                                                         
                          ) as pagamento_cod_agencia                                                      
                          , ( CASE WHEN pag_lote.numeracao is not null THEN                               
                                  pag_lote.num_agencia                                                    
                              ELSE                                                                        
                                  pag_lote_manual.num_agencia                                             
                              END                                                                         
                          ) as pagamento_num_agencia                                                      
                          , ( CASE WHEN pag_lote.numeracao is not null THEN                               
                                  pag_lote.nom_agencia                                                    
                              ELSE                                                                        
                                  pag_lote_manual.nom_agencia                                             
                              END                                                                         
                          ) as pagamento_nom_agencia                                                      
                          , ( CASE WHEN pag_lote.numeracao is not null THEN                               
                                  pag_lote.numcgm                                                         
                              ELSE                                                                        
                                  apag.pagamento_cgm                                                      
                              END                                                                         
                          ) as pagamento_numcgm                                                           
                          , ( CASE WHEN pag_lote.numeracao is not null THEN                               
                                  pag_lote.nom_cgm                                                        
                              ELSE                                                                        
                                  apag.pagamento_nome                                                     
                              END                                                                         
                          ) as pagamento_nomcgm                                                           
                          , apag.ocorrencia_pagamento                                                     
                      ---- CARNE DEVOLUCAO                                                                
                          , acd.devolucao_data                                                            
                          , acd.devolucao_descricao                                                       
                      ---- CARNE MIGRACAO                                                                 
                          , acm.numeracao_migracao as migracao_numeracao                                  
                          , acm.prefixo as migracao_prefixo                                               
                      ---- CONSOLIDACAO                                                                   
                          , accon.numeracao_consolidacao as consolidacao_numeracao                        
                      ---- PARCELA ACRESCIMOS                                                             
                          , ( CASE WHEN  
                                          ( ap.valor = 0.00 )                                          
                                          OR ( apag.pagamento_data is not null                            
                                               AND ap.vencimento >= apag.pagamento_data )                 
                              THEN                                                                        
                                  0.00                                                                    
                              ELSE                                                                        
                                  aplica_correcao( carne.numeracao::varchar, carne.exercicio::integer, carne.cod_parcela, '$dataBase'::date )::numeric(14,2) 
                              END                                                                         
                          )::numeric(14,2) as parcela_correcao_pagar                                      
                          , ( CASE WHEN  
                                          ( ap.valor = 0.00 )                                          
                                          OR ( apag.pagamento_data is not null                            
                                               AND ap.vencimento >= apag.pagamento_data )                 
                              THEN                                                                        
                                  0.00                                                                    
                              ELSE                                                                        
                                  aplica_juro( carne.numeracao::varchar, carne.exercicio::integer, carne.cod_parcela, '$dataBase'::date )::numeric(14,2) 
                              END                                                                         
                          )::numeric(14,2) as parcela_juros_pagar                                         
                          , ( CASE WHEN  
                                          ( ap.valor = 0.00 )                                          
                                          OR (apag.pagamento_data is not null                             
                                              AND ap.vencimento >= apag.pagamento_data                    
                                          )                                                               
                              THEN                                                                        
                                  0.00                                                                    
                              ELSE                                                                        
                                  aplica_multa( carne.numeracao::varchar, carne.exercicio::integer, carne.cod_parcela, '$dataBase'::date )::numeric(14,2) 
                              END                                                                         
                          )::numeric(14,2) as parcela_multa_pagar                                         
                          , ( CASE WHEN ( apag.pagamento_data is not null                                 
                                          AND ap.vencimento < apag.pagamento_data )                       
                              THEN                                                                        
                                  ( select                                                                
                                        sum(valor)                                                        
                                    from                                                                  
                                        arrecadacao.pagamento_acrescimo                                   
                                    where                                                                 
                                        numeracao = apag.numeracao                                        
                                        AND cod_convenio = apag.cod_convenio                              
                                        AND ocorrencia_pagamento = apag.ocorrencia_pagamento              
                                        AND cod_tipo = 1                                                  
                                  )                                                                       
                              ELSE                                                                        
                                  0.00                                                                    
                              END                                                                         
                          )::numeric(14,2) as parcela_correcao_pago                                       
                          , ( CASE WHEN ( apag.pagamento_data is not null                                 
                                          AND ap.vencimento < apag.pagamento_data )                       
                              THEN                                                                        
                                  ( select                                                                
                                        sum(valor)                                                        
                                    from                                                                  
                                        arrecadacao.pagamento_acrescimo                                   
                                    where                                                                 
                                        numeracao = apag.numeracao                                        
                                        AND cod_convenio = apag.cod_convenio                              
                                        AND ocorrencia_pagamento = apag.ocorrencia_pagamento              
                                        AND cod_tipo = 3                                                  
                                  )                                                                       
                              ELSE                                                                        
                                  0.00                                                                    
                              END                                                                         
                          )::numeric(14,2) as parcela_multa_pago                                          
                          , ( CASE WHEN ( apag.pagamento_data is not null AND                             
                                          ap.vencimento < apag.pagamento_data )                           
                              THEN                                                                        
                                  ( select                                                                
                                      sum(valor)                                                          
                                    from                                                                  
                                      arrecadacao.pagamento_acrescimo                                     
                                    where                                                                 
                                      numeracao = apag.numeracao                                          
                                      AND cod_convenio = apag.cod_convenio                                
                                      AND ocorrencia_pagamento = apag.ocorrencia_pagamento                
                                      AND cod_tipo = 2                                                    
                                  )                                                                       
                              ELSE                                                                        
                                  0.00                                                                    
                              END                                                                         
                          )::numeric(14,2) as parcela_juros_pago                                          
              FROM                                                                                        
                  arrecadacao.carne as carne                                                              
                  LEFT JOIN (                                                                             
                      select                                                                              
                          exercicio                                                                       
                          , valor                                                                         
                      from                                                                                
                          administracao.configuracao                                                      
                      where parametro = 'baixa_manual' AND cod_modulo = 25                                
                  ) as baixa_manual_unica                                                                 
                  ON baixa_manual_unica.exercicio = carne.exercicio                                       
              ---- PARCELA                                                                                
                  INNER JOIN (                                                                            
                      select                                                                              
                          cod_parcela                                                                     
                          , valor                                                                         
                          , arrecadacao.fn_atualiza_data_vencimento (vencimento) as vencimento            
                          , nr_parcela                                                                    
                          , cod_lancamento                                                                
                      from                                                                                
                          arrecadacao.parcela as ap                                                       
                  ) as ap                                                                                 
                  ON ap.cod_parcela = carne.cod_parcela                                                   
                  LEFT JOIN (                                                                             
                      select                                                                              
                          apr.cod_parcela                                                                 
                          , arrecadacao.fn_atualiza_data_vencimento( vencimento ) as vencimento           
                          , valor                                                                         
                      from                                                                                
                          arrecadacao.parcela_reemissao apr                                               
                          inner join (                                                                    
                              select cod_parcela, min(timestamp) as timestamp                             
                              from arrecadacao.parcela_reemissao                                          
                              group by cod_parcela                                                        
                          ) as apr2                                                                       
                          ON apr2.cod_parcela = apr.cod_parcela                                           
                          AND apr2.timestamp = apr.timestamp                                              
                  ) as apr                                                                                
                  ON apr.cod_parcela = ap.cod_parcela                                                     
                  LEFT JOIN arrecadacao.parcela_desconto apd                                              
                  ON apd.cod_parcela = ap.cod_parcela                                                     
                ---- #                                                                                    
                  INNER JOIN arrecadacao.lancamento as al                                                 
                  ON al.cod_lancamento = ap.cod_lancamento                                                
                  INNER JOIN arrecadacao.lancamento_calculo as alc                                        
                  ON alc.cod_lancamento = al.cod_lancamento                                               
                  INNER JOIN arrecadacao.calculo as ac                                                    
                  ON ac.cod_calculo = alc.cod_calculo                                                     
              ---- PAGAMENTO                                                                              
                  LEFT JOIN (                                                                             
                      SELECT                                                                              
                          apag.numeracao                                                                  
                          , apag.cod_convenio                                                             
                          , apag.observacao                                                               
                          , atp.pagamento as tp_pagamento                                                 
                          , apag.data_pagamento as pagamento_data                                         
                          , to_char(apag.data_baixa,'dd/mm/YYYY') as pagamento_data_baixa                 
                          , app.cod_processo::varchar||'/'||app.ano_exercicio as processo_pagamento       
                          , cgm.numcgm as pagamento_cgm                                                   
                          , cgm.nom_cgm as pagamento_nome                                                 
                          , atp.nom_tipo as pagamento_tipo                                                
                          , apag.valor as pagamento_valor                                                 
                          , apag.ocorrencia_pagamento                                                     
                      FROM                                                                                
                          arrecadacao.pagamento as apag                                                   
                          INNER JOIN sw_cgm as cgm                                                        
                          ON cgm.numcgm = apag.numcgm                                                     
                          INNER JOIN arrecadacao.tipo_pagamento as atp                                    
                          ON atp.cod_tipo = apag.cod_tipo                                                 
                          LEFT JOIN arrecadacao.processo_pagamento as app                                 
                          ON app.numeracao = apag.numeracao AND app.cod_convenio = apag.cod_convenio      
                  ) as apag                                                                               
                  ON apag.numeracao = carne.numeracao                                                     
                  AND apag.cod_convenio = carne.cod_convenio                                              
                  LEFT JOIN (                                                                             
                      SELECT                                                                              
                          numeracao                                                                       
                          , cod_convenio                                                                  
                          , ocorrencia_pagamento                                                          
                          , sum( valor ) as pagamento_diferenca                                           
                      FROM arrecadacao.pagamento_diferenca                                                
                      GROUP BY numeracao, cod_convenio, ocorrencia_pagamento                              
                  ) as apag_dif                                                                           
                  ON apag_dif.numeracao = carne.numeracao                                                 
                  AND apag_dif.cod_convenio = carne.cod_convenio                                          
                  AND apag_dif.ocorrencia_pagamento = apag.ocorrencia_pagamento                           
              ---- PAGAMENTO LOTE AUTOMATICO                                                              
                  LEFT JOIN (                                                                             
                      SELECT                                                                              
                          pag_lote.numeracao                                                              
                          , pag_lote.cod_convenio                                                         
                          , lote.cod_lote as pagamento_cod_lote                                           
                          , cgm.numcgm                                                                    
                          , cgm.nom_cgm                                                                   
                          , lote.data_lote                                                                
                          , mb.cod_banco                                                                  
                          , mb.num_banco                                                                  
                          , mb.nom_banco                                                                  
                          , mag.cod_agencia                                                               
                          , mag.num_agencia                                                               
                          , mag.nom_agencia                                                               
                          , pag_lote.ocorrencia_pagamento                                                 
                      FROM                                                                                
                          arrecadacao.pagamento_lote pag_lote                                             
                          INNER JOIN arrecadacao.lote lote                                                
                          ON lote.cod_lote = pag_lote.cod_lote                                            
                          AND pag_lote.exercicio = lote.exercicio                                         
                          INNER JOIN monetario.banco as mb ON mb.cod_banco = lote.cod_banco               
                          INNER JOIN sw_cgm cgm ON cgm.numcgm = lote.numcgm                               
                          LEFT JOIN monetario.conta_corrente_convenio mccc                                
                          ON mccc.cod_convenio = pag_lote.cod_convenio                                    
                          LEFT JOIN monetario.agencia mag                                                 
                          ON mag.cod_agencia = lote.cod_agencia                                           
                          AND mag.cod_banco = mb.cod_banco                                                
                  ) as pag_lote                                                                           
                  ON pag_lote.numeracao = carne.numeracao                                                 
                  AND pag_lote.cod_convenio = carne.cod_convenio                                          
              ----- PAGAMENTO LOTE MANUAL                                                                 
                  LEFT JOIN (                                                                             
                      SELECT                                                                              
                          pag_lote.numeracao                                                              
                          , pag_lote.cod_convenio                                                         
                          , mb.cod_banco                                                                  
                          , mb.num_banco                                                                  
                          , mb.nom_banco                                                                  
                          , mag.cod_agencia                                                               
                          , mag.num_agencia                                                               
                          , mag.nom_agencia                                                               
                          , pag_lote.ocorrencia_pagamento                                                 
                      FROM                                                                                
                          arrecadacao.pagamento_lote_manual pag_lote                                      
                          INNER JOIN monetario.banco as mb ON mb.cod_banco = pag_lote.cod_banco           
                          LEFT JOIN monetario.conta_corrente_convenio mccc                                
                          ON mccc.cod_convenio = pag_lote.cod_convenio                                    
                          LEFT JOIN monetario.agencia mag                                                 
                          ON mag.cod_agencia = pag_lote.cod_agencia                                       
                          AND mag.cod_banco = mb.cod_banco                                                
                  ) as pag_lote_manual                                                                    
                  ON pag_lote_manual.numeracao = carne.numeracao                                          
                  AND pag_lote_manual.cod_convenio = carne.cod_convenio                                   
                  AND pag_lote_manual.ocorrencia_pagamento = apag.ocorrencia_pagamento                    
              ---- CARNE DEVOLUCAO                                                                        
                  LEFT JOIN (                                                                             
                      SELECT                                                                              
                          acd.numeracao                                                                   
                          , acd.cod_convenio                                                              
                          , acd.dt_devolucao as devolucao_data                                            
                          , amd.descricao as devolucao_descricao                                          
                      FROM                                                                                
                          arrecadacao.carne_devolucao as acd                                              
                          INNER JOIN arrecadacao.motivo_devolucao as amd                                  
                          ON amd.cod_motivo = acd.cod_motivo                                              
                  ) as acd                                                                                
                  ON acd.numeracao = carne.numeracao                                                      
                  AND acd.cod_convenio = carne.cod_convenio                                               
                  LEFT JOIN arrecadacao.carne_migracao acm                                                
                  ON  acm.numeracao  = carne.numeracao                                                    
                  AND acm.cod_convenio = carne.cod_convenio                                               
                  LEFT JOIN arrecadacao.carne_consolidacao as accon                                       
                  ON accon.numeracao = carne.numeracao                                                    
                  AND accon.cod_convenio = carne.cod_convenio                                             
              WHERE                                                                                       
                   ac.cod_calculo = :codCalculo                                                                         
              ORDER BY                                                                                    
                  ap.nr_parcela                                                                           
              ) as consulta;";

        $query = $this->entityManager->getConnection()->prepare($sql);

        if ($codCalculo) {
            $query->bindValue(':codCalculo', $codCalculo);
        }

        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }
}
