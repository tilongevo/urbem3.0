<?php

namespace Urbem\CoreBundle\Repository\Patrimonio;

use Doctrine\ORM;

class ContratoAditivoRepository extends ORM\EntityRepository
{
    public function recuperaRelacionamentoVinculado($stTabelaVinculo = false, $stCampoVinculo = false, $filtroVinculo = false)
    {
        $sql = "
           SELECT
            CGM.numcgm
            ,CGM.nom_cgm ";

        if (!$stTabelaVinculo) {
            $sql .= "
                ,PF.cpf
                ,PJ.cnpj
                CASE WHEN PF.cpf IS NOT NULL THEN PF.cpf ELSE PJ.cnpj END AS documento";
        }
        $sql .= " FROM
            SW_CGM AS CGM";

        if ($stTabelaVinculo) {
            $sql .= " LEFT JOIN
                sw_cgm_pessoa_fisica AS PF
            ON
                CGM.numcgm = PF.numcgm
            LEFT JOIN
                sw_cgm_pessoa_juridica AS PJ
            ON
                CGM.numcgm = PJ.numcgm";
        }
        $sql .= " WHERE
            CGM.numcgm <> 0 ";
        if ($stTabelaVinculo) {
            $sql .= " and exists ( select 1 from  $stTabelaVinculo  as tabela_vinculo
                                 where tabela_vinculo.$stCampoVinculo = CGM.numcgm " . $filtroVinculo . ") ";
        }
        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }
}
