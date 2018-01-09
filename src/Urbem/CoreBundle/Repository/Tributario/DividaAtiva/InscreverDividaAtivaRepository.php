<?php

namespace Urbem\CoreBundle\Repository\Tributario\DividaAtiva;

use DateTime;
use PDO;
use Doctrine\ORM\EntityManagerInterface;

class InscreverDividaAtivaRepository
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
    * @param int $codModalidade
    * @return array
    */
    public function fetchModalidades($codModalidade)
    {
        $query = "
            SELECT
              dm.cod_modalidade,
              dm.ativa,
              dm.descricao,
              dtm.descricao as descricao_tipo_modalidade,
              dfi.cod_forma_inscricao,
              to_char(
                dmv.vigencia_inicial, 'dd/mm/YYYY'
              ) AS vigencia_inicial,
              to_char(
                dmv.vigencia_final, 'dd/mm/YYYY'
              ) AS vigencia_final,
              dmv.cod_biblioteca,
              dmv.cod_modulo,
              dmv.cod_norma,
              dmv.cod_tipo_modalidade,
              dmv.cod_funcao as cod_funcao_vigencia,
              dmv.nom_funcao as nom_funcao_vigencia,
              dmv.timestamp,
              dmr.percentual as percentual_reducao,
              dmr.valor as valor_reducao,
              dmr.cod_funcao as cod_funcao_reducao,
              dmr.nom_funcao as funcao_reducao,
              dmp.num_regra as num_regra_parcela,
              dmp.vlr_limite_inicial as limite_inicial,
              dmp.vlr_limite_final as limite_final,
              dmp.qtd_parcela,
              dmp.vlr_minimo,
              dmd.cod_documento,
              dmd.cod_tipo_documento,
              dfi.cod_forma_inscricao,
              dfi.descricao as descricao_forma_inscricao
            FROM
              divida.modalidade AS dm
              INNER JOIN (
                select
                  dmv.cod_modalidade,
                  dmv.timestamp,
                  dmv.cod_forma_inscricao,
                  dmv.cod_biblioteca,
                  dmv.cod_modulo,
                  dmv.cod_norma,
                  dmv.cod_tipo_modalidade,
                  dmv.vigencia_inicial,
                  dmv.vigencia_final,
                  af.cod_funcao,
                  af.nom_funcao
                from
                  divida.modalidade_vigencia AS dmv
                  INNER JOIN administracao.funcao as af ON dmv.cod_funcao = af.cod_funcao
                  AND dmv.cod_modulo = af.cod_modulo
                  AND dmv.cod_biblioteca = af.cod_biblioteca
              ) as dmv ON dmv.cod_modalidade = dm.cod_modalidade
              AND dmv.timestamp = dm.ultimo_timestamp
              INNER JOIN divida.tipo_modalidade as dtm ON dtm.cod_tipo_modalidade = dmv.cod_tipo_modalidade
              INNER JOIN divida.forma_inscricao as dfi ON dfi.cod_forma_inscricao = dmv.cod_forma_inscricao
              LEFT JOIN (
                select
                  dmr.cod_modalidade,
                  dmr.timestamp,
                  dmr.percentual,
                  dmr.valor,
                  af.cod_funcao,
                  af.nom_funcao
                from
                  divida.modalidade_reducao as dmr
                  INNER JOIN administracao.funcao as af ON dmr.cod_funcao = af.cod_funcao
                  AND dmr.cod_modulo = af.cod_modulo
                  AND dmr.cod_biblioteca = af.cod_biblioteca
              ) as dmr ON dmr.cod_modalidade = dm.cod_modalidade
              and dmr.timestamp = dm.ultimo_timestamp
              LEFT JOIN divida.modalidade_parcela as dmp ON dmp.cod_modalidade = dm.cod_modalidade
              AND dmp.timestamp = dm.ultimo_timestamp
              INNER JOIN divida.modalidade_documento as dmd ON dmd.cod_modalidade = dm.cod_modalidade
              AND dmd.timestamp = dm.ultimo_timestamp
            WHERE
              dm.cod_modalidade = :codModalidade;";

        $pdo = $this->em->getConnection();

        $sth = $pdo->prepare($query);

        $sth->bindValue('codModalidade', $codModalidade, PDO::PARAM_INT);

        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array $filtro
    * @return array
    */
    public function fetchDividas(array $filtro = [])
    {
        $query = "
            SELECT
              *
            FROM
              divida.fn_lista_divida_arrecadacao (
                :grupoCreditoAnoExercicio,
                :grupoCreditoCodGrupo,
                :creditoCodCredito,
                :creditoCodEspecie,
                :creditoCodGenero,
                :creditoCodNatureza,
                :cgmInicial,
                :cgmFinal,
                :inscricaoImobiliariaInicial,
                :inscricaoImobiliariaFinal,
                :cadastroEconomicoInicial,
                :cadastroEconomicoFinal,
                :periodoInicial,
                :periodoFinal,
                :valorInicial,
                :valorFinal,
                :exercicio
              ) AS lista_dividas (
                valor_aberto numeric, valor_lancamento numeric,
                cod_lancamento int, numcgm int, nom_cgm varchar,
                vinculo varchar, id_vinculo varchar,
                inscricao int, tipo_inscricao varchar,
                vencimento_base date, vencimento_base_br varchar,
                timestamp_venal timestamp, nro_parcelas int,
                situacao_lancamento varchar
              )
              ORDER BY
                numcgm;";

        $codGrupo = 0;
        $anoExercicio = 0;
        if ($filtro['grupoCredito']) {
            list($codGrupo, $anoExercicio) = explode('~', $filtro['grupoCredito']);
        }

        $codCredito = 0;
        $codNatureza = 0;
        $codGenero = 0;
        $codEspecie = 0;
        if ($filtro['credito']) {
            list($codCredito, $codNatureza, $codGenero, $codEspecie) = explode('~', $filtro['credito']);
        }

        $pdo = $this->em->getConnection();

        $sth = $pdo->prepare($query);

        $sth->bindValue('grupoCreditoAnoExercicio', (int) $anoExercicio);
        $sth->bindValue('grupoCreditoCodGrupo', (int) $codGrupo);
        $sth->bindValue('creditoCodCredito', (int) $codCredito);
        $sth->bindValue('creditoCodEspecie', (int) $codEspecie);
        $sth->bindValue('creditoCodGenero', (int) $codGenero);
        $sth->bindValue('creditoCodNatureza', (int) $codNatureza);
        $sth->bindValue('cgmInicial', (int) $filtro['cgmInicial']);
        $sth->bindValue('cgmFinal', (int) $filtro['cgmFinal']);
        $sth->bindValue('inscricaoImobiliariaInicial', (int) $filtro['inscricaoMunicipalInicial']);
        $sth->bindValue('inscricaoImobiliariaFinal', (int) $filtro['inscricaoMunicipalFinal']);
        $sth->bindValue('cadastroEconomicoInicial', (int) $filtro['cadastroEconomicoInicial']);
        $sth->bindValue('cadastroEconomicoFinal', (int) $filtro['cadastroEconomicoFinal']);
        $sth->bindValue('periodoInicial', $filtro['periodoInicial'] ? (new DateTime())->createFromFormat('d/m/Y', $filtro['periodoInicial'])->format('Y-m-d') : '');
        $sth->bindValue('periodoFinal', $filtro['periodoFinal'] ? (new DateTime())->createFromFormat('d/m/Y', $filtro['periodoFinal'])->format('Y-m-d') : '');
        $sth->bindValue('valorInicial', (int) ($filtro['valorInicial'] ?: 0));
        $sth->bindValue('valorFinal', (int) ($filtro['valorFinal'] ?: 999999999999));
        $sth->bindValue('exercicio', $filtro['exercicio']);

        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @return array
    */
    public function fetchAutoridades()
    {
        $query = "
            SELECT
              ps.numcgm,
              sc.nom_cgm
            FROM
              pessoal.servidor AS ps
              INNER JOIN sw_cgm AS sc ON sc.numcgm = ps.numcgm
              INNER JOIN divida.autoridade AS da ON da.numcgm = ps.numcgm
              INNER JOIN pessoal.contrato AS pc ON pc.cod_contrato = da.cod_contrato
              INNER JOIN pessoal.contrato_servidor AS pcs ON pcs.cod_contrato = da.cod_contrato
              INNER JOIN pessoal.cargo AS pca ON pca.cod_cargo = pcs.cod_cargo
              LEFT JOIN divida.procurador AS dp ON dp.cod_autoridade = da.cod_autoridade
            ORDER BY
              ps.numcgm;";

        $pdo = $this->em->getConnection();

        $sth = $pdo->query($query);

        return $sth->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    /**
    * @return array
    */
    public function fetchLivro()
    {
        $query = "
            SELECT
              livros[2] AS num_livro,
              livros[3] AS num_folha,
              livros[4] AS exercicio_livro
            FROM
              regexp_split_to_array(
                divida.fn_busca_livro_pagina(),
                '-'
              ) as livros;";

        $pdo = $this->em->getConnection();

        $sth = $pdo->query($query);

        return $sth->fetch();
    }

    /**
    * @param int $codLancamento
    * @return array
    */
    public function fetchLancamentoCalculos(int $codLancamento)
    {
        $query = "
            SELECT
              cod_calculo,
              cod_lancamento,
              TO_CHAR(dt_lancamento, 'dd/mm/yyyy') AS dt_lancamento,
              valor
            FROM
              arrecadacao.lancamento_calculo
            WHERE
              cod_lancamento = :codLancamento;";

        $pdo = $this->em->getConnection();

        $sth = $pdo->prepare($query);

        $sth->bindValue('codLancamento', $codLancamento, PDO::PARAM_INT);

        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array $codCalculos
    * @return array
    */
    public function fetchCalculo(array $codCalculos = [])
    {
        $query = "
            SELECT
              cod_calculo,
              cod_credito,
              cod_natureza,
              cod_genero,
              cod_especie,
              exercicio,
              valor,
              nro_parcelas,
              ativo,
              simulado,
              TO_CHAR(
                timestamp, 'yyyy-mm-dd hh24:mi:ss.us'
              ) AS timestamp,
              calculado
            FROM
              arrecadacao.calculo
            WHERE
              cod_calculo IN ({codCalculos});";

        $pdo = $this->em->getConnection();

        if (!$codCalculos) {
            $codCalculos = [0];
        }

        $query = str_replace('{codCalculos}', implode(',', $codCalculos), $query);

        $sth = $pdo->query($query);

        return $sth->fetch();
    }

    /**
    * @param int $codLancamento
    * @return array
    */
    public function fetchParcelasDivida(int $codLancamento)
    {
        $query = "
            SELECT
              *
            FROM
              divida.fn_recupera_parcelas_divida_lancamento(:codLancamento) as lista_parcelas_divida (
                numeracao varchar, cod_convenio int,
                exercicio int, cod_parcela int, cod_calculo int,
                cod_lancamento int, nr_parcela int,
                cod_credito int, descricao_credito varchar,
                cod_natureza int, cod_genero int,
                cod_especie int, valor numeric, valor_exato numeric
              );";

        $pdo = $this->em->getConnection();

        $sth = $pdo->prepare($query);

        $sth->bindValue('codLancamento', $codLancamento, PDO::PARAM_INT);

        $sth->execute();

        return $sth->fetchAll();
    }

    /**
    * @param array $codParcelas
    * @return array
    */
    public function fetchCarnesParaCancelar(array $codParcelas = [])
    {
        $query = "
            SELECT
              numeracao,
              cod_convenio
            FROM
              arrecadacao.carne
              INNER JOIN arrecadacao.parcela ON parcela.cod_parcela = carne.cod_parcela
            WHERE
              parcela.cod_lancamento in (
                SELECT
                  DISTINCT cod_lancamento
                FROM
                  arrecadacao.parcela
                WHERE
                  parcela.cod_parcela IN ({codParcelas})
              )
              AND carne.numeracao NOT IN (
                SELECT
                  pagamento.numeracao
                FROM
                  arrecadacao.pagamento
                WHERE
                  pagamento.numeracao = carne.numeracao
                  AND pagamento.cod_convenio = carne.cod_convenio
              )
              AND carne.numeracao NOT IN (
                SELECT
                  carne_devolucao.numeracao
                FROM
                  arrecadacao.carne_devolucao
                WHERE
                  carne_devolucao.numeracao = carne.numeracao
                  AND carne_devolucao.cod_convenio = carne.cod_convenio
                  AND carne_devolucao.cod_motivo <> 10
              );";

        $pdo = $this->em->getConnection();

        if (!$codParcelas) {
            $codParcelas = [0];
        }

        $query = str_replace('{codParcelas}', implode(',', $codParcelas), $query);

        $sth = $pdo->query($query);

        return $sth->fetchAll();
    }

    /**
    * @param int $exercicio
    * @return array
    */
    public function fetchUltimoCodInscricao(int $exercicio)
    {
        $query = "
            SELECT
                COALESCE(divida.fn_busca_inscricao_divida(:exercicio), 0) + 1;";

        $pdo = $this->em->getConnection();

        $sth = $pdo->prepare($query);

        $sth->bindValue('exercicio', $exercicio, PDO::PARAM_INT);

        $sth->execute();

        return $sth->fetch(PDO::FETCH_COLUMN, 0);
    }

    /**
    * @param int $codAutoridade
    * @return array
    */
    public function fetchAutoridade(int $codAutoridade)
    {
        $query = "
            SELECT
              ps.numcgm,
              sc.nom_cgm,
              (ps.numcgm || ' - ' || sc.nom_cgm) as autoridade,
              da.cod_autoridade,
              da.cod_norma,
              (
                SELECT
                  no.nom_norma
                FROM
                  normas.norma AS no
                WHERE
                  no.cod_norma = da.cod_norma
              ) AS nom_norma,
              dp.oab,
              (
                SELECT
                  su.nom_uf
                FROM
                  sw_uf AS su
                WHERE
                  su.cod_uf = dp.cod_uf
              ) AS nom_uf,
              dp.cod_uf,
              CASE WHEN dp.cod_autoridade IS NOT NULL THEN 'Procurador Municipal' ELSE 'Autoridade Competente' END AS tipo,
              pc.registro,
              pca.descricao,
              (
                SELECT
                  to_char(pc.vigencia, 'dd/mm/YYYY')
                FROM
                  pessoal.contrato_servidor_funcao AS pc,
                  (
                    SELECT
                      MAX(pf.timestamp) AS timestamp
                    FROM
                      pessoal.contrato_servidor_funcao AS pf
                    WHERE
                      pf.cod_contrato = da.cod_contrato
                      AND pf.cod_cargo = pcs.cod_cargo
                  ) AS temp
                WHERE
                  pc.cod_contrato = da.cod_contrato
                  AND pc.cod_cargo = pcs.cod_cargo
                  AND pc.timestamp = temp.timestamp
              ) AS vigencia
            FROM
              pessoal.servidor AS ps
              INNER JOIN sw_cgm AS sc ON sc.numcgm = ps.numcgm
              INNER JOIN divida.autoridade AS da ON da.numcgm = ps.numcgm
              INNER JOIN pessoal.contrato AS pc ON pc.cod_contrato = da.cod_contrato
              INNER JOIN pessoal.contrato_servidor AS pcs ON pcs.cod_contrato = da.cod_contrato
              INNER JOIN pessoal.cargo AS pca ON pca.cod_cargo = pcs.cod_cargo
              LEFT JOIN divida.procurador AS dp ON dp.cod_autoridade = da.cod_autoridade
            WHERE
              da.cod_autoridade = :codAutoridade;";

        $pdo = $this->em->getConnection();

        $sth = $pdo->prepare($query);

        $sth->bindValue('codAutoridade', $codAutoridade, PDO::PARAM_INT);

        $sth->execute();

        return $sth->fetch();
    }

    /**
    * @return array
    */
    public function fetchUltimoNumParcelamento()
    {
        $query = "
            SELECT
                COALESCE(MAX(ddp.num_parcelamento), 0) + 1
            FROM
                divida.parcelamento AS ddp;";

        $pdo = $this->em->getConnection();

        $sth = $pdo->query($query);

        return $sth->fetch(PDO::FETCH_COLUMN, 0);
    }

    /**
    * @return null
    */
    public function lancarAcrescimos($exercicio, $codInscricao)
    {
        $query = "
            SELECT
                divida.fn_acrescimo_divida_individual(:exercicio, :codInscricao);";

        $pdo = $this->em->getConnection();

        $sth = $pdo->prepare($query);

        $sth->bindValue('exercicio', $exercicio);
        $sth->bindValue('codInscricao', $codInscricao, PDO::PARAM_INT);

        $sth->execute();
    }
}
