<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Urbem\CoreBundle\Repository\AbstractRepository;

/**
 * Class AssentamentoGeradoContratoServidorRepository
 * @package Urbem\CoreBundle\Repository\Pessoal
 */
class AssentamentoGeradoContratoServidorRepository extends AbstractRepository
{
    /**
     * @param $codContrato
     * @return int
     */
    public function getNextCodAssentamentoGerado($codContrato)
    {
        return $this->nextVal(
            'cod_assentamento_gerado',
            [
                'cod_contrato' => $codContrato
            ]
        );
    }

    /**
     * @param $codContrato
     * @param $codAssentamento
     * @return bool
     */
    public function registrarEventoPorAssentamento($codContrato, $codAssentamento)
    {
        $sql = "SELECT registrarEventoPorAssentamento ($codContrato, $codAssentamento ,'excluir','') as retorno ";

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_OBJ);

        return $result->retorno;
    }
}
