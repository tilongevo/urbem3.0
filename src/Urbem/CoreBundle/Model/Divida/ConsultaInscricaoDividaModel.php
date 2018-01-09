<?php

namespace Urbem\CoreBundle\Model\Divida;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Divida\DividaAtiva;

/**
 * Class ConsultaInscricaoDividaModel
 * @package Urbem\CoreBundle\Model\Divida
 */
class ConsultaInscricaoDividaModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository;

    /**
     * ConsultaInscricaoDividaModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(DividaAtiva::class);
    }

    /**
     * @param $filter
     * @return array
     */
    public function getListaInscricaoDivida($filter)
    {
        $sql = "SELECT
            busca.cod_inscricao,
            busca.exercicio,
            busca.exercicio_original,
            busca.dt_inscricao_divida,
            busca.num_parcelamento,
            busca.inscricao,
            busca.num_livro,
            busca.num_folha,
            busca.inscricao_municipal,
            busca.inscricao_economica,
            busca.nom_cgm_autoridade,
            busca.numcgm_autoridade,
            busca.numcgm_contribuinte,
            busca.nom_cgm_contribuinte,
            arrecadacao.fn_busca_origem_inscricao_divida_ativa ( busca.cod_inscricao, busca.exercicio::integer, 6 ) AS credito,
            busca.cod_processo,
            busca.ano_exercicio,
            busca.total_parcelas,
            busca.total_parcelas_unicas,
            busca.total_parcelas_canceladas,
            busca.total_parcelas_pagas,
            busca.total_parcelas_unicas_pagas,
            busca.inscricao_cancelada,
            busca.numcgm_cancelada,
            busca.usuario_cancelada,
            busca.data_cancelada,
            busca.inscricao_estornada
            , ( CASE WHEN inscricao_cancelada IS NOT NULL THEN
                    'Cancelada'
                WHEN inscricao_estornada IS NOT NULL THEN
                    'Estornada'
                WHEN inscricao_remida IS NOT NULL THEN
                    'Remida'
                WHEN ( total_parcelas = 0 ) OR (total_parcelas_canceladas > 0) THEN
                    'Sem cobrança'
                WHEN judicial = TRUE THEN
                    'Cobrança Judicial'
                WHEN (( total_parcelas_pagas >= total_parcelas ) OR (total_parcelas_unicas_pagas > 0) ) THEN
                    'Paga'
                ELSE
                    'Aberta'
                END
            ) AS situacao,
            ( CASE WHEN inscricao_cancelada IS NOT NULL THEN
                   motivo_cancelada
                WHEN inscricao_estornada IS NOT NULL THEN
                   motivo_estornada
                ELSE
                   null
                END
            ) as motivo,
            CASE WHEN ( total_parcelas = 0 ) OR (total_parcelas_canceladas > 0) THEN
                (
                    SELECT
                        (
                            SELECT
                                modalidade.descricao
                            FROM
                                divida.modalidade
                            WHERE
                                modalidade.cod_modalidade = parcelamento.cod_modalidade
                            ORDER BY
                                timestamp DESC
                            LIMIT 1
                        )

                    FROM
                        divida.divida_parcelamento

                    INNER JOIN
                        divida.parcelamento
                    ON
                        parcelamento.num_parcelamento = divida_parcelamento.num_parcelamento

                    WHERE
                        divida_parcelamento.cod_inscricao = busca.cod_inscricao
                        AND divida_parcelamento.exercicio = busca.exercicio

                    ORDER BY
                        divida_parcelamento.num_parcelamento ASC
                    LIMIT 1
                )
            ELSE
                busca.modalidade_descricao
            END AS modalidade_descricao,

            CASE WHEN ( total_parcelas = 0 ) OR (total_parcelas_canceladas > 0) THEN
                (
                    SELECT
                        parcelamento.cod_modalidade
                    FROM
                        divida.divida_parcelamento

                    INNER JOIN
                        divida.parcelamento
                    ON
                        parcelamento.num_parcelamento = divida_parcelamento.num_parcelamento

                    WHERE
                        divida_parcelamento.cod_inscricao = busca.cod_inscricao
                        AND divida_parcelamento.exercicio = busca.exercicio

                    ORDER BY
                        divida_parcelamento.num_parcelamento ASC
                    LIMIT 1
                )
            ELSE
                busca.cod_modalidade::integer
            END AS cod_modalidade
            , ( CASE WHEN ( total_parcelas = 0 ) OR (total_parcelas_canceladas > 0) THEN
                    '  ' --sem cobrança
                ELSE
                    (
                        SELECT
                            (dp2.numero_parcelamento ||'/'||dp2.exercicio)
                        from
                            divida.divida_parcelamento as ddp2
                            INNER JOIN divida.parcelamento as dp2
                            ON ddp2.num_parcelamento = dp2.num_parcelamento
                        WHERE
                            ddp2.exercicio = busca.exercicio
                            AND ddp2.cod_inscricao = busca.cod_inscricao
                        ORDER BY dp2.exercicio DESC, dp2.numero_parcelamento DESC
                        LIMIT 1
                    )
                END
            ) as max_cobranca,
            busca.remissao_norma,
            busca.remissao_cod_norma
            , to_char(( SELECT MIN(dt_vencimento_parcela) FROM divida.parcela WHERE num_parcelamento = busca.num_parcelamento ), 'dd/mm/yyyy') AS dt_vencimento_parcela

        FROM
            (
                SELECT DISTINCT
                    dda.*
                    , dmod.descricao as modalidade_descricao
                    , ddp.cod_modalidade
                    , ddproc.cod_processo
                    , ddproc.ano_exercicio
                    , ddp.judicial
                    , (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.num_parcelamento = dda.num_parcelamento
                            AND divida.parcela.num_parcela > 0
                    ) AS total_parcelas
                    ,(
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.num_parcelamento = dda.num_parcelamento
                            AND divida.parcela.num_parcela = 0
                    ) AS total_parcelas_unicas
                    , (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.cancelada = true
                            AND divida.parcela.paga = false
                            AND divida.parcela.num_parcelamento = dda.num_parcelamento
                    ) AS total_parcelas_canceladas
                    , (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.cancelada = false
                            AND divida.parcela.paga = true
                            AND divida.parcela.num_parcelamento = dda.num_parcelamento
                            AND divida.parcela.num_parcela > 0
                    ) AS total_parcelas_pagas
                    , (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.cancelada = false
                            AND divida.parcela.paga = true
                            AND divida.parcela.num_parcelamento = dda.num_parcelamento
                            AND divida.parcela.num_parcela = 0
                    ) AS total_parcelas_unicas_pagas
                    , ddcanc.cod_inscricao as inscricao_cancelada
                    , ddcanc.motivo as motivo_cancelada
                    , ddcanc.numcgm as numcgm_cancelada
                    , ( select nom_cgm from sw_cgm where numcgm = ddcanc.numcgm ) as usuario_cancelada
                    , ddcanc.timestamp as data_cancelada
                    , ddestorn.cod_inscricao as inscricao_estornada
                    , ddestorn.motivo as motivo_estornada
                    , ddrem.cod_inscricao as inscricao_remida
                    , (
                        SELECT
                            norma.nom_norma
                        FROM
                            normas.norma
                        WHERE
                            norma.cod_norma = ddrem.cod_norma
                    )AS remissao_norma,
                    ddrem.cod_norma AS remissao_cod_norma

                FROM

                    (
                        SELECT
                            dda.cod_inscricao
                            , dda.exercicio
                            , dda.exercicio_original
                            , dda.num_livro
                            , dda.num_folha
                            , to_char(dda.dt_inscricao, 'dd/mm/yyyy') AS dt_inscricao_divida
                            , max(num_parcelamento) as num_parcelamento

                            , COALESCE( ddi.inscricao_municipal, dde.inscricao_economica ) AS inscricao

                            , ddi.inscricao_municipal
                            , dde.inscricao_economica

                            , autoridade.nom_cgm as nom_cgm_autoridade
                            , autoridade.numcgm as numcgm_autoridade
                            , cgm.numcgm AS numcgm_contribuinte
                            , cgm.nom_cgm AS nom_cgm_contribuinte

                        FROM

                            divida.divida_ativa AS dda

                            INNER JOIN divida.divida_parcelamento AS dp
                            ON dp.cod_inscricao = dda.cod_inscricao
                            AND dp.exercicio = dda.exercicio

                            INNER JOIN (
                                SELECT
                                    dauto.cod_autoridade
                                    , cgm.numcgm
                                    , cgm.nom_cgm
                                FROM
                                    divida.autoridade as dauto
                                    INNER JOIN sw_cgm as cgm
                                    ON cgm.numcgm = dauto.numcgm

                            ) as autoridade
                            ON autoridade.cod_autoridade = dda.cod_autoridade

                            LEFT JOIN divida.divida_imovel AS ddi
                            ON ddi.cod_inscricao = dda.cod_inscricao
                            AND ddi.exercicio = dda.exercicio

                            LEFT JOIN divida.divida_empresa AS dde
                            ON dde.cod_inscricao = dda.cod_inscricao
                            AND dde.exercicio = dda.exercicio

                            INNER JOIN divida.divida_cgm AS ddc
                            ON ddc.cod_inscricao = dda.cod_inscricao
                            AND ddc.exercicio = dda.exercicio

                            INNER JOIN sw_cgm as cgm
                            ON cgm.numcgm = ddc.numcgm

                        GROUP BY
                            dda.cod_inscricao, dda.exercicio, dda.dt_inscricao
                            , ddi.inscricao_municipal, dde.inscricao_economica
                            , autoridade.nom_cgm, autoridade.numcgm, dda.exercicio_original
                            , cgm.numcgm, cgm.nom_cgm, dda.num_livro, dda.num_folha

                    ) AS dda

                    INNER JOIN  divida.parcelamento AS ddp
                    ON ddp.num_parcelamento = dda.num_parcelamento

                    INNER JOIN  (
                        SELECT
                            dmod.cod_modalidade
                            , dmod.descricao
                            , max(ultimo_timestamp) as timestamp
                        FROM
                            divida.modalidade as dmod
                        GROUP BY dmod.cod_modalidade, dmod.descricao
                    ) as dmod
                    ON dmod.cod_modalidade = ddp.cod_modalidade

                    LEFT JOIN divida.parcela AS ddpar
                    ON ddpar.num_parcelamento = dda.num_parcelamento

                    INNER JOIN divida.parcela_origem AS dpo
                    ON dpo.num_parcelamento = dda.num_parcelamento

                    INNER JOIN arrecadacao.parcela AS ap
                    ON ap.cod_parcela = dpo.cod_parcela

                    LEFT JOIN divida.divida_cancelada ddcanc
                    ON ddcanc.cod_inscricao = dda.cod_inscricao
                       AND ddcanc.exercicio = dda.exercicio

                    LEFT JOIN divida.divida_remissao ddrem
                    ON ddrem.cod_inscricao = dda.cod_inscricao
                       AND ddrem.exercicio = dda.exercicio

                    LEFT JOIN divida.divida_estorno ddestorn
                    ON ddestorn.cod_inscricao = dda.cod_inscricao
                       AND ddestorn.exercicio = dda.exercicio

                    LEFT JOIN divida.divida_processo as ddproc
                    ON ddproc.cod_inscricao = dda.cod_inscricao
                    AND ddproc.exercicio = dda.exercicio
                     ORDER BY dda.exercicio, dda.cod_inscricao
            ) as busca WHERE 1 = 1";

        if (isset($filter['codInscricaoAno']['value']) and $filter['codInscricaoAno']['value'] !== "") {
            list($codInscricao, $exercicio) = explode("/", $filter['codInscricaoAno']['value']);

            $sql .= " AND busca.cod_inscricao = :cod_inscricao";
            $sql .= " AND busca.exercicio = :exercicio";
        }

        if (isset($filter['numLivroDe']['value']) and $filter['numLivroDe']['value'] !== "" or isset($filter['numLivroAte']['value']) and $filter['numLivroAte']['value'] !== "") {
            $sql .= " AND busca.num_livro BETWEEN :num_livro_de AND :num_livro_ate";
        }

        if (isset($filter['numFolhaDe']['value']) and $filter['numFolhaDe']['value'] !== "" or isset($filter['numFolhaAte']['value']) and $filter['numFolhaAte']['value'] !== "") {
            $sql .= " AND busca.num_folha BETWEEN :num_folha_de AND :num_folha_ate";
        }

        if (isset($filter['cobrancaAno']['value']) and $filter['cobrancaAno']['value'] !== "") {
            $sql .= " and (SELECT
                    (dp2.numero_parcelamento ||'/'||dp2.exercicio)
                from
                    divida.divida_parcelamento as ddp2
                    INNER JOIN divida.parcelamento as dp2
                    ON ddp2.num_parcelamento = dp2.num_parcelamento
                WHERE
                    ddp2.exercicio = busca.exercicio
                    AND ddp2.cod_inscricao = busca.cod_inscricao
                ORDER BY dp2.exercicio DESC, dp2.numero_parcelamento DESC
                LIMIT 1
                ) = :max_cobranca";
        }

        if (isset($filter['fkSwCgm']['value']) and $filter['fkSwCgm']['value'] !== "") {
            $sql .= " AND busca.numcgm_contribuinte = :numcgm_contribuinte";
        }

        if (isset($filter['inscricaoEconomicaDe']['value']) and $filter['inscricaoEconomicaDe']['value'] !== "" or isset($filter['inscricaoEconomicaAte']['value']) and $filter['inscricaoEconomicaAte']['value'] !== "") {
            $sql .= " AND busca.inscricao_economica BETWEEN :inscricao_economica_de AND :inscricao_economica_ate";
        }

        if (isset($filter['inscricaoMunicipalDe']['value']) and $filter['inscricaoMunicipalDe']['value'] !== "" or isset($filter['inscricaoMunicipalAte']['value']) and $filter['inscricaoMunicipalAte']['value'] !== "") {
            $sql .= " AND busca.inscricao_municipal BETWEEN :inscricao_municipal_de AND :inscricao_municipal_ate";
        }

        $query = $this->entityManager->getConnection()->prepare($sql);

        if (isset($filter['codInscricaoAno']['value']) and $filter['codInscricaoAno']['value'] !== "") {
            $query->bindValue(':cod_inscricao', $codInscricao, \PDO::PARAM_INT);
            $query->bindValue(':exercicio', $exercicio, \PDO::PARAM_STR);
        }

        if (isset($filter['numLivroDe']['value']) and $filter['numLivroDe']['value'] !== "" or isset($filter['numAteLivro']['value']) and $filter['numLivroAte']['value'] !== "") {
            $query->bindValue(':num_livro_de', empty($filter['numLivroDe']['value']) ? $filter['numLivroAte']['value'] : $filter['numLivroDe']['value'], \PDO::PARAM_INT);
            $query->bindValue(':num_livro_ate', empty($filter['numLivroAte']['value']) ? $filter['numLivroDe']['value'] : $filter['numLivroAte']['value'], \PDO::PARAM_INT);
        }

        if (isset($filter['numFolhaDe']['value']) and $filter['numFolhaDe']['value'] !== "" or isset($filter['numFolhaAte']['value']) and $filter['numFolhaAte']['value'] !== "") {
            $query->bindValue(':num_folha_de', empty($filter['numFolhaDe']['value']) ? $filter['numFolhaAte']['value'] : $filter['numFolhaDe']['value'], \PDO::PARAM_INT);
            $query->bindValue(':num_folha_ate', empty($filter['numFolhaAte']['value']) ? $filter['numFolhaDe']['value'] : $filter['numFolhaAte']['value'], \PDO::PARAM_INT);
        }

        if (isset($filter['cobrancaAno']['value']) and $filter['cobrancaAno']['value'] !== "") {
            $query->bindValue(':max_cobranca', $filter['cobrancaAno']['value'], \PDO::PARAM_STR);
        }

        if (isset($filter['cobrancaAno']['value']) and $filter['cobrancaAno']['value'] !== "") {
            $query->bindValue(':max_cobranca', $filter['cobrancaAno']['value'], \PDO::PARAM_STR);
        }

        if (isset($filter['fkSwCgm']['value']) and $filter['fkSwCgm']['value'] !== "") {
            $query->bindValue(':numcgm_contribuinte', $filter['fkSwCgm']['value'], \PDO::PARAM_INT);
        }

        if (isset($filter['inscricaoMunicipalDe']['value']) and $filter['inscricaoMunicipalDe']['value'] !== "" or isset($filter['inscricaoMunicipalAte']['value']) and $filter['inscricaoMunicipalAte']['value'] !== "") {
            $query->bindValue(':inscricao_municipal_de', empty($filter['inscricaoMunicipalDe']['value']) ? $filter['inscricaoMunicipalAte']['value'] : $filter['inscricaoMunicipalDe']['value'], \PDO::PARAM_INT);
            $query->bindValue(':inscricao_municipal_ate', empty($filter['inscricaoMunicipalAte']['value']) ? $filter['inscricaoMunicipalDe']['value'] : $filter['inscricaoMunicipalAte']['value'], \PDO::PARAM_INT);
        }

        if (isset($filter['inscricaoEconomicaDe']['value']) and $filter['inscricaoEconomicaDe']['value'] !== "" or isset($filter['inscricaoEconomicaAte']['value']) and $filter['inscricaoEconomicaAte']['value'] !== "") {
            $query->bindValue(':inscricao_economica_de', empty($filter['inscricaoEconomicaDe']['value']) ? $filter['inscricaoEconomicaAte']['value'] : $filter['inscricaoEconomicaDe']['value'], \PDO::PARAM_INT);
            $query->bindValue(':inscricao_economica_ate', empty($filter['inscricaoEconomicaAte']['value']) ? $filter['inscricaoEconomicaDe']['value'] : $filter['inscricaoEconomicaAte']['value'], \PDO::PARAM_INT);
        }

        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param DividaAtiva $dividaAtiva
     * @return mixed
     */
    public function getDadosDividaAtiva(DividaAtiva $dividaAtiva)
    {
        $sql = "SELECT
            busca.cod_inscricao,
            busca.exercicio,
            busca.exercicio_original,
            busca.dt_inscricao_divida,
            busca.num_parcelamento,
            busca.inscricao,
            busca.num_livro,
            busca.num_folha,
            busca.inscricao_municipal,
            busca.inscricao_economica,
            busca.nom_cgm_autoridade,
            busca.numcgm_autoridade,
            busca.numcgm_contribuinte,
            busca.nom_cgm_contribuinte,
            arrecadacao.fn_busca_origem_inscricao_divida_ativa ( busca.cod_inscricao, busca.exercicio::integer, 6 ) AS credito,
            busca.cod_processo,
            busca.ano_exercicio,
            busca.total_parcelas,
            busca.total_parcelas_unicas,
            busca.total_parcelas_canceladas,
            busca.total_parcelas_pagas,
            busca.total_parcelas_unicas_pagas,
            busca.inscricao_cancelada,
            busca.numcgm_cancelada,
            busca.usuario_cancelada,
            busca.data_cancelada,
            busca.inscricao_estornada
            , ( CASE WHEN inscricao_cancelada IS NOT NULL THEN
                    'Cancelada'
                WHEN inscricao_estornada IS NOT NULL THEN
                    'Estornada'
                WHEN inscricao_remida IS NOT NULL THEN
                    'Remida'
                WHEN ( total_parcelas = 0 ) OR (total_parcelas_canceladas > 0) THEN
                    'Sem cobrança'
                WHEN judicial = TRUE THEN
                    'Cobrança Judicial'
                WHEN (( total_parcelas_pagas >= total_parcelas ) OR (total_parcelas_unicas_pagas > 0) ) THEN
                    'Paga'
                ELSE
                    'Aberta'
                END
            ) AS situacao,
            ( CASE WHEN inscricao_cancelada IS NOT NULL THEN
                   motivo_cancelada
                WHEN inscricao_estornada IS NOT NULL THEN
                   motivo_estornada
                ELSE
                   null
                END
            ) as motivo,
            CASE WHEN ( total_parcelas = 0 ) OR (total_parcelas_canceladas > 0) THEN
                (
                    SELECT
                        (
                            SELECT
                                modalidade.descricao
                            FROM
                                divida.modalidade
                            WHERE
                                modalidade.cod_modalidade = parcelamento.cod_modalidade
                            ORDER BY
                                timestamp DESC
                            LIMIT 1
                        )

                    FROM
                        divida.divida_parcelamento

                    INNER JOIN
                        divida.parcelamento
                    ON
                        parcelamento.num_parcelamento = divida_parcelamento.num_parcelamento

                    WHERE
                        divida_parcelamento.cod_inscricao = busca.cod_inscricao
                        AND divida_parcelamento.exercicio = busca.exercicio

                    ORDER BY
                        divida_parcelamento.num_parcelamento ASC
                    LIMIT 1
                )
            ELSE
                busca.modalidade_descricao
            END AS modalidade_descricao,

            CASE WHEN ( total_parcelas = 0 ) OR (total_parcelas_canceladas > 0) THEN
                (
                    SELECT
                        parcelamento.cod_modalidade
                    FROM
                        divida.divida_parcelamento

                    INNER JOIN
                        divida.parcelamento
                    ON
                        parcelamento.num_parcelamento = divida_parcelamento.num_parcelamento

                    WHERE
                        divida_parcelamento.cod_inscricao = busca.cod_inscricao
                        AND divida_parcelamento.exercicio = busca.exercicio

                    ORDER BY
                        divida_parcelamento.num_parcelamento ASC
                    LIMIT 1
                )
            ELSE
                busca.cod_modalidade::integer
            END AS cod_modalidade
            , ( CASE WHEN ( total_parcelas = 0 ) OR (total_parcelas_canceladas > 0) THEN
                    '  ' --sem cobrança
                ELSE
                    (
                        SELECT
                            (dp2.numero_parcelamento ||'/'||dp2.exercicio)
                        from
                            divida.divida_parcelamento as ddp2
                            INNER JOIN divida.parcelamento as dp2
                            ON ddp2.num_parcelamento = dp2.num_parcelamento
                        WHERE
                            ddp2.exercicio = busca.exercicio
                            AND ddp2.cod_inscricao = busca.cod_inscricao
                        ORDER BY dp2.exercicio DESC, dp2.numero_parcelamento DESC
                        LIMIT 1
                    )
                END
            ) as max_cobranca,
            busca.remissao_norma,
            busca.remissao_cod_norma
            , to_char(( SELECT MIN(dt_vencimento_parcela) FROM divida.parcela WHERE num_parcelamento = busca.num_parcelamento ), 'dd/mm/yyyy') AS dt_vencimento_parcela

        FROM
            (
                SELECT DISTINCT
                    dda.*
                    , dmod.descricao as modalidade_descricao
                    , ddp.cod_modalidade
                    , ddproc.cod_processo
                    , ddproc.ano_exercicio
                    , ddp.judicial
                    , (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.num_parcelamento = dda.num_parcelamento
                            AND divida.parcela.num_parcela > 0
                    ) AS total_parcelas
                    ,(
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.num_parcelamento = dda.num_parcelamento
                            AND divida.parcela.num_parcela = 0
                    ) AS total_parcelas_unicas
                    , (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.cancelada = true
                            AND divida.parcela.paga = false
                            AND divida.parcela.num_parcelamento = dda.num_parcelamento
                    ) AS total_parcelas_canceladas
                    , (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.cancelada = false
                            AND divida.parcela.paga = true
                            AND divida.parcela.num_parcelamento = dda.num_parcelamento
                            AND divida.parcela.num_parcela > 0
                    ) AS total_parcelas_pagas
                    , (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.cancelada = false
                            AND divida.parcela.paga = true
                            AND divida.parcela.num_parcelamento = dda.num_parcelamento
                            AND divida.parcela.num_parcela = 0
                    ) AS total_parcelas_unicas_pagas
                    , ddcanc.cod_inscricao as inscricao_cancelada
                    , ddcanc.motivo as motivo_cancelada
                    , ddcanc.numcgm as numcgm_cancelada
                    , ( select nom_cgm from sw_cgm where numcgm = ddcanc.numcgm ) as usuario_cancelada
                    , ddcanc.timestamp as data_cancelada
                    , ddestorn.cod_inscricao as inscricao_estornada
                    , ddestorn.motivo as motivo_estornada
                    , ddrem.cod_inscricao as inscricao_remida
                    , (
                        SELECT
                            norma.nom_norma
                        FROM
                            normas.norma
                        WHERE
                            norma.cod_norma = ddrem.cod_norma
                    )AS remissao_norma,
                    ddrem.cod_norma AS remissao_cod_norma

                FROM

                    (
                        SELECT
                            dda.cod_inscricao
                            , dda.exercicio
                            , dda.exercicio_original
                            , dda.num_livro
                            , dda.num_folha
                            , to_char(dda.dt_inscricao, 'dd/mm/yyyy') AS dt_inscricao_divida
                            , max(num_parcelamento) as num_parcelamento

                            , COALESCE( ddi.inscricao_municipal, dde.inscricao_economica ) AS inscricao

                            , ddi.inscricao_municipal
                            , dde.inscricao_economica

                            , autoridade.nom_cgm as nom_cgm_autoridade
                            , autoridade.numcgm as numcgm_autoridade
                            , cgm.numcgm AS numcgm_contribuinte
                            , cgm.nom_cgm AS nom_cgm_contribuinte

                        FROM

                            divida.divida_ativa AS dda

                            INNER JOIN divida.divida_parcelamento AS dp
                            ON dp.cod_inscricao = dda.cod_inscricao
                            AND dp.exercicio = dda.exercicio

                            INNER JOIN (
                                SELECT
                                    dauto.cod_autoridade
                                    , cgm.numcgm
                                    , cgm.nom_cgm
                                FROM
                                    divida.autoridade as dauto
                                    INNER JOIN sw_cgm as cgm
                                    ON cgm.numcgm = dauto.numcgm

                            ) as autoridade
                            ON autoridade.cod_autoridade = dda.cod_autoridade

                            LEFT JOIN divida.divida_imovel AS ddi
                            ON ddi.cod_inscricao = dda.cod_inscricao
                            AND ddi.exercicio = dda.exercicio

                            LEFT JOIN divida.divida_empresa AS dde
                            ON dde.cod_inscricao = dda.cod_inscricao
                            AND dde.exercicio = dda.exercicio

                            INNER JOIN divida.divida_cgm AS ddc
                            ON ddc.cod_inscricao = dda.cod_inscricao
                            AND ddc.exercicio = dda.exercicio

                            INNER JOIN sw_cgm as cgm
                            ON cgm.numcgm = ddc.numcgm

                        GROUP BY
                            dda.cod_inscricao, dda.exercicio, dda.dt_inscricao
                            , ddi.inscricao_municipal, dde.inscricao_economica
                            , autoridade.nom_cgm, autoridade.numcgm, dda.exercicio_original
                            , cgm.numcgm, cgm.nom_cgm, dda.num_livro, dda.num_folha

                    ) AS dda

                    INNER JOIN  divida.parcelamento AS ddp
                    ON ddp.num_parcelamento = dda.num_parcelamento

                    INNER JOIN  (
                        SELECT
                            dmod.cod_modalidade
                            , dmod.descricao
                            , max(ultimo_timestamp) as timestamp
                        FROM
                            divida.modalidade as dmod
                        GROUP BY dmod.cod_modalidade, dmod.descricao
                    ) as dmod
                    ON dmod.cod_modalidade = ddp.cod_modalidade

                    LEFT JOIN divida.parcela AS ddpar
                    ON ddpar.num_parcelamento = dda.num_parcelamento

                    INNER JOIN divida.parcela_origem AS dpo
                    ON dpo.num_parcelamento = dda.num_parcelamento

                    INNER JOIN arrecadacao.parcela AS ap
                    ON ap.cod_parcela = dpo.cod_parcela

                    LEFT JOIN divida.divida_cancelada ddcanc
                    ON ddcanc.cod_inscricao = dda.cod_inscricao
                       AND ddcanc.exercicio = dda.exercicio

                    LEFT JOIN divida.divida_remissao ddrem
                    ON ddrem.cod_inscricao = dda.cod_inscricao
                       AND ddrem.exercicio = dda.exercicio

                    LEFT JOIN divida.divida_estorno ddestorn
                    ON ddestorn.cod_inscricao = dda.cod_inscricao
                       AND ddestorn.exercicio = dda.exercicio

                    LEFT JOIN divida.divida_processo as ddproc
                    ON ddproc.cod_inscricao = dda.cod_inscricao
                    AND ddproc.exercicio = dda.exercicio
                    WHERE dda.cod_inscricao = :cod_inscricao
                    ORDER BY dda.exercicio, dda.cod_inscricao
                    ) as busca
                    ";

        $query = $this->entityManager->getConnection()->prepare($sql);

        $query->bindValue('cod_inscricao', $dividaAtiva->getCodInscricao(), \PDO::PARAM_INT);

        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param array $dividasAtivas
     * @return array
     */
    public function getDadosDividasAtivas(array $dividasAtivas = [])
    {
        $query = "SELECT
            busca.cod_inscricao,
            busca.exercicio,
            busca.total_parcelas,
            busca.total_parcelas_unicas,
            busca.total_parcelas_canceladas,
            busca.total_parcelas_pagas,
            busca.total_parcelas_unicas_pagas,
            busca.inscricao_cancelada,
            busca.inscricao_estornada
            , ( CASE WHEN inscricao_cancelada IS NOT NULL THEN
                    'Cancelada'
                WHEN inscricao_estornada IS NOT NULL THEN
                    'Estornada'
                WHEN inscricao_remida IS NOT NULL THEN
                    'Remida'
                WHEN ( total_parcelas = 0 ) OR (total_parcelas_canceladas > 0) THEN
                    'Sem cobrança'
                WHEN judicial = TRUE THEN
                    'Cobrança Judicial'
                WHEN (( total_parcelas_pagas >= total_parcelas ) OR (total_parcelas_unicas_pagas > 0) ) THEN
                    'Paga'
                ELSE
                    'Aberta'
                END
            ) AS situacao
        FROM
            (
                SELECT DISTINCT
                    dda.*
                    , dmod.descricao as modalidade_descricao
                    , ddp.cod_modalidade
                    , ddproc.cod_processo
                    , ddproc.ano_exercicio
                    , ddp.judicial
                    , (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.num_parcelamento = dda.num_parcelamento
                            AND divida.parcela.num_parcela > 0
                    ) AS total_parcelas
                    ,(
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.num_parcelamento = dda.num_parcelamento
                            AND divida.parcela.num_parcela = 0
                    ) AS total_parcelas_unicas
                    , (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.cancelada = true
                            AND divida.parcela.paga = false
                            AND divida.parcela.num_parcelamento = dda.num_parcelamento
                    ) AS total_parcelas_canceladas
                    , (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.cancelada = false
                            AND divida.parcela.paga = true
                            AND divida.parcela.num_parcelamento = dda.num_parcelamento
                            AND divida.parcela.num_parcela > 0
                    ) AS total_parcelas_pagas
                    , (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.cancelada = false
                            AND divida.parcela.paga = true
                            AND divida.parcela.num_parcelamento = dda.num_parcelamento
                            AND divida.parcela.num_parcela = 0
                    ) AS total_parcelas_unicas_pagas
                    , ddcanc.cod_inscricao as inscricao_cancelada
                    , ddcanc.motivo as motivo_cancelada
                    , ddcanc.numcgm as numcgm_cancelada
                    , ( select nom_cgm from sw_cgm where numcgm = ddcanc.numcgm ) as usuario_cancelada
                    , ddcanc.timestamp as data_cancelada
                    , ddestorn.cod_inscricao as inscricao_estornada
                    , ddestorn.motivo as motivo_estornada
                    , ddrem.cod_inscricao as inscricao_remida
                    , (
                        SELECT
                            norma.nom_norma
                        FROM
                            normas.norma
                        WHERE
                            norma.cod_norma = ddrem.cod_norma
                    )AS remissao_norma,
                    ddrem.cod_norma AS remissao_cod_norma

                FROM

                    (
                        SELECT
                            dda.cod_inscricao
                            , dda.exercicio
                            , dda.exercicio_original
                            , dda.num_livro
                            , dda.num_folha
                            , to_char(dda.dt_inscricao, 'dd/mm/yyyy') AS dt_inscricao_divida
                            , max(num_parcelamento) as num_parcelamento

                            , COALESCE( ddi.inscricao_municipal, dde.inscricao_economica ) AS inscricao

                            , ddi.inscricao_municipal
                            , dde.inscricao_economica

                            , autoridade.nom_cgm as nom_cgm_autoridade
                            , autoridade.numcgm as numcgm_autoridade
                            , cgm.numcgm AS numcgm_contribuinte
                            , cgm.nom_cgm AS nom_cgm_contribuinte

                        FROM

                            divida.divida_ativa AS dda

                            INNER JOIN divida.divida_parcelamento AS dp
                            ON dp.cod_inscricao = dda.cod_inscricao
                            AND dp.exercicio = dda.exercicio

                            INNER JOIN (
                                SELECT
                                    dauto.cod_autoridade
                                    , cgm.numcgm
                                    , cgm.nom_cgm
                                FROM
                                    divida.autoridade as dauto
                                    INNER JOIN sw_cgm as cgm
                                    ON cgm.numcgm = dauto.numcgm

                            ) as autoridade
                            ON autoridade.cod_autoridade = dda.cod_autoridade

                            LEFT JOIN divida.divida_imovel AS ddi
                            ON ddi.cod_inscricao = dda.cod_inscricao
                            AND ddi.exercicio = dda.exercicio

                            LEFT JOIN divida.divida_empresa AS dde
                            ON dde.cod_inscricao = dda.cod_inscricao
                            AND dde.exercicio = dda.exercicio

                            INNER JOIN divida.divida_cgm AS ddc
                            ON ddc.cod_inscricao = dda.cod_inscricao
                            AND ddc.exercicio = dda.exercicio

                            INNER JOIN sw_cgm as cgm
                            ON cgm.numcgm = ddc.numcgm

                        GROUP BY
                            dda.cod_inscricao, dda.exercicio, dda.dt_inscricao
                            , ddi.inscricao_municipal, dde.inscricao_economica
                            , autoridade.nom_cgm, autoridade.numcgm, dda.exercicio_original
                            , cgm.numcgm, cgm.nom_cgm, dda.num_livro, dda.num_folha

                    ) AS dda

                    INNER JOIN  divida.parcelamento AS ddp
                    ON ddp.num_parcelamento = dda.num_parcelamento

                    INNER JOIN  (
                        SELECT
                            dmod.cod_modalidade
                            , dmod.descricao
                            , max(ultimo_timestamp) as timestamp
                        FROM
                            divida.modalidade as dmod
                        GROUP BY dmod.cod_modalidade, dmod.descricao
                    ) as dmod
                    ON dmod.cod_modalidade = ddp.cod_modalidade

                    LEFT JOIN divida.parcela AS ddpar
                    ON ddpar.num_parcelamento = dda.num_parcelamento

                    LEFT JOIN divida.parcela_origem AS dpo
                    ON dpo.num_parcelamento = dda.num_parcelamento

                    LEFT JOIN arrecadacao.parcela AS ap
                    ON ap.cod_parcela = dpo.cod_parcela

                    LEFT JOIN divida.divida_cancelada ddcanc
                    ON ddcanc.cod_inscricao = dda.cod_inscricao
                       AND ddcanc.exercicio = dda.exercicio

                    LEFT JOIN divida.divida_remissao ddrem
                    ON ddrem.cod_inscricao = dda.cod_inscricao
                       AND ddrem.exercicio = dda.exercicio

                    LEFT JOIN divida.divida_estorno ddestorn
                    ON ddestorn.cod_inscricao = dda.cod_inscricao
                       AND ddestorn.exercicio = dda.exercicio

                    LEFT JOIN divida.divida_processo as ddproc
                    ON ddproc.cod_inscricao = dda.cod_inscricao
                    AND ddproc.exercicio = dda.exercicio
                    WHERE dda.cod_inscricao IN ({codInscricao})
                    ORDER BY dda.cod_inscricao DESC
                    ) as busca
                    ";

        if (empty($dividasAtivas)) {
            $dividasAtivas = [0];
        }

        $query = str_replace('{codInscricao}', implode(',', $dividasAtivas), $query);

        $pdo = $this->entityManager->getConnection();

        $sth = $pdo->query($query);

        return $sth->fetchAll();
    }

    /**
     * @param $dividaAtiva
     * @return array
     */
    public function getListaCobrancasDivida($dividaAtiva)
    {
        $sql = 'SELECT
                  *
                  , ( CASE WHEN inscricao_estornada IS NOT NULL THEN
                                            \'Estornada\'
                                        WHEN inscricao_cancelada IS NOT NULL THEN
                                            \'Cancelada\'
                                        WHEN qtd_parcelas < 1 THEN
                          \'Em Aberto\'
                      WHEN parcelas_canceladas > 0 THEN
                          \'Cancelada\'
                      WHEN ( parcelas_unicas_pagas > 0 ) THEN
                          \'Quitada\'
                      WHEN qtd_parcelas > 0 AND ( qtd_parcelas = parcelas_pagas ) THEN
                          \'Quitada\'
                      WHEN cod_tipo_modalidade = 2 THEN
                          \'Consolidada\'
                      WHEN cod_tipo_modalidade = 3 THEN
                          \'Parcelada\'
                      ELSE
                          \'Aberta\'
                      END
                  ) as situacao
                  , '."'".$dividaAtiva->getDtInscricao()->format('d/m/Y')."'".' as data_base
              FROM
                  (
                      SELECT
                          ddp.num_parcelamento
                          , ( CASE WHEN dp.numero_parcelamento = -1 THEN
                                  NULL
                              ELSE
                                  dp.numero_parcelamento||\'/\'||dp.exercicio
                              END
                          ) AS numero_parcelamento
                          , dp.cod_modalidade
                          , mv.cod_tipo_modalidade
                          , dm.descricao as descricao_modalidade
                          , dp.numcgm_usuario
                          , cgm.nom_cgm AS nomcgm_usuario
                          , to_char(dp.timestamp, \'dd/mm/yyyy\') AS dt_parcelamento
                          , (
                              SELECT
                                  count(*)
                              FROM
                                  divida.parcela as dp
                              WHERE
                                  dp.num_parcelamento = ddp.num_parcelamento
                                  AND dp.num_parcela > 0
                          ) AS qtd_parcelas
                          , (
                              SELECT
                                  count(*)
                              FROM
                                  divida.parcela as dp
                              WHERE
                                  dp.num_parcelamento = ddp.num_parcelamento
                                  AND dp.num_parcela = 0
                          ) AS qtd_unicas
                          , (
                              SELECT
                                  count(num_parcela) as parcelas_pagas
                              FROM
                                  divida.parcela
                              WHERE
                                  dp.num_parcelamento = parcela.num_parcelamento
                                  AND parcela.paga = false
                                  AND parcela.cancelada = true
                          ) as parcelas_canceladas
                          , (
                              SELECT
                                  count(num_parcela) as parcelas_pagas
                              FROM
                                  divida.parcela
                              WHERE
                                  dp.num_parcelamento = parcela.num_parcelamento
                                  AND parcela.paga = true
                                  AND parcela.cancelada = false
                                  AND parcela.num_parcela > 0
                          ) as parcelas_pagas
                          , (
                              SELECT
                                  count(num_parcela) as parcelas_pagas
                              FROM
                                  divida.parcela
                              WHERE
                                  dp.num_parcelamento = parcela.num_parcelamento
                                  AND parcela.paga = true
                                  AND parcela.cancelada = false
                                  AND parcela.num_parcela = 0
                          ) as parcelas_unicas_pagas
                          , (
                              SELECT
                                  CASE WHEN ( count(*) > 0 ) THEN
                                      true
                                  ELSE
                                      false
                                  END
                              FROM
                                  divida.parcela
                              WHERE
                                  num_parcelamento = ddp.num_parcelamento
                          ) AS ativar_lista
                          , (
                              SELECT
                                  sum(dpar.vlr_parcela)
                              FROM
                                  divida.parcela as dpar
                              WHERE
                                  dpar.num_parcelamento = ddp.num_parcelamento
                                  AND dpar.num_parcela > 0
                          ) AS valor_parcelamento
                          ,ddcanc.cod_inscricao AS inscricao_cancelada
                          ,ddestorn.cod_inscricao AS inscricao_estornada
                          , dpc.motivo as motivo_cancelamento
                          , to_char(dpc.timestamp, \'dd/mm/yyyy\') as data_cancelamento
                          , dpc.numcgm ||\' - \'||(select nom_cgm from sw_cgm where numcgm = dpc.numcgm) as usuario_cancelamento
                      FROM
                          divida.divida_parcelamento AS ddp
                          LEFT JOIN divida.divida_cancelada AS ddcanc
                                            ON  ddcanc.cod_inscricao = ddp.cod_inscricao
                                            AND ddcanc.exercicio = ddp.exercicio
                          LEFT JOIN divida.divida_estorno AS ddestorn
                                            ON  ddestorn.cod_inscricao = ddp.cod_inscricao
                                            AND ddestorn.exercicio = ddp.exercicio
                          INNER JOIN divida.parcelamento AS dp
                          ON dp.num_parcelamento = ddp.num_parcelamento
                          LEFT JOIN divida.parcelamento_cancelamento as DPC
                            ON DPC.num_parcelamento = ddp.num_parcelamento
                          INNER JOIN divida.modalidade_vigencia as mv
                          ON mv.cod_modalidade = dp.cod_modalidade
                          AND mv.timestamp = dp.timestamp_modalidade
                          INNER JOIN divida.modalidade as dm
                          ON dm.cod_modalidade = mv.cod_modalidade
                          AND dp.timestamp_modalidade = mv.timestamp
                          INNER JOIN sw_cgm as cgm
                          ON cgm.numcgm = dp.numcgm_usuario
                       WHERE ddp.cod_inscricao = :cod_inscricao AND ddp.exercicio = :exercicio
                  ) as busca
              WHERE
                  qtd_parcelas > 0   ;';

        $query = $this->entityManager->getConnection()->prepare($sql);

        $query->bindValue(':cod_inscricao', $dividaAtiva->getCodInscricao(), \PDO::PARAM_INT);
        $query->bindValue(':exercicio', $dividaAtiva->getExercicio(), \PDO::PARAM_STR);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $cobrancaDivida
     * @return array
     */
    public function getListaParcelasDivida($cobrancaDivida)
    {
        $sql = 'SELECT distinct
            dp.num_parcelamento,
            to_char( coalesce(pag.data_pagamento, now()::date), \'dd/mm/YYYY\')::varchar as database_br
                , ( dp.num_parcela ||\'/\'|| (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.num_parcelamento = dp.num_parcelamento
                            AND parcela.num_parcela > 0
                    )
                ) AS info_parcela
                , (
                    SELECT
                        count(*)
                    FROM
                        divida.parcela
                    WHERE
                        divida.parcela.num_parcelamento = dp.num_parcelamento
                        AND parcela.num_parcela > 0
                ) AS total_de_parcelas
                , dp.num_parcela
                , dp.vlr_parcela
                , to_char(dp.dt_vencimento_parcela, \'dd/mm/yyyy\') AS vencimento
                , ( CASE WHEN dp.paga = true THEN
                        \'paga\'
                    ELSE
                        CASE WHEN dp.cancelada = true THEN
                            \'cancelada\'
                        ELSE
                            \'aberta\'
                        END
                    END
                ) AS situacao

                , alc.cod_lancamento
                , ap.cod_parcela
                , ac.numeracao
                , ac.exercicio
                , acm.numeracao_migracao
                , acm.prefixo

            FROM
                divida.parcela AS dp

                INNER JOIN divida.parcela_calculo AS dpc
                ON dpc.num_parcelamento = dp.num_parcelamento
                AND dpc.num_parcela = dp.num_parcela

                INNER JOIN arrecadacao.lancamento_calculo as alc
                ON alc.cod_calculo = dpc.cod_calculo

                INNER JOIN arrecadacao.calculo AS calc
                ON calc.cod_calculo = alc.cod_calculo

                INNER JOIN arrecadacao.parcela as ap
                ON ap.cod_lancamento = alc.cod_lancamento
                AND ap.nr_parcela = dp.num_parcela

                LEFT JOIN (
                    SELECT
                        MAX(app.timestamp) AS timestamp,
                        app.cod_parcela
                    FROM
                        arrecadacao.parcela_reemissao AS app
                    GROUP BY cod_parcela
                )as aparr
                ON aparr.cod_parcela = ap.cod_parcela

                INNER JOIN arrecadacao.carne as ac
                ON ac.cod_parcela = ap.cod_parcela
                AND ac.exercicio = calc.exercicio
                AND ( (aparr.timestamp = ac.timestamp) OR aparr IS NULL)

                LEFT JOIN arrecadacao.pagamento as pag
                ON pag.numeracao = ac.numeracao

                LEFT JOIN arrecadacao.carne_migracao AS acm
                ON acm.numeracao = ac.numeracao
                AND acm.cod_convenio = ac.cod_convenio
           WHERE
                dp.num_parcela >= 0
                 AND dp.num_parcelamento = :num_parcelamento order by num_parcela ASC';

        $query = $this->entityManager->getConnection()->prepare($sql);

        $query->bindValue(':num_parcelamento', $cobrancaDivida->num_parcelamento, \PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $dividaAtivaParcela
     * @return array
     */
    public function getListaDetalheParcelaCredito($dividaAtivaParcela)
    {
        $dataBase = \DateTime::createFromFormat('d/m/Y', $dividaAtivaParcela->database_br);

        $sql = "SELECT DISTINCT
                    dados.cod_modalidade,
                    split_part ( monetario.fn_busca_mascara_credito( dados.cod_credito, dados.cod_especie, dados.cod_genero, dados.cod_natureza ), '§', 1 ) as credito_codigo_composto,
                    split_part ( monetario.fn_busca_mascara_credito( dados.cod_credito, dados.cod_especie, dados.cod_genero, dados.cod_natureza ), '§', 6 ) as credito_nome,
                    dados.vl_credito AS valor_credito,
                    CASE WHEN '".$dataBase->format('Y-m-d')."' > dados.dt_vencimento_parcela THEN
                        dados.vlr_acrescimos_juros + split_part( aplica_acrescimo_modalidade( 0, dados.cod_inscricao, dados.exercicio_divida, dados.cod_modalidade, 2, dados.num_parcelamento ,dados.vlr_parcela, dados.dt_vencimento_parcela, '".$dataBase->format('Y-m-d')."', 'true' ), ';', 1 )::numeric
                    ELSE
                        dados.vlr_acrescimos_juros
                    END AS credito_juros_pagar,

                    CASE WHEN '".$dataBase->format('Y-m-d')."' > dados.dt_vencimento_parcela THEN
                        aplica_acrescimo_modalidade( 0, dados.cod_inscricao, dados.exercicio_divida, dados.cod_modalidade, 2, dados.num_parcelamento ,dados.vlr_parcela, dados.dt_vencimento_parcela, '".$dataBase->format('Y-m-d')."', 'true' )
                    END AS juros_sob_juros_pagar,

                    CASE WHEN '".$dataBase->format('Y-m-d')."' > dados.dt_vencimento_parcela THEN
                        dados.vlr_acrescimos_multa + split_part( aplica_acrescimo_modalidade( 0, dados.cod_inscricao, dados.exercicio_divida, dados.cod_modalidade, 3, dados.num_parcelamento ,dados.vlr_parcela, dados.dt_vencimento_parcela, '".$dataBase->format('Y-m-d')."', 'true' ), ';', 1 )::numeric
                    ELSE
                        dados.vlr_acrescimos_multa
                    END AS credito_multa_pagar,

                    CASE WHEN '".$dataBase->format('Y-m-d')."' > dados.dt_vencimento_parcela THEN
                        aplica_acrescimo_modalidade( 0, dados.cod_inscricao, dados.exercicio_divida, dados.cod_modalidade, 3, dados.num_parcelamento ,dados.vlr_parcela, dados.dt_vencimento_parcela, '".$dataBase->format('Y-m-d')."', 'true' )
                    END AS multa_sob_multa_pagar,

                    CASE WHEN '".$dataBase->format('Y-m-d')."' > dados.dt_vencimento_parcela THEN
                        dados.vlr_acrescimos_correcao + split_part( aplica_acrescimo_modalidade( 0, dados.cod_inscricao, dados.exercicio_divida, dados.cod_modalidade, 1, dados.num_parcelamento, dados.vlr_parcela, dados.dt_vencimento_parcela, '".$dataBase->format('Y-m-d')."', 'true' ), ';', 1 )::numeric
                    ELSE
                        dados.vlr_acrescimos_correcao
                    END AS credito_correcao_pagar,

                    CASE WHEN '".$dataBase->format('Y-m-d')."' > dados.dt_vencimento_parcela THEN
                        aplica_acrescimo_modalidade( 0, dados.cod_inscricao, dados.exercicio_divida, dados.cod_modalidade, 1, dados.num_parcelamento, dados.vlr_parcela, dados.dt_vencimento_parcela, '".$dataBase->format('Y-m-d')."', 'true' )
                    END AS correcao_sob_correcao_pagar,

                    dados.vlr_reducao AS credito_descontos,

                    CASE WHEN '".$dataBase->format('Y-m-d')."' > dados.dt_vencimento_parcela THEN
                        split_part( aplica_acrescimo_modalidade( 0, dados.cod_inscricao, dados.exercicio_divida, dados.cod_modalidade, 1, dados.num_parcelamento, dados.vlr_parcela, dados.dt_vencimento_parcela, '".$dataBase->format('Y-m-d')."', 'true' ), ';', 1 )::numeric
                        + split_part( aplica_acrescimo_modalidade( 0, dados.cod_inscricao, dados.exercicio_divida, dados.cod_modalidade, 3, dados.num_parcelamento, dados.vlr_parcela, dados.dt_vencimento_parcela, '".$dataBase->format('Y-m-d')."', 'true' ), ';', 1 )::numeric
                        + split_part( aplica_acrescimo_modalidade( 0, dados.cod_inscricao, dados.exercicio_divida, dados.cod_modalidade, 2, dados.num_parcelamento, dados.vlr_parcela, dados.dt_vencimento_parcela, '".$dataBase->format('Y-m-d')."', 'true' ), ';', 1 )::numeric
                        + dados.vlr_total
                    ELSE
                        dados.vlr_total
                    END AS valor_total,
                    dados.cod_calculo,
                    (dados.vlr_pago + dados.vlr_pago_acrescimo) AS valor_total_pago,

                    CASE WHEN '".$dataBase->format('Y-m-d')."' > dados.dt_vencimento_parcela THEN
                        (dados.vlr_pago + dados.vlr_pago_acrescimo) - (split_part( aplica_acrescimo_modalidade( 0, dados.cod_inscricao, dados.exercicio_divida, dados.cod_modalidade, 1, dados.num_parcelamento, dados.vlr_parcela, dados.dt_vencimento_parcela, '".$dataBase->format('Y-m-d')."', 'true' ), ';', 1 )::numeric
                        + split_part( aplica_acrescimo_modalidade( 0, dados.cod_inscricao, dados.exercicio_divida, dados.cod_modalidade, 3, dados.num_parcelamento, dados.vlr_parcela, dados.dt_vencimento_parcela, '".$dataBase->format('Y-m-d')."', 'true' ), ';', 1 )::numeric
                        + split_part( aplica_acrescimo_modalidade( 0, dados.cod_inscricao, dados.exercicio_divida, dados.cod_modalidade, 2, dados.num_parcelamento, dados.vlr_parcela, dados.dt_vencimento_parcela, '".$dataBase->format('Y-m-d')."', 'true' ), ';', 1 )::numeric
                        + dados.vlr_total)
                    ELSE
                        (dados.vlr_pago + dados.vlr_pago_acrescimo) - dados.vlr_total
                    END AS diferenca,
                    COALESCE( dados.vlracrescimo, 0.00 ) AS valor_acrescimo_individual,
                    dados.cod_tipo AS tipo_acrescimo_individual,
                    dados.cod_acrescimo AS cod_acrescimo_individual,
                    (
                        SELECT
                            acrescimo.descricao_acrescimo
                        FROM
                            monetario.acrescimo
                        WHERE
                            acrescimo.cod_tipo = dados.cod_tipo
                            AND acrescimo.cod_acrescimo = dados.cod_acrescimo
                    )AS descricao_acrescimo_individual

                FROM
                    (
                    SELECT
                        dados.inscricao,
                        dados.cod_modalidade,
                        dados.num_parcelamento,
                        dp.vlr_parcela,
                        dp.dt_vencimento_parcela,
                        ac.*,
                        dpc.vl_credito,
                        (
                            SELECT
                                sum(vlracrescimo)
                            FROM
                                divida.parcela_acrescimo
                            WHERE
                                parcela_acrescimo.num_parcelamento = dpc.num_parcelamento
                                AND parcela_acrescimo.num_parcela = dpc.num_parcela
                                AND parcela_acrescimo.cod_tipo = 2
                        )AS vlr_acrescimos_juros,
                        (
                            SELECT
                                sum(vlracrescimo)
                            FROM
                                divida.parcela_acrescimo
                            WHERE
                                parcela_acrescimo.num_parcelamento = dpc.num_parcelamento
                                AND parcela_acrescimo.num_parcela = dpc.num_parcela
                                AND parcela_acrescimo.cod_tipo = 3
                        )AS vlr_acrescimos_multa,
                        (
                            SELECT
                                sum(vlracrescimo)
                            FROM
                                divida.parcela_acrescimo
                            WHERE
                                parcela_acrescimo.num_parcelamento = dpc.num_parcelamento
                                AND parcela_acrescimo.num_parcela = dpc.num_parcela
                                AND parcela_acrescimo.cod_tipo = 1
                        )AS vlr_acrescimos_correcao,
                        (
                            SELECT
                                sum(vlracrescimo)
                            FROM
                                divida.parcela_acrescimo
                            WHERE
                                parcela_acrescimo.num_parcelamento = dpc.num_parcelamento
                                AND parcela_acrescimo.num_parcela = dpc.num_parcela
                        )AS vlr_acrescimos,
                        (
                            SELECT
                                sum(valor)
                            FROM
                                divida.parcela_reducao
                            WHERE
                                parcela_reducao.num_parcelamento = dpc.num_parcelamento
                                AND parcela_reducao.num_parcela = dpc.num_parcela
                        )AS vlr_reducao,
                        (
                            SELECT
                                sum(vlracrescimo)+dpc.vl_credito - (
                                    SELECT
                                        sum(valor)
                                    FROM
                                        divida.parcela_reducao
                                    WHERE
                                        parcela_reducao.num_parcelamento = dpc.num_parcelamento
                                        AND parcela_reducao.num_parcela = dpc.num_parcela
                                )

                            FROM
                                divida.parcela_acrescimo
                            WHERE
                                parcela_acrescimo.num_parcelamento = dpc.num_parcelamento
                                AND parcela_acrescimo.num_parcela = dpc.num_parcela
                        )AS vlr_total,
                        COALESCE( (
                            SELECT
                                sum(pagamento_acrescimo.valor)
                            FROM
                                arrecadacao.pagamento_acrescimo
                            WHERE
                                pagamento_acrescimo.cod_calculo = ac.cod_calculo
                                AND pagamento_acrescimo.numeracao = apc.numeracao
                        ), 0.00 ) AS vlr_pago_acrescimo,
                        apc.valor AS vlr_pago,
                        dpac.vlracrescimo,
                        dmac.cod_tipo,
                        dmac.cod_acrescimo,
                        dados.cod_inscricao,
                        dados.exercicio_divida::integer

                    FROM
                        arrecadacao.parcela AS ap

                    INNER JOIN
                        divida.parcela_calculo AS dpc
                    ON
                        ap.nr_parcela = dpc.num_parcela

                    INNER JOIN (
                        SELECT DISTINCT
                            coalesce ( ddi.inscricao_municipal, dde.inscricao_economica, ddc.numcgm) AS inscricao,
                            dp.cod_modalidade,
                            dp.num_parcelamento,
                            (
                                SELECT
                                    modalidade.ultimo_timestamp
                                FROM
                                    divida.modalidade
                                WHERE
                                    modalidade.cod_modalidade = dp.cod_modalidade
                            )AS timestamp_modalidade,
                            ddc.cod_inscricao,
                            ddc.exercicio AS exercicio_divida

                        FROM
                            divida.divida_cgm AS ddc

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
                            divida.divida_parcelamento AS ddp
                        ON
                            ddp.cod_inscricao = ddc.cod_inscricao
                            AND ddp.exercicio = ddc.exercicio

                        INNER JOIN
                            divida.parcelamento AS dp
                        ON
                            ddp.num_parcelamento = dp.num_parcelamento
                    ) AS dados
                    ON
                        dados.num_parcelamento =  dpc.num_parcelamento

                    INNER JOIN
                        divida.parcela AS dp
                    ON
                        dp.num_parcela = dpc.num_parcela
                        AND dp.num_parcelamento = dpc.num_parcelamento

                    INNER JOIN
                        divida.modalidade_acrescimo AS dmac
                    ON
                        dmac.cod_modalidade = dados.cod_modalidade
                        AND dmac.timestamp = dados.timestamp_modalidade
                        AND ( dmac.pagamento = false OR ( dmac.pagamento = true AND '".$dataBase->format('Y-m-d')."' > dp.dt_vencimento_parcela ) )

                    LEFT JOIN
                        divida.parcela_acrescimo AS dpac
                    ON
                        dpac.num_parcela = dpc.num_parcela
                        AND dpac.num_parcelamento = dpc.num_parcelamento
                        AND dmac.cod_acrescimo = dpac.cod_acrescimo
                        AND dmac.cod_tipo = dpac.cod_tipo

                    INNER JOIN
                        arrecadacao.calculo AS ac
                    ON
                        ac.cod_calculo = dpc.cod_calculo

                    LEFT JOIN
                        arrecadacao.pagamento_calculo AS apc
                    ON
                        apc.cod_calculo = dpc.cod_calculo
                        AND apc.numeracao = '".$dividaAtivaParcela->numeracao."'::varchar
                    WHERE
                         ap.cod_lancamento = :cod_lancamento AND ap.cod_parcela = :cod_parcela AND dpc.num_parcelamento = :num_parcelamento
                )AS dados ";

        $query = $this->entityManager->getConnection()->prepare($sql);

        $query->bindValue(':cod_lancamento', $dividaAtivaParcela->cod_lancamento, \PDO::PARAM_INT);
        $query->bindValue(':cod_parcela', $dividaAtivaParcela->cod_parcela, \PDO::PARAM_INT);
        $query->bindValue(':num_parcelamento', $dividaAtivaParcela->num_parcelamento, \PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $dividaAtivaParcela
     * @return mixed
     */
    public function getDetalheParcelaDivida($parcelaDivida)
    {
        $dataBase = \DateTime::createFromFormat('d/m/Y', $parcelaDivida->database_br);

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
                        , carne.exercicio
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
                        , ap.valor as parcela_valor
                        , ( CASE WHEN apd.cod_parcela is not null THEN
                                (ap.valor - apd.valor)
                            ELSE
                                0.00
                            END
                        )::numeric(14,2) as parcela_valor_desconto
                        , ( select arrecadacao.buscaValorOriginalParcela( carne.numeracao ) as valor
                        ) as parcela_valor_original
                        , ( CASE WHEN apd.cod_parcela is not null THEN
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
                                    CASE WHEN dp.paga = true THEN
                                        'Paga'
                                    ELSE
                                        CASE WHEN ap.nr_parcela = 0
                                                    and (ap.vencimento < '".$dataBase->format('Y-m-d')."')
                                        THEN
                                            'Cancelada (Parcela única vencida)'
                                        ELSE
                                            'Em Aberto'
                                        END
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
                        , ( CASE WHEN  ( ap.vencimento >= '".$dataBase->format('Y-m-d')."' AND ap.nr_parcela > 0 )
                                        OR ( ap.valor = 0.00 )
                                        OR ( apag.pagamento_data is not null
                                            AND ap.vencimento >= apag.pagamento_data )
                                        OR ( ap.nr_parcela > 0 AND acd.numeracao is not null )
                            THEN
                                0.00
                            ELSE
                                --arrecadacao.calcula_correcao_lancamento(carne.numeracao,'".$dataBase->format('Y-m-d')."')::numeric(14,2)
                                split_part( aplica_acrescimo_modalidade( 0, ddc.cod_inscricao, ddc.exercicio::integer, dip.cod_modalidade, 1, dp.num_parcelamento, ap.valor, ap.vencimento, '".$dataBase->format('Y-m-d')."', 'true' ), ';', 1 )::numeric(14,2)
                            END
                        )::numeric(14,2) as parcela_correcao_pagar
                        , ( CASE WHEN  ( ap.vencimento >= '".$dataBase->format('Y-m-d')."' AND ap.nr_parcela > 0 )
                                        OR ( ap.valor = 0.00 )
                                        OR ( apag.pagamento_data is not null
                                            AND ap.vencimento >= apag.pagamento_data )
                                        OR ( ap.nr_parcela > 0 AND acd.numeracao is not null )
                            THEN
                                0.00
                            ELSE
                                --arrecadacao.calcula_juros_lancamento(carne.numeracao,'".$dataBase->format('Y-m-d')."')::numeric(14,2)
                                split_part( aplica_acrescimo_modalidade( 0, ddc.cod_inscricao, ddc.exercicio::integer, dip.cod_modalidade, 2, dp.num_parcelamento, ap.valor, ap.vencimento, '".$dataBase->format('Y-m-d')."', 'true' ), ';', 1 )::numeric(14,2)
                            END
                        )::numeric(14,2) as parcela_juros_pagar
                        , ( CASE WHEN  ( ap.vencimento >= '".$dataBase->format('Y-m-d')."' AND ap.nr_parcela > 0 )
                                        OR ( ap.valor = 0.00 )
                                        OR (apag.pagamento_data is not null
                                            AND ap.vencimento >= apag.pagamento_data
                                        )
                                        OR ( ap.nr_parcela > 0 AND acd.numeracao is not null )
                            THEN
                                0.00
                            ELSE
                                --arrecadacao.calcula_multa_lancamento ( carne.numeracao, '".$dataBase->format('Y-m-d')."')::numeric
                                split_part( aplica_acrescimo_modalidade( 0, ddc.cod_inscricao, ddc.exercicio::integer, dip.cod_modalidade, 3, dp.num_parcelamento, ap.valor, ap.vencimento, '".$dataBase->format('Y-m-d')."', 'true' ), ';', 1 )::numeric(14,2)
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

                INNER JOIN divida.parcela_calculo AS dpc
                ON  dpc.cod_calculo = alc.cod_calculo
                AND dpc.num_parcela = ap.nr_parcela

                INNER JOIN
                        divida.parcela AS dp
                ON
                        dp.num_parcelamento = dpc.num_parcelamento
                        AND dp.num_parcela = dpc.num_parcela

                INNER JOIN
                        divida.parcelamento AS dip
                ON
                        dip.num_parcelamento = dpc.num_parcelamento

                INNER JOIN
                        divida.divida_parcelamento AS ddp
                ON
                        ddp.num_parcelamento = dpc.num_parcelamento

                INNER JOIN
                        divida.divida_cgm AS ddc
                ON
                        ddc.cod_inscricao = ddp.cod_inscricao
                        AND ddc.exercicio = ddp.exercicio

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
                  al.cod_lancamento= :cod_lancamento AND  carne.numeracao= :numeracao AND  ap.cod_parcela= :cod_parcela
            ORDER BY
                ap.nr_parcela
            ) as consulta ;";

        $query = $this->entityManager->getConnection()->prepare($sql);

        $query->bindValue(':cod_lancamento', $parcelaDivida->cod_lancamento, \PDO::PARAM_INT);
        $query->bindValue(':numeracao', $parcelaDivida->numeracao, \PDO::PARAM_STR);
        $query->bindValue(':cod_parcela', $parcelaDivida->cod_parcela, \PDO::PARAM_INT);

        $query->execute();

        return $query->fetch();
    }

    /**
     * @param $listaDetalheParcela
     * @param $listaDetalheCreditos
     * @return array
     */
    public function getCalculoCredito($listaDetalheParcela, $listaDetalheCreditos)
    {
        $flTotalCreditos = 0;
        $inQuantidadeCreditos = 0;
        $arCreditos = array();

        foreach ($listaDetalheCreditos as $listaDetalheCredito) {
            $boIncluir = true;
            for ($inX = 0; $inX < $inQuantidadeCreditos; $inX++) {
                if ($arCreditos[$inX] == $listaDetalheCredito["credito_codigo_composto"]) {
                    $boIncluir = false;
                    break;
                }
            }

            if ($boIncluir) {
                $flTotalCreditos += $listaDetalheCredito["valor_credito"];
                $arCreditos[$inQuantidadeCreditos] = $listaDetalheCredito["credito_codigo_composto"];
                $inQuantidadeCreditos++;
            }
        }

        $listaDetalheParcela[0]["parcela_desconto_pagar"] = current($listaDetalheCreditos)["credito_descontos"];
        $listaDetalheParcela[0]["valor_total"] = ($listaDetalheParcela["pagamento_valor"]) ? $listaDetalheParcela["pagamento_valor"] : ($flTotalCreditos + current($listaDetalheCreditos)["credito_juros_pagar"] + current($listaDetalheCreditos)["credito_multa_pagar"] + current($listaDetalheCreditos)["credito_correcao_pagar"] - current($listaDetalheCreditos)["credito_descontos"]);
        $listaDetalheParcela[0]["parcela_valor"] = $flTotalCreditos;
        $listaDetalheParcela[0]["parcela_juros_pagar"] = current($listaDetalheCreditos)["credito_juros_pagar"];
        $listaDetalheParcela[0]["parcela_multa_pagar"] = current($listaDetalheCreditos)["credito_multa_pagar"];
        $listaDetalheParcela[0]["parcela_correcao_pagar"] = current($listaDetalheCreditos)["credito_correcao_pagar"];

        $inQuantidadeCreditos = 0;
        $arCreditos = array();
        $listaDetalheParcela[0]["credito_utilizado"] = "";
        for ($inY = 0; $inY < count($listaDetalheCreditos); $inY++) {
            $flValorAcrescimo = $listaDetalheCreditos[$inY]["valor_credito"];
            $flValorAcrescimoPercent = ($flValorAcrescimo * 100) / $flTotalCreditos;
            $boIncluir = true;
            for ($inX = 0; $inX < $inQuantidadeCreditos; $inX++) {
                if ($arCreditos[$inX]["credito_codigo_composto"] == $listaDetalheCreditos[$inY]["credito_codigo_composto"]) {
                    $inValorExtra = 0.00;
                    $arMultas = explode(";", $listaDetalheCreditos[$inY]["multa_sob_multa_pagar"]);
                    $arJuros = explode(";", $listaDetalheCreditos[$inY]["juros_sob_juros_pagar"]);
                    $arCorrecao = explode(";", $listaDetalheCreditos[$inY]["correcao_sob_correcao_pagar"]);

                    $boIncluir = false;
                    for ($inA = 2; $inA < count($arMultas); $inA += 3) {
                        if (($arMultas[$inA] == $listaDetalheCreditos[$inY]["cod_acrescimo_individual"]) && ($arMultas[$inA + 1] == $listaDetalheCreditos[$inY]["tipo_acrescimo_individual"])) {
                            $boIncluir = true;
                            $inValorExtra = $arMultas[$inA - 1];
                            break;
                        }
                    }
                    if (!$boIncluir) {
                        for ($inA = 2; $inA < count($arJuros); $inA += 3) {
                            if (($arJuros[$inA] == $listaDetalheCreditos[$inY]["cod_acrescimo_individual"]) && ($arJuros[$inA + 1] == $listaDetalheCreditos[$inY]["tipo_acrescimo_individual"])) {
                                $boIncluir = true;
                                $inValorExtra = $arJuros[$inA - 1];
                                break;
                            }
                        }
                    }

                    if (!$boIncluir) {
                        for ($inA = 2; $inA < count($arCorrecao); $inA += 3) {
                            if (($arCorrecao[$inA] == $listaDetalheCreditos[$inY]["cod_acrescimo_individual"]) && ($arCorrecao[$inA + 1] == $listaDetalheCreditos[$inY]["tipo_acrescimo_individual"])) {
                                $boIncluir = true;
                                $inValorExtra = $arCorrecao[$inA - 1];
                                break;
                            }
                        }
                    }

                    $arCreditos[$inX]["lista_acrescimos"][$arCreditos[$inX]["total_de_acrescimos"]] = $listaDetalheCreditos[$inY]["descricao_acrescimo_individual"];
                    $arCreditos[$inX]["lista_acrescimos_valor"][$arCreditos[$inX]["total_de_acrescimos"]] = (($listaDetalheCreditos[$inY]["valor_acrescimo_individual"] + $inValorExtra) * $flValorAcrescimoPercent) / 100;
                    $arCreditos[$inX]["total_de_acrescimos"]++;

                    $arCreditos[$inX]["acrescimo_nome_" . $arCreditos[$inX]["total_de_acrescimos"]] = $listaDetalheCreditos[$inY]["descricao_acrescimo_individual"];
                    $arCreditos[$inX]["acrescimo_valor_" . $arCreditos[$inX]["total_de_acrescimos"]] = (($listaDetalheCreditos[$inY]["valor_acrescimo_individual"] + $inValorExtra) * $flValorAcrescimoPercent) / 100;

                    $arCreditos[$inX]["valor_total"] += $arCreditos[$inX]["acrescimo_valor_" . $arCreditos[$inX]["total_de_acrescimos"]];
                    if ($listaDetalheCreditos[$inY]["valor_total_pago"]) {
                        $arCreditos[$inX]["diferenca"] = round($arCreditos[$inX]["valor_total_pago"] - $arCreditos[$inX]["valor_total"], 2);
                    }
                    $boIncluir = false;
                    break;
                }
            }

            if ($boIncluir) {
                $arCreditos[$inQuantidadeCreditos]["lista_acrescimos"] = array(); //lista com nome e posicao dos acrescimos
                $arCreditos[$inQuantidadeCreditos]["total_de_acrescimos"] = 1;
                $arCreditos[$inQuantidadeCreditos]["lista_acrescimos"][0] = $listaDetalheCreditos[$inY]["descricao_acrescimo_individual"];

                $inValorExtra = 0.00;
                $arMultas = explode(";", $listaDetalheCreditos[$inY]["multa_sob_multa_pagar"]);
                $arJuros = explode(";", $listaDetalheCreditos[$inY]["juros_sob_juros_pagar"]);
                $arCorrecao = explode(";", $listaDetalheCreditos[$inY]["correcao_sob_correcao_pagar"]);

                $boIncluir = false;
                for ($inA = 2; $inA < count($arMultas); $inA += 3) {
                    if (($arMultas[$inA] == $listaDetalheCreditos[$inY]["cod_acrescimo_individual"]) && ($arMultas[$inA + 1] == $listaDetalheCreditos[$inY]["tipo_acrescimo_individual"])) {
                        $boIncluir = true;
                        $inValorExtra = $arMultas[$inA - 1];
                        break;
                    }
                }

                if (!$boIncluir) {
                    for ($inA = 2; $inA < count($arJuros); $inA += 3) {
                        if (($arJuros[$inA] == $listaDetalheCreditos[$inY]["cod_acrescimo_individual"]) && ($arJuros[$inA + 1] == $listaDetalheCreditos[$inY]["tipo_acrescimo_individual"])) {
                            $boIncluir = true;
                            $inValorExtra = $arJuros[$inA - 1];
                            break;
                        }
                    }
                }

                if (!$boIncluir) {
                    for ($inA = 2; $inA < count($arCorrecao); $inA += 3) {
                        if (($arCorrecao[$inA] == $listaDetalheCreditos[$inY]["cod_acrescimo_individual"]) && ($arCorrecao[$inA + 1] == $listaDetalheCreditos[$inY]["tipo_acrescimo_individual"])) {
                            $boIncluir = true;
                            $inValorExtra = $arCorrecao[$inA - 1];
                            break;
                        }
                    }
                }

                $arCreditos[$inQuantidadeCreditos]["lista_acrescimos_valor"][0] = (($listaDetalheCreditos[$inY]["valor_acrescimo_individual"] + $inValorExtra) * $flValorAcrescimoPercent) / 100;

                $arCreditos[$inQuantidadeCreditos]["acrescimo_nome_1"] = $listaDetalheCreditos[$inY]["descricao_acrescimo_individual"];
                $arCreditos[$inQuantidadeCreditos]["acrescimo_valor_1"] = (($listaDetalheCreditos[$inY]["valor_acrescimo_individual"] + $inValorExtra) * $flValorAcrescimoPercent) / 100;

                $arCreditos[$inQuantidadeCreditos]["credito_descontos"] = ($listaDetalheCreditos[$inY]["credito_descontos"] * $flValorAcrescimoPercent) / 100;
                $arCreditos[$inQuantidadeCreditos]["valor_total"] = ($listaDetalheCreditos[$inY]["valor_credito"] + $arCreditos[$inQuantidadeCreditos]["acrescimo_valor_1"]) - $arCreditos[$inQuantidadeCreditos]["credito_descontos"];
                $arCreditos[$inQuantidadeCreditos]["valor_credito"] = $listaDetalheCreditos[$inY]["valor_credito"];

                $arCreditos[$inQuantidadeCreditos]["credito_nome"] = $listaDetalheCreditos[$inY]["credito_nome"];
                $arCreditos[$inQuantidadeCreditos]["credito_codigo_composto"] = $listaDetalheCreditos[$inY]["credito_codigo_composto"];
                $arCreditos[$inQuantidadeCreditos]["valor_total_pago"] = $listaDetalheCreditos[$inY]["valor_total_pago"];
                if ($listaDetalheCreditos[$inY]["valor_total_pago"]) {
                    $arCreditos[$inQuantidadeCreditos]["diferenca"] = round($arCreditos[$inQuantidadeCreditos]["valor_total_pago"] - $arCreditos[$inQuantidadeCreditos]["valor_total"], 2);
                } else {
                    $arCreditos[$inQuantidadeCreditos]["diferenca"] = 0.00;
                }
                $inQuantidadeCreditos++;
            }
        }
        return $arCreditos;
    }

    /**
     * @param $dividaAtiva
     * @return array
     */
    public function getListaDocumentoComCobrancaDivida($dividaAtiva)
    {
        $sql = "SELECT DISTINCT
                        dd.cod_documento,
                        dd.cod_tipo_documento,
                        ded.num_documento,
                        ded.exercicio,
                        to_char(ded.timestamp, 'dd/mm/yyyy') AS dt_emissao,
                        amd.nome_documento,
                        amd.nome_arquivo_agt,
                        dp.num_parcelamento,
                        aad.nome_arquivo_swx,
                        CASE WHEN ded.timestamp IS NULL THEN
                            false
                        ELSE
                            true
                        END AS boImprimir

                    FROM
                        divida.divida_parcelamento AS ddp

                    INNER JOIN
                        divida.parcelamento AS dp
                    ON
                        dp.num_parcelamento = ddp.num_parcelamento

                    INNER JOIN
                        divida.documento AS dd
                    ON
                        dd.num_parcelamento = dp.num_parcelamento

                    INNER JOIN
                        administracao.modelo_documento AS amd
                    ON
                        dd.cod_documento = amd.cod_documento
                        AND dd.cod_tipo_documento = amd.cod_tipo_documento

                    INNER JOIN
                        administracao.modelo_arquivos_documento AS amad
                    ON
                        dd.cod_documento = amad.cod_documento
                        AND dd.cod_tipo_documento = amad.cod_tipo_documento

                    INNER JOIN
                        administracao.arquivos_documento AS aad
                    ON
                        aad.cod_arquivo = amad.cod_arquivo

                    LEFT JOIN
                        (
                            SELECT
                                max(timestamp) AS timestamp,
                                cod_documento,
                                cod_tipo_documento,
                                num_parcelamento,
                                num_documento,
                                exercicio
                            FROM
                                divida.emissao_documento
                            GROUP BY
                                cod_documento,
                                cod_tipo_documento,
                                num_parcelamento,
                                num_documento,
                                exercicio
                        )AS ded
                    ON
                        ded.cod_documento = dd.cod_documento
                        AND ded.cod_tipo_documento = dd.cod_tipo_documento
                        AND ded.num_parcelamento = dd.num_parcelamento

                    WHERE
                        dp.numero_parcelamento::integer != -1
                        AND dp.exercicio::integer != -1
                        AND ddp.cod_inscricao = :cod_inscricao
                        AND ddp.exercicio = :exercicio ";

        $query = $this->entityManager->getConnection()->prepare($sql);

        $query->bindValue(':cod_inscricao', $dividaAtiva->getCodInscricao(), \PDO::PARAM_INT);
        $query->bindValue(':exercicio', $dividaAtiva->getExercicio(), \PDO::PARAM_STR);

        $query->execute();

        return $query->fetchAll();
    }

    public function getListaDocumentoSemCobrancaDivida($dividaAtiva)
    {
        $sql = "SELECT DISTINCT
                        dd.cod_documento,
                        dd.cod_tipo_documento,
                        ded.num_documento,
                        ded.exercicio,
                        to_char(ded.timestamp, 'dd/mm/yyyy') AS dt_emissao,
                        amd.nome_documento,
                        amd.nome_arquivo_agt,
                        dp.num_parcelamento,
                        aad.nome_arquivo_swx,
                        CASE WHEN ded.timestamp IS NULL THEN
                            false
                        ELSE
                            true
                        END AS boImprimir

                    FROM
                        divida.parcelamento AS dp

                    INNER JOIN
                        divida.documento AS dd
                    ON
                        dd.num_parcelamento = dp.num_parcelamento

                    INNER JOIN
                        administracao.modelo_documento AS amd
                    ON
                        dd.cod_documento = amd.cod_documento
                        AND dd.cod_tipo_documento = amd.cod_tipo_documento

                    INNER JOIN
                        administracao.modelo_arquivos_documento AS amad
                    ON
                        dd.cod_documento = amad.cod_documento
                        AND dd.cod_tipo_documento = amad.cod_tipo_documento

                    INNER JOIN
                        administracao.arquivos_documento AS aad
                    ON
                        aad.cod_arquivo = amad.cod_arquivo

                    LEFT JOIN
                    (
                            SELECT
                                max(timestamp) AS timestamp,
                                cod_documento,
                                cod_tipo_documento,
                                num_parcelamento,
                                num_documento,
                                exercicio
                            FROM
                                divida.emissao_documento
                            GROUP BY
                                cod_documento,
                                cod_tipo_documento,
                                num_parcelamento,
                                num_documento,
                                exercicio
                        )AS ded
                    ON
                        ded.cod_documento = dd.cod_documento
                        AND ded.cod_tipo_documento = dd.cod_tipo_documento
                        AND ded.num_parcelamento = dd.num_parcelamento

                    WHERE
                        dp.num_parcelamento = (
                            SELECT
                                MIN(num_parcelamento)
                            FROM
                                divida.divida_parcelamento
                            WHERE
                                divida_parcelamento.cod_inscricao = :cod_inscricao
                                AND divida_parcelamento.exercicio = :exercicio
                        )";

        $query = $this->entityManager->getConnection()->prepare($sql);

        $query->bindValue(':cod_inscricao', $dividaAtiva->getCodInscricao(), \PDO::PARAM_INT);
        $query->bindValue(':exercicio', $dividaAtiva->getExercicio(), \PDO::PARAM_STR);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $inscricaoAno
     * @return array
     */
    public function getInscricaoAno($inscricaoAno)
    {
        $sql = "SELECT
            busca.cod_inscricao,
            busca.exercicio,
            busca.exercicio_original,
            busca.dt_inscricao_divida,
            busca.num_parcelamento,
            busca.inscricao,
            busca.num_livro,
            busca.num_folha,
            busca.inscricao_municipal,
            busca.inscricao_economica,
            busca.nom_cgm_autoridade,
            busca.numcgm_autoridade,
            busca.numcgm_contribuinte,
            busca.nom_cgm_contribuinte,
            arrecadacao.fn_busca_origem_inscricao_divida_ativa ( busca.cod_inscricao, busca.exercicio::integer, 6 ) AS credito,
            busca.cod_processo,
            busca.ano_exercicio,
            busca.total_parcelas,
            busca.total_parcelas_unicas,
            busca.total_parcelas_canceladas,
            busca.total_parcelas_pagas,
            busca.total_parcelas_unicas_pagas,
            busca.inscricao_cancelada,
            busca.numcgm_cancelada,
            busca.usuario_cancelada,
            busca.data_cancelada,
            busca.inscricao_estornada
            , ( CASE WHEN inscricao_cancelada IS NOT NULL THEN
                    'Cancelada'
                WHEN inscricao_estornada IS NOT NULL THEN
                    'Estornada'
                WHEN inscricao_remida IS NOT NULL THEN
                    'Remida'
                WHEN ( total_parcelas = 0 ) OR (total_parcelas_canceladas > 0) THEN
                    'Sem cobrança'
                WHEN judicial = TRUE THEN
                    'Cobrança Judicial'
                WHEN (( total_parcelas_pagas >= total_parcelas ) OR (total_parcelas_unicas_pagas > 0) ) THEN
                    'Paga'
                ELSE
                    'Aberta'
                END
            ) AS situacao,
            ( CASE WHEN inscricao_cancelada IS NOT NULL THEN
                   motivo_cancelada
                WHEN inscricao_estornada IS NOT NULL THEN
                   motivo_estornada
                ELSE
                   null
                END
            ) as motivo,
            CASE WHEN ( total_parcelas = 0 ) OR (total_parcelas_canceladas > 0) THEN
                (
                    SELECT
                        (
                            SELECT
                                modalidade.descricao
                            FROM
                                divida.modalidade
                            WHERE
                                modalidade.cod_modalidade = parcelamento.cod_modalidade
                            ORDER BY
                                timestamp DESC
                            LIMIT 1
                        )

                    FROM
                        divida.divida_parcelamento

                    INNER JOIN
                        divida.parcelamento
                    ON
                        parcelamento.num_parcelamento = divida_parcelamento.num_parcelamento

                    WHERE
                        divida_parcelamento.cod_inscricao = busca.cod_inscricao
                        AND divida_parcelamento.exercicio = busca.exercicio

                    ORDER BY
                        divida_parcelamento.num_parcelamento ASC
                    LIMIT 1
                )
            ELSE
                busca.modalidade_descricao
            END AS modalidade_descricao,

            CASE WHEN ( total_parcelas = 0 ) OR (total_parcelas_canceladas > 0) THEN
                (
                    SELECT
                        parcelamento.cod_modalidade
                    FROM
                        divida.divida_parcelamento

                    INNER JOIN
                        divida.parcelamento
                    ON
                        parcelamento.num_parcelamento = divida_parcelamento.num_parcelamento

                    WHERE
                        divida_parcelamento.cod_inscricao = busca.cod_inscricao
                        AND divida_parcelamento.exercicio = busca.exercicio

                    ORDER BY
                        divida_parcelamento.num_parcelamento ASC
                    LIMIT 1
                )
            ELSE
                busca.cod_modalidade::integer
            END AS cod_modalidade
            , ( CASE WHEN ( total_parcelas = 0 ) OR (total_parcelas_canceladas > 0) THEN
                    '  ' --sem cobrança
                ELSE
                    (
                        SELECT
                            (dp2.numero_parcelamento ||'/'||dp2.exercicio)
                        from
                            divida.divida_parcelamento as ddp2
                            INNER JOIN divida.parcelamento as dp2
                            ON ddp2.num_parcelamento = dp2.num_parcelamento
                        WHERE
                            ddp2.exercicio = busca.exercicio
                            AND ddp2.cod_inscricao = busca.cod_inscricao
                        ORDER BY dp2.exercicio DESC, dp2.numero_parcelamento DESC
                        LIMIT 1
                    )
                END
            ) as max_cobranca,
            busca.remissao_norma,
            busca.remissao_cod_norma
            , to_char(( SELECT MIN(dt_vencimento_parcela) FROM divida.parcela WHERE num_parcelamento = busca.num_parcelamento ), 'dd/mm/yyyy') AS dt_vencimento_parcela

        FROM
            (
                SELECT DISTINCT
                    dda.*
                    , dmod.descricao as modalidade_descricao
                    , ddp.cod_modalidade
                    , ddproc.cod_processo
                    , ddproc.ano_exercicio
                    , ddp.judicial
                    , (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.num_parcelamento = dda.num_parcelamento
                            AND divida.parcela.num_parcela > 0
                    ) AS total_parcelas
                    ,(
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.num_parcelamento = dda.num_parcelamento
                            AND divida.parcela.num_parcela = 0
                    ) AS total_parcelas_unicas
                    , (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.cancelada = true
                            AND divida.parcela.paga = false
                            AND divida.parcela.num_parcelamento = dda.num_parcelamento
                    ) AS total_parcelas_canceladas
                    , (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.cancelada = false
                            AND divida.parcela.paga = true
                            AND divida.parcela.num_parcelamento = dda.num_parcelamento
                            AND divida.parcela.num_parcela > 0
                    ) AS total_parcelas_pagas
                    , (
                        SELECT
                            count(*)
                        FROM
                            divida.parcela
                        WHERE
                            divida.parcela.cancelada = false
                            AND divida.parcela.paga = true
                            AND divida.parcela.num_parcelamento = dda.num_parcelamento
                            AND divida.parcela.num_parcela = 0
                    ) AS total_parcelas_unicas_pagas
                    , ddcanc.cod_inscricao as inscricao_cancelada
                    , ddcanc.motivo as motivo_cancelada
                    , ddcanc.numcgm as numcgm_cancelada
                    , ( select nom_cgm from sw_cgm where numcgm = ddcanc.numcgm ) as usuario_cancelada
                    , ddcanc.timestamp as data_cancelada
                    , ddestorn.cod_inscricao as inscricao_estornada
                    , ddestorn.motivo as motivo_estornada
                    , ddrem.cod_inscricao as inscricao_remida
                    , (
                        SELECT
                            norma.nom_norma
                        FROM
                            normas.norma
                        WHERE
                            norma.cod_norma = ddrem.cod_norma
                    )AS remissao_norma,
                    ddrem.cod_norma AS remissao_cod_norma

                FROM

                    (
                        SELECT
                            dda.cod_inscricao
                            , dda.exercicio
                            , dda.exercicio_original
                            , dda.num_livro
                            , dda.num_folha
                            , to_char(dda.dt_inscricao, 'dd/mm/yyyy') AS dt_inscricao_divida
                            , max(num_parcelamento) as num_parcelamento

                            , COALESCE( ddi.inscricao_municipal, dde.inscricao_economica ) AS inscricao

                            , ddi.inscricao_municipal
                            , dde.inscricao_economica

                            , autoridade.nom_cgm as nom_cgm_autoridade
                            , autoridade.numcgm as numcgm_autoridade
                            , cgm.numcgm AS numcgm_contribuinte
                            , cgm.nom_cgm AS nom_cgm_contribuinte

                        FROM

                            divida.divida_ativa AS dda

                            INNER JOIN divida.divida_parcelamento AS dp
                            ON dp.cod_inscricao = dda.cod_inscricao
                            AND dp.exercicio = dda.exercicio

                            INNER JOIN (
                                SELECT
                                    dauto.cod_autoridade
                                    , cgm.numcgm
                                    , cgm.nom_cgm
                                FROM
                                    divida.autoridade as dauto
                                    INNER JOIN sw_cgm as cgm
                                    ON cgm.numcgm = dauto.numcgm

                            ) as autoridade
                            ON autoridade.cod_autoridade = dda.cod_autoridade

                            LEFT JOIN divida.divida_imovel AS ddi
                            ON ddi.cod_inscricao = dda.cod_inscricao
                            AND ddi.exercicio = dda.exercicio

                            LEFT JOIN divida.divida_empresa AS dde
                            ON dde.cod_inscricao = dda.cod_inscricao
                            AND dde.exercicio = dda.exercicio

                            INNER JOIN divida.divida_cgm AS ddc
                            ON ddc.cod_inscricao = dda.cod_inscricao
                            AND ddc.exercicio = dda.exercicio

                            INNER JOIN sw_cgm as cgm
                            ON cgm.numcgm = ddc.numcgm

                        GROUP BY
                            dda.cod_inscricao, dda.exercicio, dda.dt_inscricao
                            , ddi.inscricao_municipal, dde.inscricao_economica
                            , autoridade.nom_cgm, autoridade.numcgm, dda.exercicio_original
                            , cgm.numcgm, cgm.nom_cgm, dda.num_livro, dda.num_folha

                    ) AS dda

                    INNER JOIN  divida.parcelamento AS ddp
                    ON ddp.num_parcelamento = dda.num_parcelamento

                    INNER JOIN  (
                        SELECT
                            dmod.cod_modalidade
                            , dmod.descricao
                            , max(ultimo_timestamp) as timestamp
                        FROM
                            divida.modalidade as dmod
                        GROUP BY dmod.cod_modalidade, dmod.descricao
                    ) as dmod
                    ON dmod.cod_modalidade = ddp.cod_modalidade

                    LEFT JOIN divida.parcela AS ddpar
                    ON ddpar.num_parcelamento = dda.num_parcelamento

                    INNER JOIN divida.parcela_origem AS dpo
                    ON dpo.num_parcelamento = dda.num_parcelamento

                    INNER JOIN arrecadacao.parcela AS ap
                    ON ap.cod_parcela = dpo.cod_parcela

                    LEFT JOIN divida.divida_cancelada ddcanc
                    ON ddcanc.cod_inscricao = dda.cod_inscricao
                       AND ddcanc.exercicio = dda.exercicio

                    LEFT JOIN divida.divida_remissao ddrem
                    ON ddrem.cod_inscricao = dda.cod_inscricao
                       AND ddrem.exercicio = dda.exercicio

                    LEFT JOIN divida.divida_estorno ddestorn
                    ON ddestorn.cod_inscricao = dda.cod_inscricao
                       AND ddestorn.exercicio = dda.exercicio

                    LEFT JOIN divida.divida_processo as ddproc
                    ON ddproc.cod_inscricao = dda.cod_inscricao
                    AND ddproc.exercicio = dda.exercicio
                     ORDER BY dda.exercicio, dda.cod_inscricao
            ) as busca WHERE 1 = 1";

        if (isset($inscricaoAno) and $inscricaoAno !== "") {
            $sql .= " AND busca.cod_inscricao || '/' || busca.exercicio LIKE :cod_inscricao_ano";
        }

        $query = $this->entityManager->getConnection()->prepare($sql);

        if (isset($inscricaoAno) and $inscricaoAno !== "") {
            $query->bindValue(':cod_inscricao_ano', $inscricaoAno . '%', \PDO::PARAM_STR);
        }

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param integer $numParcelamento
     * @return array
     */
    public function getListaParcelas($numParcelamento)
    {
        $sql = "
            SELECT distinct
              dp.num_parcelamento,
                to_char( coalesce(pag.data_pagamento, now()::date), 'dd/mm/YYYY')::varchar as database_br
              , ( dp.num_parcela ||'/'|| (
              SELECT
                count(*)
              FROM
                divida.parcela
              WHERE
                divida.parcela.num_parcelamento = dp.num_parcelamento
                AND parcela.num_parcela > 0
            )
                ) AS info_parcela
              , (
                  SELECT
                    count(*)
                  FROM
                    divida.parcela
                  WHERE
                    divida.parcela.num_parcelamento = dp.num_parcelamento
                    AND parcela.num_parcela > 0
                ) AS total_de_parcelas
              , dp.num_parcela
              , dp.vlr_parcela
              , to_char(dp.dt_vencimento_parcela, 'dd/mm/yyyy') AS vencimento
              , ( CASE WHEN dp.paga = true THEN
              'paga'
                  ELSE
                    CASE WHEN dp.cancelada = true THEN
                      'cancelada'
                    ELSE
                      'aberta'
                    END
                  END
                ) AS situacao
            
              , alc.cod_lancamento
              , ap.cod_parcela
              , ac.numeracao
              , ac.exercicio
              , acm.numeracao_migracao
              , acm.prefixo
            
            FROM
              divida.parcela AS dp
            
              INNER JOIN divida.parcela_calculo AS dpc
                ON dpc.num_parcelamento = dp.num_parcelamento
                   AND dpc.num_parcela = dp.num_parcela
            
              INNER JOIN arrecadacao.lancamento_calculo as alc
                ON alc.cod_calculo = dpc.cod_calculo
            
              INNER JOIN arrecadacao.calculo AS calc
                ON calc.cod_calculo = alc.cod_calculo
            
              INNER JOIN arrecadacao.parcela as ap
                ON ap.cod_lancamento = alc.cod_lancamento
                   AND ap.nr_parcela = dp.num_parcela
            
              LEFT JOIN (
                          SELECT
                            MAX(app.timestamp) AS timestamp,
                            app.cod_parcela
                          FROM
                            arrecadacao.parcela_reemissao AS app
                          GROUP BY cod_parcela
                        )as aparr
                ON aparr.cod_parcela = ap.cod_parcela
            
              INNER JOIN arrecadacao.carne as ac
                ON ac.cod_parcela = ap.cod_parcela
                   AND ac.exercicio = calc.exercicio
                   AND ( (aparr.timestamp = ac.timestamp) OR aparr IS NULL)
            
              LEFT JOIN arrecadacao.pagamento as pag
                ON pag.numeracao = ac.numeracao
            
              LEFT JOIN arrecadacao.carne_migracao AS acm
                ON acm.numeracao = ac.numeracao
                   AND acm.cod_convenio = ac.cod_convenio
            WHERE
              dp.num_parcela >= 0
            
              AND dp.num_parcelamento = :num_parcelamento order by num_parcela ASC
        ";

        $query = $this->entityManager->getConnection()->prepare($sql);
        $query->bindValue(':num_parcelamento', $numParcelamento, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
