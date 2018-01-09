<?php

namespace Urbem\CoreBundle\Repository\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Patrimonio\Bem;
use Urbem\CoreBundle\Entity\Patrimonio\HistoricoBem;

class BemRepository extends ORM\EntityRepository
{
    public function getBemDisponiveis($id)
    {
        $qb = $this->createQueryBuilder('b');
        $qb->leftJoin('Urbem\CoreBundle\Entity\Patrimonio\BemBaixado', 'bb', 'WITH', 'bb.codBem = b.codBem');

        if ($id) {
            $qb->where('bb.codBem = :codBem');
            $qb->setParameter('codBem', $id);
        } else {
            $qb->where('bb.codBem IS NULL');
        }

        return $qb;
    }

    /**
     * @param $paramsWhere
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getBemDisponiveisJson($paramsWhere)
    {
        $sql = sprintf(
            "select * from patrimonio.bem WHERE %s",
            implode(" AND ", $paramsWhere)
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getApoliceBem($id)
    {
        $sql = "
            SELECT ab.cod_apolice
            FROM   patrimonio.bem b
                inner join patrimonio.apolice_bem ab
                    ON ab.cod_bem = b.cod_bem
            WHERE b.cod_bem = $id;
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    public function removeApoliceBem($id)
    {
        $codApolice = $this->getApoliceBem($id);

        if (count($codApolice) > 0) {
            $codApolice = $codApolice[0]['cod_apolice'];

            $sql = "DELETE FROM patrimonio.apolice_bem WHERE cod_bem = $id AND cod_apolice = $codApolice;";

            $query = $this->_em->getConnection()->prepare($sql);

            return $query->execute();
        }
    }


    public function montaRecuperaDadosUltimoOrgao($vigencia, $cod_orgao)
    {
        $vigencia = ($vigencia ? $vigencia : date('Y-m-d'));

        $stSql = " SELECT  \n";
        $stSql .= "       recuperadescricaoorgao(orgao.cod_orgao, '" . $vigencia . "') as descricao             \n";
        $stSql .= "     , organograma.cod_organograma                                                     \n";
        $stSql .= "     , ovw.orgao_reduzido as reduzido                                                  \n";
        $stSql .= "     , ovw.orgao                                                                       \n";
        $stSql .= "   FROM organograma.orgao                                                              \n";
        $stSql .= "      , organograma.organograma                                                        \n";
        $stSql .= "      , organograma.orgao_nivel                                                        \n";
        $stSql .= "      , organograma.nivel                                                              \n";
        $stSql .= "      , organograma.vw_orgao_nivel as ovw                                              \n";
        $stSql .= " WHERE organograma.cod_organograma = nivel.cod_organograma                             \n";
        $stSql .= "   AND nivel.cod_organograma       = orgao_nivel.cod_organograma                       \n";
        $stSql .= "   AND nivel.cod_nivel             = orgao_nivel.cod_nivel                             \n";
        $stSql .= "   AND orgao_nivel.cod_orgao       = orgao.cod_orgao                                   \n";
        $stSql .= "   AND orgao.cod_orgao             = ovw.cod_orgao                                     \n";
        $stSql .= "   AND orgao_nivel.cod_organograma = ovw.cod_organograma                               \n";
        $stSql .= "   AND nivel.cod_nivel             = ovw.nivel                                         \n";
        if ($cod_orgao) {
            $stSql .= " AND orgao.cod_orgao = '" . $cod_orgao . "'                         \n";
        }
        $stSql .= "ORDER BY orgao.cod_orgao                                                               \n";

        $query = $this->_em->getConnection()->prepare($stSql);

        $query->execute();

        return $query->fetchAll();
    }

    public function montaRecuperaSaldoBem($id)
    {
        $stSql = "
            SELECT cod_bem
                , vl_acumulado
                , vl_atualizado
                , vl_bem
            FROM patrimonio.fn_depreciacao_acumulada(" . $id . ")
                AS ( cod_bem INTEGER
                    , vl_acumulado NUMERIC(14,2)
                    , vl_atualizado NUMERIC(14,2)
                    , vl_bem NUMERIC(14,2)
                    , min_competencia VARCHAR
                    , max_competencia VARCHAR
                );
        ";

        $query = $this->_em->getConnection()->prepare($stSql);

        $query->execute();

        return $query->fetchAll();
    }

    public function getBemComManutencaoAgendada()
    {
        $sql = "
            SELECT
                bem.cod_bem,
                bem.descricao,
                natureza.nom_natureza,
                grupo.nom_grupo,
                especie.nom_especie
            FROM  patrimonio.bem
            INNER JOIN  patrimonio.natureza
                ON  natureza.cod_natureza = bem.cod_natureza
            INNER JOIN  patrimonio.grupo
                ON  grupo.cod_natureza = bem.cod_natureza
                AND  grupo.cod_grupo = bem.cod_grupo
            INNER JOIN  patrimonio.especie
                ON  especie.cod_natureza = bem.cod_natureza
                AND  especie.cod_grupo = bem.cod_grupo
                AND  especie.cod_especie = bem.cod_especie
            LEFT JOIN  patrimonio.manutencao
                ON  manutencao.cod_bem = bem.cod_bem
            LEFT JOIN  sw_cgm
                ON  sw_cgm.numcgm = manutencao.numcgm
            WHERE  EXISTS (
            	SELECT 1
            	FROM patrimonio.manutencao AS manutencao_comp
            	WHERE manutencao_comp.cod_bem = manutencao.cod_bem
             		AND manutencao_comp.dt_agendamento = manutencao.dt_agendamento
            	)  
            AND NOT EXISTS (
            	SELECT 1
            	FROM patrimonio.manutencao_paga
            	WHERE manutencao_paga.cod_bem = manutencao.cod_bem
            		AND manutencao_paga.dt_agendamento = manutencao.dt_agendamento
            )  
            ORDER BY  bem.cod_bem , manutencao.dt_agendamento
        ";

        /**
         * @TODO Remover query abaixo e deixar somente à acima
         */
        $sql = "
            SELECT
                bem.cod_bem,
                CONCAT(
                    bem.descricao,
                    ' - ',
                    natureza.nom_natureza,
                    ' - ',
                    grupo.nom_grupo,
                    ' - ',
                    especie.nom_especie
                ) AS descricao
            FROM  patrimonio.bem
            INNER JOIN  patrimonio.natureza
                ON  natureza.cod_natureza = bem.cod_natureza
            LEFT JOIN  patrimonio.grupo
                ON  grupo.cod_natureza = bem.cod_natureza
                AND  grupo.cod_grupo = bem.cod_grupo
            LEFT JOIN  patrimonio.especie
                ON  especie.cod_natureza = bem.cod_natureza
                AND  especie.cod_grupo = bem.cod_grupo
                AND  especie.cod_especie = bem.cod_especie
            LEFT JOIN  patrimonio.manutencao
                ON  manutencao.cod_bem = bem.cod_bem
            LEFT JOIN  sw_cgm
                ON  sw_cgm.numcgm = manutencao.numcgm
            
