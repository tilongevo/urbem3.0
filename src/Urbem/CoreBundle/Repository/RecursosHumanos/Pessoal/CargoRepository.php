<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;

class CargoRepository extends ORM\EntityRepository
{
    /**
     * Retorna a lista de cargos por subdivisao
     * @param array $params
     * @return array
     */
    public function findCargoSubDivisao(array $params)
    {
        $sql = <<<SQL
SELECT
    cod_cargo,
    descricao,
    cargo_cc,
    funcao_gratificada,
    cod_escolaridade,
    atribuicoes,
    dt_termino
FROM (
    SELECT
        cargo.*,
        cargo_sub_divisao.cod_sub_divisao,
        norma.dt_publicacao,
        norma_data_termino.dt_termino
    FROM
        pessoal.cargo
        JOIN pessoal.cargo_sub_divisao ON cargo_sub_divisao.cod_cargo = cargo.cod_cargo
        JOIN (
            SELECT
                cod_cargo,
                cod_sub_divisao,
                max(TIMESTAMP) AS TIMESTAMP
            FROM
                pessoal.cargo_sub_divisao
            GROUP BY
                cod_cargo,
                cod_sub_divisao) AS max_cargo_sub_divisao ON max_cargo_sub_divisao.cod_cargo = cargo_sub_divisao.cod_cargo
            AND max_cargo_sub_divisao.cod_sub_divisao = cargo_sub_divisao.cod_sub_divisao
            AND max_cargo_sub_divisao.timestamp = cargo_sub_divisao.timestamp
            JOIN normas.norma ON norma.cod_norma = cargo_sub_divisao.cod_norma
        LEFT JOIN normas.norma_data_termino ON norma_data_termino.cod_norma = norma.cod_norma
    UNION
    SELECT
        cargo.*,
        especialidade_sub_divisao.cod_sub_divisao,
        norma.dt_publicacao,
        norma_data_termino.dt_termino
    FROM
        pessoal.cargo
        JOIN pessoal.especialidade ON especialidade.cod_cargo = cargo.cod_cargo
        JOIN pessoal.especialidade_sub_divisao ON especialidade_sub_divisao.cod_especialidade = especialidade.cod_especialidade
        JOIN (
            SELECT
                cod_especialidade,
                cod_sub_divisao,
                max(TIMESTAMP) AS TIMESTAMP
            FROM
                pessoal.especialidade_sub_divisao
            GROUP BY
                cod_especialidade,
                cod_sub_divisao) AS max_especialidade_sub_divisao ON max_especialidade_sub_divisao.cod_especialidade = especialidade_sub_divisao.cod_especialidade
            AND max_especialidade_sub_divisao.cod_sub_divisao = especialidade_sub_divisao.cod_sub_divisao
            AND max_especialidade_sub_divisao.timestamp = especialidade_sub_divisao.timestamp
            JOIN normas.norma ON norma.cod_norma = especialidade_sub_divisao.cod_norma
        LEFT JOIN normas.norma_data_termino ON norma_data_termino.cod_norma = norma.cod_norma) AS tabela
WHERE
    TRUE
    AND (dt_publicacao <= to_date(:dt_final, 'dd/mm/yyyy')
        AND (dt_termino IS NULL
            OR dt_termino >= to_date(:dt_inicial, 'dd/mm/yyyy')))
    AND cod_sub_divisao IN (:cod_sub_divisao)
GROUP BY
    cod_cargo,
    descricao,
    cargo_cc,
    funcao_gratificada,
    cod_escolaridade,
    atribuicoes,
    dt_termino
ORDER BY
    descricao
SQL;

        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function consultaInformacoesSalariais(array $params)
    {
        $sql = <<<SQL
SELECT
    PCP.cod_padrao,
    FP.horas_mensais,
    FP.horas_semanais,
    FPP.valor,
    to_char(FPP.vigencia,
        'dd/mm/yyyy') AS vigencia
FROM
    pessoal.cargo AS PC,
    pessoal.cargo_padrao AS PCP, (
        SELECT
            cod_cargo,
            max(TIMESTAMP) AS TIMESTAMP
        FROM
            pessoal.cargo_padrao
        GROUP BY
            cod_cargo) AS max_cargo_padrao,
        folhapagamento.padrao AS FP,
        folhapagamento.padrao_padrao AS FPP, (
            SELECT
                cod_padrao,
                max(TIMESTAMP) AS TIMESTAMP
            FROM
                folhapagamento.padrao_padrao
            GROUP BY
                cod_padrao) AS max_padrao_padrao
        WHERE
            PC.cod_cargo = PCP.cod_cargo
            AND FP.cod_padrao = PCP.cod_padrao
            AND FPP.cod_padrao = FP.cod_padrao
            AND FPP.cod_padrao = max_padrao_padrao.cod_padrao
            AND FPP.timestamp = max_padrao_padrao.timestamp
            AND PCP.cod_cargo = max_cargo_padrao.cod_cargo
            AND PCP.timestamp = max_cargo_padrao.timestamp
            AND PC.cod_cargo = :cod_cargo
SQL;
        $conn = $this->_em->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param array $subDivisoes
     *
     * @return array
     */
    public function findCargoBySubdivisoes(array $subDivisoes)
    {
        $sql = "
        SELECT                                                                 
	      tabela.cod_cargo         as cod_cargo,                             
	      MAX(tabela.descr_cargo)  as descr_cargo,                           
	      MAX(tabela.descr_espec)  as descr_espec,                           
	      tabela.cod_especialidade as cod_especialidade                      
	  FROM                                                                   
	      (                                                                  
	      SELECT                                                             
	          csd.cod_sub_divisao as cod_sub_divisao,                        
	          c.cod_cargo         as cod_cargo,                              
	          c.descricao         as descr_cargo,                            
	          null                as cod_especialidade,                      
	          null                as descr_espec                             
	      FROM                                                               
	          pessoal.cargo as c,                                            
	          pessoal.cargo_sub_divisao as csd                               
	      WHERE                                                              
	          c.cod_cargo = csd.cod_cargo                                    
	                                                                         
	      UNION ALL                                                          
	                                                                         
	      SELECT                                                             
	          esd.cod_sub_divisao,                                           
	          c.cod_cargo,                                                   
	          c.descricao,                                                   
	          e.cod_especialidade,                                           
	          e.descricao                                                    
	      FROM                                                               
	          pessoal.especialidade as e,                                    
	          pessoal.especialidade_sub_divisao as esd,                      
	          pessoal.cargo as c                                             
	      WHERE                                                              
	          e.cod_especialidade = esd.cod_especialidade                    
	          AND c.cod_cargo = e.cod_cargo                                  
	      GROUP BY                                                           
	          esd.cod_sub_divisao,                                           
	          e.cod_especialidade,                                           
	          e.descricao,                                                   
	          c.cod_cargo,                                                   
	          c.descricao                                                    
	      ORDER BY                                                           
	          descr_cargo,                                                   
	          descr_espec                                                    
	      ) as tabela                                                        
	  WHERE cod_sub_divisao IN ( '" . implode("','", $subDivisoes) . "')
	                       GROUP BY
	                           cod_cargo,
	                           cod_especialidade
	                       ORDER BY
	                           descr_cargo, descr_espec

        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @param $codCargo
     * @return array
     */
    public function findInformacoesCargo($codCargo)
    {
        $sql = "select
                    cargo.cod_cargo as cod_cargo,
                    cargo.descricao as descricao,
                    cargo.cargo_cc,
                    cargo.funcao_gratificada,
                    esp.cod_especialidade,
                    esp.descricao as descricao_especialidade,
                    (
                        select
                            codigo
                        from
                            pessoal.cbo
                        where
                            cod_cbo = esp.cod_cbo
                    ) as cbo_especialidade,
                    esp.cod_cbo as cod_cbo_especialidade,
                    esp.cod_padrao as cod_padrao_especialidade,
                    esp.timestamp_padrao_padrao,
                    esp.cod_sub_divisao,
                    esp.vagas_ocupadas,
                    esp.nro_vaga_criada,
                    esp.cod_norma as norma_maxima,
                    esp.timestamp_especialidade_sub_divisao,
                    esp.cod_tipo_norma as cod_tipo_norma_especialidade,
                    esp.cod_regime,
                    esp.descricao_regime as nom_regime,
                    esp.descricao_sub_divisao as nom_sub_divisao,
                    (
                        select
                            PESDMIN.cod_norma
                        from
                            pessoal.especialidade_sub_divisao PESDMIN,
                            (
                                select
                                    min( timestamp ) as timestamp,
                                    cod_especialidade,
                                    cod_sub_divisao
                                from
                                    pessoal.especialidade_sub_divisao
                                group by
                                    cod_especialidade,
                                    cod_sub_divisao
                            ) as max_PESDMIN
                        where
                            PESDMIN.cod_especialidade = esp.cod_especialidade
                            and PESDMIN.cod_sub_divisao = esp.cod_sub_divisao
                            and PESDMIN.timestamp = max_PESDMIN.timestamp
                            and PESDMIN.cod_especialidade = max_PESDMIN.cod_especialidade
                            and PESDMIN.cod_sub_divisao = max_PESDMIN.cod_sub_divisao
                    ) as norma_minima,
                    esp.horas_mensais,
                    esp.horas_semanais,
                    esp.valor,
                    esp.cod_padrao
                from
                    pessoal.cargo as cargo left join(
                        select
                            especialidade.cod_especialidade,
                            especialidade.cod_cargo,
                            especialidade.descricao,
                            cbo_especialidade.cod_cbo,
                            getVagasOcupadasEspecialidade(
                                regime.cod_regime,
                                sub_divisao.cod_sub_divisao,
                                especialidade.cod_especialidade,
                                0,
                                true,
                                ''
                            ) as vagas_ocupadas,
                            especialidade_sub_divisao.nro_vaga_criada,
                            especialidade_sub_divisao.timestamp as timestamp_especialidade_sub_divisao,
                            padrao.cod_padrao,
                            padrao.horas_mensais,
                            padrao.horas_semanais,
                            padrao_padrao.timestamp as timestamp_padrao_padrao,
                            padrao_padrao.valor,
                            norma.cod_norma,
                            norma.cod_tipo_norma,
                            sub_divisao.cod_sub_divisao,
                            sub_divisao.descricao as descricao_sub_divisao,
                            regime.descricao as descricao_regime,
                            regime.cod_regime
                        from
                            pessoal.especialidade,
                            pessoal.especialidade_padrao,
                            (
                                select
                                    cod_especialidade,
                                    max( timestamp ) as timestamp
                                from
                                    pessoal.especialidade_padrao
                                group by
                                    cod_especialidade
                            ) as max_espepecialidade_padrao,
                            pessoal.especialidade_sub_divisao,
                            (
                                select
                                    cod_especialidade,
                                    max( timestamp ) as timestamp
                                from
                                    pessoal.especialidade_sub_divisao
                                group by
                                    cod_especialidade
                            ) as max_especialidade_subdivisao,
                            normas.norma,
                            pessoal.sub_divisao,
                            pessoal.regime,
                            folhapagamento.padrao,
                            folhapagamento.padrao_padrao,
                            (
                                select
                                    cod_padrao,
                                    max( timestamp ) as timestamp
                                from
                                    folhapagamento.padrao_padrao
                                group by
                                    cod_padrao
                            ) as max_padrao_padrao,
                            pessoal.cbo_especialidade,
                            (
                                select
                                    cod_especialidade,
                                    max( timestamp ) as timestamp
                                from
                                    pessoal.cbo_especialidade
                                group by
                                    cod_especialidade
                            ) as max_cbo_especialidade
                        where
                            especialidade.cod_especialidade = especialidade_padrao.cod_especialidade
                            and especialidade_padrao.cod_especialidade = max_espepecialidade_padrao.cod_especialidade
                            and especialidade_padrao.timestamp = max_espepecialidade_padrao.timestamp
                            and especialidade.cod_especialidade = especialidade_sub_divisao.cod_especialidade
                            and especialidade_sub_divisao.cod_especialidade = max_especialidade_subdivisao.cod_especialidade
                            and especialidade_sub_divisao.timestamp = max_especialidade_subdivisao.timestamp
                            and especialidade_sub_divisao.cod_norma = norma.cod_norma
                            and especialidade_sub_divisao.cod_sub_divisao = sub_divisao.cod_sub_divisao
                            and sub_divisao.cod_regime = regime.cod_regime
                            and especialidade_padrao.cod_padrao = padrao.cod_padrao
                            and padrao.cod_padrao = padrao_padrao.cod_padrao
                            and padrao_padrao.cod_padrao = max_padrao_padrao.cod_padrao
                            and padrao_padrao.timestamp = max_padrao_padrao.timestamp
                            and especialidade.cod_especialidade = cbo_especialidade.cod_especialidade
                            and cbo_especialidade.cod_especialidade = max_cbo_especialidade.cod_especialidade
                            and cbo_especialidade.timestamp = max_cbo_especialidade.timestamp
                    ) as esp on
                    esp.cod_cargo = cargo.cod_cargo
                where
                    cargo.cod_cargo = ".$codCargo."
                    and esp.cod_especialidade is not null
                order by
                    descricao_especialidade,
                    cod_cargo,
                    esp.cod_especialidade,
                    esp.cod_sub_divisao
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }
}
