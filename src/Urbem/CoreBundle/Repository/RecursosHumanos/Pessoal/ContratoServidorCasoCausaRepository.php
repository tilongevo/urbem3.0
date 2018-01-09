<?php

namespace Urbem\CoreBundle\Repository\RecursosHumanos\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class ContratoServidorCasoCausaRepository extends AbstractRepository
{
    /**
     * @param $stFiltroContratos
     * @param $stOrdem
     * @param $exercicio
     * @param $periodoMovimentacao
     * @return array
     */
    public function recuperaTermoRescisao($stFiltroContratos, $stOrdem, $exercicio, $periodoMovimentacao)
    {
        $stOrdem = $stOrdem ? " ORDER BY ".$stOrdem : " ORDER BY nom_cgm ";

        $stSql = "\n       SELECT contrato.*";
        $stSql .= "\n           , servidor_contrato_servidor.cod_servidor";
        $stSql .= "\n           , initcap(sw_cgm.nom_cgm) as nom_cgm";
        $stSql .= "\n           , initcap(sw_cgm.logradouro ||', '|| sw_cgm.numero || ', ' || sw_cgm.complemento) as endereco";
        $stSql .= "\n           , initcap(sw_cgm.bairro) as bairro";
        $stSql .= "\n           , substr(sw_cgm.cep,1,5)||'-'||substr(sw_cgm.cep,6,3) as cep";
        $stSql .= "\n           , (SELECT nom_municipio FROM sw_municipio WHERE sw_cgm.cod_municipio = sw_municipio.cod_municipio AND sw_cgm.cod_uf = sw_municipio.cod_uf) as nom_municipio";
        $stSql .= "\n           , (SELECT sigla_uf FROM sw_uf WHERE sw_cgm.cod_uf = sw_uf.cod_uf) as sigla_uf";
        $stSql .= "\n           , to_char(sw_cgm_pessoa_fisica.dt_nascimento,'dd/mm/yyyy') as dt_nascimento";
        $stSql .= "\n           , substr(sw_cgm_pessoa_fisica.cpf,1,3)||'.'||substr(sw_cgm_pessoa_fisica.cpf,4,3)||'.'||substr(sw_cgm_pessoa_fisica.cpf,7,3)||'-'||substr(sw_cgm_pessoa_fisica.cpf,10,2) as cpf";
        $stSql .= "\n           , initcap(servidor.nome_mae) as nome_mae";
        $stSql .= "\n           , sw_cgm_pessoa_fisica.servidor_pis_pasep";
        $stSql .= "\n           , to_char(contrato_servidor_nomeacao_posse.dt_admissao,'dd/mm/yyyy' ) as dt_admissao";
        $stSql .= "\n           , contrato_servidor_salario.salario";
        $stSql .= "\n           , to_char(aviso_previo.dt_aviso,'dd/mm/yyyy') as dt_aviso";
        $stSql .= "\n           , to_char(contrato_servidor_caso_causa.dt_rescisao,'dd/mm/yyyy') as dt_rescisao";
        $stSql .= "\n           , causa_rescisao.descricao";
        $stSql .= "\n           , causa_rescisao.num_causa";
        $stSql .= "\n           , (SELECT num_sefip FROM pessoal.sefip WHERE cod_sefip = causa_rescisao.cod_sefip_saida) as num_sefip";
        $stSql .= "\n           , contrato_servidor.cod_categoria";
        $stSql .= "\n           , ctps.numero ||'/'||ctps.serie ||'-'||ctps.orgao_expedidor as ctps";
        $stSql .= "\n           , (SELECT organograma.fn_consulta_orgao(orgao_nivel.cod_organograma,contrato_servidor_orgao.cod_orgao)) as orgao";
        $stSql .= "\n           , recuperaDescricaoOrgao(contrato_servidor_orgao.cod_orgao, '".$exercicio."-01-01') as desc_orgao";
        $stSql .= "\n           , (SELECT descricao FROM organograma.local WHERE cod_local = contrato_servidor_local.cod_local) as desc_local";
        $stSql .= "\n       FROM pessoal.contrato";
        $stSql .= "\n INNER JOIN pessoal.contrato_servidor";
        $stSql .= "\n         ON contrato.cod_contrato = contrato_servidor.cod_contrato";
        $stSql .= "\n INNER JOIN pessoal.servidor_contrato_servidor";
        $stSql .= "\n         ON contrato_servidor.cod_contrato = servidor_contrato_servidor.cod_contrato";
        $stSql .= "\n INNER JOIN pessoal.servidor";
        $stSql .= "\n         ON servidor.cod_servidor = servidor_contrato_servidor.cod_servidor";
        $stSql .= "\n INNER JOIN pessoal.contrato_servidor_caso_causa";
        $stSql .= "\n         ON contrato_servidor.cod_contrato = contrato_servidor_caso_causa.cod_contrato";
        $stSql .= "\n INNER JOIN pessoal.caso_causa";
        $stSql .= "\n         ON contrato_servidor_caso_causa.cod_caso_causa = caso_causa.cod_caso_causa";
        $stSql .= "\n INNER JOIN pessoal.causa_rescisao";
        $stSql .= "\n         ON caso_causa.cod_causa_rescisao = causa_rescisao.cod_causa_rescisao";
        $stSql .= "\n INNER JOIN ultimo_contrato_servidor_nomeacao_posse('', ".$periodoMovimentacao.") as contrato_servidor_nomeacao_posse";
        $stSql .= "\n         ON contrato_servidor.cod_contrato = contrato_servidor_nomeacao_posse.cod_contrato";
        $stSql .= "\n INNER JOIN ultimo_contrato_servidor_salario('', ".$periodoMovimentacao.") as contrato_servidor_salario";
        $stSql .= "\n         ON contrato_servidor.cod_contrato = contrato_servidor_salario.cod_contrato";
        $stSql .= "\n INNER JOIN ultimo_contrato_servidor_orgao('', ".$periodoMovimentacao.") as contrato_servidor_orgao";
        $stSql .= "\n         ON contrato_servidor_orgao.cod_contrato = contrato.cod_contrato";
        $stSql .= "\n INNER JOIN organograma.orgao_nivel";
        $stSql .= "\n         ON contrato_servidor_orgao.cod_orgao = orgao_nivel.cod_orgao";
        $stSql .= "\n         AND orgao_nivel.cod_nivel = publico.fn_nivel(organograma.fn_consulta_orgao(orgao_nivel.cod_organograma, contrato_servidor_orgao.cod_orgao))";
        $stSql .= "\n INNER JOIN sw_cgm";
        $stSql .= "\n         ON servidor.numcgm = sw_cgm.numcgm";
        $stSql .= "\n INNER JOIN sw_cgm_pessoa_fisica";
        $stSql .= "\n         ON servidor.numcgm = sw_cgm_pessoa_fisica.numcgm";
        $stSql .= "\n INNER JOIN (  SELECT servidor_pis_pasep.*";
        $stSql .= "\n                 FROM pessoal.servidor_pis_pasep";
        $stSql .= "\n                     , (  SELECT cod_servidor";
        $stSql .= "\n                               , max(timestamp) as timestamp";
        $stSql .= "\n                           FROM pessoal.servidor_pis_pasep";
        $stSql .= "\n                       GROUP BY cod_servidor";
        $stSql .= "\n                       ) as max_servidor_pis_pasep";
        $stSql .= "\n                 WHERE servidor_pis_pasep.cod_servidor = max_servidor_pis_pasep.cod_servidor";
        $stSql .= "\n                   AND servidor_pis_pasep.timestamp    = max_servidor_pis_pasep.timestamp";
        $stSql .= "\n             ) as servidor_pis_pasep";
        $stSql .= "\n         ON servidor.cod_servidor = servidor_pis_pasep.cod_servidor";
        $stSql .= "\n  LEFT JOIN ultimo_contrato_servidor_local('', ".$periodoMovimentacao.") as contrato_servidor_local";
        $stSql .= "\n         ON contrato_servidor_local.cod_contrato = contrato_servidor.cod_contrato";
        $stSql .= "\n  LEFT JOIN pessoal.aviso_previo";
        $stSql .= "\n         ON contrato_servidor_caso_causa.cod_contrato = aviso_previo.cod_contrato";
        $stSql .= "\n  LEFT JOIN (SELECT ctps.*";
        $stSql .= "\n                   , servidor_ctps.cod_servidor";
        $stSql .= "\n               FROM pessoal.servidor_ctps";
        $stSql .= "\n                   , (  SELECT cod_servidor";
        $stSql .= "\n                             , max(dt_emissao) as dt_emissao";
        $stSql .= "\n                         FROM pessoal.servidor_ctps";
        $stSql .= "\n                             , pessoal.ctps";
        $stSql .= "\n                         WHERE servidor_ctps.cod_ctps = ctps.cod_ctps";
        $stSql .= "\n                     GROUP BY cod_servidor) as max_servidor_ctps";
        $stSql .= "\n                   , pessoal.ctps";
        $stSql .= "\n               WHERE servidor_ctps.cod_servidor = max_servidor_ctps.cod_servidor";
        $stSql .= "\n                            AND ctps.dt_emissao            = max_servidor_ctps.dt_emissao";
        $stSql .= "\n                            AND ctps.cod_ctps              = servidor_ctps.cod_ctps) as ctps";
        $stSql .= "\n         ON servidor.cod_servidor = ctps.cod_servidor ";

        $sql  = $stSql.$stFiltroContratos.$stOrdem;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @param $stFiltro
     *
     * @return array
     */
    public function recuperaTodos($stFiltro)
    {
        $sql = <<<SQL
SELECT * FROM pessoal.contrato_servidor_caso_causa
SQL;
        if ($stFiltro) {
            $sql .= $stFiltro;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return $result;
    }

    /**
     * @param $stFiltro
     *
     * @return mixed
     */
    public function recuperaSefipContrato($stFiltro)
    {
        $sql = <<<SQL
SELECT num_sefip                                                                    
    FROM pessoal.contrato_servidor_caso_causa               
       , pessoal.caso_causa                                 
       , pessoal.causa_rescisao                             
       , pessoal.sefip                                      
     WHERE contrato_servidor_caso_causa.cod_caso_causa = caso_causa.cod_caso_causa      
     AND caso_causa.cod_causa_rescisao = causa_rescisao.cod_causa_rescisao            
     AND causa_rescisao.cod_sefip_saida = sefip.cod_sefip                             
SQL;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_OBJ);

        return $result;
    }
}
