<?php

namespace Urbem\CoreBundle\Repository\Patrimonio;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Patrimonio\EspecieAtributo;

class EspecieAtributoRepository extends ORM\EntityRepository
{
    public function salvar(EspecieAtributo $especieAtributo)
    {
        $sql = "
            INSERT INTO 
                patrimonio.especie_atributo
                (cod_atributo, cod_especie, cod_modulo, cod_cadastro, ativo)
            VALUES
                (
                    " . $especieAtributo->getCodAtributo() . ","
                    . $especieAtributo->getCodEspecie() . ","
                    . $especieAtributo->getCodModulo() . ","
                    . $especieAtributo->getCodCadastro() . ",
                    true
                );
        ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(\PDO::FETCH_OBJ);
        return $result;
    }
}
