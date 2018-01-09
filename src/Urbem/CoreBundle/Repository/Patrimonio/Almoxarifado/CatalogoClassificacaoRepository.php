<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class CatalogoClassificacaoRepository extends AbstractRepository
{
    public function getClassificacaoNivel($params)
    {
        $sql = "   
          SELECT 
            catalogo_classificacao.cod_classificacao,
            publico.fn_mascarareduzida(catalogo_classificacao.cod_estrutural) AS classif_base, 
            catalogo_classificacao.descricao
          FROM 
            almoxarifado.catalogo_classificacao 
          INNER JOIN
            almoxarifado.catalogo_niveis 
            ON
              catalogo_niveis.cod_catalogo = catalogo_classificacao.cod_catalogo
              AND catalogo_niveis.nivel = " . $params['nivel'] . "
          WHERE 
            publico.fn_nivel(catalogo_classificacao.cod_estrutural) = catalogo_niveis.nivel
            AND catalogo_classificacao.cod_catalogo = " . $params['codCatalogo'] . "
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $params['estrutural', 'codCatalogo']
     * @return array
     */
    public function getNivelClassificacao($params)
    {
        $sql = "   
          SELECT 
            catalogo_niveis.nivel,
            catalogo_niveis.descricao
          FROM 
            almoxarifado.catalogo_classificacao
          INNER JOIN
            almoxarifado.catalogo_niveis 
            ON
              catalogo_niveis.cod_catalogo = catalogo_classificacao.cod_catalogo
              AND catalogo_niveis.nivel = publico.fn_nivel('" . $params['estrutural'] . "')
          WHERE 
            catalogo_classificacao.cod_catalogo = " . $params['codCatalogo'] . "
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function getClassificacaoNivelPai($params)
    {
        $sql = "   
          SELECT 
            catalogo_classificacao.descricao
          FROM 
            almoxarifado.catalogo_classificacao
          WHERE 
            publico.fn_nivel('" . $params['estrutural'] . "') = " . $params['nivel'] . "
            AND publico.fn_mascarareduzida(catalogo_classificacao.cod_estrutural) = '" . $params['estrutural'] . "'
            AND catalogo_classificacao.cod_catalogo = " . $params['codCatalogo'] . "
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param array $params {
     * @option string  NAME
     * @option string  "cod_estrutural"
     * @option string  "cod_nivel"
     * }
     * @return array
     */
    public function getClassificacaoFilhos(array $params)
    {
        $sql = <<<SQL
SELECT
  catalogoClassificacao.cod_classificacao AS cod_classificacao,
  publico.fn_mascarareduzida(catalogoClassificacao.cod_estrutural) AS cod_estrutural,
  CONCAT(publico.fn_mascarareduzida(catalogoClassificacao.cod_estrutural), ' - ', catalogoClassificacao.descricao) AS descricao
FROM
  almoxarifado.catalogo_classificacao catalogoClassificacao
WHERE
  publico.fn_nivel(catalogoClassificacao.cod_estrutural) = ?
  AND catalogoClassificacao.cod_estrutural LIKE CONCAT(publico.fn_mascarareduzida(?), '%%');
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $params['cod_nivel'],
            $params['cod_estrutual']
        ]);

        $result = $stmt->fetchAll();

        return $result;
    }

    public function getProxEstruturalLivre($params)
    {
        $sql = "   
          SELECT almoxarifado.fn_retorna_proximo_estrutural_livre('" .
            $params['codCatalogo'] . "','" .
            $params['nivel'] . "','" .
            $params['estruturaMae'] .
            "') as livre
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function getMascaraReduzida($params)
    {
        $sql = "   
          SELECT publico.fn_mascarareduzida('" . $params['estruturaMae'] . "')
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function getMascaraCompleta($params)
    {
        $sql = "   
            SELECT                                       
                publico.concatenar_ponto(mascara) AS mascara    
            FROM (                                       
                SELECT                               
                    mascara                      
                FROM                                 
                    almoxarifado.catalogo_niveis 
                WHERE   
                    cod_catalogo = " . $params['codCatalogo'] . "
                ORDER BY nivel                       
            )                                       
            AS cn 
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param array $paramsWhere
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getCatalogoClassificacao(array $paramsWhere)
    {
        $sql = sprintf(
            "select * from almoxarifado.catalogo_classificacao WHERE %s",
            implode(" AND ", $paramsWhere)
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $codCatalogo
     * @return int
     */
    public function getProxCodClassificacao($codCatalogo)
    {
        return $this->nextVal('cod_classificacao', ['cod_catalogo' => $codCatalogo]);
    }

    /**
     * @param $params
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getClassificacaoMae($params)
    {
        $sql = "
          SELECT
            nivel,
	       mascara,
	       descricao
	      FROM
	       almoxarifado.catalogo_niveis     WHERE  cod_catalogo = " . $params['codCatalogo'] . "
              ".($params['codNivel'] ? "AND nivel < " . $params['codNivel'] . " ORDER by nivel" : '')
        ;

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $params
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getClassificacoesByClassificacaoMae($params)
    {
        $sql = "
            SELECT
                cc.cod_catalogo as cod_catalogo,
                cn.nivel as nivel,
                cn.cod_nivel as cod_nivel,
                cc.cod_estrutural as cod_estrutural,
                publico.fn_mascarareduzida(cc.cod_estrutural) as cod_estrutural_reduzido,
                cc.descricao as descricao,
                cc.cod_classificacao as cod_classificacao,
                ca.mascara as mascara
            from
                almoxarifado.catalogo_classificacao cc,
                almoxarifado.classificacao_nivel cn,
                almoxarifado.catalogo_niveis ca
        WHERE cc.cod_catalogo =  " . $params['codCatalogo'] . " AND cn.nivel = " . $params['codNivel'] . "
        AND cc.cod_classificacao = cn.cod_classificacao
        AND cc.cod_catalogo = cn.cod_catalogo
        AND ca.cod_catalogo = cn.cod_catalogo
        AND ca.nivel = cn.nivel
        AND publico.fn_nivel( cc.cod_estrutural ) = cn.nivel
        GROUP BY cc.cod_catalogo,  cn.nivel, cn.cod_nivel, cc.cod_estrutural,
                cc.descricao,
                cc.cod_classificacao,
                ca.mascara
        ORDER BY cn.cod_nivel;
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $params
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getNivelCategoriasWithMascara($params)
    {
        $sql = "
            SELECT
	            cc.cod_catalogo as cod_catalogo,
	            cn.nivel as nivel,
	            cn.cod_nivel as cod_nivel,
	            cc.cod_estrutural as cod_estrutural,
                publico.fn_mascarareduzida(cc.cod_estrutural) as cod_estrutural_reduzido,
	            cc.descricao as descricao,
	            cc.cod_classificacao as cod_classificacao,
                ca.mascara as mascara
            FROM
                almoxarifado.catalogo_classificacao cc,
                almoxarifado.classificacao_nivel cn,
                almoxarifado.catalogo_niveis ca
            WHERE cc.cod_catalogo = " . $params['codCatalogo'] . "
                AND cn.nivel = " . $params['codNivel'] . "
                AND cc.cod_classificacao = cn.cod_classificacao
                AND cc.cod_catalogo = cn.cod_catalogo
                AND publico.fn_nivel( cc.cod_estrutural ) = cn.nivel
                AND ca.cod_catalogo = cn.cod_catalogo
                AND ca.nivel = cn.nivel
                AND cc.cod_estrutural
                like  publico.fn_mascarareduzida('" . $params['nivel'] . "')||'%'
            ORDER BY cn.cod_nivel
        ";
        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $params['estrutural', 'codCatalogo']
     * @return array
     */
    public function findClassificacoesFilhas($params)
    {
        $sql = "
            SELECT 
                cod_classificacao ,
                cod_catalogo ,
                cod_estrutural ,
                descricao,
                publico.fn_nivel(cod_estrutural) as nivel
            FROM
                almoxarifado.catalogo_classificacao
            WHERE 
                cod_estrutural like publico.fn_mascarareduzida('{$params['estrutural']}')||'%' 
                AND cod_estrutural != '{$params['estrutural']}'
                AND cod_catalogo = {$params['codCatalogo']}
            ORDER BY cod_estrutural
        ";
        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }
}
