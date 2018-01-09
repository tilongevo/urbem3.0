<?php

namespace Urbem\CoreBundle\Repository\Ldo;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Ppa\Ppa;

class LdoRepository extends ORM\EntityRepository
{
    public function listDividasLDO($ppa, $ano)
    {
        $sql = sprintf(
            "SELECT ordem
                , cod_tipo
                , especificacao
                , bo_orcamento_1
                , bo_orcamento_2
                , bo_orcamento_3
                , bo_orcamento_4
                , bo_orcamento_5
                , bo_orcamento_6
                , valor_1
                , valor_2
                , valor_3
                , valor_4
                , valor_5
                , valor_6
                , exercicio_1
                , exercicio_2
                , exercicio_3
                , exercicio_4
                , exercicio_5
                , exercicio_6
            FROM ldo.evolucao_divida(%d, '%s') AS (
                  ordem             INTEGER
                , cod_tipo          INTEGER
                , especificacao     VARCHAR
                , valor_1           DECIMAL(14,2)
                , valor_2           DECIMAL(14,2)
                , valor_3           DECIMAL(14,2)
                , valor_4           DECIMAL(14,2)
                , valor_5           DECIMAL(14,2)
                , valor_6           DECIMAL(14,2)
                , bo_orcamento_1    DECIMAL(1)
                , bo_orcamento_2    DECIMAL(1)
                , bo_orcamento_3    DECIMAL(1)
                , bo_orcamento_4    DECIMAL(1)
                , bo_orcamento_5    DECIMAL(1)
                , bo_orcamento_6    DECIMAL(1)
                , exercicio_1       CHAR(4)
                , exercicio_2       CHAR(4)
                , exercicio_3       CHAR(4)
                , exercicio_4       CHAR(4)
                , exercicio_5       CHAR(4)
                , exercicio_6       CHAR(4)
                ) ORDER BY ordem",
            $ppa->getCodPpa(),
            $ano
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function getReceitaConfiguracao($codPpa, $exercicio)
    {
        $sql = sprintf(
            "SELECT cod_tipo
                , exercicio
                , cod_estrutural
                , descricao
                , tipo
                , nivel
                , rpps
                , orcamento_1
                , orcamento_2
                , orcamento_3
                , orcamento_4
                , valor_1
                , valor_2
                , valor_3
                , valor_4
            FROM ldo.fn_receita_configuracao(%d, '%s') AS (
                  cod_tipo         INTEGER,
                  exercicio        VARCHAR(4),
                  cod_estrutural   VARCHAR,
                  descricao        VARCHAR,
                  tipo             CHAR(1),
                  nivel            NUMERIC(1),
                  rpps             NUMERIC(1),
                  orcamento_1      NUMERIC(1),
                  orcamento_2      NUMERIC(1),
                  orcamento_3      NUMERIC(1),
                  orcamento_4      NUMERIC(1),
                  valor_1          NUMERIC,
                  valor_2          NUMERIC,
                  valor_3          NUMERIC,
                  valor_4          NUMERIC
                ) ORDER BY cod_tipo",
            $codPpa,
            $exercicio
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function getDespesaConfiguracao($codPpa, $exercicio)
    {
        $sql = sprintf(
            "SELECT cod_tipo
                , exercicio
                , cod_estrutural
                , descricao
                , tipo
                , nivel
                , rpps
                , orcamento_1
                , orcamento_2
                , orcamento_3
                , orcamento_4
                , valor_1
                , valor_2
                , valor_3
                , valor_4
            FROM ldo.fn_despesa_configuracao(%d, '%s') AS (
                  cod_tipo         INTEGER,
                  exercicio        VARCHAR(4),
                  cod_estrutural   VARCHAR,
                  descricao        VARCHAR,
                  tipo             CHAR(1),
                  nivel            NUMERIC(1),
                  rpps             NUMERIC(1),
                  orcamento_1      NUMERIC(1),
                  orcamento_2      NUMERIC(1),
                  orcamento_3      NUMERIC(1),
                  orcamento_4      NUMERIC(1),
                  valor_1          NUMERIC,
                  valor_2          NUMERIC,
                  valor_3          NUMERIC,
                  valor_4          NUMERIC
                ) ORDER BY cod_tipo",
            $codPpa,
            $exercicio
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function getReceitaPrevistaConfiguracao($codPpa, $exercicio)
    {
        $sql = sprintf(
            "SELECT cod_tipo
                , exercicio
                , cod_estrutural
                , descricao
                , tipo
                , nivel
                , rpps
                , orcamento_1
                , orcamento_2
                , orcamento_3
                , orcamento_4
                , valor_1
                , valor_2
                , valor_3
                , valor_4
            FROM ldo.fn_receita_prevista_configuracao(%d, '%s') AS (
                  cod_tipo         INTEGER,
                  exercicio        VARCHAR(4),
                  cod_estrutural   VARCHAR,
                  descricao        VARCHAR,
                  tipo             CHAR(1),
                  nivel            NUMERIC(1),
                  rpps             NUMERIC(1),
                  orcamento_1      NUMERIC(1),
                  orcamento_2      NUMERIC(1),
                  orcamento_3      NUMERIC(1),
                  orcamento_4      NUMERIC(1),
                  valor_1          NUMERIC,
                  valor_2          NUMERIC,
                  valor_3          NUMERIC,
                  valor_4          NUMERIC
                ) ORDER BY cod_tipo",
            $codPpa,
            $exercicio
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function getDespesaFixadaConfiguracao($codPpa, $exercicio)
    {
        $sql = sprintf(
            "SELECT cod_tipo
                , exercicio
                , cod_estrutural
                , descricao
                , tipo
                , nivel
                , rpps
                , orcamento_1
                , orcamento_2
                , orcamento_3
                , orcamento_4
                , valor_1
                , valor_2
                , valor_3
                , valor_4
            FROM ldo.fn_despesa_fixada_configuracao(%d, '%s') AS (
                  cod_tipo         INTEGER,
                  exercicio        VARCHAR(4),
                  cod_estrutural   VARCHAR,
                  descricao        VARCHAR,
                  tipo             CHAR(1),
                  nivel            NUMERIC(1),
                  rpps             NUMERIC(1),
                  orcamento_1      NUMERIC(1),
                  orcamento_2      NUMERIC(1),
                  orcamento_3      NUMERIC(1),
                  orcamento_4      NUMERIC(1),
                  valor_1          NUMERIC,
                  valor_2          NUMERIC,
                  valor_3          NUMERIC,
                  valor_4          NUMERIC
                ) ORDER BY cod_tipo",
            $codPpa,
            $exercicio
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function getReceitaProjetadaConfiguracao($codPpa, $exercicio)
    {
        $sql = sprintf(
            "SELECT cod_tipo
                , exercicio
                , cod_estrutural
                , descricao
                , tipo
                , nivel
                , rpps
                , orcamento_1
                , orcamento_2
                , orcamento_3
                , orcamento_4
                , valor_1
                , valor_2
                , valor_3
                , valor_4
            FROM ldo.fn_receita_projetada_configuracao(%d, '%s') AS (
                  cod_tipo         INTEGER,
                  exercicio        VARCHAR(4),
                  cod_estrutural   VARCHAR,
                  descricao        VARCHAR,
                  tipo             CHAR(1),
                  nivel            NUMERIC(1),
                  rpps             NUMERIC(1),
                  orcamento_1      NUMERIC(1),
                  orcamento_2      NUMERIC(1),
                  orcamento_3      NUMERIC(1),
                  orcamento_4      NUMERIC(1),
                  valor_1          NUMERIC,
                  valor_2          NUMERIC,
                  valor_3          NUMERIC,
                  valor_4          NUMERIC
                ) ORDER BY cod_tipo",
            $codPpa,
            $exercicio
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function getDespesaProjetadaConfiguracao($codPpa, $exercicio)
    {
        $sql = sprintf(
            "SELECT cod_tipo
                , exercicio
                , cod_estrutural
                , descricao
                , tipo
                , nivel
                , rpps
                , orcamento_1
                , orcamento_2
                , orcamento_3
                , orcamento_4
                , valor_1
                , valor_2
                , valor_3
                , valor_4
            FROM ldo.fn_despesa_projetada_configuracao(%d, '%s') AS (
                  cod_tipo         INTEGER,
                  exercicio        VARCHAR(4),
                  cod_estrutural   VARCHAR,
                  descricao        VARCHAR,
                  tipo             CHAR(1),
                  nivel            NUMERIC(1),
                  rpps             NUMERIC(1),
                  orcamento_1      NUMERIC(1),
                  orcamento_2      NUMERIC(1),
                  orcamento_3      NUMERIC(1),
                  orcamento_4      NUMERIC(1),
                  valor_1          NUMERIC,
                  valor_2          NUMERIC,
                  valor_3          NUMERIC,
                  valor_4          NUMERIC
                ) ORDER BY cod_tipo",
            $codPpa,
            $exercicio
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function listServicosLDO($ppa, $ano, $codSelic)
    {
        $sql = sprintf(
            "SELECT ordem
                , cod_tipo
                , especificacao
                , bo_orcamento_1
                , bo_orcamento_2
                , bo_orcamento_3
                , bo_orcamento_4
                , bo_orcamento_5
                , bo_orcamento_6
                , valor_1
                , valor_2
                , valor_3
                , valor_4
                , valor_5
                , valor_6
                , exercicio_1
                , exercicio_2
                , exercicio_3
                , exercicio_4
                , exercicio_5
                , exercicio_6
            FROM ldo.servico_divida(%d, '%s', %d) AS (
                ordem             INTEGER
                , cod_tipo          INTEGER
                , especificacao     VARCHAR
                , valor_1           DECIMAL(14,2)
                , valor_2           DECIMAL(14,2)
                , valor_3           DECIMAL(14,2)
                , valor_4           DECIMAL(14,2)
                , valor_5           DECIMAL(14,2)
                , valor_6           DECIMAL(14,2)
                , bo_orcamento_1    DECIMAL(1)
                , bo_orcamento_2    DECIMAL(1)
                , bo_orcamento_3    DECIMAL(1)
                , bo_orcamento_4    DECIMAL(1)
                , bo_orcamento_5    DECIMAL(1)
                , bo_orcamento_6    DECIMAL(1)
                , exercicio_1       CHAR(4)
                , exercicio_2       CHAR(4)
                , exercicio_3       CHAR(4)
                , exercicio_4       CHAR(4)
                , exercicio_5       CHAR(4)
                , exercicio_6       CHAR(4)
                ) ORDER BY ordem",
            $ppa->getCodPpa(),
            $ano,
            $codSelic
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function getEvolucaoPatrimonioLiquido(Ppa $ppa, $ano, $boRPPS)
    {
        $sql = "SELECT
                cod_tipo,
                descricao,
                rpps,
                nivel,
                valor_1,
                valor_2,
                valor_3,
                porcentagem_1,
                porcentagem_2,
                porcentagem_3,
                orcamento_1,
                orcamento_2,
                orcamento_3
            FROM
                ldo.fn_evolucao_patrimonio_liquido(:ppa, :ano, :boRPPS ) as retorno (
                cod_tipo integer,
                descricao varchar,
                rpps numeric,
                nivel numeric,
                valor_1 numeric,
                valor_2 numeric,
                valor_3 numeric,
                porcentagem_1 numeric,
                porcentagem_2 numeric,
                porcentagem_3 numeric,
                orcamento_1 numeric,
                orcamento_2 numeric,
                orcamento_3 numeric
            )";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(':ppa', $ppa->getCodPpa(), \PDO::PARAM_INT);
        $query->bindValue(':ano', $ano, \PDO::PARAM_STR);
        $query->bindValue(':boRPPS', $boRPPS, \PDO::PARAM_BOOL);

        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }
}
