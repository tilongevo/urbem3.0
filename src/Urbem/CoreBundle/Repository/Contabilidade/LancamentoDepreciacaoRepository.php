<?php

namespace Urbem\CoreBundle\Repository\Contabilidade;

use Doctrine\ORM;

class LancamentoDepreciacaoRepository extends ORM\EntityRepository
{

    public function executaLancamentoDepreciacao(
        $exercicio,
        $competencia,
        $codEntidade,
        $codHistorico,
        $tipo,
        $complemento,
        $estorno
    ) {
        $sql = "SELECT contabilidade.fn_insere_lancamentos_depreciacao(:exercicio,
                                                                       :competencia,
                                                                       :codEntidade,
                                                                       :codHistorico,
                                                                       :tipo,
                                                                       :complemento,
                                                                       :estorno); ";
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue("exercicio", $exercicio, \PDO::PARAM_STR);
        $query->bindValue("competencia", $competencia, \PDO::PARAM_STR);
        $query->bindValue("codEntidade", $codEntidade, \PDO::PARAM_STR);
        $query->bindValue("codHistorico", $codHistorico, \PDO::PARAM_STR);
        $query->bindValue("tipo", $tipo, \PDO::PARAM_STR);
        $query->bindValue("complemento", $complemento, \PDO::PARAM_STR);
        $query->bindValue("estorno", $estorno, \PDO::PARAM_STR);
        $query->execute();
        try {
            $query->execute();
        } catch (\Exception $e) {
            throw new \Exception($query->errorInfo()[2]);
        }

        return $query->fetch(\PDO::FETCH_OBJ);
    }
}
