<?php

namespace Urbem\CoreBundle\Repository\Administracao;

use Doctrine\ORM;
use Symfony\Component\Config\Definition\Exception\Exception;
use Urbem\CoreBundle\Repository\AbstractRepository;

class FuncaoRepository extends AbstractRepository
{
    public function executaFuncaoPL($sql)
    {
        try {
            $sql = sprintf($sql);
            $query = $this->_em->getConnection()->prepare($sql);
            return $query->execute();
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function getNextCodFuncao()
    {
        return $this->nextVal(
            'cod_funcao'
        );
    }
}
