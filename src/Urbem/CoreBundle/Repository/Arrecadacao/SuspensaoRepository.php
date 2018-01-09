<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use Urbem\CoreBundle\Entity\Arrecadacao\Lancamento;
use Urbem\CoreBundle\Repository\AbstractRepository;
use Doctrine\ORM;

class SuspensaoRepository extends AbstractRepository
{
    /**
     * @return mixed
     */
    public function getNextVal($lancamento)
    {
        return $this->nextVal("cod_suspensao", ['cod_lancamento' => $lancamento]);
    }

    /**
     * @param $filter
     * @return array
     */
    public function filterLancamento($filter)
    {
        $sql = "
        SELECT DISTINCT
          alc.cod_lancamento,
          (CASE WHEN ic.cod_calculo IS NOT NULL
            THEN ic.inscricao_municipal
           WHEN cec.cod_calculo IS NOT NULL
             THEN cec.inscricao_economica END)                                     AS inscricao,
          (arrecadacao.buscaCgmLancamento(alc.cod_lancamento) || ' - ' ||
           arrecadacao.buscaContribuinteLancamento(alc.cod_lancamento)) :: VARCHAR AS proprietarios,
          (CASE WHEN ic.cod_calculo IS NOT NULL
            THEN arrecadacao.fn_consulta_endereco_imovel(ic.inscricao_municipal)
           WHEN cec.cod_calculo IS NOT NULL
             THEN arrecadacao.fn_consulta_endereco_empresa(cec.inscricao_economica)
           ELSE 'Nao Encontrado' END)                                              AS dados_complementares,
          (CASE WHEN acgc.cod_grupo IS NOT NULL
            THEN acgc.cod_grupo || '/' || acgc.ano_exercicio || ' - ' || agc.descricao
           ELSE ac.cod_credito || '.' || ac.cod_especie || '.' || ac.cod_genero || '.' || ac.cod_natureza || ' - ' ||
                mc.descricao_credito END)                                          AS origemcobranca,
          acgc.cod_grupo
        FROM arrecadacao.calculo_cgm cgm INNER JOIN arrecadacao.lancamento_calculo AS alc ON cgm.cod_calculo = alc.cod_calculo
          INNER JOIN arrecadacao.lancamento AS al ON al.cod_lancamento = alc.cod_lancamento
          LEFT JOIN arrecadacao.imovel_calculo ic ON ic.cod_calculo = alc.cod_calculo
          LEFT JOIN arrecadacao.cadastro_economico_calculo cec ON cec.cod_calculo = alc.cod_calculo
          INNER JOIN arrecadacao.calculo_grupo_credito AS acgc ON alc.cod_calculo = acgc.cod_calculo
          INNER JOIN arrecadacao.calculo AS ac ON alc.cod_calculo = ac.cod_calculo
          INNER JOIN arrecadacao.grupo_credito AS agc ON acgc.cod_grupo = agc.cod_grupo
          LEFT JOIN monetario.credito AS mc ON ac.cod_credito = mc.cod_credito and NOT EXISTS (SELECT * FROM arrecadacao.suspensao         WHERE arrecadacao.suspensao.cod_lancamento = alc.cod_lancamento)
          
        ";

        if ($filter['codLancamento']['value'] !== "") {
            $sql .= " AND alc.cod_lancamento = :cod_lancamento";
        }

        if (isset($filter['fkSwCgm']['value']) && $filter['fkSwCgm']['value'] !== "") {
            $sql .= " AND alc.cod_lancamento in (select alc.cod_lancamento 
                                  from arrecadacao.calculo_cgm cgm 
                            inner join arrecadacao.calculo ac 
                                    on ac.cod_calculo=cgm.cod_calculo
                            inner join arrecadacao.lancamento_calculo alc 
                                    on alc.cod_calculo=ac.cod_calculo
                                 where cgm.numcgm = :numcgm )";
        }

