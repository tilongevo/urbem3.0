<?php

namespace Urbem\CoreBundle\Repository;

use Doctrine\ORM;

/**
 * Class AbstractRepository
 * @package Urbem\CoreBundle\Repository
 */
abstract class AbstractRepository extends ORM\EntityRepository
{
    /**
     * Captura o ultimo valor de um campo, para uso em entidades com chaves
     * compostas.
     *
     * @param  string $campo  Nome do campo
     * @param  array  $params Lista de where para a query
     * @return integer
     */
    public function nextVal($campo, array $params = array())
    {
        $tabela = $this->_class->table['schema']
            . "."
            . $this->_class->table['name'];

        $sql = "
        SELECT
            COALESCE (
                MAX (
                    t.{$campo} ),
                0 ) AS codigo
        FROM
            {$tabela} t
        WHERE 1=1
        ";

        foreach ($params as $field => $value) {
            $sql .= " AND t.{$field} = :{$field}";
        }
        
        $query = $this->_em->getConnection()->prepare($sql);

        foreach ($params as $field => &$value) {
            if (is_string($value)) {
                $query->bindParam(":" . $field, $value, \PDO::PARAM_STR);
            } else {
                $query->bindParam(":" . $field, $value, \PDO::PARAM_INT);
            }
        }
        $query->execute();
        $res = $query->fetch(\PDO::FETCH_OBJ);

        return (int) $res->codigo + 1;
    }

    /**
     * @param array $params
     * @return bool
     */
    protected function isUnique(array $params)
    {
        $tabela = $this->_class->table['schema']
            . "."
            . $this->_class->table['name'];

        $sql = "
        SELECT COUNT(0) total
        FROM
            {$tabela} t
        WHERE 1=1
        ";

        foreach ($params as $field => $value) {
            $sql .= " AND t.{$field} = :{$field}";
        }

        $query = $this->_em->getConnection()->prepare($sql);

        foreach ($params as $field => $value) {
            $query->bindParam($field, $value);
        }

        $query->execute();

        $res = $query->fetch(\PDO::FETCH_OBJ);

        return (int) $res->total > 0 ? true : false;
    }
}
