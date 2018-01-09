<?php

namespace Urbem\CoreBundle\Repository\Tributario\DividaAtiva;

use Urbem\CoreBundle\Entity\Divida\DividaParcelamento;
use Urbem\CoreBundle\Entity\Divida\EmissaoDocumento;
use Urbem\CoreBundle\Entity\Divida\Parcela;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Repository\AbstractRepository;

class InscricaoRepository extends AbstractRepository
{

    /**
     * @return array
     */
    public function findAllInscricaoAno()
    {
        $sql = '
            select
                distinct dda.*,
                dda.exercicio || \'/\' || dda.cod_inscricao as exercicio_inscricao, 
                ddc.numcgm,
                (
                    select
                        nom_cgm
                    from
                        sw_cgm
                    where
                        numcgm = ddc.numcgm
                ) as nom_cgm,
                coalesce(
                    ddi.inscricao_municipal,
                    dde.inscricao_economica
                )|| \' - \' as cod_inscricao_imec,
                case
                    when ddi.inscricao_municipal is not null then imobiliario.fn_busca_endereco_imovel_formatado(ddi.inscricao_municipal)
                    else(
                        select
                            (
                                select
                                    nom_cgm
                                from
                                    sw_cgm
                                where
                                    numcgm = coalesce(
                                        CEED.numcgm,
                                        CEEF.numcgm,
                                        CEA.numcgm
                                    )
                            )
                        from
                            economico.cadastro_economico as CE left join economico.cadastro_economico_empresa_direito CEED on
                            CEED.inscricao_economica = CE.inscricao_economica left join economico.cadastro_economico_empresa_fato CEEF on
                            CEEF.inscricao_economica = CE.inscricao_economica left join economico.cadastro_economico_autonomo CEA on
                            CEA.inscricao_economica = CE.inscricao_economica
                        where
                            CE.inscricao_economica = dde.inscricao_economica
                    )
                end as descricao_inscricao_imec,
                (
                    case
                        when ddi.cod_inscricao is not null then \'IM\'
                        else \'IE\'
                    end
                ) as tipo_divida,
                (
                    case
                        when ddcanc.cod_inscricao is not null then true
                        else false
                    end
                ) as cancelada
            from
                divida.divida_ativa as dda inner join divida.divida_cgm as ddc on
                ddc.cod_inscricao = dda.cod_inscricao
                and ddc.exercicio = dda.exercicio left join sw_cgm on
                sw_cgm.numcgm = ddc.numcgm left join divida.divida_imovel as ddi on
                ddi.cod_inscricao = dda.cod_inscricao
                and ddi.exercicio = dda.exercicio left join divida.divida_empresa as dde on
                dde.cod_inscricao = dda.cod_inscricao
                and dde.exercicio = dda.exercicio left join divida.divida_cancelada as ddcanc on
                ddcanc.cod_inscricao = dda.cod_inscricao
                and ddcanc.exercicio = dda.exercicio
        ';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @return array
     */
    public function findSwClassificacao()
    {
        return $this->_em->createQueryBuilder()
            ->select(['sw.codClassificacao', 'sw.nomClassificacao'])
            ->from(SwClassificacao::class, 'sw')
            ->orderBy('sw.codClassificacao', 'ASC')
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY)
            ;
    }

