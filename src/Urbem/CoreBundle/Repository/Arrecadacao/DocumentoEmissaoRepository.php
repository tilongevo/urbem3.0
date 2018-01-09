<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use Urbem\CoreBundle\Entity\Arrecadacao\DocumentoEmissao;
use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class DocumentoEmissaoRepository
 * @package Urbem\CoreBundle\Repository\Arrecadacao
 */
class DocumentoEmissaoRepository extends AbstractRepository
{

    /**
     * @param $params
     * @return int
     */
    public function getNextVal($params)
    {
        return $this->nextVal(
            "num_documento",
            [
                'cod_documento' => $params['cod_documento'],
                'exercicio' => $params['exercicio']
            ]
        );
    }

    /**
     * @param $numDocumento
     * @param $exercicio
     * @return array
     */
    public function findDocumentoEmissao($filtro)
    {
        $where = 'Where ';
        if (array_key_exists('numDocumento', $filtro) && !is_null($filtro['numDocumento'])) {
            $where .= sprintf('documento_emissao.num_documento = %d ~ ', $filtro['numDocumento']);
        }

        if (array_key_exists('exercicio', $filtro) && !is_null($filtro['exercicio'])) {
            $where .= sprintf('documento_emissao.exercicio = \'%s\' ~ ', $filtro['exercicio']);
        }

        if ($where == 'Where ') {
            $where = '';
        } else {
            $where = str_replace("~", "AND", $where);
            $where = substr($where, 0, -4);
        }

        $sql =
            '
              SELECT DISTINCT
	                        (
	                            SELECT
	                                sw_cgm_pessoa_fisica.cpf
	                            FROM
	                                sw_cgm_pessoa_fisica
	                            WHERE
	                                sw_cgm_pessoa_fisica.numcgm = COALESCE( prop_imovel.numcgm, eco.numcgm, documento_cgm.numcgm )
	                        )AS cpf,
	                        (
	                            SELECT
	                                sw_cgm_pessoa_juridica.cnpj
	                            FROM
	                                sw_cgm_pessoa_juridica
	                            WHERE
	                                sw_cgm_pessoa_juridica.numcgm = COALESCE( prop_imovel.numcgm, eco.numcgm, documento_cgm.numcgm )
	                        )AS cnpj,
	                        arrecadacao.fn_consulta_endereco_todos(
	                            COALESCE( prop_imovel.inscricao_municipal, eco.inscricao_economica, documento_cgm.numcgm ),
	                            CASE WHEN prop_imovel.inscricao_municipal is not null THEN
	                                1
	                            ELSE
	                                CASE WHEN eco.inscricao_economica IS NOT NULL THEN
	                                    2
	                                ELSE
	                                    3
	                                END
	                            END,
	                            1
	                        )AS endereco,
	                        arrecadacao.fn_consulta_endereco_todos(
	                            COALESCE( prop_imovel.inscricao_municipal, eco.inscricao_economica, documento_cgm.numcgm ),
	                            CASE WHEN prop_imovel.inscricao_municipal is not null THEN
	                                1
	                            ELSE
	                                CASE WHEN eco.inscricao_economica IS NOT NULL THEN
	                                    2
	                                ELSE
	                                    3
	                                END
	                            END,
	                            2
	                        )AS bairro,
	                        arrecadacao.fn_consulta_endereco_todos(
	                            COALESCE( prop_imovel.inscricao_municipal, eco.inscricao_economica, documento_cgm.numcgm ),
	                            CASE WHEN prop_imovel.inscricao_municipal is not null THEN
	                                1
	                            ELSE
	                                CASE WHEN eco.inscricao_economica IS NOT NULL THEN
	                                    2
	                                ELSE
	                                    3
	                                END
	                            END,
	                            3
	                        )AS cep,
	                        arrecadacao.fn_consulta_endereco_todos(
	                            COALESCE( prop_imovel.inscricao_municipal, eco.inscricao_economica, documento_cgm.numcgm ),
	                            CASE WHEN prop_imovel.inscricao_municipal is not null THEN
	                                1
	                            ELSE
	                                CASE WHEN eco.inscricao_economica IS NOT NULL THEN
	                                    2
	                                ELSE
	                                    3
	                                END
	                            END,
	                            4
	                        )AS municipio,
	                        COALESCE( documento_cgm.numcgm, prop_imovel.numcgm, eco.numcgm ) AS numcgm,
	                        (
	                            SELECT
	                                sw_cgm.nom_cgm
	                            FROM
	                                sw_cgm
	                            WHERE
	                                sw_cgm.numcgm = COALESCE( documento_cgm.numcgm, prop_imovel.numcgm, eco.numcgm )
	                        )AS contribuinte,
	                        documento_imovel.inscricao_municipal,
	                        documento_empresa.inscricao_economica,
	                        lpad(documento_emissao.num_documento::varchar,4,\'0\') as num_documento,
	                        documento_emissao.exercicio,
	                        documento.cod_documento,
	                        documento.cod_tipo_documento,
	                        documento.descricao,
	                        to_char( documento_emissao.timestamp, \'dd/mm/YYYY\' ) AS dt_emissao
	
	                    FROM
	                        arrecadacao.documento
	
	                    INNER JOIN
	                        arrecadacao.documento_emissao
	                    ON
	                        documento_emissao.cod_documento = documento.cod_documento
	
	                    LEFT JOIN
	                        arrecadacao.documento_imovel
	                    ON
	                        documento_imovel.num_documento = documento_emissao.num_documento
	                        AND documento_imovel.cod_documento = documento_emissao.cod_documento
	                        AND documento_imovel.exercicio = documento_emissao.exercicio
	
	                    LEFT JOIN
	                        arrecadacao.documento_empresa
	                    ON
	                        documento_empresa.num_documento = documento_emissao.num_documento
	                        AND documento_empresa.cod_documento = documento_emissao.cod_documento
	                        AND documento_empresa.exercicio = documento_emissao.exercicio
	
	                    LEFT JOIN
	                        arrecadacao.documento_cgm
	                    ON
	                        documento_cgm.num_documento = documento_emissao.num_documento
	                        AND documento_cgm.cod_documento = documento_emissao.cod_documento
	                        AND documento_cgm.exercicio = documento_emissao.exercicio
	
	
	                    LEFT JOIN
	                        (
	                            SELECT
	                                prop.*
	                            FROM
	                                imobiliario.proprietario AS prop
	
	                            INNER JOIN
	                                (
	                                    SELECT
	                                        inscricao_municipal,
	                                        MAX( timestamp) AS timestamp
	                                    FROM
	                                        imobiliario.proprietario
	                                    GROUP BY
	                                        inscricao_municipal
	                                )AS temp
	                            ON
	                                temp.inscricao_municipal = prop.inscricao_municipal
	                                AND temp.timestamp = prop.timestamp
	                        ) AS prop_imovel
	                    ON
	                        prop_imovel.inscricao_municipal = documento_imovel.inscricao_municipal
	
	                    LEFT JOIN
	                        (
	                            SELECT DISTINCT
	                                COALESCE( cadastro_economico_autonomo.numcgm, cadastro_economico_empresa_fato.numcgm, cadastro_economico_empresa_direito.numcgm ) AS numcgm,
	                                cadastro_economico.inscricao_economica
	
	                            FROM
	                                economico.cadastro_economico
	
	                            LEFT JOIN
	                                economico.cadastro_economico_autonomo
	                            ON
	                                cadastro_economico_autonomo.inscricao_economica = cadastro_economico.inscricao_economica
	
	                            LEFT JOIN
	                                economico.cadastro_economico_empresa_fato
	                            ON
	                                cadastro_economico_empresa_fato.inscricao_economica = cadastro_economico.inscricao_economica
	
	                            LEFT JOIN
	                                economico.cadastro_economico_empresa_direito
	                            ON
	                                cadastro_economico_empresa_direito.inscricao_economica = cadastro_economico.inscricao_economica
	                        ) AS eco
	                    ON
	                        eco.inscricao_economica = documento_empresa.inscricao_economica
	
	                    '.$where.'
	
	                    GROUP BY
	                        prop_imovel.numcgm,
	                        eco.numcgm,
	                        documento_cgm.numcgm,
	                        prop_imovel.inscricao_municipal,
	                        eco.inscricao_economica,
	                        documento_imovel.inscricao_municipal,
	                        documento_empresa.inscricao_economica,
	                        documento_emissao.num_documento,
	                        documento_emissao.exercicio,
	                        documento.cod_documento,
	                        documento.cod_tipo_documento,
	                        documento.descricao,
	                        documento_emissao.timestamp ;
	                        ';

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetch();
    }

    /**
     * @param $numDocumento
     * @param $exercicio
     * @return array
     */
    public function getDocumentosEmitidos($filtro)
    {
        $where = 'Where ';

        if (array_key_exists('numCgm', $filtro) && !is_null($filtro['numCgm']) && $filtro['numCgm'] != '') {
            $where .= sprintf('COALESCE( prop_imovel.numcgm, eco.numcgm, documento_cgm.numcgm ) = %d ~ ', $filtro['numCgm']);
        }

        if (array_key_exists('inscricaoMunicipal', $filtro) && !is_null($filtro['inscricaoMunicipal']) && $filtro['inscricaoMunicipal'] != '') {
            $where .= sprintf('documento_imovel.inscricao_municipal = %d ~ ', $filtro['inscricaoMunicipal']);
        }

        if (array_key_exists('inscricaoEconomica', $filtro) && !is_null($filtro['inscricaoEconomica']) && $filtro['inscricaoEconomica'] != '') {
            $where .= sprintf('documento_empresa.inscricao_economica = %d ~ ', $filtro['inscricaoEconomica']);
        }

        if ($where == 'Where ') {
            $where = '';
        } else {
            $where = str_replace("~", "AND", $where);
            $where = substr($where, 0, -4);
        }

        $sql =
            "
                select
                    distinct
                    coalesce(
                        prop_imovel.numcgm,
                        eco.numcgm,
                        documento_cgm.numcgm
                    ) as numcgm,
                    (
                        select
                            sw_cgm.nom_cgm
                        from
                            sw_cgm
                        where
                            sw_cgm.numcgm = coalesce(
                                prop_imovel.numcgm,
                                eco.numcgm,
                                documento_cgm.numcgm
                            )
                    ) as contribuinte,
                    documento_imovel.inscricao_municipal,
                    documento_empresa.inscricao_economica,
                    lpad(parcela_documento.num_documento::varchar,4,'0'::varchar) as num_documento,
                    parcela_documento.exercicio,
                    documento.cod_documento,
                    documento.cod_tipo_documento,
                    documento.descricao,
                    (
                        select
                            to_char(
                                documento_emissao.timestamp,
                                'dd/mm/YYYY'
                            )
                        from
                            arrecadacao.documento_emissao
                        where
                            documento_emissao.cod_documento = documento.cod_documento
                            and documento_emissao.num_documento = parcela_documento.num_documento
                            and documento_emissao.exercicio = parcela_documento.exercicio
                    ) as dt_emissao
                from
                    arrecadacao.parcela_documento left join(
                        select
                            count(*) as qtd,
                            parcela_documento.cod_documento,
                            parcela_documento.num_documento,
                            parcela_documento.exercicio
                        from
                            arrecadacao.parcela_documento
                        where
                            parcela_documento.cod_situacao = 2
                        group by
                            parcela_documento.cod_documento,
                            parcela_documento.num_documento,
                            parcela_documento.exercicio
                    ) as parcelas_vencidas on
                    parcelas_vencidas.cod_documento = parcela_documento.cod_documento
                    and parcelas_vencidas.num_documento = parcela_documento.num_documento
                    and parcelas_vencidas.exercicio = parcela_documento.exercicio left join(
                        select
                            count(*) as qtd,
                            parcela_documento.cod_documento,
                            parcela_documento.num_documento,
                            parcela_documento.exercicio
                        from
                            arrecadacao.parcela_documento
                        where
                            parcela_documento.cod_situacao = 1
                        group by
                            parcela_documento.cod_documento,
                            parcela_documento.num_documento,
                            parcela_documento.exercicio
                    ) as parcelas_abertas on
                    parcelas_abertas.cod_documento = parcela_documento.cod_documento
                    and parcelas_abertas.num_documento = parcela_documento.num_documento
                    and parcelas_abertas.exercicio = parcela_documento.exercicio inner join arrecadacao.documento on
                    documento.cod_documento = parcela_documento.cod_documento left join arrecadacao.documento_imovel on
                    documento_imovel.num_documento = parcela_documento.num_documento
                    and documento_imovel.cod_documento = parcela_documento.cod_documento
                    and documento_imovel.exercicio = parcela_documento.exercicio left join arrecadacao.documento_empresa on
                    documento_empresa.num_documento = parcela_documento.num_documento
                    and documento_empresa.cod_documento = parcela_documento.cod_documento
                    and documento_empresa.exercicio = parcela_documento.exercicio left join arrecadacao.documento_cgm on
                    documento_cgm.num_documento = parcela_documento.num_documento
                    and documento_cgm.cod_documento = parcela_documento.cod_documento
                    and documento_cgm.exercicio = parcela_documento.exercicio left join(
                        select
                            prop.*
                        from
                            imobiliario.proprietario as prop inner join(
                                select
                                    inscricao_municipal,
                                    max( timestamp ) as timestamp
                                from
                                    imobiliario.proprietario
                                group by
                                    inscricao_municipal
                            ) as temp on
                            temp.inscricao_municipal = prop.inscricao_municipal
                            and temp.timestamp = prop.timestamp
                    ) as prop_imovel on
                    prop_imovel.inscricao_municipal = documento_imovel.inscricao_municipal left join(
                        select
                            distinct coalesce(
                                cadastro_economico_autonomo.numcgm,
                                cadastro_economico_empresa_fato.numcgm,
                                cadastro_economico_empresa_direito.numcgm
                            ) as numcgm,
                            cadastro_economico.inscricao_economica
                        from
                            economico.cadastro_economico left join economico.cadastro_economico_autonomo on
                            cadastro_economico_autonomo.inscricao_economica = cadastro_economico.inscricao_economica left join economico.cadastro_economico_empresa_fato on
                            cadastro_economico_empresa_fato.inscricao_economica = cadastro_economico.inscricao_economica left join economico.cadastro_economico_empresa_direito on
                            cadastro_economico_empresa_direito.inscricao_economica = cadastro_economico.inscricao_economica
                    ) as eco on
                    eco.inscricao_economica = documento_empresa.inscricao_economica inner join arrecadacao.parcela on
                    parcela.cod_parcela = parcela_documento.cod_parcela
                ".$where."
                group by
                    prop_imovel.numcgm,
                    eco.numcgm,
                    documento_cgm.numcgm,
                    documento_imovel.inscricao_municipal,
                    documento_empresa.inscricao_economica,
                    parcela_documento.num_documento,
                    parcela_documento.exercicio,
                    documento.cod_documento,
                    documento.cod_tipo_documento,
                    documento.descricao";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }
}
