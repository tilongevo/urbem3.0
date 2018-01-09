<?php

namespace Urbem\CoreBundle\Repository\Pessoal;

use Doctrine\ORM;
use Urbem\CoreBundle\Repository\AbstractRepository;

class AssentamentoAfastamentoTemporarioRepository extends AbstractRepository
{
    /**
     * O sistema legado sempre criava valores novos para os relacionamentos
     *
     * - PessoalAssentamentoMovSefipSaida
     * - PessoalAssentamentoRaisAfastamento
     * - PessoalAssentamentoAfastamentoTemporarioDuracao
     *
     * porem, com a estrurtura nova, One To One não da pra criar histórico desses
     * registros, então essa função exclui os filhos de AssentamentoAfastamentoTemporario
     * para criar novos com valores referenciando o pai.
     *
     * @param  array $params
     * @return boolean
     */
    public function removeChild($params)
    {
        $conn = $this->_em->getConnection();
        
        $sql = "
        DELETE
        FROM
            pessoal.assentamento_mov_sefip_saida
        WHERE
            cod_assentamento = :cod_assentamento;
        ";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        
        $sql = "
        DELETE
        FROM
            pessoal.assentamento_rais_afastamento
        WHERE
            cod_assentamento = :cod_assentamento;
        ";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        
        $sql = "
        DELETE
        FROM
            pessoal.assentamento_afastamento_temporario_duracao
        WHERE
            cod_assentamento = :cod_assentamento;
        ";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
    }
}
