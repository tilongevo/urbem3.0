<?php

namespace Urbem\CoreBundle\Repository\Folhapagamento;

use Urbem\CoreBundle\Repository\AbstractRepository;

class UltimoRegistroEventoComplementarRepository extends AbstractRepository
{
    /**
     * @param null $filtro
     * @param null $ordem
     * @return array
     */
    public function montaRecuperaRelacionamento($filtro = null, $ordem = null)
    {
        $sql = " SELECT ultimo_registro_evento_complementar.*                                                                        
        FROM folhapagamento.ultimo_registro_evento_complementar                                                           
          , folhapagamento.registro_evento_complementar                                                                  
        WHERE ultimo_registro_evento_complementar.cod_registro = registro_evento_complementar.cod_registro                 
          AND ultimo_registro_evento_complementar.cod_evento = registro_evento_complementar.cod_evento                     
          AND ultimo_registro_evento_complementar.cod_configuracao = registro_evento_complementar.cod_configuracao         
          AND ultimo_registro_evento_complementar.timestamp = registro_evento_complementar.timestamp";

        if ($filtro) {
            $sql .= $filtro;
        }

        if ($ordem) {
            $sql .= $ordem;
        }

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
