<?php

namespace Urbem\CoreBundle\Repository\Imobiliario;

use Doctrine\ORM;

class LoteRepository extends ORM\EntityRepository
{
    /**
     * @param $codLote
     * @return array
     */
    public function recuperaProprietariosLote($codLote)
    {
        $sql = "select p.numcgm from imobiliario.fn_recupera_lote_proprietarios(:codLote) as p(numcgm integer)";
        
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('codLote', $codLote, \PDO::PARAM_INT);

        $query->execute();
        return $query->fetchAll(\PDO::FETCH_COLUMN, 0);
    }
    
    /**
     * @param $codLote
     * @return array
     */
   public function getLoteByCod($codLote)
   {
        $sql = "
            SELECT
                coalesce( ilr.cod_atributo, ilu.cod_atributo) AS cod_atr_din_lote,
                coalesce( ilr.valor, ilu.valor) AS valor_atr_din_lote
            FROM  imobiliario.lote AS il
            LEFT JOIN (
                SELECT ial.*
                FROM imobiliario.lote_rural AS ilr
                INNER JOIN imobiliario.atributo_lote_rural_valor AS ial
                ON ilr.cod_lote = ial.cod_lote) AS ilr
            ON ilr.cod_lote = il.cod_lote
            LEFT JOIN (
                SELECT ial.* FROM imobiliario.lote_urbano AS ilr
                INNER JOIN imobiliario.atributo_lote_urbano_valor AS ial
                ON ilr.cod_lote = ial.cod_lote) AS ilu
            ON ilu.cod_lote = il.cod_lote
            WHERE  il.cod_lote = 
        ". $codLote;

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
