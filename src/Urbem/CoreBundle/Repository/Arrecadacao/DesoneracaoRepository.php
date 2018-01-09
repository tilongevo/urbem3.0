<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use Urbem\CoreBundle\Repository\AbstractRepository;

class DesoneracaoRepository extends AbstractRepository
{
    /**
     * @param $params
     * @return int
     */
    public function concederDesoneracaoGrupo($params)
    {
        $sql = sprintf(
            "SELECT * FROM fn_conceder_desoneracao_grupo(%d, '%s', '%s');",
            $params['codDesoneracao'],
            $params['nomeFuncao'],
            $params['tipoVinculo']
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