    /**
     * @param $codClassificacao
     * @return array
     */
    public function findSwAssunto($codClassificacao)
    {
        $assuntos = $this->_em->createQueryBuilder()
            ->select(["CONCAT(sw.codAssunto, CONCAT('-', sw.codClassificacao)) as assuntoClassificacao" ,'sw.nomAssunto'])
            ->from(SwAssunto::class, 'sw')
        ;

        if (!empty($codClassificacao)) {
            $assuntos
                ->andWhere("sw.codClassificacao = :codClassificacao")
                ->setParameter('codClassificacao', $codClassificacao);
        }

        return $assuntos
                    ->orderBy('sw.codAssunto', 'ASC')
                    ->getQuery()
                    ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY)
        ;
    }

    /**
     * @param $codClassificacao
     * @param $codAssunto
     * @return array
     */
    public function findProcessos($codClassificacao, $codAssunto)
    {
        $sql = '
             SELECT																	
			      P.cod_processo													
	        ,  P.ano_exercicio													
	        ,  P.cod_classificacao												
	        ,  P.cod_assunto														
	        ,  P.cod_usuario														
	        ,  P.cod_situacao													
			   ,  P.timestamp														
			   ,  P.observacoes														
			   ,  P.confidencial													
			   ,  P.resumo_assunto													
	        ,  P.cod_processo||\'/\'||P.ano_exercicio as cod_processo_completo  	
	        ,  A.nom_assunto														
	        ,  C.nom_classificacao												
	        ,  TO_CHAR(P.timestamp,\'dd/mm/yyyy\') as inclusao						
	        ,  G.nom_cgm  														
	        ,  G.numcgm                                         	    
	    FROM   sw_processo              as P           							
	        ,  sw_assunto               as A										
	        ,  sw_classificacao         as C										
	        ,  sw_cgm                   as G										
	        ,  sw_processo_interessado  as PI									
	    WHERE  P.cod_assunto       = A.cod_assunto								
	      AND  P.cod_classificacao = C.cod_classificacao							
	      AND  C.cod_classificacao = A.cod_classificacao							
			 AND  PI.ano_exercicio = P.ano_exercicio								
			 AND  PI.cod_processo  = P.cod_processo									
	      AND  PI.numcgm		   = G.numcgm  											  
        ';

        if (!empty($codClassificacao)) {
            $sql .= ' AND P.cod_classificacao = :cod_classificacao  AND P.cod_assunto = :cod_assunto';
        }

        $query = $this->_em->getConnection()->prepare($sql);
        if (!empty($codClassificacao)) {
            $query->bindValue('cod_classificacao', $codClassificacao);
            $query->bindValue('cod_assunto', $codAssunto);
        }

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $codInscricao
     * @param $exercicio
     * @return mixed
     */
    public function findDividaParcelamento($codInscricao, $exercicio)
    {
        return $this->_em->createQueryBuilder()
            ->select(['p.exercicio', 'p.codInscricao', 'p.numParcelamento'])
            ->from(DividaParcelamento::class, 'p')
            ->andWhere("p.codInscricao = :codInscricao")
            ->andWhere("p.exercicio = :exercicio")
            ->setParameter('codInscricao', $codInscricao)
            ->setParameter('exercicio', $exercicio)
            ->orderBy('p.numParcelamento', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @param $numParcelamento
     * @return array
     */
    public function findDividaParcela($numParcelamento)
    {
        return $this->_em->createQueryBuilder()
            ->select(['p.numParcelamento', 'p.numParcela', 'p.vlrParcela', 'p.dtVencimentoParcela', 'p.paga', 'p.cancelada'])
            ->from(Parcela::class, 'p')
            ->andWhere("p.numParcelamento = :numParcelamento")
            ->andWhere("p.cancelada = :cancelada")
            ->setParameter('numParcelamento', $numParcelamento)
            ->setParameter('cancelada', false)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $numParcelamento
     * @return mixed
     */
    public function findDadosDocumento($numParcelamento)
    {
        $sql = '
             SELECT DISTINCT 
                    ddd.*, 
                    divida_ativa.cod_inscricao AS cod_inscricao_divida_ativa,
                    divida_ativa.exercicio AS exercicio_divida_ativa,  
                    ded.num_emissao, 
                    ded.num_documento, 
                    ded.exercicio, 
                    CASE WHEN dp.numero_parcelamento = -1 THEN
                                   \' \'
                       ELSE
                           dp.numero_parcelamento::text
                       END AS numero_parcelamento, 
            CASE WHEN dp.exercicio = \'-1\' THEN
                           \' \'
                       ELSE
                           dp.exercicio::text
                       END AS exercicio_cobranca,  
            ( 
                SELECT 
                    swc.nom_cgm 
                FROM 
                    sw_cgm AS swc 
                WHERE 
                    swc.numcgm = ddc.numcgm 
            )AS nom_cgm, 
            ddc.numcgm, 
            amd.nome_documento, 
            amd.nome_arquivo_agt, 
            aad.nome_arquivo_swx, 
            (   SELECT to_char(emissao_documento.timestamp, \'dd/mm/YYYY\')
                                  FROM divida.emissao_documento
                                WHERE emissao_documento.num_parcelamento = ded.num_parcelamento
                                  AND emissao_documento.cod_tipo_documento = ded.cod_tipo_documento
                                  AND emissao_documento.cod_documento = ded.cod_documento
                                  AND emissao_documento.num_documento = ded.num_documento
                                ORDER BY emissao_documento.timestamp ASC
                                LIMIT 1
                            ) AS data_emissao, 
                            (   SELECT emissao_documento.num_emissao
                                  FROM divida.emissao_documento
                                WHERE emissao_documento.num_parcelamento = ded.num_parcelamento
                                  AND emissao_documento.cod_tipo_documento = ded.cod_tipo_documento
                                  AND emissao_documento.cod_documento = ded.cod_documento
                                  AND emissao_documento.num_documento = ded.num_documento
                                ORDER BY emissao_documento.timestamp DESC
                                LIMIT 1
                            ) AS num_emissao 
                        FROM  divida.documento AS ddd 
                        
                        LEFT JOIN divida.emissao_documento AS ded
                               ON ded.num_parcelamento = ddd.num_parcelamento
                              AND ded.cod_documento = ddd.cod_documento
                              AND ded.cod_tipo_documento = ddd.cod_tipo_documento 
                        
                        INNER JOIN divida.divida_parcelamento AS ddp 
                                ON ddp.num_parcelamento = ddd.num_parcelamento 
            
                        INNER JOIN divida.parcelamento AS dp 
                                ON dp.num_parcelamento = ddd.num_parcelamento 
            
                        INNER JOIN divida.divida_cgm AS ddc 
                                ON ddc.exercicio = ddp.exercicio 
                               AND ddc.cod_inscricao = ddp.cod_inscricao 
             
                        INNER JOIN administracao.modelo_documento AS amd 
                                ON amd.cod_documento = ddd.cod_documento 
                               AND amd.cod_tipo_documento = ddd.cod_tipo_documento 
            
                        INNER JOIN administracao.modelo_arquivos_documento AS amad 
                                ON amad.cod_documento = ddd.cod_documento 
                               AND amad.cod_tipo_documento = ddd.cod_tipo_documento 
            
                        INNER JOIN administracao.arquivos_documento AS aad 
                                ON aad.cod_arquivo = amad.cod_arquivo 
            
                        LEFT JOIN divida.divida_imovel AS ddi 
                               ON ddi.exercicio = ddp.exercicio 
                              AND ddi.cod_inscricao = ddp.cod_inscricao 
                        
                        LEFT JOIN divida.divida_empresa AS dde 
                               ON dde.exercicio = ddp.exercicio 
                              AND dde.cod_inscricao = ddp.cod_inscricao
            
                        LEFT JOIN divida.divida_cancelada AS ddcanc
                               ON ddcanc.cod_inscricao = ddp.cod_inscricao
                              AND ddcanc.exercicio = ddp.exercicio
            
                        LEFT JOIN divida.divida_remissao
                               ON divida_remissao.cod_inscricao = ddp.cod_inscricao
                              AND divida_remissao.exercicio = ddp.exercicio
                            
                        LEFT JOIN divida.divida_ativa
                               ON divida_ativa.cod_inscricao = ddp.cod_inscricao
                              AND divida_ativa.exercicio = ddp.exercicio  
                            
                        LEFT JOIN divida.modalidade_vigencia
                               ON modalidade_vigencia.cod_modalidade = dp.cod_modalidade 
                              AND modalidade_vigencia.timestamp = dp.timestamp_modalidade
                            
                        LEFT JOIN divida.modalidade
                               ON modalidade.cod_modalidade = modalidade_vigencia.cod_modalidade   
                 WHERE  divida_remissao.cod_inscricao IS NULL AND  
             dp.num_parcelamento in ( :num_parcelamento ) AND  
             ded.timestamp IS NULL  ORDER by exercicio_divida_ativa  DESC LIMIT 1             
        ';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('num_parcelamento', $numParcelamento);

        $query->execute();
        return $query->fetch();
    }

    /**
     * @param $codDocumento
     * @param $codTipoDocumento
     * @param $exercicio
     * @return mixed
     */
    public function findDividaEmissaoDocumento($codDocumento, $codTipoDocumento, $exercicio)
    {
        return $this->_em->createQueryBuilder()
            ->select(['d.numParcelamento', 'd.numDocumento', 'd.numEmissao'])
            ->from(EmissaoDocumento::class, 'd')
            ->andWhere("d.codDocumento = :codDocumento")
            ->andWhere("d.codTipoDocumento = :codTipoDocumento")
            ->andWhere("d.exercicio = :exercicio")
            ->setParameter('codDocumento', $codDocumento)
            ->setParameter('codTipoDocumento', $codTipoDocumento)
            ->setParameter('exercicio', $exercicio)
            ->orderBy('d.numDocumento', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @param $numParcelamento
     * @param $codInscricao
     * @param $exercicio
     * @return array
     */
    public function findRegistros($numParcelamento, $codInscricao, $exercicio)
    {
        $sql = '
             SELECT DISTINCT 
            ddd.*, 
            divida_ativa.cod_inscricao AS cod_inscricao_divida_ativa,
            divida_ativa.exercicio AS exercicio_divida_ativa,  
            ded.num_emissao, 
            ded.num_documento, 
            ded.exercicio, 
            CASE WHEN dp.numero_parcelamento = -1 THEN
                           \' \'
                       ELSE
                           dp.numero_parcelamento::text
                       END AS numero_parcelamento, 
            CASE WHEN dp.exercicio = \'-1\' THEN
                           \' \'
                       ELSE
                           dp.exercicio::text
                       END AS exercicio_cobranca,  
            ( 
                SELECT 
                    swc.nom_cgm 
                FROM 
                    sw_cgm AS swc 
                WHERE 
                    swc.numcgm = ddc.numcgm 
            )AS nom_cgm, 
            ddc.numcgm, 
            amd.nome_documento, 
            amd.nome_arquivo_agt, 
            aad.nome_arquivo_swx, 
            (   SELECT to_char(emissao_documento.timestamp, \'dd/mm/YYYY\')
                              FROM divida.emissao_documento
                            WHERE emissao_documento.num_parcelamento = ded.num_parcelamento
                              AND emissao_documento.cod_tipo_documento = ded.cod_tipo_documento
                              AND emissao_documento.cod_documento = ded.cod_documento
                              AND emissao_documento.num_documento = ded.num_documento
                            ORDER BY emissao_documento.timestamp ASC
                            LIMIT 1
                        ) AS data_emissao, 
                        (   SELECT emissao_documento.num_emissao
                              FROM divida.emissao_documento
                            WHERE emissao_documento.num_parcelamento = ded.num_parcelamento
                              AND emissao_documento.cod_tipo_documento = ded.cod_tipo_documento
                              AND emissao_documento.cod_documento = ded.cod_documento
                              AND emissao_documento.num_documento = ded.num_documento
                            ORDER BY emissao_documento.timestamp DESC
                            LIMIT 1
                        ) AS num_emissao 
                    FROM  divida.documento AS ddd 
                    
                    LEFT JOIN divida.emissao_documento AS ded
                           ON ded.num_parcelamento = ddd.num_parcelamento
                          AND ded.cod_documento = ddd.cod_documento
                          AND ded.cod_tipo_documento = ddd.cod_tipo_documento 
                    
                    INNER JOIN divida.divida_parcelamento AS ddp 
                            ON ddp.num_parcelamento = ddd.num_parcelamento 

                    INNER JOIN divida.parcelamento AS dp 
                            ON dp.num_parcelamento = ddd.num_parcelamento 

                    INNER JOIN divida.divida_cgm AS ddc 
                            ON ddc.exercicio = ddp.exercicio 
                           AND ddc.cod_inscricao = ddp.cod_inscricao 
         
                    INNER JOIN administracao.modelo_documento AS amd 
                            ON amd.cod_documento = ddd.cod_documento 
                           AND amd.cod_tipo_documento = ddd.cod_tipo_documento 

                    INNER JOIN administracao.modelo_arquivos_documento AS amad 
                            ON amad.cod_documento = ddd.cod_documento 
                           AND amad.cod_tipo_documento = ddd.cod_tipo_documento 

                    INNER JOIN administracao.arquivos_documento AS aad 
                            ON aad.cod_arquivo = amad.cod_arquivo 

                    LEFT JOIN divida.divida_imovel AS ddi 
                           ON ddi.exercicio = ddp.exercicio 
                          AND ddi.cod_inscricao = ddp.cod_inscricao 
                    
                    LEFT JOIN divida.divida_empresa AS dde 
                           ON dde.exercicio = ddp.exercicio 
                          AND dde.cod_inscricao = ddp.cod_inscricao

                    LEFT JOIN divida.divida_cancelada AS ddcanc
                           ON ddcanc.cod_inscricao = ddp.cod_inscricao
                          AND ddcanc.exercicio = ddp.exercicio

                    LEFT JOIN divida.divida_remissao
                           ON divida_remissao.cod_inscricao = ddp.cod_inscricao
                          AND divida_remissao.exercicio = ddp.exercicio
                        
                    LEFT JOIN divida.divida_ativa
                           ON divida_ativa.cod_inscricao = ddp.cod_inscricao
                          AND divida_ativa.exercicio = ddp.exercicio  
                        
                    LEFT JOIN divida.modalidade_vigencia
                           ON modalidade_vigencia.cod_modalidade = dp.cod_modalidade 
                          AND modalidade_vigencia.timestamp = dp.timestamp_modalidade
                        
                    LEFT JOIN divida.modalidade
                           ON modalidade.cod_modalidade = modalidade_vigencia.cod_modalidade   
             WHERE  divida_remissao.cod_inscricao IS NULL AND  
             dp.num_parcelamento in ( :num_parcelamento ) AND  
             divida_ativa.cod_inscricao = :cod_inscricao AND
             divida_ativa.exercicio = :exercicio AND
             ded.timestamp IS NULL  ORDER BY ddd.num_parcelamento, ddd.cod_documento
        ';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('num_parcelamento', $numParcelamento);
        $query->bindValue('cod_inscricao', $codInscricao);
        $query->bindValue('exercicio', $exercicio);

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $numParcelamento
     * @return mixed
     */
    public function findDadosDocumentoNotificacaoDa($numParcelamento)
    {
        $sql = '
        SELECT DISTINCT
            to_char(now(), \'dd/mm/yyyy\') AS dt_notificacao,
            dda.dt_vencimento_origem,
            sw_cgm_pessoa_fisica.rg,
            sw_cgm_pessoa_fisica.orgao_emissor,
            COALESCE( sw_cgm_pessoa_fisica.cpf, sw_cgm_pessoa_juridica.cnpj ) AS cpf_cnpj,
            dda.cod_inscricao,
            dda.exercicio,
            dpar.cod_modalidade,
            ddi.inscricao_municipal,
            dde.inscricao_economica,
            COALESCE( ddi.inscricao_municipal, dde.inscricao_economica, ddc.numcgm) AS inscricao,
            dda.num_livro,
            dda.num_folha,
            CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                arrecadacao.fn_consulta_endereco_todos( ddi.inscricao_municipal, 1, 1 )
            ELSE
                CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                    arrecadacao.fn_consulta_endereco_todos( dde.inscricao_economica, 2, 1 )
                ELSE
                    arrecadacao.fn_consulta_endereco_todos( ddc.numcgm, 3, 1 )
                END
            END AS endereco,

            CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                arrecadacao.fn_consulta_endereco_todos( ddi.inscricao_municipal, 1, 2 )
            ELSE
                CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                    arrecadacao.fn_consulta_endereco_todos( dde.inscricao_economica, 2, 2 )
                ELSE
                    arrecadacao.fn_consulta_endereco_todos( ddc.numcgm, 3, 2 )
                END
            END AS bairro,

            CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                arrecadacao.fn_consulta_endereco_todos( ddi.inscricao_municipal, 1, 3 )
            ELSE
                CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                    arrecadacao.fn_consulta_endereco_todos( dde.inscricao_economica, 2, 3 )
                ELSE
                    arrecadacao.fn_consulta_endereco_todos( ddc.numcgm, 3, 3 )
                END
            END AS cep,

            parcela_origem.valor AS valor_origem,
            parcela_origem.cod_credito||\'.\'||parcela_origem.cod_especie||\'.\'||parcela_origem.cod_genero||\'.\'||parcela_origem.cod_natureza||\' - \'||credito.descricao_credito AS credito_origem,
            parcela_origem.cod_natureza,
            aplica_acrescimo_modalidade (
                0,
                dda.cod_inscricao,
                dda.exercicio::integer,
                dpar.cod_modalidade,
                3,
                dpar.num_parcelamento,
                parcela_origem.valor,
                dda.dt_vencimento_origem,
                now()::date,
                \'false\'
            ) AS acrescimos_m,

            aplica_acrescimo_modalidade (
                0,
                dda.cod_inscricao,
                dda.exercicio::integer,
                dpar.cod_modalidade,
                2,
                dpar.num_parcelamento,
                parcela_origem.valor,
                dda.dt_vencimento_origem,
                now()::date,
                \'false\'
            ) AS acrescimos_j,

            aplica_acrescimo_modalidade (
                0,
                dda.cod_inscricao,
                dda.exercicio::integer,
                dpar.cod_modalidade,
                1,
                dpar.num_parcelamento,
                parcela_origem.valor,
                dda.dt_vencimento_origem,
                now()::date,
                \'false\'
            ) AS acrescimos_c,

            (
                SELECT
                    sum(valor)
                FROM
                    divida.parcela_reducao
                WHERE
                    divida.parcela_reducao.num_parcelamento = ddp.num_parcelamento
            )AS total_reducao,
            dda.exercicio_original AS exercicio_origem,
            (
                SELECT
                    (
                        SELECT
                            arrecadacao.fn_busca_origem_lancamento ( ap.cod_lancamento, dda.exercicio_original::integer, 1, 1 )
                        FROM
                            arrecadacao.parcela AS ap
                        WHERE
                            ap.cod_parcela = dpo.cod_parcela
                    )
                FROM
                    divida.parcela_origem AS dpo
                WHERE
                    dpo.num_parcelamento = (
                        SELECT
                            divida.divida_parcelamento.num_parcelamento
                        FROM
                            divida.divida_parcelamento
                        WHERE
                            divida.divida_parcelamento.cod_inscricao = dda.cod_inscricao
                            AND divida.divida_parcelamento.exercicio = dda.exercicio
                        ORDER BY
                            divida.divida_parcelamento.num_parcelamento ASC
                        LIMIT 1
                    )
                    AND dpo.cod_parcela IN (
                        SELECT
                            dpo2.cod_parcela
                        FROM
                            divida.parcela_origem AS dpo2
                        WHERE
                            dpo2.num_parcelamento = ddp.num_parcelamento
                            AND dpo2.cod_parcela = dpo.cod_parcela
                    )
                    LIMIT 1
            )AS imposto,

            sw_cgm.nom_cgm AS contribuinte,
            sw_cgm.numcgm,

            dpar.num_parcelamento,
            to_char( dda.dt_inscricao, \'dd/mm/yyyy\' ) AS dt_inscricao_divida

        FROM
            divida.divida_ativa AS dda

        INNER JOIN
            divida.divida_cgm AS ddc
        ON
            ddc.cod_inscricao = dda.cod_inscricao
            AND ddc.exercicio = dda.exercicio


        INNER JOIN
            sw_cgm
        ON
            sw_cgm.numcgm = ddc.numcgm

        LEFT JOIN
            sw_cgm_pessoa_fisica
        ON
            sw_cgm_pessoa_fisica.numcgm = sw_cgm.numcgm

        LEFT JOIN
            sw_cgm_pessoa_juridica
        ON
            sw_cgm_pessoa_juridica.numcgm = sw_cgm.numcgm

        LEFT JOIN
            divida.divida_imovel AS ddi
        ON
            ddi.cod_inscricao = ddc.cod_inscricao
            AND ddi.exercicio = ddc.exercicio

        LEFT JOIN
            divida.divida_empresa AS dde
        ON
            dde.cod_inscricao = ddc.cod_inscricao
            AND dde.exercicio = ddc.exercicio

        INNER JOIN
            (
                SELECT
                    divida_parcelamento.cod_inscricao,
                    divida_parcelamento.exercicio,
                    max(divida_parcelamento.num_parcelamento) AS num_parcelamento
                FROM
                    divida.divida_parcelamento
                GROUP BY
                    divida_parcelamento.cod_inscricao,
                    divida_parcelamento.exercicio
            )AS ddp
        ON
            ddp.cod_inscricao = ddc.cod_inscricao
            AND ddp.exercicio = ddc.exercicio

        INNER JOIN
            divida.parcelamento AS dpar
        ON
            dpar.num_parcelamento = ddp.num_parcelamento

        INNER JOIN
            (
                SELECT
                    min( divida.divida_parcelamento.num_parcelamento ) AS num_parcelamento,
                    divida_parcelamento.cod_inscricao,
                    divida_parcelamento.exercicio
                FROM
                    divida.divida_parcelamento
                GROUP BY
                    divida_parcelamento.cod_inscricao,
                    divida_parcelamento.exercicio
            )AS parcelamento_inscricao
        ON
            parcelamento_inscricao.cod_inscricao = ddc.cod_inscricao
            AND parcelamento_inscricao.exercicio = ddc.exercicio

        INNER JOIN
            (
                SELECT
                    sum( dpo.valor ) as valor,
                    dpo.cod_especie,
                    dpo.cod_genero,
                    dpo.cod_natureza,
                    dpo.cod_credito,
                    dpo.num_parcelamento,
                    dpo2.num_parcelamento AS num_parcelamento_atual
                FROM
                    divida.parcela_origem AS dpo

                INNER JOIN
                    divida.parcela_origem AS dpo2
                ON
                    dpo2.cod_parcela = dpo.cod_parcela

                GROUP BY
                    dpo.cod_especie,
                    dpo.cod_genero,
                    dpo.cod_natureza,
                    dpo.cod_credito,
                    dpo.num_parcelamento,
                    dpo2.num_parcelamento
            )AS parcela_origem
        ON
            parcela_origem.num_parcelamento_atual = ddp.num_parcelamento
            AND parcela_origem.num_parcelamento = parcelamento_inscricao.num_parcelamento

        INNER JOIN
            monetario.credito
        ON
            credito.cod_credito = parcela_origem.cod_credito
            AND credito.cod_especie = parcela_origem.cod_especie
            AND credito.cod_genero = parcela_origem.cod_genero
            AND credito.cod_natureza = parcela_origem.cod_natureza  WHERE dpar.num_parcelamento in ( :num_parcelamento ) 
        ';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('num_parcelamento', $numParcelamento);
        $query->execute();
        return $query->fetch();
    }

    /**
     * @param $numParcelamento
     * @param $codTipoDocumento
     * @return mixed
     */
    public function findDadosTermoConsolidacaoDa($numParcelamento, $codTipoDocumento)
    {
        $sql = 'SELECT DISTINCT
            tdpa.total,
            to_char(now(), \'dd/mm/yyyy\') AS dt_notificacao,
            ddi.inscricao_municipal,  
            (
                SELECT
                    COALESCE( sw_cgm_pessoa_fisica.cpf, sw_cgm_pessoa_juridica.cnpj )
    
                FROM
                    sw_cgm
    
                LEFT JOIN
                    sw_cgm_pessoa_fisica
                ON
                    sw_cgm_pessoa_fisica.numcgm = sw_cgm.numcgm
    
                LEFT JOIN
                    sw_cgm_pessoa_juridica
                ON
                    sw_cgm_pessoa_juridica.numcgm = sw_cgm.numcgm
    
                WHERE
                    sw_cgm.numcgm = ddc.numcgm
            )AS cpf_cnpj,
    
            CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                \'im\'
            ELSE
                CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                    \'ie\'
                ELSE
                    \'cgm\'
                END
            END AS tipo_inscricao,
    
            CASE WHEN ddi.inscricao_municipal IS NOT NULL THEN
                ( select split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), \'§\', 1)||\' \'||split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), \'§\', 3)||\', \'||split_part ( imobiliario.fn_busca_endereco_imovel( ddi.inscricao_municipal ), \'§\', 4) )
            ELSE
                CASE WHEN dde.inscricao_economica IS NOT NULL THEN
                COALESCE( economico.fn_busca_domicilio_fiscal( dde.inscricao_economica ), economico.fn_busca_domicilio_informado( dde.inscricao_economica ) )
                ELSE
                    (
                        SELECT
                            sw_cgm.logradouro ||\' \'|| sw_cgm.numero ||\' \'|| sw_cgm.complemento
                        FROM
                            sw_cgm
                        WHERE
                            sw_cgm.numcgm = ddc.numcgm
                    )
                END
            END AS domicilio_fiscal,
    
            (
                SELECT
                    sw_cgm.nom_cgm
                FROM
                    sw_cgm
                WHERE
                    sw_cgm.numcgm = ddc.numcgm
            )AS contribuinte,
    
            dde.inscricao_economica,
    
            dpa.num_parcela,
            dpa.num_parcela || \'/\' || tdpa.total AS parcelas,
            dpa.vlr_parcela,
            to_char(dpa.dt_vencimento_parcela, \'dd/mm/yyyy\') AS dt_vencimento,
            to_char(dp.timestamp, \'dd/mm/yyyy\') AS dt_acordo,
            CASE WHEN paga = true THEN
                \'Paga\'
            ELSE
                CASE WHEN ( dpa.dt_vencimento_parcela < now() ) THEN
                    \'Vencida\'
                ELSE
                    \'Sem Pagamento\'
                END
            END AS situacao,
    
            dp.numero_parcelamento ||\'/\'||dp.exercicio AS nr_acordo_administrativo,
            (
                SELECT
                    num_documento||\'/\'||exercicio
                FROM
                    divida.emissao_documento
                WHERE
                    emissao_documento.num_parcelamento = dp.num_parcelamento
                    AND emissao_documento.exercicio = dp.exercicio
                    AND cod_tipo_documento = :cod_tipo_documento
                ORDER BY
                    timestamp DESC
                LIMIT 1
            )as notificacao_nr,
            calculo.valor AS valor_corrigido,
            total_multa.valor AS valor_multa,
            total_correcao.valor AS valor_correcao,
            total_juros.valor AS valor_juros,
            total_reducao.valor AS valor_reducao,
            pagamento.valor AS valor_pago,
            pagamento.dt_pagamento
        FROM
            divida.divida_ativa AS dda
    
        INNER JOIN
            divida.divida_cgm AS ddc
        ON
            ddc.cod_inscricao = dda.cod_inscricao
            AND ddc.exercicio = dda.exercicio
    
        LEFT JOIN
            divida.divida_imovel AS ddi
        ON
            ddi.cod_inscricao = dda.cod_inscricao
            AND ddi.exercicio = dda.exercicio
    
        LEFT JOIN
            divida.divida_empresa AS dde
        ON
            dde.cod_inscricao = dda.cod_inscricao
            AND dde.exercicio = dda.exercicio
    
        INNER JOIN
            divida.divida_parcelamento AS ddp
        ON
            ddp.cod_inscricao = dda.cod_inscricao
            AND ddp.exercicio = dda.exercicio
    
        INNER JOIN
            divida.parcelamento AS dp
        ON
            dp.num_parcelamento = ddp.num_parcelamento
    
        INNER JOIN
            (
                SELECT
                    count(num_parcela) AS total,
                    num_parcelamento
                FROM
                    divida.parcela
                GROUP BY
                    num_parcelamento
            )AS tdpa
        ON
            tdpa.num_parcelamento = ddp.num_parcelamento
    
        INNER JOIN
            divida.parcela AS dpa
        ON
            dpa.num_parcelamento = ddp.num_parcelamento
    
        LEFT JOIN ( SELECT parcela_calculo.num_parcelamento
                         , parcela_calculo.num_parcela
                         , pagamento.valor
                         , to_char( pagamento.data_pagamento, \'dd/mm/yyyy\' ) AS dt_pagamento
                      FROM divida.parcela_calculo
                INNER JOIN arrecadacao.lancamento_calculo
                        ON lancamento_calculo.cod_calculo = parcela_calculo.cod_calculo
                INNER JOIN arrecadacao.parcela
                        ON parcela.nr_parcela = parcela_calculo.num_parcela
                       AND parcela.cod_lancamento = lancamento_calculo.cod_lancamento
                INNER JOIN arrecadacao.carne
                        ON carne.cod_parcela = parcela.cod_parcela
                INNER JOIN arrecadacao.pagamento
                        ON pagamento.numeracao = carne.numeracao
                  )AS pagamento
                ON pagamento.num_parcelamento = ddp.num_parcelamento
               AND pagamento.num_parcela = dpa.num_parcela
    
        INNER JOIN ( SELECT sum(vl_credito) AS valor
                          , num_parcelamento
                       FROM divida.parcela_calculo
                   GROUP BY num_parcelamento
                   )AS calculo
                ON calculo.num_parcelamento = ddp.num_parcelamento
    
        LEFT JOIN ( SELECT sum(vlracrescimo) AS valor
                         , num_parcelamento
                      FROM divida.parcela_acrescimo
                     WHERE cod_tipo = 1
                  GROUP BY num_parcelamento
                  )AS total_correcao
               ON total_correcao.num_parcelamento = ddp.num_parcelamento
    
        LEFT JOIN ( SELECT sum(vlracrescimo) AS valor
                         , num_parcelamento
                      FROM divida.parcela_acrescimo
                     WHERE cod_tipo = 2
                  GROUP BY num_parcelamento
                  )AS total_juros
               ON total_juros.num_parcelamento = ddp.num_parcelamento
    
        LEFT JOIN ( SELECT sum(vlracrescimo) AS valor
                         , num_parcelamento
                      FROM divida.parcela_acrescimo
                     WHERE cod_tipo = 3
                  GROUP BY num_parcelamento
                  )AS total_multa
               ON total_multa.num_parcelamento = ddp.num_parcelamento
    
        LEFT JOIN ( SELECT sum(valor) AS valor
                         , num_parcelamento
                      FROM divida.parcela_reducao
                  GROUP BY num_parcelamento
                  )AS total_reducao
               ON total_reducao.num_parcelamento = ddp.num_parcelamento	        
         WHERE ddp.num_parcelamento in ( :num_parcelamento )'
        ;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('num_parcelamento', $numParcelamento);
        $query->bindValue('cod_tipo_documento', $codTipoDocumento);
        $query->execute();
        return $query->fetch();
    }
}
