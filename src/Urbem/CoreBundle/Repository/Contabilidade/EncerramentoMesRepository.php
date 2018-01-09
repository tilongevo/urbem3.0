<?php

namespace Urbem\CoreBundle\Repository\Contabilidade;

use Doctrine\ORM;

class EncerramentoMesRepository extends ORM\EntityRepository
{
    public function getUltimoMesEncerrado($exercicio, $situacao = "F")
    {
        $sql = "
            SELECT mes
                , exercicio
                , situacao
            FROM contabilidade.encerramento_mes
            WHERE TIMESTAMP = (
                    SELECT MAX(TIMESTAMP)
                    FROM contabilidade.encerramento_mes em
                    WHERE em.mes = encerramento_mes.mes
                        AND em.exercicio = encerramento_mes.exercicio
                    )
                AND exercicio = :exercicio
                AND situacao = :situacao
            ORDER BY mes DESC LIMIT 1
        ";
        
        $query = $this->_em->getConnection()->prepare($sql);
        $query->bindValue('exercicio', $exercicio);
        $query->bindValue('situacao', $situacao);
        $query->execute();
        $result = $query->fetch(\PDO::FETCH_OBJ);
        return $result;
    }

    public function getMesesEncerrados($params)
    {
        $sql = sprintf("
            SELECT * FROM contabilidade.encerramento_mes f
            WHERE f.situacao = 'F' 
            AND f.exercicio = '%s'
            AND f.mes NOT IN (
                SELECT mes FROM contabilidade.encerramento_mes a 
                WHERE a.situacao = 'A' AND a.exercicio = '%s')",
            $params['exercicio'],
            $params['exercicio']
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getMesesReabertos($params)
    {
        $sql = sprintf("
            SELECT mes, count(0) FROM contabilidade.encerramento_mes f
            WHERE f.exercicio = '%s'
            group by mes",
            $params['exercicio']
        );

        $query = $this->_em->getConnection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}
