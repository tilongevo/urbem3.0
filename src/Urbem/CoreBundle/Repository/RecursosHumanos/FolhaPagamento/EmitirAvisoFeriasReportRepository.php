<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento;

use Doctrine\ORM;

class EmitirAvisoFeriasReportRepository extends ORM\EntityRepository
{

    /**
     * Essa query pertence ao arquivo  EmitirAvisoFerias.rptdesign
     * @param $exercicio
     * @return array
     */
    public function relatorioAvisoDeFerias($exercicio)
    {
        $sql = sprintf("
                   SELECT sw_cgm.nom_cgm
                 , ferias.cod_contrato
                 , ferias.cod_ferias
                 , contrato.registro
                 , (especialidade.descricao) as especialidade
                 , cod_orgao
                 , recuperaDescricaoOrgao(contrato_servidor_orgao.cod_orgao,('%d-01-01')::date) as orgao
                 , cod_local
                 , ( SELECT descricao FROM organograma.local WHERE cod_local = contrato_servidor_local.cod_local ) as local
                 , to_char ( ferias.dt_inicial_aquisitivo, 'dd/mm/yyyy' ) as \"dt_inicial_aquisitivo\"
                 , to_char ( ferias.dt_final_aquisitivo, 'dd/mm/yyyy' ) as \"dt_final_aquisitivo\"
                 , to_char ( lancamento_ferias.dt_inicio, 'dd/mm/yyyy') as \"dt_inicio\"
                 , to_char ( lancamento_ferias.dt_fim, 'dd/mm/yyyy') as \"dt_fim\"
                 , dias_ferias
                 , dias_abono
                 , faltas
                 , to_char (lancamento_ferias.dt_retorno, 'dd/mm/yyyy') as \"dt_retorno\"
                 , mes_competencia
                 , CASE mes_competencia
                    WHEN '01' THEN 'Janeiro'
                    WHEN '02' THEN 'Fevereiro'
                    WHEN '03' THEN 'Março'
                    WHEN '04' THEN 'Abril'
                    WHEN '05' THEN 'Maio'
                    WHEN '06' THEN 'Junho'
                    WHEN '07' THEN 'Julho'
                    WHEN '08' THEN 'Agosto'
                    WHEN '09' THEN 'Setembro'
                    WHEN '10' THEN 'Outubro'
                    WHEN '11' THEN 'Novembro'
                    WHEN '12' THEN 'Dezembro'
                    ELSE mes_competencia
                    END as mes_competencia_desc
                 , ano_competencia
                 , ( SELECT descricao FROM pessoal.regime WHERE cod_regime = contrato_servidor.cod_regime ) as regime
                 , CASE WHEN especialidade.descricao != NULL THEN
                       ( SELECT descricao FROM pessoal.cargo WHERE cod_cargo = contrato_servidor.cod_cargo )||'/'||especialidade.descricao
                    ELSE
                       ( SELECT descricao FROM pessoal.cargo WHERE cod_cargo = contrato_servidor.cod_cargo )
                    END AS cargo_especialidade

                 , ( SELECT descricao FROM pessoal.sub_divisao WHERE cod_sub_divisao = contrato_servidor.cod_sub_divisao) as sub_divisao
            FROM pessoal.ferias
              INNER JOIN pessoal.forma_pagamento_ferias
                 ON forma_pagamento_ferias.cod_forma = ferias.cod_forma
              INNER JOIN pessoal.lancamento_ferias
                 ON lancamento_ferias.cod_ferias = ferias.cod_ferias
              INNER JOIN pessoal.contrato_servidor
                 ON contrato_servidor.cod_contrato = ferias.cod_contrato
              INNER JOIN pessoal.contrato
                 ON contrato.cod_contrato = ferias.cod_contrato
              INNER JOIN pessoal.servidor_contrato_servidor
                 ON servidor_contrato_servidor.cod_contrato = ferias.cod_contrato
              INNER JOIN pessoal.servidor
                 ON servidor.cod_servidor = servidor_contrato_servidor.cod_servidor
              INNER JOIN sw_cgm
                 ON sw_cgm.numcgm = servidor.numcgm
              LEFT JOIN pessoal.contrato_servidor_especialidade_cargo
                ON contrato_servidor_especialidade_cargo.cod_contrato = ferias.cod_contrato
              LEFT JOIN pessoal.especialidade
                ON especialidade.cod_especialidade = contrato_servidor_especialidade_cargo.cod_especialidade
              LEFT JOIN (SELECT contrato_servidor_orgao.*
                           FROM pessoal.contrato_servidor_orgao
                              , (SELECT cod_contrato
                                      , max(timestamp) as timestamp
                                   FROM pessoal.contrato_servidor_orgao
                                  GROUP BY cod_contrato) as max_contrato_servidor_orgao
                          WHERE pessoal.contrato_servidor_orgao.cod_contrato = max_contrato_servidor_orgao.cod_contrato
                            AND contrato_servidor_orgao.timestamp = max_contrato_servidor_orgao.timestamp) AS contrato_servidor_orgao
                ON servidor_contrato_servidor.cod_contrato = contrato_servidor_orgao.cod_contrato
              LEFT JOIN (SELECT contrato_servidor_local.*
                           FROM pessoal.contrato_servidor_local
                              , (SELECT cod_contrato
                                      , max(timestamp) as timestamp
                                   FROM pessoal.contrato_servidor_local
                                  GROUP BY cod_contrato) as max_contrato_servidor_local
                          WHERE pessoal.contrato_servidor_local.cod_contrato = max_contrato_servidor_local.cod_contrato
                           AND contrato_servidor_local.timestamp = max_contrato_servidor_local.timestamp) AS contrato_servidor_local
                ON servidor_contrato_servidor.cod_contrato = contrato_servidor_local.cod_contrato
            WHERE NOT EXISTS (SELECT 1
                                FROM pessoal.contrato_servidor_caso_causa
                               WHERE cod_contrato = ferias.cod_contrato)
           ", $exercicio);
        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }

    /**
     * Essa query pertence ao arquivo ppara relatorios EmitirAvisoFerias.rptdesign
     * @return array
     */
    public function relatorioEmitirAvisoFeriasPj()
    {
        $sql = "SELECT sw_cgm.nom_cgm
             , sw_cgm.fone_residencial
             , sw_cgm.fone_comercial
             , sw_cgm.e_mail
             , sw_cgm.tipo_logradouro||' '||sw_cgm.logradouro as logradouro
             , sw_cgm.numero
             , sw_cgm.bairro
             , sw_municipio.nom_municipio
             , sw_uf.sigla_uf
             , cep
          FROM orcamento.entidade
             LEFT JOIN orcamento.entidade_logotipo
               ON entidade.cod_entidade = entidade_logotipo.cod_entidade
             , sw_cgm
        LEFT JOIN sw_cgm_pessoa_juridica
               ON sw_cgm.numcgm = sw_cgm_pessoa_juridica.numcgm
             , sw_municipio
             , sw_uf
         WHERE entidade.numcgm = sw_cgm.numcgm
           AND sw_cgm.cod_uf = sw_municipio.cod_uf
           AND sw_cgm.cod_municipio = sw_municipio.cod_municipio
           AND sw_cgm.cod_uf = sw_uf.cod_uf";

        $result = $this->_em->getConnection()->prepare($sql);

        $result->execute();
        return $result->fetchAll();
    }
}
