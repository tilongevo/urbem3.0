<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Licitacao;

use Doctrine\ORM;

class ComissaoRepository extends ORM\EntityRepository
{
    /**
     * @param $codComissao
     * @return array
     */
    public function ativar($codComissao)
    {
        return $this->atualizar($codComissao, "true");
    }
    /**
     * @param $codComissao
     * @return array
     */
    public function inativar($codComissao)
    {
        return $this->atualizar($codComissao, "false");
    }

    /**
     * @param $codComissao
     * @param $ativo
     * @return array
     */
    private function atualizar($codComissao, $ativo)
    {
        $sql = "
            UPDATE 
                licitacao.comissao
            SET ativo = $ativo
            WHERE cod_comissao = $codComissao
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }

    public function getComissaoAtivas()
    {
        $stSql = "
        select comissao.cod_comissao,
               comissao.cod_tipo_comissao,
               tipo_comissao.descricao as finalidade,
               comissao.cod_norma,
               to_char(norma.dt_publicacao,'dd/mm/yyyy') as dt_publicacao,
               to_char(norma_data_termino.dt_termino,'dd/mm/yyyy') as dt_termino,
               norma.exercicio,
               norma.num_norma,
               ntn.nom_tipo_norma,
               CASE
                     WHEN ativo = true
                     THEN 'Ativa' ELSE 'Inativa'
               END AS status
        from licitacao.comissao
        join licitacao.tipo_comissao
            on (tipo_comissao.cod_tipo_comissao = comissao.cod_tipo_comissao)
        join normas.norma
            on (norma.cod_norma = comissao.cod_norma)
        left join normas.norma_data_termino
            on (norma_data_termino.cod_norma = norma.cod_norma)
        left join normas.tipo_norma ntn
            on (norma.cod_tipo_norma = ntn.cod_tipo_norma)
            where tipo_comissao.cod_tipo_comissao <> 4
            AND comissao.ativo = true
        ";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function getMembrosComissao($codComissao)
    {
        $stSql = "
        select sw_cgm.nom_cgm,
           tipo_membro.descricao as tipo_membro,
           to_char(norma.dt_publicacao,'dd/mm/yyyy') AS dt_publicacao,
           comissao_membros.numcgm,
           comissao_membros.cod_tipo_membro,
           comissao_membros.cod_norma,
           comissao_membros.cod_comissao,
           comissao_membros.cargo,
           comissao_membros.natureza_cargo
        from licitacao.comissao_membros
        join sw_cgm
            on ( comissao_membros.numcgm = sw_cgm.numcgm )
        join licitacao.tipo_membro
            on ( comissao_membros.cod_tipo_membro = tipo_membro.cod_tipo_membro )
        join normas.norma
            on (comissao_membros.cod_norma = norma.cod_norma)
        where comissao_membros.cod_comissao = $codComissao
        and not  comissao_membros.cod_comissao::varchar|| comissao_membros.numcgm::varchar || comissao_membros.cod_norma::varchar in
                      ( select cod_comissao::varchar ||   numcgm::varchar || cod_norma::varchar
                        from licitacao.membro_excluido
                        where membro_excluido.cod_comissao = $codComissao)";

        $query = $this->_em->getConnection()->prepare($stSql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
}