        if (isset($filter['grupoCredito']['value']) && $filter['grupoCredito']['value'] !== "") {
            $sql .= "AND alc.cod_lancamento in (select distinct alc.cod_lancamento 
                              from arrecadacao.calculo_cgm cgm 
                        inner join arrecadacao.calculo ac 
                                on ac.cod_calculo=cgm.cod_calculo
                        inner join arrecadacao.lancamento_calculo alc 
                                on alc.cod_calculo=ac.cod_calculo
                                INNER JOIN arrecadacao.calculo_grupo_credito AS acgc ON alc.cod_calculo = acgc.cod_calculo
          						INNER JOIN arrecadacao.grupo_credito AS agc ON acgc.cod_grupo = agc.cod_grupo
                             where acgc.cod_grupo || '/' || acgc.ano_exercicio = :cod_grupo)";
        }

        if (isset($filter['credito']['value']) && $filter['credito']['value'] !== "") {
            $sql .= "AND alc.cod_lancamento in (select distinct alc.cod_lancamento 
                              from arrecadacao.calculo_cgm cgm 
                        inner join arrecadacao.calculo ac 
                                on ac.cod_calculo=cgm.cod_calculo
                        inner join arrecadacao.lancamento_calculo alc 
                                on alc.cod_calculo=ac.cod_calculo
                                INNER JOIN arrecadacao.calculo_grupo_credito AS acgc ON alc.cod_calculo = acgc.cod_calculo
          						INNER JOIN arrecadacao.grupo_credito AS agc ON acgc.cod_grupo = agc.cod_grupo
          						LEFT JOIN monetario.credito AS mc ON ac.cod_credito = mc.cod_credito 
                             where ac.cod_credito || '.' || ac.cod_especie || '.' || ac.cod_genero || '.' || ac.cod_natureza = :cod_credito)";
        }

        $query = $this->_em->getConnection()->prepare($sql);

        if ($filter['codLancamento']['value'] !== "") {
            $query->bindValue(':cod_lancamento', $filter['codLancamento']['value'], \PDO::PARAM_INT);
        }

        if (isset($filter['fkSwCgm']['value']) && $filter['fkSwCgm']['value'] !== "") {
            $query->bindValue(':numcgm', $filter['fkSwCgm']['value'], \PDO::PARAM_INT);
        }

        if (isset($filter['grupoCredito']['value']) && $filter['grupoCredito']['value'] !== "") {
            $query->bindValue(':cod_grupo', $filter['grupoCredito']['value'], \PDO::PARAM_STR);
        }


        if (isset($filter['credito']['value']) && $filter['credito']['value'] !== "") {
            $query->bindValue(':cod_credito', $filter['credito']['value'], \PDO::PARAM_STR);
        }

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $lancamento
     * @return mixed
     */
    public function getProprietario(Lancamento $lancamento)
    {
        $sql =
            'select arrecadacao.buscaCgmLancamento(:codLancamento) :: VARCHAR || \' - \' || arrecadacao.buscaContribuinteLancamento(:codLancamento) as proprietario';

        $query = $this->_em->getConnection()->prepare($sql);

        $query->bindValue(':codLancamento', $lancamento->getCodLancamento(), \PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param Lancamento $lancamento
     * @return array
     */
    public function getDadosLancamento(Lancamento $lancamento)
    {
        $sql =
            'SELECT DISTINCT
          (CASE WHEN ic.cod_calculo IS NOT NULL
            THEN ic.inscricao_municipal
           WHEN cec.cod_calculo IS NOT NULL
             THEN cec.inscricao_economica END)                                     AS inscricao,
          (CASE WHEN ic.cod_calculo IS NOT NULL
            THEN arrecadacao.fn_consulta_endereco_imovel(ic.inscricao_municipal)
           WHEN cec.cod_calculo IS NOT NULL
             THEN arrecadacao.fn_consulta_endereco_empresa(cec.inscricao_economica)
           ELSE \'Nao Encontrado\' END)                                              AS dados_complementares,
          (CASE WHEN acgc.cod_grupo IS NOT NULL
            THEN acgc.cod_grupo || \'/\' || acgc.ano_exercicio || \' - \' || agc.descricao
           ELSE ac.cod_credito || \'.\' || ac.cod_especie || \'.\' || ac.cod_genero || \'.\' || ac.cod_natureza || \' - \' ||
                mc.descricao_credito END)                                          AS origemcobranca
        FROM arrecadacao.calculo_cgm cgm INNER JOIN arrecadacao.lancamento_calculo AS alc ON cgm.cod_calculo = alc.cod_calculo
          INNER JOIN arrecadacao.lancamento AS al ON al.cod_lancamento = alc.cod_lancamento
          LEFT JOIN arrecadacao.imovel_calculo ic ON ic.cod_calculo = alc.cod_calculo
          LEFT JOIN arrecadacao.cadastro_economico_calculo cec ON cec.cod_calculo = alc.cod_calculo
          INNER JOIN arrecadacao.calculo_grupo_credito AS acgc ON alc.cod_calculo = acgc.cod_calculo
          INNER JOIN arrecadacao.calculo AS ac ON alc.cod_calculo = ac.cod_calculo
          INNER JOIN arrecadacao.grupo_credito AS agc ON acgc.cod_grupo = agc.cod_grupo
          LEFT JOIN monetario.credito AS mc ON ac.cod_credito = mc.cod_credito 
          WHERE alc.cod_lancamento =:codLancamento';

        $query = $this->_em->getConnection()->prepare($sql);

        $query->bindValue(':codLancamento', $lancamento->getCodLancamento(), \PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
