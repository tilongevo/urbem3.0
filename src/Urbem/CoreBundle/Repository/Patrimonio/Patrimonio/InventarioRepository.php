<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Patrimonio;

use Doctrine\ORM;

class InventarioRepository extends ORM\EntityRepository
{
    public function getProximoId($complemento = '')
    {
        $query = $this->_em->getConnection()->prepare("SELECT MAX(id_inventario) AS CODIGO FROM patrimonio.inventario" . $complemento);
        $query->execute();
        $result = current($query->fetchAll());
        $result = array_shift($result);

        return $result + 1;
    }

    public function cargaInventarioPatrimonio($params)
    {
        $query = $this->_em->getConnection()->prepare("SELECT patrimonio.fn_carga_inventario_patrimonio('".$params['exercicio']."',  ".$params['idInventario'].",  ".$params['numcgm'].")");
        $query->execute();
        $result = current($query->fetchAll());
        $result = array_shift($result);

        if ($result) {
            return $result + 1;
        }

        return false;
    }

    /**
     * @param \DateTime $vigencia
     *
     * @return array
     */
    public function getOrgaoBens(\DateTime $vigencia)
    {
        $sql = <<<SQL
SELECT *,
       recuperaDescricaoOrgao(cod_orgao, :inativacao::DATE) AS descricao,
       (SELECT COUNT(historico_bem.cod_bem) FROM patrimonio.historico_bem WHERE historico_bem.cod_orgao = vw_orgao.cod_orgao) AS num_bem
FROM patrimonio.vw_bem_patrimonio_orgao AS vw_orgao
WHERE (vw_orgao.inativacao > :inativacao::DATE OR vw_orgao.inativacao IS NULL)
  AND EXISTS
    ( SELECT 1
      FROM organograma.organograma
      WHERE organograma.cod_organograma = vw_orgao.cod_organograma
        AND organograma.ativo = TRUE );
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'inativacao' => $vigencia->format('Y-m-d')
        ]);

        return $stmt->fetchAll();
    }



    /**
     * Processa o Inventário
     *
     * @author Helike Long (helikelong@gmail.com)
     * @date   2016-10-05
     *
     * @param  object     $object   inventario object
     * @return array                historicoBem object
     */
    public function processarInventario($object)
    {
        $query = $this->_em->getConnection()->prepare("
            SELECT patrimonio.fn_inventario_processamento ('".$object->getExercicio()."', ".$object->getIdInventario().");
        ");

        $query->execute();
        $result = $query->fetchAll();

        $query = $this->_em->getConnection()->prepare("
            update patrimonio.inventario set
                dt_fim = TO_DATE(
                    '".date('d/m/Y')."',
                    'dd/mm/yyyy'
                ),
                processado = 'true'
            where
                id_inventario = ".$object->getIdInventario()."
                and exercicio = '".$object->getExercicio()."';
        ");

        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $exercicio
     * @param $codInventario
     * @return array
     */
    public function carregaDadosAberturaInventario($exercicio, $codInventario)
    {
        $sql = <<<SQL
SELECT  bem.cod_bem
         ,  TRIM(bem.descricao) as descricao
         ,  bem.num_placa
		 ,  historico_bem.cod_orgao
         ,  recuperaDescricaoOrgao(historico_bem.cod_orgao, 'NOW()') as nom_orgao
		 ,  historico_bem.cod_local
         ,  (
               SELECT  local.descricao                                                       
                 FROM  organograma.local                                                       
                WHERE  local.cod_local = historico_bem.cod_local                               
            ) as nom_local
      FROM  patrimonio.inventario_historico_bem
INNER JOIN  patrimonio.bem
        ON  bem.cod_bem = inventario_historico_bem.cod_bem
INNER JOIN  patrimonio.historico_bem
        ON  historico_bem.cod_bem   = inventario_historico_bem.cod_bem
       AND  historico_bem.timestamp = inventario_historico_bem.timestamp_historico
     WHERE  inventario_historico_bem.id_inventario = :codInventario
       AND  inventario_historico_bem.exercicio     = :exercicio
       ORDER BY  bem.descricao;
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'codInventario' => $codInventario,
            'exercicio' => $exercicio
        ]);

        return $stmt->fetchAll();
    }

    /**
     * @param $exercicio
     * @param $codInventario
     * @return array
     */
    public function carregaDadosEncerramentoInventario($exercicio, $codInventario)
    {
        $sql = <<<SQL
SELECT  bem.cod_bem
         ,  TRIM(bem.descricao) as descricao
         ,  bem.num_placa
		 ,  inventario_historico_bem.cod_orgao
         ,  recuperaDescricaoOrgao(inventario_historico_bem.cod_orgao, 'NOW()') as nom_orgao
		 ,  inventario_historico_bem.cod_local
         ,  (
               SELECT  local.descricao                                                       
                 FROM  organograma.local                                                       
                WHERE  local.cod_local = inventario_historico_bem.cod_local                               
            ) as nom_local
		 ,  inventario_historico_bem.cod_situacao
         ,  (
               SELECT  situacao_bem.nom_situacao                                                       
                 FROM  patrimonio.situacao_bem                                                     
                WHERE  situacao_bem.cod_situacao = inventario_historico_bem.cod_situacao                               
            ) as nom_situacao
         ,  TO_CHAR(inventario.dt_fim, 'DD/MM/YYYY') as dt_fim
      FROM  patrimonio.inventario_historico_bem
INNER JOIN  patrimonio.bem
        ON  bem.cod_bem = inventario_historico_bem.cod_bem
INNER JOIN  patrimonio.inventario
		ON  inventario.id_inventario = inventario_historico_bem.id_inventario
       AND  inventario.exercicio     = inventario_historico_bem.exercicio
     WHERE  inventario_historico_bem.id_inventario = :codInventario
       AND  inventario_historico_bem.exercicio     = :exercicio
       ORDER BY  bem.descricao;
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'codInventario' => $codInventario,
            'exercicio' => $exercicio
        ]);

        return $stmt->fetchAll();
    }


    /**
     * @param \DateTime $vigencia
     * @param $exercicio
     * @param $idInventario
     * @return array
     */
    public function recuperaOrgaosInventario(\DateTime $vigencia, $exercicio, $idInventario)
    {
        $sql = <<<SQL
SELECT  DISTINCT 
                        orgao_nivel.cod_estrutural                                                                
                        , recuperaDescricaoOrgao(orgao.cod_orgao, :inativacao::DATE) as descricao     
                        , orgao.cod_orgao                                                                           
                FROM organograma.orgao                                                                         
                INNER JOIN (SELECT  orgao_nivel.*                                                                     
                                    , organograma.fn_consulta_orgao(orgao_nivel.cod_organograma, orgao_nivel.cod_orgao) AS cod_estrutural
                            FROM organograma.orgao_nivel
                ) AS orgao_nivel                                           
                    ON orgao_nivel.cod_orgao = orgao.cod_orgao                                                   
                    AND orgao_nivel.cod_nivel = publico.fn_nivel(cod_estrutural)                                  
                INNER JOIN (SELECT  MAX(TIMESTAMP)
                                    ,cod_orgao
                                    ,cod_bem                               
                            FROM patrimonio.historico_bem
                            GROUP BY cod_orgao, cod_bem
                ) as historico_bem
                    ON historico_bem.cod_orgao = orgao.cod_orgao                                  
                LEFT JOIN patrimonio.inventario_historico_bem
                    ON  inventario_historico_bem.cod_bem = historico_bem.cod_bem
                WHERE (orgao.inativacao > :inativacao::DATE OR orgao.inativacao IS NULL)
                      AND inventario_historico_bem.id_inventario = :idInventario
                      AND inventario_historico_bem.exercicio     = :exercicio
                AND  EXISTS
                 (
                    SELECT  1
                      FROM  organograma.organograma
                     WHERE  organograma.cod_organograma = orgao_nivel.cod_organograma
                       AND  organograma.ativo = true
                 )
                 ORDER BY orgao_nivel.cod_estrutural;
SQL;
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);

        $stmt->execute([
            'inativacao' => $vigencia->format('Y-m-d'),
            'exercicio' => $exercicio,
            'idInventario' => $idInventario
        ]);

        return $stmt->fetchAll();
    }

    /**
     * @param $places
     * @return array
     */
    public function getListColetoraInventario($places)
    {
        $sql = "
             SELECT
	                 bem.num_placa
	                ,bem.descricao
	              FROM
	                patrimonio.bem
	        INNER JOIN
	                patrimonio.historico_bem
	                ON
	                bem.cod_bem = historico_bem.cod_bem
	        INNER JOIN
    ( SELECT cod_bem, max(timestamp) AS timestamp FROM patrimonio.historico_bem GROUP BY cod_bem ) AS bem10
	                ON
	                    historico_bem.cod_bem = bem10.cod_bem
                        AND historico_bem.timestamp = bem10.timestamp
	        where historico_bem.cod_local in (".$places.") and num_placa <> '' and historico_bem.cod_bem not in (select cod_bem from patrimonio.bem_baixado) ORDER BY cod_local;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $places
     * @return array
     */
    public function getListColetoraCadastro($places)
    {
        $sql = "
             SELECT 
	    cod_local ,
	    cod_logradouro ,
	    numero ,
	    fone ,
	    ramal ,
	    dificil_acesso ,
	    insalubre ,
	    descricao 
	FROM 
	    organograma.local where cod_local in (" . $places . ");
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }
}
