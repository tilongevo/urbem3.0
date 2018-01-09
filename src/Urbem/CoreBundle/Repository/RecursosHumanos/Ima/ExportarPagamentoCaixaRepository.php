<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Ima;

use PDO;
use Doctrine\ORM\EntityManagerInterface;
use Urbem\RecursosHumanosBundle\Resources\config\Sonata\Ima\ExportarPagamentoCaixaAdmin;

class ExportarPagamentoCaixaRepository
{
    const NUM_SEQUENCIAL_ARQUIVO_KEY = 'num_sequencial_arquivo_caixa';

    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
    * @return array
    */
    public function fetchUltimoPeriodoMovimentacao()
    {
        $query = "
            SELECT
              FPM.cod_periodo_movimentacao,
              to_char(FPM.dt_inicial, 'dd/mm/yyyy') as dt_inicial,
              to_char(FPM.dt_final, 'dd/mm/yyyy') as dt_final,
              FPMS.situacao,
              to_char(FPMS.timestamp, 'dd/mm/yyyy') as timestamp_situacao
            FROM
              folhapagamento.periodo_movimentacao FPM,
              folhapagamento.periodo_movimentacao_situacao FPMS,
              (
                SELECT
                  cod_periodo_movimentacao,
                  MAX(timestamp) as timestamp
                FROM
                  folhapagamento.periodo_movimentacao_situacao
                GROUP BY
                  cod_periodo_movimentacao
              ) as MAX_FPMS
            WHERE
              FPM.cod_periodo_movimentacao = FPMS.cod_periodo_movimentacao
              AND FPM.cod_periodo_movimentacao = MAX_FPMS.cod_periodo_movimentacao
              AND FPMS.timestamp = MAX_FPMS.timestamp
            ORDER BY dt_final::date DESC
            LIMIT 1;";

        $pdo = $this->em->getConnection();
        $sth = $pdo->query($query);

        return $sth->fetch();
    }

    /**
    * @param string $competencia
    * @return array
    */
    public function fetchPeriodoMovimentacao($competencia)
    {
        $query = "
            SELECT
              cod_periodo_movimentacao,
              TO_CHAR(dt_inicial, 'dd/mm/yyyy') AS dt_inicial,
              TO_CHAR(dt_final, 'dd/mm/yyyy') AS dt_final
            FROM
              folhapagamento.periodo_movimentacao
            WHERE
              to_char(dt_final, 'mm/yyyy') = :competencia;";

        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue('competencia', $competencia);
        $sth->execute();

        return $sth->fetch();
    }

    /**
    * @return array
    */
    public function fetchOrganograma()
    {
        $query = "
            SELECT
                *
            FROM
                organograma.organograma
            WHERE
                ativo = true
            ORDER BY
                implantacao DESC
            LIMIT 1;";

        $pdo = $this->em->getConnection();
        $sth = $pdo->query($query);

        return $sth->fetch();
    }