            ORDER BY  bem.cod_bem 
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function getBemComClassificacao()
    {
        $sql = "
            SELECT
                bem.cod_bem,
                CONCAT(
                    natureza.cod_natureza,
                    '.',
                    grupo.cod_grupo,
                    '.',
                    especie.cod_especie,
                    ' - ',
                    bem.descricao
                ) AS descricao
            FROM  patrimonio.bem
            INNER JOIN  patrimonio.natureza
                ON  natureza.cod_natureza = bem.cod_natureza
            LEFT JOIN  patrimonio.grupo
                ON  grupo.cod_natureza = bem.cod_natureza
                AND  grupo.cod_grupo = bem.cod_grupo
            LEFT JOIN  patrimonio.especie
                ON  especie.cod_natureza = bem.cod_natureza
                AND  especie.cod_grupo = bem.cod_grupo
                AND  especie.cod_especie = bem.cod_especie
            LEFT JOIN  patrimonio.manutencao
                ON  manutencao.cod_bem = bem.cod_bem
            LEFT JOIN  sw_cgm
                ON  sw_cgm.numcgm = manutencao.numcgm
            
            ORDER BY  bem.cod_bem
            

        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $codBem
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function carregaBemProprio($codBem)
    {
        $sql = "
            SELECT bem.cod_bem
	                 , bem.cod_natureza
	                 , natureza.nom_natureza
	                 , bem.cod_grupo
	                 , grupo.nom_grupo
	                 , bem.cod_especie
	                 , especie.nom_especie
	                 , bem.numcgm AS num_fornecedor
	                 , fornecedor.nom_cgm as nom_fornecedor
	                 , bem.descricao
	                 , bem.detalhamento
	                 , TO_CHAR(bem.dt_aquisicao,'dd/mm/yyyy') AS dt_aquisicao
	                 , TO_CHAR(bem.dt_incorporacao,'dd/mm/yyyy') AS dt_incorporacao
	                 , TO_CHAR(bem.dt_depreciacao,'dd/mm/yyyy') AS dt_depreciacao
	                 , TO_CHAR(bem.dt_garantia,'dd/mm/yyyy') AS dt_garantia
	                 , bem.vl_bem
	                 , bem.vl_depreciacao
	                 , bem.identificacao
	                 , bem.num_placa
	                 , bem.vida_util
	                 , bem_comprado.exercicio
	                 , bem_comprado.cod_entidade
	                 , entidade_cgm.nom_cgm AS nom_entidade
	                 , bem_comprado.num_orgao AS num_orgao_a
	                 , orgao.nom_orgao AS nom_orgao_a
	                 , bem_comprado.num_unidade AS num_unidade_a
	                 , unidade.nom_unidade AS nom_unidade_a
	                 , bem_comprado.cod_empenho
	                 , bem_comprado.nota_fiscal
	                 , bem_comprado.caminho_nf
	                 , bem_responsavel.numcgm as num_responsavel
	                 , bem_responsavel.nom_cgm as nom_responsavel
	                 , TO_CHAR(bem_responsavel.dt_inicio,'dd/mm/yyyy') AS dt_inicio
	                 , bem_marca.cod_marca
	                 , bem_marca.descricao as nome_marca
	                 , situacao_bem.cod_situacao
	                 , situacao_bem.nom_situacao
	                 , historico_bem.cod_local
	                 , historico_bem.nom_local
	                 , historico_bem.cod_orgao
	                 , historico_bem.nom_orgao
	                 , historico_bem.descricao AS historico_descricao
	                 , apolice.num_apolice
	                 , TO_CHAR(apolice.dt_vencimento,'dd/mm/yyyy') AS vencimento_apolice
	                 , apolice.numcgm as num_seguradora
	                 , seguradora.nom_cgm AS nom_seguradora
	                 , TO_CHAR(bem_baixado.dt_baixa,'dd/mm/yyyy') AS dt_baixa
	                 , bem_baixado.motivo
	                 , (
	                     SELECT orgao FROM organograma.vw_orgao_nivel WHERE cod_orgao = historico_bem.cod_orgao ORDER BY nivel DESC LIMIT 1
	                   ) as orgao_resumido
	                 , orgao.num_orgao AS orgao_num_orgao
	                 , orgao.nom_orgao AS orgao_nom_orgao
	                 , unidade.num_unidade AS unidade_num_unidade
	                 , unidade.nom_unidade AS unidade_nom_unidade
	              FROM patrimonio.bem
	        INNER JOIN patrimonio.natureza
	                ON natureza.cod_natureza = bem.cod_natureza
	        INNER JOIN patrimonio.grupo
	                ON grupo.cod_grupo = bem.cod_grupo
	               AND grupo.cod_natureza = bem.cod_natureza
	        INNER JOIN patrimonio.especie
	                ON especie.cod_especie = bem.cod_especie
	               AND especie.cod_grupo = bem.cod_grupo
	               AND especie.cod_natureza = bem.cod_natureza
	         LEFT JOIN patrimonio.bem_comprado
	                ON bem_comprado.cod_bem = bem.cod_bem
	         LEFT JOIN orcamento.unidade
	                ON unidade.exercicio   = bem_comprado.exercicio
	               AND unidade.num_orgao   = bem_comprado.num_orgao
	               AND unidade.num_unidade = bem_comprado.num_unidade
	         LEFT JOIN orcamento.orgao
	                ON orgao.exercicio = unidade.exercicio
	               AND orgao.num_orgao = unidade.num_orgao
	         LEFT JOIN orcamento.entidade
	                ON entidade.cod_entidade = bem_comprado.cod_entidade
	               AND entidade.exercicio = bem_comprado.exercicio
	         LEFT JOIN sw_cgm as entidade_cgm
	                ON entidade_cgm.numcgm = entidade.numcgm
	          LEFT JOIN ( SELECT historico_bem.cod_bem
	                           , historico_bem.cod_local
	                           , local.descricao as nom_local
	                           , historico_bem.cod_situacao
	                           , historico_bem.cod_orgao
	                           , orgao_descricao.descricao as nom_orgao
	                           , historico_bem.descricao
	                           , historico_bem.timestamp
	                        FROM patrimonio.historico_bem
	                  INNER JOIN (  SELECT  cod_bem
	                                     ,  MAX(timestamp) AS timestamp
	                                  FROM  patrimonio.historico_bem
	                              GROUP BY  cod_bem
	                             ) AS historico_bem_max
	                          ON historico_bem.cod_bem = historico_bem_max.cod_bem
	                         AND historico_bem.timestamp   = historico_bem_max.timestamp
	                  INNER JOIN organograma.orgao
	                          ON orgao.cod_orgao = historico_bem.cod_orgao
	                  INNER JOIN organograma.orgao_descricao
	                          ON orgao.cod_orgao = orgao_descricao.cod_orgao

	         INNER JOIN ( SELECT cod_orgao,
	                     MAX(timestamp) AS timestamp
	                 FROM organograma.orgao_descricao
	                 GROUP BY cod_orgao
	               ) as max_orgao_descricao
	                          ON max_orgao_descricao.cod_orgao = orgao_descricao.cod_orgao
	                          AND max_orgao_descricao.timestamp = orgao_descricao.timestamp

	                  INNER JOIN organograma.local
	                          ON local.cod_local = historico_bem.cod_local
	                    )   AS historico_bem
	                ON  historico_bem.cod_bem = bem.cod_bem
	         LEFT JOIN ( SELECT apolice_bem.cod_bem
	                          , apolice_bem.cod_apolice
	                          , apolice_bem.timestamp
	                       FROM patrimonio.apolice_bem
	                 INNER JOIN ( SELECT cod_bem
	                                   , MAX(timestamp) AS timestamp
	                                FROM patrimonio.apolice_bem
	                            GROUP BY cod_bem
	                            ) AS apolice_bem_max
	                         ON apolice_bem_max.cod_bem = apolice_bem.cod_bem
	                        AND apolice_bem_max.timestamp = apolice_bem.timestamp
	                   ) AS apolice_bem
	                ON apolice_bem.cod_bem = bem.cod_bem
	         LEFT JOIN patrimonio.apolice
	                ON apolice.cod_apolice = apolice_bem.cod_apolice
	         LEFT JOIN sw_cgm AS seguradora
	                ON seguradora.numcgm = apolice.numcgm
	         LEFT JOIN patrimonio.situacao_bem
	                ON situacao_bem.cod_situacao = historico_bem.cod_situacao
	         LEFT JOIN ( SELECT bem_responsavel.cod_bem
	                          , bem_responsavel.numcgm
	                          , bem_responsavel.dt_inicio AS dt_inicio
	                          , sw_cgm.nom_cgm
	                       FROM patrimonio.bem_responsavel
	                 INNER JOIN ( SELECT cod_bem
	                                   , MAX(timestamp) AS timestamp
	                                FROM patrimonio.bem_responsavel
	                            GROUP BY cod_bem
	                            ) AS bem_responsavel_max
	                         ON bem_responsavel_max.cod_bem = bem_responsavel.cod_bem
	                        AND bem_responsavel_max.timestamp = bem_responsavel.timestamp
	                 INNER JOIN sw_cgm
	                         ON sw_cgm.numcgm = bem_responsavel.numcgm
	                   ) AS bem_responsavel
	                ON bem_responsavel.cod_bem = bem.cod_bem
	         LEFT JOIN ( SELECT bem_marca.cod_bem
	                          , bem_marca.cod_marca
	                          , marca.descricao
	                       FROM patrimonio.bem_marca
	                 INNER JOIN almoxarifado.marca
	                         ON bem_marca.cod_marca = marca.cod_marca
	                   ) AS bem_marca
	                ON bem.cod_bem = bem_marca.cod_bem
	         LEFT JOIN sw_cgm AS fornecedor
	                ON fornecedor.numcgm = bem.numcgm
	         LEFT JOIN patrimonio.bem_baixado
	                ON bem_baixado.cod_bem = bem.cod_bem
	             WHERE  bem.cod_bem = $codBem;
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @return array
     */
    public function getAvailableNumPlaca()
    {
        $sql = "
        SELECT  MAX(num_placa::INTEGER) AS num_placa
                     FROM  patrimonio.bem
                    WHERE  1=1
    AND  num_placa ~  E'^[0-9]+$'
    AND  TRIM(num_placa) != ''
    AND  num_placa IS NOT NULL ;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return array_shift($result);
    }

    /**
     * @return array
     */
    public function getAvailableNumPlacaAlfanumerica()
    {
        $sql = "
        SELECT  num_placa
                     FROM  patrimonio.bem
                    WHERE  1=1
                      AND  num_placa ~ '[a-zA-Z]'
                 ORDER BY  num_placa DESC
                    LIMIT  1;";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return array_shift($result);
    }

    /**
     * @param Bem $bem
     * @return HistoricoBem
     */
    public function getHistoricoBem(Bem $bem)
    {
        $timestamp = $this->createQueryBuilder('b')
            ->select('max(hb.timestamp)')
            ->leftJoin('b.fkPatrimonioHistoricoBens', 'hb')
            ->where('b = :bem')
            ->setParameter('bem', $bem)
            ->getQuery()
            ->getSingleScalarResult();

        if (!$timestamp) {
            return null;
        }

        return $this->getEntityManager()
            ->getRepository(HistoricoBem::class)
            ->createQueryBuilder('hb')
            ->where('hb.timestamp = :timestamp')
            ->setParameter('timestamp', $timestamp)
            ->getQuery()->getResult();
    }


    /**
     * @return mixed
     */
    public function listaBenParaManutencao()
    {
        $sql = "
        SELECT  bem.cod_bem
	                 ,  bem.cod_natureza
	                 ,  natureza.nom_natureza
	                 ,  bem.cod_grupo
	                 ,  grupo.nom_grupo
	                 ,  bem.cod_especie
	                 ,  especie.nom_especie
	                 ,  bem.descricao
	                 ,  bem.num_placa
	                 ,  TO_CHAR(manutencao.dt_agendamento,'dd/mm/yyyy') AS dt_agendamento
	                 ,  TO_CHAR(manutencao.dt_garantia,'dd/mm/yyyy') AS dt_garantia
	                 ,  TO_CHAR(manutencao.dt_realizacao,'dd/mm/yyyy') AS dt_realizacao
	                 ,  manutencao.observacao
	                 ,  manutencao.numcgm
	                 ,  sw_cgm.nom_cgm
	              FROM  patrimonio.bem
	        INNER JOIN  patrimonio.natureza
	                ON  natureza.cod_natureza = bem.cod_natureza
	        INNER JOIN  patrimonio.grupo
	                ON  grupo.cod_natureza = bem.cod_natureza
	               AND  grupo.cod_grupo = bem.cod_grupo
	        INNER JOIN  patrimonio.especie
	                ON  especie.cod_natureza = bem.cod_natureza
	               AND  especie.cod_grupo = bem.cod_grupo
	               AND  especie.cod_especie = bem.cod_especie
	         LEFT JOIN  patrimonio.manutencao
	                ON  manutencao.cod_bem = bem.cod_bem	        
	         LEFT JOIN  sw_cgm
	                ON  sw_cgm.numcgm = manutencao.numcgm
	              WHERE  EXISTS ( SELECT 1
	                              FROM patrimonio.manutencao AS manutencao_comp
	                             WHERE manutencao_comp.cod_bem = manutencao.cod_bem
	                               AND manutencao_comp.dt_agendamento = manutencao.dt_agendamento
	                          )  AND NOT EXISTS ( SELECT 1
	                                      FROM patrimonio.manutencao_paga
	                                     WHERE manutencao_paga.cod_bem = manutencao.cod_bem
	                                       AND manutencao_paga.dt_agendamento = manutencao.dt_agendamento
	                                  )  ORDER BY  bem.cod_bem , manutencao.dt_agendamento; 
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    /**
     * @param $paramsWhere
     * @return array
     */
    public function carregaBemResponsavelAnterior($paramsWhere)
    {
        $sql = sprintf(
            "SELECT                           
	     CGM.numcgm                  
	     ,CGM.nom_cgm                 
	 FROM                             
	     SW_CGM AS CGM                
	 LEFT JOIN                        
	     sw_cgm_pessoa_fisica AS PF   
	 ON                               
	     CGM.numcgm = PF.numcgm       
	 LEFT JOIN                        
	     sw_cgm_pessoa_juridica AS PJ 
	 ON                               
	     CGM.numcgm = PJ.numcgm       
	 WHERE %s AND                           
	     CGM.numcgm <> 0              
	 and exists ( select 1 from  patrimonio.bem_responsavel  as tabela_vinculo
	                                 where tabela_vinculo.numcgm = CGM.numcgm  AND tabela_vinculo.dt_fim IS NULL)  order by lower(cgm.nom_cgm)",
            implode(" AND ", $paramsWhere)
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $paramsWhere
     * @return array
     */
    public function carregaBemResponsavel($paramsWhere)
    {
        $sql = sprintf(
            "SELECT                           
	     CGM.numcgm                  
	     ,CGM.nom_cgm                 
	 FROM                             
	     SW_CGM AS CGM                
	 LEFT JOIN                        
	     sw_cgm_pessoa_fisica AS PF   
	 ON                               
	     CGM.numcgm = PF.numcgm       
	 LEFT JOIN                        
	     sw_cgm_pessoa_juridica AS PJ 
	 ON                               
	     CGM.numcgm = PJ.numcgm       
	 WHERE %s AND                           
	     CGM.numcgm <> 0              
	 and exists ( select 1 from  sw_cgm_pessoa_fisica  as tabela_vinculo
	                                 where tabela_vinculo.numcgm = CGM.numcgm )  order by lower(cgm.nom_cgm)
",
            implode(" AND ", $paramsWhere)
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $numcgm
     * @return array
     */
    public function carregaDtInicioResponsavel($numcgm)
    {
        $sql = sprintf(
            "SELECT MAX( dt_inicio ) AS dt_inicio
              FROM patrimonio.bem_responsavel where numcgm = %s
",
            $numcgm
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $fetch = $query->fetchAll(\PDO::FETCH_OBJ);
        return array_shift($fetch);
    }

    public function montaRecuperaRelacionamento($exercicio, $competencia1, $competencia2)
    {
        $sql = "
            SELECT bem.cod_bem
                 , bem.cod_natureza
                 , bem.cod_grupo
                 , bem.cod_especie
                 , bem.numcgm AS num_fornecedor
                 , fornecedor.nom_cgm as nom_fornecedor
                 , CASE WHEN (SELECT count(cod_bem) 
                              FROM patrimonio.inventario_historico_bem 
                              WHERE inventario_historico_bem.cod_bem = bem.cod_bem) > 0
                          THEN true
                          ELSE false
                       END AS inventario
                 , bem.descricao
                 , bem.descricao AS descricao_padrao
                 , bem.detalhamento
                 , TO_CHAR(bem.dt_aquisicao,'dd/mm/yyyy') AS dt_aquisicao
                 , TO_CHAR(bem.dt_incorporacao,'dd/mm/yyyy') AS dt_incorporacao
                 , depreciacao.dt_depreciacao
                 , TO_CHAR(bem.dt_garantia,'dd/mm/yyyy') AS dt_garantia
                 , bem.vl_bem
                 , bem.vl_depreciacao
                 , bem.identificacao
                 , bem.num_placa
                 , bem.vida_util
                 , bem_comprado.exercicio
                 , bem_comprado.cod_entidade
                 , bem_comprado.cod_empenho
                 , bem_comprado.nota_fiscal
                 , bem_comprado.num_orgao
                 , bem_comprado.num_unidade
                 , TO_CHAR(bem_comprado.data_nota_fiscal,'dd/mm/yyyy') AS data_nota_fiscal
                 , bem_comprado.caminho_nf
                 , bem_responsavel.numcgm as num_responsavel
                 , bem_responsavel.nom_cgm as nom_responsavel
                 , bem.depreciavel
                 , bem.depreciacao_acelerada
                 , bem.quota_depreciacao_anual
                 , bem.quota_depreciacao_anual_acelerada
                 , TO_CHAR(bem_responsavel.dt_inicio,'dd/mm/yyyy') AS dt_inicio
                 , bem_marca.cod_marca
                 , bem_marca.descricao as nome_marca
                 , situacao_bem.cod_situacao
                 , situacao_bem.nom_situacao
                 , historico_bem.cod_local
                 , historico_bem.cod_orgao
                 , historico_bem.timestamp::date as data_historico_bem
                 , to_char(now()::date,'YYYY') as ano_exercicio
                 , historico_bem.descricao AS historico_descricao
                 , apolice.cod_apolice
                 , apolice.numcgm as num_seguradora
                 , bem_comprado_tipo_documento_fiscal.cod_tipo_documento_fiscal
                 , natureza.nom_natureza
                 , tipo_natureza.codigo
                 , tipo_natureza.descricao AS descricao_natureza
                 
              FROM patrimonio.bem
              
         LEFT JOIN patrimonio.bem_comprado
                ON bem_comprado.cod_bem = bem.cod_bem
         
         LEFT JOIN tceal.bem_comprado_tipo_documento_fiscal
                ON bem_comprado_tipo_documento_fiscal.cod_bem = bem_comprado.cod_bem
         
          LEFT JOIN ( SELECT historico_bem.cod_bem
                          , historico_bem.cod_local
                          , historico_bem.cod_situacao
                          , historico_bem.cod_orgao
                          , historico_bem.descricao
                          , historico_bem.timestamp
                       FROM patrimonio.historico_bem
                INNER JOIN (  SELECT  cod_bem
                                   ,  MAX(timestamp) AS timestamp
                                FROM  patrimonio.historico_bem
                            GROUP BY  cod_bem
                            ) AS historico_bem_max
                         ON historico_bem.cod_bem = historico_bem_max.cod_bem
                        AND historico_bem.timestamp   = historico_bem_max.timestamp
                    )   AS historico_bem
                ON  historico_bem.cod_bem = bem.cod_bem
         
         LEFT JOIN ( SELECT apolice_bem.cod_bem
                          , apolice_bem.cod_apolice
                          , apolice_bem.timestamp
                       FROM patrimonio.apolice_bem
                 INNER JOIN ( SELECT cod_bem
                                   , MAX(timestamp) AS timestamp
                                FROM patrimonio.apolice_bem
                            GROUP BY cod_bem
                            ) AS apolice_bem_max
                         ON apolice_bem_max.cod_bem = apolice_bem.cod_bem
                        AND apolice_bem_max.timestamp = apolice_bem.timestamp
                   ) AS apolice_bem
                ON apolice_bem.cod_bem = bem.cod_bem
        
         LEFT JOIN patrimonio.apolice
                ON apolice.cod_apolice = apolice_bem.cod_apolice
       
        LEFT JOIN patrimonio.situacao_bem
                ON situacao_bem.cod_situacao = historico_bem.cod_situacao
    
    LEFT JOIN ( SELECT bem_responsavel.cod_bem
                          , bem_responsavel.numcgm
                          , bem_responsavel.dt_inicio
                          , sw_cgm.nom_cgm
                       FROM patrimonio.bem_responsavel
                 INNER JOIN sw_cgm
                         ON sw_cgm.numcgm = bem_responsavel.numcgm

                 INNER JOIN ( SELECT cod_bem
                                   , MAX(dt_inicio) AS dt_inicio
                                   , MAX(timestamp) AS timestamp
                                FROM patrimonio.bem_responsavel
                            GROUP BY cod_bem
                            ) AS bem_responsavel_max
                         ON bem_responsavel_max.cod_bem = bem_responsavel.cod_bem
                        AND bem_responsavel_max.timestamp = bem_responsavel.timestamp

                   ) AS bem_responsavel
                ON bem_responsavel.cod_bem = bem.cod_bem
         
         LEFT JOIN sw_cgm AS fornecedor
                ON fornecedor.numcgm = bem.numcgm
         
         LEFT JOIN ( SELECT bem_marca.cod_bem
                          , bem_marca.cod_marca
                          , marca.descricao
                       FROM patrimonio.bem_marca
                 INNER JOIN almoxarifado.marca
                         ON bem_marca.cod_marca = marca.cod_marca
                   ) AS bem_marca
                ON bem.cod_bem = bem_marca.cod_bem
         
         LEFT JOIN ( SELECT depreciacao.cod_bem
                          , TO_CHAR(depreciacao.dt_depreciacao, 'DD/MM/YYYY') AS dt_depreciacao
                       FROM patrimonio.depreciacao

		          LEFT JOIN patrimonio.depreciacao_anulada
		  	             ON depreciacao.cod_bem         = depreciacao_anulada.cod_bem
		                AND depreciacao.cod_depreciacao = depreciacao_anulada.cod_depreciacao
		                AND depreciacao.timestamp       = depreciacao_anulada.timestamp
		  	        
		              WHERE depreciacao_anulada.cod_depreciacao IS NULL
		                AND depreciacao.timestamp = ( SELECT max(depreciacao_interna.timestamp)
                                                        FROM patrimonio.depreciacao AS depreciacao_interna
                                                       WHERE depreciacao_interna.cod_bem = depreciacao.cod_bem
                                                         AND SUBSTRING(depreciacao_interna.competencia, 1,4) = '$exercicio' )
	            ) AS depreciacao 
	           ON depreciacao.cod_bem = bem.cod_bem
        
       INNER JOIN patrimonio.especie
	           ON especie.cod_especie  = bem.cod_especie
	          AND especie.cod_grupo    = bem.cod_grupo
	          AND especie.cod_natureza = bem.cod_natureza

       INNER JOIN patrimonio.grupo
	           ON grupo.cod_grupo    = especie.cod_grupo
	          AND grupo.cod_natureza = especie.cod_natureza
       
       INNER JOIN patrimonio.natureza
               ON natureza.cod_natureza = grupo.cod_natureza
       
       INNER JOIN patrimonio.tipo_natureza
	           ON tipo_natureza.codigo = natureza.cod_tipo
               
            WHERE TO_CHAR(bem.dt_aquisicao,'YYYYMM')::INTEGER <= " . $competencia1 . "
              AND bem.depreciavel = true
              AND NOT EXISTS ( SELECT 1
                                FROM patrimonio.bem_baixado
                               WHERE bem_baixado.cod_bem = bem.cod_bem
                            ) 
              AND TO_CHAR(bem.dt_aquisicao,'YYYYMM')::INTEGER <= " . $competencia2;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
