<?php

namespace Urbem\CoreBundle\Repository\Administracao;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;

class AtributoDinamicoRepository extends ORM\EntityRepository
{
    public function getAtributosDinamicosPorModuloeCadastroeContrato($info)
    {
        $sql = sprintf(
            "SELECT *
                FROM administracao.atributo_dinamico ad JOIN administracao.tipo_atributo ta ON (ad.cod_tipo = ta.cod_tipo)
                LEFT JOIN pessoal.atributo_contrato_servidor_valor acsv on (ad.cod_atributo = acsv.cod_atributo)
                LEFT JOIN administracao.modulo m ON (m.cod_modulo = acsv.cod_modulo)
                LEFT JOIN administracao.cadastro c ON (c.cod_cadastro = acsv.cod_cadastro)
                WHERE m.nom_modulo = '%s' AND c.nom_cadastro = '%s'
                AND ad.ativo = true
                order by timestamp desc
                limit (select count(distinct(cod_atributo)) from pessoal.atributo_contrato_servidor_valor where cod_contrato = %d)",
            $info['cod_modulo'],
            $info['cod_cadastro'],
            $info['cod_contrato']
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll();
    }

    public function getAtributosDinamicosPorModuloeCadastro($info)
    {
        $sql = sprintf(
            "SELECT *
             FROM administracao.atributo_dinamico ad
             JOIN administracao.tipo_atributo ta ON (ad.cod_tipo = ta.cod_tipo)
             LEFT JOIN administracao.modulo m ON (m.cod_modulo = ad.cod_modulo)
             LEFT JOIN administracao.cadastro c ON (c.cod_cadastro = ad.cod_cadastro)
             WHERE m.nom_modulo = '%s' AND c.nom_cadastro = '%s'",
            $info['cod_modulo'],
            $info['cod_cadastro']
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function getAtributosDinamicosPreEmpenho($codPreEmpenho, $exercicio)
    {
        $sql = sprintf(
            "select
                AD.cod_cadastro,
                AD.cod_atributo,
                AD.ativo,
                AD.nao_nulo,
                AD.nom_atributo,
                case
                    TA.cod_tipo
                    when 4 then administracao.valor_padrao(
                        AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro,
                        VALOR.valor
                    )
                    else administracao.valor_padrao(
                        AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro,
                        ''
                    )
                end as valor_padrao,
                case
                    TA.cod_tipo
                    when 3 then administracao.valor_padrao_desc(
                        AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro,
                        administracao.valor_padrao(
                            AD.cod_atributo,
                            AD.cod_modulo,
                            AD.cod_cadastro,
                            ''
                        )
                    )
                    when 4 then administracao.valor_padrao_desc(
                        AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro,
                        administracao.valor_padrao(
                            AD.cod_atributo,
                            AD.cod_modulo,
                            AD.cod_cadastro,
                            VALOR.valor
                        )
                    )
                    else null
                end as valor_padrao_desc,
                case
                    TA.cod_tipo
                    when 4 then administracao.valor_padrao_desc(
                        AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro,
                        VALOR.valor
                    )
                    else null
                end as valor_desc,
                AD.ajuda,
                AD.mascara,
                TA.cod_tipo,
                TA.nom_tipo,
                VALOR.valor,
                VALOR.timestamp
            from
                administracao.atributo_dinamico as AD,
                administracao.tipo_atributo as TA,
                administracao.atributo_dinamico as ACA left join empenho.atributo_empenho_valor as VALOR on
                (
                    ACA.cod_atributo = VALOR.cod_atributo
                    and ACA.cod_cadastro = VALOR.cod_cadastro
                    and cast(
                        VALOR.timestamp as VARCHAR
                    )|| cast(
                        VALOR.cod_atributo as varchar
                    ) in(
                        select
                            (
                                cast(
                                    max( VALOR.timestamp ) as varchar
                                )
                            )::varchar || cast(
                                VALOR.cod_atributo as varchar
                            )
                        from
                            administracao.atributo_dinamico as ACA,
                            empenho.atributo_empenho_valor as VALOR,
                            administracao.atributo_dinamico as AD,
                            administracao.tipo_atributo as TA
                        where
                            ACA.cod_atributo = AD.cod_atributo
                            and ACA.cod_cadastro = AD.cod_cadastro
                            and ACA.cod_modulo = AD.cod_modulo
                            and ACA.cod_atributo = VALOR.cod_atributo
                            and ACA.cod_cadastro = VALOR.cod_cadastro
                            and ACA.cod_modulo = VALOR.cod_modulo
                            and AD.cod_tipo = TA.cod_tipo
                            and ACA.ativo = true
                            and AD.cod_modulo = 10
                            and AD.cod_cadastro = 1
                            and VALOR.cod_pre_empenho = %d
                            and VALOR.exercicio = '%s'
                        group by
                            VALOR.cod_cadastro,
                            VALOR.cod_atributo,
                            VALOR.cod_pre_empenho,
                            VALOR.exercicio
                    )
                    and VALOR.cod_pre_empenho = %d
                    and VALOR.exercicio = '%s'
                )
            where
                AD.cod_tipo = TA.cod_tipo
                and ACA.ativo = true
                and AD.ativo
                and AD.cod_atributo = ACA.cod_atributo
                and AD.cod_modulo = ACA.cod_modulo
                and AD.cod_cadastro = ACA.cod_cadastro
                and ACA.cod_cadastro = 1
                and ACA.cod_modulo = 10",
            $codPreEmpenho,
            $exercicio,
            $codPreEmpenho,
            $exercicio
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * Script do sistema legado para trazer atributos dinâmicos do modulo Pessoal
     * @param  array $params
     * @return array
     */
    public function getAtributosDinamicosPessoal($params)
    {
        $sql = "
        SELECT
            AD.cod_cadastro,
            AD.cod_atributo,
            AD.ativo,
            AD.nao_nulo,
            AD.nom_atributo,
            administracao.valor_padrao (AD.cod_atributo,
                AD.cod_modulo,
                AD.cod_cadastro, '') AS valor_padrao,
            CASE TA.cod_tipo
                WHEN 3 THEN administracao.valor_padrao_desc (AD.cod_atributo,
                    AD.cod_modulo,
                    AD.cod_cadastro,
                    administracao.valor_padrao (AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro, ''))
                WHEN 4 THEN administracao.valor_padrao_desc (AD.cod_atributo,
                    AD.cod_modulo,
                    AD.cod_cadastro,
                    administracao.valor_padrao (AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro, ''))
                ELSE NULL
            END AS valor_padrao_desc,
            CASE TA.cod_tipo
                WHEN 4 THEN administracao.valor_padrao_desc (AD.cod_atributo,
                    AD.cod_modulo,
                    AD.cod_cadastro, '')
                ELSE NULL
            END AS valor_desc,
            AD.ajuda,
            AD.mascara,
            TA.nom_tipo,
            TA.cod_tipo
        FROM
            administracao.atributo_dinamico AS ACA,
            administracao.atributo_dinamico AS AD,
            administracao.tipo_atributo AS TA
        WHERE
            ACA.cod_atributo = AD.cod_atributo
            AND ACA.cod_cadastro = AD.cod_cadastro
            AND ACA.cod_modulo = AD.cod_modulo
            AND ACA.ativo = TRUE
            AND TA.cod_tipo = AD.cod_tipo
            AND AD.ativo = TRUE
            AND AD.cod_modulo = :cod_modulo
            AND AD.cod_cadastro = :cod_cadastro
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute($params);

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $params
     * @return array
     */
    public function getAtributoDinamicoTrecho($params)
    {
        $sql = sprintf(
            "SELECT
                AD.cod_cadastro,
                AD.cod_atributo,
                AD.ativo,
                AD.nao_nulo,
                AD.nom_atributo,
                CASE
                    TA.cod_tipo
                    WHEN 4 THEN administracao.valor_padrao(
                        AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro,
                        VALOR.valor
                    )
                    ELSE administracao.valor_padrao(
                        AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro,
                        ''
                    )
                END AS valor_padrao,
                CASE
                    TA.cod_tipo
                    WHEN 3 THEN administracao.valor_padrao_desc(
                        AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro,
                        administracao.valor_padrao(
                            AD.cod_atributo,
                            AD.cod_modulo,
                            AD.cod_cadastro,
                            ''
                        )
                    )
                    WHEN 4 THEN administracao.valor_padrao_desc(
                        AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro,
                        administracao.valor_padrao(
                            AD.cod_atributo,
                            AD.cod_modulo,
                            AD.cod_cadastro,
                            VALOR.valor
                        )
                    )
                    ELSE null
                END AS valor_padrao_desc,
                CASE
                    TA.cod_tipo
                    WHEN 4 THEN administracao.valor_padrao_desc(
                        AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro,
                        VALOR.valor
                    )
                    ELSE null
                END AS valor_desc,
                AD.ajuda,
                AD.mascara,
                TA.cod_tipo,
                TA.nom_tipo,
                VALOR.valor,
                VALOR.timestamp
            FROM
                administracao.atributo_dinamico AS AD,
                administracao.tipo_atributo AS TA,
                administracao.atributo_dinamico AS ACA LEFT JOIN imobiliario.atributo_trecho_valor AS VALOR ON
                (
                    ACA.cod_atributo = VALOR.cod_atributo
                    AND ACA.cod_cadastro = VALOR.cod_cadastro
                    AND cast(
                        VALOR.timestamp AS VARCHAR
                    ) || cast(
                        VALOR.cod_atributo AS VARCHAR
                    ) IN (
                        SELECT
                            (
                                cast(
                                    max( VALOR.timestamp ) AS VARCHAR
                                )
                            )::VARCHAR || cast(
                                VALOR.cod_atributo AS VARCHAR
                            )
                        FROM
                            administracao.atributo_dinamico AS ACA,
                            imobiliario.atributo_trecho_valor AS VALOR,
                            administracao.atributo_dinamico AS AD,
                            administracao.tipo_atributo AS TA
                        WHERE
                            ACA.cod_atributo = AD.cod_atributo
                            AND ACA.cod_cadastro = AD.cod_cadastro
                            AND ACA.cod_modulo = AD.cod_modulo
                            AND ACA.cod_atributo = VALOR.cod_atributo
                            AND ACA.cod_cadastro = VALOR.cod_cadastro
                            AND ACA.cod_modulo = VALOR.cod_modulo
                            AND AD.cod_tipo = TA.cod_tipo
                            AND ACA.ativo = true
                            AND AD.cod_modulo = %d
                            AND AD.cod_cadastro = %d
                            AND VALOR.cod_trecho = %d
                            AND VALOR.cod_logradouro = %d
                        GROUP BY
                            VALOR.cod_cadastro,
                            VALOR.cod_atributo,
                            VALOR.cod_trecho,
                            VALOR.cod_logradouro
                    )
                    AND VALOR.cod_trecho = %d
                    AND VALOR.cod_logradouro = %d
                )
            WHERE
                AD.cod_tipo = TA.cod_tipo
                AND ACA.ativo = true
                AND AD.ativo
                AND AD.cod_atributo = ACA.cod_atributo
                AND AD.cod_modulo = ACA.cod_modulo
                AND AD.cod_cadastro = ACA.cod_cadastro
                AND ACA.cod_modulo = %d
                AND ACA.cod_cadastro = %d
        ",
            Modulo::MODULO_CADASTRO_IMOBILIARIO,
            Cadastro::CADASTRO_TRIBUTARIO_TRECHO,
            $params['cod_trecho'],
            $params['cod_logradouro'],
            $params['cod_trecho'],
            $params['cod_logradouro'],
            Modulo::MODULO_CADASTRO_IMOBILIARIO,
            Cadastro::CADASTRO_TRIBUTARIO_TRECHO
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $params
     * @return array
     */
    public function getAtributoDinamicoCadastroEconomico($params)
    {
        $sql = sprintf(
            "SELECT
                DISTINCT CASE
                    WHEN efv.cod_atributo IS NOT NULL THEN efv.cod_atributo
                    WHEN eav.cod_atributo IS NOT NULL THEN eav.cod_atributo
                    ELSE edv.cod_atributo
                END AS cod_atributo,
                ad.nom_atributo,
                CASE
                    WHEN efv.valor IS NOT NULL THEN ltrim( efv.valor, '0' )
                    WHEN eav.valor IS NOT NULL THEN ltrim( eav.valor, '0' )
                    ELSE ltrim( edv.valor, '0' )
                END AS valor
            FROM (
                SELECT
                    principal.cod_atributo,
                    principal.cod_cadastro,
                    principal.cod_modulo,
                    max( principal.timestamp ) AS timestamp
                FROM
                    (
                        SELECT
                            DISTINCT CASE
                                WHEN efv.cod_atributo IS NOT NULL THEN efv.cod_atributo
                                WHEN eav.cod_atributo IS NOT NULL THEN eav.cod_atributo
                                ELSE edv.cod_atributo
                            END AS cod_atributo,
                            CASE
                                WHEN efv.cod_cadastro IS NOT NULL THEN efv.cod_cadastro
                                WHEN eav.cod_cadastro IS NOT NULL THEN eav.cod_cadastro
                                ELSE edv.cod_cadastro
                            END AS cod_cadastro,
                            CASE
                                WHEN efv.cod_modulo IS NOT NULL THEN efv.cod_modulo
                                WHEN eav.cod_modulo IS NOT NULL THEN eav.cod_modulo
                                ELSE edv.cod_modulo
                            end AS cod_modulo,
                            case
                                WHEN efv.timestamp IS NOT NULL THEN efv.timestamp
                                WHEN eav.timestamp IS NOT NULL THEN eav.timestamp
                                ELSE edv.timestamp
                            END AS timestamp
                        FROM
                            administracao.atributo_dinamico as ad LEFT JOIN economico.atributo_empresa_fato_valor AS efv ON
                                efv.cod_atributo = ad.cod_atributo AND efv.cod_cadastro = ad.cod_cadastro AND efv.cod_modulo = ad.cod_modulo
                            LEFT JOIN economico.atributo_cad_econ_autonomo_valor AS eav ON eav.cod_atributo = ad.cod_atributo
                                AND eav.cod_cadastro = ad.cod_cadastro
                                AND eav.cod_modulo = ad.cod_modulo
                            LEFT JOIN economico.atributo_empresa_direito_valor AS edv ON
                                edv.cod_atributo = ad.cod_atributo
                                AND edv.cod_cadastro = ad.cod_cadastro
                                AND edv.cod_modulo = ad.cod_modulo
                        WHERE
                            ad.ativo = true
                            AND efv.inscricao_economica = %d
                            OR eav.inscricao_economica = %d
                            OR edv.inscricao_economica = %d
                        ORDER BY
                            CASE
                                WHEN efv.cod_atributo IS NOT NULL THEN efv.cod_atributo
                                WHEN eav.cod_atributo IS NOT NULL THEN eav.cod_atributo
                                else edv.cod_atributo
                            end
                    ) AS principal
                group by
                    1,
                    2,
                    3
            ) AS consulta LEFT JOIN administracao.atributo_dinamico AS ad ON
                ad.cod_atributo = consulta.cod_atributo
                AND ad.cod_cadastro = consulta.cod_cadastro
                AND ad.cod_modulo = consulta.cod_modulo
            LEFT JOIN economico.atributo_empresa_fato_valor AS efv ON
                efv.cod_atributo = consulta.cod_atributo
                AND efv.cod_cadastro = consulta.cod_cadastro
                AND efv.cod_modulo = consulta.cod_modulo
                AND efv.timestamp = consulta.timestamp
            LEFT JOIN economico.atributo_cad_econ_autonomo_valor AS eav ON
                eav.cod_atributo = consulta.cod_atributo
                AND eav.cod_cadastro = consulta.cod_cadastro
                AND eav.cod_modulo = consulta.cod_modulo
                AND eav.timestamp = consulta.timestamp
            LEFT JOIN economico.atributo_empresa_direito_valor AS edv ON
                edv.cod_atributo = consulta.cod_atributo
                AND edv.cod_cadastro = consulta.cod_cadastro
                AND edv.cod_modulo = consulta.cod_modulo
                AND edv.timestamp = consulta.timestamp
        WHERE
            ad.ativo = true
            AND efv.inscricao_economica = %d
            OR eav.inscricao_economica = %d
            OR edv.inscricao_economica = %d
        ORDER BY
            CASE
                WHEN efv.cod_atributo IS NOT NULL THEN efv.cod_atributo
                WHEN eav.cod_atributo IS NOT NULL THEN eav.cod_atributo
                ELSE edv.cod_atributo
            END
        ",
            $params['inscricao_economica'],
            $params['inscricao_economica'],
            $params['inscricao_economica'],
            $params['inscricao_economica'],
            $params['inscricao_economica'],
            $params['inscricao_economica']
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getValorAtributoDinamicoPorTabela(array $params)
    {

        $codCadastro = $params['codCadastro'];
        $codModulo = $params['codModulo'];
        $tabelaAtributo = $params['tabelaAtributo'];
        $campoAtributo = $params['campoAtributo'];
        $codAtributo = $params['codAtributo'];

        $sql = "
            SELECT
                AD.cod_cadastro,
                AD.cod_atributo,
                AD.ativo,
                AD.nao_nulo,
                AD.nom_atributo,
                CASE
                    TA.cod_tipo
                    WHEN 4 THEN administracao.valor_padrao(
                        AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro,
                        VALOR.valor
                    )
                    ELSE administracao.valor_padrao(
                        AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro,
                        ''
                    )
                END AS valor_padrao,
                CASE
                    TA.cod_tipo
                    WHEN 3 THEN administracao.valor_padrao_desc(
                        AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro,
                        administracao.valor_padrao(
                            AD.cod_atributo,
                            AD.cod_modulo,
                            AD.cod_cadastro,
                            ''
                        )
                    )
                    WHEN 4 THEN administracao.valor_padrao_desc(
                        AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro,
                        administracao.valor_padrao(
                            AD.cod_atributo,
                            AD.cod_modulo,
                            AD.cod_cadastro,
                            VALOR.valor
                        )
                    )
                    ELSE null
                END AS valor_padrao_desc,
                CASE
                    TA.cod_tipo
                    WHEN 4 THEN administracao.valor_padrao_desc(
                        AD.cod_atributo,
                        AD.cod_modulo,
                        AD.cod_cadastro,
                        VALOR.valor
                    )
                    ELSE null
                END AS valor_desc,
                AD.ajuda,
                AD.mascara,
                TA.cod_tipo,
                TA.nom_tipo,
                VALOR.valor,
                VALOR.timestamp
            FROM
                administracao.atributo_dinamico AS AD,
                administracao.tipo_atributo AS TA,
                administracao.atributo_dinamico AS ACA LEFT JOIN imobiliario.atributo_trecho_valor AS VALOR ON
                (
                    ACA.cod_atributo = VALOR.cod_atributo
                    AND ACA.cod_cadastro = VALOR.cod_cadastro
                    AND cast(
                        VALOR.timestamp AS VARCHAR
                    ) || cast(
                        VALOR.cod_atributo AS VARCHAR
                    ) IN (
                        SELECT
                            (
                                cast(
                                    max( VALOR.timestamp ) AS VARCHAR
                                )
                            )::VARCHAR || cast(
                                VALOR.cod_atributo AS VARCHAR
                            )
                     FROM
                        administracao.atributo_dinamico AS ACA,
                        imobiliario.".$tabelaAtributo."          AS VALOR,
                        administracao.atributo_dinamico          AS AD,
                        administracao.tipo_atributo              AS TA
                     WHERE
                        ACA.cod_atributo = AD.cod_atributo
                        AND ACA.cod_cadastro = AD.cod_cadastro
                        AND ACA.cod_modulo   = AD.cod_modulo
                        AND ACA.cod_atributo = VALOR.cod_atributo
                        AND ACA.cod_cadastro = VALOR.cod_cadastro
                        AND ACA.cod_modulo   = VALOR.cod_modulo
                        AND AD.cod_tipo = TA.cod_tipo
                        AND ACA.ativo = true
                       AND AD.cod_modulo   = ".$codModulo."
                       AND AD.cod_cadastro= ".$codCadastro."
                       AND VALOR.".$campoAtributo." = ".$codAtributo."
                      GROUP BY VALOR.cod_cadastro, VALOR.cod_atributo, VALOR.".$campoAtributo."
                                          )
             )
          WHERE
              AD.cod_tipo = TA.cod_tipo
          AND ACA.ativo = true
          AND     AD.ativo
          AND AD.cod_atributo =  ACA.cod_atributo
          AND AD.cod_modulo   = ACA.cod_modulo
          AND AD.cod_cadastro = ACA.cod_cadastro
          AND ACA.cod_cadastro= ".$codCadastro."
          AND ACA.cod_modulo  = ".$codModulo."
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param int $codModulo
     * @param int $codCadastro
     * @return array
     */
    public function getAlteracaoCadastralAtributos($codModulo, $codCadastro)
    {
        $sql = '
            SELECT
         AD.cod_cadastro,
         AD.cod_atributo,
         AD.ativo,
         AD.nao_nulo,
         AD.nom_atributo,
         administracao.valor_padrao(AD.cod_atributo,AD.cod_modulo, AD.cod_cadastro, \'\') as valor_padrao,
         CASE TA.cod_tipo
           WHEN 3 THEN  administracao.valor_padrao_desc(AD.cod_atributo,AD.cod_modulo, AD.cod_cadastro,administracao.valor_padrao(AD.cod_atributo,AD.cod_modulo, AD.cod_cadastro,\'\'))
           WHEN 4 THEN  administracao.valor_padrao_desc(AD.cod_atributo,AD.cod_modulo, AD.cod_cadastro,administracao.valor_padrao(AD.cod_atributo,AD.cod_modulo, AD.cod_cadastro,\'\'))
             ELSE         null
         END AS valor_padrao_desc,
         CASE TA.cod_tipo WHEN
             4 THEN  administracao.valor_padrao_desc(AD.cod_atributo,AD.cod_modulo, AD.cod_cadastro,\'\')
             ELSE         null
         END AS valor_desc,
         AD.ajuda,
         AD.mascara,
         TA.nom_tipo,
             TA.cod_tipo
          FROM
        administracao.atributo_dinamico          AS ACA,
             administracao.atributo_dinamico             AS AD,
             administracao.tipo_atributo                 AS TA
          WHERE
         ACA.cod_atributo = AD.cod_atributo AND
         ACA.cod_cadastro = AD.cod_cadastro AND
         ACA.cod_modulo   = AD.cod_modulo AND
         ACA.ativo        = true AND
              TA.cod_tipo = AD.cod_tipo
          AND AD.ativo = true
          AND AD.cod_modulo   = ' .$codModulo. '
          AND AD.cod_cadastro = '.$codCadastro.'
        ';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param int $inscricaoMunicipal
     * @param int $codModulo
     * @param int $codCadastro
     * @return array
     */
    public function getAtributosByImovel($inscricaoMunicipal, $codModulo, $codCadastro)
    {
        $sql = "
            SELECT
        ACA.cod_modulo::text || '~' || ACA.cod_cadastro::text || '~' || ACA.cod_atributo::text AS id,
         ACA.cod_cadastro,
         ACA.cod_atributo,
         ACA.ativo,
         AD.nao_nulo,
         AD.nom_atributo,
         CASE TA.cod_tipo
             WHEN 4 THEN  administracao.valor_padrao(AD.cod_atributo,AD.cod_modulo,AD.cod_cadastro ,VALOR.valor)
             ELSE         administracao.valor_padrao(AD.cod_atributo,AD.cod_modulo,AD.cod_cadastro ,'')
         END AS valor_padrao,
         CASE TA.cod_tipo
           WHEN 3 THEN  administracao.valor_padrao_desc(AD.cod_atributo,AD.cod_modulo,AD.cod_cadastro ,administracao.valor_padrao(AD.cod_atributo,AD.cod_modulo,AD.cod_cadastro,''))
           WHEN 4 THEN  administracao.valor_padrao_desc(AD.cod_atributo,AD.cod_modulo,AD.cod_cadastro ,administracao.valor_padrao(AD.cod_atributo,AD.cod_modulo,AD.cod_cadastro,VALOR.valor))
             ELSE         null
         END AS valor_padrao_desc,
         CASE TA.cod_tipo WHEN
             4 THEN  administracao.valor_padrao_desc(AD.cod_atributo,AD.cod_modulo,AD.cod_cadastro ,administracao.valor_padrao(AD.cod_atributo,AD.cod_modulo,AD.cod_cadastro,VALOR.valor))
             ELSE         null
         END AS valor_desc,
         AD.ajuda,
         AD.mascara,
         TA.cod_tipo,
         TA.nom_tipo,
         VALOR.valor,
         VALOR.timestamp
          FROM
             administracao.atributo_dinamico          AS AD,
             administracao.tipo_atributo              AS TA,
             administracao.atributo_dinamico AS ACA
             LEFT OUTER JOIN
             imobiliario.atributo_imovel_valor         AS VALOR
          ON ( ACA.cod_atributo = VALOR.cod_atributo
                  AND ACA.cod_cadastro = VALOR.cod_cadastro

                AND CAST(VALOR.timestamp as varchar)||CAST(VALOR.cod_atributo as varchar) IN (
                     SELECT
                (CAST(VALOR.timestamp as varchar))||CAST(VALOR.cod_atributo as varchar)
                     FROM
                        administracao.atributo_dinamico AS ACA,
                        imobiliario.atributo_imovel_valor         AS VALOR,
                        administracao.atributo_dinamico          AS AD,
                        administracao.tipo_atributo              AS TA
                     WHERE
                        ACA.cod_atributo = AD.cod_atributo
                     AND ACA.cod_atributo = VALOR.cod_atributo
                     AND ACA.cod_cadastro = VALOR.cod_cadastro

                     AND AD.cod_tipo = TA.cod_tipo
                     AND ACA.ativo = true
                     AND AD.cod_modulo   = " .$codModulo. "
                     AND ACA.cod_cadastro= " .$codCadastro. "
                      AND VALOR.inscricao_municipal =    :inscricaoMunicipal
         GROUP BY VALOR.cod_cadastro, VALOR.timestamp ,VALOR.cod_atributo  ,VALOR.inscricao_municipal
                                          )
                      AND VALOR.inscricao_municipal = :inscricaoMunicipal
             )
          WHERE
             ACA.cod_atributo = AD.cod_atributo
          AND AD.cod_tipo = TA.cod_tipo
          AND ACA.ativo = true
          AND ACA.cod_modulo = AD.cod_modulo
          AND ACA.cod_cadastro = AD.cod_cadastro
          AND AD.cod_modulo   = " .$codModulo. "
          AND ACA.cod_cadastro= " .$codCadastro. "
        ORDER BY valor.inscricao_municipal,valor.cod_cadastro,valor.timestamp,valor.cod_atributo;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':inscricaoMunicipal', $inscricaoMunicipal, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_UNIQUE);
    }

    /**
     * @param $codLote
     * @param $codModulo
     * @param $codCadastro
     * @return array
     */
    public function getAtributosByLote($codLote, $codModulo, $codCadastro)
    {
        $sql = "
        SELECT
            AD.cod_cadastro,
            AD.cod_atributo,
            AD.ativo,
            AD.nao_nulo,
            AD.nom_atributo,
            CASE TA.cod_tipo
                WHEN 4 THEN  administracao.valor_padrao(AD.cod_atributo,AD.cod_modulo,AD.cod_cadastro ,VALOR.valor)
                ELSE         administracao.valor_padrao(AD.cod_atributo,AD.cod_modulo,AD.cod_cadastro ,'')
            END AS valor_padrao,
            CASE TA.cod_tipo
                WHEN 3 THEN  administracao.valor_padrao_desc(AD.cod_atributo,AD.cod_modulo,AD.cod_cadastro ,administracao.valor_padrao(AD.cod_atributo,AD.cod_modulo,AD.cod_cadastro,''))
                WHEN 4 THEN  administracao.valor_padrao_desc(AD.cod_atributo,AD.cod_modulo,AD.cod_cadastro ,administracao.valor_padrao(AD.cod_atributo,AD.cod_modulo,AD.cod_cadastro,VALOR.valor))
                ELSE         null
                END AS valor_padrao_desc,
                CASE TA.cod_tipo
                    WHEN 4 THEN  administracao.valor_padrao_desc(AD.cod_atributo,AD.cod_modulo,AD.cod_cadastro ,VALOR.valor)
                    ELSE         null
                END AS valor_desc,
                AD.ajuda,
                AD.mascara,
                TA.cod_tipo,
                TA.nom_tipo,
                VALOR.valor,
                VALOR.timestamp
        FROM
            administracao.atributo_dinamico          AS AD,
            administracao.tipo_atributo              AS TA,
            administracao.atributo_dinamico AS ACA
        LEFT JOIN
            imobiliario.atributo_lote_urbano_valor   AS VALOR
            ON ( ACA.cod_atributo = VALOR.cod_atributo AND ACA.cod_cadastro = VALOR.cod_cadastro
            AND CAST(VALOR.timestamp as varchar)||CAST(VALOR.cod_atributo as varchar) IN (
                SELECT
                    (CAST(max(VALOR.timestamp) as varchar))::varchar||CAST(VALOR.cod_atributo as varchar)
                FROM
                    administracao.atributo_dinamico AS ACA,
                    imobiliario.atributo_lote_urbano_valor   AS VALOR,
                    administracao.atributo_dinamico          AS AD,
                    administracao.tipo_atributo              AS TA
                WHERE
                    ACA.cod_atributo = AD.cod_atributo
                    AND ACA.cod_cadastro = AD.cod_cadastro
                    AND ACA.cod_modulo   = AD.cod_modulo
                    AND ACA.cod_atributo = VALOR.cod_atributo
                    AND ACA.cod_cadastro = VALOR.cod_cadastro
                    AND ACA.cod_modulo   = VALOR.cod_modulo
                              
                    AND AD.cod_tipo = TA.cod_tipo
                    AND ACA.ativo = true
                    AND AD.cod_modulo = :codModulo
                    AND AD.cod_cadastro = :codCadastro
                    AND VALOR.cod_lote = :codLote
                GROUP BY VALOR.cod_cadastro, VALOR.cod_atributo, VALOR.cod_lote
            )
                AND VALOR.cod_lote = :codLote
	    	)
	    WHERE
        	AD.cod_tipo = TA.cod_tipo
            AND ACA.ativo = true
            AND AD.ativo
            AND AD.cod_atributo  =  ACA.cod_atributo
            AND AD.cod_modulo    = ACA.cod_modulo
            AND AD.cod_cadastro  = ACA.cod_cadastro
            AND ACA.cod_cadastro = :codCadastro
            AND ACA.cod_modulo   = :codModulo
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':codLote', $codLote, \PDO::PARAM_INT);
        $query->bindValue(':codCadastro', $codCadastro, \PDO::PARAM_STR);
        $query->bindValue(':codModulo', $codModulo, \PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_UNIQUE);
    }

    /**
     * @param array $params
     * @return array
     */
    public function getValorAtributoDinamicoPorTabelaComCodigo(array $params)
    {

        $codCadastro = $params['codCadastro'];
        $codModulo = $params['codModulo'];
        $tabelaAtributo = $params['tabelaAtributo'];
        $campoAtributo = $params['campoAtributo'];
        $codAtributo = $params['codAtributo'];

        $sql = "select
                    AD.cod_cadastro,
                    AD.cod_atributo,
                    AD.ativo,
                    AD.nao_nulo,
                    AD.nom_atributo,
                    case
                        TA.cod_tipo
                        when 4 then administracao.valor_padrao(
                            AD.cod_atributo,
                            AD.cod_modulo,
                            AD.cod_cadastro,
                            VALOR.valor
                        )
                        else administracao.valor_padrao(
                            AD.cod_atributo,
                            AD.cod_modulo,
                            AD.cod_cadastro,
                            ''
                        )
                    end as valor_padrao,
                    case
                        TA.cod_tipo
                        when 3 then administracao.valor_padrao_desc(
                            AD.cod_atributo,
                            AD.cod_modulo,
                            AD.cod_cadastro,
                            administracao.valor_padrao(
                                AD.cod_atributo,
                                AD.cod_modulo,
                                AD.cod_cadastro,
                                ''
                            )
                        )
                        when 4 then administracao.valor_padrao_desc(
                            AD.cod_atributo,
                            AD.cod_modulo,
                            AD.cod_cadastro,
                            administracao.valor_padrao(
                                AD.cod_atributo,
                                AD.cod_modulo,
                                AD.cod_cadastro,
                                VALOR.valor
                            )
                        )
                        else null
                    end as valor_padrao_desc,
                    case
                        TA.cod_tipo
                        when 4 then administracao.valor_padrao_desc(
                            AD.cod_atributo,
                            AD.cod_modulo,
                            AD.cod_cadastro,
                            VALOR.valor
                        )
                        else null
                    end as valor_desc,
                    AD.ajuda,
                    AD.mascara,
                    TA.cod_tipo,
                    TA.nom_tipo,
                    VALOR.valor,
                    VALOR.timestamp
                from
                    administracao.atributo_dinamico as AD,
                    administracao.tipo_atributo as TA,
                    administracao.atributo_dinamico as ACA left join ".$tabelaAtributo." as VALOR on
                    (
                        ACA.cod_atributo = VALOR.cod_atributo
                        and ACA.cod_cadastro = VALOR.cod_cadastro
                        and cast(
                            VALOR.timestamp as varchar
                        )|| cast(
                            VALOR.cod_atributo as varchar
                        ) in(
                            select
                                (
                                    cast(
                                        max( VALOR.timestamp ) as varchar
                                    )
                                )::varchar || cast(
                                    VALOR.cod_atributo as varchar
                                )
                            from
                                administracao.atributo_dinamico as ACA,
                                ".$tabelaAtributo." as VALOR,
                                administracao.atributo_dinamico as AD,
                                administracao.tipo_atributo as TA
                            where
                                ACA.cod_atributo = AD.cod_atributo
                                and ACA.cod_cadastro = AD.cod_cadastro
                                and ACA.cod_modulo = AD.cod_modulo
                                and ACA.cod_atributo = VALOR.cod_atributo
                                and ACA.cod_cadastro = VALOR.cod_cadastro
                                and ACA.cod_modulo = VALOR.cod_modulo
                                and AD.cod_tipo = TA.cod_tipo
                                and ACA.ativo = true
                                AND ACA.cod_cadastro= ".$codCadastro."
                                AND ACA.cod_modulo  = ".$codModulo."
                                and ".$campoAtributo."= ".$codAtributo."
                            group by
                                VALOR.cod_cadastro,
                                VALOR.cod_atributo,
                                VALOR.cod_contrato
                        )
                        and VALOR.".$campoAtributo." = ".$codAtributo."
                    )
                where
                    AD.cod_tipo = TA.cod_tipo
                    and ACA.ativo = true
                    and AD.ativo
                    and AD.cod_atributo = ACA.cod_atributo
                    and AD.cod_modulo = ACA.cod_modulo
                    and AD.cod_cadastro = ACA.cod_cadastro
                    AND ACA.cod_cadastro= ".$codCadastro."
                    AND ACA.cod_modulo  = ".$codModulo."
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
