<?php

namespace Urbem\CoreBundle\Repository\Administracao;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class VariavelRepository extends AbstractRepository
{
    /**
     * Retorna o próximo cod_variavel no banco
     * @param  integer $codModulo
     * @param  integer $codBiblioteca
     * @param  integer $codFuncao
     * @return integer
     */
    public function getNexCodVariavel($codModulo, $codBiblioteca, $codFuncao)
    {
        return $this->nextVal(
            'cod_variavel',
            array(
                'cod_modulo' => $codModulo,
                'cod_biblioteca' => $codBiblioteca,
                'cod_funcao' => $codFuncao
            )
        );
    }
}
