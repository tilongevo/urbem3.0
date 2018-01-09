<?php

namespace Urbem\CoreBundle\Repository\Arrecadacao;

use Urbem\CoreBundle\Entity\Arrecadacao\CarneDevolucao;
use Urbem\CoreBundle\Repository\AbstractRepository;

class CarneDevolucaoRepository extends AbstractRepository
{

    /**
     * @param CarneDevolucao $carneDevolucao
     * @return array
     */
    public function getConvenio(CarneDevolucao $carneDevolucao)
    {
        $sql =
            'select
                ac.cod_convenio,
                cgm.nom_cgm,
                cgm.numcgm,
                ac.numeracao
                from
                arrecadacao.carne as ac
                INNER JOIN
                arrecadacao.parcela as ap
                ON
                ac.cod_parcela = ap.cod_parcela
                INNER JOIN
                arrecadacao.lancamento as al
                ON
                ap.cod_lancamento = al.cod_lancamento
                INNER JOIN
                arrecadacao.lancamento_calculo AS alc
                ON
                alc.cod_lancamento = al.cod_lancamento
                INNER JOIN
                arrecadacao.calculo_cgm AS acc
                ON
                acc.cod_calculo = alc.cod_calculo
                INNER JOIN
                sw_cgm as cgm
                ON
                acc.numcgm = cgm.numcgm
                where ac.numeracao =:numeracao';


        $query = $this->_em->getConnection()->prepare($sql);

        $query->bindValue(':numeracao', $carneDevolucao->getNumeracao(), \PDO::PARAM_INT);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);
    }
}
