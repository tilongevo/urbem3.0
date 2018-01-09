<?php

namespace Urbem\CoreBundle\Repository\Patrimonio\Frota;

use Doctrine\ORM;

/**
 * Class ItemRepository
 * @package Urbem\CoreBundle\Repository\Patrimonio\Frota
 */
class ItemRepository extends ORM\EntityRepository
{
    /**
     * @param $id
     * @return array
     */
    public function getCombustivelItem($id)
    {
        $sql = "
            SELECT mv.cod_item
            FROM   frota.combustivel m
                inner join frota.combustivel_item mv
                    ON mv.cod_combustivel = m.cod_combustivel
            WHERE m.cod_combustivel = $id;
        ";

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @param $id
     * @param $codItem
     */
    public function removeCombustivelItem($id, $codItem = null)
    {
        if (!$codItem) {
            $codCombustivel = $this->getCombustivelItem($id);
        } else {
            $codCombustivel[0]['cod_item'] = $codItem;
        }

        foreach ($codCombustivel as $combustivel) {
            $sql = "DELETE FROM frota.combustivel_item WHERE cod_combustivel = $id AND cod_item = ".
                $combustivel['cod_item'].";";

            $query = $this->_em->getConnection()->prepare($sql);

            $query->execute();
        }
    }

    /**
     * @param $info
     * @return array
     */
    public function getClassificacaoCatalogo($info)
    {
        $sql = sprintf(
            "SELECT cod_estrutural
            FROM almoxarifado.catalogo_classificacao
            WHERE cod_catalogo = '%s'
            ORDER BY cod_estrutural",
            $info['cod_catalogo']
        );

        $query = $this->_em->getConnection()->prepare($sql);

        $query->execute();
        return $query->fetchAll();
    }

    /**
     * @param $info
     * @return bool
     */
    public function processaItens($info)
    {
        try {
            $sql = "
                SELECT 
                    catalogo_item.cod_item     
                FROM  
                    almoxarifado.catalogo_item                                                 
                    INNER JOIN  
                        almoxarifado.catalogo_classificacao
                        ON catalogo_classificacao.cod_classificacao = catalogo_item.cod_classificacao
                        AND catalogo_classificacao.cod_catalogo = catalogo_item.cod_catalogo
                WHERE 1=1                                                                         
                    AND catalogo_classificacao.cod_estrutural = '".$info['codEstrutural']['nivelDinamico']."'
                    AND catalogo_classificacao.cod_catalogo = ".$info['codCatalogo']."
            ";

            $query = $this->_em->getConnection()->prepare($sql);
            $query->execute();
            $catalogo_itens = $query->fetchAll();

            foreach ($catalogo_itens as $item) {
                $sql = "
                    SELECT 
                        cod_item ,
                        cod_tipo 
                    FROM 
                        frota.item 
                    WHERE 
                        cod_item = ".$item['cod_item']."
                ";
                $query = $this->_em->getConnection()->prepare($sql);
                $query->execute();
                $verify_item = $query->fetchAll();

                if (count($verify_item) == 0) {
                    $sql_item = "
                        INSERT INTO 
                            frota.item (
                                cod_item,
                                cod_tipo
                            )
                        VALUES (
                            ".$item['cod_item'].",
                            ".$info['codTipo']."
                        )
                    ";
                    $query = $this->_em->getConnection()->prepare($sql_item);
                    $query->execute();

                    if ($info['codTipo'] == 1) {
                        $sql_combustivel_item = "
                            INSERT INTO 
                                frota.combustivel_item (
                                    cod_item,
                                    cod_combustivel
                                )
                            VALUES (
                                ".$item['cod_item'].",
                                ".$info['codCombustivel']."
                            )
                        ";
                        $query = $this->_em->getConnection()->prepare($sql_combustivel_item);
                        $query->execute();
                    }
                }
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
