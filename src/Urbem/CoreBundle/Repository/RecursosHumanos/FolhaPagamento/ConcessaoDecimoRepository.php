<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class ConcessaoDecimoRepository extends ORM\EntityRepository
{
    /**
     * @param $codPeriodoMovimentacao
     * @param $orgao
     * @param $local
     * @param $params
     *
     * @return array
     */
    public function montaRecuperaContratosConcessaoDecimo($codPeriodoMovimentacao, $orgao, $local, $params)
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

        INNER JOIN ultimo_contrato_servidor_orgao('', " . $codPeriodoMovimentacao . " ) as contrato_servidor_orgao
                ON contrato_servidor_orgao.cod_contrato = contrato.cod_contrato

         LEFT JOIN ultimo_contrato_servidor_local('', " . $codPeriodoMovimentacao . " ) as contrato_servidor_local
                ON contrato_servidor_local.cod_contrato = contrato.cod_contrato

         LEFT JOIN ultimo_contrato_servidor_regime_funcao('', " . $codPeriodoMovimentacao . " ) as contrato_servidor_regime_funcao
                ON contrato_servidor_regime_funcao.cod_contrato = contrato.cod_contrato

         LEFT JOIN ultimo_contrato_servidor_sub_divisao_funcao('', " . $codPeriodoMovimentacao . " ) as contrato_servidor_sub_divisao_funcao
                ON contrato_servidor_sub_divisao_funcao.cod_contrato = contrato.cod_contrato

         LEFT JOIN ultimo_contrato_servidor_funcao('', " . $codPeriodoMovimentacao . " ) as contrato_servidor_funcao
                ON contrato_servidor_funcao.cod_contrato = contrato.cod_contrato

         LEFT JOIN ultimo_contrato_servidor_especialidade_funcao('', " . $codPeriodoMovimentacao . " ) as contrato_servidor_especialidade_funcao
                ON contrato_servidor_especialidade_funcao.cod_contrato = contrato.cod_contrato

             WHERE NOT EXISTS ( SELECT 1
                                  FROM pessoal.contrato_servidor_caso_causa
                                 WHERE contrato_servidor_caso_causa.cod_contrato = contrato.cod_contrato
                              )
    ";

        if ($orgao) {
            $stSql .= " AND contrato_servidor_orgao.cod_orgao IN (" . $orgao . ")";
        }

        if ($local) {
            $stSql .= " AND contrato_servidor_local.cod_local IN (" . $local . ")";
        }

        if (isset($params['regime'])) {
            $stSql .= " AND contrato_servidor_regime_funcao.cod_regime_funcao in ( ".$params['regime']." ) ";
        }

        if (isset($params['subDivisao'])) {
            $stSql .= " AND contrato_servidor_sub_divisao_funcao.cod_sub_divisao_funcao in ( ".$params['subDivisao']." ) ";
        }

        if (isset($params['cargo'])) {
            $stSql .= " AND contrato_servidor_funcao.cod_cargo in ( ".$params['cargo']." ) ";
        }

        if (isset($params['especialidade'])) {
            $stSql .= " AND contrato_servidor_especialidade_funcao.cod_especialidade_funcao in ( ".$params['especialidade']." ) ";
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

        INNER JOIN ultimo_contrato_pensionista_orgao('', " . $codPeriodoMovimentacao . " ) as contrato_servidor_orgao
                ON contrato_servidor_orgao.cod_contrato = contrato.cod_contrato

         LEFT JOIN ultimo_contrato_servidor_local('', " . $codPeriodoMovimentacao . " ) as contrato_servidor_local
                ON contrato_servidor_local.cod_contrato = contrato.cod_contrato

         LEFT JOIN ultimo_contrato_servidor_regime_funcao('', " . $codPeriodoMovimentacao . " ) as contrato_servidor_regime_funcao
                ON contrato_servidor_regime_funcao.cod_contrato = contrato.cod_contrato

         LEFT JOIN ultimo_contrato_servidor_sub_divisao_funcao('', " . $codPeriodoMovimentacao . " ) as contrato_servidor_sub_divisao_funcao
                ON contrato_servidor_sub_divisao_funcao.cod_contrato = contrato.cod_contrato

         LEFT JOIN ultimo_contrato_servidor_funcao('', " . $codPeriodoMovimentacao . " ) as contrato_servidor_funcao
                ON contrato_servidor_funcao.cod_contrato = contrato.cod_contrato

         LEFT JOIN ultimo_contrato_servidor_especialidade_funcao('', " . $codPeriodoMovimentacao . " ) as contrato_servidor_especialidade_funcao
                ON contrato_servidor_especialidade_funcao.cod_contrato = contrato.cod_contrato

             WHERE 1=1 ";

        if ($orgao) {
            $stSql .= " AND contrato_servidor_orgao.cod_orgao IN (" . $orgao . ")";
        }

        if ($local) {
            $stSql .= " AND contrato_servidor_local.cod_local IN (" . $local . ")";
        }

        if (isset($params['regime'])) {
            $stSql .= " AND contrato_servidor_regime_funcao.cod_regime_funcao in ( " . $params['regime'] . " ) ";
        }

        if (isset($params['subDivisao'])) {
            $stSql .= " AND contrato_servidor_sub_divisao_funcao.cod_sub_divisao_funcao in ( " . $params['subDivisao'] . " ) ";
        }

        if (isset($params['cargo'])) {
            $stSql .= " AND contrato_servidor_funcao.cod_cargo in ( " . $params['cargo'] . " ) ";
        }

        if (isset($params['especialidade'])) {
            $stSql .= " AND contrato_servidor_especialidade_funcao.cod_especialidade_funcao in ( " . $params['especialidade'] . " ) ";
        }

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $codContrato
     * @param $codPeriodoMovimentacao
     * @param $desdobramento
     * @param $entidade
     * @return mixed
     */
    public function montaGeraRegistroDecimo($codContrato, $codPeriodoMovimentacao, $desdobramento, $entidade)
    {
        $stSql = "select removerTodosBuffers();";
        $querys = $this->_em->getConnection()->prepare($stSql);
        $querys->execute();

        $querys->fetchAll();

        $query = $this->_em->getConnection()->prepare("SELECT geraRegistroDecimo(:cod_contrato,:cod_periodo_movimentacao,:desdobramento,:entidade) as retorno");
        $query->bindValue(':cod_contrato', $codContrato, \PDO::PARAM_STR);
        $query->bindValue(':cod_periodo_movimentacao', $codPeriodoMovimentacao, \PDO::PARAM_STR);
        $query->bindValue(':desdobramento', $desdobramento, \PDO::PARAM_STR);
        $query->bindValue(':entidade', $entidade, \PDO::PARAM_STR);
        $query->execute();
        $result = array_shift(current($query->fetchAll()));

        return $result;
    }

    public function montaGeraConcessaoDecimoWithParanms($filtro = false, $order = false)
    {
        $stSql = "SELECT * FROM folhapagamento.concessao_decimo ";

        if ($filtro) {
            $stSql .= $filtro;
        }

        if ($order) {
            $stSql .= $order;
        }

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $mesAniversario
     * @param $entidade
     * @param $codPeriodoMovimentacao
     * @param bool $filtro
     * @param bool $order
     * @return array
     */
    public function montaRecuperaContratosAdiantamentoDecidoMesAniversario($mesAniversario, $entidade, $codPeriodoMovimentacao, $filtro = false, $order = false)
    {
        $stSql = "SELECT contrato.*
                 , servidor.numcgm
                 , sw_cgm.nom_cgm
                 , TO_CHAR(sw_cgm_pessoa_fisica.dt_nascimento,'mm') as mes_nascimento
              FROM pessoal.contrato
        INNER JOIN pessoal.servidor_contrato_servidor
                ON servidor_contrato_servidor.cod_contrato = contrato.cod_contrato
        INNER JOIN pessoal.servidor
                ON servidor.cod_servidor = servidor_contrato_servidor.cod_servidor
        INNER JOIN sw_cgm
                ON sw_cgm.numcgm = servidor.numcgm
        INNER JOIN sw_cgm_pessoa_fisica
                ON sw_cgm_pessoa_fisica.numcgm = sw_cgm.numcgm
               AND TO_CHAR(sw_cgm_pessoa_fisica.dt_nascimento,'mm') = '" . $mesAniversario . "'
        INNER JOIN ultimo_contrato_servidor_orgao('" . $entidade . "', " . $codPeriodoMovimentacao . " ) as contrato_servidor_orgao
                ON contrato_servidor_orgao.cod_contrato = contrato.cod_contrato

             WHERE NOT EXISTS ( SELECT 1
                                  FROM pessoal.contrato_servidor_caso_causa
                                 WHERE contrato_servidor_caso_causa.cod_contrato = contrato.cod_contrato
                              )
             
        UNION

            SELECT contrato.*
                 , pensionista.numcgm
                 , sw_cgm.nom_cgm
                 , TO_CHAR(sw_cgm_pessoa_fisica.dt_nascimento,'mm') as mes_nascimento
              FROM pessoal.contrato
        INNER JOIN pessoal.contrato_pensionista
                ON contrato_pensionista.cod_contrato = contrato.cod_contrato
        INNER JOIN pessoal.pensionista
                ON pensionista.cod_pensionista = contrato_pensionista.cod_pensionista
               AND pensionista.cod_contrato_cedente = contrato_pensionista.cod_contrato_cedente
        INNER JOIN sw_cgm
                ON sw_cgm.numcgm = pensionista.numcgm
        INNER JOIN sw_cgm_pessoa_fisica
                ON sw_cgm_pessoa_fisica.numcgm = sw_cgm.numcgm
                AND TO_CHAR(sw_cgm_pessoa_fisica.dt_nascimento,'mm') = '" . $mesAniversario . "'
        INNER JOIN ultimo_contrato_pensionista_orgao('" . $entidade . "', " . $codPeriodoMovimentacao . " ) as contrato_servidor_orgao
                ON contrato_servidor_orgao.cod_contrato = contrato.cod_contrato";

        if ($filtro) {
            $stSql .= $filtro;
        }

        if ($order) {
            $stSql .= $order;
        }

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $filtro
     * @return array
     */
    public function montaRecuperaTodos($filtro)
    {
        $stSql = "SELECT 
	    cod_periodo_movimentacao ,
	    cod_contrato ,
	    desdobramento ,
	    folha_salario 
	FROM 
	    folhapagamento.concessao_decimo";

        if (isset($filtro)) {
            $stSql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll();
        $result = array_shift($result);

        return $result;
    }

    /**
     * @param array $params
     * @param $filtro
     *
     * @return array
     */
    public function recuperaContratosParaCancelar($params, $filtro)
    {
        $stSql  = "SELECT concessao_decimo.*                                                                                          
                 , getDesdobramentoDecimo(desdobramento,'".$params['entidade']."') as desdobramento_texto                    
                 , ( CASE WHEN evento_decimo_calculado.cod_contrato > 0                                                        
                            THEN 'A Matrícula possui cálculo de 13º, ao confirmar, o cálculo será excluído.'                   
                            ELSE 'Confirma a exclusão da concessão do 13º Salário (Matrícula '||contrato.registro||').'        
                     END ) as mensagem                                                                                         
                 , contrato.registro                                                                                           
                 , contrato.cod_contrato                                                                                       
                 , contrato.numcgm                                                                                             
                 , contrato.nom_cgm                                                                                            
                 , trim(contrato.desc_orgao) as desc_orgao                                                                     
                 , contrato.desc_funcao                                                                                        
              FROM folhapagamento.concessao_decimo                                                                             
        INNER JOIN ( SELECT *                                                                                                  
                       FROM recuperarContratoServidor(                                                                         
                                            '".$params['stConfiguracao']."',                                            
                                            '".$params['entidade']."',                                                       
                                            0,                                                                                 
                                            '".$params['stTipoFiltro']."',                                              
                                            '".$params['stValoresFiltro']."',                                           
                                            '".$params['exercicio']."'                                                       
                                            )) as contrato                                                                     
                ON concessao_decimo.cod_contrato = contrato.cod_contrato                                                       
         LEFT JOIN ( SELECT cod_contrato                                                                                       
                       FROM folhapagamento.evento_decimo_calculado                                                             
                          , folhapagamento.registro_evento_decimo                                                              
                      WHERE evento_decimo_calculado.cod_registro       = registro_evento_decimo.cod_registro                   
                        AND evento_decimo_calculado.desdobramento      = registro_evento_decimo.desdobramento                  
                        AND evento_decimo_calculado.timestamp_registro = registro_evento_decimo.timestamp                      
                        AND evento_decimo_calculado.cod_evento         = registro_evento_decimo.cod_evento                     
                   GROUP BY cod_contrato) as evento_decimo_calculado                                                           
                ON contrato.cod_contrato = evento_decimo_calculado.cod_contrato ";

        if ($filtro) {
            $stSql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    /**
     * @param $params
     * @param $filtro
     *
     * @return array
     */
    public function recuperaContratosParaCancelarPensionista($params, $filtro)
    {
        $stSql = "SELECT concessao_decimo.*                                                                                                 
            , getDesdobramentoDecimo(desdobramento,'".$params['entidade']."') as desdobramento_texto                           
            , 'Confirma a exclusão da concessão do 13º Salário (Matrícula '||contrato_pensionista.registro||').' as mensagem     
            , contrato_pensionista.registro                                                                                      
            , contrato_pensionista.cod_contrato                                                                                  
            , contrato_pensionista.numcgm                                                                                        
            , contrato_pensionista.nom_cgm                                                                                       
            , contrato_pensionista.desc_orgao                                                                                    
            , contrato_pensionista.orgao as cod_estrutural                                                                       
            , '' as desc_funcao                                                                                                  
         FROM folhapagamento.concessao_decimo                                                                                    
   INNER JOIN ( SELECT *                                                                                                         
                  FROM recuperarContratoPensionista(                                                                             
                                        '".$params['stConfiguracao']."',                                            
                                            '".$params['entidade']."',                                                       
                                            0,                                                                                 
                                            '".$params['stTipoFiltro']."',                                              
                                            '".$params['stValoresFiltro']."',                                           
                                            '".$params['exercicio']."'                                                                       
                                       )) as contrato_pensionista                                                                
           ON concessao_decimo.cod_contrato = contrato_pensionista.cod_contrato";
        if ($filtro) {
            $stSql .= $filtro;
        }

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }
}
