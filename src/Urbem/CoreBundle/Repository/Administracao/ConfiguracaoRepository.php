<?php

namespace Urbem\CoreBundle\Repository\Administracao;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Divida\Modalidade;
use Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia;

class ConfiguracaoRepository extends ORM\EntityRepository
{
    const TABLE_ADMINISTRACAO_CONFIGURACAO = "SELECT * FROM administracao.configuracao_entidade";

    public function getConfiguracao(array $paramsWhere, $paramsExtra = null)
    {
        $sql = sprintf(
            "%s WHERE %s",
            self::TABLE_ADMINISTRACAO_CONFIGURACAO,
            implode(" AND ", $paramsWhere)
        );
        $sql .= $paramsExtra ? " ".$paramsExtra : "";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getAtributosDinamicosPorModuloeExercicio($info)
    {
        $sql = sprintf(
            "SELECT * FROM administracao.configuracao WHERE exercicio = '%s' AND cod_modulo = '%s'",
            $info['exercicio'],
            $info['cod_modulo']
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $info
     */
    public function updateAtributosDinamicos($info)
    {
        try {
            $this->update($info);
        } catch (\Exception $e) {
            $this->persist($info);
        }
    }

    /**
     * @param $info
     */
    public function persist($info)
    {
        $configuracao = new Configuracao();
        $configuracao->setValor($info['valor']);
        $configuracao->setCodModulo($info['cod_modulo']);
        $configuracao->setParametro($info['parametro']);
        $configuracao->setExercicio($info['exercicio']);

        $this->_em->persist($configuracao);
        $this->_em->flush($configuracao);
    }

    /**
     * @param $info
     * @throws \Exception
     */
    public function update($info)
    {
        $configuracao = $this->findOneBy(['exercicio' => $info['exercicio'], 'codModulo' => $info['cod_modulo'], 'parametro' => $info['parametro']]);
        if (empty($configuracao)) {
            throw new \Exception();
        }
        $configuracao->setValor($info['valor']);
        $this->_em->flush($configuracao);
    }



    public function getAtributosDinamicosPorModuloeExercicioParametro($info)
    {
        $sql = sprintf(
            "SELECT * FROM administracao.configuracao WHERE exercicio = '%s' AND cod_modulo = '%s' AND parametro = '%s'",
            $info['exercicio'],
            $info['cod_modulo'],
            $info['parametro']
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return current($query->fetchAll());
    }

    public function montaRecuperaEntidadeGeral($exercicio)
    {
        $stSql  = " SELECT                                   \n";
        $stSql .= "     C.numcgm,                            \n";
        $stSql .= "     C.nom_cgm,                           \n";
        $stSql .= "     E.cod_entidade                       \n";
        $stSql .= " FROM                                     \n";
        $stSql .= "     orcamento.entidade      as   E,      \n";
        $stSql .= "     sw_cgm                  as   C       \n";
        $stSql .= " WHERE                                    \n";
        $stSql .= "     E.numcgm = C.numcgm                  \n";
        if ($exercicio) {
            $stSql .= " AND E.exercicio = '".$exercicio.    "'\n";
        }
        $stSql .= "GROUP BY                                  \n";
        $stSql .= "     C.numcgm,                            \n";
        $stSql .= "     C.nom_cgm,                           \n";
        $stSql .= "     E.cod_entidade                       \n";
        $stSql .= "ORDER BY                                  \n";
        $stSql .= "     C.nom_cgm                            \n";

        $query = $this->_em->getConnection()->prepare($stSql);

        $query->execute();
        return $query->fetchAll();
    }

    public function selectInsertUpdateAtributosDinamicos($info)
    {
        $sql = sprintf(
            "%s WHERE exercicio = '%s' AND cod_modulo = '%s' AND parametro = '%s' AND cod_entidade = '%s'",
            self::TABLE_ADMINISTRACAO_CONFIGURACAO,
            $info['exercicio'],
            $info['cod_modulo'],
            $info['campo'],
            $info['cod_entidade']
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        if (count($result) > 0) {
            $this->updateConfiguracaoEntidade($info);
        } else {
            $this->insertConfiguracaoEntidade($info);
        }
    }

    public function selectAtributosDinamicosEntidade($info)
    {
        $sql = sprintf(
            "%s WHERE exercicio = '%s' AND cod_modulo = '%s' AND parametro = '%s' AND cod_entidade = '%s'",
            self::TABLE_ADMINISTRACAO_CONFIGURACAO,
            $info['exercicio'],
            $info['cod_modulo'],
            $info['campo'],
            $info['cod_entidade']
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return current($query->fetchAll());
    }

    public function insertConfiguracaoEntidade($info)
    {
        $exercicio = $info['exercicio'];
        $codEntidade = $info['cod_entidade'];
        $codModulo = $info['cod_modulo'];
        $campo = $info['campo'];
        $valor = $info['valor'];

        /**
         * @todo Injection?
         */
        $sql = "INSERT INTO administracao.configuracao_entidade
                  (exercicio, cod_entidade, cod_modulo, parametro, valor)
                VALUES ($exercicio, $codEntidade, $codModulo, '$campo', '$valor')";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll();
    }

    public function updateConfiguracaoEntidade($info)
    {
        $sql = sprintf(
            "UPDATE administracao.configuracao_entidade SET valor= '%s'WHERE cod_modulo= '%d' AND parametro= '%s' AND exercicio= '%s' AND cod_entidade = '%s';",
            $info['valor'],
            $info['cod_modulo'],
            $info['campo'],
            $info['exercicio'],
            $info['cod_entidade']
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Pega a ultima configuração disponivel.
     * @param $stParametro
     * @param $inCodModulo
     * @param bool $returnValor
     * @return array|null|string
     */
    public function pegaConfiguracao($stParametro, $inCodModulo, $returnValor = false, $exercicio = false)
    {
        $exercicioStmt = '';
        if ($exercicio) {
            $exercicioStmt = "AND exercicio = :exercicio";
        }

        $stSQL = "
        SELECT cod_modulo
        	, parametro
        	, valor
        FROM administracao.configuracao
        WHERE cod_modulo = :cod_modulo
        	AND parametro = :parametro
        	$exercicioStmt
        ORDER BY exercicio DESC limit 1
        ;";

        $query = $this->_em->getConnection()->prepare($stSQL);
        $query->bindValue('parametro', $stParametro);
        $query->bindValue('cod_modulo', $inCodModulo);
        if ($exercicio) {
            $query->bindValue('exercicio', $exercicio);
        }

        $query->execute();

        if (true === $returnValor) {
            $return = $query->fetchAll(\PDO::FETCH_ASSOC);

            return 0 === count($return) ? null : $return[0]['valor'];
        }

        return $query->fetchAll();
    }

    public function getContaCaixaEntidade($params)
    {
        $sql = sprintf(
            "SELECT
                pa.cod_plano,
                pc.exercicio,
                pc.cod_conta,
                pc.nom_conta,
                pc.cod_estrutural,
                pa.natureza_saldo
            FROM
                contabilidade.plano_conta     as pc,
                contabilidade.plano_analitica as pa
            WHERE
                pc.cod_conta = pa.cod_conta
                AND pc.exercicio = pa.exercicio
                AND  cod_plano = %d
                AND pa.exercicio = '%s'",
            $params['codPlano'],
            $params['exercicio']
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        $result = $query->fetchAll();
        return array_shift($result);
    }

    public function getAtributosDinamicosPorModuloeExercicioWithNotIn($info)
    {
        $sql = sprintf(
            "SELECT * FROM administracao.configuracao WHERE exercicio = '%s' AND cod_modulo = '%s' AND parametro NOT IN('%s')",
            $info['exercicio'],
            $info['cod_modulo'],
            implode("','", $info['atributos_negados'])
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Retorna os a configuração para o livro de dívida ativa
     *
     * @param $codModulo
     * @param $parametro
     * @param $exercicio
     * @return int
     */
    public function findConfiguracao($codModulo, $parametro, $exercicio)
    {
        return $this->createQueryBuilder('c')
            ->where("c.exercicio = :exercicio")
            ->andWhere("c.codModulo = :codModulo")
            ->andWhere("c.parametro = :parametro")
            ->setParameter('exercicio', $exercicio)
            ->setParameter('codModulo', $codModulo)
            ->setParameter('parametro', $parametro)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * Retorna a configuração com os parametros pedidos em Array
     *
     * @param array $params
     * @param $exercicio
     * @return array
     */
    public function findConfiguracaoByParameters(array $params, $exercicio)
    {
        $data = [];
        $result = $this->createQueryBuilder('c')
            ->select('c.parametro, c.valor')
            ->where("c.exercicio = :exercicio")
            ->andWhere("c.parametro IN (:parametro)")
            ->setParameter('exercicio', $exercicio)
            ->setParameter('parametro', $params)
            ->getQuery()
            ->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        if (count($result)) {
            foreach ($result as $item) {
                $key = $item['parametro'];
                $data[$key] = $item['valor'];
            }
        }

        return $data;
    }

    /**
     * @param $codTipoModalidade
     * @param $dataVigencia
     * @param $ativa
     * @return array
     */
    public function findModalidade($codTipoModalidade, $dataVigencia, $ativa)
    {
        return  $this->_em->createQueryBuilder()
            ->select(['m.codModalidade', 'm.descricao'])
            ->from(Modalidade::class, 'm', 'm.codModalidade')
            ->join(
                ModalidadeVigencia::class,
                'mv',
                'WITH',
                'm.codModalidade = mv.codModalidade AND mv.timestamp = m.ultimoTimestamp '
            )
            ->where("m.ativa = :ativa")
            ->andWhere("mv.vigenciaInicial <= :vigenciaInicial")
            ->andWhere("mv.vigenciaFinal >= :vigenciaFinal")
            ->andWhere("mv.codTipoModalidade >= :codTipoModalidade")
            ->setParameter('ativa', $ativa)
            ->setParameter('vigenciaInicial', $dataVigencia)
            ->setParameter('vigenciaFinal', $dataVigencia)
            ->setParameter('codTipoModalidade', $codTipoModalidade)
            ->orderBy('m.codModalidade')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param $codModulo
     * @param $exercicio
     * @return array
     */
    public function getInformacoesPrefeituraByModuloAbdExercicio($codModulo, $exercicio)
    {
        $sql = "SELECT DISTINCT 
                (
                    SELECT valor
                    FROM administracao.configuracao
                    WHERE parametro = 'nom_prefeitura' 
                    AND cod_modulo = :codModulo 
                    AND exercicio = :exercicio
                ) AS nom_prefeitura,
                (
                    SELECT valor
                    FROM administracao.configuracao
                    WHERE parametro = 'logradouro' 
                    AND cod_modulo = :codModulo 
                    AND exercicio = :exercicio
                ) AS prefeitura_logradouro,
                (
                    SELECT valor
                    FROM administracao.configuracao
                    WHERE parametro = 'numero' 
                    AND cod_modulo = :codModulo 
                    AND exercicio = :exercicio
                ) AS prefeitura_numero,
                (
                    SELECT valor
                    FROM administracao.configuracao
                    WHERE parametro = 'complemento' 
                    AND cod_modulo = :codModulo 
                    AND exercicio = :exercicio
                ) AS prefeitura_complemento,
                (
                    SELECT valor
                    FROM administracao.configuracao
                    WHERE parametro = 'prefeitura_bairro' 
                    AND cod_modulo = :codModulo 
                    AND exercicio = :exercicio
                ) AS prefeitura_bairro,
                (
                    SELECT valor
                    FROM administracao.configuracao
                    WHERE parametro = 'cep' 
                    AND cod_modulo = :codModulo 
                    AND exercicio = :exercicio
                ) AS prefeitura_cep,
                (
                    SELECT valor
                    FROM administracao.configuracao
                    WHERE parametro = 'diretor_tributos' 
                    AND cod_modulo = :codModulo 
                    AND exercicio = :exercicio
                ) AS diretor_tributos,
                (
                    SELECT valor
                    FROM administracao.configuracao
                    WHERE parametro = 'cnpj' 
                    ORDER BY exercicio DESC
                    LIMIT 1
                ) AS cnpj,
                (
                    SELECT DISTINCT valor
                    FROM administracao.configuracao
                    WHERE parametro = 'sanit_secretaria' 
                    ORDER BY valor DESC
                    LIMIT 1
                ) AS sec_saude,
                (
                    SELECT DISTINCT valor
                    FROM administracao.configuracao
                    WHERE parametro = 'secretaria_1'
                    LIMIT 1
                ) AS sec_fazenda
                FROM administracao.configuracao ";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue("codModulo", $codModulo);
        $query->bindValue("exercicio", $exercicio);
        $query->execute();
        $result = $query->fetch();

        return $result;
    }

    /**
     * @param $codModulo
     * @param $exercicio
     * @return array
     */
    public function getMunicipioAndUF()
    {
        $sql = "	SELECT DISTINCT MUNI.nom_municipio, UF.nom_uf, UF.sigla_uf 
					FROM sw_uf AS UF 
					INNER JOIN (
                          SELECT valor AS cod_uf
                          FROM administracao.configuracao 
                          WHERE parametro = 'cod_uf'  
                          ORDER BY exercicio DESC
                          LIMIT 1
                    ) AS CONF_UF
					ON CAST(coalesce(CONF_UF.cod_uf, '0') AS integer) = UF.cod_uf
					INNER JOIN (
                        SELECT sw_municipio.cod_uf, sw_municipio.nom_municipio 
                        FROM sw_municipio
                        INNER JOIN (         
                              SELECT valor AS cod_municipio, exercicio                                                           
                              FROM administracao.configuracao                                          
                              WHERE parametro = 'cod_municipio'
                              ORDER BY exercicio DESC
                              LIMIT 1
                        ) AS MUN
                        ON CAST(coalesce(MUN.cod_municipio, '0') AS integer) = sw_municipio.cod_municipio
					) AS MUNI
					ON UF.cod_uf = MUNI.cod_uf";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetch();

        return $result;
    }

    /**
     * @param $exercicio
     * @param $modulo
     * @return mixed
     */
    public function findLogotipo($exercicio, $modulo)
    {
        return $this->createQueryBuilder('c')
            ->where("c.exercicio = :exercicio")
            ->andWhere("c.codModulo = :codModulo")
            ->andWhere("c.parametro = :parametro")
            ->setParameter('exercicio', $exercicio)
            ->setParameter('codModulo', $modulo)
            ->setParameter('parametro', "logotipo")
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