    /**
    * @return array
    */
    public function fetchLotacoes()
    {
        $query = "
            SELECT
                orgao.cod_orgao,
                CONCAT(
                    orgao_nivel.cod_estrutural,
                    ' - ',
                    recuperaDescricaoOrgao(orgao.cod_orgao, (SELECT dt_final::date FROM folhapagamento.periodo_movimentacao WHERE cod_periodo_movimentacao = :codPeriodoMovimentacao))
                ) AS descricao
            FROM
            organograma.orgao
            inner join(SELECT orgao_nivel.*,
                organograma.Fn_consulta_orgao(
                    orgao_nivel.cod_organograma,
                    orgao_nivel.cod_orgao) AS cod_estrutural FROM organograma.orgao_nivel) AS orgao_nivel
            ON orgao_nivel.cod_orgao = orgao.cod_orgao
            AND orgao_nivel.cod_nivel = publico.Fn_nivel(cod_estrutural)
            WHERE(orgao.inativacao > (SELECT dt_final::date FROM folhapagamento.periodo_movimentacao WHERE cod_periodo_movimentacao = :codPeriodoMovimentacao)
                OR orgao.inativacao IS NULL)
            AND orgao_nivel.cod_organograma = :codOrganograma
            ORDER BY descricao;";

        $ultimoPeriodoMovimentacao = $this->fetchUltimoPeriodoMovimentacao();
        $organograma = $this->fetchOrganograma();

        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue('codPeriodoMovimentacao', $ultimoPeriodoMovimentacao['cod_periodo_movimentacao']);
        $sth->bindValue('codOrganograma', $organograma['cod_organograma']);
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    /**
    * @return array
    */
    public function fetchFolhaComplementar()
    {
        $query = "
            SELECT
              complementar.cod_complementar,
              complementar.cod_complementar
            FROM
              folhapagamento.complementar complementar
              JOIN (
                SELECT
                  fcs.*
                FROM
                  folhapagamento.complementar_situacao fcs
                  JOIN (
                    SELECT
                      cod_periodo_movimentacao,
                      cod_complementar,
                      max(timestamp) as timestamp
                    FROM
                      folhapagamento.complementar_situacao
                    GROUP BY
                      cod_periodo_movimentacao,
                      cod_complementar
                  ) as max_fcs ON max_fcs.cod_periodo_movimentacao = fcs.cod_periodo_movimentacao
                  AND max_fcs.cod_complementar = fcs.cod_complementar
                  AND max_fcs.timestamp = fcs.timestamp
              ) as complementar_situacao ON complementar_situacao.cod_periodo_movimentacao = complementar.cod_periodo_movimentacao
              AND complementar_situacao.cod_complementar = complementar.cod_complementar
              AND complementar.cod_periodo_movimentacao = :codPeriodoMovimentacao;";

        $ultimoPeriodoMovimentacao = $this->fetchUltimoPeriodoMovimentacao();

        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue('codPeriodoMovimentacao', $ultimoPeriodoMovimentacao['cod_periodo_movimentacao']);
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    /**
    * @param int $codConfiguracao
    * @return array
    */
    public function fetchDesdobramentos($codConfiguracao)
    {
        $query = "
            SELECT
              desdobramento,
              descricao
            FROM
              folhapagamento.configuracao_desdobramento
            WHERE
              cod_configuracao = :codConfiguracao
            ORDER BY
              descricao;";

        $ultimoPeriodoMovimentacao = $this->fetchUltimoPeriodoMovimentacao();

        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue('codConfiguracao', $codConfiguracao);
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    /**
    * @return array
    */
    public function fetchGrupoDeContas()
    {
        $query = "
            SELECT
              configuracao_convenio_caixa_economica_federal.*,
              conta_corrente.num_conta_corrente,
              agencia.num_agencia,
              agencia.nom_agencia,
              banco.num_banco,
              banco.nom_banco
            FROM
              ima.configuracao_convenio_caixa_economica_federal,
              monetario.conta_corrente,
              monetario.agencia,
              monetario.banco
            WHERE
              configuracao_convenio_caixa_economica_federal.cod_conta_corrente = conta_corrente.cod_conta_corrente
              AND configuracao_convenio_caixa_economica_federal.cod_agencia = conta_corrente.cod_agencia
              AND configuracao_convenio_caixa_economica_federal.cod_banco = conta_corrente.cod_banco
              AND conta_corrente.cod_agencia = agencia.cod_agencia
              AND conta_corrente.cod_banco = agencia.cod_banco
              AND agencia.cod_banco = banco.cod_banco;";

        $pdo = $this->em->getConnection();
        $sth = $pdo->query($query);

        return $sth->fetch();
    }

    /**
    * @param int $exercicio
    * @return array
    */
    public function fetchNumSequencialArquivo($exercicio)
    {
        $query = "
            SELECT
              valor
            FROM
              administracao.configuracao
            WHERE
              parametro = :numSequencialArquivo
              AND exercicio = :exercicio
            LIMIT 1;";

        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue('numSequencialArquivo', $this::NUM_SEQUENCIAL_ARQUIVO_KEY);
        $sth->bindValue('exercicio', $exercicio);
        $sth->execute();

        return $sth->fetch(PDO::FETCH_COLUMN);
    }

    /**
    * @param int $exercicio
    * @return array
    */
    public function updateNumSequencialArquivo($exercicio)
    {
        $query = "
            UPDATE
              administracao.configuracao
            SET
              valor = (valor::int + 1)::text
            WHERE
              parametro = :numSequencialArquivo
              AND exercicio = :exercicio;";

        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue('numSequencialArquivo', $this::NUM_SEQUENCIAL_ARQUIVO_KEY);
        $sth->bindValue('exercicio', $exercicio);

        return $sth->execute();
    }

    /**
    * @param int $exercicio
    * @return array
    */
    public function fetchDadosEntidade($exercicio)
    {
        $query = "
            SELECT
              entidade.*,
              sw_cgm.*,
              sw_cgm_pessoa_juridica.*,
              publico.mascara_cpf_cnpj(
                sw_cgm_pessoa_juridica.cnpj, 'cnpj'
              ) as cnpj_formatado,
              sw_municipio.nom_municipio,
              sw_uf.sigla_uf
            FROM
              orcamento.entidade
            JOIN
              sw_cgm
              ON sw_cgm.numcgm = entidade.numcgm
            JOIN
              sw_cgm_pessoa_juridica
              ON sw_cgm_pessoa_juridica.numcgm = sw_cgm.numcgm
            JOIN
              sw_municipio
              ON sw_municipio.cod_uf = sw_cgm.cod_uf
              AND sw_municipio.cod_municipio = sw_cgm.cod_municipio
            JOIN
              sw_uf
              ON sw_uf.cod_uf = sw_cgm.cod_uf
            WHERE
              entidade.numcgm = sw_cgm.numcgm
              AND entidade.numcgm = sw_cgm_pessoa_juridica.numcgm
              AND entidade.cod_entidade = (
                select
                  valor
                from
                  administracao.configuracao
                where
                  cod_modulo = 8
                  and parametro = 'cod_entidade_prefeitura'
                  and exercicio = :exercicio
              )::int
              AND entidade.exercicio = :exercicio
            LIMIT 1;";

        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue('exercicio', $exercicio);
        $sth->execute();

        return $sth->fetch();
    }

    /**
    * @param array $filtro
    * @return array
    */
    public function fetchRemessaAtivos($filtro)
    {
        $query = "
            SELECT
              *
            FROM
              (
                SELECT
                  servidor_pensionista.*,
                  eventos_calculados.proventos,
                  eventos_calculados.descontos,
                  CASE WHEN eventos_calculados.proventos - eventos_calculados.descontos > 0 THEN
                    (
                      eventos_calculados.proventos - eventos_calculados.descontos
                    ) * :percentualAPagar ELSE 0 END as liquido,
                  'ativo' AS tipo
                FROM
                  (
                    SELECT
                      'S' as tipo_cadastro,
                      servidor.cod_contrato,
                      servidor.nom_cgm,
                      servidor.cpf,
                      servidor.registro,
                      servidor.nr_conta_salario as nr_conta,
                      servidor.num_banco_salario as num_banco,
                      servidor.cod_banco_salario as cod_banco,
                      servidor.num_agencia_salario as num_agencia,
                      servidor.cod_orgao,
                      servidor.cod_local,
                      servidor.desc_cargo as descricao_cargo,
                      servidor.desc_funcao as descricao_funcao
                    FROM
                      recuperarContratoServidor(
                        'cgm,cs,o,l,f,ca', '', :ultimoPeriodoMovimentacao, :tipoFiltro,
                        :valorFiltro, :exercicio
                      ) as servidor
                    WHERE
                      servidor.nr_conta_salario IS NOT NULL
                      AND servidor.num_banco_salario IS NOT NULL
                      AND servidor.cod_banco_salario IS NOT NULL
                      AND servidor.num_agencia_salario IS NOT NULL
                    UNION
                    SELECT
                      'P' as tipo_cadastro,
                      pensionista.cod_contrato,
                      pensionista.nom_cgm,
                      pensionista.cpf,
                      pensionista.registro,
                      pensionista.nr_conta_salario as nr_conta,
                      pensionista.num_banco_salario as num_banco,
                      pensionista.cod_banco_salario as cod_banco,
                      pensionista.num_agencia_salario as num_agencia,
                      pensionista.cod_orgao,
                      pensionista.cod_local,
                      null as descricao_cargo,
                      null as descricao_funcao
                    FROM
                      recuperarContratoPensionista(
                        'cgm,cs,o,l', '', :ultimoPeriodoMovimentacao, :tipoFiltro,
                        :valorFiltro, :exercicio
                      ) as pensionista
                  ) as servidor_pensionista
                  INNER JOIN (
                    SELECT
                      cod_contrato,
                      coalesce(
                        sum(proventos),
                        0
                      ) as proventos,
                      coalesce(
                        sum(descontos),
                        0
                      ) as descontos
                    FROM
                      (
                        SELECT
                          cod_contrato,
                          sum(valor) as proventos,
                          0 as descontos
                        FROM
                          recuperarEventosCalculados(
                            :tipoFolha, :ultimoPeriodoMovimentacao, 0, :folhaComplementar, '', 'evento.descricao'
                          ) as eventos_proventos
                        WHERE
                          eventos_proventos.natureza = 'P'
                          {desdobramento}
                        GROUP BY
                          eventos_proventos.cod_contrato
                        UNION
                        SELECT
                          cod_contrato,
                          0 as proventos,
                          sum(valor) as descontos
                        FROM
                          recuperarEventosCalculados(
                            :tipoFolha, :ultimoPeriodoMovimentacao, 0, :folhaComplementar, '', 'evento.descricao'
                          ) as eventos_descontos
                        WHERE
                          eventos_descontos.natureza = 'D'
                          {desdobramento}
                        GROUP BY
                          eventos_descontos.cod_contrato
                      ) as eventos_calculados_proventos_descontos_contrato
                    GROUP BY
                      cod_contrato
                  ) as eventos_calculados ON servidor_pensionista.cod_contrato = eventos_calculados.cod_contrato
              ) as remessa
            WHERE
              recuperarSituacaoDoContrato(remessa.cod_contrato, :ultimoPeriodoMovimentacao, '') = 'A'
              AND remessa.cod_banco = :codBanco
              AND (
                remessa.proventos - remessa.descontos
              ) BETWEEN :valoresLiquidosDe
              AND :valoresLiquidosAte
              AND remessa.liquido > 0
            ORDER BY
              nom_cgm;";

        $desdobramento = '';
        if (!empty($filtro['desdobramento'])) {
            $desdobramento = sprintf("AND desdobramento = '%d'", $filtro['desdobramento']);
        }

        $query = str_replace('{desdobramento}', $desdobramento, $query);

        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue('tipoFiltro', $filtro['tipoFiltro']);
        $sth->bindValue('valorFiltro', $filtro['valorFiltro']);
        $sth->bindValue('exercicio', explode('/', $filtro['competencia'])[1]);
        $sth->bindValue('tipoFolha', $filtro['tipoFolha']);
        $sth->bindValue('folhaComplementar', !empty($filtro['folhaComplementar']) ? (int) $filtro['folhaComplementar'] : 0);
        $sth->bindValue('codBanco', $filtro['codBanco']);
        $sth->bindValue('percentualAPagar', strtr($filtro['percentualAPagar'], '.,', "\0.") / 100);

        $valoresLiquidosDe = strtr($filtro['valoresLiquidosDe'], '.,', "\0.");
        $sth->bindValue('valoresLiquidosDe', $valoresLiquidosDe);

        $valoresLiquidosAte = strtr($filtro['valoresLiquidosAte'], '.,', "\0.");
        $sth->bindValue('valoresLiquidosAte', $valoresLiquidosAte);

        $ultimoPeriodoMovimentacao = $this->fetchUltimoPeriodoMovimentacao();
        $sth->bindValue('ultimoPeriodoMovimentacao', $ultimoPeriodoMovimentacao['cod_periodo_movimentacao']);

        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array $filtro
    * @return array
    */
    public function fetchRemessaAposentados($filtro)
    {
        $query = "
            SELECT
              *
            FROM
              (
                SELECT
                  servidor_pensionista.*,
                  eventos_calculados.proventos,
                  eventos_calculados.descontos,
                  CASE WHEN eventos_calculados.proventos - eventos_calculados.descontos > 0 THEN
                    (
                      eventos_calculados.proventos - eventos_calculados.descontos
                    ) * :percentualAPagar ELSE 0 END as liquido,
                  'ativo' AS tipo
                FROM
                  (
                    SELECT
                      'S' as tipo_cadastro,
                      servidor.cod_contrato,
                      servidor.nom_cgm,
                      servidor.cpf,
                      servidor.registro,
                      servidor.nr_conta_salario as nr_conta,
                      servidor.num_banco_salario as num_banco,
                      servidor.cod_banco_salario as cod_banco,
                      servidor.num_agencia_salario as num_agencia,
                      servidor.cod_orgao,
                      servidor.cod_local,
                      servidor.desc_cargo as descricao_cargo,
                      servidor.desc_funcao as descricao_funcao
                    FROM
                      recuperarContratoServidor(
                        'cgm,cs,o,l,f,ca', '', :ultimoPeriodoMovimentacao, :tipoFiltro,
                        :valorFiltro, :exercicio
                      ) as servidor
                    WHERE
                      servidor.nr_conta_salario IS NOT NULL
                      AND servidor.num_banco_salario IS NOT NULL
                      AND servidor.cod_banco_salario IS NOT NULL
                      AND servidor.num_agencia_salario IS NOT NULL
                    UNION
                    SELECT
                      'P' as tipo_cadastro,
                      pensionista.cod_contrato,
                      pensionista.nom_cgm,
                      pensionista.cpf,
                      pensionista.registro,
                      pensionista.nr_conta_salario as nr_conta,
                      pensionista.num_banco_salario as num_banco,
                      pensionista.cod_banco_salario as cod_banco,
                      pensionista.num_agencia_salario as num_agencia,
                      pensionista.cod_orgao,
                      pensionista.cod_local,
                      null as descricao_cargo,
                      null as descricao_funcao
                    FROM
                      recuperarContratoPensionista(
                        'cgm,cs,o,l', '', :ultimoPeriodoMovimentacao, :tipoFiltro,
                        :valorFiltro, :exercicio
                      ) as pensionista
                  ) as servidor_pensionista
                  INNER JOIN (
                    SELECT
                      cod_contrato,
                      coalesce(
                        sum(proventos),
                        0
                      ) as proventos,
                      coalesce(
                        sum(descontos),
                        0
                      ) as descontos
                    FROM
                      (
                        SELECT
                          cod_contrato,
                          sum(valor) as proventos,
                          0 as descontos
                        FROM
                          recuperarEventosCalculados(
                            :tipoFolha, :ultimoPeriodoMovimentacao, 0, :folhaComplementar, '', 'evento.descricao'
                          ) as eventos_proventos
                        WHERE
                          eventos_proventos.natureza = 'P'
                          {desdobramento}
                        GROUP BY
                          eventos_proventos.cod_contrato
                        UNION
                        SELECT
                          cod_contrato,
                          0 as proventos,
                          sum(valor) as descontos
                        FROM
                          recuperarEventosCalculados(
                            :tipoFolha, :ultimoPeriodoMovimentacao, 0, :folhaComplementar, '', 'evento.descricao'
                          ) as eventos_descontos
                        WHERE
                          eventos_descontos.natureza = 'D'
                          {desdobramento}
                        GROUP BY
                          eventos_descontos.cod_contrato
                      ) as eventos_calculados_proventos_descontos_contrato
                    GROUP BY
                      cod_contrato
                  ) as eventos_calculados ON servidor_pensionista.cod_contrato = eventos_calculados.cod_contrato
              ) as remessa
            WHERE
              recuperarSituacaoDoContrato(remessa.cod_contrato, :ultimoPeriodoMovimentacao, '') = 'P'
              AND remessa.cod_banco = :codBanco
              AND (
                remessa.proventos - remessa.descontos
              ) BETWEEN :valoresLiquidosDe
              AND :valoresLiquidosAte
              AND remessa.liquido > 0
            ORDER BY
              nom_cgm;";

        $desdobramento = '';
        if (!empty($filtro['desdobramento'])) {
            $desdobramento = sprintf("AND desdobramento = '%d'", $filtro['desdobramento']);
        }

        $query = str_replace('{desdobramento}', $desdobramento, $query);

        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue('tipoFiltro', $filtro['tipoFiltro']);
        $sth->bindValue('valorFiltro', $filtro['valorFiltro']);
        $sth->bindValue('exercicio', explode('/', $filtro['competencia'])[1]);
        $sth->bindValue('tipoFolha', $filtro['tipoFolha']);
        $sth->bindValue('folhaComplementar', !empty($filtro['folhaComplementar']) ? (int) $filtro['folhaComplementar'] : 0);
        $sth->bindValue('codBanco', $filtro['codBanco']);
        $sth->bindValue('percentualAPagar', strtr($filtro['percentualAPagar'], '.,', "\0.") / 100);

        $valoresLiquidosDe = strtr($filtro['valoresLiquidosDe'], '.,', "\0.");
        $sth->bindValue('valoresLiquidosDe', $valoresLiquidosDe);

        $valoresLiquidosAte = strtr($filtro['valoresLiquidosAte'], '.,', "\0.");
        $sth->bindValue('valoresLiquidosAte', $valoresLiquidosAte);

        $ultimoPeriodoMovimentacao = $this->fetchUltimoPeriodoMovimentacao();
        $sth->bindValue('ultimoPeriodoMovimentacao', $ultimoPeriodoMovimentacao['cod_periodo_movimentacao']);

        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array $filtro
    * @return array
    */
    public function fetchRemessaRescindidos($filtro)
    {
        $query = "
            SELECT
              *
            FROM
              (
                SELECT
                  servidor_pensionista.*,
                  eventos_calculados.proventos,
                  eventos_calculados.descontos,
                  CASE WHEN eventos_calculados.proventos - eventos_calculados.descontos > 0 THEN
                    (
                      eventos_calculados.proventos - eventos_calculados.descontos
                    ) * :percentualAPagar ELSE 0 END as liquido,
                  'ativo' AS tipo
                FROM
                  (
                    SELECT
                      'S' as tipo_cadastro,
                      servidor.cod_contrato,
                      servidor.nom_cgm,
                      servidor.cpf,
                      servidor.registro,
                      servidor.nr_conta_salario as nr_conta,
                      servidor.num_banco_salario as num_banco,
                      servidor.cod_banco_salario as cod_banco,
                      servidor.num_agencia_salario as num_agencia,
                      servidor.cod_orgao,
                      servidor.cod_local,
                      servidor.desc_cargo as descricao_cargo,
                      servidor.desc_funcao as descricao_funcao
                    FROM
                      recuperarContratoServidor(
                        'cgm,cs,o,l,f,ca', '', :ultimoPeriodoMovimentacao, :tipoFiltro,
                        :valorFiltro, :exercicio
                      ) as servidor
                    WHERE
                      servidor.nr_conta_salario IS NOT NULL
                      AND servidor.num_banco_salario IS NOT NULL
                      AND servidor.cod_banco_salario IS NOT NULL
                      AND servidor.num_agencia_salario IS NOT NULL
                    UNION
                    SELECT
                      'P' as tipo_cadastro,
                      pensionista.cod_contrato,
                      pensionista.nom_cgm,
                      pensionista.cpf,
                      pensionista.registro,
                      pensionista.nr_conta_salario as nr_conta,
                      pensionista.num_banco_salario as num_banco,
                      pensionista.cod_banco_salario as cod_banco,
                      pensionista.num_agencia_salario as num_agencia,
                      pensionista.cod_orgao,
                      pensionista.cod_local,
                      null as descricao_cargo,
                      null as descricao_funcao
                    FROM
                      recuperarContratoPensionista(
                        'cgm,cs,o,l', '', :ultimoPeriodoMovimentacao, :tipoFiltro,
                        :valorFiltro, :exercicio
                      ) as pensionista
                  ) as servidor_pensionista
                  INNER JOIN (
                    SELECT
                      cod_contrato,
                      coalesce(
                        sum(proventos),
                        0
                      ) as proventos,
                      coalesce(
                        sum(descontos),
                        0
                      ) as descontos
                    FROM
                      (
                        SELECT
                          cod_contrato,
                          sum(valor) as proventos,
                          0 as descontos
                        FROM
                          recuperarEventosCalculados(
                            :tipoFolha, :ultimoPeriodoMovimentacao, 0, :folhaComplementar, '', 'evento.descricao'
                          ) as eventos_proventos
                        WHERE
                          eventos_proventos.natureza = 'P'
                          {desdobramento}
                        GROUP BY
                          eventos_proventos.cod_contrato
                        UNION
                        SELECT
                          cod_contrato,
                          0 as proventos,
                          sum(valor) as descontos
                        FROM
                          recuperarEventosCalculados(
                            :tipoFolha, :ultimoPeriodoMovimentacao, 0, :folhaComplementar, '', 'evento.descricao'
                          ) as eventos_descontos
                        WHERE
                          eventos_descontos.natureza = 'D'
                          {desdobramento}
                        GROUP BY
                          eventos_descontos.cod_contrato
                      ) as eventos_calculados_proventos_descontos_contrato
                    GROUP BY
                      cod_contrato
                  ) as eventos_calculados ON servidor_pensionista.cod_contrato = eventos_calculados.cod_contrato
              ) as remessa
            WHERE
              recuperarSituacaoDoContrato(remessa.cod_contrato, :ultimoPeriodoMovimentacao, '') = 'R'
              AND remessa.cod_banco = :codBanco
              AND (
                remessa.proventos - remessa.descontos
              ) BETWEEN :valoresLiquidosDe
              AND :valoresLiquidosAte
              AND remessa.liquido > 0
            ORDER BY
              nom_cgm;";

        $desdobramento = '';
        if (!empty($filtro['desdobramento'])) {
            $desdobramento = sprintf("AND desdobramento = '%d'", $filtro['desdobramento']);
        }

        $query = str_replace('{desdobramento}', $desdobramento, $query);

        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue('tipoFiltro', $filtro['tipoFiltro']);
        $sth->bindValue('valorFiltro', $filtro['valorFiltro']);
        $sth->bindValue('exercicio', explode('/', $filtro['competencia'])[1]);
        $sth->bindValue('tipoFolha', $filtro['tipoFolha']);
        $sth->bindValue('folhaComplementar', !empty($filtro['folhaComplementar']) ? (int) $filtro['folhaComplementar'] : 0);
        $sth->bindValue('codBanco', $filtro['codBanco']);
        $sth->bindValue('percentualAPagar', strtr($filtro['percentualAPagar'], '.,', "\0.") / 100);

        $valoresLiquidosDe = strtr($filtro['valoresLiquidosDe'], '.,', "\0.");
        $sth->bindValue('valoresLiquidosDe', $valoresLiquidosDe);

        $valoresLiquidosAte = strtr($filtro['valoresLiquidosAte'], '.,', "\0.");
        $sth->bindValue('valoresLiquidosAte', $valoresLiquidosAte);

        $ultimoPeriodoMovimentacao = $this->fetchUltimoPeriodoMovimentacao();
        $sth->bindValue('ultimoPeriodoMovimentacao', $ultimoPeriodoMovimentacao['cod_periodo_movimentacao']);

        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array $filtro
    * @return array
    */
    public function fetchRemessaPensionistas($filtro)
    {
        $query = "
            SELECT
              *
            FROM
              (
                SELECT
                  servidor_pensionista.*,
                  eventos_calculados.proventos,
                  eventos_calculados.descontos,
                  CASE WHEN eventos_calculados.proventos - eventos_calculados.descontos > 0 THEN
                    (
                      eventos_calculados.proventos - eventos_calculados.descontos
                    ) * :percentualAPagar ELSE 0 END as liquido,
                  'ativo' AS tipo
                FROM
                  (
                    SELECT
                      'S' as tipo_cadastro,
                      servidor.cod_contrato,
                      servidor.nom_cgm,
                      servidor.cpf,
                      servidor.registro,
                      servidor.nr_conta_salario as nr_conta,
                      servidor.num_banco_salario as num_banco,
                      servidor.cod_banco_salario as cod_banco,
                      servidor.num_agencia_salario as num_agencia,
                      servidor.cod_orgao,
                      servidor.cod_local,
                      servidor.desc_cargo as descricao_cargo,
                      servidor.desc_funcao as descricao_funcao
                    FROM
                      recuperarContratoServidor(
                        'cgm,cs,o,l,f,ca', '', :ultimoPeriodoMovimentacao, :tipoFiltro,
                        :valorFiltro, :exercicio
                      ) as servidor
                    WHERE
                      servidor.nr_conta_salario IS NOT NULL
                      AND servidor.num_banco_salario IS NOT NULL
                      AND servidor.cod_banco_salario IS NOT NULL
                      AND servidor.num_agencia_salario IS NOT NULL
                    UNION
                    SELECT
                      'P' as tipo_cadastro,
                      pensionista.cod_contrato,
                      pensionista.nom_cgm,
                      pensionista.cpf,
                      pensionista.registro,
                      pensionista.nr_conta_salario as nr_conta,
                      pensionista.num_banco_salario as num_banco,
                      pensionista.cod_banco_salario as cod_banco,
                      pensionista.num_agencia_salario as num_agencia,
                      pensionista.cod_orgao,
                      pensionista.cod_local,
                      null as descricao_cargo,
                      null as descricao_funcao
                    FROM
                      recuperarContratoPensionista(
                        'cgm,cs,o,l', '', :ultimoPeriodoMovimentacao, :tipoFiltro,
                        :valorFiltro, :exercicio
                      ) as pensionista
                  ) as servidor_pensionista
                  INNER JOIN (
                    SELECT
                      cod_contrato,
                      coalesce(
                        sum(proventos),
                        0
                      ) as proventos,
                      coalesce(
                        sum(descontos),
                        0
                      ) as descontos
                    FROM
                      (
                        SELECT
                          cod_contrato,
                          sum(valor) as proventos,
                          0 as descontos
                        FROM
                          recuperarEventosCalculados(
                            :tipoFolha, :ultimoPeriodoMovimentacao, 0, :folhaComplementar, '', 'evento.descricao'
                          ) as eventos_proventos
                        WHERE
                          eventos_proventos.natureza = 'P'
                          {desdobramento}
                        GROUP BY
                          eventos_proventos.cod_contrato
                        UNION
                        SELECT
                          cod_contrato,
                          0 as proventos,
                          sum(valor) as descontos
                        FROM
                          recuperarEventosCalculados(
                            :tipoFolha, :ultimoPeriodoMovimentacao, 0, :folhaComplementar, '', 'evento.descricao'
                          ) as eventos_descontos
                        WHERE
                          eventos_descontos.natureza = 'D'
                          {desdobramento}
                        GROUP BY
                          eventos_descontos.cod_contrato
                      ) as eventos_calculados_proventos_descontos_contrato
                    GROUP BY
                      cod_contrato
                  ) as eventos_calculados ON servidor_pensionista.cod_contrato = eventos_calculados.cod_contrato
              ) as remessa
            WHERE
              recuperarSituacaoDoContrato(remessa.cod_contrato, :ultimoPeriodoMovimentacao, '') = 'E'
              AND remessa.cod_banco = :codBanco
              AND (
                remessa.proventos - remessa.descontos
              ) BETWEEN :valoresLiquidosDe
              AND :valoresLiquidosAte
              AND remessa.liquido > 0
            ORDER BY
              nom_cgm;";

        $desdobramento = '';
        if (!empty($filtro['desdobramento'])) {
            $desdobramento = sprintf("AND desdobramento = '%d'", $filtro['desdobramento']);
        }

        $query = str_replace('{desdobramento}', $desdobramento, $query);

        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue('tipoFiltro', $filtro['tipoFiltro']);
        $sth->bindValue('valorFiltro', $filtro['valorFiltro']);
        $sth->bindValue('exercicio', explode('/', $filtro['competencia'])[1]);
        $sth->bindValue('tipoFolha', $filtro['tipoFolha']);
        $sth->bindValue('folhaComplementar', !empty($filtro['folhaComplementar']) ? (int) $filtro['folhaComplementar'] : 0);
        $sth->bindValue('codBanco', $filtro['codBanco']);
        $sth->bindValue('percentualAPagar', strtr($filtro['percentualAPagar'], '.,', "\0.") / 100);

        $valoresLiquidosDe = strtr($filtro['valoresLiquidosDe'], '.,', "\0.");
        $sth->bindValue('valoresLiquidosDe', $valoresLiquidosDe);

        $valoresLiquidosAte = strtr($filtro['valoresLiquidosAte'], '.,', "\0.");
        $sth->bindValue('valoresLiquidosAte', $valoresLiquidosAte);

        $ultimoPeriodoMovimentacao = $this->fetchUltimoPeriodoMovimentacao();
        $sth->bindValue('ultimoPeriodoMovimentacao', $ultimoPeriodoMovimentacao['cod_periodo_movimentacao']);

        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array $filtro
    * @return array
    */
    public function fetchRemessaEstagiarios($filtro)
    {
        $query = "
            SELECT
              *
            FROM
              (
                SELECT
                  estagiario_estagio.*,
                  sw_cgm.nom_cgm,
                  sw_cgm_pessoa_fisica.cpf,
                  (
                    SELECT
                      num_banco
                    FROM
                      monetario.banco
                    where
                      banco.cod_banco = estagiario_estagio_conta.cod_banco
                  ) AS num_banco,
                  estagiario_estagio_conta.cod_banco,
                  (
                    SELECT
                      num_agencia
                    FROM
                      monetario.agencia
                    WHERE
                      agencia.cod_banco = estagiario_estagio_conta.cod_banco
                      AND agencia.cod_agencia = estagiario_estagio_conta.cod_agencia
                  ) AS num_agencia,
                  estagiario_estagio_conta.cod_agencia,
                  estagiario_estagio_conta.num_conta,
                  coalesce(
                    estagiario_estagio_bolsa.vl_bolsa,
                    0
                  ) AS proventos,
                  CASE WHEN estagiario_estagio_bolsa.faltas > 0 THEN (
                    coalesce(
                      estagiario_estagio_bolsa.vl_bolsa,
                      0
                    )/ 30
                  )* estagiario_estagio_bolsa.faltas + coalesce(
                    estagiario_vale_refeicao.vl_desconto,
                    0
                  ) ELSE coalesce(
                    estagiario_vale_refeicao.vl_desconto,
                    0
                  ) END AS descontos,
                  CASE WHEN estagiario_estagio_bolsa.faltas > 0 THEN (
                    (
                      coalesce(
                        estagiario_estagio_bolsa.vl_bolsa,
                        0
                      )+ coalesce(
                        estagiario_vale_refeicao.vl_vale,
                        0
                      ) - (
                        (
                          coalesce(
                            estagiario_estagio_bolsa.vl_bolsa,
                            0
                          )/ 30
                        )* estagiario_estagio_bolsa.faltas
                      ) - coalesce(
                        estagiario_vale_refeicao.vl_desconto,
                        0
                      )
                    ) * :percentualAPagar
                  ) ELSE (
                    (
                      coalesce(
                        estagiario_estagio_bolsa.vl_bolsa,
                        0
                      )+ coalesce(
                        estagiario_vale_refeicao.vl_vale,
                        0
                      ) - coalesce(
                        estagiario_vale_refeicao.vl_desconto,
                        0
                      )
                    ) * :percentualAPagar
                  ) END AS liquido,
                  estagiario_estagio_bolsa.faltas,
                  estagiario_estagio_local.cod_local,
                  'estagiario' AS tipo
                FROM
                  estagio.estagiario_estagio
                  {atributoEstagio}
                  LEFT JOIN estagio.estagiario_estagio_conta ON estagiario_estagio.cod_estagio = estagiario_estagio_conta.cod_estagio
                  AND estagiario_estagio.cgm_estagiario = estagiario_estagio_conta.numcgm
                  AND estagiario_estagio.cod_curso = estagiario_estagio_conta.cod_curso
                  AND estagiario_estagio.cgm_instituicao_ensino = estagiario_estagio_conta.cgm_instituicao_ensino
                  LEFT JOIN estagio.estagiario_estagio_local ON estagiario_estagio.cod_estagio = estagiario_estagio_local.cod_estagio
                  AND estagiario_estagio.cgm_estagiario = estagiario_estagio_local.numcgm
                  AND estagiario_estagio.cod_curso = estagiario_estagio_local.cod_curso
                  AND estagiario_estagio.cgm_instituicao_ensino = estagiario_estagio_local.cgm_instituicao_ensino
                  LEFT JOIN (
                    SELECT
                      estagiario_estagio_bolsa.*
                    FROM
                      estagio.estagiario_estagio_bolsa,
                      (
                        SELECT
                          cod_estagio,
                          cod_curso,
                          cgm_estagiario,
                          cgm_instituicao_ensino,
                          max(timestamp) as timestamp
                        FROM
                          estagio.estagiario_estagio_bolsa
                        GROUP BY
                          cod_estagio,
                          cod_curso,
                          cgm_estagiario,
                          cgm_instituicao_ensino
                      ) AS max_estagiario_estagio_bolsa
                    WHERE
                      estagiario_estagio_bolsa.cod_estagio = max_estagiario_estagio_bolsa.cod_estagio
                      AND estagiario_estagio_bolsa.cod_curso = max_estagiario_estagio_bolsa.cod_curso
                      AND estagiario_estagio_bolsa.cgm_estagiario = max_estagiario_estagio_bolsa.cgm_estagiario
                      AND estagiario_estagio_bolsa.cgm_instituicao_ensino = max_estagiario_estagio_bolsa.cgm_instituicao_ensino
                      AND estagiario_estagio_bolsa.timestamp = max_estagiario_estagio_bolsa.timestamp
                  ) AS estagiario_estagio_bolsa ON estagiario_estagio.cod_estagio = estagiario_estagio_bolsa.cod_estagio
                  AND estagiario_estagio.cgm_estagiario = estagiario_estagio_bolsa.cgm_estagiario
                  AND estagiario_estagio.cod_curso = estagiario_estagio_bolsa.cod_curso
                  AND estagiario_estagio.cgm_instituicao_ensino = estagiario_estagio_bolsa.cgm_instituicao_ensino
                  LEFT JOIN estagio.estagiario_vale_refeicao ON estagiario_vale_refeicao.cod_estagio = estagiario_estagio_bolsa.cod_estagio
                  AND estagiario_vale_refeicao.cod_curso = estagiario_estagio_bolsa.cod_curso
                  AND estagiario_vale_refeicao.cgm_estagiario = estagiario_estagio_bolsa.cgm_estagiario
                  AND estagiario_vale_refeicao.cgm_instituicao_ensino = estagiario_estagio_bolsa.cgm_instituicao_ensino
                  AND estagiario_vale_refeicao.timestamp = estagiario_estagio_bolsa.timestamp,
                  estagio.curso_instituicao_ensino,
                  sw_cgm,
                  sw_cgm_pessoa_fisica
                WHERE
                  estagiario_estagio.cgm_estagiario = sw_cgm.numcgm
                  AND sw_cgm.numcgm = sw_cgm_pessoa_fisica.numcgm
                  AND estagiario_estagio.cod_curso = curso_instituicao_ensino.cod_curso
                  AND estagiario_estagio.cgm_instituicao_ensino = curso_instituicao_ensino.numcgm
                  AND (
                    estagiario_estagio.dt_final IS NULL
                    OR estagiario_estagio.dt_final >= (
                      SELECT
                        dt_inicial
                      FROM
                        folhapagamento.periodo_movimentacao
                      WHERE
                        cod_periodo_movimentacao = :ultimoPeriodoMovimentacao
                    )
                  )
              ) AS remessa
            WHERE
              remessa.cod_banco = :codBanco
              AND (
                remessa.proventos - remessa.descontos
              ) BETWEEN :valoresLiquidosDe
              AND :valoresLiquidosAte
              AND remessa.liquido > 0
              {codEstagio}
              {lotacao}
              {codLocal}
            ORDER BY
              nom_cgm;";

        $atributoEstagio = '';
        $codEstagio = '';
        $lotacao = '';
        $codLocal = '';

        if ($filtro['tipoFiltro'] == ExportarPagamentoCaixaAdmin::TIPO_FILTRO_ATRIBUTO_DINAMICO_ESTAGIARIO) {
            $atributoEstagio = sprintf("INNER JOIN estagio.atributo_estagiario_estagio
                    ON estagiario_estagio.cod_estagio = atributo_estagiario_estagio.cod_estagio
                   AND estagiario_estagio.cgm_estagiario = atributo_estagiario_estagio.numcgm
                   AND estagiario_estagio.cod_curso = atributo_estagiario_estagio.cod_curso
                   AND estagiario_estagio.cgm_instituicao_ensino = atributo_estagiario_estagio.cgm_instituicao_ensino
                   AND atributo_estagiario_estagio.cod_atributo = %d
                   AND atributo_estagiario_estagio.valor = '%s'", $filtro['codAtributo'], $filtro['valorAtributo']);
        }

        if ($filtro['tipoFiltro'] == ExportarPagamentoCaixaAdmin::TIPO_FILTRO_CODIGO_ESTAGIO) {
            $codEstagio = !empty($filtro['estagios']) ? array_column($filtro['estagios'], 'codEstagio') : [0];
            $codEstagio = sprintf('AND numero_estagio IN (%s)', implode(',', $codEstagio));
        }

        if ($filtro['tipoFiltro'] == ExportarPagamentoCaixaAdmin::TIPO_FILTRO_LOTACAO) {
            $lotacao = sprintf('AND cod_orgao IN (%s)', implode(',', $filtro['valorFiltro']));
        }

        if ($filtro['tipoFiltro'] == ExportarPagamentoCaixaAdmin::TIPO_FILTRO_LOCAL) {
            $codLocal = sprintf('AND cod_local in (%s)', implode(',', $filtro['valorFiltro']));
        }

        $query = strtr($query, ['{atributoEstagio}' => $atributoEstagio, '{codEstagio}' => $codEstagio, '{lotacao}' => $lotacao, '{codLocal}' => $codLocal]);

        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue('codBanco', $filtro['codBanco']);
        $sth->bindValue('percentualAPagar', strtr($filtro['percentualAPagar'], '.,', "\0.") / 100);

        $valoresLiquidosDe = strtr($filtro['valoresLiquidosDe'], '.,', "\0.");
        $sth->bindValue('valoresLiquidosDe', $valoresLiquidosDe);

        $valoresLiquidosAte = strtr($filtro['valoresLiquidosAte'], '.,', "\0.");
        $sth->bindValue('valoresLiquidosAte', $valoresLiquidosAte);

        $ultimoPeriodoMovimentacao = $this->fetchUltimoPeriodoMovimentacao();
        $sth->bindValue('ultimoPeriodoMovimentacao', $ultimoPeriodoMovimentacao['cod_periodo_movimentacao']);

        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array $filtro
    * @return array
    */
    public function fetchRemessaPensaoJudicial($filtro)
    {
        $query = "
            SELECT
              *
            FROM
              (
                SELECT
                  dependentes_calculados.cod_contrato,
                  CASE WHEN responsavel_legal.numcgm IS NULL THEN (
                    SELECT
                      nom_cgm
                    FROM
                      sw_cgm
                    WHERE
                      numcgm = dependente.numcgm
                  ) ELSE (
                    SELECT
                      nom_cgm
                    FROM
                      sw_cgm
                    WHERE
                      numcgm = responsavel_legal.numcgm
                  ) END as nom_cgm,
                  CASE WHEN responsavel_legal.numcgm IS NULL THEN (
                    SELECT
                      cpf
                    FROM
                      sw_cgm_pessoa_fisica
                    WHERE
                      numcgm = dependente.numcgm
                  ) ELSE (
                    SELECT
                      cpf
                    FROM
                      sw_cgm_pessoa_fisica
                    WHERE
                      numcgm = responsavel_legal.numcgm
                  ) END as cpf,
                  dependente.numcgm as numcgm_dependente,
                  responsavel_legal.numcgm as numcgm_responsavel_legal,
                  dependentes_calculados.cod_dependente,
                  contrato_servidor.registro,
                  agencia.num_agencia,
                  agencia.cod_agencia,
                  banco.num_banco,
                  banco.cod_banco,
                  pensao_banco.conta_corrente as nr_conta,
                  dependentes_calculados.valor as proventos,
                  0 as descontos,
                  (
                    (dependentes_calculados.valor) * :percentualAPagar
                  ) as liquido,
                  contrato_servidor.cod_orgao,
                  contrato_servidor.cod_local,
                  'pensao-judicial' AS tipo
                FROM
                  (
                    SELECT
                      registro,
                      cod_contrato,
                      cod_orgao,
                      cod_local,
                      cod_servidor
                    FROM
                      recuperarContratoServidor('l,o', '', :ultimoPeriodoMovimentacao, 'geral', '', :exercicio)
                  ) as contrato_servidor
                  INNER JOIN pessoal.servidor_dependente ON servidor_dependente.cod_servidor = contrato_servidor.cod_servidor
                  INNER JOIN (
                    SELECT
                      *
                    FROM
                      recuperarEventosCalculadosDependentes(:tipoFolha, :ultimoPeriodoMovimentacao, 0, 0, :folhaComplementar, '', '')
                      {desdobramento}
                  ) as dependentes_calculados ON contrato_servidor.cod_contrato = dependentes_calculados.cod_contrato
                  AND servidor_dependente.cod_dependente = dependentes_calculados.cod_dependente
                  INNER JOIN pessoal.dependente ON dependente.cod_dependente = servidor_dependente.cod_dependente
                  INNER JOIN (
                    SELECT
                      pensao.*
                    FROM
                      pessoal.pensao,
                      (
                        SELECT
                          cod_pensao,
                          MAX(timestamp) AS timestamp
                        FROM
                          pessoal.pensao
                        WHERE
                          pensao.timestamp <= ultimoTimestampPeriodoMovimentacao(:ultimoPeriodoMovimentacao, ''):: timestamp
                        GROUP BY
                          cod_pensao
                      ) AS max_pensao
                    WHERE
                      pensao.cod_pensao = max_pensao.cod_pensao
                      AND pensao.timestamp = max_pensao.timestamp
                      AND NOT EXISTS (
                        SELECT
                          1
                        FROM
                          pessoal.pensao_excluida
                        WHERE
                          pensao_excluida.cod_pensao = max_pensao.cod_pensao
                          AND max_pensao.timestamp <= pensao_excluida.timestamp
                      )
                  ) as pensao ON dependente.cod_dependente = pensao.cod_dependente
                  INNER JOIN pessoal.pensao_banco ON pensao_banco.cod_pensao = pensao.cod_pensao
                  AND pensao_banco.timestamp = pensao.timestamp
                  INNER JOIN monetario.banco ON pensao_banco.cod_banco = banco.cod_banco
                  INNER JOIN monetario.agencia ON pensao_banco.cod_agencia = agencia.cod_agencia
                  AND pensao_banco.cod_banco = agencia.cod_banco
                  LEFT JOIN pessoal.responsavel_legal ON responsavel_legal.cod_pensao = pensao.cod_pensao
                  AND responsavel_legal.timestamp = pensao.timestamp
              ) as remessa
            WHERE
              remessa.cod_banco = :codBanco
              AND (
                remessa.proventos - remessa.descontos
              ) BETWEEN :valoresLiquidosDe
              AND :valoresLiquidosAte
              AND remessa.liquido > 0
              {numcgmDependente}
              {codContratoServidor}
            ORDER BY
              nom_cgm;";

        $desdobramento = '';
        $numcgmDependente = '';
        $codContratoServidor = '';

        if (!empty($filtro['desdobramento'])) {
            $desdobramento = sprintf("AND desdobramento = '%d'", $filtro['desdobramento']);
        }

        if ($filtro['tipoFiltro'] == ExportarPagamentoCaixaAdmin::TIPO_FILTRO_CGM_DEPENDENTE_PENSAO) {
            $cgms = !empty($filtro['cgms']) ? array_column($filtro['cgms'], 'numcgm') : [0];
            $numcgmDependente = sprintf('AND numcgm_dependente IN (%s)', implode(',', $cgms));
        }

        if ($filtro['tipoFiltro'] == ExportarPagamentoCaixaAdmin::TIPO_FILTRO_CGM_MATRICULA_SERVIDOR) {
            $cgmMatriculas = !empty($filtro['cgmMatriculas']) ? array_column($filtro['cgmMatriculas'], 'codContrato') : [0];
            $codContratoServidor = sprintf('AND cod_contrato IN (%s)', implode(',', $cgmMatriculas));
        }

        $query = strtr($query, ['{desdobramento}' => $desdobramento, '{numcgmDependente}' => $numcgmDependente, '{codContratoServidor}' => $codContratoServidor]);

        $pdo = $this->em->getConnection();
        $sth = $pdo->prepare($query);
        $sth->bindValue('exercicio', explode('/', $filtro['competencia'])[1]);
        $sth->bindValue('tipoFolha', $filtro['tipoFolha']);
        $sth->bindValue('folhaComplementar', !empty($filtro['folhaComplementar']) ? (int) $filtro['folhaComplementar'] : 0);
        $sth->bindValue('codBanco', $filtro['codBanco']);
        $sth->bindValue('percentualAPagar', strtr($filtro['percentualAPagar'], '.,', "\0.") / 100);

        $valoresLiquidosDe = strtr($filtro['valoresLiquidosDe'], '.,', "\0.");
        $sth->bindValue('valoresLiquidosDe', $valoresLiquidosDe);

        $valoresLiquidosAte = strtr($filtro['valoresLiquidosAte'], '.,', "\0.");
        $sth->bindValue('valoresLiquidosAte', $valoresLiquidosAte);

        $ultimoPeriodoMovimentacao = $this->fetchUltimoPeriodoMovimentacao();
        $sth->bindValue('ultimoPeriodoMovimentacao', $ultimoPeriodoMovimentacao['cod_periodo_movimentacao']);

        $sth->execute();

        return $sth->fetchAll();
    }
}
