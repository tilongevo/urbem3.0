<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;
use Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento\CalculoComplementarAdmin;

class ContratoRepository extends AbstractRepository
{
    /**
     * @return int
     */
    public function getNextCodContrato()
    {
        return $this->nextVal('cod_contrato');
    }

    /**
     * @return int
     */
    public function getNextRegistro()
    {
        return $this->nextVal('registro');
    }

    public function listContratosAtivosWithCgm()
    {
        $sql = "
            SELECT
                cs.cod_contrato,
                CONCAT(
                    c.nom_cgm,
                    ' - ',
                    CASE ativo
                        WHEN true
                        THEN 'Ativo'
                        ELSE 'Rescindido'
                    END
                ) AS nom_cgm
            FROM public.sw_cgm c
            INNER JOIN pessoal.servidor s
                ON s.numcgm = c.numcgm
            INNER JOIN pessoal.contrato_servidor cs
                ON cs.cod_servidor = s.cod_servidor
            WHERE cs.ativo = true
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $codContratos
     *
     * @return array
     */
    public function listContratosByCodContratos($codContratos)
    {
        $sql = "
            SELECT
                cs.cod_contrato,
                c.nom_cgm,
                CASE ativo
                        WHEN true
                        THEN 'Ativo'
                        ELSE 'Rescindido'
                END as status,
                co.registro
            FROM public.sw_cgm c
            INNER JOIN pessoal.servidor s
                ON s.numcgm = c.numcgm
            LEFT JOIN pessoal.servidor_contrato_servidor scs
	            ON s.cod_servidor = scs.cod_servidor
            INNER JOIN pessoal.contrato_servidor cs
                ON cs.cod_contrato = scs.cod_contrato
            inner join pessoal.contrato co
            	on co.cod_contrato = cs.cod_contrato
            	WHERE co.cod_contrato in($codContratos);
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function listAllContratosWithCgm()
    {
        $sql = "
            SELECT
                cs.cod_contrato,
                CONCAT(
                    c.nom_cgm,
                    ' - ',
                    CASE ativo
                        WHEN true
                        THEN 'Ativo'
                        ELSE 'Rescindido'
                    END
                ) AS nom_cgm
            FROM public.sw_cgm c
            INNER JOIN pessoal.servidor s
                ON s.numcgm = c.numcgm
            LEFT JOIN pessoal.servidor_contrato_servidor scs
	            ON s.cod_servidor = scs.cod_servidor
            INNER JOIN pessoal.contrato_servidor cs
                ON cs.cod_contrato = scs.cod_contrato
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param        $filtro
     * @param bool   $situacao
     * @param string $entidade
     *
     * @return array
     */
    public function getContrato($filtro, $situacao = false, $entidade = '')
    {
        $sql = "
        SELECT
            *
        FROM (
                SELECT
                    sw_cgm.numcgm,
                    sw_cgm.nom_cgm,
                    contrato.*,
                    recuperarSituacaoDoContratoLiteral (contrato.cod_contrato,
                        0, :entidade) AS situacao
                FROM
                    pessoal.contrato,
                    pessoal.servidor_contrato_servidor,
                    pessoal.servidor,
                    sw_cgm
                WHERE
                    contrato.cod_contrato = servidor_contrato_servidor.cod_contrato
                    AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
                    AND servidor.numcgm = sw_cgm.numcgm
                UNION
                SELECT
                    sw_cgm.numcgm,
                    sw_cgm.nom_cgm,
                    contrato.*,
                    recuperarSituacaoDoContratoLiteral (contrato.cod_contrato,
                        0, :entidade) AS situacao
                FROM
                    pessoal.contrato,
                    pessoal.contrato_pensionista,
                    pessoal.pensionista,
                    sw_cgm
                WHERE
                    contrato.cod_contrato = contrato_pensionista.cod_contrato
                    AND contrato_pensionista.cod_pensionista = pensionista.cod_pensionista
                    AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente
                    AND pensionista.numcgm = sw_cgm.numcgm) AS contrato
        WHERE
            registro IS NOT NULL";

        if (is_numeric($filtro)) {
            $sql .= "
            AND (registro = :filtro OR numcgm = :filtro)
            ";
        } else {
            $sql .= "
            AND LOWER(nom_cgm)
            LIKE :filtro
            || '%'
            ";
        }

        if (!$situacao) {
            $sql .= " AND situacao = 'Ativo'";
        } else {
            $sql .= " AND situacao = '{$situacao}'";
        }

        $sql .= "
        ORDER BY
            nom_cgm
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        if (is_numeric($filtro)) {
            $query->bindValue(":filtro", $filtro, \PDO::PARAM_INT);
        } else {
            $query->bindValue(":filtro", "%" . strtolower($filtro) . "%", \PDO::PARAM_STR);
        }

        $query->bindValue(':entidade', $entidade, \PDO::PARAM_STR);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param        $filtro
     * @param string $entidade
     *
     * @return array
     */
    public function getContratoAll($filtro, $entidade = '')
    {
        $sql = "
        SELECT
            *
        FROM (
                SELECT
                    sw_cgm.numcgm,
                    sw_cgm.nom_cgm,
                    contrato.*,
                    recuperarSituacaoDoContratoLiteral (contrato.cod_contrato,
                        0, :entidade) AS situacao
                FROM
                    pessoal.contrato,
                    pessoal.servidor_contrato_servidor,
                    pessoal.servidor,
                    sw_cgm
                WHERE
                    contrato.cod_contrato = servidor_contrato_servidor.cod_contrato
                    AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
                    AND servidor.numcgm = sw_cgm.numcgm
                UNION
                SELECT
                    sw_cgm.numcgm,
                    sw_cgm.nom_cgm,
                    contrato.*,
                    recuperarSituacaoDoContratoLiteral (contrato.cod_contrato,
                        0, :entidade) AS situacao
                FROM
                    pessoal.contrato,
                    pessoal.contrato_pensionista,
                    pessoal.pensionista,
                    sw_cgm
                WHERE
                    contrato.cod_contrato = contrato_pensionista.cod_contrato
                    AND contrato_pensionista.cod_pensionista = pensionista.cod_pensionista
                    AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente
                    AND pensionista.numcgm = sw_cgm.numcgm) AS contrato
        WHERE
            registro IS NOT NULL";

        if (is_numeric($filtro)) {
            $sql .= "
            AND (registro = :filtro OR numcgm = :filtro)
            ";
        } else {
            $sql .= "
            AND LOWER(nom_cgm)
            LIKE :filtro
            || '%'
            ";
        }

        $sql .= "
        ORDER BY
            nom_cgm
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        if (is_numeric($filtro)) {
            $query->bindValue(":filtro", $filtro, \PDO::PARAM_INT);
        } else {
            $query->bindValue(":filtro", "%" . strtolower($filtro) . "%", \PDO::PARAM_STR);
        }

        $query->bindValue(':entidade', $entidade, \PDO::PARAM_STR);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }


    /**
     * @param        $filtro
     * @param string $entidade
     *
     * @return array
     */
    public function getContratoServidorPensionista($filtro, $entidade = '')
    {
        $sql = "
        SELECT
            *
        FROM (
                SELECT
                    sw_cgm.numcgm,
                    sw_cgm.nom_cgm,
                    contrato.*,
                    recuperarSituacaoDoContratoLiteral (contrato.cod_contrato,
                        0, :entidade) AS situacao
                FROM
                    pessoal.contrato,
                    pessoal.servidor_contrato_servidor,
                    pessoal.servidor,
                    sw_cgm
                WHERE
                    contrato.cod_contrato = servidor_contrato_servidor.cod_contrato
                    AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
                    AND servidor.numcgm = sw_cgm.numcgm
                UNION
                SELECT
                    sw_cgm.numcgm,
                    sw_cgm.nom_cgm,
                    contrato.*,
                    recuperarSituacaoDoContratoLiteral (contrato.cod_contrato,
                        0, :entidade) AS situacao
                FROM
                    pessoal.contrato,
                    pessoal.contrato_pensionista,
                    pessoal.pensionista,
                    sw_cgm
                WHERE
                    contrato.cod_contrato = contrato_pensionista.cod_contrato
                    AND contrato_pensionista.cod_pensionista = pensionista.cod_pensionista
                    AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente
                    AND pensionista.numcgm = sw_cgm.numcgm) AS contrato
        WHERE
            registro IS NOT NULL";

        if (is_numeric($filtro)) {
            $sql .= "
            AND (registro = :filtro OR numcgm = :filtro)
            ";
        } else {
            $sql .= "
            AND LOWER(nom_cgm)
            LIKE :filtro
            || '%'
            ";
        }

        $sql .= "
        ORDER BY
            nom_cgm
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        if (is_numeric($filtro)) {
            $query->bindValue(":filtro", $filtro, \PDO::PARAM_INT);
        } else {
            $query->bindValue(":filtro", "%" . strtolower($filtro) . "%", \PDO::PARAM_STR);
        }

        $query->bindValue(':entidade', $entidade, \PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }


    /**
     * @param $filtro
     *
     * @return array
     */
    public function getContratoRescindido($filtro = false)
    {
        $sql = "
        SELECT
            *
        FROM (
                SELECT
                    sw_cgm.numcgm,
                    sw_cgm.nom_cgm,
                    contrato.*,
                    recuperarSituacaoDoContratoLiteral (contrato.cod_contrato,
                        0, '') AS situacao
                FROM
                    pessoal.contrato,
                    pessoal.servidor_contrato_servidor,
                    pessoal.servidor,
                    sw_cgm
                WHERE
                    contrato.cod_contrato = servidor_contrato_servidor.cod_contrato
                    AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
                    AND servidor.numcgm = sw_cgm.numcgm
                UNION
                SELECT
                    sw_cgm.numcgm,
                    sw_cgm.nom_cgm,
                    contrato.*,
                    recuperarSituacaoDoContratoLiteral (contrato.cod_contrato,
                        0, '') AS situacao
                FROM
                    pessoal.contrato,
                    pessoal.contrato_pensionista,
                    pessoal.pensionista,
                    sw_cgm
                WHERE
                    contrato.cod_contrato = contrato_pensionista.cod_contrato
                    AND contrato_pensionista.cod_pensionista = pensionista.cod_pensionista
                    AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente
                    AND pensionista.numcgm = sw_cgm.numcgm) AS contrato
        WHERE
            registro IS NOT NULL
             AND EXISTS (SELECT 1 FROM pessoal.contrato_servidor_caso_causa WHERE contrato_servidor_caso_causa.cod_contrato = contrato.cod_contrato
	                        UNION ALL
	                        SELECT 1 FROM pessoal.contrato_pensionista_caso_causa WHERE contrato_pensionista_caso_causa.cod_contrato = contrato.cod_contrato  )
            ";

        if ($filtro) {
            if (is_numeric($filtro)) {
                $sql .= "
                AND (registro = :filtro OR numcgm = :filtro)
                ";
            } else {
                $sql .= "
                AND lower (nom_cgm)
                LIKE lower (:filtro)
                || '%'
                ";
            }
        }

        $sql .= "
        ORDER BY
            nom_cgm
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        if ($filtro) {
            if (is_numeric($filtro)) {
                $query->bindValue(":filtro", $filtro, \PDO::PARAM_INT);
            } else {
                $query->bindValue(":filtro", "%" . $filtro . "%", \PDO::PARAM_STR);
            }
        }
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $filtro
     *
     * @return array
     */
    public function getContratoNotRescindido($filtro)
    {
        $sql = "
        SELECT
            *
        FROM (
                SELECT
                    sw_cgm.numcgm,
                    sw_cgm.nom_cgm,
                    contrato.*,
                    recuperarSituacaoDoContratoLiteral (contrato.cod_contrato,
                        0, '') AS situacao
                FROM
                    pessoal.contrato,
                    pessoal.servidor_contrato_servidor,
                    pessoal.servidor,
                    sw_cgm
                WHERE
                    contrato.cod_contrato = servidor_contrato_servidor.cod_contrato
                    AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
                    AND servidor.numcgm = sw_cgm.numcgm
                UNION
                SELECT
                    sw_cgm.numcgm,
                    sw_cgm.nom_cgm,
                    contrato.*,
                    recuperarSituacaoDoContratoLiteral (contrato.cod_contrato,
                        0, '') AS situacao
                FROM
                    pessoal.contrato,
                    pessoal.contrato_pensionista,
                    pessoal.pensionista,
                    sw_cgm
                WHERE
                    contrato.cod_contrato = contrato_pensionista.cod_contrato
                    AND contrato_pensionista.cod_pensionista = pensionista.cod_pensionista
                    AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente
                    AND pensionista.numcgm = sw_cgm.numcgm) AS contrato
        WHERE
            registro IS NOT NULL
             AND NOT EXISTS (SELECT 1 FROM pessoal.contrato_servidor_caso_causa WHERE contrato_servidor_caso_causa.cod_contrato = contrato.cod_contrato )
            ";

        if (is_numeric($filtro)) {
            $sql .= "
            AND (registro = :filtro OR numcgm = :filtro)
            ";
        } else {
            $sql .= "
            AND lower (nom_cgm)
            LIKE lower (:filtro)
            || '%'
            ";
        }

        $sql .= "
        ORDER BY
            nom_cgm
        ";
        $query = $this->_em->getConnection()->prepare($sql);
        if (is_numeric($filtro)) {
            $query->bindValue(":filtro", $filtro, \PDO::PARAM_INT);
        } else {
            $query->bindValue(":filtro", "%" . $filtro . "%", \PDO::PARAM_STR);
        }
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $filtro
     *
     * @return array
     */
    public function getContratoServidorPeriodo($filtro, $codPeriodoMovimentacao)
    {
        $sql = "
        SELECT
            *
        FROM (
                SELECT
                    sw_cgm.numcgm,
                    sw_cgm.nom_cgm,
                    contrato.*,
                    recuperarSituacaoDoContratoLiteral (contrato.cod_contrato,
                        0, '') AS situacao
                FROM
                    pessoal.contrato,
                    pessoal.servidor_contrato_servidor,
                    pessoal.servidor,
                    sw_cgm
                WHERE
                    contrato.cod_contrato = servidor_contrato_servidor.cod_contrato
                    AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
                    AND servidor.numcgm = sw_cgm.numcgm
                UNION
                SELECT
                    sw_cgm.numcgm,
                    sw_cgm.nom_cgm,
                    contrato.*,
                    recuperarSituacaoDoContratoLiteral (contrato.cod_contrato,
                        0, '') AS situacao
                FROM
                    pessoal.contrato,
                    pessoal.contrato_pensionista,
                    pessoal.pensionista,
                    sw_cgm
                WHERE
                    contrato.cod_contrato = contrato_pensionista.cod_contrato
                    AND contrato_pensionista.cod_pensionista = pensionista.cod_pensionista
                    AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente
                    AND pensionista.numcgm = sw_cgm.numcgm) AS contrato
        WHERE
            registro IS NOT NULL
             AND EXISTS (SELECT 1 FROM folhapagamento.contrato_servidor_periodo WHERE contrato_servidor_periodo.cod_contrato = contrato.cod_contrato
              AND contrato_servidor_periodo.cod_periodo_movimentacao = :codPeriodoMovimentacao)
            ";

        if (is_numeric($filtro)) {
            $sql .= "
            AND registro = :filtro
            ";
        } else {
            $sql .= "
            AND lower (nom_cgm)
            LIKE lower (:filtro)
            || '%'
            ";
        }

        $sql .= "
        ORDER BY
            nom_cgm
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":codPeriodoMovimentacao", $codPeriodoMovimentacao, \PDO::PARAM_INT);
        if (is_numeric($filtro)) {
            $query->bindValue(":filtro", $filtro, \PDO::PARAM_INT);
        } else {
            $query->bindValue(":filtro", "%" . $filtro . "%", \PDO::PARAM_STR);
        }
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Recupera a situaçãoo do contrato literal
     *
     * @param  integer $inCodContrato
     * @param  integer $inCodPeriodoMovimentacao
     * @param  string  $stEntidade
     *
     * @return string
     */
    public function recuperarSituacaoDoContratoLiteral($inCodContrato, $inCodPeriodoMovimentacao = 0, $stEntidade = '')
    {
        $sql = "
        SELECT
            recuperarSituacaoDoContratoLiteral (:inCodContrato,
                :inCodPeriodoMovimentacao, :stEntidade) AS situacao;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":inCodContrato", $inCodContrato, \PDO::PARAM_INT);
        $query->bindValue(":inCodPeriodoMovimentacao", $inCodPeriodoMovimentacao, \PDO::PARAM_INT);
        $query->bindValue(":stEntidade", $stEntidade, \PDO::PARAM_STR);
        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param        $codContrato
     * @param string $entidade
     *
     * @return array
     */
    public function montaRecuperaCgmDoRegistro($codContrato, $entidade = '')
    {
        $stSql = "SELECT * FROM (
        SELECT sw_cgm.numcgm
             , sw_cgm.nom_cgm
             , contrato.*
             , recuperarSituacaoDoContratoLiteral(contrato.cod_contrato, 0, '" . $entidade . "') as situacao
          FROM pessoal.contrato
             , pessoal.servidor_contrato_servidor
             , pessoal.servidor
             , sw_cgm
         WHERE contrato.cod_contrato = servidor_contrato_servidor.cod_contrato
           AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
           AND servidor.numcgm = sw_cgm.numcgm
        UNION
        SELECT sw_cgm.numcgm
             , sw_cgm.nom_cgm
             , contrato.*
             , recuperarSituacaoDoContratoLiteral(contrato.cod_contrato, 0, '" . $entidade . "') as situacao
          FROM pessoal.contrato
             , pessoal.contrato_pensionista
             , pessoal.pensionista
             , sw_cgm
         WHERE contrato.cod_contrato = contrato_pensionista.cod_contrato
           AND contrato_pensionista.cod_pensionista = pensionista.cod_pensionista
           AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente
           AND pensionista.numcgm = sw_cgm.numcgm
           ) as contrato WHERE registro is not null ";

        $stSql .= "AND contrato.cod_contrato = $codContrato";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $queryResult = array_shift($query->fetchAll());
        $result = $queryResult;

        return $result;
    }

    /**
     * @param $inCodContrato
     * @param $inCodConfiguracao
     * @param $boErro
     * @param $stEntidade
     * @param $stExercicio
     *
     * @return mixed
     */
    public function montaCalculaFolha($inCodContrato, $inCodConfiguracao, $boErro, $stEntidade, $stExercicio)
    {
        $sql = "
        SELECT calculaFolha(:inCodContrato, :inCodConfiguracao, :boErro, :stEntidade, :stExercicio ) AS retorno;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":inCodContrato", $inCodContrato, \PDO::PARAM_INT);
        $query->bindValue(":inCodConfiguracao", $inCodConfiguracao, \PDO::PARAM_INT);
        $query->bindValue(":boErro", $boErro, \PDO::PARAM_STR);
        $query->bindValue(":stEntidade", $stEntidade, \PDO::PARAM_STR);
        $query->bindValue(":stExercicio", $stExercicio, \PDO::PARAM_STR);
        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param $inCodContrato
     * @param $inCodComplementar
     * @param $boErro
     * @param $stEntidade
     * @param $stExercicio
     *
     * @return mixed
     */
    public function montaCalculaFolhaComplementar($inCodContrato, $inCodComplementar, $boErro, $stEntidade, $stExercicio)
    {
        $sql = "
            SELECT calculaFolhaComplementar(:inCodContrato, :inCodComplementar, :boErro, :stEntidade, :stExercicio) AS retorno;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":inCodContrato", $inCodContrato, \PDO::PARAM_INT);
        $query->bindValue(":inCodComplementar", $inCodComplementar, \PDO::PARAM_INT);
        $query->bindValue(":boErro", $boErro, \PDO::PARAM_STR);
        $query->bindValue(":stEntidade", $stEntidade, \PDO::PARAM_STR);
        $query->bindValue(":stExercicio", $stExercicio, \PDO::PARAM_STR);

        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param $inCodContrato
     * @param $boErro
     * @param $stEntidade
     * @param $stExercicio
     *
     * @return mixed
     */
    public function montaCalculaFolhaFerias($inCodContrato, $boErro, $stEntidade, $stExercicio)
    {
        $sql = "
        SELECT
            calculaFolhaFerias (:inCodContrato,
                :boErro, :stEntidade, :stExercicio ) AS retorno;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":inCodContrato", $inCodContrato, \PDO::PARAM_INT);
        $query->bindValue(":boErro", $boErro, \PDO::PARAM_STR);
        $query->bindValue(":stEntidade", $stEntidade, \PDO::PARAM_STR);
        $query->bindValue(":stExercicio", $stExercicio, \PDO::PARAM_STR);

        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param $inCodContrato
     * @param $desdobramento
     * @param $boErro
     * @param $stEntidade
     * @param $stExercicio
     *
     * @return mixed
     */
    public function montaCalculaFolhaDecimo($inCodContrato, $desdobramento, $boErro, $stEntidade, $stExercicio)
    {
        $sql = "
        SELECT
            calculaFolhaDecimo (:inCodContrato, :desdobramento,
                :boErro, :stEntidade, :stExercicio ) AS retorno;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":inCodContrato", $inCodContrato, \PDO::PARAM_INT);
        $query->bindValue(":desdobramento", $desdobramento, \PDO::PARAM_STR);
        $query->bindValue(":boErro", $boErro, \PDO::PARAM_STR);
        $query->bindValue(":stEntidade", $stEntidade, \PDO::PARAM_STR);
        $query->bindValue(":stExercicio", $stExercicio, \PDO::PARAM_STR);

        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param $inCodContrato
     * @param $boErro
     * @param $stEntidade
     * @param $stExercicio
     *
     * @return mixed
     */
    public function montaCalculaFolhaRescisao($inCodContrato, $boErro, $stEntidade, $stExercicio)
    {
        $sql = "
        SELECT
            calculaFolhaRescisao (:inCodContrato,
                :boErro, :stEntidade, :stExercicio ) AS retorno;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":inCodContrato", $inCodContrato, \PDO::PARAM_INT);
        $query->bindValue(":boErro", $boErro, \PDO::PARAM_STR);
        $query->bindValue(":stEntidade", $stEntidade, \PDO::PARAM_STR);
        $query->bindValue(":stExercicio", $stExercicio, \PDO::PARAM_STR);

        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }


    /**
     * @param       $paramsBo
     * @param       $inCodPeriodoMovimentacao
     * @param       $entidade
     * @param array $inCodLocal
     * @param array $inCodLotacao
     * @param array $inCodEvento
     * @param bool  $inCodComplementar
     *
     * @return array
     */
    public function montaRecuperaContratosCalculoFolha($paramsBo, $inCodPeriodoMovimentacao, $entidade, $inCodLocal, $inCodLotacao, $inCodEvento, $inCodComplementar = false)
    {
        $boAtivos = $paramsBo["boAtivos"];
        $boAposentados = $paramsBo["boAposentados"];
        $boRescindidos = $paramsBo["boRescindidos"];
        $boPensionistas = $paramsBo["boPensionistas"];
        $stTipoFolha = $paramsBo["stTipoFolha"];
        $stFiltro = "";

        $arSituacaoContrato = array();
        if ($boAtivos === true) {
            array_push($arSituacaoContrato, "'A'");
        }
        if ($boAposentados === true) {
            array_push($arSituacaoContrato, "'P'");
        }
        if ($boRescindidos === true) {
            array_push($arSituacaoContrato, "'R'");
        }

        $stSql = "SELECT * FROM ( \n";

        if ($boAtivos === true || $boAposentados === true || $boRescindidos === true || $boPensionistas === true) {
            // Monta a consulta dos servidores(Ativos, aposentado e rescindidos)
            $stSql .= "SELECT contrato.*                                                        \n";
            $stSql .= "     , sw_cgm.numcgm                                                     \n";
            $stSql .= "     , sw_cgm.nom_cgm                                                    \n";
            $stSql .= "  FROM pessoal.contrato                                                  \n";
            $stSql .= "  JOIN pessoal.servidor_contrato_servidor                                \n";
            $stSql .= "    ON contrato.cod_contrato = servidor_contrato_servidor.cod_contrato   \n";
            $stSql .= "  JOIN pessoal.servidor                                                  \n";
            $stSql .= "    ON servidor_contrato_servidor.cod_servidor = servidor.cod_servidor   \n";
            $stSql .= "  JOIN sw_cgm                                                            \n";
            $stSql .= "    ON servidor.numcgm = sw_cgm.numcgm                                   \n";
            $stSql .= "  JOIN pessoal.contrato_servidor                                         \n";
            $stSql .= "    ON contrato_servidor.cod_contrato = contrato.cod_contrato            \n";

            // Adicionando Filtro por Local para os servidores
            if (!empty($inCodLocal)) {
                $stSql .= "  JOIN pessoal.contrato_servidor_local                                                   \n";
                $stSql .= "    ON contrato.cod_contrato = contrato_servidor_local.cod_contrato                      \n";
                $stSql .= "  JOIN (  SELECT cod_contrato                                                            \n";
                $stSql .= "               , MAX(timestamp) as timestamp                                             \n";
                $stSql .= "            FROM pessoal.contrato_servidor_local                                         \n";
                $stSql .= "        GROUP BY cod_contrato) as max_contrato_servidor_local                            \n";
                $stSql .= "    ON contrato_servidor_local.cod_contrato = max_contrato_servidor_local.cod_contrato   \n";
                $stSql .= "   AND contrato_servidor_local.timestamp = max_contrato_servidor_local.timestamp         \n";
                $stSql .= "   AND contrato_servidor_local.cod_local IN ('" . implode("','", $inCodLocal) . "') \n";
            }

            // Adicionando Filtro por Lotação para os servidores
            if (!empty($inCodLotacao)) {
                $stSql .= "  JOIN pessoal.contrato_servidor_orgao                                                   \n";
                $stSql .= "    ON contrato.cod_contrato = contrato_servidor_orgao.cod_contrato                      \n";
                $stSql .= "  JOIN (  SELECT cod_contrato                                                            \n";
                $stSql .= "               , MAX(timestamp) as timestamp                                             \n";
                $stSql .= "            FROM pessoal.contrato_servidor_orgao                                         \n";
                $stSql .= "        GROUP BY cod_contrato) as max_contrato_servidor_orgao                            \n";
                $stSql .= "    ON contrato_servidor_orgao.cod_contrato = max_contrato_servidor_orgao.cod_contrato   \n";
                $stSql .= "   AND contrato_servidor_orgao.timestamp = max_contrato_servidor_orgao.timestamp         \n";
                $stSql .= "   AND contrato_servidor_orgao.cod_orgao IN ('" . implode("','", $inCodLotacao) . "')\n";
            }

            // Adicionando Filtro por Evento para os servidores
            if (!empty($inCodEvento)) {
                $stSql .= "  INNER JOIN folhapagamento.registro_evento_periodo                                \n";
                $stSql .= "          ON registro_evento_periodo.cod_contrato = contrato.cod_contrato          \n";
                $stSql .= "  INNER JOIN folhapagamento.registro_evento                                        \n";
                $stSql .= "          ON registro_evento.cod_registro = registro_evento_periodo.cod_registro   \n";
                $stSql .= "         AND registro_evento.cod_evento IN ('" . implode("','", $inCodEvento) . "')\n";
            }

            if (count($arSituacaoContrato) > 0) {
                $stSql .= " WHERE recuperarSituacaoDoContrato(contrato.cod_contrato, 0, '" . $entidade . "') in (" . implode(",", $arSituacaoContrato) . ") \n";
            }

            if ($boPensionistas === true) {
                $stSql .= "UNION \n";
            }
        }

        if ($boPensionistas === true) {
            // Monta a consulta dos pensionistas
            $stSql .= "SELECT contrato.*                                                                    \n";
            $stSql .= "     , pensionista.numcgm                                                            \n";
            $stSql .= "     , (SELECT nom_cgm FROM sw_cgm WHERE numcgm = pensionista.numcgm) as nom_cgm     \n";
            $stSql .= "  FROM pessoal.contrato                                                              \n";
            $stSql .= "  JOIN pessoal.contrato_pensionista                                                  \n";
            $stSql .= "    ON (contrato.cod_contrato = contrato_pensionista.cod_contrato)                   \n";
            $stSql .= "  JOIN pessoal.pensionista                                                           \n";
            $stSql .= "    ON contrato_pensionista.cod_pensionista = pensionista.cod_pensionista            \n";
            $stSql .= "   AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente  \n";

            if (!empty($inCodLotacao)) {
                // Adicionando Filtro por Lotação para os pensionistas
                $stSql .= "   JOIN pessoal.contrato_pensionista_orgao                                                     \n";
                $stSql .= "     ON contrato.cod_contrato = contrato_pensionista.cod_contrato                              \n";
                $stSql .= "   JOIN (  SELECT cod_contrato                                                                 \n";
                $stSql .= "                , max(timestamp) as timestamp                                                  \n";
                $stSql .= "             FROM pessoal.contrato_pensionista_orgao                                           \n";
                $stSql .= "         GROUP BY cod_contrato) as max_contrato_pensionista_orgao                              \n";
                $stSql .= "     ON contrato_pensionista_orgao.cod_contrato = max_contrato_pensionista_orgao.cod_contrato  \n";
                $stSql .= "    AND contrato_pensionista_orgao.timestamp = max_contrato_pensionista_orgao.timestamp        \n";
                $stSql .= "    AND contrato_pensionista_orgao.cod_orgao IN ('" . implode("','", $inCodLotacao) . "') \n";
            }

            // Adicionando Filtro por Evento para os servidores
            if (!empty($inCodEvento)) {
                $stSql .= "  INNER JOIN folhapagamento.registro_evento_periodo                                   \n";
                $stSql .= "          ON registro_evento_periodo.cod_contrato = contrato.cod_contrato             \n";
                $stSql .= "  INNER JOIN folhapagamento.registro_evento                                           \n";
                $stSql .= "          ON registro_evento.cod_registro = registro_evento_periodo.cod_registro      \n";
                $stSql .= "         AND registro_evento.cod_evento IN ('" . implode("','", $inCodEvento) . "')\n";
            }
        }
        $stSql .= " ) as contrato \n";

        // Verifica se o contrato possui registros de eventos para ser calculado na folha na competencia
        switch (trim($stTipoFolha)) {
            case "S":
                $stFiltro .= " WHERE EXISTS ( SELECT 1                                                                                  \n";
                $stFiltro .= "                  FROM folhapagamento.registro_evento_periodo                                             \n";
                $stFiltro .= "                  JOIN folhapagamento.ultimo_registro_evento                                              \n";
                $stFiltro .= "                    ON ultimo_registro_evento.cod_registro = registro_evento_periodo.cod_registro         \n";
                $stFiltro .= "                 WHERE registro_evento_periodo.cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao . "   \n";
                $stFiltro .= "                   AND registro_evento_periodo.cod_contrato = contrato.cod_contrato                       \n";
                $stFiltro .= "               )                                                                                          \n";
                break;
            case "C":
                $stFiltro .= " WHERE EXISTS ( SELECT 1                                                                                                      \n";
                $stFiltro .= "                  FROM folhapagamento.registro_evento_complementar                                                            \n";
                $stFiltro .= "                  JOIN folhapagamento.ultimo_registro_evento_complementar                                                     \n";
                $stFiltro .= "                    ON ultimo_registro_evento_complementar.cod_registro = registro_evento_complementar.cod_registro           \n";
                $stFiltro .= "                   AND ultimo_registro_evento_complementar.cod_evento = registro_evento_complementar.cod_evento               \n";
                $stFiltro .= "                   AND ultimo_registro_evento_complementar.cod_configuracao = registro_evento_complementar.cod_configuracao   \n";
                $stFiltro .= "                   AND ultimo_registro_evento_complementar.timestamp = registro_evento_complementar.timestamp                 \n";
                $stFiltro .= "                 WHERE registro_evento_complementar.cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao . "                  \n";
                $stFiltro .= "                   AND registro_evento_complementar.cod_complementar = " . $inCodComplementar . "                                 \n";
                $stFiltro .= "                   AND registro_evento_complementar.cod_contrato = contrato.cod_contrato                                      \n";
                $stFiltro .= "              )                                                                                                               \n";
                break;
            case "F":
                $stFiltro .= " WHERE EXISTS ( SELECT 1                                                                                      \n";
                $stFiltro .= "                  FROM pessoal.ferias                                                                         \n";
                $stFiltro .= "                     , pessoal.lancamento_ferias                                                              \n";
                $stFiltro .= "                     , folhapagamento.registro_evento_ferias                                                  \n";
                $stFiltro .= "                  JOIN folhapagamento.ultimo_registro_evento_ferias                                           \n";
                $stFiltro .= "                    ON ultimo_registro_evento_ferias.cod_registro = registro_evento_ferias.cod_registro       \n";
                $stFiltro .= "                   AND ultimo_registro_evento_ferias.cod_evento = registro_evento_ferias.cod_evento           \n";
                $stFiltro .= "                   AND ultimo_registro_evento_ferias.desdobramento = registro_evento_ferias.desdobramento     \n";
                $stFiltro .= "                   AND ultimo_registro_evento_ferias.timestamp = registro_evento_ferias.timestamp             \n";
                $stFiltro .= "                 WHERE registro_evento_ferias.cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao . "        \n";
                $stFiltro .= "                   AND ferias.cod_ferias = lancamento_ferias.cod_ferias                                       \n";
                $stFiltro .= "                   AND ferias.cod_contrato = contrato.cod_contrato                                            \n";
                $stFiltro .= "                   AND lancamento_ferias.cod_tipo = 1                                                         \n";
                $stFiltro .= "                   AND registro_evento_ferias.cod_contrato = contrato.cod_contrato                            \n";
                $stFiltro .= "             )                                                                                                \n";
                break;
            case "D":
                $stFiltro .= " WHERE EXISTS ( SELECT 1                                                                                           \n";
                $stFiltro .= "                  FROM folhapagamento.concessao_decimo                                                             \n";
                $stFiltro .= "                     , folhapagamento.registro_evento_decimo                                                       \n";
                $stFiltro .= "                  JOIN folhapagamento.ultimo_registro_evento_decimo                                                \n";
                $stFiltro .= "                    ON ultimo_registro_evento_decimo.cod_registro = registro_evento_decimo.cod_registro            \n";
                $stFiltro .= "                   AND ultimo_registro_evento_decimo.cod_evento = registro_evento_decimo.cod_evento                \n";
                $stFiltro .= "                   AND ultimo_registro_evento_decimo.desdobramento = registro_evento_decimo.desdobramento          \n";
                $stFiltro .= "                   AND ultimo_registro_evento_decimo.timestamp = registro_evento_decimo.timestamp                  \n";
                $stFiltro .= "                 WHERE registro_evento_decimo.cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao . "             \n";
                $stFiltro .= "                   AND registro_evento_decimo.cod_contrato = contrato.cod_contrato                                 \n";
                $stFiltro .= "                   AND registro_evento_decimo.cod_contrato = concessao_decimo.cod_contrato                         \n";
                $stFiltro .= "                   AND registro_evento_decimo.cod_periodo_movimentacao = concessao_decimo.cod_periodo_movimentacao \n";
                $stFiltro .= "                   AND concessao_decimo.folha_salario = 'f'                                                        \n";
                $stFiltro .= "              )                                                                                                    \n";
                break;
            case "R":
                $stFiltro .= " WHERE EXISTS ( SELECT 1                                                                                          \n";
                $stFiltro .= "                  FROM folhapagamento.registro_evento_rescisao                                                    \n";
                $stFiltro .= "                  JOIN folhapagamento.ultimo_registro_evento_rescisao                                             \n";
                $stFiltro .= "                    ON ultimo_registro_evento_rescisao.cod_registro = registro_evento_rescisao.cod_registro       \n";
                $stFiltro .= "                   AND ultimo_registro_evento_rescisao.cod_evento = registro_evento_rescisao.cod_evento           \n";
                $stFiltro .= "                   AND ultimo_registro_evento_rescisao.desdobramento = registro_evento_rescisao.desdobramento     \n";
                $stFiltro .= "                   AND ultimo_registro_evento_rescisao.timestamp = registro_evento_rescisao.timestamp             \n";
                $stFiltro .= "                 WHERE registro_evento_rescisao.cod_periodo_movimentacao = " . $inCodPeriodoMovimentacao . "          \n";
                $stFiltro .= "                   AND registro_evento_rescisao.cod_contrato = contrato.cod_contrato                              \n";
                $stFiltro .= "               )                                                                                                  \n";
                break;
        }
        $stSql .= $stFiltro;

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $codContratos
     *
     * @return array
     */
    public function montaRecuperaContratosReport($codContratos)
    {
        $sql = "
        SELECT * FROM (
	SELECT sw_cgm.numcgm
	     , sw_cgm.nom_cgm
	     , contrato.*
	     , recuperarSituacaoDoContratoLiteral(contrato.cod_contrato, 0, '') as situacao
	  FROM pessoal.contrato
	     , pessoal.servidor_contrato_servidor
	     , pessoal.servidor
	     , sw_cgm
	 WHERE contrato.cod_contrato = servidor_contrato_servidor.cod_contrato
	   AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
	   AND servidor.numcgm = sw_cgm.numcgm
	UNION
	SELECT sw_cgm.numcgm
	     , sw_cgm.nom_cgm
	     , contrato.*
	     , recuperarSituacaoDoContratoLiteral(contrato.cod_contrato, 0, '') as situacao
	  FROM pessoal.contrato
	     , pessoal.contrato_pensionista
	     , pessoal.pensionista
	     , sw_cgm
	 WHERE contrato.cod_contrato = contrato_pensionista.cod_contrato
	   AND contrato_pensionista.cod_pensionista = pensionista.cod_pensionista
	   AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente
	   AND pensionista.numcgm = sw_cgm.numcgm
	   ) as contrato WHERE registro is not null
	 AND cod_contrato in ($codContratos) order by nom_cgm;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * Recupera Contratos que não estão na tabela de aposentadoria
     *
     * @param $params
     *
     * @return array
     */
    public function montaRecuperaContratosNaoAposentadoria($params)
    {
        $params['exercicio'] = $params['exercicio'] . "-01-01";

        $sql = <<<SQL
SELECT
    sw_cgm.nom_cgm,
    contrato.cod_contrato,
    contrato.registro,
    ovw.orgao AS cod_estrutural,
    recuperaDescricaoOrgao(orgao.cod_orgao,
        :exercicio) AS descricao_lotacao
FROM
    pessoal.contrato,
    pessoal.servidor_contrato_servidor,
    pessoal.servidor,
    sw_cgm,
    pessoal.contrato_servidor_orgao, (
        SELECT
            cod_contrato,
            max(TIMESTAMP) AS TIMESTAMP
        FROM
            pessoal.contrato_servidor_orgao
        GROUP BY
            cod_contrato) AS max_contrato_orgao,
        organograma.orgao,
        organograma.organograma,
        organograma.orgao_nivel,
        organograma.nivel,
        organograma.vw_orgao_nivel AS ovw
    WHERE
        contrato.cod_contrato = servidor_contrato_servidor.cod_contrato
        AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
        AND servidor.numcgm = sw_cgm.numcgm
        AND contrato_servidor_orgao.cod_contrato = contrato.cod_contrato
        AND contrato_servidor_orgao.cod_contrato = max_contrato_orgao.cod_contrato
        AND contrato_servidor_orgao.timestamp = max_contrato_orgao.timestamp
        AND contrato_servidor_orgao.cod_orgao = orgao.cod_orgao
        AND organograma.cod_organograma = nivel.cod_organograma
        AND nivel.cod_organograma = orgao_nivel.cod_organograma
        AND nivel.cod_nivel = orgao_nivel.cod_nivel
        AND orgao_nivel.cod_orgao = orgao.cod_orgao
        AND orgao.cod_orgao = ovw.cod_orgao
        AND orgao_nivel.cod_organograma = ovw.cod_organograma
        AND nivel.cod_nivel = ovw.nivel
        AND NOT EXISTS (
            SELECT
                1
            FROM
                pessoal.aposentadoria
            WHERE
                aposentadoria.cod_contrato = contrato.cod_contrato
                AND NOT EXISTS (
                    SELECT
                        1
                    FROM
                        pessoal.aposentadoria_excluida
                    WHERE
                        aposentadoria_excluida.cod_contrato = aposentadoria.cod_contrato
                        AND aposentadoria_excluida.timestamp_aposentadoria = aposentadoria.timestamp))
                AND NOT EXISTS (
                    SELECT
                        1
                    FROM
                        pessoal.contrato_servidor_caso_causa
                    WHERE
                        contrato_servidor_caso_causa.cod_contrato = contrato.cod_contrato)
                    AND LOWER(nom_cgm) like :nomCgm
                ORDER BY
                    nom_cgm
SQL;
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute($params);
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @param $params
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByNomCgm($params)
    {
        $consultaContratoLegado = $this->montaRecuperaContratosNaoAposentadoria($params);

        $codContratoLista = [];
        foreach ($consultaContratoLegado as $codContrato) {
            $codContratoLista[] = $codContrato->cod_contrato;
        }

        $qb = $this->createQueryBuilder('cs');
        $qb->andWhere($qb->expr()->in('cs.codContrato', $codContratoLista));

        return $qb;
    }

    /**
     * @param $filtros
     *
     * @return array
     */
    public function recuperaContratosDeLotacao($filtros)
    {
        $sql = "
SELECT contrato.*
	     , sw_cgm.numcgm
	     , sw_cgm.nom_cgm
	  FROM (SELECT contrato_servidor_orgao.cod_contrato
	             , contrato_servidor_orgao.cod_orgao
	             , numcgm
	          FROM pessoal.contrato_servidor_orgao
	             , (  SELECT cod_contrato
	                       , MAX(timestamp) as timestamp
	                    FROM pessoal.contrato_servidor_orgao
	                GROUP BY cod_contrato) as max_contrato_servidor_orgao
	             , pessoal.servidor_contrato_servidor
	             , pessoal.servidor
	         WHERE contrato_servidor_orgao.cod_contrato = max_contrato_servidor_orgao.cod_contrato
	           AND contrato_servidor_orgao.timestamp = max_contrato_servidor_orgao.timestamp
	           AND contrato_servidor_orgao.cod_contrato = servidor_contrato_servidor.cod_contrato
	           AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
	         UNION
	        SELECT contrato_pensionista_orgao.cod_contrato
	             , contrato_pensionista_orgao.cod_orgao
	             , numcgm
	          FROM pessoal.contrato_pensionista_orgao
	             , (  SELECT cod_contrato
	                       , MAX(timestamp) as timestamp
	                    FROM pessoal.contrato_pensionista_orgao
	                GROUP BY cod_contrato) as max_contrato_pensionista_orgao
	             , pessoal.contrato_pensionista
	             , pessoal.pensionista
	         WHERE contrato_pensionista_orgao.cod_contrato = max_contrato_pensionista_orgao.cod_contrato
	           AND contrato_pensionista_orgao.timestamp = max_contrato_pensionista_orgao.timestamp
	           AND contrato_pensionista_orgao.cod_contrato = contrato_pensionista.cod_contrato
	           AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente
	           AND contrato_pensionista.cod_pensionista = pensionista.cod_pensionista) as servidor_pensionista
	     , pessoal.contrato
	     , folhapagamento.registro_evento_periodo
	     , sw_cgm
	 WHERE servidor_pensionista.cod_contrato = contrato.cod_contrato
	   AND contrato.cod_contrato = registro_evento_periodo.cod_contrato
	   AND servidor_pensionista.numcgm = sw_cgm.numcgm
	   AND contrato.cod_contrato NOT IN (SELECT cod_contrato
	                                       FROM pessoal.contrato_servidor_caso_causa )
	   AND cod_periodo_movimentacao = " . $filtros['cod_periodo_movimentacao'] . "
	   AND cod_orgao IN (" . $filtros['lotacoes'] . ")
	GROUP BY contrato.registro
	, contrato.cod_contrato
	       , sw_cgm.numcgm
	       , sw_cgm.nom_cgm
	 ORDER BY nom_cgm;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $filtros
     *
     * @return array
     */
    public function recuperaContratosDeLocal($filtros)
    {
        $sql = "
        SELECT contrato.*
         , sw_cgm.numcgm
         , sw_cgm.nom_cgm
      FROM (SELECT contrato_servidor_local.cod_contrato
                 , contrato_servidor_local.cod_local
                 , numcgm
              FROM pessoal.contrato_servidor_local
                 , (  SELECT cod_contrato
                           , MAX(timestamp) as timestamp
                        FROM pessoal.contrato_servidor_local
                    GROUP BY cod_contrato) as max_contrato_servidor_local
                 , pessoal.servidor_contrato_servidor
                 , pessoal.servidor
             WHERE contrato_servidor_local.cod_contrato = max_contrato_servidor_local.cod_contrato
               AND contrato_servidor_local.timestamp = max_contrato_servidor_local.timestamp
               AND contrato_servidor_local.cod_contrato = servidor_contrato_servidor.cod_contrato
               AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
             UNION
            SELECT contrato_pensionista.cod_contrato
                 , contrato_servidor_local.cod_local
                 , numcgm
              FROM pessoal.contrato_servidor_local
                 , (  SELECT cod_contrato
                           , MAX(timestamp) as timestamp
                        FROM pessoal.contrato_servidor_local
                    GROUP BY cod_contrato) as max_contrato_servidor_local
                 , pessoal.contrato_pensionista
                 , pessoal.pensionista
             WHERE contrato_servidor_local.cod_contrato = max_contrato_servidor_local.cod_contrato
               AND contrato_servidor_local.timestamp = max_contrato_servidor_local.timestamp
               AND contrato_servidor_local.cod_contrato = contrato_pensionista.cod_contrato_cedente
               AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente
               AND contrato_pensionista.cod_pensionista = pensionista.cod_pensionista) as servidor_pensionista
         , pessoal.contrato
         , folhapagamento.registro_evento_periodo
         , sw_cgm
     WHERE servidor_pensionista.cod_contrato = contrato.cod_contrato
       AND contrato.cod_contrato = registro_evento_periodo.cod_contrato
       AND servidor_pensionista.numcgm = sw_cgm.numcgm
       AND contrato.cod_contrato NOT IN (SELECT cod_contrato
                                           FROM pessoal.contrato_servidor_caso_causa )
       AND cod_periodo_movimentacao = " . $filtros['cod_periodo_movimentacao'] . "
       AND cod_local IN (" . $filtros['local'] . ")
    GROUP BY contrato.registro
           , contrato.cod_contrato
           , sw_cgm.numcgm
           , sw_cgm.nom_cgm";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $filtros
     *
     * @return array
     */
    public function recuperaContratosCalculados($filtros)
    {
        $sql = "
        SELECT *
	               FROM (SELECT contrato.registro
	                          , contrato.cod_contrato
	                          , servidor_contrato_servidor.numcgm
	                          , servidor_contrato_servidor.nom_cgm
	                          , servidor_contrato_servidor.cod_orgao          , evento_calculado.cod_evento
	             , registro_evento_periodo.cod_periodo_movimentacao
	                      FROM folhapagamento.registro_evento_periodo
	                         , (SELECT servidor_contrato_servidor.cod_contrato
	                                 , sw_cgm.numcgm
	                                 , sw_cgm.nom_cgm
	                                 , contrato_servidor_orgao.cod_orgao
	                  FROM pessoal.servidor_contrato_servidor
	                     , pessoal.servidor
	                         , sw_cgm
	                         , pessoal.contrato_servidor_orgao
	                         , (  SELECT contrato_servidor_orgao.cod_contrato
	                                    , max(timestamp) as timestamp
	                                 FROM pessoal.contrato_servidor_orgao
	                             GROUP BY contrato_servidor_orgao.cod_contrato) as max_contrato_servidor_orgao
	                     WHERE servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
	                       AND servidor.numcgm = sw_cgm.numcgm
	                       AND servidor_contrato_servidor.cod_contrato = contrato_servidor_orgao.cod_contrato
	                       AND contrato_servidor_orgao.cod_contrato = max_contrato_servidor_orgao.cod_contrato
	                       AND contrato_servidor_orgao.timestamp = max_contrato_servidor_orgao.timestamp
	                     UNION
	                    SELECT contrato_pensionista.cod_contrato
	                         , sw_cgm.numcgm
	                         , sw_cgm.nom_cgm
	                         , contrato_pensionista_orgao.cod_orgao
	                  FROM pessoal.contrato_pensionista
	                     , pessoal.pensionista
	                             , sw_cgm
	                             , pessoal.contrato_pensionista_orgao
	                             , (  SELECT contrato_pensionista_orgao.cod_contrato
	                                        , max(timestamp) as timestamp
	                                     FROM pessoal.contrato_pensionista_orgao
	                                 GROUP BY contrato_pensionista_orgao.cod_contrato) as max_contrato_pensionista_orgao
	                         WHERE contrato_pensionista.cod_pensionista = pensionista.cod_pensionista
	                           AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente
	                           AND pensionista.numcgm = sw_cgm.numcgm
	                           AND contrato_pensionista.cod_contrato = contrato_pensionista_orgao.cod_contrato
	                           AND contrato_pensionista_orgao.cod_contrato = max_contrato_pensionista_orgao.cod_contrato
	                           AND contrato_pensionista_orgao.timestamp = max_contrato_pensionista_orgao.timestamp
	                           ) as servidor_contrato_servidor
	                     , pessoal.contrato
	                     , folhapagamento.registro_evento
	                     , folhapagamento.ultimo_registro_evento
	                     , folhapagamento.evento_calculado
	                 WHERE registro_evento_periodo.cod_registro = registro_evento.cod_registro
	                   AND registro_evento.cod_registro = ultimo_registro_evento.cod_registro
	                   AND registro_evento.cod_evento = ultimo_registro_evento.cod_evento
	                   AND registro_evento.timestamp = ultimo_registro_evento.timestamp
	                   AND registro_evento.cod_registro = evento_calculado.cod_registro
	                   AND registro_evento.cod_evento = evento_calculado.cod_evento
	                   AND registro_evento.timestamp = evento_calculado.timestamp_registro
	                   AND registro_evento_periodo.cod_contrato = servidor_contrato_servidor.cod_contrato
	                   AND registro_evento_periodo.cod_contrato = contrato.cod_contrato
	                   AND registro_evento_periodo.cod_contrato NOT IN (SELECT cod_contrato
	                                           FROM pessoal.contrato_servidor_caso_causa )
	              GROUP BY contrato.registro
	                     , contrato.cod_contrato
	                     , servidor_contrato_servidor.numcgm
	                     , servidor_contrato_servidor.cod_orgao
	         , evento_calculado.cod_evento
	           , servidor_contrato_servidor.nom_cgm,registro_evento_periodo.cod_periodo_movimentacao) as contratos_calculados  WHERE contratos_calculados.cod_evento IN (" . $filtros['evento'] . ")
	                            AND contratos_calculados.cod_periodo_movimentacao =  " . $filtros['cod_periodo_movimentacao'] . "

	 ORDER BY nom_cgm";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @return array
     */
    public function recuperaContratoGeral()
    {
        $sql = "
       SELECT *
                  FROM (
                        SELECT
                                contrato.*
                                , servidor.numcgm
                                , (select nom_cgm from sw_cgm where numcgm = servidor.numcgm) as nom_cgm
                          FROM folhapagamento.registro_evento_periodo
                    INNER JOIN folhapagamento.registro_evento
                            ON registro_evento_periodo.cod_registro = registro_evento.cod_registro
                    INNER JOIN folhapagamento.ultimo_registro_evento
                            ON registro_evento.cod_registro = ultimo_registro_evento.cod_registro
                           AND registro_evento.cod_evento = ultimo_registro_evento.cod_evento
                           AND registro_evento.timestamp = ultimo_registro_evento.timestamp
                    INNER JOIN folhapagamento.contrato_servidor_periodo
                            ON contrato_servidor_periodo.cod_periodo_movimentacao = registro_evento_periodo.cod_periodo_movimentacao
                           AND contrato_servidor_periodo.cod_contrato = registro_evento_periodo.cod_contrato
                    INNER JOIN pessoal.contrato
                            ON contrato.cod_contrato = contrato_servidor_periodo.cod_contrato
                    INNER JOIN pessoal.contrato_servidor
                            ON contrato_servidor.cod_contrato = contrato.cod_contrato
                    INNER JOIN pessoal.servidor_contrato_servidor
                            ON servidor_contrato_servidor.cod_contrato = contrato_servidor.cod_contrato
                    INNER JOIN pessoal.servidor
                            ON servidor.cod_servidor = servidor_contrato_servidor.cod_servidor
                         WHERE NOT EXISTS ( SELECT 1
                                              FROM pessoal.contrato_servidor_caso_causa
                                             WHERE contrato_servidor_caso_causa.cod_contrato = servidor_contrato_servidor.cod_contrato
                                          )
                         UNION
                        SELECT contrato.*
                             , pensionista.numcgm
                             , (select nom_cgm from sw_cgm where numcgm = pensionista.numcgm) as nom_cgm
                          FROM folhapagamento.registro_evento_periodo
                    INNER JOIN folhapagamento.registro_evento
                            ON registro_evento_periodo.cod_registro = registro_evento.cod_registro

                    INNER JOIN folhapagamento.ultimo_registro_evento
                            ON registro_evento.cod_registro = ultimo_registro_evento.cod_registro
                           AND registro_evento.cod_evento = ultimo_registro_evento.cod_evento
                           AND registro_evento.timestamp = ultimo_registro_evento.timestamp
                    INNER JOIN pessoal.contrato_pensionista
                            ON registro_evento_periodo.cod_contrato = contrato_pensionista.cod_contrato
                    INNER JOIN pessoal.contrato
                            ON contrato.cod_contrato = contrato_pensionista.cod_contrato
                    INNER JOIN pessoal.pensionista
                            ON pensionista.cod_pensionista = contrato_pensionista.cod_pensionista
                           AND pensionista.cod_contrato_cedente = contrato_pensionista.cod_contrato_cedente
                           AND NOT EXISTS ( SELECT 1
                                                FROM pessoal.contrato_servidor_caso_causa
                                               WHERE contrato_servidor_caso_causa.cod_contrato = contrato_pensionista.cod_contrato)
                        ) AS tabela
                        GROUP BY cod_contrato, registro, numcgm, nom_cgm ORDER BY registro, nom_cgm;
                        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param        $filtro
     * @param string $entidade
     *
     * @return mixed
     */
    public function recuperaCgmDoRegistro($filtro, $entidade = '')
    {
        $stSql = "SELECT * FROM (
        SELECT sw_cgm.numcgm
             , sw_cgm.nom_cgm
             , contrato.*
             , recuperarSituacaoDoContratoLiteral(contrato.cod_contrato, 0, '" . $entidade . "') as situacao
          FROM pessoal.contrato
             , pessoal.servidor_contrato_servidor
             , pessoal.servidor
             , sw_cgm
         WHERE contrato.cod_contrato = servidor_contrato_servidor.cod_contrato
           AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
           AND servidor.numcgm = sw_cgm.numcgm
        UNION
        SELECT sw_cgm.numcgm
             , sw_cgm.nom_cgm
             , contrato.*
             , recuperarSituacaoDoContratoLiteral(contrato.cod_contrato, 0, '" . $entidade . "') as situacao
          FROM pessoal.contrato
             , pessoal.contrato_pensionista
             , pessoal.pensionista
             , sw_cgm
         WHERE contrato.cod_contrato = contrato_pensionista.cod_contrato
           AND contrato_pensionista.cod_pensionista = pensionista.cod_pensionista
           AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente
           AND pensionista.numcgm = sw_cgm.numcgm
           ) as contrato WHERE registro is not null ";

        if ($filtro) {
            $stSql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $queryResult = $query->fetchAll();
        $result = $queryResult;

        return $result;
    }

    /**
     * Retorna dados resumidos para o relatório de Folha Analitica Resumida
     *
     * @param integer $inCodConfiguracao
     * @param integer $inCodPeriodoMovimentacao
     * @param integer $inCodComplementar
     * @param string  $stFiltro
     * @param string  $stOrdenacao
     * @param integer $inCodAtributo
     * @param string  $stValorAtributo
     * @param string  $stEntidade
     * @param string  $stExercicio
     *
     * @return array
     */
    public function folhaAnaliticaResumida($inCodConfiguracao, $inCodPeriodoMovimentacao, $inCodComplementar, $stFiltro, $stOrdenacao, $inCodAtributo, $stValorAtributo, $stEntidade, $stExercicio)
    {
        $sql = <<<SQL
SELECT
    *
FROM
    folhaAnaliticaResumida (:inCodConfiguracao,
        :inCodPeriodoMovimentacao,
        :inCodComplementar,
        :stFiltro,
        :stOrdenacao,
        :inCodAtributo,
        :stValorAtributo,
        :stEntidade,
        :stExercicio) AS retorno
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":inCodConfiguracao", $inCodConfiguracao, \PDO::PARAM_INT);
        $query->bindValue(":inCodPeriodoMovimentacao", $inCodPeriodoMovimentacao, \PDO::PARAM_INT);
        $query->bindValue(":inCodComplementar", $inCodComplementar, \PDO::PARAM_INT);
        $query->bindValue(":stFiltro", $stFiltro, \PDO::PARAM_STR);
        $query->bindValue(":stOrdenacao", $stOrdenacao, \PDO::PARAM_STR);
        $query->bindValue(":inCodAtributo", $inCodAtributo, \PDO::PARAM_INT);
        $query->bindValue(":stValorAtributo", $stValorAtributo, \PDO::PARAM_STR);
        $query->bindValue(":stEntidade", $stEntidade, \PDO::PARAM_STR);
        $query->bindValue(":stExercicio", $stExercicio, \PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * Retorna os dados completos da folha analítica
     *
     * @param integer $inCodConfiguracao
     * @param integer $inCodPeriodoMovimentacao
     * @param integer $inCodComplementar
     * @param string  $stFiltro
     * @param string  $stOrdenacao
     * @param string  $stExercicio
     * @param integer $inCodAtributo
     * @param string  $stValorAtributo
     * @param string  $stEntidade
     *
     * @return array
     */
    public function folhaAnalitica($inCodConfiguracao, $inCodPeriodoMovimentacao, $inCodComplementar, $stFiltro, $stOrdenacao, $stExercicio, $inCodAtributo = 0, $stValorAtributo = '', $stEntidade = '')
    {
        $sql = <<<SQL
SELECT
    *
FROM
    folhaAnalitica (:inCodConfiguracao,
        :inCodPeriodoMovimentacao,
        :inCodComplementar,
        :stFiltro,
        :stOrdenacao,
        :inCodAtributo,
        :stValorAtributo,
        :stEntidade,
        :stExercicio) AS retorno;
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":inCodConfiguracao", $inCodConfiguracao, \PDO::PARAM_INT);
        $query->bindValue(":inCodPeriodoMovimentacao", $inCodPeriodoMovimentacao, \PDO::PARAM_INT);
        $query->bindValue(":inCodComplementar", $inCodComplementar, \PDO::PARAM_INT);
        $query->bindValue(":stFiltro", $stFiltro, \PDO::PARAM_STR);
        $query->bindValue(":stOrdenacao", $stOrdenacao, \PDO::PARAM_STR);
        $query->bindValue(":inCodAtributo", $inCodAtributo, \PDO::PARAM_INT);
        $query->bindValue(":stValorAtributo", $stValorAtributo, \PDO::PARAM_STR);
        $query->bindValue(":stEntidade", $stEntidade, \PDO::PARAM_STR);
        $query->bindValue(":stExercicio", $stExercicio, \PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * Traz os dados detalhados da folha analítica por natureza
     *
     * @param        $inCodConfiguracao
     * @param        $inCodContrato
     * @param        $inCodPeriodoMovimentacao
     * @param        $inCodComplementar
     * @param        $stOrdenacao
     * @param        $stNaturezaE
     * @param        $stNaturezaD
     * @param string $stEntidade
     *
     * @return array
     */
    public function eventosCalculadosFolhaAnalitica($inCodConfiguracao, $inCodContrato, $inCodPeriodoMovimentacao, $inCodComplementar, $stOrdenacao, $stNaturezaE, $stNaturezaD, $stEntidade = '')
    {
        $sql = <<<SQL
SELECT
    *
FROM
    eventosCalculadosFolhaAnalitica (:inCodConfiguracao,
        :inCodContrato,
        :inCodPeriodoMovimentacao,
        :inCodComplementar,
        :stOrdenacao,
        :stNaturezaE,
        :stNaturezaD,
        :stEntidade) AS retorno;
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":inCodConfiguracao", $inCodConfiguracao, \PDO::PARAM_INT);
        $query->bindValue(":inCodContrato", $inCodContrato, \PDO::PARAM_INT);
        $query->bindValue(":inCodPeriodoMovimentacao", $inCodPeriodoMovimentacao, \PDO::PARAM_INT);
        $query->bindValue(":inCodComplementar", $inCodComplementar, \PDO::PARAM_INT);
        $query->bindValue(":stOrdenacao", $stOrdenacao, \PDO::PARAM_STR);
        $query->bindValue(":stNaturezaE", $stNaturezaE, \PDO::PARAM_INT);
        $query->bindValue(":stNaturezaD", $stNaturezaD, \PDO::PARAM_STR);
        $query->bindValue(":stEntidade", $stEntidade, \PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * Retorna os dados completos da folha sintética
     *
     * @param integer $inCodConfiguracao
     * @param integer $inCodPeriodoMovimentacao
     * @param integer $inCodComplementar
     * @param string  $stFiltro
     * @param string  $stOrdenacao
     * @param string  $stExercicio
     * @param integer $inCodAtributo
     * @param string  $stValorAtributo
     * @param string  $stEntidade
     *
     * @return array
     */
    public function folhaSintetica($inCodConfiguracao, $inCodPeriodoMovimentacao, $inCodComplementar, $stFiltro, $stOrdenacao, $stExercicio, $inCodAtributo = 0, $stValorAtributo = '', $stEntidade = '')
    {
        $sql = <<<SQL
SELECT
    *
FROM
    folhaSintetica (:inCodConfiguracao,
        :inCodPeriodoMovimentacao,
        :inCodComplementar,
        :stFiltro,
        :stOrdenacao,
        :inCodAtributo,
        :stValorAtributo,
        :stEntidade,
        :stExercicio) AS retorno
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":inCodConfiguracao", $inCodConfiguracao, \PDO::PARAM_INT);
        $query->bindValue(":inCodPeriodoMovimentacao", $inCodPeriodoMovimentacao, \PDO::PARAM_INT);
        $query->bindValue(":inCodComplementar", $inCodComplementar, \PDO::PARAM_INT);
        $query->bindValue(":stFiltro", $stFiltro, \PDO::PARAM_STR);
        $query->bindValue(":stOrdenacao", $stOrdenacao, \PDO::PARAM_STR);
        $query->bindValue(":inCodAtributo", $inCodAtributo, \PDO::PARAM_INT);
        $query->bindValue(":stValorAtributo", $stValorAtributo, \PDO::PARAM_STR);
        $query->bindValue(":stEntidade", $stEntidade, \PDO::PARAM_STR);
        $query->bindValue(":stExercicio", $stExercicio, \PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $filtro
     *
     * @return array
     */
    public function carregaContratoAposentadoria($filtro)
    {
        $sql = <<<SQL
SELECT sw_cgm.numcgm                                                        
	     , sw_cgm.nom_cgm                                                       
	     , contrato.*                                                           
	     , recuperarSituacaoDoContratoLiteral(contrato.cod_contrato, 0, '') as situacao 
	  FROM sw_cgm                                                               
	   	, pessoal.contrato                                                     
	     , pessoal.servidor_contrato_servidor                                   
	     , pessoal.servidor                                                     
	     , pessoal.contrato_servidor                                            
	 WHERE contrato.cod_contrato = servidor_contrato_servidor.cod_contrato      
	   AND servidor_contrato_servidor.cod_servidor = servidor.cod_servidor      
	   AND servidor.numcgm = sw_cgm.numcgm                                      
	   AND contrato_servidor.cod_contrato = contrato.cod_contrato               
	   AND contrato.cod_contrato NOT IN ( 							                       			
	 		  SELECT contrato_pensionista.cod_contrato FROM pessoal.contrato_pensionista      			
	   )															 				           			
	   AND contrato.cod_contrato NOT IN(										    		   			
	  	  SELECT contrato_servidor_caso_causa.cod_contrato FROM pessoal.contrato_servidor_caso_causa
	   )   																	               
	   AND contrato.cod_contrato NOT IN(										    		   			
	  	  SELECT cod_contrato from pessoal.aposentadoria											
	   )
SQL;
        if (is_numeric($filtro)) {
            $sql .= "
             AND (registro = :filtro OR sw_cgm.numcgm = :filtro)
            ";
        } else {
            $sql .= "
            AND lower (nom_cgm)
            LIKE lower (:filtro)
            || '%'
            ";
        }

        $sql .= "
        ORDER BY
            nom_cgm;
        ";


        $query = $this->_em->getConnection()->prepare($sql);
        if (is_numeric($filtro)) {
            $query->bindValue(":filtro", $filtro, \PDO::PARAM_INT);
        } else {
            $query->bindValue(":filtro", "%" . $filtro . "%", \PDO::PARAM_STR);
        }

        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $filtro
     *
     * @return array
     */
    public function carregaContratoCgmPensionista($filtro)
    {
        $sql = <<<SQL
select
    sw_cgm.numcgm,
    sw_cgm.nom_cgm,
    contrato.registro
from
    pessoal.contrato,
    pessoal.contrato_pensionista,
    pessoal.pensionista,
    sw_cgm
where
    contrato.cod_contrato = contrato_pensionista.cod_contrato
    and contrato_pensionista.cod_pensionista = pensionista.cod_pensionista
    and contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente
    and pensionista.numcgm = sw_cgm.numcgm
SQL;
        if (is_numeric($filtro)) {
            $sql .= "
             AND (registro = :filtro OR sw_cgm.numcgm = :filtro)
            ";
        } else {
            $sql .= "
            AND lower (sw_cgm.nom_cgm)
            LIKE lower (:filtro)
            || '%'
            ";
        }

        $sql .= "
        ORDER BY
            nom_cgm;
        ";


        $query = $this->_em->getConnection()->prepare($sql);
        if (is_numeric($filtro)) {
            $query->bindValue(":filtro", $filtro, \PDO::PARAM_INT);
        } else {
            $query->bindValue(":filtro", "%" . $filtro . "%", \PDO::PARAM_STR);
        }

        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $params
     * @param $stFiltro
     * @param $stOrder
     *
     * @return array
     */
    public function recuperaContratosAutomaticos($params, $stFiltro, $stOrder)
    {
        $numCgm = $params['numCgm'];

        $stSql = "SELECT registro_evento_decimo.cod_contrato 
           , registro 
           , sw_cgm.numcgm 
           , sw_cgm.nom_cgm 
        FROM folhapagamento.registro_evento_decimo 
           , folhapagamento.ultimo_registro_evento_decimo 
               , (SELECT servidor_contrato_servidor.cod_contrato                             
                       , servidor.numcgm                                                     
                    FROM pessoal.servidor_contrato_servidor                                  
                       , pessoal.servidor                                                    
                   WHERE servidor_contrato_servidor.cod_servidor = servidor.cod_servidor     
                   UNION                                                                     
                  SELECT contrato_pensionista.cod_contrato                                   
                       , pensionista.numcgm                                                  
                    FROM pessoal.contrato_pensionista                                        
                       , pessoal.pensionista                                                 
                   WHERE contrato_pensionista.cod_pensionista = pensionista.cod_pensionista  
                     AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente) as servidor_contrato_servidor
           , pessoal.contrato 
           , sw_cgm 
       WHERE registro_evento_decimo.cod_registro = ultimo_registro_evento_decimo.cod_registro 
         AND registro_evento_decimo.cod_evento  = ultimo_registro_evento_decimo.cod_evento 
         AND registro_evento_decimo.desdobramento  = ultimo_registro_evento_decimo.desdobramento 
         AND registro_evento_decimo.timestamp  = ultimo_registro_evento_decimo.timestamp 
         AND registro_evento_decimo.cod_contrato  = servidor_contrato_servidor.cod_contrato 
         AND servidor_contrato_servidor.cod_contrato = contrato.cod_contrato 
         AND servidor_contrato_servidor.numcgm = sw_cgm.numcgm 
         AND cod_periodo_movimentacao = :codPeriodoMovimentacao ";

        if (!empty($numCgm)) {
            $stSql .= " AND sw_cgm.numcgm IN  (" . implode(',', $numCgm) . ") ";
        }

        $stSql .= " AND contrato.cod_contrato NOT IN (SELECT cod_contrato FROM pessoal.contrato_servidor_caso_causa) 
         AND EXISTS (SELECT 1                                                                                            
                       FROM folhapagamento.concessao_decimo                                                              
                      WHERE concessao_decimo.cod_periodo_movimentacao = registro_evento_decimo.cod_periodo_movimentacao  
                        AND concessao_decimo.cod_contrato = registro_evento_decimo.cod_contrato                          
                        AND concessao_decimo.folha_salario IS FALSE)                                                     
    GROUP BY registro_evento_decimo.cod_contrato 
           , registro 
           , sw_cgm.numcgm 
           , sw_cgm.nom_cgm";

        if ($stFiltro) {
            $stSql .= $stFiltro;
        }

        $stSql .= ($stOrder) ? $stOrder : " ORDER BY nom_cgm";
        $query = $this->_em->getConnection()->prepare($stSql);
        $query->bindValue(":codPeriodoMovimentacao", $params['codPeriodoMovimentacao'], \PDO::PARAM_STR);
        $query->execute();
        $queryResult = $query->fetchAll();
        $result = $queryResult;

        return $result;
    }

    /**
     * @param $params
     * @param $codPeriodoMovimentacao
     * @param $entidade
     *
     * @return array
     */
    public function recuperaContratosConcessaoDecimo($params, $codPeriodoMovimentacao, $entidade)
    {
        $stSql = "
            SELECT contrato.*
                 , servidor.numcgm
                 , sw_cgm.nom_cgm
              FROM pessoal.contrato
        INNER JOIN pessoal.servidor_contrato_servidor
                ON servidor_contrato_servidor.cod_contrato = contrato.cod_contrato
        INNER JOIN pessoal.servidor
                ON servidor.cod_servidor = servidor_contrato_servidor.cod_servidor
        INNER JOIN sw_cgm
                ON sw_cgm.numcgm = servidor.numcgm

        INNER JOIN ultimo_contrato_servidor_orgao('" . $entidade . "', " . $codPeriodoMovimentacao . " ) as contrato_servidor_orgao
                ON contrato_servidor_orgao.cod_contrato = contrato.cod_contrato

         LEFT JOIN ultimo_contrato_servidor_local('" . $entidade . "', " . $codPeriodoMovimentacao . " ) as contrato_servidor_local
                ON contrato_servidor_local.cod_contrato = contrato.cod_contrato

         LEFT JOIN ultimo_contrato_servidor_regime_funcao('" . $entidade . "', " . $codPeriodoMovimentacao . " ) as contrato_servidor_regime_funcao
                ON contrato_servidor_regime_funcao.cod_contrato = contrato.cod_contrato

         LEFT JOIN ultimo_contrato_servidor_sub_divisao_funcao('" . $entidade . "', " . $codPeriodoMovimentacao . " ) as contrato_servidor_sub_divisao_funcao
                ON contrato_servidor_sub_divisao_funcao.cod_contrato = contrato.cod_contrato

         LEFT JOIN ultimo_contrato_servidor_funcao('" . $entidade . "', " . $codPeriodoMovimentacao . " ) as contrato_servidor_funcao
                ON contrato_servidor_funcao.cod_contrato = contrato.cod_contrato

         LEFT JOIN ultimo_contrato_servidor_especialidade_funcao('" . $entidade . "', " . $codPeriodoMovimentacao . " ) as contrato_servidor_especialidade_funcao
                ON contrato_servidor_especialidade_funcao.cod_contrato = contrato.cod_contrato

             WHERE NOT EXISTS ( SELECT 1
                                  FROM pessoal.contrato_servidor_caso_causa
                                 WHERE contrato_servidor_caso_causa.cod_contrato = contrato.cod_contrato
                              )
    ";

        if (isset($params["inCodOrgao"])) {
            $stSql .= " AND contrato_servidor_orgao.cod_orgao IN (" . $params["inCodOrgao"] . ")";
        }

        if (isset($params["inCodLocal"])) {
            $stSql .= " AND contrato_servidor_local.cod_local IN ( " . $params["inCodLocal"] . " )";
        }

        if (isset($params["inCodRegime"])) {
            $stSql .= " AND contrato_servidor_regime_funcao.cod_regime_funcao in ( " . $params["inCodRegime"] . " ) ";
        }

        if (isset($params["inCodSubDivisao"])) {
            $stSql .= " AND contrato_servidor_sub_divisao_funcao.cod_sub_divisao_funcao in ( " . $params["inCodSubDivisao"] . " ) ";
        }

        if (isset($params["inCodCargo"])) {
            $stSql .= " AND contrato_servidor_funcao.cod_cargo in ( " . $params["inCodCargo"] . " ) ";
        }

        if (isset($params["inCodEspecialidade"])) {
            $stSql .= " AND contrato_servidor_especialidade_funcao.cod_especialidade_funcao in ( " . $params["inCodEspecialidade"] . " ) ";
        }

        $stSql .= "
             UNION
            SELECT contrato.*
                 , pensionista.numcgm
                 , sw_cgm.nom_cgm
              FROM pessoal.contrato
        INNER JOIN pessoal.contrato_pensionista
                ON contrato_pensionista.cod_contrato = contrato.cod_contrato
        INNER JOIN pessoal.pensionista
                ON pensionista.cod_pensionista = contrato_pensionista.cod_pensionista
               AND pensionista.cod_contrato_cedente = contrato_pensionista.cod_contrato_cedente
        INNER JOIN sw_cgm
                ON sw_cgm.numcgm = pensionista.numcgm
        INNER JOIN ultimo_contrato_pensionista_orgao('" . $entidade . "', " . $codPeriodoMovimentacao . " ) as contrato_servidor_orgao
                ON contrato_servidor_orgao.cod_contrato = contrato.cod_contrato
         LEFT JOIN ultimo_contrato_servidor_local('" . $entidade . "', " . $codPeriodoMovimentacao . " ) as contrato_servidor_local
                ON contrato_servidor_local.cod_contrato = contrato.cod_contrato
         LEFT JOIN ultimo_contrato_servidor_regime_funcao('" . $entidade . "', " . $codPeriodoMovimentacao . " ) as contrato_servidor_regime_funcao
                ON contrato_servidor_regime_funcao.cod_contrato = contrato.cod_contrato
         LEFT JOIN ultimo_contrato_servidor_sub_divisao_funcao('" . $entidade . "', " . $codPeriodoMovimentacao . " ) as contrato_servidor_sub_divisao_funcao
                ON contrato_servidor_sub_divisao_funcao.cod_contrato = contrato.cod_contrato
         LEFT JOIN ultimo_contrato_servidor_funcao('" . $entidade . "', " . $codPeriodoMovimentacao . " ) as contrato_servidor_funcao
                ON contrato_servidor_funcao.cod_contrato = contrato.cod_contrato
         LEFT JOIN ultimo_contrato_servidor_especialidade_funcao('" . $entidade . "', " . $codPeriodoMovimentacao . " ) as contrato_servidor_especialidade_funcao
                ON contrato_servidor_especialidade_funcao.cod_contrato = contrato.cod_contrato
             WHERE 1=1 ";

        if (isset($params["inCodOrgao"])) {
            $stSql .= " AND contrato_servidor_orgao.cod_orgao IN (" . $params["inCodOrgao"] . ")";
        }

        if (isset($params["inCodLocal"])) {
            $stSql .= " AND contrato_servidor_local.cod_local IN ( " . $params["inCodLocal"] . " )";
        }

        if (isset($params["inCodRegime"])) {
            $stSql .= " AND contrato_servidor_regime_funcao.cod_regime_funcao in ( " . $params["inCodRegime"] . " ) ";
        }

        if (isset($params["inCodSubDivisao"])) {
            $stSql .= " AND contrato_servidor_sub_divisao_funcao.cod_sub_divisao_funcao in ( " . $params["inCodSubDivisao"] . " ) ";
        }

        if (isset($params["inCodCargo"])) {
            $stSql .= " AND contrato_servidor_funcao.cod_cargo in ( " . $params["inCodCargo"] . " ) ";
        }

        if (isset($params["inCodEspecialidade"])) {
            $stSql .= " AND contrato_servidor_especialidade_funcao.cod_especialidade_funcao in ( " . $params["inCodEspecialidade"] . " ) ";
        }

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $queryResult = $query->fetchAll();
        $result = $queryResult;

        return $result;
    }

    /**
     * @param string $tipo
     * @param string $valor
     * @param string $exercicio
     * @return array
     */
    public function filtraContratoServidor($tipo, $valor, $exercicio)
    {
        $sql = "
            SELECT * FROM (
                select servidor.cod_contrato
                  , servidor.registro
                  , servidor.numcgm
                  , servidor.nom_cgm
                  , servidor.cod_orgao
                  , servidor.desc_orgao as descricao_lotacao
                  , servidor.orgao as cod_estrutural
                  , servidor.cod_especialidade_cargo
                  , servidor.cod_cargo
                  , recuperarSituacaoDoContratoLiteral(servidor.cod_contrato,0,'') as situacao
                  , servidor.cod_especialidade_funcao
                  , servidor.cod_funcao
                  , servidor.cod_padrao
                  , servidor.cod_local
                from recuperarContratoServidor('cgm,oo','',0,:tipo,:valor,:exercicio) as servidor
                UNION
                select pensionista.cod_contrato
                  , pensionista.registro
                  , pensionista.numcgm
                  , pensionista.nom_cgm
                  , pensionista.cod_orgao
                  , pensionista.desc_orgao as descricao_lotacao
                  , pensionista.orgao as cod_estrutural
                  , 0 as cod_especialidade
                  , 0 as cod_cargo
                  , recuperarSituacaoDoContratoLiteral(pensionista.cod_contrato,0,'') as situacao
                  , 0 as cod_especialidade_funcao
                  , 0 as cod_funcao
                  , 0 as cod_padrao
                  , 0 as cod_local
                from recuperarContratoPensionista('cgm,oo','',0,:tipo,:valor,:exercicio) as pensionista
              ) as contrato
            WHERE recuperarSituacaoDoContrato(contrato.cod_contrato,0,'') IN ('A','P','E')
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":tipo", $tipo, \PDO::PARAM_STR);
        $query->bindValue(":valor", $valor, \PDO::PARAM_STR);
        $query->bindValue(":exercicio", $exercicio, \PDO::PARAM_STR);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param integer $codContrato
     * @return array
     */
    public function filtraContratoServidorByCodContrato($codContrato)
    {
        $sql = "
            SELECT * FROM (
                select servidor.cod_contrato
                  , servidor.registro
                  , servidor.numcgm
                  , servidor.nom_cgm
                  , CONCAT(servidor.numcgm, ' - ', servidor.nom_cgm) as servidor
                  , servidor.cod_orgao
                  , servidor.desc_orgao as descricao_lotacao
                  , servidor.orgao as cod_estrutural
                  , CONCAT(servidor.orgao, ' - ', servidor.desc_orgao) as lotacao
                  , servidor.cod_especialidade_cargo
                  , servidor.cod_cargo
                  , recuperarSituacaoDoContratoLiteral(servidor.cod_contrato,0,'') as situacao
                  , servidor.cod_especialidade_funcao
                  , servidor.cod_funcao
                  , servidor.cod_padrao
                  , servidor.cod_local
                from recuperarContratoServidor('cgm,oo','',0,'','','') as servidor
                UNION
                select pensionista.cod_contrato
                  , pensionista.registro
                  , pensionista.numcgm
                  , pensionista.nom_cgm
                  , CONCAT(pensionista.numcgm, ' - ', pensionista.nom_cgm) as servidor
                  , pensionista.cod_orgao
                  , pensionista.desc_orgao as descricao_lotacao
                  , pensionista.orgao as cod_estrutural
                  , CONCAT(pensionista.orgao, ' - ', pensionista.desc_orgao) as lotacao
                  , 0 as cod_especialidade
                  , 0 as cod_cargo
                  , recuperarSituacaoDoContratoLiteral(pensionista.cod_contrato,0,'') as situacao
                  , 0 as cod_especialidade_funcao
                  , 0 as cod_funcao
                  , 0 as cod_padrao
                  , 0 as cod_local
                from recuperarContratoPensionista('cgm,oo','',0,'','','') as pensionista
              ) as contrato
            WHERE recuperarSituacaoDoContrato(contrato.cod_contrato,0,'') IN ('A','P','E')
            AND cod_contrato = :codContrato
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":codContrato", $codContrato, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param integer $codPeriodoMovimentacao
     * @param integer $codComplementar
     * @param string $tipo
     * @param string $valor
     * @return array
     */
    public function montaRecuperaContratosCalculoComplementar($codPeriodoMovimentacao, $codComplementar, $tipo, $valor)
    {
        if ($tipo == CalculoComplementarAdmin::COD_FILTRAR_LOTACAO) {
            $sql = "
                SELECT * FROM ( 
                    SELECT contrato.*                                                        
                         , sw_cgm.numcgm                                                     
                         , sw_cgm.nom_cgm                                                    
                      FROM pessoal.contrato                                                  
                      JOIN pessoal.servidor_contrato_servidor                                
                        ON contrato.cod_contrato = servidor_contrato_servidor.cod_contrato   
                      JOIN pessoal.servidor                                                  
                        ON servidor_contrato_servidor.cod_servidor = servidor.cod_servidor   
                      JOIN sw_cgm                                                            
                        ON servidor.numcgm = sw_cgm.numcgm                                   
                      JOIN pessoal.contrato_servidor                                         
                        ON contrato_servidor.cod_contrato = contrato.cod_contrato            
                      JOIN pessoal.contrato_servidor_orgao                                                   
                        ON contrato.cod_contrato = contrato_servidor_orgao.cod_contrato                      
                      JOIN (  SELECT cod_contrato                                                            
                                   , MAX(timestamp) as timestamp                                             
                                FROM pessoal.contrato_servidor_orgao                                         
                            GROUP BY cod_contrato) as max_contrato_servidor_orgao                            
                        ON contrato_servidor_orgao.cod_contrato = max_contrato_servidor_orgao.cod_contrato   
                       AND contrato_servidor_orgao.timestamp = max_contrato_servidor_orgao.timestamp         
                       AND contrato_servidor_orgao.cod_orgao IN (" . implode(',', $valor) . ")                          
                     WHERE recuperarSituacaoDoContrato(contrato.cod_contrato, 0, '') in ('A','P','R') 
                    UNION 
                    SELECT contrato.*                                                                    
                         , pensionista.numcgm                                                            
                         , (SELECT nom_cgm FROM sw_cgm WHERE numcgm = pensionista.numcgm) as nom_cgm     
                      FROM pessoal.contrato                                                              
                      JOIN pessoal.contrato_pensionista                                                  
                        ON (contrato.cod_contrato = contrato_pensionista.cod_contrato)                   
                      JOIN pessoal.pensionista                                                           
                        ON contrato_pensionista.cod_pensionista = pensionista.cod_pensionista            
                       AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente  
                       JOIN pessoal.contrato_pensionista_orgao                                                     
                         ON contrato.cod_contrato = contrato_pensionista.cod_contrato                              
                       JOIN (  SELECT cod_contrato                                                                 
                                    , max(timestamp) as timestamp                                                  
                                 FROM pessoal.contrato_pensionista_orgao                                           
                             GROUP BY cod_contrato) as max_contrato_pensionista_orgao                              
                         ON contrato_pensionista_orgao.cod_contrato = max_contrato_pensionista_orgao.cod_contrato  
                        AND contrato_pensionista_orgao.timestamp = max_contrato_pensionista_orgao.timestamp        
                        AND contrato_pensionista_orgao.cod_orgao IN (" . implode(',', $valor) . ")                            
                     ) as contrato 
                     WHERE EXISTS ( SELECT 1                                                                                                      
                                      FROM folhapagamento.registro_evento_complementar                                                            
                                      JOIN folhapagamento.ultimo_registro_evento_complementar                                                     
                                        ON ultimo_registro_evento_complementar.cod_registro = registro_evento_complementar.cod_registro           
                                       AND ultimo_registro_evento_complementar.cod_evento = registro_evento_complementar.cod_evento               
                                       AND ultimo_registro_evento_complementar.cod_configuracao = registro_evento_complementar.cod_configuracao   
                                       AND ultimo_registro_evento_complementar.timestamp = registro_evento_complementar.timestamp                 
                                     WHERE registro_evento_complementar.cod_periodo_movimentacao = :codPeriodoMovimentacao                  
                                       AND registro_evento_complementar.cod_complementar = :codComplementar                                 
                                       AND registro_evento_complementar.cod_contrato = contrato.cod_contrato                                      
                                  )                                                                                                               
                     ORDER BY nom_cgm, numcgm
            ";
        } else {
            $filtrarContratos = '';
            if ($tipo == CalculoComplementarAdmin::COD_FILTRAR_CGM_MATRICULA) {
                $filtrarContratos = ' AND registro_evento_complementar.cod_contrato IN (' . implode(',', $valor) . ') ';
            }

            $sql = "
                SELECT * FROM (
                    SELECT contrato.*
                      , sw_cgm.numcgm
                      , sw_cgm.nom_cgm
                    FROM pessoal.contrato
                      JOIN pessoal.servidor_contrato_servidor
                        ON contrato.cod_contrato = servidor_contrato_servidor.cod_contrato
                      JOIN pessoal.servidor
                        ON servidor_contrato_servidor.cod_servidor = servidor.cod_servidor
                      JOIN sw_cgm
                        ON servidor.numcgm = sw_cgm.numcgm
                      JOIN pessoal.contrato_servidor
                        ON contrato_servidor.cod_contrato = contrato.cod_contrato
                    WHERE recuperarSituacaoDoContrato(contrato.cod_contrato, 0, '') in ('A','P','R')
                    UNION
                    SELECT contrato.*
                      , pensionista.numcgm
                      , (SELECT nom_cgm FROM sw_cgm WHERE numcgm = pensionista.numcgm) as nom_cgm
                    FROM pessoal.contrato
                      JOIN pessoal.contrato_pensionista
                        ON (contrato.cod_contrato = contrato_pensionista.cod_contrato)
                      JOIN pessoal.pensionista
                        ON contrato_pensionista.cod_pensionista = pensionista.cod_pensionista
                           AND contrato_pensionista.cod_contrato_cedente = pensionista.cod_contrato_cedente
                  ) as contrato
                WHERE EXISTS ( SELECT 1
                               FROM folhapagamento.registro_evento_complementar
                                 JOIN folhapagamento.ultimo_registro_evento_complementar
                                   ON ultimo_registro_evento_complementar.cod_registro = registro_evento_complementar.cod_registro
                                      AND ultimo_registro_evento_complementar.cod_evento = registro_evento_complementar.cod_evento
                                      AND ultimo_registro_evento_complementar.cod_configuracao = registro_evento_complementar.cod_configuracao
                                      {$filtrarContratos}
                                      AND ultimo_registro_evento_complementar.timestamp = registro_evento_complementar.timestamp
                               WHERE registro_evento_complementar.cod_periodo_movimentacao = :codPeriodoMovimentacao
                                     AND registro_evento_complementar.cod_complementar = :codComplementar
                                     AND registro_evento_complementar.cod_contrato = contrato.cod_contrato
                )
                ORDER BY nom_cgm, numcgm
            ";
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":codPeriodoMovimentacao", $codPeriodoMovimentacao, \PDO::PARAM_INT);
        $query->bindValue(":codComplementar", $codComplementar, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param $stCodContrato
     * @param $stTipoFolha
     * @param $inCodComplementar
     * @return mixed
     */
    public function deletarInformacoesCalculo($stCodContrato, $stTipoFolha, $inCodComplementar)
    {
        $sql = "SELECT deletarInformacoesCalculo(:stCodContrato, :stTipoFolha, :inCodComplementar, '') as retorno";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue(":stCodContrato", $stCodContrato, \PDO::PARAM_STR);
        $query->bindValue(":stTipoFolha", $stTipoFolha, \PDO::PARAM_STR);
        $query->bindValue(":inCodComplementar", $inCodComplementar, \PDO::PARAM_INT);
        $query->execute();

        return $query->fetch(\PDO::FETCH_OBJ);
    }
}
