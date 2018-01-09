<?php

namespace Urbem\CoreBundle\Repository;

use Doctrine\ORM;

class SwAssuntoAtributoRepository extends ORM\EntityRepository
{
    public function getAtributosPorCodAssuntoECodClassificacao($codAssunto, $codClassificacao)
    {
        $sql = sprintf(
            "SELECT saa.id, saa.cod_atributo, sap.nom_atributo, sap.tipo, sap.valor_padrao, sap.obrigatorio, saav.valor
             FROM sw_assunto_atributo saa JOIN sw_atributo_protocolo sap ON saa.cod_atributo = sap.cod_atributo
             LEFT JOIN sw_assunto_atributo_valor saav ON (saav.cod_atributo = saa.cod_atributo)
             WHERE saa.cod_assunto = %d AND saa.cod_classificacao = %d",
            $codAssunto,
            $codClassificacao
        );

        try {
            $query = $this->_em->getConnection()->prepare($sql);
            $query->execute();
            $return = $query->fetchAll();
        } catch (\Exception $e) {
            $return = null;
        }

        return $return;
    }
}
