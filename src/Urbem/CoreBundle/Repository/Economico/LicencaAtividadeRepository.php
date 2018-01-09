<?php

namespace Urbem\CoreBundle\Repository\Economico;

use Doctrine\ORM\EntityRepository;

/**
 * Class LicencaAtividadeRepository
 * @package Urbem\CoreBundle\Repository\Economico
 */
class LicencaAtividadeRepository extends EntityRepository
{
    const COD_MODULO_ADMINISTRACAO = 2;
    const COD_MODULO_CADASTRO_IMOBILIARIO = 12;
    const COD_MODULO_CADASTRO_ECONOMICO = 14;

    /**
     * @param $search
     * @return array
     */
    public function getSwCgmInscricaoEconomica($search)
    {
        $sql = "SELECT  h.inscricao_economica, h.numcgm, cgm.nom_cgm
                FROM (
                    SELECT DISTINCT COALESCE( ef.numcgm, ed.numcgm, au.numcgm ) AS numcgm, ce.inscricao_economica AS inscricao_economica
                    FROM economico.cadastro_economico AS ce
                    LEFT JOIN economico.cadastro_economico_empresa_fato AS ef
                    ON ce.inscricao_economica = ef.inscricao_economica
                    LEFT JOIN economico.cadastro_economico_autonomo AS au
                    ON ce.inscricao_economica = au.inscricao_economica
                    LEFT JOIN economico.cadastro_economico_empresa_direito AS ed
                    ON ce.inscricao_economica = ed.inscricao_economica
                    LEFT JOIN
                    (
                     SELECT baixa_cadastro_economico.*
                     FROM economico.baixa_cadastro_economico
                     INNER JOIN
                        (
                          SELECT
                             MAX( TIMESTAMP ) AS TIMESTAMP,
                             inscricao_economica
                          FROM
                             economico.baixa_cadastro_economico
                          GROUP BY
                             inscricao_economica
                        ) AS tmp
                      ON tmp.inscricao_economica = baixa_cadastro_economico.inscricao_economica
                      AND tmp.TIMESTAMP = baixa_cadastro_economico.TIMESTAMP
                    ) AS ba
                    ON ce.inscricao_economica = ba.inscricao_economica, sw_cgm AS cgm
                    ORDER BY ce.inscricao_economica
                ) AS h
                INNER JOIN public.sw_cgm AS cgm
                ON h.numcgm = cgm.numcgm
                WHERE cgm.nom_cgm ILIKE '%".$search."%'";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $search
     * @return array
     */
    public function getSwCgmByInscricaoEconomica($inscricaoEconomica)
    {
        $sql = "SELECT  h.inscricao_economica, h.numcgm, cgm.nom_cgm
                FROM (
                    SELECT DISTINCT COALESCE( ef.numcgm, ed.numcgm, au.numcgm ) AS numcgm, ce.inscricao_economica AS inscricao_economica
                    FROM economico.cadastro_economico AS ce
                    LEFT JOIN economico.cadastro_economico_empresa_fato AS ef
                    ON ce.inscricao_economica = ef.inscricao_economica
                    LEFT JOIN economico.cadastro_economico_autonomo AS au
                    ON ce.inscricao_economica = au.inscricao_economica
                    LEFT JOIN economico.cadastro_economico_empresa_direito AS ed
                    ON ce.inscricao_economica = ed.inscricao_economica
                    LEFT JOIN
                    (
                     SELECT baixa_cadastro_economico.*
                     FROM economico.baixa_cadastro_economico
                     INNER JOIN
                        (
                          SELECT
                             MAX( TIMESTAMP ) AS TIMESTAMP,
                             inscricao_economica
                          FROM
                             economico.baixa_cadastro_economico
                          GROUP BY
                             inscricao_economica
                        ) AS tmp
                      ON tmp.inscricao_economica = baixa_cadastro_economico.inscricao_economica
                      AND tmp.TIMESTAMP = baixa_cadastro_economico.TIMESTAMP
                    ) AS ba
                    ON ce.inscricao_economica = ba.inscricao_economica, sw_cgm AS cgm
                    ORDER BY ce.inscricao_economica
                ) AS h
                INNER JOIN public.sw_cgm AS cgm
                ON h.numcgm = cgm.numcgm
                WHERE h.inscricao_economica = :cod ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('cod', $inscricaoEconomica);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $inscricaoEconomica
     * @return array
     */
    public function getOcorrenciaLicencaByInscricaoEconomica($inscricaoEconomica)
    {
        $sql = "SELECT
                    CASE WHEN COUNT(j.cod_licenca)=0 THEN 1 ELSE COUNT(j.cod_licenca) END
                FROM (
                    SELECT
                        h.cod_licenca ,
                        h.exercicio ,
                        h.cod_atividade ,
                        h.inscricao_economica ,
                        h.ocorrencia_atividade ,
                        h.ocorrencia_licenca ,
                        TO_CHAR(h.dt_inicio,'dd/mm/yyyy') AS dt_inicio ,
                        TO_CHAR(h.dt_termino,'dd/mm/yyyy') AS dt_termino
                    FROM
                        economico.licenca_atividade AS h
                    WHERE h.inscricao_economica = :cod
                    ORDER BY h.ocorrencia_licenca DESC LIMIT 1
                ) j ";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('cod', $inscricaoEconomica);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
    * @param array|null $params
    * @return array
    */
    public function fetchDadosAlvaraSanitarioMariana(array $params = [])
    {
        if (empty($params['exercicioLicenca']) || empty($params['inscricaoEconomica']) || empty($params['codLicenca']) || empty($params['exercicio'])) {
            return [];
        }

        $query = "
            SELECT DISTINCT
          LPAD (ela.cod_licenca::varchar, 8, '0') as cod_licenca
          , licenca_documento.num_alvara
          , lpad( ela.exercicio, 4, '0')::varchar as exercicio
          , TO_CHAR ( ela.dt_inicio,'dd/mm/yyyy' ) as inicio_licenca
          , TO_CHAR ( ela.dt_termino,'dd/mm/yyyy' ) as termino_licenca
          , ece.inscricao_economica as IE
          , (CASE WHEN edi.timestamp > edf.timestamp  THEN
                             null
                           ELSE
                            edf.inscricao_municipal
                           end) as IM
          , coalesce ( eceA.numcgm, eceD.numcgm, eceF.numcgm ) as numcgm
          , cgm.nom_cgm as razao_social
          , cgmPJ.nom_fantasia
          , cgmPF.rg
          , cgmPF.cpf
          , cgmPJ.cnpj as cnpj
          , NULL as num_emissao
          , eceD.nom_natureza
          , elo.observacao
          , LPAD (ela.cod_licenca::varchar, 4, '0')||ela.exercicio as codigo_barra
          , diretor_tributos.nom_cgm as diretor_tributos
          , TO_CHAR ( now()::date,'dd/mm/yyyy' ) as data_emissao
          , ( CASE WHEN edi.endereco is null OR ( edi.timestamp < COALESCE( edf.timestamp, '1900-01-01 00:00:00' ) ) THEN
                  split_part ( edf.endereco, '§', 1 ) ||' '||
                  split_part ( edf.endereco, '§', 3 ) ||' - '||
                  split_part ( edf.endereco, '§', 4 ) ||' '||
                  split_part ( edf.endereco, '§', 5 ) ||' Bairro: '||
                  split_part ( edf.endereco, '§', 6 ) ||' CEP: '||
                  split_part ( edf.endereco, '§', 7 )
              ELSE
                  split_part ( edi.endereco, '§', 1 ) ||' '||
                  split_part ( edi.endereco, '§', 3 ) ||' - '||
                  split_part ( edi.endereco, '§', 4 ) ||' '||
                  split_part ( edi.endereco, '§', 5 ) ||' Bairro: '||
                  split_part ( edi.endereco, '§', 6 ) ||' CEP: '||
                  split_part ( edi.endereco, '§', 7 )
              END
          ) as rua
          , ( CASE WHEN edi.endereco is null OR ( edi.timestamp < COALESCE( edf.timestamp, '1900-01-01 00:00:00' ) ) THEN
                  split_part ( edf.endereco,'§',5)
              ELSE
                  split_part ( edi.endereco,'§',5)
              END
          ) as complemento
          , ( CASE WHEN edi.endereco is null OR ( edi.timestamp < COALESCE( edf.timestamp, '1900-01-01 00:00:00' ) ) THEN
                  split_part ( edf.endereco,'§',9) ||' / '||
                  split_part ( edf.endereco,'§',11 )
              ELSE
                  split_part ( edi.endereco,'§',9) ||' / '||
                  split_part ( edi.endereco,'§',11 )
              END
          ) as cidade
          , ( CASE WHEN edi.endereco is null OR ( edi.timestamp < COALESCE( edf.timestamp, '1900-01-01 00:00:00' ) ) THEN
                  split_part ( edf.endereco,'§',7)
              ELSE
                  split_part ( edi.endereco,'§',7)
              END
          ) as cep
          , ativide_principal.cod_atividade
          , ativide_principal.nom_atividade
          , ativide_principal.dt_inicio as inicio_atividade
          , upper (prefeitura_nome.valor) as prefeitura_nome
          , prefeitura_cnpj.valor as prefeitura_cnpj
          , ( prefeitura_tl.valor||' '||prefeitura_logr.valor||', '||
              prefeitura_logr_nr.valor||' '||prefeitura_complem.valor||' - '||
              prefeitura_bairro.valor||' - CEP: '||
              substring (prefeitura_cep.valor from 1 for 5)||'-'||
              substring( prefeitura_cep.valor from 6 for 9)
          ) as prefeitura_endereco
          , prefeitura_municipio.nom_municipio as prefeitura_municipio
          , prefeitura_uf.nom_uf as prefeitura_uf
          , prefeitura_uf.sigla_uf as prefeitura_uf_sigla
          , ela.ocorrencia_licenca
          , coalesce (domingo.hr_inicio,  '00:00:00') as domingo_inicio
          , coalesce (domingo.hr_termino, '00:00:00') as domingo_termino
          , coalesce (segunda.hr_inicio,  '00:00:00') as segunda_inicio
          , coalesce (segunda.hr_termino, '00:00:00') as segunda_termino
          , coalesce (terca.hr_inicio,    '00:00:00') as terca_inicio
          , coalesce (terca.hr_termino,   '00:00:00') as terca_termino
          , coalesce (quarta.hr_inicio,   '00:00:00') as quarta_inicio
          , coalesce (quarta.hr_termino,  '00:00:00') as quarta_termino
          , coalesce (quinta.hr_inicio,   '00:00:00') as quinta_inicio
          , coalesce (quinta.hr_termino,  '00:00:00') as quinta_termino
          , coalesce (sexta.hr_inicio,    '00:00:00') as sexta_inicio
          , coalesce (sexta.hr_termino,   '00:00:00') as sexta_termino
          , coalesce (sabado.hr_inicio,   '00:00:00') as sabado_inicio
          , coalesce (sabado.hr_termino,  '00:00:00') as sabado_termino
          , ( CASE WHEN (edf.inscricao_municipal IS NOT NULL) AND (edf.timestamp > COALESCE( edi.timestamp, '1900-01-01 00:00:00' )) THEN
              (
              select valor from imobiliario.atributo_lote_urbano_valor
              where cod_lote = (
                      select cod_lote from imobiliario.imovel_lote
                      where inscricao_municipal = edf.inscricao_municipal
                  )
                  and cod_atributo = (
                      SELECT cod_atributo from administracao.atributo_dinamico
                      WHERE  cod_modulo = :codModuloCadastroImobiliario  AND nom_atributo = 'Lote'
                  )
              ORDER BY timestamp DESC
              LIMIT 1
              )
              END
          ) as Lote
          , ( CASE WHEN (edf.inscricao_municipal IS NOT NULL) and (edf.timestamp > COALESCE( edi.timestamp, '1900-01-01 00:00:00' )) THEN
              (
              select valor from imobiliario.atributo_lote_urbano_valor
              where cod_lote = (
                      select cod_lote from imobiliario.imovel_lote
                      where inscricao_municipal = edf.inscricao_municipal
                  )
                  and cod_atributo = (
                      SELECT cod_atributo from administracao.atributo_dinamico
                      WHERE  cod_modulo = :codModuloCadastroImobiliario  AND nom_atributo = 'Quadra'
                  )
              ORDER BY timestamp DESC
              LIMIT 1
              )
              END
          ) as quadra
          , (CASE WHEN COALESCE( edi.timestamp, '1900-01-01 00:00:00' ) > COALESCE( edf.timestamp, '1900-01-01 00:00:00' )  THEN
                             ''
                           ELSE
           (   SELECT
                  iln.nom_localizacao
              FROM
                  imobiliario.imovel_lote as iil
                  INNER JOIN imobiliario.lote_localizacao as ill
                  ON ill.cod_lote = iil.cod_lote
                  INNER JOIN imobiliario.localizacao AS iloc
                  ON iloc.cod_localizacao = ill.cod_localizacao
                  INNER JOIN (
                      SELECT
                          nom_localizacao
                          , iln.cod_localizacao
                      FROM
                          imobiliario.localizacao AS iloc
                          INNER JOIN  imobiliario.localizacao_nivel AS iln
                          ON iloc.codigo_composto = iln.valor || '.00'
                          AND iln.cod_nivel = 1
                  ) as iln
                  ON iln.cod_localizacao = iloc.cod_localizacao
              WHERE
                  iil.inscricao_municipal = edf.inscricao_municipal)
         END ) AS regiao
          , (CASE WHEN COALESCE( edi.timestamp, '1900-01-01 00:00:00' ) > COALESCE( edf.timestamp, '1900-01-01 00:00:00' )  THEN
                             ''
                           ELSE
          (    SELECT
                  iloc.nom_localizacao
              FROM
                  imobiliario.imovel_lote as iil
                  INNER JOIN imobiliario.lote_localizacao as ill
                  ON ill.cod_lote = iil.cod_lote
                  INNER JOIN imobiliario.localizacao AS iloc
                  ON iloc.cod_localizacao = ill.cod_localizacao
              WHERE iil.inscricao_municipal = edf.inscricao_municipal)
           END) as distrito
      FROM
      (
      select
          ela.*
      from
          economico.licenca_atividade as ela
          INNER JOIN  (
              select
                  inscricao_economica,
                  cod_licenca,
                  max(ocorrencia_licenca) as ocorrencia
              from
                  economico.licenca_atividade
              group by inscricao_economica, cod_licenca
          ) as ela2
          ON ela2.inscricao_economica = ela.inscricao_economica
          AND ela2.cod_licenca = ela.cod_licenca
          AND ela2.ocorrencia = ela.ocorrencia_licenca
      group by
          ela.inscricao_economica,
          ela.cod_licenca,
          ela.exercicio,
          ela.ocorrencia_atividade,
          ela.cod_atividade,
          ela.ocorrencia_licenca,
          ela.dt_inicio,
          ela.dt_termino
      order by
          ela.cod_licenca
      ) as ela
      INNER JOIN
                        economico.licenca_documento
                    ON
                        licenca_documento.cod_licenca = ela.cod_licenca
                        AND licenca_documento.exercicio = ela.exercicio

      INNER JOIN economico.licenca as el
      ON el.cod_licenca = ela.cod_licenca
      AND el.exercicio = ela.exercicio
      LEFT JOIN economico.licenca_observacao as elo
      ON elo.cod_licenca = el.cod_licenca
      AND elo.exercicio = el.exercicio
      INNER JOIN economico.cadastro_economico as ece
      ON ece.inscricao_economica = ela.inscricao_economica
      LEFT JOIN economico.cadastro_economico_autonomo as eceA
      ON eceA.inscricao_economica = ece.inscricao_economica
      LEFT JOIN economico.cadastro_economico_empresa_fato as eceF
      ON eceF.inscricao_economica = ece.inscricao_economica
      LEFT JOIN (
          select
              eceD.inscricao_economica,
              eceD.numcgm,
              enj.nom_natureza
          from
              economico.cadastro_economico_empresa_direito as eceD
              LEFT JOIN (
                  select
                      inscricao_economica,
                      cod_natureza,
                      max(timestamp)
                  from
                      economico.empresa_direito_natureza_juridica as eceDNJ
                  group by
                      inscricao_economica,
                      cod_natureza
              ) as eceDNJ
              on eceDNJ.inscricao_economica = eced.inscricao_economica
              LEFT JOIN economico.natureza_juridica as enj
              on enj.cod_natureza = eceDNJ.cod_natureza
      ) as eceD
      ON eceD.inscricao_economica = ece.inscricao_economica
      LEFT JOIN economico.empresa_direito_natureza_juridica as eceDNJ
      ON eceDNJ.inscricao_economica = ece.inscricao_economica
      INNER JOIN sw_cgm as cgm
      ON cgm.numcgm = coalesce ( eceA.numcgm, eceD.numcgm, eceF.numcgm )
      LEFT JOIN sw_cgm_pessoa_fisica as cgmPF
      ON cgmPF.numcgm = cgm.numcgm
      LEFT JOIN sw_cgm_pessoa_juridica as cgmPJ
      ON cgmPJ.numcgm = cgm.numcgm
      LEFT JOIN  (
          select
              edf1.inscricao_economica, edf1.inscricao_municipal
              , edf1.endereco, edf1.timestamp
          from
          (
              select
                  inscricao_economica
                  , inscricao_municipal
                  , timestamp
                  , economico.fn_busca_domicilio_fiscal (inscricao_economica) as endereco
              from economico.domicilio_fiscal
          ) as edf1
          INNER JOIN  (
              select
                  inscricao_economica, max (timestamp) as timestamp
              from economico.domicilio_fiscal
              group by inscricao_economica
          ) as edf2
          ON edf2.inscricao_economica = edf1.inscricao_economica
          AND edf2.timestamp = edf1.timestamp
      ) as edf
      ON edf.inscricao_economica = ece.inscricao_economica
      LEFT JOIN (
          select edi1.*
          from
          (
              select
                  inscricao_economica, timestamp,
                  economico.fn_busca_domicilio_informado (inscricao_economica) as endereco
              from
                  economico.domicilio_informado as edi
          ) as edi1
          INNER JOIN (
              select inscricao_economica, max (timestamp) as timestamp
              from economico.domicilio_informado
              group by inscricao_economica
          ) as edi2
          ON  edi2.inscricao_economica = edi1.inscricao_economica
          AND edi2.timestamp = edi1.timestamp
      ) as edi
      ON edi.inscricao_economica = ece.inscricao_economica
      INNER JOIN (
          SELECT
              atv.cod_atividade,
              ATE.inscricao_economica,
              atv.nom_atividade,
              atv.cod_estrutural,
              ATE.PRINCIPAL,
              coalesce ( TO_CHAR ( ATE.DT_INICIO,'dd/mm/yyyy' ) , '-') AS dt_inicio,
              coalesce ( TO_CHAR ( ATE.DT_TERMINO,'dd/mm/yyyy' ), '-') AS dt_termino,
              ATE.OCORRENCIA_ATIVIDADE
          FROM
              economico.atividade  AS ATV
              INNER JOIN economico.atividade_cadastro_economico AS ATE
              ON ATV.COD_ATIVIDADE = ATE.COD_ATIVIDADE
    INNER JOIN (
          SELECT MAX(ocorrencia_atividade) AS ocorrencia_atividade
               , inscricao_economica
            FROM economico.atividade_cadastro_economico
        GROUP BY inscricao_economica
          ) AS max_atividade ON max_atividade.inscricao_economica = ATE.inscricao_economica
          AND max_atividade.ocorrencia_atividade = ATE.ocorrencia_atividade
      ) as ativide_principal
      ON ativide_principal.inscricao_economica = ece.inscricao_economica
      AND ativide_principal.cod_atividade = ela.cod_atividade
      LEFT JOIN (
          SELECT
              dias_cadastro_economico.inscricao_economica,
              coalesce(hr_inicio, '00:00:00') as hr_inicio,
              coalesce (hr_termino, '00:00:00') as hr_termino
          FROM
              economico.dias_cadastro_economico
          INNER JOIN
                            (
                                SELECT
                                    max(timestamp) AS timestamp,
                                    cod_dia,
                                    inscricao_economica
                                FROM
                                    economico.dias_cadastro_economico
                                GROUP BY
                                    cod_dia,
                                    inscricao_economica
                            )AS tmp
                        ON
                            tmp.cod_dia = dias_cadastro_economico.cod_dia
                            AND tmp.inscricao_economica = dias_cadastro_economico.inscricao_economica
                            AND tmp.timestamp = dias_cadastro_economico.timestamp
          where dias_cadastro_economico.cod_dia = 1
      ) as domingo
      ON domingo.inscricao_economica = ece.inscricao_economica
      LEFT JOIN (
          SELECT
              dias_cadastro_economico.inscricao_economica,
              coalesce(hr_inicio, '00:00:00') as hr_inicio,
              coalesce (hr_termino, '00:00:00') as hr_termino
          FROM
              economico.dias_cadastro_economico
          INNER JOIN
                            (
                                SELECT
                                    max(timestamp) AS timestamp,
                                    cod_dia,
                                    inscricao_economica
                                FROM
                                    economico.dias_cadastro_economico
                                GROUP BY
                                    cod_dia,
                                    inscricao_economica
                            )AS tmp
                        ON
                            tmp.cod_dia = dias_cadastro_economico.cod_dia
                            AND tmp.inscricao_economica = dias_cadastro_economico.inscricao_economica
                            AND tmp.timestamp = dias_cadastro_economico.timestamp
          where dias_cadastro_economico.cod_dia = 2
      ) as segunda
      ON segunda.inscricao_economica = ece.inscricao_economica
      LEFT JOIN (
          SELECT
              dias_cadastro_economico.inscricao_economica,
              coalesce(hr_inicio, '00:00:00') as hr_inicio,
              coalesce (hr_termino, '00:00:00') as hr_termino
          FROM
              economico.dias_cadastro_economico
          INNER JOIN
                            (
                                SELECT
                                    max(timestamp) AS timestamp,
                                    cod_dia,
                                    inscricao_economica
                                FROM
                                    economico.dias_cadastro_economico
                                GROUP BY
                                    cod_dia,
                                    inscricao_economica
                            )AS tmp
                        ON
                            tmp.cod_dia = dias_cadastro_economico.cod_dia
                            AND tmp.inscricao_economica = dias_cadastro_economico.inscricao_economica
                            AND tmp.timestamp = dias_cadastro_economico.timestamp
          where dias_cadastro_economico.cod_dia = 3
      ) as terca
      ON terca.inscricao_economica = ece.inscricao_economica
      LEFT JOIN (
          SELECT
              dias_cadastro_economico.inscricao_economica,
              coalesce(hr_inicio, '00:00:00') as hr_inicio,
              coalesce (hr_termino, '00:00:00') as hr_termino
          FROM
              economico.dias_cadastro_economico
          INNER JOIN
                            (
                                SELECT
                                    max(timestamp) AS timestamp,
                                    cod_dia,
                                    inscricao_economica
                                FROM
                                    economico.dias_cadastro_economico
                                GROUP BY
                                    cod_dia,
                                    inscricao_economica
                            )AS tmp
                        ON
                            tmp.cod_dia = dias_cadastro_economico.cod_dia
                            AND tmp.inscricao_economica = dias_cadastro_economico.inscricao_economica
                            AND tmp.timestamp = dias_cadastro_economico.timestamp
          where dias_cadastro_economico.cod_dia = 4
      ) as quarta
      ON quarta.inscricao_economica = ece.inscricao_economica
      LEFT JOIN (
          SELECT
              dias_cadastro_economico.inscricao_economica,
              coalesce(hr_inicio, '00:00:00') as hr_inicio,
              coalesce (hr_termino, '00:00:00') as hr_termino
          FROM
              economico.dias_cadastro_economico
          INNER JOIN
                            (
                                SELECT
                                    max(timestamp) AS timestamp,
                                    cod_dia,
                                    inscricao_economica
                                FROM
                                    economico.dias_cadastro_economico
                                GROUP BY
                                    cod_dia,
                                    inscricao_economica
                            )AS tmp
                        ON
                            tmp.cod_dia = dias_cadastro_economico.cod_dia
                            AND tmp.inscricao_economica = dias_cadastro_economico.inscricao_economica
                            AND tmp.timestamp = dias_cadastro_economico.timestamp
          where dias_cadastro_economico.cod_dia = 5
      ) as quinta
      ON quinta.inscricao_economica = ece.inscricao_economica
      LEFT JOIN  (
          SELECT
              dias_cadastro_economico.inscricao_economica,
              coalesce(hr_inicio, '00:00:00') as hr_inicio,
              coalesce (hr_termino, '00:00:00') as hr_termino
          FROM
              economico.dias_cadastro_economico
          INNER JOIN
                            (
                                SELECT
                                    max(timestamp) AS timestamp,
                                    cod_dia,
                                    inscricao_economica
                                FROM
                                    economico.dias_cadastro_economico
                                GROUP BY
                                    cod_dia,
                                    inscricao_economica
                            )AS tmp
                        ON
                            tmp.cod_dia = dias_cadastro_economico.cod_dia
                            AND tmp.inscricao_economica = dias_cadastro_economico.inscricao_economica
                            AND tmp.timestamp = dias_cadastro_economico.timestamp
          where dias_cadastro_economico.cod_dia = 6
      ) as sexta
      ON sexta.inscricao_economica = ece.inscricao_economica
      LEFT JOIN (
          SELECT
              dias_cadastro_economico.inscricao_economica,
              coalesce(hr_inicio, '00:00:00') as hr_inicio,
              coalesce (hr_termino, '00:00:00') as hr_termino
          FROM
              economico.dias_cadastro_economico
          INNER JOIN
                            (
                                SELECT
                                    max(timestamp) AS timestamp,
                                    cod_dia,
                                    inscricao_economica
                                FROM
                                    economico.dias_cadastro_economico
                                GROUP BY
                                    cod_dia,
                                    inscricao_economica
                            )AS tmp
                        ON
                            tmp.cod_dia = dias_cadastro_economico.cod_dia
                            AND tmp.inscricao_economica = dias_cadastro_economico.inscricao_economica
                            AND tmp.timestamp = dias_cadastro_economico.timestamp
          where dias_cadastro_economico.cod_dia = 7
      ) as sabado
      ON sabado.inscricao_economica = ece.inscricao_economica
      , (
          SELECT
              valor
          FROM
              administracao.configuracao
          WHERE
              parametro = 'nom_prefeitura'
              AND cod_modulo = :codModuloAdministracao
              AND exercicio = :exercicio
      ) as prefeitura_nome
      , (
          SELECT
              valor
          FROM
              administracao.configuracao
          WHERE
              parametro = 'tipo_logradouro'
              and cod_modulo = :codModuloAdministracao
              AND exercicio = :exercicio
      ) as prefeitura_tl
      , (
          SELECT
              valor
          FROM
              administracao.configuracao
          where
              parametro = 'logradouro'
              and cod_modulo = :codModuloAdministracao
              AND exercicio = :exercicio
      ) as prefeitura_logr
      , (
          SELECT
              valor
          FROM
              administracao.configuracao
          where
              parametro = 'numero'
              and cod_modulo = :codModuloAdministracao
              AND exercicio = :exercicio
      ) as prefeitura_logr_nr
      , (
          SELECT
              valor
          FROM
              administracao.configuracao
          where
              parametro = 'complemento'
              and cod_modulo = :codModuloAdministracao
              AND exercicio = :exercicio
      ) as prefeitura_complem
      , (
          SELECT
              valor
          FROM
              administracao.configuracao
          WHERE
              parametro = 'bairro'
              and cod_modulo = :codModuloAdministracao
              AND exercicio = :exercicio
      ) as prefeitura_bairro
      , (
          SELECT valor
          FROM administracao.configuracao
          where parametro = 'cep'
          and cod_modulo = :codModuloAdministracao
          AND exercicio = :exercicio
      ) as prefeitura_cep
      , (
          SELECT
              valor
          FROM
              administracao.configuracao
          WHERE
              parametro = 'cnpj'
              and cod_modulo = :codModuloAdministracao
              AND exercicio = :exercicio
      ) as prefeitura_cnpj
      , (
          SELECT
              nom_uf,
              sigla_uf
          FROM
              sw_uf
              INNER JOIN (
                  select
                      valor
                  from
                      administracao.configuracao
                  where  parametro = 'cod_uf'
                      and cod_modulo = :codModuloAdministracao
                      AND exercicio = :exercicio
              ) as uf_config
              ON uf_config.valor = sw_uf.cod_uf::varchar
      ) as prefeitura_uf
      , (
          SELECT
              nom_municipio
          FROM
              sw_municipio
              INNER JOIN (
                  select
                      valor,
                      exercicio
                  from
                      administracao.configuracao
                  where
                      parametro = 'cod_municipio'
                      and cod_modulo = :codModuloAdministracao
                      AND exercicio = :exercicio
              ) as mun_conf
              ON mun_conf.valor = sw_municipio.cod_municipio::varchar
              INNER JOIN (
                  select
                      valor,
                      exercicio
                  from
                      administracao.configuracao
                  where
                      parametro = 'cod_uf'
                      and cod_modulo = :codModuloAdministracao
                      AND exercicio = :exercicio
              ) as uf_config
              ON uf_config.valor = sw_municipio.cod_uf::varchar
              AND uf_config.exercicio = mun_conf.exercicio
      ) as prefeitura_municipio
      , (
          SELECT
              admc.valor,
              nom_cgm
          FROM
              administracao.configuracao as admc
              INNER JOIN sw_cgm as cgm
              ON cgm.numcgm::varchar = admc.valor
          WHERE
              cod_modulo = 14
              AND parametro = 'diretor_tributos'
              AND exercicio = :exercicio
      ) as diretor_tributos
     WHERE ela.exercicio = :exercicioLicenca
     AND ela.inscricao_economica = :inscricaoEconomica
     AND ela.cod_licenca = :codLicenca
     AND ativide_principal.principal = true";

        $pdo = $this->_em->getConnection();

        $sth = $pdo->prepare($query);
        $sth->bindValue('codModuloAdministracao', $this::COD_MODULO_ADMINISTRACAO);
        $sth->bindValue('codModuloCadastroImobiliario', $this::COD_MODULO_CADASTRO_IMOBILIARIO);
        $sth->bindValue('exercicioLicenca', $params['exercicioLicenca']);
        $sth->bindValue('inscricaoEconomica', $params['inscricaoEconomica']);
        $sth->bindValue('codLicenca', $params['codLicenca']);
        $sth->bindValue('exercicio', $params['exercicio']);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array|null $params
    * @return array
    */
    public function fetchDadosAtividadesSecundarias(array $params = [])
    {
        if (empty($params['inscricaoEconomica'])) {
            return [];
        }

        $query = "
            SELECT
           ATV.COD_ATIVIDADE,
           ATV.NOM_ATIVIDADE,
           ATV.COD_ESTRUTURAL,
           ATE.PRINCIPAL,
           TO_CHAR ( ATE.DT_INICIO,'dd/mm/yyyy' )  AS DT_INICIO,
           TO_CHAR ( ATE.DT_TERMINO,'dd/mm/yyyy' ) AS DT_TERMINO,
           ATE.OCORRENCIA_ATIVIDADE
       FROM
            (
            SELECT
                ate.inscricao_economica, ate.cod_atividade,
                ate.principal, ate.dt_inicio,
                ate.dt_termino, ate.ocorrencia_atividade
            FROM
                economico.atividade_cadastro_economico AS ATE
             INNER JOIN (
                 SELECT
                     ate.inscricao_economica,
                     MAX(ocorrencia_atividade) as ocorrencia_atividade
                 FROM
                     ECONOMICO.ATIVIDADE_CADASTRO_ECONOMICO AS ATE
                 GROUP BY inscricao_economica
             ) as ATE2
             ON ATE2.inscricao_economica = ATE.inscricao_economica
             and ATE2.ocorrencia_atividade = ATE.ocorrencia_atividade
              ) as ATE
             INNER JOIN economico.atividade AS ATV
             ON ATV.COD_ATIVIDADE = ATE.COD_ATIVIDADE
       WHERE
           ATV.COD_ATIVIDADE = ATE.COD_ATIVIDADE
     AND ATE.INSCRICAO_ECONOMICA = :inscricaoEconomica
     AND ATE.PRINCIPAL = false";

        $pdo = $this->_em->getConnection();

        $sth = $pdo->prepare($query);
        $sth->bindValue('inscricaoEconomica', $params['inscricaoEconomica']);
        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array|null $params
    * @return array
    */
    public function fetchDadosSanit(array $params = [])
    {
        if (empty($params['exercicio'])) {
            return [];
        }

        $query = "
            SELECT
                      (
                          SELECT
                              valor
                          FROM
                              administracao.configuracao
                          WHERE
                              configuracao.cod_modulo = :codModulo
                              AND configuracao.parametro = 'sanit_secretaria'
                              AND configuracao.exercicio = :exercicio
                      )AS sanit_secretaria,
                      (
                          SELECT
                              valor
                          FROM
                              administracao.configuracao
                          WHERE
                              configuracao.cod_modulo = :codModulo
                              AND configuracao.parametro = 'sanit_departamento'
                              AND configuracao.exercicio = :exercicio
                      )AS sanit_departamento";

        $pdo = $this->_em->getConnection();

        $sth = $pdo->prepare($query);
        $sth->bindValue('codModulo', $this::COD_MODULO_CADASTRO_ECONOMICO);
        $sth->bindValue('exercicio', $params['exercicio']);
        $sth->execute();

        return $sth->fetchAll();
    }
}
