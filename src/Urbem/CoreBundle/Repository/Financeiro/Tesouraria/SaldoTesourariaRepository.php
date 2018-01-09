<?php

namespace Urbem\CoreBundle\Repository\Financeiro\Tesouraria;

use Doctrine\ORM;

class SaldoTesourariaRepository extends ORM\EntityRepository
{
    /**
     * Buscar as contas por entidade
     * @param $entidade
     * @return array
     */
    public function findAllContasPorEntidade($entidade = null, $exercicio = null)
    {
        $sql = "SELECT                                                                            
               pa.cod_plano                                                    
                    ,pa.exercicio                                                    
                    ,pc.cod_estrutural                                               
                    ,pc.nom_conta                                                    
                    ,pc.cod_conta                                                    
                    , publico.fn_mascarareduzida(pc.cod_estrutural) as cod_reduzido  
                    , pc.cod_classificacao,pc.cod_sistema                            
                    ,st.vl_saldo
                    ,st.exercicio
                    , pa.natureza_saldo,                                    
                 CASE WHEN publico.fn_nivel(cod_estrutural) > 4 THEN                           
                         5                                                                     
                      ELSE                                                                     
                         publico.fn_nivel(cod_estrutural)                                      
                 END as nivel                                                                  
             FROM                                                                              
                 contabilidade.plano_conta as pc                                           
             LEFT JOIN contabilidade.plano_analitica as pa on (                            
             pc.cod_conta = pa.cod_conta and pc.exercicio = pa.exercicio )                     
             LEFT JOIN contabilidade.plano_banco as pb on (                                
             pb.cod_plano = pa.cod_plano and pb.exercicio = pa.exercicio                       
             )                                                           
             LEFT JOIN tesouraria.saldo_tesouraria st ON st.cod_plano = pa.cod_plano 
             WHERE 
             pb.cod_banco is not null AND           
             pc.cod_estrutural LIKE '1.1.1.%' AND 
             pc.exercicio = :exercicio AND 
             st.exercicio = :exercicio ";

        if (!empty($entidade)) {
            $sql .= sprintf("AND pb.cod_entidade IN (:entidade) ");
        }
        $sql .= " ORDER BY cod_estrutural ";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        if (!empty($entidade)) {
            $query->bindValue('entidade', $entidade);
        }
        $query->execute();
        return $query->fetchAll();
    }

    /**
     * Busca o nome da conta por codigo do plano
     * @param $codPlano
     * @return mixed
     */
    public function findContaPorPlano($codPlano)
    {
        $sql = " SELECT                                                                                                                                      
                    pc.nom_conta                                                                                                                          
                 FROM                                                                              
                     contabilidade.plano_conta as pc                                           
                 LEFT JOIN contabilidade.plano_analitica as pa on (                            
                     pc.cod_conta = pa.cod_conta and pc.exercicio = pa.exercicio )                     
                 LEFT JOIN contabilidade.plano_banco as pb on (                                
                     pb.cod_plano = pa.cod_plano and pb.exercicio = pa.exercicio)                                                           
                 LEFT JOIN tesouraria.saldo_tesouraria st ON st.cod_plano = pa.cod_plano 
                 WHERE 
                 pb.cod_banco is not null 
                 AND pc.cod_estrutural LIKE '1.1.1.%' 
                 AND pa.cod_plano = :cod_plano ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('cod_plano', $codPlano);
        $query->execute();
        return $query->fetch();
    }

    /**
     * Consulta o saldo, em uma function no banco de dados
     * Os parametros passados para a consulta são: exercicio, cod_plano, data_exercicio, data_saldo
     * @param array $params
     * @return array
     */
    public function consultarSaldo(array $params)
    {
        $sql = "SELECT fn_saldo_conta_tesouraria as saldo FROM tesouraria.fn_saldo_conta_tesouraria (:exercicio, :cod_plano, :data_exercicio, :data_saldo, true)";

        list($exercicio,$codPlano,$dataExercicio,$dataSaldo) = $params;
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('cod_plano', $codPlano);
        $query->bindValue('data_exercicio', $dataExercicio);
        $query->bindValue('data_saldo', $dataSaldo);
        $query->execute();
        return $query->fetch();
    }


    /**
     * O Essa query pega as entidades válidas para consulta de saldo
     * @param null $entidade
     * @param $numcgm
     * @param $exercicio
     * @return array|mixed
     */
    public function getEntidadesValidas($numcgm, $exercicio, $entidade = null)
    {
        $sql = "SELECT
                     E.cod_entidade,
                     C.nom_cgm
                 FROM
                     orcamento.entidade      as   E,
                     sw_cgm                  as   C
                 WHERE
                     E.numcgm = C.numcgm AND
                     ( E.cod_entidade || '-' || exercicio in
                (
                    SELECT cod_entidade || '-' || exercicio
                         FROM orcamento.usuario_entidade
                         WHERE numcgm = :numcgm AND exercicio = :exercicio
                     )
                 OR E.exercicio <
                (
                SELECT substring(valor,7,4)
                         from administracao.configuracao
                         where parametro ='data_implantacao'
                and exercicio = :exercicio
                and cod_modulo=9))
                AND E.exercicio = :exercicio ";


        if (!empty($entidade)) {
            $sql .= sprintf("AND cod_entidade = :codEntidade ");
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('numcgm', $numcgm);
        $query->bindValue('exercicio', $exercicio);
        if (!empty($entidade)) {
            $query->bindValue('codEntidade', $entidade);
            $query->execute();
            return $query->fetch();
        }
        $query->execute();
        return $query->fetchAll();
    }
}
