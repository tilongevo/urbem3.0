<?php

namespace Urbem\CoreBundle\Repository\Administracao;

use Doctrine\ORM;

class ModuloRepository extends ORM\EntityRepository
{
    public function getAllModulos()
    {
        $sql = "SELECT g.nom_gestao, m.cod_modulo, m.nom_modulo, u.username, recuperadescricaoorgao(U.cod_orgao, now()::date) as nom_setor
                FROM administracao.modulo m INNER JOIN administracao.usuario u ON (m.cod_responsavel = u.numcgm)
                join administracao.gestao g on (g.cod_gestao = m.cod_gestao)
                ORDER by g.nom_gestao, m.nom_modulo asc";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }
}
